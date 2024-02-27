<?php
namespace application\models;

class TemplateSendLogModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_template_send_log' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['tpId']) ) return;
            $value['tp_id'] = $arr['tpId'];
            $value['tpsl_by_id'] = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $value['tpsl_by_id_type'] = !empty($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
            if( !empty($arr['senderName']) )            $value['tpsl_sender_shop'] = $arr['senderName']; 
            if( !empty($arr['senderEmail']) )            $value['tpsl_sender_email'] = $arr['senderEmail']; 
            if( !empty($arr['senderTel']) )            $value['tpsl_sender_email'] = $arr['senderTel']; 
            if( !empty($arr['userId']) )            $value['mb_id'] = $arr['userId']; 
            if( !empty($arr['userName']) )          $value['tpsl_receiver_name'] = $arr['userName']; 
            if( !empty($arr['userEmail']) )         $value['tpsl_receiver_email'] = $arr['userEmail']; 
            if( !empty($arr['userCellphone']) )     $value['tpsl_receiver_cellphone'] = $arr['userCellphone']; 
            if( !empty($arr['title']) )             $value['tpsl_send_title'] = $arr['title']; 
            if( !empty($arr['content']) )           $value['tpsl_send_content'] = $arr['content']; 
            $value['tpsl_reg_dt'] = _DATE_YMDHIS; 
        }else{
            $value['tpsl_retry_dt'] = _DATE_YMDHIS; 
        }
        if( !empty($arr['resultCode']) )        $value['tpsl_send_res_code'] = $arr['resultCode']; 
        if( !empty($arr['resultMessage']) )     $value['tpsl_send_res_msg'] = $arr['resultMessage']; 
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['tpId']) ) $this->sql_where .= " and tp_id = '{$_REQUEST['tpId']}' ";
        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by tpsl_reg_dt desc ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    function set($arr,$id=''){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $value = $this->getValue($arr,'set');
        $search = " and tpsl_id = '{$id}' ";
        return $this->update($value,$search);
    }

}
