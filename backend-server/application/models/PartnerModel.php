<?php
namespace application\models;

use \Exception;

class PartnerModel extends Model{
    public $colArr;

    function __construct( ){
        parent::__construct ( 'web_partner' );
        $this->colArr = array(
            "shopId"=>"pt_id",
            "shopName"=>"pt_name",
            "shopGrade"=>"pt_grade",
            "logo"=>"concat('"._LOGO."',shop_pc_logo)",
            "mLogo"=>"concat('"._LOGO."',shop_m_logo)",
            "favicon"=>"concat('"._LOGO."',shop_favicon)",
            "useCtg"=>"shop_use_ctg",
            "gnb"=>"shop_gnb",
            "main"=>"shop_main_layout",
            "pcTheme"=>"shop_pc_theme",
            "mTheme"=>"shop_m_theme",
            "title"=>"shop_title",
            "description"=>"shop_description",
            "headTag"=>"shop_head_tag",
            "bodyTag"=>"shop_body_tag",
            "companyName"=>"shop_company_name",
            "companyOwner"=>"shop_company_owner",
            "saupjaNo"=>"shop_company_saupja_no",
            "tolsinNo"=>"shop_company_tolsin_no",
            "companyTel"=>"shop_company_tel",
            "companyEmail"=>"shop_company_email",
            "companyAddr"=>"shop_company_addr",
            "csTel"=>"shop_customer_service_tel",
            "csEmail"=>"shop_customer_service_email",
            "csInfo"=>"shop_customer_service_info",
            "snsLogin"=>"shop_sns_login_yn",
            "loginNaverClientId"=>"shop_sns_login_naver_client_id",
            "loginNaverClientSecret"=>"shop_sns_login_naver_client_secret",
            "loginKakaoApiKey"=>"shop_sns_login_kakao_api_key",
            "pgService"=>"shop_pg_service",
            "pgMid"=>"shop_pg_mid",
            "pgClientKey"=>"shop_pg_key1",
            "pgSecretKey"=>"shop_pg_key2",
            "pgTestYn"=>"shop_pg_test_yn",
            "cardYn"=>"shop_paymethod_card_yn",
            "icheYn"=>"shop_paymethod_iche_yn",
            "vbankYn"=>"shop_paymethod_vbank_yn",
            "hpYn"=>"shop_paymethod_hp_yn",
            "bankYn"=>"shop_paymethod_bank_yn",
            "policy"=>"shop_policy",
            "provision"=>"shop_provision",
            "marketing"=>"shop_marketing",
            "pointYn"=>"shop_point_use_yn",
            "minPoint"=>"shop_min_point",
            "maxPoint"=>"shop_max_point",
        );
 
    }

