<?php
namespace application\models;

use \PDO;

class SellerPayModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_seller_pay' );
    }

    function getValue($arr, $mode='add'){
        if( empty($arr) ) return;

        if( $mode == "add" ){
            if( empty($arr['seller']) ) return;
            $value['sl_id'] = $arr['seller'];
            $value['spay_reg_dt'] = _DATE_YMDHIS; 
            if( !empty($arr['rate']) )          $value['spay_rate'] = $arr['rate'];
            if( !empty($arr['bank']) )          $value['spay_bank'] = $arr['bank'];
            if( !empty($arr['account']) )       $value['spay_account'] = $arr['account'];
            if( !empty($arr['holder']) )        $value['spay_holder'] = $arr['holder'];
            if( !empty($arr['begin']) )         $value['spay_begin'] = $arr['begin'];
            if( !empty($arr['end']) )           $value['spay_end'] = $arr['end'];
            if( !empty($arr['orderList']) )     $value['spay_order_idl'] = $arr['orderList'];
            if( !empty($arr['cancelList']) )    $value['spay_cancel_idl'] = $arr['cancelList'];
            if( !empty($arr['deliveryList']) )    $value['spay_delivery_idl'] = $arr['deliveryList'];
            if( !empty($arr['orderCommission']) )    $value['spay_order_commission'] = $arr['orderCommission'];
            if( !empty($arr['deliveryCharge']) )         $value['spay_delivery_charge'] = $arr['deliveryCharge'];
            if( !empty($arr['cancelCommission']) )    $value['spay_cancel_commission'] = $arr['cancelCommission'];
            $value['spay_by_id'] = $_SESSION['user_id'];
            $value['spay_by_id_type'] = $_SESSION['user_type'];
            if( !empty($arr['commission']) )    $value['spay_commission'] = $arr['commission'];
            if( !empty($arr['memo']) )          $value['spay_adm_memo'] = $arr['memo'];
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        $this->sql_where .= " and spay_cancel_yn = 'n' ";            
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("spay_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("spay_reg_dt",$_REQUEST['end'],"le");
            }
        }
        if( !empty($_REQUEST['seller']) ) $this->getParameter("sl_id",$_REQUEST['seller']);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by spay_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            else if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by spay_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'commission' ) $this->sql_order = " order by spay_commission {$_REQUEST['colby']} ";
        }
    }
/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $search = " and spay_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/
    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and spay_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    function cancel($id){
        $value['spay_cancel_yn'] = "y";
        return $this->set($value,$id,"state");
    }

}
?>
