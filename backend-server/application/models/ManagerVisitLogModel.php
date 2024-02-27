<?php
namespace application\models;


class ManagerVisitLogModel extends Model{
    function __construct( ){
        parent::__construct ( 'web_manager_visit_log' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            $value['mng_visit_log_by_id'] = $_SESSION['user_id'];
            $value['mng_visit_log_by_id_type'] = "";
            if( !empty($arr['mng_visit_log_msg']) ) 
                $value['mng_visit_log_msg'] = $arr['mng_visit_log_msg'];
            $value['mng_visit_log_url'] = _SCRIPT_URI;
            $value['mng_visit_log_reg_dt'] = _DATE_YMDHIS; 
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

    function get($id, $col="*"){
        $sql_where = " and cs_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }
}
?>
