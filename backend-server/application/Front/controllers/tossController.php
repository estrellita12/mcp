<?php
namespace application\Front\controllers;

use \Exception;

class tossController extends Controller{
    private $secretKey;

    public function init(){
        try{
            $this->tossModel = new \application\models\TossPayments();
            $partnerModel = new \application\models\PartnerModel();
            $row = $partnerModel->get("pt_own_pg_yn,shop_pg_key2",array("pt_id"=>$this->shopId));
            if( $row['pt_own_pg_yn'] == "N" || $row['pt_own_pg_yn'] == "n" ){
                $defaultModel = new \application\models\DefaultModel();
                $row = $defaultModel->get("shop_pg_key2",array("pt_id"=>"admin"));
            }
            $this->secretKey = $row['shop_pg_key2'];
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function success(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($request['od_payment_id']) ) $this->result("002");
            if( empty($request['od_amount']) ) $this->result("002");
            if( empty($this->param['ident']) ) $this->result("002");

            $orderModel = new \application\models\OrderNoModel();
            $row = $orderModel->get("sum(od_amount) as od_amount",array("od_no"=>$this->param['ident']));
            if( $row['od_amount'] != $request['od_amount'] ) $this->result("111");

            $url = 'https://api.tosspayments.com/v1/payments/confirm';
            $data = ["paymentKey"=>$request['od_payment_id'],"amount" =>$request['od_amount'], "orderId" =>$this->param['ident']];
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
            $this->result("009",$e->getMessage());
        }
    }

}