    function getValue($arr, $mode='add'){
        if( empty($arr) ) return;

        if( $mode == "add" ){
            if( empty($arr['id']) ) return;
            $value['pt_id'] = $arr['id']; // 가맹점 아이디
            $value['pt_reg_dt'] = _DATE_YMDHIS; // 가맹점 가입 일시
            $value['pt_stt'] = 1; // 대기 상태
            $value['pt_grade'] = 9;
            $value['pt_own_pg_yn'] = 'n'; // 개별 PG 사용 여부
            $value['pt_own_gs_yn'] = 'n'; // 가맹점 상품 판매 허용 여부
        }
        if( !empty($arr['name']) )          $value['pt_name'] = $arr['name']; // 가맹점 이름
        if( !empty($arr['sso']) )           $value['pt_sso_yn'] = $arr['sso']; // 가맹점 회원 정보 동기화 여부
        if( !empty($arr['ssoMethod']) )     $value['pt_sso_method'] = $arr['ssoMethod']; 
        if( !empty($arr['encIv']) )         $value['pt_sso_enc_iv'] = $arr['encIv']; 
        if( !empty($arr['encKey']) )        $value['pt_sso_enc_key'] = $arr['encKey']; 
        if( !empty($arr['passwd']) )        $value['pt_passwd'] = password($arr['passwd']); // 가맹점 비밀번호
        if( !empty($arr['grade']) )         $value['pt_grade'] = $arr['grade']; // 가맹점 가격 정책 등급
        if( !empty($arr['state']) )         $value['pt_stt'] = $arr['state']; // 가맹점 상태
        if( !empty($arr['ownpg']) )         $value['pt_own_pg_yn'] = $arr['ownpg']; // 개별 PG 사용 여부
        if( !empty($arr['owngs']) )         $value['pt_own_gs_yn'] = $arr['owngs']; // 개별 상품 판매 허용 여부
        if( !empty($arr['rate']) )          $value['pt_pay_rate'] = $arr['rate']; // 가맹점 수수료
        if( !empty($arr['bank']) )          $value['pt_bank_info'] = serialize($arr['bank']); // 정산 계좌 정보
        if( !empty($arr['bankFile']) )      $value['pt_bank_file'] = $arr['bankFile']; // 정산 통장 사본
        if( !empty($arr['manager']) )       $value['pt_manager'] = serialize($arr['manager']);
        if( !empty($arr['url']) )           $value['shop_url'] = $arr['url']; // 쇼핑몰 도메인
        if( !empty($arr['title']) )         $value['shop_title'] = $arr['title']; // 브라우저 타이틀
        if( !empty($arr['description']) )   $value['shop_description'] = $arr['description'];
        if( !empty($arr['headTag']) )       $value['shop_head_tag'] = $arr['headTag'];
        if( !empty($arr['bodyTag']) )       $value['shop_body_tag'] = $arr['bodyTag'];
        if( !empty($arr['ctg2']) )          $value['shop_use_ctg'] = serialize($arr['ctg2']);
        if( !empty($arr['pctheme']) )       $value['shop_pc_theme'] = $arr['pctheme'];
        if( !empty($arr['mtheme']) )        $value['shop_m_theme'] = $arr['mtheme'];
        if( !empty($arr['companyType']) )   $value['shop_company_type'] = $arr['companyType'];
        if( !empty($arr['companyName']) )   $value['shop_company_name'] = $arr['companyName'];
        if( !empty($arr['owner']) )         $value['shop_company_owner'] = $arr['owner'];
        if( !empty($arr['saupjaNo']) )      $value['shop_company_saupja_no'] = $arr['saupjaNo'];
        //if( !empty($arr['saupjaFile']) )    $value['shop_company_saupja_file'] = $arr['saupjaFile'];
        if( !empty($arr['tolsinNo']) )      $value['shop_company_tolsin_no'] = $arr['tolsinNo'];
        //if( !empty($arr['tolsinFile']) )    $value['shop_company_tolsin_file'] = $arr['tolsinFile'];
        if( !empty($arr['companyItem']) )   $value['shop_company_item'] = $arr['companyItem'];
        if( !empty($arr['companyService']) )    $value['shop_company_service'] = $arr['companyService'];
        if( !empty($arr['companyTel']) )    $value['shop_company_tel'] = $arr['companyTel'];
        if( !empty($arr['companyFax']) )    $value['shop_company_fax'] = $arr['companyFax'];
        if( !empty($arr['companyEmail']) )  $value['shop_company_email'] = $arr['companyEmail'];
        if( !empty($arr['companyAddr']) )   $value['shop_company_addr'] = $arr['companyAddr'];
        if( !empty($arr['info']) )          $value['shop_info_manager'] = serialize($arr['info']);
        if( !empty($arr['point']) )         $value['shop_point_use_yn'] = $arr['point'];
        if( !empty($arr['minPoint']) )      $value['shop_min_point'] = $arr['minPoint'];
        if( !empty($arr['maxPoint']) )      $value['shop_max_point'] = $arr['maxPoint'];
        if( !empty($arr['coupon']) )        $value['shop_coupon_use_yn'] = $arr['coupon'];
        if( !empty($arr['snsLogin']) )      $value['shop_sns_login_yn'] = $arr['snsLogin'];
        if( !empty($arr['loginNaverClientId']) )      $value['shop_sns_login_naver_client_id'] = $arr['loginNaverClientId'];
        if( !empty($arr['loginNaverClientSecret']) )      $value['shop_sns_login_naver_client_secret'] = $arr['loginNaverClientSecret'];
        if( !empty($arr['loginKakaoApiKey']) )      $value['shop_sns_login_kakao_api_key'] = $arr['loginKakaoApiKey'];
        if( !empty($arr['gnb']) )           $value['shop_gnb'] = json_encode($arr['gnb']);
        if( !empty($arr['mainLayout']) )    $value['shop_main_layout'] = json_encode($arr['mainLayout']);

        if( !empty($arr['pgService']) )     $value['shop_pg_service'] = $arr['pgService'];
        if( !empty($arr['pgTest']) )        $value['shop_pg_test_yn'] = $arr['pgTest'];
        if( !empty($arr['bankYn']) )          $value['shop_paymethod_bank_yn'] = $arr['bankYn'];
        if( !empty($arr['cardYn']) )          $value['shop_paymethod_card_yn'] = $arr['cardYn'];
        if( !empty($arr['vbankYn']) )         $value['shop_paymethod_vbank_yn'] = $arr['vbankYn'];
        if( !empty($arr['icheYn']) )          $value['shop_paymethod_iche_yn'] = $arr['icheYn'];
        if( !empty($arr['hpYn']) )            $value['shop_paymethod_hp_yn'] = $arr['hpYn'];
        if( !empty($arr['pgMid']) )           $value['shop_pg_mid'] = $arr['pgMid'];
        if( !empty($arr['pgKey1']) )          $value['shop_pg_key1'] = $arr['pgKey1'];
        if( !empty($arr['pgKey2']) )          $value['shop_pg_key2'] = $arr['pgKey2'];
        if( !empty($arr['policy']) )          $value['shop_policy'] = $arr['policy'];
        if( !empty($arr['provision']) )       $value['shop_provision'] = $arr['provision'];
        if( !empty($arr['marketing']) )       $value['shop_marketing'] = $arr['marketing'];
        if( !empty($arr['memo']) )          $value['pt_adm_memo'] = $arr['memo'];

        try{
            $upl = new \application\models\UploadFile(_ROOT._FILE);
            if( !empty($_FILES['saupjaFile']) && !empty($_FILES['saupjaFile']['name'])  ){
                $filename = $upl->upload($_FILES['saupjaFile']);
                if(!empty($filename)) $value['shop_company_saupja_file'] = $filename;
            }
            if( !empty($_FILES['tolsinFile']) && !empty($_FILES['tolsinFile']['name'])  ){
                $filename = $upl->upload($_FILES['tolsinFile']);
                if(!empty($filename)) $value['shop_company_tolsin_file'] = $filename;
            }
        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }


        try{
            $upl = new \application\models\UploadImage(_ROOT._LOGO);

            if( !empty($arr['pclogo_del']) )    $upl->del($arr['pclogo_del']);
            if( !empty($arr['mlogo_del']) )     $upl->del($arr['mlogo_del']);
            if( !empty($arr['snslogo_del']) )   $upl->del($arr['snslogo_del']);
            if( !empty($arr['fav_del']) )       $upl->del($arr['fav_del']);
            if( !empty($_FILES['pclogo']) && !empty($_FILES['pclogo']['name']) ){
                $filename = $upl->upload($_FILES['pclogo']);
                if(!empty($filename)) $value['shop_pc_logo'] = $filename; // PC버전 로고
            }

            if( !empty($_FILES['mlogo']) && !empty($_FILES['mlogo']['name'])  ){
                $filename = $upl->upload($_FILES['mlogo']);
                if(!empty($filename)) $value['shop_m_logo'] = $filename; // 모바일 버전 로고
            }

            if( !empty($_FILES['snslogo']) && !empty($_FILES['snslogo']['name'])  ){
                $filename = $upl->upload($_FILES['snslogo']);
                if(!empty($filename)) $value['shop_sns_logo'] = $filename; // SNS 썸네일
            }
            if( !empty($_FILES['fav']) && !empty($_FILES['fav']['name'])  ){
                $filename = $upl->upload($_FILES['fav']);
                if(!empty($filename)) $value['shop_favicon'] = $filename; // 쇼핑몰 파비콘
            }

        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) &&  !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("pt_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" ) $this->getSearch("pt_name",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['state']) ) $this->getParameter("pt_stt",$_REQUEST['state']);
        if( !empty($_REQUEST['grade']) && $_REQUEST['grade'] != "all")  $this->getParameter("pt_grade",$_REQUEST['grade']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("pt_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("pt_reg_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "appDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("pt_app_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("pt_app_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "expDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("pt_exp_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("pt_exp_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by pt_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            else if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by pt_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'appDate' ) $this->sql_order = " order by pt_app_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'expDate' ) $this->sql_order = " order by pt_exp_dt {$_REQUEST['colby']} ";
        }
    }
/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $search = " and pt_id = '{$id}' ";
        return $this->select( $col, $search );
    }
 */

