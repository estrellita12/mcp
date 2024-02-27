<?php
namespace application\models;

use \Exception;

class TossPayments{ 
    public function __construct( ){

    }
    /*
    public function success($odNo, $paymentKey, $secretKey, $amount ){
        try{
            $url = 'https://api.tosspayments.com/v1/payments/confirm';
            $data = ["paymentKey"=>$paymentKey,"amount" => $amount, "orderId" => $odNo];
            $credential = base64_encode($secretKey . ':');
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
            if( $httpCode != 200 ) {
                $this->result($httpCode,$response);
                return "111";
            }
            $responseJson = json_decode($response,true);
            if($responseJson['status']!="DONE") return "111";

            $arr = array();
            $arr['requestDate'] = $responseJson['requestedAt'];
            $arr['approvedDate'] = $responseJson['approvedAt'];
            $arr['pgMid'] = $responseJson['mId'];
            $arr['pgCompany'] = 'toss';
            $arr['paymentId'] = $responseJson['paymentKey'];
            $arr['escrowYn'] = $responseJson['useEscrow']=="true"?"y":"n";
            $arr['responseMsg'] = $response;
            return $arr;
        }catch(Exception $e){

        }
    }
    */
    public function cancel($odNo,$paymentsId, $secretKey,$amount,$reason, $refundableAmount=''){
        try{
            if(empty($reason)) $reason='고객이 취소를 원함';
            $credential = base64_encode($secretKey . ':');
            $url = "https://api.tosspayments.com/v1/payments/".$paymentsId."/cancel";
            $data = ["cancelReason"=>$reason, "cancelAmount"=>$amount, "refundableAmount"=>$refundableAmount ];
            if( !empty($refundableAmount)){
                $data['refundableAmount'] = $refundableAmount;
            }
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Basic " . $credential,
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS =>json_encode($data),
            ]);
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                debug_log( static::class,"111",array("isSuccess"=>false,"response"=>$err) );
                return "111";
            } else {
                if($httpCode == 200){
                    //return array("isSuccess"=>true,"response"=>$response);
                    return "000";
                }else{
                    debug_log( static::class,"111",array("isSuccess"=>false,"data"=>$data,"url"=>$url,"secretKey"=>$secretKey,"response"=>$httpCode." : ".$response) );
                    return "111";
                }
            }
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }
}
