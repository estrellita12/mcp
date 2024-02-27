<?php
namespace application\API_F\controllers;

use \Exception;

class orderController extends Controller{

    function init(){
        $this->temp();
        $this->order = new \application\models\OrderModel();
        $this->orderNo = new \application\models\OrderNoModel(); // 2023-03-10
        $this->member = new \application\models\MemberModel();
        $this->teamOrder = new \application\models\OrderTeamModel();
    }

    function add(){
        $res = 'success';
        $orderNum = null;
        try{
            if(empty($this->accessInfo)) {
                echo json_encode(null);
                exit;
            }
            
            //init
            $selfId = $this->accessInfo['index'];
            $postParams = $this->postData;
            $postInfo = $postParams['params'];
            $orderInfo = $postInfo['order'];
            
            $teamId = $postInfo['teamId'];
            $count = $postInfo['count'];
            $goods = $orderInfo['goods'];
            $option = $orderInfo['option'];
            $addr = $postInfo['addr'];
            $amount = $postInfo['amount'];
            $paymentType = $postInfo['paymentType'];

            $point = (!empty($postInfo['point'])) ? $postInfo['point'] : null; 
            $pointIn = (!empty($postInfo['pointIn'])) ? $postInfo['pointIn'] : null; 
            $pointOut = (!empty($postInfo['pointOut'])) ? $postInfo['pointOut'] : null; 

            //table set
            $this->join = new \application\models\GoodsOptionJoinModel();
            $this->join->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
            $this->join->colArr['supplyPrice'] = "gs_opt_supply_price";
            $this->join->colArr['claimDeliveryCharge'] = "gs_claim_delivery_charge";
            $colArr = array(
                "simg1","timg1","goodsId","goodsCode","brand","seller","goodsName",
                "consumerPrice","goodsPrice","supplyPrice","claimDeliveryCharge",
                "deliveryType","deliveryCharge","deliveryFree","deliveryEachUse",
                "optionId","optionName","optionStockQty","addPrice"
            );
            
            //data set
            $postInfo['shop'] = $this->shopId;
            $postInfo['state'] = $paymentType == 'credit' ? "0" : "1";
            $postInfo['no'] = _ORDER_NO.mt_rand(100, 999);
            $postInfo['goodsId'] = $goods['goodsId'];
            $postInfo['optionId'] = $option['optionId'];
            $postInfo['qty'] = $count;
            $postInfo['teamId'] = $teamId;
            $postInfo['self'] = $selfId;

            $self = $this->member->get($this->member->getCol(), array("mb_id"=>$selfId));
            $postInfo['userId'] = $selfId;
            $postInfo['userName'] = $self['name'];
            $postInfo['userEmail'] = $self['email'];
            $postInfo['userCellphone'] = $self['cellphone'];        
            $postInfo['userAddr1'] = $addr['address1'];
            $postInfo['userAddr2'] = $addr['address2'];
            
            $postInfo['receiverName'] = $addr['recipient'];
            $postInfo['receiverCellphone'] = $addr['tel'];
            $postInfo['receiverDeliveryMsg'] = "수령방법 : {$addr['extraInfo']} / 현관비밀번호 : {$addr['password']}";

            $postInfo['receiverZip'] = $addr['postcode'];
            $postInfo['receiverAddr1'] = $addr['address1'];
            $postInfo['receiverAddr2'] = $addr['address2'];

            $postInfo['deliveryCharge'] = 0;
            $postInfo['goodsPrice'] = $count*((int)$goods['goodsPrice']+(int)$option['addPrice']);
            $postInfo['amount'] = $amount;
            $postInfo['point'] = $point; 
            $postInfo['pointIn'] = $pointIn; 
            $postInfo['pointOut'] = $pointOut; 

            $row = $this->join->getOption($option['optionId'], $this->join->getCol($colArr));
            $postInfo['supplyPrice'] = $count*(int)$row['supplyPrice'];
            $postInfo['seller'] = $row['seller'];
            $postInfo['paymethod'] = 'card';

            if($row['optionStockQty'] <= 0 ){
                //$this->result("104");
            }
            $postInfo['goodsJoinInfo'] = json_encode($row);

            //exec
            $this->orderNo->add($postInfo);
            $addRes = $this->order->add($postInfo);

            if($addRes != '000') $res = 'order made error';
            $orderNum = $postInfo['no'];
        }catch(Exception $e){
            $res = 'systemError';
        }
        echo json_encode(array('res' => $res, 'orderNum' => $orderNum));
    }

