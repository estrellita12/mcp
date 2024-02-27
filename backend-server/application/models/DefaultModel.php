<?php
namespace application\models;

use \Exception;

class DefaultModel extends Model{
    public $colArr;

    function __construct( ){
        parent::__construct ( 'web_default' );
        $this->colArr = array(
            "shopId"=>"pt_id",
            "shopName"=>"pt_name",
            "shopGrade"=>"pt_grade",
            "logo"=>"concat('"._LOGO."',shop_pc_logo)",
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
            "pgTestYn"=>"shop_pg_test_yn",
            "cardYn"=>"shop_paymethod_card_yn",
            "icheYn"=>"shop_paymethod_iche_yn",
            "vbankYn"=>"shop_paymethod_vbank_yn",
            "hpYn"=>"shop_paymethod_hp_yn",
            "bankYn"=>"shop_paymethod_bank_yn",
            "policy"=>"shop_policy",
            "provision"=>"shop_provision",
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
        else $value['pt_sso_yn'] = 'n';
        if( !empty($arr['passwd']) )        $value['pt_passwd'] = $arr['passwd']; // 가맹점 비밀번호
        if( !empty($arr['grade']) )         $value['pt_grade'] = $arr['grade']; // 가맹점 가격 정책 등급
        if( !empty($arr['state']) )         $value['pt_stt'] = $arr['state']; // 가맹점 상태
        //$value['pt_app_dt'] = _DATE_YMDHIS; // 가맹점 승인 일시
        //$value['pt_exp_dt'] = _DATE_YMDHIS; // 가맹점 만료 일시
        if( !empty($arr['ownpg']) )         $value['pt_own_pg_yn'] = $arr['ownpg']; // 개별 PG 사용 여부
        if( !empty($arr['owngs']) )         $value['pt_own_gs_yn'] = $arr['owngs']; // 개별 상품 판매 허용 여부
        if( !empty($arr['rate']) )          $value['pt_pay_rate'] = $arr['rate']; // 가맹점 수수료
        if( !empty($arr['bank']) )          $value['pt_bank_info'] = serialize($arr['bank']); // 정산 계좌 정보
        if( !empty($arr['bankFile']) )      $value['pt_bank_file'] = $arr['bankFile']; // 정산 통장 사본
        if( !empty($arr['manager']) )       $value['pt_manager'] = serialize($arr['manager']);
        if( !empty($arr['url']) )           $value['shop_url'] = $arr['url']; // 쇼핑몰 도메인
        if( !empty($arr['title']) )         $value['shop_title'] = $arr['title']; // 브라우저 타이틀
        if( !empty($arr['description']) )   $value['shop_description'] = $arr['description'];
        if( isset($arr['headTag']) )       $value['shop_head_tag'] = $arr['headTag'];
        if( isset($arr['bodyTag']) )       $value['shop_body_tag'] = $arr['bodyTag'];
        if( !empty($arr['ctg2']) )          $value['shop_use_ctg'] = serialize($arr['ctg2']);
        if( !empty($arr['pctheme']) )       $value['shop_pc_theme'] = $arr['pctheme'];
        if( !empty($arr['mtheme']) )        $value['shop_m_theme'] = $arr['mtheme'];
        if( !empty($arr['companyType']) )   $value['shop_company_type'] = $arr['companyType'];
        if( !empty($arr['companyName']) )   $value['shop_company_name'] = $arr['companyName'];
        if( !empty($arr['owner']) )         $value['shop_company_owner'] = $arr['owner'];
        if( !empty($arr['saupjaNo']) )      $value['shop_company_saupja_no'] = $arr['saupjaNo'];
        if( !empty($arr['saupjaFile']) )    $value['shop_company_saupja_file'] = $arr['saupjaFile'];
        if( !empty($arr['tolsinNo']) )      $value['shop_company_tolsin_no'] = $arr['tolsinNo'];
        if( !empty($arr['tolsinFile']) )    $value['shop_company_tolsin_file'] = $arr['tolsinFile'];
        if( !empty($arr['companyItem']) )   $value['shop_company_item'] = $arr['companyItem'];
        if( !empty($arr['companyService']) )    $value['shop_company_service'] = $arr['companyService'];
        if( !empty($arr['companyTel']) )    $value['shop_company_tel'] = $arr['companyTel'];
        if( !empty($arr['companyFax']) )    $value['shop_company_fax'] = $arr['companyFax'];
        if( !empty($arr['companyEmail']) )  $value['shop_company_email'] = $arr['companyEmail'];
        if( !empty($arr['companyAddr']) )   $value['shop_company_addr'] = $arr['companyAddr'];
        if( !empty($arr['info']) )          $value['shop_info_manager'] = serialize($arr['info']);
        if( !empty($arr['cs']) )            $value['shop_customer_service_info'] = serialize($arr['cs']);
        if( !empty($arr['csTel']) )         $value['shop_customer_service_tel'] = $arr['csTel'];
        if( !empty($arr['csEmail']) )       $value['shop_customer_service_email'] = $arr['csEmail'];
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
        if( !empty($arr['card']) )          $value['shop_paymethod_card_yn'] = $arr['card'];
        if( !empty($arr['vbank']) )         $value['shop_paymethod_vbank_yn'] = $arr['vbank'];
        if( !empty($arr['iche']) )          $value['shop_paymethod_iche_yn'] = $arr['iche'];
        if( !empty($arr['hp']) )            $value['shop_paymethod_hp_yn'] = $arr['hp'];
        if( !empty($arr['pgMid']) )           $value['shop_pg_mid'] = $arr['pgMid'];
        if( !empty($arr['pgKey1']) )          $value['shop_pg_key1'] = $arr['pgKey1'];
        if( !empty($arr['pgKey2']) )          $value['shop_pg_key2'] = $arr['pgKey2'];
        if( !empty($arr['policy']) )          $value['shop_policy'] = $arr['policy'];
        if( !empty($arr['provision']) )       $value['shop_provision'] = $arr['provision'];

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

    public function set($arr ){
        if( empty($arr) ) return "002";
        $this->preValue = $this->get("*", array("pt_id"=>"admin"));
        $value = $this->getValue($arr,'set');

        $search = " and df_id = '1' ";
        $res = $this->update($value,$search);

        if($res=="000"){
            $exclude = array('df_update_dt');
            $data = $this->addLog("1",$value,$exclude,"수정");
        }
        return $res;
    }
}
?>
