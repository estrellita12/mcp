<?php
namespace application\models;

use \Exception;

class MemberSleepModel extends Model{

    public function __construct( ){
        try{
            parent::__construct ( 'web_member_sleep' );
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            if( !empty($arr['id']) )     $value['mb_id'] = $arr['id']; // 회원 아이디
            //if( !empty($arr['snsid1']) )     $value['mb_sns_id_1'] = $arr['snsid1']; // 네아로 아이디
            //if( !empty($arr['snsid2']) )     $value['mb_sns_id_2'] = $arr['snsid2']; // 카아로 아이디
            $value['mb_reg_dt'] = _DATE_YMDHIS; // 회원 가입 일시
        }

        if( !empty($arr['name']) )      $value['mb_name'] = $arr['name']; // 회원 이름
        if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop']; // 회원이 가입한 쇼핑몰 ID (가맹점)
        if( !empty($arr['state']) )     $value['mb_stt'] = $arr['state']; // 회원 상태(1:승인,2:차단)
        if( !empty($arr['grade']) )     $value['mb_grade'] = $arr['grade']; // 회원 등급
        if( !empty($arr['passwd']) )    $value['mb_passwd'] = $arr['passwd'];   // 회원 비밀 번호
        if( !empty($arr['birth']) )     $value['mb_birth'] = $arr['birth']; // 회원 생년월일
        if( !empty($arr['gender']) )    $value['mb_gender'] = $arr['gender'];   // 회원 성별
        if( !empty($arr['email']) )     $value['mb_email'] = $arr['email'];    // 회원 메일 주소
        if( !empty($arr['cellphone']) ) $value['mb_cellphone'] = $arr['cellphone']; // 회원 핸드폰 번호
        if( !empty($arr['zip']) )       $value['mb_zip'] = $arr['zip'];      // 우편 번호
        if( !empty($arr['addr1']) )     $value['mb_addr1'] = $arr['addr1'];    // 기본 주소
        if( !empty($arr['addr2']) )     $value['mb_addr2'] = $arr['addr2'];    // 상세 주소
        if( !empty($arr['addr3']) )     $value['mb_addr3'] = $arr['addr3'];    // 참고 주소 (건물명)
        if( !empty($arr['jibeon']) )    $value['mb_addr_jibeon'] = $arr['jibeon'];    // 집배원 메세지 (배송 메세지)
        if( !empty($arr['addrId']) )    $value['mb_addr_id'] = $arr['addrId'];    // 기본주소 ID
        if( !empty($arr['billingId']) )    $value['mb_billing_id'] = $arr['billingId'];    // 기본 결제 카드
        if( !empty($arr['paymentType']) )  $value['mb_payment_type'] = $arr['paymentType']; // 기본 결제 수단
        if( !empty($arr['emailser']) )  $value['mb_emailser'] = $arr['emailser']; // 이메일 마케팅 수신동의 ( Y:동의, N:거부 ) 
        if( !empty($arr['smsser']) )    $value['mb_smsser'] = $arr['smsser'];   // SMS 마케팅 수신동의 ( Y:동의, N:거부 )
        //if( !empty($arr['lastlogin']) )    $value['mb_last_login_dt'] = $arr['lastlogin'];   // 마지막(최근)로그인 일시
        //if( !empty($arr['loginip']) )   $value['mb_login_ip'] = $arr['loginip'];   // 마지막(최근) 접속 아이피
        //if( !empty($arr['logincnt']) )  $value['mb_login_cnt'] = $arr['logincnt'];   // 회원 로그인 횟수
        //if( !empty($arr['odsum']) )     $value['mb_order_sum'] = $arr['odsum'];   // 회원 총 구매 횟수
        if( !empty($arr['memo']) )      $value['mb_memo'] = $arr['memo'];     // 메모
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("mb_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" ) $this->getSearch("mb_name",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "email" ) $this->getSearch("mb_email",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "cellphone" ) $this->getSearch("mb_cellphone",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "shop" ) $this->getSearch("pt_id",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['grade']) && $_REQUEST['grade'] != "all" ) $this->getParameter("mb_grade",$_REQUEST['grade']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("mb_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("mb_reg_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "lastLoginDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("mb_last_login_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("mb_last_login_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by mb_reg_dt desc "; 

        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by mb_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'loginCnt' ) $this->sql_order = " order by mb_login_cnt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'point' ) $this->sql_order = " order by mb_point {$_REQUEST['colby']} ";
        }
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $search = " and mb_id = '{$id}' ";
        return $this->select( $col, $search );
    }
 */
    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        $search = " and mb_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr,$type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and mb_id = '{$id}' ";
        return $this->delete($search);
    }
}
?>
