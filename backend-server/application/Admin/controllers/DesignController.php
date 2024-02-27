<?php
namespace application\Admin\controllers;

class DesignController extends Controller{
    public $cnt;
    public $row;

    function init(){ 
        $this->col = "*";
    }

    //-------------------------------------
    public function bannerGroupList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->bannerGroup = new \application\models\BannerGroupModel();
        $this->cnt = $this->bannerGroup->getCnt();
    }

    public function addBannerGroup(){
        $this->header=false; $this->footer=false;
        $this->bannerGroup = new \application\models\BannerGroupModel();
        $res = $this->bannerGroup->add( $_POST );
        $msg = $res=="000" ? "배너가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function bannerGroupModify(){
        $this->bannerGroup = new \application\models\BannerGroupModel();
        $this->row = $this->bannerGroup->get($this->col, array("bngr_id"=>$this->param['ident']));
    }

    public function setBannerGroup(){
        $this->header=false; $this->footer=false;
        $this->bannerGroup = new \application\models\BannerGroupModel();
        $res = $this->bannerGroup->set( $_POST, $this->param['ident'] );
        $msg = $res=="000" ? "배너가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function removeBannerGroup(){
        $this->header=false; $this->footer=false;
        $this->bannerGroup = new \application\models\BannerGroupModel();
        $res = $this->bannerGroup->remove( $this->param['ident'] );
        $msg = $res=="000" ? "배너가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , urldecode($_GET['preUrl']) );
    }

    public function bannerList(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['device'])) $_REQUEST['device'] = "1";
        $bannerGroup = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroup->getNameList($_REQUEST['device']);
        $this->banner = new \application\models\BannerModel();
        $this->cnt = $this->banner->getCnt();
    }

    public function bannerModify(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();

        $this->banner = new \application\models\BannerModel();
        $this->row = $this->banner->get($this->col, array("bn_id"=>$this->param['ident']));
        $bannerGroup = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroup->getNameList($this->row['bn_device']);
    }

    public function bannerForm(){
        if( empty($_REQUEST['device'])) $_REQUEST['device'] = "1";
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $bannerGroup = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroup->getNameList($_REQUEST['device']);
    }

    public function addBanner(){
        $this->banner = new \application\models\BannerModel();
        $res = $this->banner->add( array_merge($_POST,$_FILES) );
        $msg = $res=="000" ? "배너가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Design/bannerList");
        access($msg , $_POST['preUrl']);
    }

    public function setBanner(){
        $this->banner = new \application\models\BannerModel();
        $res = $this->banner->set(array_merge($_POST,$_FILES),$this->param['ident']);
        $msg = $res=="000" ? "배너가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , _PRE_URL);
        access($msg , $_POST['preUrl']);
    }

    public function removeBanner(){
        $this->banner = new \application\models\BannerModel();
        $res = $this->banner->remove($this->param['ident']);
        $msg = $res=="000" ? "배너가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , empty($_GET['returnUrl'])?"/Design/bannerList":$_GET['returnUrl']);
    }

    public function bannerOdrPopup(){
        $this->header = "head";  $this->footer = false;
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->banner = new \application\models\BannerModel();
        //$_REQUEST['shop'] = "admin";
        //$_REQUEST['showYn'] = "y";
        if( empty($_REQUEST['position']) ) $_REQUEST['position'] = 1;
        $this->cnt = $this->banner->getCnt();
    }

    public function sortableBanner(){
        $this->header = "head";  $this->footer = false;
        $this->banner = new \application\models\BannerModel();
        $sortList = explode(",",$_POST['orderby']);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i+1;
            $res = $this->banner->move($arr,$arr['id']);
            if($res == "000") $success++;
        }
        $msg = $success > 0 ? "배너 순서가 변경되었습니다." : "실패\\n다시 시도 해주세요.";
        access($msg , "close");
    }

    public function goodsListPopup(){
        $this->header = "head";  $this->footer = false;
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $this->category = new \application\models\CategoryModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = 2;
        $this->goods = new \application\models\GoodsModel();
        $goods_list = $this->param['ident'];
        $goods_list = explode(",",$this->param['ident']);
        $goods_list = array_filter($goods_list);
        $goods_list = implode(",",$goods_list);
        if(!empty($goods_list)) $this->gsList = $this->goods->selectAll("*"," and gs_id in ( $goods_list ) ", " order by field(gs_id,$goods_list) ");
        else $this->gsList = array();
        $this->gsCnt = count($this->gsList);
    }

    // 기획전 관리------------------------------------------------------
    public function planList(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->plan = new \application\models\PlanModel();
        $this->cnt = $this->plan->getCnt();
    }

    public function planModify(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->plan = new \application\models\PlanModel();
        $this->goods = new \application\models\GoodsModel();

        $this->row = $this->plan->get($this->col, array("plan_id"=>$this->param['ident']));
        if( empty($_REQUEST['goodsId']) ) $_REQUEST['goodsId'] = $this->row['plan_goods_list'];
        $_REQUEST['col'] = "field";
    }

    public function planForm(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        if( empty($_REQUEST['goodsId']) ) $_REQUEST['goodsId'] = "";
    }

    public function addPlan(){
        $this->plan = new \application\models\PlanModel();
        $res = $this->plan->add($_POST);
        $msg = $res=="000" ? "기획전이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Design/planList");
        access($msg , $_POST['preUrl']);
    }

    public function setPlan(){
        $this->plan = new \application\models\PlanModel();
        $res = $this->plan->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "기획전이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Design/planList");
        access($msg , $_POST['preUrl']);
    }

    public function removePlan(){
        $this->plan = new \application\models\PlanModel();
        $res = $this->plan->remove($this->param['ident']);
        $msg = $res=="000" ? "기획전이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Design/planList");
        $returnUrl = !empty($_REQUEST['preUrl'])?$_REQUEST['preUrl']:"/Design/planList";
        access($msg , $returnUrl);
    }

    public function planOdrPopup(){
        $this->header = "head";  $this->footer = false;
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->plan = new \application\models\PlanModel();
        //$_REQUEST['shop'] = "admin";
        $_REQUEST['showYn'] = "y";
        $this->cnt = $this->plan->getCnt();
    }

    public function sortablePlan(){
        $this->header = "head";  $this->footer = false;
        $this->plan = new \application\models\PlanModel();
        $sortList = explode(",",$_POST['orderby']);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i+1;
            $res = $this->plan->move($arr,$arr['id']);
            if($res == "000") $success++;
        }
        $msg = $success > 0 ? "기획전 순서가 변경되었습니다." : "실패\\n다시 시도 해주세요.";
        access($msg , "close");
    }

    // 미디어 관리------------------------------------------------------
    public function mediaList(){
        $this->category = new \application\models\CategoryModel();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->media = new \application\models\MediaModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->media->getCnt();
    }

    public function mediaModify(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $this->media = new \application\models\MediaModel();
        $this->row = $this->media->get( $this->col, array("media_id"=>$this->param['ident']));
       if(empty($_REQUEST['goodsId'])) $_REQUEST['goodsId'] = $this->row['media_goods_list'];
    }

    public function mediaForm(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $this->media = new \application\models\MediaModel();
       if(empty($_REQUEST['goodsId'])) $_REQUEST['goodsId'] = "";
    }

    public function addMedia(){
        $this->media = new \application\models\MediaModel();
        $res = $this->media->add($_POST);
        $msg = $res=="000" ? "컨텐츠이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Design/mediaList");
    }

    public function setMedia(){
        $this->media = new \application\models\MediaModel();
        $res = $this->media->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "컨텐츠이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Design/mediaList");
    }

    public function removeMedia(){
        $this->media = new \application\models\MediaModel();
        $res = $this->media->remove($this->param['ident']);
        $msg = $res=="000" ? "컨텐츠이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Design/mediaList");
    }

    public function mediaOdrPopup(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->category = new \application\models\CategoryModel();
        $this->media = new \application\models\MediaModel();
        $this->header = "head";  $this->footer = false;
        //$_REQUEST['shop'] = "admin";
        $_REQUEST['showYn'] = "y";
        $this->cnt = $this->media->getCnt();
    }

    public function sortableMedia(){
        $this->header = "head";  $this->footer = false;
        $this->media = new \application\models\MediaModel();
        $sortList = explode(",",$_POST['orderby']);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i+1;
            $res = $this->media->move($arr,$arr['id']);
            if($res == "000") $success++;
        }
        $msg = $success > 0 ? "컨텐츠 순서가 변경되었습니다." : "실패\\n다시 시도 해주세요.";
        access($msg , "close");
    }


    // 팝업 관리------------------------------------------------------
    public function popupList(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->popup = new \application\models\PopupModel();
        $this->cnt = $this->popup->getCnt();
    }

    public function popupModify(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->popup = new \application\models\PopupModel();
        $this->row = $this->popup->get($this->col, array("pp_id"=>$this->param['ident']));
    }

    public function popupForm(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
    }
    
    public function addPopup(){
        $this->popup = new \application\models\PopupModel();
        $res = $this->popup->add($_POST);
        $msg = $res=="000" ? "팝업이 등록되었습니다." :  "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Design/popupList");
    }

    public function setPopup(){
        $this->popup = new \application\models\PopupModel();
        $res = $this->popup->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "팝업이 수정되었습니다." :  "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Design/popupList");
    }

    public function removePopup(){
        $this->popup = new \application\models\PopupModel();
        $res = $this->popup->remove($this->param['ident']);
        $msg = $res=="000" ? "팝업이 삭제되었습니다." :  "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function popupOdrPopup(){
        $this->header = "head";  $this->footer = false;
        $this->popup = new \application\models\PopupModel();
        //$_REQUEST['shop'] = "admin";
        $_REQUEST['showYn'] = "y";
        $this->cnt = $this->popup->getCnt();
    }

    public function sortablePopup(){
        $this->header = "head";  $this->footer = false;
        $this->popup = new \application\models\PopupModel();
        $sortList = explode(",",$_POST['orderby']);
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i+1;
            $res = $this->popup->move($arr,$arr['id']);
            $msg = $res ? "팝업 순서가 변경되었습니다." : "실패\\n다시 시도 해주세요.";
        }
        access($msg , "close");
    }

    // 쿠폰 관리------------------------------------------------------
    public function couponList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "cp_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $couponModel = new \application\models\CouponModel();
        $search = array();
        $search['cp_id_then_ge'] = "0";
        $search['rpp'] = $_REQUEST['rpp'];
        $search['page'] = $_REQUEST['page'];
        $search['col'] = $_REQUEST['col'];
        $search['colby'] = $_REQUEST['colby'];
        $cnt = $couponModel->get("count(cp_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];
        $this->row = $couponModel->get("*",$search,true);
    }

    public function couponForm(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();
    }

    public function couponModify(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();
        $couponModel = new \application\models\CouponModel();
        $this->row = $couponModel->get("*",array("cp_id"=>$this->param['ident']));
    }
    
    public function addCoupon(){
        $couponModel = new \application\models\CouponModel();
        $res = $couponModel->add($_POST);
        $msg = $res=="000" ? "쿠폰이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];

        $url = "/Design/couponList";
        if( !empty($_POST['returnUrl']) ) $url = $_POST['preUrl'];
        access($msg , $url);
    }
    public function setCoupon(){
        $couponModel = new \application\models\CouponModel();
        $res = $couponModel->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "쿠폰이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        
        #$url = "/Design/couponList";
        #if( !empty($_POST['returnUrl']) ) $url = $_POST['preUrl'];
        $url = get_return_url("/Design/couponList");
        access($msg , $url);
    }
    public function removeCoupon(){
    }


    public function couponFormUpdate(){
        $coupon = new \application\models\PopupModel();
        $mode = $_POST['mode'];
        if( isset($_POST['ini_begin_date']) || empty($_POST['begin_date_1']) || empty($_POST['begin_date_2']) ){
            $_POST['begin_date'] = '1970-01-01 00:00:00';
        }else{
            $_POST['begin_date'] = $_POST['begin_date_1']." ".$_POST['begin_date_2'];
        }

        if( isset($_POST['ini_end_date']) || empty($_POST['end_date_1']) || empty($_POST['end_date_2']) ){
            $_POST['end_date'] = '2200-01-01 00:00:00';
        }else{
            $_POST['end_date'] = $_POST['end_date_1']." ".$_POST['end_date_2'];
        }

        $value = $coupon->getValue($_POST,$mode);
        if($mode=="u"){
            $idx = $_POST['idx'];
            $this->query->update("web_coupon", $value, " and idx={$idx} " );
            access('수정 완료',_PRE_URL);
        }else{
            $this->query->insert("web_coupon", $value );
            access('추가 완료',_PRE_URL);
        }
    }

}
?>
