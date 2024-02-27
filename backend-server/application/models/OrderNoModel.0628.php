<?php
namespace application\models;

use \Exception;

class OrderNoModel extends Model{ 

    public function __construct( ){
        parent::__construct ( 'web_order_no' );
    }

    public function getValue($arr,$mode="add"){
        try{
            if( empty($arr) ) return;

            if($mode=="add"){
                $value['od_no'] = $arr['no']; // 주문 번호
                $value['od_dt'] = _DATE_YMDHIS; // 주문 일시
                if( !empty($arr['paymethod']) )         $value['od_paymethod'] = $arr['paymethod']; 
                if( !empty($arr['shop']) )              $value['pt_id'] = $arr['shop'];
                if( !empty($arr['passwd']) )            $value['od_passwd'] = $arr['passwd'];
                if( isset($arr['state']) )              $value['od_stt'] = $arr['state'];
                $value['od_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['od_device'] = $_SERVER["HTTP_USER_AGENT"]; 
            }

            if( !empty($arr['userId']) )            $value['mb_id'] = $arr['userId']; // 주문자 아이디
            if( !empty($arr['userName']) )          $value['orderer_name'] = $arr['userName']; // 주문자 아이디
            if( !empty($arr['userEmail']) )         $value['orderer_email'] = $arr['userEmail']; 
            if( !empty($arr['userCellphone']) )     $value['orderer_cellphone'] = $arr['userCellphone']; 
            if( !empty($arr['userZip']) )           $value['orderer_zip'] = $arr['userZip']; 
            if( !empty($arr['userAddr1']) )         $value['orderer_addr1'] = $arr['userAddr1']; 
            if( !empty($arr['userAddr2']) )         $value['orderer_addr2'] = $arr['userAddr2']; 
            if( !empty($arr['userAddr3']) )         $value['orderer_addr3'] = $arr['userAddr3']; 
            if( !empty($arr['receiverName']) )      $value['receiver_name'] = $arr['receiverName']; 
            if( !empty($arr['receiverEmail']) )     $value['receiver_email'] = $arr['receiverEmail']; 
            if( !empty($arr['receiverCellphone']) ) $value['receiver_cellphone'] = $arr['receiverCellphone']; 
            if( !empty($arr['receiverZip']) )       $value['receiver_zip'] = $arr['receiverZip']; 
            if( !empty($arr['receiverAddr1']) )     $value['receiver_addr1'] = $arr['receiverAddr1']; 
            if( !empty($arr['receiverAddr2']) )     $value['receiver_addr2'] = $arr['receiverAddr2']; 
            if( !empty($arr['receiverAddr3']) )     $value['receiver_addr3'] = $arr['receiverAddr3']; 
            if( !empty($arr['receiverDeliveryMsg']) )   $value['receiver_delivery_msg'] = $arr['receiverDeliveryMsg']; 
            //if( !empty($arr['qty']) )               $value['od_qty'] = $arr['qty']; 
            if( !empty($arr['goodsPrice']) )        $value['od_goods_price'] = $arr['goodsPrice'];
            if( !empty($arr['point']) )             $value['od_use_point'] = $arr['point'];
            if( !empty($arr['coupon']) )            $value['od_use_coupon'] = $arr['coupon'];
            if( !empty($arr['deliveryType']) )      $value['od_delivery_type'] = $arr['deliveryType']; // 배송비 유형
            if( !empty($arr['deliveryCharge']) )     $value['od_delivery_charge'] = $arr['deliveryCharge']; 
            //if( !empty($arr['deliveryChargeDosan']) )     $value['od_delivery_charge_dosan'] = $arr['deliveryChargeDosan']; 
            if( !empty($arr['amount']) )            $value['od_amount'] = $arr['amount'];
            //if( !empty($arr['cancelAmount']) )      $value['od_cancel_amt'] = $arr['cancelAmount'];
            if( !empty($arr['vbank']) )             $value['od_vbank'] = $arr['vbank'];
            if( !empty($arr['vbankDeposit']) )      $value['od_vbank_deposit'] = $arr['vbankDeposit'];
            /*
            if( !empty($arr['test']) )              $value['od_test'] = $arr['test']; 
            if( !empty($arr['pgMid']) )             $value['od_pg_mid'] = $arr['pgMid']; 
            if( !empty($arr['pgCompany']) )         $value['od_pg_company'] = $arr['pgCompany']; 
            if( !empty($arr['paymentId']) )         $value['od_payment_id'] = $arr['paymentId']; 
            if( !empty($arr['escrowYn']) )         $value['od_escrow_yn'] = $arr['escrowYn']; 
            if( !empty($arr['taxFlag']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['taxMoney']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['vatMoney']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['freeMoney']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['taxInvoice']) )           $value['od_tax_invoice'] = $arr['taxInvoice'];
            if( !empty($arr['taxSaveInfo']) )           $value['od_taxsave_info'] = $arr['taxSaveInfo'];
            if( !empty($arr['taxBillInfo']) )           $value['od_taxbill_info'] = $arr['taxBillInfo'];
            if( !empty($arr['cashYn']) )         $value['od_cash_yn'] = $arr['cashYn']; 
            if( !empty($arr['cashNo']) )         $value['od_cash_no'] = $arr['cashNo']; 
            if( !empty($arr['cashInfo']) )         $value['od_cash_info'] = $arr['cashInfo']; 
            if( !empty($arr['memo']) )              $value['od_adm_memo'] = $arr['memo'];  
             */
            if( !empty($arr['state']) )         $value['od_stt'] = $arr['state']; 
            if( !empty($arr['rcentDate']) )              $value['od_rcent_dt'] = $arr['rcentDate'];  
            return $value;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }

    public function add($arr,$type='arr'){
        try{
            if($type=="arr") $value = $this->getValue($arr,'add');
            else $value = $arr;

            $res = $this->insert($value);
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function set($arr,$no,$type='arr'){
        try{
            if( empty($no) ) $no = $arr['no'];
            if( empty($no) ) return "002";

            if($type=="arr") $value = $this->getValue($arr,'set');
            else $value = $arr;

            $search = " and od_no = '{$no}' ";
            $res = $this->update($value,$search);
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function changeState($stt, $no, $arr=''){
        try{
            $csModel  = new \application\models\CustomerServiceModel(); 
            $orderModel  = new \application\models\OrderModel(); 
            $row = $orderModel->get("*", array("od_no"=>$no),true);
            foreach($row as $od){
                $preOrder = $orderModel->get("*", array("od_id"=>$id));
                $csValue['odId'] = $preOrder['od_id'];
                $csValue['odNo'] = $preOrder['od_no'];
                $csValue['userId'] = $preOrder['mb_id'];
                $csValue['statePre'] = $preOrder['od_stt'];
                $csValue['state'] = $stt;
                $csValue['type'] = empty($arr['type'])?"SYSTEM":$arr['type'];
                $csValue['message'] = $arr['message'];
                $csValue['byId'] = $_SESSION['user_id'];
                $csModel->add( $value );
            }

            $method = "changeState".$stt;
            if(method_exists($this,$method)){
                return $this->$method($no,$arr);
            }else{
                $value = array();
                $value['od_stt'] = $stt;
                $value['od_rcent_dt'] = _DATE_YMDHIS;
                $res = $this->set($value,$no,"state");
                if( $res == "000" ){
                    $search = " and od_no = '{$no}' ";
                    $orderModel->update($value,$search);
                }
                return $res;                
            }
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function changeState2($no,$arr=''){
        try{
            $this->pdo->beginTransaction();
            $value = array();
            $value['od_stt'] = "2";
            $value['od_rcent_dt'] = _DATE_YMDHIS;
            if( !empty($arr['requestDate']) )   $value['od_pay_request_dt'] = $arr['requestDate'];
            if( !empty($arr['approvedDate']) )  $value['od_pay_approved_dt'] = $arr['approvedDate'];
            if( !empty($arr['pgMid']) )         $value['od_pg_mid'] = $arr['pgMid'];
            if( !empty($arr['pgCompany']) )     $value['od_pg_company'] = $arr['pgCompany'];
            if( !empty($arr['paymentId']) )     $value['od_payment_id'] = $arr['paymentId'];
            if( !empty($arr['escrowYn']) )      $value['od_escrow_yn'] = $arr['escrowYn'];
            if( !empty($arr['responseMsg']) )   $value['od_response_msg'] = $arr['responseMsg'];
            $res = $this->set($value,$no,"state");
            if(  $res != "000" ) {
                $this->pdo->rollBack();
                return $res;
            }

            $orderModel  = new \application\models\OrderModel(); 
            $orderModel->pdo->beginTransaction();
            $search = " and od_no = '{$no}' ";
            $res = $orderModel->update($value,$search);
            if( $res != "000" ) {
                $this->pdo->rollBack();
                $orderModel->pdo->rollBack();
                return $res;
            }
            $row = $orderModel->get("od_no, sum(od_use_point) as od_use_point, sum(od_use_point_in) as od_use_point_in, sum(od_use_point_out) as od_use_point_out, mb_id, pt_id",array("od_no"=>$no));
            $memberModel  = new \application\models\MemberModel(); 
            $memberModel->pdo->beginTransaction();
            if( $row['od_use_point'] > 0 ){
                if( $row['od_use_point_in'] > 0 ){
                    $res = $memberModel->usePoint($row['mb_id'],$row['od_use_point_in'],"주문 차감",$row['od_no']);
                    if( $res != "000" ){
                        $this->pdo->rollBack();
                        $orderModel->pdo->rollBack();
                        return $res;
                    }
                }
                if( $row['od_use_point_out'] > 0 ){
                    if( $row['pt_id']=="alldeal" ){
                        $mb = $memberModel->get("mb_sns_id_3",array("mb_id"=>$row['mb_id']));
                        $url = "http://vnoti.co.kr/api/point/{$mb['mb_sns_id_3']}/order?od_id={$row['od_no']}&use_point={$row['od_use_point_out']}";
                        $token = "aJmkfoZdbdJBxFKFom2NLIAycnUS5Xabqo0hJdqgqU/8aZCC5tu6wWD+a8AOIG8tIoMQvvpL0uAVZr+2HBmPOkoGLvJYbBWb2KSCz2aiqMNjIOjIQ/toYGIuLa8F0Yde";
                        $curlHandle = curl_init($url);
                        curl_setopt_array($curlHandle, [
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => false,
                            CURLOPT_HTTPHEADER => array(
                                'Authorization: ' . $token,
                            ),
                        ]);
                        $response = json_decode(curl_exec($curlHandle),true);
                        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
                        curl_close($curlHandle);
                        $res = $response["result"];
                        if( $res != "000" ){
                            $this->pdo->rollBack();
                            $orderModel->pdo->rollBack();
                            $memberModel->pdo->rollBack();
                            return $res;
                        }
                    }
                }
            }
            $this->pdo->commit();
            $orderModel->pdo->commit();
            $memberModel->pdo->commit();

            $goodsModel = new \application\models\GoodsModel();
            $row = $orderModel->get("gs_id,gs_opt_id,od_qty",array("od_no"=>$no),true);
            foreach($row as $od){
                $goodsModel->order($od['gs_id'],$od['gs_opt_id'],$od['od_qty'],true);
            }
            $cartModel = new \application\models\CartModel();
            $cartModel->order($no);
            return $res;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function changeState42($no,$arr=''){ // 취소완료
        try{
            $this->pdo->beginTransaction();
            $value['od_stt'] = "42";
            $value['od_cancel_dt'] = _DATE_YMDHIS;
            $value['od_cancel_reason'] = empty($arr['cancelReason'])?"기타":$arr['cancelReason'];
            $value['od_rcent_dt'] = _DATE_YMDHIS;
            $res = $this->set($value,$no,"state");
            if ($res!="000") {
                $this->pdo->rollBack();
                return $res;
            }

            $orderModel  = new \application\models\OrderModel(); 
            $orderModel->pdo->beginTransaction();
            $search = " and od_no = '{$no}' ";
            $res = $orderModel->update($value,$search);
            if ($res!="000"){
                $this->pdo->rollBack();
                $orderModel->pdo->rollBack();
                return $res;
            }

            $row = $orderModel->get("od_no,sum(od_use_point) as od_use_point, sum(od_use_point_in) as od_use_point_in, sum(od_use_point_out) as od_use_point_out,mb_id,pt_id,od_team_id",array("od_no"=>$no));
            $memberModel = new \application\models\MemberModel();
            $memberModel->pdo->beginTransaction();        
            if( $row['od_use_point'] > 0 ){
                if( $row['od_use_point_in'] > 0 ){
                    $res = $memberModel->savePoint($row['mb_id'],$row['od_use_point_in'],"주문 취소",$row['od_no']);
                    if($res != "000"){
                        $this->pdo->rollBack();
                        $orderModel->pdo->rollBack();
                        $memberModel->pdo->rollBack();
                        return $res;
                    }
                }
                if( $row['od_use_point_out'] > 0 ){
                    if($row['pt_id']=="alldeal"){
                        $mb = $memberModel->get("mb_sns_id_3",array("mb_id"=>$row['mb_id']));   
                        $url = "http://vnoti.co.kr/api/point/{$mb['mb_sns_id_3']}/cancel?od_id={$row['od_no']}&use_point={$row['od_use_point_out']}";
                        $token = "aJmkfoZdbdJBxFKFom2NLIAycnUS5Xabqo0hJdqgqU/8aZCC5tu6wWD+a8AOIG8tIoMQvvpL0uAVZr+2HBmPOkoGLvJYbBWb2KSCz2aiqMNjIOjIQ/toYGIuLa8F0Yde";
                        $curlHandle = curl_init($url);
                        curl_setopt_array($curlHandle, [
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => false,
                            CURLOPT_HTTPHEADER => array(
                                'Authorization: ' . $token,
                            ),
                        ]);
                        $response = json_decode(curl_exec($curlHandle),true);
                        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
                        curl_close($curlHandle);
                        $res = $response["result"];
                        if( $res != "000" ){
                            $this->pdo->rollBack();
                            $orderModel->pdo->rollBack();
                            $memberModel->pdo->rollBack();
                            return $res;
                        }
                    }
                }
            }
            $res = $this->cancel($no,$value);
            if($res != "000") {}

            $this->pdo->commit();
            $orderModel->pdo->commit();
            $memberModel->pdo->commit();

            $goodsModel = new \application\models\GoodsModel();
            $row = $orderModel->get("gs_id,gs_opt_id,od_qty",array("od_no"=>$no),true);
            foreach($row as $od){
                $goodsModel->stockCnt($od['gs_id'],$od['gs_opt_id'],$od['od_qty'],false);
            }

            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function cancel($no,$arr=array(),$type="cancel"){ //전체 취소
        try{
            $row = $this->get("pt_id, od_no, od_pg_company, od_pg_mid, od_payment_id, od_amount, od_return_reason, od_cancel_reason", array("od_no"=>$no));

            $partnerModel = new \application\models\PartnerModel();
            $pg = $partnerModel->get("pt_own_pg_yn,shop_pg_service,shop_pg_test_yn,shop_pg_key1,shop_pg_key2",array("shop_pg_mid"=>$row['od_pg_mid']));
            if( empty($pg) || empty($pg['shop_pg_key2']) ){
                $defaultModel = new \application\models\DefaultModel();
                $pg = $defaultModel->get("shop_pg_service,shop_pg_test_yn,shop_pg_key1,shop_pg_key2",array("shop_pg_mid"=>$row['od_pg_mid']));
            }
            if( empty($pg) ) return "111";

            if( $row['od_pg_company'] == "toss" ){
                $tossModel = new \application\models\TossPayments();
                $res = $tossModel->cancel($row['od_no'], $row['od_payment_id'],$pg['shop_pg_key2'],$row['od_amount'],$row['od_cancel_reason']);
            }else if( $row['od_pg_company'] == "inicis" ){
                $res = "000";
            }else if( $row['od_pg_company'] == "kcp" ){
                $res = "000";
            }else{
                return "114";
            }

            if( $res=="000" ){
                $orderModel = new \application\models\OrderModel();
                $res = $orderModel->execute(" update {$this->tb_nm} set od_cancel_amount = od_amount  where od_no ='$no' ");
            }
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }
}

?>
