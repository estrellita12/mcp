<?php
namespace application\Front\controllers;

use \Exception;

class orderNoController extends Controller{
    public $col;
    public $search;
    public $sql;

    public function init(){
        try{
            $this->orderNoModel = new \application\models\OrderNoModel();
            $this->orderModel = new \application\models\OrderModel();
            $this->col = array(
                "od_no"=>"od_no",
                "mb_id"=>"mb_id",
                "od_dt"=>"od_dt",
                //"od_num"=>"sum(if(od_stt<=29,1,0))",
                //"od_cancel_num"=>"sum(if(od_stt>=30,1,0))",
                "od_amount"=>"od_amount",
                //"od_cancel_amount"=>"sum(od_cancel_amount)",
                //"od_return_amount"=>"sum(od_return_amount)",
                "od_goods_price"=>"od_goods_price",
                "od_use_point"=>"od_use_point",
                "od_use_coupon"=>"od_use_coupon",
                "od_delivery_charge"=>"od_delivery_charge",
                //"od_delivery_charge_dosan"=>"sum(od_delivery_charge_dosan)",
                "od_paymethod"=>"od_paymethod",
                "orderer_name"=>"orderer_name",
                "orderer_cellphone"=>"orderer_cellphone",
                "orderer_email"=>"orderer_email",
                "orderer_zip"=>"orderer_zip",
                "orderer_addr1"=>"orderer_addr1",
                "orderer_addr2"=>"orderer_addr2",
                "orderer_addr3"=>"orderer_addr3",
                "orderer_addr_jibeon"=>"orderer_addr_jibeon",
                "receiver_name"=>"receiver_name",
                "receiver_cellphone"=>"receiver_cellphone",
                "receiver_email"=>"receiver_email",
                "receiver_zip"=>"receiver_zip",
                "receiver_addr1"=>"receiver_addr1",
                "receiver_addr2"=>"receiver_addr2",
                "receiver_addr3"=>"receiver_addr3",
                "receiver_addr_jibeon"=>"receiver_addr_jibeon",
                "receiver_delivery_msg"=>"receiver_delivery_msg",
                "od_passwd"=>"od_passwd",
                "od_vbank"=>"od_vbank",
                "od_vbank_deposit"=>"od_vbank_deposit",
            );
        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function getSearch($request = array()){
        try{
            $sql = "";
            $search = array();
            $search['od_stt_then_ge'] = "1";
            $search['pt_id'] = $this->shopId;

            $required = false;
            if( !empty($request['mb_id']) ){
                $search['mb_id'] = $request['mb_id'];
                $required = true;
            }

            if( !empty($request['orderer_cellphone']) ){
                $search['orderer_cellphone'] = $request['orderer_cellphone'];
                $required = true;
            }
            if( !$required ) $this->result("002");

            if( !empty($request['od_no']) )    $search['od_no'] = trim($request['od_no']);
            if( !empty($request['od_stt']) )    $search['od_stt_in_all'] = trim($request['od_stt']);
            if( !empty($request['od_dt_beg']) ) $search['od_dt_then_ge'] = trim($request['od_dt_beg'])." 00:00:00";
            if( !empty($request['od_dt_end']) ) $search['od_dt_then_le'] = trim($request['od_dt_end'])." 23:59:59";
            if( !empty($request['rpp']) ) $search['rpp'] = trim($request['rpp']);
            if( !empty($request['page']) ) $search['page'] = trim($request['page']);
            $search['col'] = "od_dt";
            $search['colby'] = "desc";

            $this->search = $search;
            $this->sql = $sql;
        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function getList(){
        try{
            $request = array();
            if( !empty($this->request['get']) ) $request = $this->request['get'];
            if(!empty($this->userId)) $request['mb_id'] =  $this->userId;
            $this->getSearch($request);

            $col = get_column_as($this->col,array(),false);
            $row = $this->orderNoModel->get($col,$this->search,true,$this->sql);
            if(empty($row)) $this->result("001");
            if(!is_array($row)) $this->result($row);

            $this->response_json("000",array("list"=>$row));

        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function get(){
        try{
            $request = array();
            if( !empty($this->request['get']) ) $request = $this->request['get'];
            if( empty($this->param['ident']) ) $this->result("002");
            $request['od_no'] =  $this->param['ident'];
            if(!empty($this->userId)) $request['mb_id'] =  $this->userId;

            $this->getSearch($request);
            $col = get_column_as($this->col,array(),false);
            $row = $this->orderNoModel->get($col,$this->search,false,$this->sql);
            if(empty($row)) $this->result("001");
            if(!is_array($row)) $this->result($row);

            $this->response_json("000",array("data"=>$row));

        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function add(){
        $orderModel = new \application\models\OrderNoModel();
        try{
            $request = array();
            if( !empty($this->request['put']) ) $request = $this->request['put'];
            if( empty($request['gs_li']) ) $this->result("002");

            //debug_log( static::class,"000",array("request"=>$request) );

            $cartModel = new \application\models\CartModel();
            $orderNo = _ORDER_NO.mt_rand(100, 999);
            $success = 0;
            $value = array();
            $value['shop'] = $this->shopId;
            $value['state'] = 0;
            $value['no'] = $orderNo;
            if( !empty($request['mb_id']) )             $value['userId'] = $request['mb_id'];
            if( !empty($this->userId) )                 $value['userId'] = $this->userId;
            if( !empty($request['orderer_name']) )      $value['userName'] = $request['orderer_name'];
            if( !empty($request['orderer_email']) )     $value['userEmail'] = $request['orderer_email'];
            if( !empty($request['orderer_cellphone']) ) $value['userCellphone'] = only_number($request['orderer_cellphone']);
            if( !empty($request['orderer_zip']) )       $value['userZip'] = $request['orderer_zip'];
            if( !empty($request['orderer_addr1']) )     $value['userAddr1'] = $request['orderer_addr1'];
            if( !empty($request['orderer_addr2']) )     $value['userAddr2'] = $request['orderer_addr2'];
            if( !empty($request['orderer_addr3']) )     $value['userAddr3'] = $request['orderer_addr3'];
            if( !empty($request['receiver_name']) )     $value['receiverName'] = $request['receiver_name'];
            if( !empty($request['receiver_email']) )    $value['receiverEmail'] = $request['receiver_email'];
            if( !empty($request['receiver_cellphone']) )    $value['receiverCellphone'] = only_number($request['receiver_cellphone']);
            if( !empty($request['receiver_zip']) )      $value['receiverZip'] = $request['receiver_zip'];
            if( !empty($request['receiver_addr1']) )    $value['receiverAddr1'] = $request['receiver_addr1'];
            if( !empty($request['receiver_addr2']) )    $value['receiverAddr2'] = $request['receiver_addr2'];
            if( !empty($request['receiver_addr3']) )    $value['receiverAddr3'] = $request['receiver_addr3'];
            if( !empty($request['receiver_delivery_msg']) ) $value['receiverDeliveryMsg'] = $request['receiver_delivery_msg'];
            if( !empty($request['od_paymethod']) )      $value['paymethod'] = $request['od_paymethod'];
            if( !empty($request['od_passwd']) )         $value['passwd'] = $request['od_passwd'];
            if( !empty($request['od_use_point']) )      $value['point'] = $request['od_use_point'];
            if( !empty($request['od_use_coupon']) )     $value['coupon'] = $request['od_use_coupon'];
            if( !empty($request['od_amount']) )         $value['amount'] = $request['od_amount'];
            if( !empty($request['od_goods_price']) )    $value['goodsPrice'] = $request['od_goods_price'];
            if( !empty($request['od_delivery_charge']) )    $value['deliveryCharge'] = $request['od_delivery_charge'];
            $res = $this->orderNoModel->add($value);
            if( $res != "000") $this->result($res);
            unset($value['point']);
            unset($value['coupon']);
            unset($value['amount']);
            unset($value['goodsPrice']);
            unset($value['deliveryCharge']);
            $saveValue = $value;
            foreach($request['gs_li'] as $od){
                $value = $saveValue;
                if( !empty($od['gs_id']))       $value['goodsId'] = $od['gs_id'];
                if( !empty($od['gs_opt_id']))   $value['optionId'] = $od['gs_opt_id'];
                if( !empty($od['sl_id']))       $value['seller'] = $od['sl_id'];
                if( !empty($od['od_qty']))      $value['qty'] = $od['od_qty'];
                if( !empty($od['od_delivery_type']))    $value['deliveryType'] = $od['od_delivery_type'];
                if( !empty($od['od_delivery_charge']))  $value['deliveryCharge'] = $od['od_delivery_charge'];
                if( !empty($od['od_delivery_charge_dosan']))   $value['deliveryChargeDosan'] = $od['od_delivery_charge_dosan'];
                if( !empty($od['od_goods_price']))      $value['goodsPrice'] = $od['od_goods_price'];
                if( !empty($od['od_use_point']))        $value['point'] = $od['od_use_point'];
                if( !empty($od['od_use_point_in']))        $value['pointIn'] = $od['od_use_point_in'];
                if( !empty($od['od_use_point_out']))        $value['pointOut'] = $od['od_use_point_out'];
                if( !empty($od['od_use_coupon']))       $value['coupon'] = $od['od_use_coupon'];
                if( !empty($od['od_amount']))           $value['amount'] = $od['od_amount'];
                $res = $this->orderModel->add($value);
                if( $res != "000") $this->result($res);
                $success = $success+1;
                if( !empty($od['cart_id']) ){
                    $cartModel->set(array("odNo"=>$orderNo), $od['cart_id']);
                }
            }
            $col = get_column_as($this->col,array(),false);
            $row = $this->orderNoModel->get($col, array("od_no"=>$orderNo));
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);
            $this->response_json("000",array("od_no"=>$orderNo,"data"=>$row));

        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function cancel(){
        try{
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");

            $arr = array();
            if( !empty($request['od_cancel_reason']) ) $arr['cancelReason'] = $request['od_cancel_reason'];
            $res = $model->changeState("42",$this->param['ident'],$arr);
            $this->response_json($res);

        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function pay(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");
            if( empty($request['shop_pg_mid']) ) $this->result("002");
            if( empty($request['od_payment_id']) ) $this->result("002");
            if( empty($request['od_amount']) ) $this->result("002");
            $request['od_no'] = $this->param['ident'];

            $orderModel = new \application\models\OrderNoModel();
            $row = $orderModel->get("sum(od_amount) as od_amount",array("od_no"=>$this->param['ident']));
            if( $row['od_amount'] != $request['od_amount'] ) $this->result("111");

            $partnerModel = new \application\models\PartnerModel();
            $row = $partnerModel->get("pt_own_pg_yn,shop_pg_service,shop_pg_key2",array("shop_pg_mid"=>$request['shop_pg_mid']));
            //if( empty($row) || empty($row['shop_pg_key2']) /*2023-03-24 추가*/ || empty($row['shop_pg_service'])){
            if( empty($row) ){
                $defaultModel = new \application\models\DefaultModel();
                $row = $defaultModel->get("shop_pg_service,shop_pg_key2",array("shop_pg_mid"=>$request['shop_pg_mid']));
            }

            if( empty($row) ) $this->result("111");
            if( $row['shop_pg_service'] == "toss" ){
                $res = $this->toss($request, $row['shop_pg_key2']);
            }else if( $row['shop_pg_service'] == "inicis" ){

            }else if( $row['shop_pg_service'] == "kcp" ){

            }
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009");
        }
    }

    public function toss($request, $secretKey){
        try{
            $orderModel = new \application\models\OrderNoModel();
            $row = $orderModel->get("sum(od_amount) as od_amount",array("od_no"=>$request['od_no']));
            if( $row['od_amount'] != $request['od_amount'] ) $this->result("111");

            $url = 'https://api.tosspayments.com/v1/payments/confirm';
            $data = ["paymentKey"=>$request['od_payment_id'],"amount" =>$request['od_amount'], "orderId" => $request['od_no']];
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

            if( $httpCode != 200 ) return "111"; //$this->result($httpCode,$response);
            $responseJson = json_decode($response,true);
            if($responseJson['status']!="DONE") return "111"; //$this->result("111");

            $arr = array();
            $arr['requestDate'] = $responseJson['requestedAt'];
            $arr['approvedDate'] = $responseJson['approvedAt'];
            $arr['pgMid'] = $responseJson['mId'];
            $arr['pgCompany'] = 'toss';
            $arr['paymentId'] = $responseJson['paymentKey'];
            $arr['escrowYn'] = $responseJson['useEscrow']=="true"?"y":"n";
            $arr['responseMsg'] = $response;

            $res = $orderModel->changeState("2",$request['od_no'],$arr);
            return $res;
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }




}