    function set(){ // refund code : 31, exchange code : 21
        $res = 'success';
        try{
            $putParams = $this->putData['params'];
            $orderNum = $putParams['orderNum'];
    
            //if use changeState function
            /* 2023-04-17 주석처리
            $_REQUEST['no'] = $orderNum; 
            $orderData = $this->order->getList($this->order->getCol(array("odId")));
            */

            //2023-04-17 od_id get 코드 수정
            $orderData = $this->order->get("od_id",array("od_no"=>$orderNum),true);          
            $odId = $orderData[0]['od_id'];

            $accessId = $this->accessInfo['index'];
            $updateArr = array();
            if(!empty($putParams['teamId']) && $putParams['teamId']=='reset'){
                $updateArr['od_team_id'] = 0;
                $updateRes = $this->order->set($updateArr,$odId,"value");
            } 
            if(!empty($putParams['orderStatus'])) {
                if(!empty($putParams['changeMessage'])) $updateArr['changeMessage'] = $putParams['changeMessage'];
                if(!empty($putParams['returnReason'])) $updateArr['returnReason'] = $putParams['returnReason'];
                $targetMethod = "changeState".$putParams['orderStatus'];
                $updateRes = $this->order->$targetMethod($odId, $updateArr);
            }
    
            /* if not use changeState function
            $updateArr = array();
            $updateArr['od_no'] = $orderNum;
            if(!empty($putParams['orderStatus'])) {
                $updateArr['od_stt'] = $putParams['orderStatus'];
                $updateArr['od_rcent_dt'] = _DATE_YMDHIS;
            }
            if(!empty($putParams['teamId']) && $putParams['teamId']=='reset') $updateArr['od_team_id'] = 0;
            if(!empty($putParams['changeMessage'])) $updateArr['od_change_msg'] = $putParams['changeMessage'];
            if(!empty($putParams['returnReason'])) $updateArr['od_return_reason'] = $putParams['returnReason'];
            
            $updateRes = $this->order->setNo($updateArr,$orderNum,"value");
            */
    
            if($updateRes != '000' && $updateRes != '001') $res = 'updateErr';
        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);
    }

    function get(){
        if(empty($this->accessInfo)) {
            echo json_encode(null);
            exit;
        }
        $memberId = $this->accessInfo['index'];

        $res = "success";
        $data = null;
        try{
            $colArr = array(
                "odId","odNo","state",
                "orderDate","invoiceDate","goodsInfo","goodsPrice","qty","amount","point","coupon","seller",
                "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
                "userId","userName","userCellphone","userEmail","paymethod",
                "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
            );
    
            $data = $this->order->get($this->order->getCol($colArr), array("od_id"=>$this->param['ident']));
            if(empty($data) || !is_array($data)){
                echo json_encode('query Error');
                exit;
            } 
            if($data['userId'] != $memberId){
                echo json_encode("access blocked");
                exit;
            } 
    
            if(!empty($data['goodsInfo'])) $data['goodsInfo'] = json_decode($data['goodsInfo']); 

        }catch(Exception $e){
            $res = 'systemError';
        }

        echo json_encode(array('res' => $res, 'data' => $data));
    }

    function getList(){
        if(empty($this->accessInfo)) {
            echo json_encode(null);
            exit;
        }

        $res = "success";
        try{
            //selfChk
            if(!empty($_REQUEST['self'])){
                $_REQUEST['srch'] = 'userId';
                $_REQUEST['kwd'] = $this->accessInfo['index'];
            } 

            //default column
            $colArr = array(
                "odId","odNo","state","seller",
                "orderDate","invoiceDate","goodsInfo","amount","qty","goodsPrice","point","coupon",
                "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo","teamId","review"
            );

            //selected column
            if(!empty($_REQUEST['colArr'])) $colArr = $_REQUEST['colArr'];

            //exec
            $row = $this->order->getList($this->order->getCol($colArr));
            if(!is_array($row)) $res = "select fail";

            //reset
            if(!empty($_REQUEST['col'])) unset($_REQUEST['col']);
            if(!empty($_REQUEST['rpp'])) unset($_REQUEST['rpp']);
            if(!empty($_REQUEST['page'])) unset($_REQUEST['page']);

            //extra work
            foreach($row as &$r){
                //goods data decoding
                if(!empty($r['goodsInfo'])) $r['goodsInfo'] = json_decode($r['goodsInfo']); 

                //extra info chk
                if(!empty($_REQUEST['extraInfo'])){
                    $extraInfo = array();
                    foreach($_REQUEST['extraInfo'] as &$i){
                        switch($i){
                            case 'team' : 
                                //team
                                $_REQUEST['teamId'] = $r['teamId'];
                                $r['teamData'] = $this->teamOrder->getList($this->teamOrder->getCol());
                                $r['teamData'][0]['teamTimeLimit'] = strtotime($r['teamData'][0]['teamTime'])-strtotime(_DATE_YMDHIS);

                                //order
                                $_REQUEST['srch'] = null;
                                $_REQUEST['kwd'] = null;
                                $_REQUEST['teamId'] = $r['teamId'];
                                $orderData = $this->order->getList($this->order->getCol(array("userId", "odNo", "point")));

                                //member
                                $memberArr = array();
                                foreach($orderData as $od){
                                    $memberData = $this->member->get($this->member->getCol(array("name","img")), array("mb_id"=>$od['userId']));
                                    array_push($memberArr,$memberData);
                                }             
                                $r['memberData'] = $memberArr;                   
                                $r['orderData'] = $orderData;                   
                        }
                    }
                }
            } 
            $arr = array("result"=>$res,"data"=>$row);
        }catch(Exception $e){
            $res = "system Err";
            $arr = array("result"=>$res,"data"=>$e);
        }

        echo json_encode($arr);
    }
}
