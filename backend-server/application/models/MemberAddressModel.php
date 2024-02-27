<?php
namespace application\models;

use \PDO;
use \Exception;

class MemberAddressModel extends Model
{
    var $colArr;
    function __construct(){
        parent::__construct ( 'web_member_address' );
        $this->colArr = array(
            "id"=>"mbad_idx",
            "memberId"=>"mb_id",
            "postcode"=>"mbad_postcode",
            "address1"=>"mbad_addr1",
            "address2"=>"mbad_addr2",
            "recipient"=>"mbad_recipient",
            "tel"=>"mbad_tel",
            "password"=>"mbad_password",
            "extraInfo"=>"mbad_etc",
            "def"=>"mbad_default",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            if( empty($arr['memberId']) || empty($arr['address1']) || empty($arr['address2']) || empty($arr['recipient']) || empty($arr['tel'])) return;
            $value['mb_id'] = $arr['memberId']; // 회원 고유번호
            $value['mbad_postcode'] = $arr['postcode']; // 우편번호
            $value['mbad_addr1'] = $arr['address1']; // 배달 기본주소
            $value['mbad_addr2'] = $arr['address2']; // 배달 상세주소
            $value['mbad_recipient'] = $arr['recipient']; // 수령인
            $value['mbad_tel'] = $arr['tel']; // 연락처
            $value['mbad_reg_dt'] = _DATE_YMDHIS; // 등록일시
        }

        if( !empty($arr['password']) )      $value['mbad_password'] = $arr['password']; // 현관 비밀번호
        if( !empty($arr['extraInfo']) )     $value['mbad_etc'] = $arr['extraInfo']; // 수령방식 기타
        if( !empty($arr['def']) )           $value['mbad_default'] = $arr['def']; // 기본 배송지 체크값

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        /*
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "address1" )     $this->getSearch("mbad_addr1",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "address2" )   $this->getSearch("mbad_addr2",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "recipient" )   $this->getSearch("mbad_recipient",$_REQUEST['kwd']);
        }
        */
        if( !empty($_REQUEST['id']) )           $this->getParameter("mbad_idx",$_REQUEST['id']);
        if( !empty($_REQUEST['memberId']) )     $this->getParameter("mb_id",$_REQUEST['memberId']);
        if( !empty($_REQUEST['postcode']) )     $this->getParameter("mbad_postcode",$_REQUEST['postcode']);
        if( !empty($_REQUEST['address1']) )     $this->getParameter("mbad_addr1",$_REQUEST['address1']);
        if( !empty($_REQUEST['address2']) )     $this->getParameter("mbad_addr2",$_REQUEST['address2']);
        if( !empty($_REQUEST['recipient']) )    $this->getParameter("mbad_recipient",$_REQUEST['recipient']);
        if( !empty($_REQUEST['tel']) )          $this->getParameter("mbad_tel",$_REQUEST['tel']);
        if( !empty($_REQUEST['regdate']) )      $this->getParameter("mbad_reg_dt",$_REQUEST['regdate']);
        if( !empty($_REQUEST['def']) )          $this->getParameter("mbad_default",$_REQUEST['def']);

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("mbad_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("mbad_reg_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by mbad_reg_dt desc ";    // 기본 정렬 방식 설정

        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'memberId' ) $this->sql_order = " order by mb_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'postcode' ) $this->sql_order = " order by mbad_postcode {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'address1' ) $this->sql_order = " order by mbad_addr1 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'address2' ) $this->sql_order = " order by mbad_addr2 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'recipient' ) $this->sql_order = " order by mbad_recipient {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'tel' ) $this->sql_order = " order by mbad_tel {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'regdate' ) $this->sql_order = " order by mbad_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'def' ) $this->sql_order = " order by mbad_default {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and mbad_idx = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id,$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $preValue = $this->get("*",array("mbad_idx"=>$id));

        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $flag = false;
        foreach($preValue as $k=>$v){
            if( isset($value[$k]) && strcmp($value[$k],$v)!=0 ) $flag = true;
        }
        if($flag){
            $search = " and mbad_idx = '{$id}' ";
            $res = $this->update($value,$search);
            return $res;
        }else{
            return "001";
        }
    }

    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $res = $this->insert($value);
        return $res;
    }

    function remove($id){
        if(empty($id)) return"002";
        $search = " and mbad_idx = '{$id}' ";
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
