<?php
namespace application\models;

class LmsLogModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_lms_log' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['lmsId']) ) return;
            $value['lms_id'] = $arr['lmsId'];
            if( !empty($arr['senderName']) )         $value['lmsl_sender_shop'] = $arr['senderName']; 
            if( !empty($arr['senderTel']) )         $value['lmsl_sender_Tel'] = $arr['senderTel']; 
            if( !empty($arr['userId']) )        $value['mb_id'] = $arr['userId']; 
            if( !empty($arr['userName']) )        $value['lmsl_receiver_name'] = $arr['userName']; 
            if( !empty($arr['userCellphone']) )         $value['lmsl_receiver_cellphone'] = $arr['userCellphone']; 
            if( !empty($arr['title']) )         $value['lmsl_send_title'] = $arr['title']; 
            if( !empty($arr['content']) )         $value['lmsl_send_content'] = $arr['content']; 
            $value['lmsl_reg_dt'] = _DATE_YMDHIS; 
        }else{
            $value['lmsl_retry_dt'] = _DATE_YMDHIS; 
        }
        if( !empty($arr['resultCode']) )        $value['lmsl_send_res_code'] = $arr['resultCode']; 
        if( !empty($arr['resultMessage']) )     $value['lmsl_send_res_msg'] = $arr['resultMessage']; 
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['lmsId']) ) $this->getParameter("lms_id",$_REQUEST['lmsId']);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by lmsl_reg_dt desc "; 
    }

/*
    function get($id, $col="*"){
        if( empty($id) ) return "002";
        $search = " and lmsl_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/
    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    function set($arr,$id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        $search = " and lmsl_id = '{$id}' ";
        return $this->update($value,$search);
    }

}
