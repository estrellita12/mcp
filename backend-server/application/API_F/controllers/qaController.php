<?php
namespace application\API_F\controllers;

use \Exception;

class qaController extends Controller{

    function init(){
        $this->temp();
        $this->qa = new \application\models\GoodsQaModel();
        $this->goods = new \application\models\GoodsModel();
    }

    function add(){
        $res = 'success';
        try{
            $selfId = !empty($this->accessInfo) ? $this->accessInfo['index'] : 'nonMember';

            $postParams = $this->postData;
            $postInfo = $postParams['params'];

            $goodsResult = $this->goods->get( $this->goods->getCol(array('seller', 'goodsName')), array("gs_id"=>$postInfo['goodsId']));

            $postInfo['seller'] = $goodsResult['seller'];
            $postInfo['userId'] = $selfId;
            $postInfo['type'] = 1;
            //$postInfo['title'] = $this->shopName.'/'.$goodsResult['goodsName'].'/ 상품문의 건';
            $postInfo['title'] = "";
            $postInfo['shop'] = $this->shopId;

            $qaResult = $this->qa->add($postInfo);
            if($qaResult != '000') $res = 'query Err';
        }catch(Exception $e){
            $res = 'systemError';
        }
        echo json_encode($res);
    }

    function getList(){
        $res = 'success';
        try{
            $_REQUEST['shop'] = $this->shopId;

            //qa
            $data = $this->qa->getList();

            //goods
            foreach($data as &$q){
                $q['goodsInfo'] = $this->goods->get( $this->goods->getCol(array('timg1', 'goodsName', 'goodsId')), array("gs_id"=>$q['gs_id']));
            }
            
        }catch(Exception $e){
            $res = 'systemError';
        }    
        echo json_encode(array('res' => $res, 'data' => $data));
    }


    /*
    function get(){
        $res = 'success';
        try{
            $arr = array();
            $id = $this->param['ident'];

            //seller 
            $sellerResult = $this->seller->get($id, 'sl_name');
            $arr['name'] = $sellerResult['sl_name'];

            //review
            $reviewResult = $this->review->getSellerInfo($id);
            $reviewResult['avg'] = round($reviewResult['avg'], 1);
            $arr['review'] = $reviewResult;
            
            //goods
            if(!empty($_REQUEST['exceptionGoods'])) $_REQUEST['notGoodsId'] = $_REQUEST['exceptionGoods'];
            $_REQUEST['seller'] = $id;
            $_REQUEST['state'] = "2";
            $_REQUEST['isopen'] = "1";
            $_REQUEST['useYn'] = 'y';
            $arr['goodsCnt'] = $this->goods->getCnt();
            $goodsResult = $this->goods->getList($this->goods->getCol(array('goodsId', 'goodsName', 'timg1', 'goodsPrice', 'consumerPrice')));
            $arr['goods'] = $goodsResult;

            //order
            if(!empty($_REQUEST['state'])) unset($_REQUEST['state']);
            if(!empty($_REQUEST['isopen'])) unset($_REQUEST['isopen']);
            if(!empty($_REQUEST['useYn'])) unset($_REQUEST['useYn']);
            if(!empty($_REQUEST['rpp'])) unset($_REQUEST['rpp']);
            if(!empty($_REQUEST['page'])) unset($_REQUEST['page']);
            if(!empty($_REQUEST['notGoodsId'])) unset($_REQUEST['notGoodsId']);
            $arr['orderCnt'] = $this->order->getCnt();
        }catch(Exception $e){
            $res='systemErr';
        }
        echo json_encode(array('res' => $res, 'data' => $arr));
    }

    */
}
