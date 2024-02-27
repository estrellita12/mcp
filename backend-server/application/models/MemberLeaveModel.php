<?php
namespace application\models;

use \PDO;

class MemberLeaveModel extends Model
{

    function __construct( ){
        parent::__construct ( 'web_member_leave' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            if( !empty($arr['id']) )    $value['mb_id'] = $arr['id']; // 탈퇴 회윈의 아이디
            if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop']; // 탈퇴 회원의 가맹점
            if( !empty($arr['reason']) )    $value['mb_leave_reason'] = $arr['reason']; // 회원 탈퇴 사유 
            if( !empty($arr['cellphone']) )    $value['mb_cellphone'] = $arr['cellphone']; // 회원 휴대전화 번호
            $value['mb_leave_dt'] = _DATE_YMDHIS; // 탈퇴 일시
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("mb_id",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['cellphone']) ) $this->getParameter("mb_cellphone",$_REQUEST['cellphone']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "leaveDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("mb_leave_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("mb_leave_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by mb_leave_dt desc ";
        
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'leaveDate' ) $this->sql_order = " order by mb_leave_dt {$_REQUEST['colby']} ";
        }
    }
/*
    function get($id,$col='*'){
        if( empty($id) ) return "002";
        $search = " and mb_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/
    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }
}
?>
