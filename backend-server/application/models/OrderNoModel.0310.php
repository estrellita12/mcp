<?php
namespace application\models;

use \Exception;

class OrderNoModel extends Model{ 

    public function __construct( ){
        parent::__construct ( 'web_order' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        return $value;
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
            $row = $this->get("*", array("od_no"=>$no),true);
            foreach($row as $od){
                $preOrder = $this->get("*", array("od_id"=>$id));
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
                return $this->set($value,$no,"state");
            }

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function changeState2($no,$arr=''){
        try{
            $value = array();
            $value['od_stt'] = "2";
            if( !empty($arr['requestDate']) )   $value['od_pay_request_dt'] = $arr['requestDate'];
            if( !empty($arr['approvedDate']) )  $value['od_pay_approved_dt'] = $arr['approvedDate'];
            if( !empty($arr['pgMid']) )         $value['od_pg_mid'] = $arr['pgMid'];
            if( !empty($arr['pgCompany']) )     $value['od_pg_company'] = $arr['pgCompany'];
            if( !empty($arr['paymentId']) )     $value['od_payment_id'] = $arr['paymentId'];
            if( !empty($arr['escrowYn']) )      $value['od_escrow_yn'] = $arr['escrowYn'];
            if( !empty($arr['responseMsg']) )   $value['od_response_msg'] = $arr['responseMsg'];
            $value['od_rcent_dt'] = _DATE_YMDHIS;
            $res = $this->set($value,$no,"state");
            if(  $res == "000" ){
                $row = $this->get("od_qty,gs_id,gs_opt_id",array("od_no"=>$no),true);
                $goodsModel = new \application\models\GoodsModel();
                foreach($row as $od){
                    $goodsModel->order($od['gs_id'],$od['gs_opt_id'],$od['od_qty'],true);
                }
                $cartModel = new \application\models\CartModel();
                $cartModel->order($no);
            }
            return $res;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function changeState42($no,$arr=''){ // 취소완료
        try{
            $value['od_stt'] = "42";
            $value['od_cancel_dt'] = _DATE_YMDHIS;
            if( !empty($arr['cancelReason']) ) $value['od_cancel_reason'] = $arr['cancelReason'];
            else $value['od_cancel_reason'] = "기타";
            $value['od_rcent_dt'] = _DATE_YMDHIS;
            $res = $this->set($value,$no,"state");
            if($res=="000"){
                $res = $this->cancel($no,$value);
                if($res == "000"){
                    $row = $this->get("gs_id,gs_opt_id,od_qty",array("od_no"=>$no),true);
                    $goodsModel = new \application\models\GoodsModel();
                    foreach($row as $od){
                        $goodsModel->stockCnt($od['gs_id'],$od['gs_opt_id'],$od['od_qty'],false);
                    }
                }
            }
            return $res;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function cancel($no,$value){
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

            }else if( $row['od_pg_company'] == "kcp" ){

            }
            if( $res=="000" ){
                $value = array();
                if( $type=="cancel" ) $value['od_cancel_amount'] = $row['od_amount'];
                else $value['od_return_amount'] = $row['od_amount'];
                $res = $this->set($value,$id,"value");
            }
            return $res;
        }catch(Exception $e){}

    }

}
?>
