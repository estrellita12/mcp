<?php
namespace application\Front\controllers;

use \Exception;

class tossPaymentsController extends Controller{
    private $secretKey;

    public function init(){
        $this->tossModel = new \application\models\TossPayments();
        $partnerModel = new \application\models\PartnerModel();
        $row = $partnerModel->get("pt_own_pg_yn,shop_pg_key2",array("pt_id"=>$this->shopId));
        if( $row['pt_own_pg_yn'] == "N" || $row['pt_own_pg_yn'] == "n" ){
            $defaultModel = new \application\models\DefaultModel();
            $row = $defaultModel->get("shop_pg_key2",array("pt_id"=>"admin"));
        }
        $this->secretKey = $row['shop_pg_key2'];
    }

    public function success(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            $paymentKey = $request['paymentKey'];
            $orderNo = $request['orderId'];
            $amount = $request['amount'];
            //$secretKey = 'test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R';
            $url = 'https://api.tosspayments.com/v1/payments/confirm';
            $data = ["paymentKey"=>$paymentKey,"amount" => $amount, "orderId" => $orderNo];
            $credential = base64_encode($this->secretKey . ':');
            $curlHandle = curl_init($url);
            curl_setopt_array($curlHandle, [
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => [
                    'Authorization: Basic ' . $credential,
                    'Content-Type: application/json'
                ],
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            if( $httpCode != 200 ) $this->result($httpCode,$response);
            $responseJson = json_decode($response,true);
            if($responseJson['status']!="DONE") $this->result("111");

            $orderModel = new \application\models\OrderNoModel();
            $arr = array();
            $arr['requestDate'] = $responseJson['requestedAt'];
            $arr['approvedDate'] = $responseJson['approvedAt'];
            $arr['pgMid'] = $responseJson['mId'];
            $arr['pgCompany'] = 'toss';
            $arr['paymentId'] = $responseJson['paymentKey'];
            $arr['escrowYn'] = $responseJson['useEscrow']=="true"?"y":"n";
            $arr['responseMsg'] = $response;
            $result = $orderModel->changeState("2",$orderNo,$arr);
            $this->response_json("000");
        }catch(Exception $e){
            $this->result("111");
        }
    }

    function fail(){
        $message = $_GET['message'];
        $code = $_GET['code'];
        $responseJson = json_decode($_GET);
        echo $responseJson;
    }
    /*
    function cancel(){
        try{
            $odNo = $this->param['ident'];
            $cancelReason = $_POST['cancelReason'];
            $payments = '';
            $_REQUEST['odNo'] = $odNo;
            $_REQUEST['odId'] = $_POST['orderList'];
            $amount = 0;
            foreach($this->order->getList() as $row){
                // 배송비 관련 기타 처리
                // 묶음 배송일 경우 배송비 부분에 대한 처리를 다른 주문건으로 넘기는 등..
                if(empty($paymentsId)) $paymentsId = $row['od_payment_id'];
                $amount += $row['od_amount'];
                $arr = array();
                $arr['cancelReason'] = $cancelReason;
                $arr['cancelAmount'] = $row['od_amount'];
                $res = $this->order->changeState42($row['od_id'],$arr);
            }
            $response = $this->toss->cancel($odNo, $paymentsId, $amount,$cancelReason);
            $value['od_response_msg'] = $response;
            $res = $this->order->setNo($value,$odNo,"value");
            $arr = array("result"=>$res,"data"=>$response);
            echo json_encode($arr);
        }catch(Exception $e){
            $arr = array("result"=>"500","error"=>$e);
            echo json_encode($arr);
        }
    }
     */

}
