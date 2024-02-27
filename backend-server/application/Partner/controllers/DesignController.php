<?php
namespace application\Partner\controllers;

class DesignController extends Controller{
    public $col;
    public $search;
    public $sql;

    public function init(){ 
        $this->col = "*";
        $this->search = array();
        $this->sql = "";

        $this->categoryModel = new \application\models\CategoryModel();
        $sql = "";
        if(empty($this->my['shop_use_ctg'])){
            $defaultModel = new \application\models\DefaultModel();
            $default = $defaultModel->get("shop_use_ctg",array("pt_id"=>"admin"));
            $this->my['shop_use_ctg'] = $default['shop_use_ctg'];
        }
        $this->my['shop_use_ctg'] = unserialize($this->my['shop_use_ctg']);
        foreach( $this->my['shop_use_ctg'] as $row ){
            $d1 = substr($row,0,3);
            if( !empty($sql) ) $sql .= "or";
            $sql .= " ( ctg_id like '{$d1}%') ";
        }
        $sql = " and ({$sql}) ";
        $this->categoryDepth1 = $this->categoryModel->get("ctg_id,ctg_title",array("ctg_id_length_"=>"3"),true,$sql);
    }

    public function bannerList(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");
        if( empty($_REQUEST['device'])) $_REQUEST['device'] = "1";
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "bn_orderby";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "asc";

        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['col'] = $_REQUEST['col'];
        $this->search['colby'] = $_REQUEST['colby'];
        $this->search['bn_device'] = $_REQUEST['device'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        /*
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = $_REQUEST['beg']." 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = $_REQUEST['end']." 23:59:59";
        }
         */
        if( !empty($_REQUEST['position']) ){
            $this->search['bn_position'] = $_REQUEST['position'];
        }

        $bannerGroupModel = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroupModel->getNameList($_REQUEST['device']);
        $this->bannerModel = new \application\models\BannerModel();
        $row = $this->bannerModel->get("count(bn_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];

    }

    public function bannerModify(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");
        $bannerModel = new \application\models\BannerModel();
        $this->row = $bannerModel->get($this->col, array("bn_id"=>$this->param['ident']));
        $bannerGroupModel = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroupModel->getNameList($this->row['bn_device']);
    }

    public function bannerForm(){
        if( empty($_REQUEST['device'])) $_REQUEST['device'] = "1";
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");
        $bannerGroupModel = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroupModel->getNameList($_REQUEST['device']);
    }

    public function addBanner(){
        $bannerModel = new \application\models\BannerModel();
        $_POST['shop'] = $this->my['pt_id'];
        $res = $bannerModel->add( array_merge($_POST,$_FILES) );
        $msg = $res=="000" ? "배너가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function setBanner(){
        $bannerModel = new \application\models\BannerModel();
        $_POST['shop'] = $this->my['pt_id'];
        $res = $bannerModel->set(array_merge($_POST,$_FILES),$this->param['ident']);
        $msg = $res=="000" ? "배너가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function removeBanner(){
        $bannerModel = new \application\models\BannerModel();
        $res = $bannerModel->remove($this->param['ident']);
        $msg = $res=="000" ? "배너가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , empty($_GET['returnUrl'])?"/Design/bannerList":$_GET['returnUrl']);
    }

    public function bannerOdrPopup(){
        $this->header = "head";  $this->footer = false;
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");
        if( empty($_REQUEST['device'])) $_REQUEST['device'] = "1";
        if( empty($_REQUEST['position']) ) $_REQUEST['position'] = 1;
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;

        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['bn_device'] = $_REQUEST['device'];
        $this->search['col'] = "bn_orderby";
        $this->search['colby'] = "asc";
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['position']) ){
            $this->search['bn_position'] = $_REQUEST['position'];
        }

        $bannerGroupModel = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroupModel->getNameList($_REQUEST['device']);
        $this->bannerModel = new \application\models\BannerModel();
        $row = $this->bannerModel->get("count(bn_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
    }

    public function sortableBanner(){
        $this->header = "head";  $this->footer = false;
        $bannerModel = new \application\models\BannerModel();
        $sortList = array_filter(explode(",",$_POST['orderby']));
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i;
            $res = $bannerModel->move($arr,$arr['id']);
            if($res == "000") $success++;
        }
        $msg = $success > 0 ? "배너 순서가 변경되었습니다." : "실패\\n{$GLOBALS['res_code'][$res]}";
        access($msg , "close");
    }

