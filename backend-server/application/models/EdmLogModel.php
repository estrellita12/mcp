<?php
namespace application\models;

class EdmLogModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_edm_log' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['edmId']) ) return;
            $value['edm_id'] = $arr['edmId'];
            if( !empty($arr['senderName']) )         $value['edml_sender_shop'] = $arr['senderName']; 
            if( !empty($arr['senderEmail']) )         $value['edml_sender_email'] = $arr['senderEmail']; 
            if( !empty($arr['userId']) )        $value['mb_id'] = $arr['userId']; 
            if( !empty($arr['userName']) )        $value['edml_receiver_name'] = $arr['userName']; 
            if( !empty($arr['userEmail']) )         $value['edml_receiver_email'] = $arr['userEmail']; 
            if( !empty($arr['title']) )         $value['edml_send_title'] = $arr['title']; 
            if( !empty($arr['content']) )         $value['edml_send_content'] = $arr['content']; 
            $value['edml_reg_dt'] = _DATE_YMDHIS; 
        }else{
            $value['edml_retry_dt'] = _DATE_YMDHIS; 
        }
        if( !empty($arr['resultCode']) )        $value['edml_send_res_code'] = $arr['resultCode']; 
        if( !empty($arr['resultMessage']) )     $value['edml_send_res_msg'] = $arr['resultMessage']; 
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['edmId']) ) $this->getParameter("edm_id",$_REQUEST['edmId']);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by edml_reg_dt desc "; 
    }

/*
    function get($id, $col="*"){
        if( empty($id) ) return "002";
        $search = " and edml_id = '{$id}' ";
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
        $search = " and edml_id = '{$id}' ";
        return $this->update($value,$search);
    }

}
