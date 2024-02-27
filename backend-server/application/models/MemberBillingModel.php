<?php
namespace application\models;

use \PDO;
use \Exception;

class MemberBillingModel extends Model
{
    var $colArr;
    function __construct(){
        parent::__construct ( 'web_member_billing' );
        $this->colArr = array(
            "id"=>"mbbi_idx",
            "memberId"=>"mb_id",
            "bKey"=>"mbbi_billing_key",
            "regdate"=>"mbbi_regdate",
            "def"=>"mbbi_default",
            "sInfo"=>"mbbi_semi_info",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            if( empty($arr['memberId']) || empty($arr['bKey']) || empty($arr['sInfo']) ) return;
            $value['mb_id'] = $arr['memberId']; // 회원 고유번호
            $value['mbbi_billing_key'] = $arr['bKey']; // billing Key
            $value['mbbi_semi_info'] = $arr['sInfo']; // 카드 표시정보
            $value['mbbi_regdate'] = _DATE_YMDHIS; // 등록일시
        }
        if( !empty($arr['def']) ) $value['mbbi_default'] = $arr['def']; // 기본카드 등록 여부
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['id']) )               $this->getParameter("mbbi_idx",$_REQUEST['id']);
        if( !empty($_REQUEST['memberId']) )         $this->getParameter("mb_id",$_REQUEST['memberId']);
        //if( !empty($_REQUEST['bKey']) )           $this->getParameter("mbbi_billing_key",$_REQUEST['bKey']);
        if( !empty($_REQUEST['def']) )          $this->getParameter("mbbi_default",$_REQUEST['def']);
        if( !empty($_REQUEST['sInfo']) )            $this->getParameter("mbbi_semi_info",$_REQUEST['sInfo']);

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("mbbi_regdate",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("mbbi_regdate",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by mbbi_regdate desc ";    // 기본 정렬 방식 설정

        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'memberId' ) $this->sql_order = " order by mb_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'def' ) $this->sql_order = " order by mbbi_default {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and mbbi_idx = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $res = $this->insert($value);
        return $res;
    }

    function remove($id){
        if(empty($id)) return"002";
        $search = " and mbbi_idx = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }    

    function removeMember($mb_id){
        if(empty($mb_id)) return"002";
        $search = " and mb_id = '{$mb_id}' ";
        $res = $this->delete($search);
        return $res;
    }        
}
?>
