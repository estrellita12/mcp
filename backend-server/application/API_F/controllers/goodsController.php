<?php
namespace application\API_F\controllers;

class goodsController extends Controller
{
    var $goods;

    function init(){
        $this->temp();
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $this->wish = new \application\models\GoodsWishModel();
        $this->goods->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
        $this->review = new \application\models\GoodsReviewModel();
        $this->seller = new \application\models\SellerModel();
    }

    function get(){
        //goods
        $id = $this->param['ident'];

        $_REQUEST['goodsId'] = $id;
        $_REQUEST['state'] = "2";
        $_REQUEST['isopen'] = "1";
        $_REQUEST['useYn'] = 'y';

        $colArr = array(
            "goodsId","goodsCode","goodsName","ctg","state","onlyShopYn","onlyShop","buyUseGrade","brand","seller","isopen",
            "goodsPrice","consumerPrice","stockQty","salesBeginDate","salesEndDate",
            "deliveryType","deliveryCharge","deliveryFree","deliveryEachUse","deliveryRegion","deliveryRegionMsg",
            "simgType","simg1","simg2","simg3","simg4","simg5","timg1",
            "optSubject","detail","orderMaxQty"
        );
        $goods = $this->goods->get( $this->goods->getCol($colArr), array("gs_id"=>$id) );

        if(!empty($_REQUEST['customerView'])) $this->goods->viewCnt($id); // count up views

        //seller
        $sellerSelect = '
            sl_delivery_information, 
            sl_company_owner, 
            sl_company_name, 
            sl_company_owner, 
            sl_company_tel, 
            sl_company_email, 
            sl_company_addr, 
            sl_company_tolsin_no, 
            sl_company_saupja_no
        ';
        $seller = $this->seller->get( $sellerSelect, array("sl_id"=>$goods['seller']) );

        //options
        $options = $this->option->getList($this->option->getCol());

        //wishLists
        $wish = [];
        if(!empty($this->accessInfo)){
            $_REQUEST['memberId'] = $this->accessInfo['index'];
            $wish = $this->wish->getList($this->wish->getCol());
        }

        $arr = array("goods"=>$goods,"options"=>$options, "wish" => count($wish), 'seller' => $seller);
        echo json_encode($arr);
    }

    function getList(){
        $colArr = array(
            "goodsId","goodsCode","goodsName","ctg","brand","seller",
            "isopen","goodsPrice","consumerPrice","deliveryType","simgType",
            "simg1","simg2","timg1","updateDate","viewCnt","orderQty"
        );

        if(!empty($this->shopUseCtg)) $_REQUEST['useCtg'] = implode(",",$this->shopUseCtg);
        if(!empty($shopId = $this->shopId)) $_REQUEST['shop'] = $shopId;
        $_REQUEST['state'] = "2";
        $_REQUEST['isopen'] = "1";
        $_REQUEST['useYn'] = 'y';

        if(!empty($_REQUEST['srch']) && $_REQUEST['srch'] == 'id' && !empty($_REQUEST['kwd']) && is_array($_REQUEST['kwd'])){
            $_REQUEST['kwd'] = implode(",",$_REQUEST['kwd']);
        };
        $row = $this->goods->getList($this->goods->getCol($colArr));

        //review
        foreach($row as &$g){
            $reviewInfo = $this->review->getGoodsInfo($g['goodsId'], $this->shopId);
            $avg = !empty($reviewInfo['avg']) ? round($reviewInfo['avg'], 1) : 0;
            $g['avgScore'] = $avg;
            $g['cnt'] = $reviewInfo['cnt'];
        }

        echo json_encode($row);
    }

    function wishList(){
        try{
            if(empty($this->accessInfo['index'])){
                echo json_encode([]);        
                exit;
            }
            $_REQUEST['memberId'] = $this->accessInfo['index'];
            $memberWish = $this->wish->getList($this->wish->getCol());
            $result = array();
            foreach($memberWish as $val){
                if(!empty($this->shopUseCtg)) {
                    $_REQUEST['useCtg'] = implode(",",$this->shopUseCtg);
                }                
                $_REQUEST['state'] = "2";
                $_REQUEST['isopen'] = "1";
                $_REQUEST['useYn'] = "y";
                if(!empty($shopId = $this->shopId)) $_REQUEST['shop'] = $shopId;
                $goodsData = $this->goods->get( $this->goods->getCol(), array("gs_id"=>$val['goodsId']) );

                //review
                $reviewInfo = $this->review->getGoodsInfo($val['goodsId'], $this->shopId);
                $avg = !empty($reviewInfo['avg']) ? round($reviewInfo['avg'], 1) : 0;
                $goodsData['avgScore'] = $avg;
                $goodsData['cnt'] = $reviewInfo['cnt'];

                array_push($result,$goodsData);
            }
        }catch(Exception $e){
            $result = $e;
        }
        echo json_encode($result);
    }

    function wishChk(){
        try{
            if(empty($this->accessInfo['index'])){
                echo json_encode([]);        
                exit;
            }
            $memberId = $this->accessInfo['index'];
            $goodsId = $this->param['ident'];
            $_REQUEST['memberId'] = $memberId;
            $_REQUEST['goodsId'] = $goodsId;
            $isChk = $this->wish->getList($this->wish->getCol());
            if(count($isChk)){
                $this->wish->remove($isChk[0]['id']);
            }else{
                $arr = Array('goodsId' => $goodsId, 'memberId' => $memberId);
                $this->wish->add($arr);
            }
            $result = count($this->wish->getList($this->wish->getCol()));
        }catch(Exception $e){
            $result = $e;
        }
        echo json_encode($result);
    }

    function getArrayOrdered(){
        try{
            $result = array();
            $dataArr = $_REQUEST['dataArr'];
            foreach($dataArr as $val){
                if(!empty($this->shopUseCtg)) {
                    $_REQUEST['useCtg'] = implode(",",$this->shopUseCtg);
                }                
                $_REQUEST['state'] = "2";
                $_REQUEST['isopen'] = "1";
                $_REQUEST['useYn'] = 'y';
                $goods = $this->goods->get( $this->goods->getCol(), array("gs_id"=>$val) );

                //review
                if(!empty($goods)){
                    $reviewInfo = $this->review->getGoodsInfo($val, $this->shopId);
                    $avg = !empty($reviewInfo['avg']) ? round($reviewInfo['avg'], 1) : 0;
                    $goods['avgScore'] = $avg;
                    $goods['cnt'] = $reviewInfo['cnt'];
                }
                if($goods) array_push($result,$goods);
            }            
        }catch(Exception $e){
            $result = $e;
        }
        echo json_encode($result);
    }

    function optionStockChk(){
        $id = $this->param['ident'];
        $option = $this->option->get( $this->option->getCol(array("optionStockQty")), array("gs_opt_id"=>$id) );        
        echo json_encode((int)$option['optionStockQty'] > 0);
    }
}
?>
