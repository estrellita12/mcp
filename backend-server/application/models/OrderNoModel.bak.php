<?php
namespace application\models;

use \PDO;

class OrderNoModel extends Model{ 

    var $colArr;

    function __construct( ){
        parent::__construct ( 'web_order' );
        $this->colArr = array(
            "odId"=>"group_concat(od_id)",
            "odNo"=>"od_no",
            "state"=>"max(od_stt)",
            "orderDate"=>"od_dt",
            "cancelDate"=>"od_cancel_dt",
            "returnDate"=>"od_return_dt",
            "goodsPrice"=>"sum(od_goods_price)",
            "qty"=>"sum(od_qty)",
            "amount"=>"sum(od_amount)",
            "cancelAmount"=>"sum(od_cancel_amount)",
            "returnAmount"=>"sum(od_return_amount)",
            "point"=>"sum(od_use_point)",
            "coupon"=>"sum(od_use_coupon)",
            "deliveryCharge"=>"sum(od_delivery_charge)",
            "deliveryChargeDosan"=>"sum(od_delivery_charge_dosan)",
            "userId" =>"mb_id",
            "userName" => "orderer_name",
            "userEmail" => "orderer_email",
            "userCellphone" => "orderer_cellphone",
            "receiverName" => "receiver_name",
            "receiverEmail" => "receiver_email",
            "receiverCellphone" => "receiver_cellphone",
            "receiverZip" => "receiver_zip",
            "receiverAddr1" => "receiver_addr1",
            "receiverAddr2" => "receiver_addr2",
            "receiverDeliveryMsg" => "receiver_delivery_msg",
            "paymentsId"=>"od_payment_id",
            "pgCompany"=>"od_pg_company",
            "paymethod"=>"od_paymethod",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            $value['od_no'] = $arr['no']; // 주문 번호
            $value['od_dt'] = _DATE_YMDHIS; // 주문 일시
            if( !empty($arr['paymethod']) )         $value['od_paymethod'] = $arr['paymethod']; 
            if( !empty($arr['shop']) )              $value['pt_id'] = $arr['shop'];
            if( !empty($arr['passwd']) )           $value['od_passwd'] = $arr['passwd'];
            if( isset($arr['state']) )           $value['od_stt'] = $arr['state'];
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
        if( !empty($arr['vbank']) )             $value['od_vbank'] = $arr['vbank'];
        if( !empty($arr['vbankDeposit']) )      $value['od_vbank_deposit'] = $arr['vbankDeposit'];
        //if( !empty($arr['payDate']) )           $value['od_pay_dt'] = $arr['payDate'];
        //if( !empty($arr['deliveryDate']) )           $value['od_delivery_dt'] = $arr['deliveryDate'];
        //if( !empty($arr['invoiceDate']) )           $value['od_invoice_dt'] = $arr['invoiceDate'];
        //if( !empty($arr['cancelDate']) )           $value['od_cancel_dt'] = $arr['cancelDate'];
        //if( !empty($arr['returnDate']) )           $value['od_return_dt'] = $arr['returnDate'];
        //if( !empty($arr['changeDate']) )           $value['od_change_dt'] = $arr['changeDate'];
        if( !empty($arr['confirm']) )           $value['od_confirm_yn'] = $arr['confirm']; 
        //if( !empty($arr['confirmDate']) )           $value['od_confirm_dt'] = $arr['confirmDate'];
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
        //if( !empty($arr['rcentDate']) )         $value['od_rcent_dt'] = $arr['rcentDate']; 
        if( !empty($arr['memo']) )              $value['od_adm_memo'] = $arr['memo'];  
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        $this->sql_where .= " and od_stt != '0' ";            
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd'])){
            if( $_REQUEST['srch'] == "no" ) $this->getSearch("od_no",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "userId" ) $this->getSearch("mb_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "userName" ) $this->getSearch("orderer_name",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "userCellphone" ) $this->getSearch("orderer_cellphone",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['odNo']) ) $this->getParameter("od_no",$_REQUEST['odNo']);
        if( !empty($_REQUEST['userId']) ) $this->getParameter("mb_id",$_REQUEST['userId']);
        if( !empty($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['paymethod']) ) $this->getParameter("od_paymethod",$_REQUEST['paymethod']);
        if( !empty($_REQUEST['confirm']) ) $this->getParameter("od_confirm_yn",$_REQUEST['confirm']);

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "orderDate" ){
                if( !empty($_REQUEST['beg']) ) $this->getTerm("od_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("od_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "rcentDate" ) {
                if( !empty($_REQUEST['beg']) ) $this->getTerm("od_rcent_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("od_rcent_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by od_dt desc ";    // 기본 정렬 방식 설정
    }

    public function set($arr,$no,$type='arr'){
        if(empty($no)) $no=$arr['no'];
        if(empty($no)) return "002";

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and od_no = '{$no}' ";
        $res = $this->update($value,$search);
        return $res;
    }

    public function changeState($stt, $no, $arr=''){
        $row = $this->get("*", array("od_no"=>$no),true);
        /*
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
            $cs  = new \application\models\CustomerServiceModel(); 
            $cs->add( $value );
        }
        */

        $method = "changeState".$stt;
        if(method_exists($this,$method)){
            return $this->$method($no,$arr);
        }else{
            $value = array();
            $value['od_stt'] = $stt;
            $value['od_rcent_dt'] = _DATE_YMDHIS;
            return $this->set($value,$no,"state");
        }
    }

    function changeState2($no,$arr=''){
        $value['od_stt'] = "2";
        if( !empty($arr['requestDate']) )
            $value['od_pay_request_dt'] = $arr['requestDate'];
        $value['od_pay_approved_dt'] = $arr['approvedDate'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        $value['od_pg_mid'] = $arr['pgMid'];
        $value['od_pg_company'] = $arr['pgCompany'];
        $value['od_payment_id'] = $arr['paymentId'];
        $value['od_escrow_yn'] = $arr['escrowYn'];
        $value['od_response_msg'] = $arr['responseMsg'];
        $row = $this->get("od_qty,gs_id,gs_opt_id",array("od_no"=>$no),true);
        $goodsModel = new \application\models\GoodsModel();
        foreach($row as $od){
            $goodsModel->orderQty($od['gs_id'],$od['gs_opt_id'],$od['od_qty'],true);
            $goodsModel->stockCnt($od['gs_id'],$od['gs_opt_id'],$od['od_qty'],true);
        }

        $cartModel = new \application\models\CartModel();
        $cartModel->order($no);
        return $this->set($value,$no,"state");
    }

    function changeState36($no,$arr=''){ // 반품완료
        $value['od_stt'] = "36";
        $value['od_return_dt'] = _DATE_YMDHIS;
        $value['od_return_reason'] = $arr['returnReason'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        $res = $this->set($value,$no,"state");
        if($res=="000"){
            $res = $this->cancel($no,$arr);
        }
        return $res;
    }

    function changeState42($no,$arr=''){ // 입금대기,결제 완료 상태로 바로 취소 가능
        $value['od_stt'] = "42";
        $value['od_cancel_dt'] = _DATE_YMDHIS;
        $value['od_cancel_reason'] = $arr['cancelReason'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        $res = $this->set($value,$no,"state");
        if($res=="000"){
            $res = $this->cancel($no);
        }
        return $res;
    }

    function cancel($no,$type="cancel"){
        if( empty($no) ) return "002";

        $row = $this->get("od_no as odNo,od_payment_id as paymentId, sum(od_amount) as amount, od_return_reason as returnReason, od_cancel_reason as cancelReason", array("od_no"=>$no));

        $odNo = $row['odNo'];
        $paymentsId = $row['paymentId'];
        $amount = $row['amount'];
        if($type=="cancel")  $cancelReason = $row['cancelReason'];
        else  $cancelReason = $row['returnReason'];
        $refundableAmount = $amount;

        $this->toss = new \application\models\TossPayments();
        $response = $this->toss->cancel($odNo, $paymentsId, $amount, $cancelReason, $refundableAmount);

        if( !$response['isSuccess'] ) {
            debug_log( static::class,"112",array("odNo"=>$odNo, "paymentsId"=>$paymentsId, "amount"=>$amount,"refundableAmount"=>$refundableAmount, "reason"=>$cancelReason)); 
            $value['od_response_msg'] = $response['response'];
            $res = $this->set($value, $no, "value");
            return "112";
        }

        $cancelAmount = 0;
        $responseData = json_decode($response['response'],true);
        foreach($responseData['cancels'] as $cancel){
            $cancelAmount += $cancel['cancelAmount'];
        }
        if($amount != $cancelAmount){
            debug_log( static::class,"112",array("odNo"=>$odNo, "paymentsId"=>$paymentsId, "amount"=>$amount,"cancelAmount"=>$cancelAmount, "reason"=>$cancelReason)); 
            $value['od_response_msg'] = $response['response'];
            $res = $this->set($value, $no, "value");
            return "112";
        }

        $sql = "update ".$this->tb_nm." set od_response_msg = '".$response['response']."' , od_cancel_amount = od_amount where od_no = ".$no;
        $res = $this->execute($sql);
        return $res;
    }
}
?>
