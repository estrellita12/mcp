<?php
namespace application\API\controllers;

use \Exception;

class paymentController extends Controller{

    function init(){
        $this->temp();
        //$this->tokenCheck();
        $this->order = new \application\models\OrderModel();
    }

    function add(){
        $res = "000";
        try{
            parse_str(file_get_contents("php://input"), $_PUT);
            $this->goods = new \application\models\GoodsOptionJoinModel();
            $this->goods->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
            $this->goods->colArr['supplyPrice'] = "gs_supply_price";
            $this->goods->colArr['claimDeliveryCharge'] = "gs_claim_delivery_charge";
            $goodsColArr = array("simg1","goodsId","goodsCode","brand","seller","goodsName","optionName","optionId","goodsPrice","supplyPrice","claimDeliveryCharge","optionStockQty");
            $this->cart = new \application\models\CartModel();

            $_POST = $_PUT;
            $_POST['shop'] =  $this->shopId;
            $_POST['state'] = "0";
            $_POST['no'] = _ORDER_NO.mt_rand(100, 999);
            $goodsArr = json_decode($_PUT['goodsArr'],true);
            foreach($goodsArr as $gs){
                //if(!empty($gs['cartId'])) $res = $this->cart->set(array("odNo"=>$_POST['no']), $gs['cartId']);
                $_POST['goodsId'] = $gs['goodsId'];
                $_POST['optionId'] = $gs['optionId'];
                $_POST['qty'] = $gs['qty'];
                $_POST['deliveryCharge'] = $gs['deliveryCharge'];
                $_POST['goodsPrice'] = $gs['goodsPrice']+$gs['goodsOptionAddPrice'];
                $_POST['amount'] = $gs['amount'];

                $row = $this->goods->get($gs['optionId'],$this->goods->getCol($goodsColArr));
                $_POST['supplyPrice'] = $row['supplyPrice'];
                $_POST['claimDeliveryCharge'] = $row['claimDeliveryCharge'];
                $_POST['seller'] = $row['seller'];

                if($row['optionStockQty'] <= 0 ){
                    $res = "301";  // 품절
                    $arr = array("result"=>$res,"data"=>$row);
                    echo json_encode($arr);
                    return;
                }
                $_POST['goodsInfo'] = json_encode($row);
                $res = $this->order->add($_POST);
            } 
            $arr = array("result"=>$res,"odNo"=>$_POST['no']);
            echo json_encode($arr);
        }catch(Exception $e){
            $arr = array("result"=>"500","error"=>$e,"data"=>$_POST);
            echo json_encode($arr);
        }
    }

    function success(){
        $paymentKey = $_POST['paymentKey'];
        $orderNo = $_POST['orderId'];
        $amount = $_POST['amount'];

        $order = new \application\models\OrderModel();
        $_REQUEST['odNo'] = $orderNo;
        $row = $order->getSum("sum(amount) as amount");
        if($row['amount'] != $amount) $this->result("001","결제금액이 올바르지 않습니다.");

        $secretKey = 'test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R';
        $url = 'https://api.tosspayments.com/v1/payments/' . $paymentKey;
        $data = ['orderId' => $orderNo, 'amount' => $amount];
        $credential = base64_encode($secretKey . ':');

        $curlHandle = curl_init($url);
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
        $result = $httpCode == 200 ? "000":"500";
        $responseJson = json_decode($response,true);
        if($responseJson['status']!="DONE") return;

            $goods = new \application\models\GoodsModel();
            $option = new \application\models\GoodsOptionModel();
            $cart = new \application\models\CartModel();
            $arr = array();

            $res = $option->order($gs['goodsOptionId']);

            $arr['od_no'] = $orderNo;
            $arr['od_stt'] = "2";
            $arr['od_pay_request_dt'] = $responseJson['requestedAt'];
            $arr['od_pay_approved_dt'] = $responseJson['approvedAt'];
            $arr['od_pg_mid'] = $responseJson['mId'];
            $arr['od_pg_company'] = 'toss';
            $arr['od_payment_id'] = $responseJson['paymentKey'];
            $arr['od_escrow_yn'] = $responseJson['useEscrow']=="true"?"y":"n";
            $arr['od_response_msg'] = $response;
            $result = $order->setNo($arr,$orderNo,"value");

            $_REQUEST['no'] = $orderNo;
            foreach($order->getList() as $row){
                $res = $option->order($row['gs_opt_id']);
                $res = $goods->order($row['gs_id']);
            }    
            $res=$cart->order($orderNo);

            $arr = array("result"=>$res,"data"=>$responseJson);
            echo json_encode($arr);

    }

    function fail(){
        $message = $_GET['message'];
        $code = $_GET['code'];

        $responseJson = json_decode($_GET);
        echo $responseJson;

    }

}
