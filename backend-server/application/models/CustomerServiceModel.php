<?php
namespace application\models;

use \PDO;

class CustomerServiceModel extends Model{
    function __construct( ){
        parent::__construct ( 'web_customer_service' );
    }

    function getValue($arr,$mode="add",$by=''){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( !empty($arr['odId']) ) $value['od_id'] = $arr['odId']; 
            if( !empty($arr['odNo']) ) $value['cs_od_no'] = $arr['odNo']; 
            if( !empty($arr['userId']) ) $value['mb_id'] = $arr['userId']; 
            if( !empty($arr['actButton']) ) $value['cs_type'] = $arr['actButton']; 
            if( !empty($arr['type']) ) $value['cs_type'] = $arr['type']; 
            if( isset($arr['state']) ) $value['cs_od_stt'] = $arr['state']; 
            if( isset($arr['statePre']) ) $value['cs_od_stt_pre'] = $arr['statePre']; 
            if( !empty($arr['byId']) ) $value['cs_by_id'] = $arr['byId'];
            if( !empty($_SESSION['user_id']) ) $value['cs_by_id'] = $_SESSION['user_id'];
            if( !empty($arr['byIdType']) ) $value['cs_by_id_type'] = $arr['byIdType'];
            $value['cs_reg_dt'] = _DATE_YMDHIS; 
            if( !empty($arr['message']) ) $value['cs_message'] = $arr['message']; 
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['odId']) ) $this->getParameter("od_id",$_REQUEST['odId']);
        if( !empty($_REQUEST['userId']) ) $this->getParameter("mb_id",$_REQUEST['userId']);
        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by cs_reg_dt desc ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }
/*
    function get($id, $col="*"){
        $sql_where = " and cs_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function add($arr, $by=''){
        $value = $this->getValue($arr,'add',$by);
        return $this->insert($value);
    }
}
?>
