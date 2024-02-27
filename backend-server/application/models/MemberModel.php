<?php
namespace application\models;

use \Exception;

class MemberModel extends Model{
    var $colArr;

    public function __construct( ){
        parent::__construct ( 'web_member' );
        $this->colArr = array(
            "id"=>"mb_id",
            "shop"=>"pt_id",
            "snsid1"=>"mb_sns_id_1",
            "snsid2"=>"mb_sns_id_2",
            "snsid3"=>"mb_sns_id_3",
            "snsid4"=>"mb_sns_id_4",            
            "name"=>"mb_name",
            "grade"=>"mb_grade",
            "email"=>"mb_email",
            "cellphone"=>"mb_cellphone",
            "smsser"=>"mb_smsser_yn",
            "emailser"=>"mb_emailser_yn",
            "zip"=>"mb_zip",
            "addr1"=>"mb_addr1",
            "addr2"=>"mb_addr2",
            "addrId"=>"mb_addr_id",
            "img"=>"mb_img",
            "birth"=>"mb_birth",
            "gender"=>"mb_gender",
            "billingId"=>"mb_billing_id",
            "paymentType"=>"mb_payment_type",
            "point"=>"mb_point",
            "appleRefresh"=>"mb_apple_refresh",
        );
    }

    public function getValue($arr,$mode="add"){
        try{
            if( empty($arr) ) return;
            if($mode=="add"){  
                if( empty($arr['id']) ) return;
                $value['mb_id'] = $arr['id']; // 회원 아이디
                $value['mb_reg_dt'] = _DATE_YMDHIS; // 회원 가입 일시
                $value['mb_grade'] = 9;
            }

            if( !empty($arr['name']) )      $value['mb_name'] = $arr['name']; // 회원 이름
            if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop']; // 회원이 가입한 쇼핑몰 ID (가맹점)
            if( !empty($arr['state']) )     $value['mb_stt'] = $arr['state']; // 회원 상태(1:대기, 2:승인)
            if( !empty($arr['block']) )     $value['mb_block_yn'] = $arr['block']; // 사용자 차단 여부
            if( !empty($arr['grade']) )     $value['mb_grade'] = $arr['grade']; // 회원 등급
            if( !empty($arr['img']) )       $value['mb_img'] = $arr['img']; // 회원 프로필 이미지
            if( !empty($arr['passwd']) )    $value['mb_passwd'] = password($arr['passwd']);   // 회원 비밀 번호
            if( !empty($arr['birth']) )     $value['mb_birth'] = $arr['birth']; // 회원 생년월일
            if( !empty($arr['gender']) )    $value['mb_gender'] = $arr['gender'];   // 회원 성별
            if( !empty($arr['point']) )     $value['mb_point'] = $arr['point'];   // 회원 포인트
            if( !empty($arr['email']) )     $value['mb_email'] = $arr['email'];    // 회원 메일 주소
            if( !empty($arr['cellphone']) ) $value['mb_cellphone'] = $arr['cellphone']; // 회원 핸드폰 번호
            if( !empty($arr['zip']) )       $value['mb_zip'] = $arr['zip'];      // 우편 번호
            if( !empty($arr['addr1']) )     $value['mb_addr1'] = $arr['addr1'];    // 기본 주소
            if( !empty($arr['addr2']) )     $value['mb_addr2'] = $arr['addr2'];    // 상세 주소
            if( !empty($arr['addr3']) )     $value['mb_addr3'] = $arr['addr3'];    // 참고 주소 (건물명)
            if( !empty($arr['addrId']) )    $value['mb_addr_id'] = $arr['addrId'];    // 기본주소 ID
            if( !empty($arr['baesongMsg']) )    $value['mb_baesong_msg'] = $arr['baesongMsg'];    // 집배원 메세지 (배송 메세지)
            if( !empty($arr['billingId']) )    $value['mb_billing_id'] = $arr['billingId'];    // 기본 결제 카드
            if( !empty($arr['paymentType']) )  $value['mb_payment_type'] = $arr['paymentType']; // 기본 결제 수단
            if( !empty($arr['emailser']) )  $value['mb_emailser_yn'] = $arr['emailser']; // 이메일 마케팅 수신동의 ( y:동의, n:거부 ) 
            if( !empty($arr['smsser']) )    $value['mb_smsser_yn'] = $arr['smsser'];   // SMS 마케팅 수신동의 ( y:동의, n:거부 )
            //if( !empty($arr['lastLogin']) )    $value['mb_last_login_dt'] = $arr['lastLogin'];   // 마지막(최근)로그인 일시
            //if( !empty($arr['lastLoginIp']) )   $value['mb_last_login_ip'] = $arr['lastLoginIp'];   // 마지막(최근) 접속 아이피
            //if( !empty($arr['logincnt']) )  $value['mb_login_cnt'] = $arr['logincnt'];   // 회원 로그인 횟수
            //if( !empty($arr['odsum']) )     $value['mb_order_sum'] = $arr['odsum'];   // 회원 총 구매 횟수
            if( !empty($arr['memo']) )      $value['mb_adm_memo'] = $arr['memo'];     // 회원에 대한 관리자 메모
            if( !empty($arr['snsid1']) )     $value['mb_sns_id_1'] = $arr['snsid1']; // 카아로 아이디
            if( !empty($arr['snsid2']) )     $value['mb_sns_id_2'] = $arr['snsid2']; // 네아로 아이디
            if( !empty($arr['snsid3']) )     $value['mb_sns_id_3'] = $arr['snsid3']; 
            if( !empty($arr['snsid4']) )     $value['mb_sns_id_4'] = $arr['snsid4'];             
            if( !empty($arr['appleRefresh']) )     $value['mb_apple_refresh'] = $arr['appleRefresh']; // 애플 리프레시 토큰
            if( !empty($arr['dailyAttend']) )     $value['mb_daily_attend'] = $arr['dailyAttend']; // 일일 출석참여
            return $value;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return;
        }
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
            else if( $_REQUEST['term'] == "lastLoginDate" ){ 
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
            else if( $_REQUEST['col'] == 'lastLoginDate' ) $this->sql_order = " order by mb_last_login_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'loginCnt' ) $this->sql_order = " order by mb_login_cnt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'point' ) $this->sql_order = " order by mb_point {$_REQUEST['colby']} ";
        }
    }

    public function set($arr, $id, $type="arr"){
        try{
            if( empty($id) ) $id = $arr['id'];
            if( empty($id) ) return "002";
            if($type=="arr") $value = $this->getValue($arr,'set');
            else $value = $arr;
            if( empty($value) ) return "002";
            $search = " and mb_id = '{$id}' ";
            return $this->update($value,$search);
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function add($arr, $type='arr'){
        try{
            if(empty($arr)) return "002";
            if($type=="arr") $value = $this->getValue($arr,'add');
            else $value = $arr;
            if( empty($value) ) return "002";

            $user = new \application\models\UserModel();
            if( !$user->overChk('user_id', $value['mb_id']) ) return "003";
            $res = $user->add(array("id"=>$value['mb_id'],"type"=>"Member"));
            if($res != "000") return "003";
            return $this->insert($value);
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function remove($id){
        try{
            if( empty($id) ) return "002";
            $search = " and mb_id = '{$id}' ";
            return $this->delete($search);
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function approval($id){
        try{
            if(empty($id)) return "002";
            $arr['mb_stt'] = '2';
            return $this->set($arr,$id,"value");
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function blocking($id){
        try{
            if(empty($id)) return "002";
            $arr['mb_block_yn'] = 'y';
            return $this->set($arr,$id,"value");
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function sleep($id){
        try{
            $row = $this->get( "*", array("mb_id"=>$id) );
            $sleep = new \application\models\MemberSleepModel();
            $res1 = $sleep->add($row,"value");
            if( $res1 != "000" ){ return $res1; }
            $res2 = $this->remove( $id );
            if( $res2 == "000" ){ return $res2; }
            return "000";
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function wake($id){
        try{
            $sleep = new \application\models\MemberSleepModel();
            $row = $sleep->get( "*", array("mb_id"=>$id) );
            $res1 = $this->add($row,"value");
            if( $res1 != "000" ){ return $res1; }
            $res2 = $sleep->remove( $id );
            if( $res2 == "000" ){ return $res2; }
            return "000";
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function leave($id,$arr){
        try{
            $leave = new \application\models\MemberLeaveModel();
            $leave->add($arr);

            $res = $this->remove( $id );
            if( $res == "000" ){ return $res; }

            $sleep = new \application\models\MemberSleepModel();
            $res = $sleep->remove( $id );
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function login($id, $pw){
        try{
            if(empty($id)) return "002";
            if(empty($pw)) return "002";
            $row = $this->get("mb_id,mb_name,mb_passwd,mb_grade,mb_stt,mb_login_cnt,count(mb_id) as cnt", array("mb_id"=>$id));
            if( password_verify($pw, $row['mb_passwd']) ){
                if( $row['cnt'] >= 1 ){
                    if ( $row['mb_stt'] == 2 ){
                        $value['mb_last_login_dt'] = _DATE_YMDHIS;
                        $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                        $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
                        $res = $this->set($value,$id,"value");
                        if($res=="000"){
                            set_session("user_id",$row['mb_id']);
                            set_session("user_type",'member');
                            set_session("user_grade",$row['mb_grade']);
                            set_session("is_member","1");
                            return "000";
                        }else{
                            return "001";
                        }
                    }else{
                        return "103";
                    }
                }else{
                    return "100";
                }
            }else{
                return "102";
            }
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function savePoint($id,$point,$reason="기타 사유",$no=''){
        try{
            if($point < 0) $point *= -1;
            $res = $this->execute(" update {$this->tb_nm} set mb_point = mb_point + {$point} where mb_id ='$id' ");
            if( $res=="000" ){
                $value = array();
                $value['id'] = $id;
                $value['type'] = 1;
                $value['point'] = $point;
                $value['reason'] = $reason;
                $value['odNo'] = $no;
                $pointModel = new \application\models\MemberPointModel();
                $pointModel->pdo = $this->pdo;
                $res = $pointModel->add($value);
                if( $res!="000" ){
                    $resExtra = $this->execute(" update {$this->tb_nm} set mb_point = mb_point - {$point} where mb_id ='$id' ");
                }
            }
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function usePoint($id,$point,$reason="기타 사유",$no=''){
        try{
            $point = (int)$point;
            if($point < 0) $point *= -1;
            $row = $this->get("mb_point",array("mb_id"=>$id));
            if( $row['mb_point'] < $point ) return "{$point} {$id} 116";
            $value = array();
            $value['mb_point'] = $row['mb_point'] - $point;
            $res = $this->set($value,$id,"value");
            if( $res=="000" ){
                $value = array();
                $value['id'] = $id;
                $value['type'] = 2;
                $value['point'] = $point*-1;
                $value['odNo'] = $no;
                $value['reason'] = $reason;
                $pointModel = new \application\models\MemberPointModel();
                $res = $pointModel->add($value);
                if( $res!="000" ){
                    $value = array();
                    $value['mb_point'] = $row['mb_point'];
                    $this->set($value,$id,"value");
                }
            }
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }



}
?>