    public function goodsListPopup(){
        $this->header = "head";  $this->footer = false;
        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $this->header = "head"; $this->footer=false;
        $this->categoryModel = new \application\models\CategoryModel();
        $sql = "";
        foreach($this->my['shop_use_ctg'] as $ctg){
            if( !empty($sql) ) $sql .= " or ";
            $sql .= " ( gs_ctg like '{$ctg}%' or  gs_ctg2 like '{$ctg}%' or  gs_ctg3 like '{$ctg}%' ) ";
        }
        $this->sql = " and ( {$sql} ) ";

        $this->goodsModel = new \application\models\GoodsModel();
        $this->selected = array();
        if( !empty($this->param['ident']) ){
            $goods_list = $this->param['ident'];
            $goods_list = explode(",",$this->param['ident']);
            $goods_list = array_filter($goods_list);
            $goods_list = implode(",",$goods_list);
            $search = array();
            $search['gs_id_in_all'] = $goods_list;
            $search['col'] = "  field (gs_id,{$goods_list}) ";
            $this->selected = $this->goodsModel->get("*", $search, true,$this->sql );
        }
        $this->selectedCnt = count($this->selected);
        $this->search['gs_stt'] = "2";
        if( !empty($_REQUEST['ctg']) ){
            $this->sql .= " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }

        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['geQty']) ) $this->search["gs_stock_qty_then_ge"] = $_REQUEST['geQty']; 
        if( !empty($_REQUEST['leQty']) ) $this->search["gs_stock_qty_then_le"] = $_REQUEST['leQty']; 
        if( !empty($_REQUEST['gePrice']) ) $this->search["gs_price_then_ge"] = $_REQUEST['gePrice']; 
        if( !empty($_REQUEST['lePrice']) ) $this->search["gs_price_then_le"] = $_REQUEST['lePrice']; 

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "gs_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        $cnt = $this->goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
    }

    public function planList(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "plan_orderby";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "asc";

        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['col'] = $_REQUEST['col'];
        $this->search['colby'] = $_REQUEST['colby'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = $_REQUEST['beg']." 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = $_REQUEST['end']." 23:59:59";
        }
        $this->planModel = new \application\models\PlanModel();
        $row = $this->planModel->get("count(plan_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
    }

    public function planModify(){
        $planModel = new \application\models\PlanModel();
        $this->row = $planModel->get($this->col, array("plan_id"=>$this->param['ident']));
        $this->goodsModel = new \application\models\GoodsModel();
        if( empty($_REQUEST['goodsId']) ) $_REQUEST['goodsId'] = $this->row['plan_goods_list'];
        $this->search['gs_id_in_'] = $_REQUEST['goodsId'];
        $this->search['col'] = "  field (gs_id,{$_REQUEST['goodsId']}) ";
        $row = $this->goodsModel->get("count(gs_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
    }

    public function planForm(){
        $this->goodsModel = new \application\models\GoodsModel();
        if( !empty($_REQUEST['goodsId']) ) {
            $this->search['gs_id_in_'] = $_REQUEST['goodsId'];
            $this->search['col'] = "  field (gs_id,{$_REQUEST['goodsId']}) ";
            $cnt = $this->goodsModel->get("count(gs_id) as cnt",$this->search);
            $this->cnt = $cnt['cnt'];
        }
    }

    public function addPlan(){
        $planModel = new \application\models\PlanModel();
        $_POST['shop'] = $this->my['pt_id'];
        $res = $planModel->add($_POST);
        $msg = $res=="000" ? "기획전이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function setPlan(){
        $planModel = new \application\models\PlanModel();
        $_POST['shop'] = $this->my['pt_id'];
        $res = $planModel->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "기획전이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function removePlan(){
        $planModel = new \application\models\PlanModel();
        $res = $planModel->remove($this->param['ident']);
        $msg = $res=="000" ? "기획전이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Design/planList");
        access($msg , $_GET['preUrl']);
    }

    public function planOdrPopup(){
        $this->header = "head";  $this->footer = false;
        $this->pt_li = $this->partnerModel->getNameList("a");
        $this->planModel = new \application\models\PlanModel();
        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['col'] = "plan_orderby";
        $this->search['colby'] = "desc";
        $this->search['plan_show_yn'] = "y";
        $row = $this->planModel->get("count(plan_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
    }

    public function sortablePlan(){
        $this->header = false;  $this->footer = false;
        $planModel = new \application\models\PlanModel();
        $sortList = explode(",",$_POST['orderby']);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i+1;
            $res = $planModel->move($arr,$arr['id']);
            if($res == "000") $success++;
        }
        $msg = $success > 0 ? "기획전 순서가 변경되었습니다." : "실패\\n다시 시도 해주세요.";
        access($msg , "close");
    }

    // 미디어 관리------------------------------------------------------
    public function mediaList(){
        $this->pt_li = $this->partnerModel->getNameList("a");
        $mediaModel = new \application\models\MediaModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['pt_id'] = $this->my['pt_id'];
        $cnt = $mediaModel->get("count(media_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $mediaModel->get($this->col,$this->search,true,$this->sql);
    }

    public function mediaForm(){
        $this->selectedList = array();
        $this->cnt = 0;
        if( !isset($_REQUEST['goodsId']) ) $_REQUEST['goodsId'] = "";
        if( !empty($_REQUEST['goodsId']) ){
            $goodsModel = new \application\models\GoodsModel();
            $sql = "";
            foreach($this->my['shop_use_ctg'] as $ctg){
                if( !empty($sql) ) $sql .= " or ";
                $sql .= " ( gs_ctg like '{$ctg}%' or  gs_ctg2 like '{$ctg}%' or  gs_ctg3 like '{$ctg}%' ) ";
            }
            $this->sql = " and ( {$sql} ) ";

            if( empty($_REQUEST['goodsId']) ) $_REQUEST['goodsId'] = "";
            $this->search['gs_id_in_all'] = $_REQUEST['goodsId'];
            $this->search['col'] = "  field (gs_id,{$_REQUEST['goodsId']}) ";
            $this->search['gs_stt'] = "2";
            $row = $goodsModel->get("count(gs_id) as cnt",$this->search,false,$this->sql);
            $this->cnt = $row['cnt'];
            $this->selectedList = $goodsModel->get($this->col,$this->search,true,$this->sql);
        }
    }

    public function mediaModify(){
        $this->pt_li = $this->partnerModel->getNameList("a");
        $mediaModel = new \application\models\MediaModel();
        $this->row = $mediaModel->get( $this->col, array("media_id"=>$this->param['ident']));
        if(empty($_REQUEST['goodsId'])) $_REQUEST['goodsId'] = $this->row['media_goods_list'];
        if( !empty($_REQUEST['goodsId']) ){
            $goodsModel = new \application\models\GoodsModel();
            $sql = "";
            foreach($this->my['shop_use_ctg'] as $ctg){
                if( !empty($sql) ) $sql .= " or ";
                $sql .= " ( gs_ctg like '{$ctg}%' or  gs_ctg2 like '{$ctg}%' or  gs_ctg3 like '{$ctg}%' ) ";
            }
            $this->sql = " and ( {$sql} ) ";

            if( empty($_REQUEST['goodsId']) ) $_REQUEST['goodsId'] = "";
            $this->search['gs_id_in_all'] = $_REQUEST['goodsId'];
            $this->search['col'] = "  field (gs_id,{$_REQUEST['goodsId']}) ";
            $this->search['gs_stt'] = "2";
            $row = $goodsModel->get("count(gs_id) as cnt",$this->search,false,$this->sql);
            $this->cnt = $row['cnt'];
            $this->selectedList = $goodsModel->get($this->col,$this->search,true,$this->sql);
        }
 
    }

    public function addMedia(){
        $mediaModel = new \application\models\MediaModel();
        $_POST['shop'] = $this->my['pt_id'];
        $res = $mediaModel->add($_POST);
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
    function couponList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->coupon = new \application\models\CouponModel();
        $this->cnt = $this->coupon->getCnt();
    }

    function couponForm(){
        if( $_GET['mode'] == "u" ){
            $idx = $this->param['ident'];
            $this->row = $this->query->getRow("web_coupon","*"," and idx={$idx} ");
        }
    }

    function couponFormUpdate(){
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
