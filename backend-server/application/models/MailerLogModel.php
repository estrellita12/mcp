<?php
namespace application\models;

use \PDO;

class MailerLogModel extends Model
{
    function __construct( ){
        parent::__construct ( 'mailer_log' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            try{
                if( empty($arr['id']) ) return;
                $value['mail_id'] = $arr['id'];
                if( !empty($arr['userId']) )        $value['mb_id'] = $arr['userId']; 
                if( !empty($arr['email']) )         $value['mail_send_email'] = $arr['email']; 
                if( !empty($arr['message']) )       $value['mail_send_msg'] = $arr['message']; 
                $value['mail_log_reg_dt'] = _DATE_YMDHIS; 
            }catch(Exception $e){
                return;
            }
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("mail_id",$_REQUEST['kwd']);
        } 
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by mail_log_reg_dt asc ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }
/*
    function get($id, $col="*"){
        $sql_where = " and mail_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }
}
?>
