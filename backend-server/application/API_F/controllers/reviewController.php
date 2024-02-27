<?php
namespace application\API_F\controllers;

use \Exception;

class reviewController extends Controller{

    function init(){
        $this->temp();
        $this->review = new \application\models\GoodsReviewModel();
        $this->order = new \application\models\OrderModel();
        $this->member = new \application\models\MemberModel();
        $this->goods = new \application\models\GoodsModel();
        $this->goods->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
    }

    function getList(){
        $res = 'success';
        try{
            $_REQUEST['shop'] = $this->shopId;

            //self id
            $selfId = !empty($this->accessInfo['index']) ? $this->accessInfo['index'] : null;

            //option term
            if(!empty($_REQUEST['recent'])){
                $dateCnt = $_REQUEST['recent'];
                $_REQUEST['reviewTerm'] = 'regDate';
                $_REQUEST['beg'] = date("Y-m-d H:i:s", strtotime("-{$dateCnt} days"));
            }

            //review
            if(!empty($_REQUEST['type']) && $_REQUEST['type'] == 'self'){ //self Chk
                if(!$selfId){
                    echo json_encode(array('res' => 'SystemErr'));
                    exit;
                }else{
                    $_REQUEST['userId'] = $selfId;
                }
            }
            $reviewData = $this->review->getList($this->review->getCol());

            //reset
            if(!empty($_REQUEST['rpp'])) unset($_REQUEST['rpp']);
            if(!empty($_REQUEST['page'])) unset($_REQUEST['page']);

            //goods
            if(!empty($_REQUEST['goodsId'])){ //one Goods
                //avg & cnt
                $reviewInfo = $this->review->getGoodsInfo($_REQUEST['goodsId'], $this->shopId);
                $avg = !empty($reviewInfo['avg']) ? round($reviewInfo['avg'], 1) : 0;
                $cnt = $reviewInfo['cnt'];                                

                foreach($reviewData as &$rv1){
                    //member
                    $memberData = $this->member->get( $this->member->getCol(array("name","img")), array("mb_id"=>$rv1['userId']));
                    $rv1['memberInfo'] = $memberData;

                    //reviewImg
                    $rv1['imgArr'] = array($rv1['reviewImg'], $rv1['reviewImg2'], $rv1['reviewImg3']);                
                }         

            }else{ //all Goods
                $avg = null;
                $cnt = null;                
                if(!empty($_REQUEST['seller'])){ //one seller all goods
                    $reviewInfo = $this->review->getSellerInfo($_REQUEST['seller'], $this->shopId);
                    $avg = !empty($reviewInfo['avg']) ? round($reviewInfo['avg'], 1) : 0;
                    $cnt = $reviewInfo['cnt'];                                
                }

                foreach($reviewData as &$rv1){
                    //each avg & cnt
                    $eachReview = $this->review->getGoodsInfo($rv1['goodsId'], $this->shopId);
                    $rv1['eachAvg'] = !empty($eachReview['avg']) ? round($eachReview['avg'], 1) : 0;
                    $rv1['eachCnt'] = $eachReview['cnt'];           
                    
                    //each goods
                    $colArr = array(
                        "goodsId","goodsName","state","onlyShopYn","onlyShop","buyUseGrade","brand","seller","isopen",
                        "goodsPrice","consumerPrice","stockQty","salesBeginDate","salesEndDate","simgType","timg1"
                    );
                    $rv1['goods'] = $this->goods->get( $this->goods->getCol($colArr), array("gs_id"=>$rv1['goodsId']) );
        
                    //order Cnt
                    $rv1['buyCnt'] = $this->order->getStateCnt($rv1['goodsId'], 14);

                    //member
                    $memberData = $this->member->get( $this->member->getCol(array("name","img")), array("mb_id"=>$rv1['userId']) );
                    $rv1['memberInfo'] = $memberData;

                    //reviewImg
                    $rv1['imgArr'] = array($rv1['reviewImg'], $rv1['reviewImg2'], $rv1['reviewImg3']);                

                    //orderData
                    $rv1['order'] = $this->order->get( $this->order->getCol(array("orderDate")), array("od_id"=>$rv1['odId']) );
                }
            }

        }catch(Exception $e){
            $res = 'systemError';
        }    
        echo json_encode(array('res' => $res, 'data' => $reviewData, 'avg' => $avg, 'cnt' => $cnt));
    }

    function add(){
        $res = 'success';
        try{
            if(empty($this->accessInfo)) {
                echo json_encode(null);
                exit;
            }

            $selfId = $this->accessInfo['index'];
            $postParams = $this->postData;
            $postInfo = $postParams['params'];
            $postInfo['userId'] = $selfId;
            $postInfo['partner'] = $this->shopId;

            // to check count of repurchase
            $orderCnt = $this->order->getStateCnt($postInfo['goodsId'], 14, $selfId);
            $postInfo['reviewCnt'] = $orderCnt;

            $reviewRes = $this->review->add($postInfo);
            if($reviewRes != '000') $res = 'query Err';

            $orderArr = array();
            $orderArr['id'] = $postInfo['odId'];
            $orderArr['review'] = 'y';
            $updateOrder = $this->order->set($orderArr,$postInfo['odId']);            
            if($updateOrder != '000') $res = 'query Err';
        }catch(Exception $e){
            $res = 'systemError';
        }
        echo json_encode($res);
    }

    function set(){
        $res = 'success';
        try{
            //data
            $putParams = $this->putData['params'];
            $id = $this->param['ident'];

            //selfChk
            if(empty($this->accessInfo)) {
                echo json_encode(null);
                exit;
            }
            $selfId = $this->accessInfo['index'];
            if($selfId == $putParams['userChk']){
                //update
                $updateReview = $this->review->set($putParams,$id);            
                if($updateReview != '000' && $updateReview != '001') $res = 'updateErr';
            }else{
                $res = 'indetifyErr';
            }
        }catch(Exception $e){
            $res = 'systemError';
        }
        echo json_encode($res);
    }
    
    function remove(){
        $res = 'success';
        try{
            //sessionChk
            if(empty($this->accessInfo)) {
                echo json_encode('sessionErr');
                exit;
            }

            //memberId
            $selfId = $this->accessInfo['index'];

            //goodsId
            $goodsId = $_REQUEST['targetGoods'];

            //idetify
            $id = $this->param['ident'];
            $reviewInfo = $this->review->get('mb_id, od_id', array("gs_rv_id"=>$id) );
            if($reviewInfo['mb_id'] != $selfId){
                $res = 'identifyErr';
            }else{
                //delete
                $deleteRes = $this->review->remove($id);
                if($deleteRes != '000'){
                    $res = 'delete fail';
                }else{
                    //order Update
                    $orderId = $reviewInfo['od_id'];
                    $updateArr = array( 'od_review_yn' => 'n' );
                    $updateRes = $this->order->set($updateArr,$orderId,"value");
                    if($updateRes != '000') $res = 'update fail';
                }
            }
        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);
    }    
}
