<?php
namespace application\Front\controllers;

class configController extends Controller{
    private $col;
    private $search;
    private $sql;
    
    public function init(){
        $this->col = array(
            "pt_id"=>"pt_id",
            "pt_name"=>"pt_name",
            "pt_sso_yn"=>"ifnull(pt_sso_yn,'n')",
            "pt_grade"=>"ifnull(pt_grade,10)",
            "pt_own_pg_yn"=>"ifnull(pt_own_pg_yn,'n')",
            "shop_url"=>"ifnull(shop_url,'')",
            "shop_title"=>"ifnull(shop_title,'')",
            "shop_description"=>"ifnull(shop_description,'')",
            "shop_use_ctg"=>"ifnull(shop_use_ctg,'')",
            "shop_head_tag"=>"ifnull(shop_head_tag,'')",
            "shop_body_tag"=>"ifnull(shop_body_tag,'')",
            "shop_pc_theme"=>"ifnull(shop_pc_theme,'basic')",
            "shop_m_theme"=>"ifnull(shop_m_theme,'basic')",
            "shop_gnb"=>"ifnull(shop_gnb,'')",
            "shop_main_layout"=>"ifnull(shop_main_layout,'')",
            "shop_company_name"=>"ifnull(shop_company_name,'')",
            "shop_company_owner"=>"ifnull(shop_company_owner,'')",
            "shop_company_saupja_no"=>"ifnull(shop_company_saupja_no,'')",
            "shop_company_tolsin_no"=>"ifnull(shop_company_tolsin_no,'')",
            "shop_company_tel"=>"ifnull(shop_company_tel,'')",
            "shop_company_email"=>"ifnull(shop_company_email,'')",
            "shop_company_addr"=>"ifnull(shop_company_addr,'')",
            "shop_customer_service_tel"=>"ifnull(shop_customer_service_tel,'')",
            "shop_customer_service_email"=>"ifnull(shop_customer_service_email,'')",
            "shop_customer_service_info"=>"ifnull(shop_customer_service_info,'')",
            "shop_sns_login_yn"=>"ifnull(shop_sns_login_yn,'n')",
            "shop_sns_login_naver_client_id"=>"ifnull(shop_sns_login_naver_client_id,'')",
            "shop_sns_login_naver_client_secret"=>"ifnull(shop_sns_login_naver_client_secret,'')",
            "shop_sns_login_kakao_api_key"=>"ifnull(shop_sns_login_kakao_api_key,'')",
            "shop_pg_service"=>"ifnull(shop_pg_service,'')",
            "shop_pg_mid"=>"ifnull(shop_pg_mid,'')",
            "shop_pg_key1"=>"ifnull(shop_pg_key1,'')",
            "shop_pg_key2"=>"ifnull(shop_pg_key2,'')",
            "shop_pg_test_yn"=>"ifnull(shop_pg_test_yn,'')",
            "shop_paymethod_card_yn"=>"ifnull(shop_paymethod_card_yn,'')",
            "shop_paymethod_iche_yn"=>"ifnull(shop_paymethod_iche_yn,'')",
            "shop_paymethod_vbank_yn"=>"ifnull(shop_paymethod_vbank_yn,'')",
            "shop_paymethod_hp_yn"=>"ifnull(shop_paymethod_hp_yn,'')",
            "shop_paymethod_bank_yn"=>"ifnull(shop_paymethod_bank_yn,'')",
            "shop_policy"=>"ifnull(shop_policy,'')",
            "shop_provision"=>"ifnull(shop_provision,'')",
            "shop_marketing"=>"ifnull(shop_marketing,'')",
            "shop_pc_logo"=>"if(shop_pc_logo != '', concat('"._LOGO."',shop_pc_logo), '')",
            "shop_m_logo"=>"if(shop_m_logo != '', concat('"._LOGO."',shop_m_logo), '')",
            "shop_favicon"=>"if(shop_favicon != '', concat('"._LOGO."',shop_favicon), '')",
            "shop_point_use_yn"=>"ifnull(shop_point_use_yn,'n')",
            "shop_min_point"=>"ifnull(shop_min_point,'0')",
            "shop_max_point"=>"ifnull(shop_max_point,'0')",
            "shop_coupon_use_yn"=>"ifnull(shop_coupon_use_yn,'n')",
        );
    }
    public function get(){
        if( empty($this->param['ident']) ) $this->result("002");

        $partnerModel = new \application\models\PartnerModel();
        $col = get_column_as($this->col,array(),false);
        $partnerRow = $partnerModel->get($col, array("pt_id"=>$this->shopId));
        if( empty($partnerRow) ) $this->result("001","가맹점 정보가 존재하지 않습니다.");
        if( !is_array($partnerRow) ) $this->result($partnerRow);
        $row = $partnerRow;

        $defaultModel = new \application\models\DefaultModel();
        $col = get_column_as($this->col,array("pt_id","pt_name","pt_sso_yn","pt_grade","pt_own_pg_yn"),false);
        $defaultRow = $defaultModel->get($col,array("pt_id"=>"admin"));
        foreach($defaultRow as $key=>$value){
            if( empty($row[$key]) && !empty($value) ) $row[$key] = $value;
        }

        if( $partnerRow['pt_own_pg_yn'] == "n" || $partnerRow['pt_own_pg_yn'] == "N" ){
            $row['shop_pg_service'] = $defaultRow['shop_pg_service'];
            $row['shop_pg_mid'] = $defaultRow['shop_pg_mid'];
            $row['shop_pg_key1'] = $defaultRow['shop_pg_key1'];
            $row['shop_pg_key2'] = $defaultRow['shop_pg_key2'];
            $row['shop_pg_test_yn'] = $defaultRow['shop_pg_test_yn'];
        }else{
            $row['shop_pg_service'] = $partnerRow['shop_pg_service'];
            $row['shop_pg_mid'] = $partnerRow['shop_pg_mid'];
            $row['shop_pg_key1'] = $partnerRow['shop_pg_key1'];
            $row['shop_pg_key2'] = $partnerRow['shop_pg_key2'];
            $row['shop_pg_test_yn'] = $partnerRow['shop_pg_test_yn'];
        }
        $row['shop_use_ctg'] = unserialize($row['shop_use_ctg']);
        $row['shop_customer_service_info'] = unserialize($row['shop_customer_service_info']);
        $row['shop_head_tag'] = stripslashes($row['shop_head_tag']);
        $row['shop_body_tag'] = stripslashes($row['shop_body_tag']);

        $configModel = new \application\models\ConfigModel();
        $configRow = $configModel->get("cf_delivery_company",array("cf_id"=>1));
        $configRow['cf_delivery_company'] = json_decode($configRow['cf_delivery_company'],true);
        $this->response_json("000",array("data"=>array_merge($row,$configRow)));
    }

}
?>