    function set($arr, $id, $type="arr"){
        if(empty($arr)) return "002";
        if(empty($id)) $id = $arr['id'];
        if(empty($id)) return "002";
        $this->preValue = $this->get("*",array("pt_id"=>$id) );
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and pt_id = '{$id}' ";
        $res = $this->update($value,$search);

        if($res=="000"){
            $exclude = array('pt_idx,pt_passwd');
            $data = $this->addLog($id,$value,$exclude);
        }
        return $res;
    }

    function resetLayout($id){
        $value = array("shop_gnb"=>"","shop_main_layout"=>"");
        return $this->set($value,$id,"value");
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $user = new \application\models\UserModel();
        if( !$user->overChk('user_id', $value['pt_id']) ) return "003";
        $res = $user->add(array("id"=>$value['pt_id'],"type"=>"Partner"));
        if($res != "000") return "003";

        $res = $this->insert($value);
        if( $res == "000" ){
            //$data = $this->addLog($id,$value);
        }
        return $res;
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and pt_id = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }

    function getNameList($sso_yn="a", $state="y"){
        $search = array();
        if( $sso_yn =="y" || $sso_yn=="n" ){
            $search['pt_sso_yn'] = $sso_yn;
        }
        if( $state == "y" ){
            $search['pt_stt'] = "2";
        }else{
            $search['pt_stt_then_ge'] = "2";
        }
        $search['col'] = "pt_app_dt";
        $search['colby'] = "asc";
        $rowAll = $this->get("pt_id,pt_name",$search,true);
        $pt_li = array();
        foreach($rowAll as $row){
            $pt_li[$row['pt_id']] = $row['pt_name'];
        }
        return $pt_li;
    }   

