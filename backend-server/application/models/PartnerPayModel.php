<?php
namespace application\models;

use \PDO;

class PartnerPayModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_partner_pay' );
    }

    function getValue($arr, $mode='add'){
        if( empty($arr) ) return;

        if( $mode == "add" ){
            if( empty($arr['shop']) ) return;
            $value['pt_id'] = $arr['shop'];
            $value['ppay_reg_dt'] = _DATE_YMDHIS; 
            if( !empty($arr['rate']) )          $value['ppay_rate'] = $arr['rate'];
            if( !empty($arr['bank']) )          $value['ppay_bank'] = $arr['bank'];
            if( !empty($arr['account']) )       $value['ppay_account'] = $arr['account'];
            if( !empty($arr['holder']) )        $value['ppay_holder'] = $arr['holder'];
            if( !empty($arr['begin']) )         $value['ppay_begin'] = $arr['begin'];
            if( !empty($arr['end']) )           $value['ppay_end'] = $arr['end'];
            if( !empty($arr['orderList']) )     $value['ppay_order_idl'] = $arr['orderList'];
            if( !empty($arr['cancelList']) )    $value['ppay_cancel_idl'] = $arr['cancelList'];
            if( !empty($arr['orderCommission']) )    $value['ppay_order_commission'] = $arr['orderCommission'];
            if( !empty($arr['point']) )         $value['ppay_tot_point'] = $arr['point'];
            if( !empty($arr['coupon']) )        $value['ppay_tot_point'] = $arr['coupon'];
            if( !empty($arr['cancelCommission']) )    $value['ppay_cancel_commission'] = $arr['cancelCommission'];
            $value['ppay_by_id'] = $_SESSION['user_id'];
            $value['ppay_by_id_type'] = $_SESSION['user_type'];
            if( !empty($arr['commission']) )    $value['ppay_commission'] = $arr['commission'];
            if( !empty($arr['memo']) )          $value['ppay_adm_memo'] = $arr['memo'];
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        $this->sql_where .= " and ppay_cancel_yn = 'n' ";            
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("ppay_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("ppay_reg_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by ppay_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            else if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by ppay_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'commission' ) $this->sql_order = " order by ppay_commission {$_REQUEST['colby']} ";
        }
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $search = " and ppay_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/
    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and ppay_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    function cancel($id){
        $value['ppay_cancel_yn'] = "y";
        return $this->set($value,$id,"state");
    }

}
?>
