<?php
namespace application\API_F\controllers;

use \Exception;

class sellerController extends Controller{

    function init(){
        $this->temp();
        $this->review = new \application\models\GoodsReviewModel();
        $this->order = new \application\models\OrderModel();
        $this->member = new \application\models\MemberModel();
        $this->goods = new \application\models\GoodsModel();
        $this->seller = new \application\models\SellerModel();
        $this->goods->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
    }

    function get(){
        $res = 'success';
        try{
            $arr = array();
            $id = $this->param['ident'];

            //seller 
            $sellerResult = $this->seller->get( 'sl_name', array("sl_id"=>$id));
            $arr['name'] = $sellerResult['sl_name'];

            //review
            $reviewResult = $this->review->getSellerInfo($id, $this->shopId);
            $reviewResult['avg'] = round($reviewResult['avg'], 1);
            $arr['review'] = $reviewResult;
            
            //goods
            if(!empty($_REQUEST['exceptionGoods'])) $_REQUEST['notGoodsId'] = $_REQUEST['exceptionGoods'];
            $_REQUEST['seller'] = $id;
            $_REQUEST['state'] = "2";
            $_REQUEST['isopen'] = "1";
            $_REQUEST['useYn'] = 'y';
            $_REQUEST['geQty'] = 1;  
            $_REQUEST['col'] = 'regDate';  
            $_REQUEST['colby'] = 'desc';  

            $goodsResult = $this->goods->getList($this->goods->getCol(array('goodsId', 'goodsName', 'timg1', 'goodsPrice', 'consumerPrice')));
            $arr['goods'] = $goodsResult;

            //goods Cnt
            unset($_REQUEST['notGoodsId']);
            $arr['goodsCnt'] = $this->goods->getCnt();

            //order
            if(!empty($_REQUEST['state'])) unset($_REQUEST['state']);
            if(!empty($_REQUEST['isopen'])) unset($_REQUEST['isopen']);
            if(!empty($_REQUEST['useYn'])) unset($_REQUEST['useYn']);
            if(!empty($_REQUEST['rpp'])) unset($_REQUEST['rpp']);
            if(!empty($_REQUEST['page'])) unset($_REQUEST['page']);
            if(!empty($_REQUEST['notGoodsId'])) unset($_REQUEST['notGoodsId']);
            if(!empty($_REQUEST['col'])) unset($_REQUEST['col']);
            if(!empty($_REQUEST['colby'])) unset($_REQUEST['colby']);

            $arr['orderCnt'] = $this->order->getCnt();
        }catch(Exception $e){
            $res='systemErr';
        }
        echo json_encode(array('res' => $res, 'data' => $arr));
    }
}