    function expire($id){
        if( empty($id) ) return "002";
        $arr['pt_stt'] = '3';
        $arr['pt_exp_dt'] = _DATE_YMDHIS;
        $res = $this->set($arr,$id,"value");
        if($res=="000"){
            $member = new \application\models\MemberModel();
            $member->execute("update ".$this->tb_nm." SET mb_block_yn='y' where pt_id='{$id}'");
            // 디자인 정보 삭제
        }
        return $res;
    }

    function approval($id){
        if( empty($id) ) return "002";
        $arr['pt_stt'] = '2';
        $arr['pt_app_dt'] = _DATE_YMDHIS;
        return $this->set($arr,$id,"value");
    }

    function login($id, $pw){
        if( empty($id) ) return "002";
        if( empty($pw) ) return "002";
        $row = $this->get("pt_id,pt_name,pt_stt,pt_passwd,pt_grade,pt_login_cnt,count(pt_id) as cnt", array("pt_id"=>$id));
        if( password_verify($pw, $row['pt_passwd']) ){
            if( $row['cnt'] >= 1 && $row['pt_stt'] == 2 ){
                $value['pt_last_login_dt'] = _DATE_YMDHIS;
                $value['pt_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['pt_login_cnt'] = $row['pt_login_cnt']+1;
                $search = " and pt_id = '{$id}' ";
                $res = $this->update($value,$search);
                if($res=="000"){
                    set_session("is_partner","1");
                    set_session("user_id",$row['pt_id']);
                    set_session("user_name",$row['pt_name']);
                    set_session("user_type",'partner');
                    set_session("user_grade",$row['pt_grade']);
                    return "000";
                }else{
                    return "001";
                }
            }
        }else{
            return false;
        }
    }

}
?>
