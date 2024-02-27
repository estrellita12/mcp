<?php
namespace application\API_F\controllers;

class billingController extends Controller 
{
    function init(){ 
        $this->temp();
        $this->memberBilling = new \application\models\MemberBillingModel();
        $this->order = new \application\models\OrderModel();
        $this->goods = new \application\models\GoodsModel();
        $this->col = "*";
        $this->addUrl = 'https://api.tosspayments.com/v1/billing/authorizations/card';
        $this->payUrl = 'https://api.tosspayments.com/v1/billing';
        $this->baseUrl = 'https://api.tosspayments.com/v1/payments/';
        $this->confirmUrl = 'https://api.tosspayments.com/v1/payments/confirm';
        if(empty($this->accessInfo)) {
            echo json_encode(null);
            exit;
        }
    }

    function get(){
        $id = $this->param['ident'];
        echo json_encode($this->memberBilling->get( $this->memberBilling->getCol(array('sInfo','id')), array("mbbi_idx"=>$id) ));
    }

    function getList(){
        $id = $this->accessInfo['index'];
        $_REQUEST['memberId'] = $id;
        echo json_encode($this->memberBilling->getList($this->memberBilling->getCol(array('id', 'sInfo'))));
    }

    function certificate(){
        $res = 'success';
        try{
            //---- INIT ----//
            $paymentKey = $_REQUEST['paymentKey'];
            $orderId = $_REQUEST['orderId'];
            $amount = $_REQUEST['amount'];

            //---- API REQUEST ----//
            $data = [
                'paymentKey' => $paymentKey,
                'orderId' => $orderId,
                'amount' => $amount,
            ];
            $credential = base64_encode($this->shopTossSecret . ':');
    
            $curlHandle = curl_init("{$this->confirmUrl}");
            curl_setopt_array($curlHandle, [
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . $credential,
                    'Content-Type: application/json'
                ],
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);
    
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            $responseJson = json_decode($response,true);
            
            if($httpCode != 200){
                $res = 'networkErr';
            }else{
            //---- ORDER CONTROL ----//
                //state update
                $orderData = $this->order->get($this->order->getCol(array("odId", "goodsId", "qty")), array("od_no"=>$orderId));
                $odId = $orderData['odId']; //real ID
                $goodsId = $orderData['goodsId'];
                $orderQty = $orderData['qty'];
                $accessId = $this->accessInfo['index'];
                $statusUpdateArr = array(
                    //'message' => '고객 카드 결제',
                    'requestDate' => $responseJson['requestedAt'],
                    'approvedDate' => $responseJson['approvedAt'],
                    'pgMid' => $this->shopTossMid,
                    //'pgMid' => $responseJson['mId'],
                    'pgCompany' => 'toss',
                    'paymentId' => $responseJson['paymentKey'],
                    'escrowYn' => $responseJson['useEscrow']=="true"?"y":"n",  
                    'responseMsg' => $response
                );

                $orderNoModel = new \application\models\OrderNoModel();                         
                $statusUpdateRes = $orderNoModel->changeState2($orderId, $statusUpdateArr);     

                if($statusUpdateRes != '000'){
                    $res = 'updateErr';

                    /* send TOSS request for cancel */
                    $tossModel = new \application\models\TossPayments();
                    $cancelResult = $tossModel->cancel($orderId, $responseJson['paymentKey'], $this->shopTossSecret, $amount, '주문 실패');
                } 
            }
        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);        
    }

    function pay(){
        $res = 'success';
        $updateRes = null;
        try{
            //---- INIT ----//
            $id = $this->param['ident'];
            $bKey = $this->memberBilling->get( $this->memberBilling->getCol(array('bKey')), array("mbbi_idx"=>$id) );
            $orderNum = $_REQUEST['orderNum'];
            $orderName = $_REQUEST['orderName'];
            $amount = $_REQUEST['amount'];
            $customerId = $this->accessInfo['index'];
            $customerName = $_REQUEST['customerName'];

            //---- API REQUEST ----//
            $data = [
                'orderId' => $orderNum,
                'orderName' => $orderName,
                'amount' => $amount,
                'customerKey' => $customerId,
                'customerName' => $customerName
            ];
            $credential = base64_encode($this->shopTossSecret . ':');
    
            $curlHandle = curl_init("{$this->payUrl}/{$bKey['bKey']}");
            curl_setopt_array($curlHandle, [
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . $credential,
                    'Content-Type: application/json'
                ],
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);
    
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            $responseJson = json_decode($response,true);
            
            if($httpCode != 200){
                $res = 'netwrokErr';
            }else{
            //---- ORDER CONTROL ----//
                //state update
                $_REQUEST = array();
                $_REQUEST['no'] = $orderNum;
                $orderData = $this->order->getList($this->order->getCol(array("odId", "goodsId", "qty")));
                $odId = $orderData[0]['odId']; //real ID
                $goodsId = $orderData[0]['goodsId'];
                $orderQty = $orderData[0]['qty'];
                $accessId = $this->accessInfo['index'];
                $statusUpdateArr = array(
                    //'message' => '고객 간편 결제',
                    'requestDate' => $responseJson['requestedAt'],
                    'approvedDate' => $responseJson['approvedAt'],
                    'pgMid' => $this->shopTossMid,
                    //'pgMid' => $responseJson['mId'],
                    'pgCompany' => 'toss',
                    'paymentId' => $responseJson['paymentKey'],
                    'escrowYn' => $responseJson['useEscrow']=="true"?"y":"n",  
                    'responseMsg' => $response
                );
                $orderNoModel = new \application\models\OrderNoModel();                         
                $statusUpdateRes = $orderNoModel->changeState2($orderNum, $statusUpdateArr);    
                if($statusUpdateRes != '000'){
                    $res = 'updateErr';
                    /* send TOSS request for cancel */
                    $tossModel = new \application\models\TossPayments();
                    $cancelResult = $tossModel->cancel($orderNum, $responseJson['paymentKey'], $this->shopTossSecret, $amount, '주문 실패');
                } 
            }
        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);
    }    

