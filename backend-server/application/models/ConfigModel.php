<?php
namespace application\models;

use \Exception;

class ConfigModel extends Model{
    public $colArr;
    
    function __construct( ){
        parent::__construct ( 'web_config' );
        $this->colArr = array(
            "delivery"=>"cf_delivery_company"
        );
 
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if( !empty($arr['keepConfirm']) )         $value['cf_keep_confirm_term'] = $arr['keepConfirm'];  
        if( !empty($arr['keepMisu']) )         $value['cf_keep_misu_term'] = $arr['keepMisu'];  
        if( !empty($arr['keepCart']) )         $value['cf_keep_cart_term'] = $arr['keepCart'];  
        if( !empty($arr['keepWish']) )         $value['cf_keep_wish_term'] = $arr['keepWish'];  
        if( !empty($arr['reviewOnly']) )         $value['cf_review_only_pt_yn'] = $arr['reviewOnly'];  
        if( !empty($arr['boardOnly']) )         $value['cf_board_only_pt_yn'] = $arr['boardOnly'];  
        if( !empty($arr['pcLogoWidth']) )         $value['cf_pc_logo_size_w'] = $arr['pcLogoWidth'];  
        if( !empty($arr['pcLogoHeight']) )         $value['cf_pc_logo_size_h'] = $arr['pcLogoHeight'];  
        if( !empty($arr['mLogoWidth']) )         $value['cf_m_logo_size_w'] = $arr['mLogoWidth'];  
        if( !empty($arr['mLogoHeight']) )         $value['cf_m_logo_size_h'] = $arr['mLogoHeight'];  
        if( !empty($arr['snsLogoWidth']) )         $value['cf_sns_logo_size_w'] = $arr['snsLogoWidth'];  
        if( !empty($arr['snsLogoHeight']) )         $value['cf_sns_logo_size_h'] = $arr['snsLogoHeight'];  
        if( !empty($arr['faviconWidth']) )         $value['cf_favicon_size_w'] = $arr['faviconWidth'];  
        if( !empty($arr['faviconHeight']) )         $value['cf_favicon_size_h'] = $arr['faviconHeight'];  
        if( !empty($arr['bannerWidth']) )         $value['cf_bn_size_w'] = $arr['bannerWidth'];  
        if( !empty($arr['bannerHeight']) )         $value['cf_bn_size_h'] = $arr['bannerHeight'];  
        if( !empty($arr['mBannerWidth']) )         $value['cf_m_bn_size_w'] = $arr['mBannerWidth'];  
        if( !empty($arr['mBannerHeight']) )         $value['cf_m_bn_size_h'] = $arr['mBannerHeight'];  
        if( !empty($arr['wideBannerWidth']) )         $value['cf_wide_bn_size_w'] = $arr['wideBannerWidth'];  
        if( !empty($arr['wideBannerHeight']) )         $value['cf_wide_bn_size_h'] = $arr['wideBannerHeight'];  
        if( !empty($arr['simgWidth']) )         $value['cf_simg_size_w'] = $arr['simgWidth'];  
        if( !empty($arr['simgHeight']) )         $value['cf_simg_size_h'] = $arr['simgHeight'];  
        if( !empty($arr['delivery']) )         $value['cf_delivery_company'] = json_encode($arr['delivery']);  
       return $value;
    }
/*
    function get($col='*'){
        $search = " and pt_id = 'admin' ";
        return $this->select( $col , $search );
    }
*/
    function set($arr){
        $value = $this->getValue($arr,'set');
        $search = " and  pt_id = 'admin' ";
        return $this->update($value,$search);
    }
}
?>