    function add(){
        //---- API REQUEST ----//
        $res = 'success';
        try{
            $arr = $this->postData['params'];

            $data = [
                'cardNumber' => $arr['cardNum'],
                'cardExpirationMonth' => $arr['month'], 
                'cardExpirationYear' => $arr['year'],
                'cardPassword' => $arr['password'],
                'customerIdentityNumber' => $arr['idNum'],
                'customerKey' => $this->accessInfo['index']  
            ];
            $credential = base64_encode($this->shopTossSecret . ':');
    
            $curlHandle = curl_init($this->addUrl);
            curl_setopt_array($curlHandle, [
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . $credential,
                    'Content-Type: application/json'
                ],
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);
    
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            $responseJson = json_decode($response,true);
            
            if($httpCode != 200) $res = 'netwrokErr';
            if(!empty($responseJson['code']) && $responseJson['code'] == "INVALID_CARD_EXPIRATION") $res = 'invalid';
        }catch(Exception $e){
            $res = 'systemErr';
        }

        //---- BILLING KEY SAVE ----//
        if($res == 'success' && !empty($responseJson)){
            $addInfo = array();
            $addInfo['memberId'] = $responseJson['customerKey'];
            $addInfo['bKey'] = $responseJson['billingKey'];

            $cardFrontNum = substr($responseJson['card']['number'], 0, 4);
            $cardCompany = $responseJson['card']['company'];
            $addInfo['sInfo'] = "[{$cardCompany}] {$cardFrontNum}-****-****-****";
            
            $addRes = $this->memberBilling->add($addInfo);
            if($addRes != '000') $res = 'saveErr';
        }
        echo json_encode($res);
    }    
    
    function remove(){
        $id = $this->param['ident'];
        echo json_encode($this->memberBilling->remove($id));
    }    

    function cancel(){
        $res = 'success';

        try{
            //---- INIT ----//
            //data check
            if(empty($_REQUEST['orderNum']) || empty($_REQUEST['reason'])){
                echo json_encode('access invalid');
                exit;                
            }

            $orderNum = $_REQUEST['orderNum'];
            $cancelReason = $_REQUEST['reason'];

            $_REQUEST['no'] = $orderNum;
            $orderData = $this->order->getList($this->order->getCol(array("odId","paymentsId", "amount", "userId", "state")));

            //user check
            if($this->accessInfo['index'] != $orderData[0]['userId']){
                echo json_encode('access blocked');
                exit;
            }

            //state check
            if($orderData[0]['state'] != 2 && $orderData[0]['state'] != 11 && $orderData[0]['state'] != 1){ 
                echo json_encode('proccess blocked');
                exit;
            }

            $paymentsId = $orderData[0]['paymentsId'];
            $amount = $orderData[0]['amount'];
            
            //----API REQUEST & STATE CHANGE ----// if use changeState function
            $odId = $orderData[0]['odId'];
            $accessId = $this->accessInfo['index'];
            $updateArr = array(
                //'message' => '고객 취소',
                'cancelReason' => $cancelReason,
            );

            $updateRes = $this->order->changeState42($odId, $updateArr);
            if($updateRes != '000' && $updateRes != '001' && $updateRes != '112' && $updateRes != '113' && $updateRes != '114') $res = "updateErr"; //112, 113, 114 (결제취소 에러 통과처리 (Cs로 사후처리))
        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);
    }

    function cancelReq(){
        $res = 'success';

        try{
            //---- INIT ----//
            //data check
            if(empty($_REQUEST['orderNum']) || empty($_REQUEST['reason'])){
                echo json_encode('access invalid');
                exit;                
            }

            $orderNum = $_REQUEST['orderNum'];
            $cancelReason = $_REQUEST['reason'];

            $_REQUEST['no'] = $orderNum;
            $orderData = $this->order->getList($this->order->getCol(array("odId","paymentsId", "amount", "userId", "state")));

            //user check
            if($this->accessInfo['index'] != $orderData[0]['userId']){
                echo json_encode('access blocked');
                exit;
            }

            //state check
            if($orderData[0]['state'] != 3){ 
                echo json_encode('proccess blocked');
                exit;
            }
            
            //----API REQUEST & STATE CHANGE ----// if use changeState function
            $odId = $orderData[0]['odId'];
            $updateArr = array(
                'cancelReason' => $cancelReason,
            );
            $updateRes = $this->order->changeState41($odId, $updateArr);
            if($updateRes != '000' && $updateRes != '001') $res = "updateErr";
        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);
    }    
}
