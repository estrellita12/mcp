<?php
namespace application\Admin\controllers;

class SettingController extends Controller{
    public $col;
    public $search;
    public $sql;
    public $row;

    public function init(){
        $this->col = "*";
        $this->search = array();
        $this->sql = "";
        $this->row = array();
    }

    public function adminMenuList(){
        $this->menu = new \application\models\AdminMenuModel();
        $this->cnt = $this->menu->getCnt();
        $this->grade = new \application\models\AdministratorGradeModel();
        $this->gr_li = $this->grade->getNameList();
    }

    public function getNextAdminMenu(){
        $this->menu = new \application\models\AdminMenuModel();
        $this->header=false; $this->footer=false;
        $depth = $_POST['depth'];
        $upper = $_POST['upper'];
        $length = $depth*2;
        $data = array();
        if(!empty($depth)) {
            $res = $this->menu->getDepthList($depth, $upper, 'a');
            $i=0; foreach( $res as $row) {
            $data[$i]['optionValue'] = $row['code'];
            $data[$i]['optionText']  = $row['name'];
            $i++;
            }
        }
        print_r(json_encode($data));
    }

    public function printAdminMenu(){
        $this->menu = new \application\models\AdminMenuModel();
        $this->header=false; $this->footer=false;
        $row = $this->menu->get('code,name,use_yn,url,show_grade', array("code"=>$this->param['ident']));
        echo json_encode($row);
    }

    public function sortableAdminMenu(){
        $this->menu = new \application\models\AdminMenuModel();
        $this->header = false;  $this->footer = false;
        $sortList = explode(",", $_REQUEST['orderby']);
        $sortList = array_filter($sortList);
        $upper = substr($sortList[0],0,-2);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i;
            $res = $this->menu->set($arr,$arr['id'],"move");
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "관리자 메뉴가 순서가 변경되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/adminMenuList?menu=".$upper);
    }

    public function addAdminMenu(){
        $this->menu = new \application\models\AdminMenuModel();
        $res = $this->menu->add( array("id"=>$this->param['ident']) );
        $msg = $res=="000" ? "메뉴가 추가되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/adminMenuList?menu=".$this->param['ident']);
    }

    public function removeAdminMenu(){
        $this->menu = new \application\models\AdminMenuModel();
        $res = $this->menu->remove($this->param['ident']);
        $msg = $res=="000" ? "메뉴가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $upper = substr($this->param['ident'],0,-2);
        access($msg , "/Setting/adminMenuList?menu=".$upper);
    }

    public function setAdminMenu(){
        $this->menu = new \application\models\AdminMenuModel();
        $res = $this->menu->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "관리자 메뉴가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/adminMenuList?menu=".$this->param['ident']);
    }

    // -----------------------------------------------------------------------------------
    public function partnerMenuList(){
        $this->menu = new \application\models\PartnerMenuModel();
        $this->cnt = $this->menu->getCnt();
    }

    public function getNextPartnerMenu(){
        $this->menu = new \application\models\PartnerMenuModel();
        $this->header=false; $this->footer=false;
        $depth = $_POST['depth'];
        $upper = $_POST['upper'];
        $length = $depth*2;
        $data = array();
        if(!empty($depth)) {
            $res = $this->menu->getDepthList($depth, $upper, 'a');
            $i=0; foreach( $res as $row) {
            $data[$i]['optionValue'] = $row['code'];
            $data[$i]['optionText']  = $row['name'];
            $i++;
            }
        }
        print_r(json_encode($data));
    }

    public function printPartnerMenu(){
        $this->menu = new \application\models\PartnerMenuModel();
        $this->header=false; $this->footer=false;
        $row = $this->menu->get('code,name,use_yn,url', array("code"=>$this->param['ident']));
        echo json_encode($row);
    }

    public function sortablePartnerMenu(){
        $this->menu = new \application\models\PartnerMenuModel();
        $this->header = false;  $this->footer = false;
        $sortList = explode(",", $_REQUEST['orderby']);
        $sortList = array_filter($sortList);
        $upper = substr($sortList[0],0,-2);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i;
            $res = $this->menu->set($arr,$arr['id'],"move");
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "관리자 메뉴가 순서가 변경되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/partnerMenuList?menu=".$upper);
    }

    public function addPartnerMenu(){
        $this->menu = new \application\models\PartnerMenuModel();
        $res = $this->menu->add( array("id"=>$this->param['ident']) );
        $msg = $res=="000" ? "메뉴가 추가되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/partnerMenuList?menu=".$this->param['ident']);
    }

    public function removePartnerMenu(){
        $this->menu = new \application\models\PartnerMenuModel();
        $res = $this->menu->remove($this->param['ident']);
        $msg = $res=="000" ? "메뉴가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $upper = substr($this->param['ident'],0,-2);
        access($msg , "/Setting/partnerMenuList?menu=".$upper);
    }

    public function setPartnerMenu(){
        $this->menu = new \application\models\PartnerMenuModel();
        $res = $this->menu->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "관리자 메뉴가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/partnerMenuList?menu=".$this->param['ident']);
    }

    // -----------------------------------------------------------------------------------
    public function sellerMenuList(){
        $this->menu = new \application\models\SellerMenuModel();
        $this->cnt = $this->menu->getCnt();
    }

    public function getNextSellerMenu(){
        $this->menu = new \application\models\SellerMenuModel();
        $this->header=false; $this->footer=false;
        $depth = $_POST['depth'];
        $upper = $_POST['upper'];
        $length = $depth*2;
        $data = array();
        if(!empty($depth)) {
            $res = $this->menu->getDepthList($depth, $upper, 'a');
            $i=0; foreach( $res as $row) {
            $data[$i]['optionValue'] = $row['code'];
            $data[$i]['optionText']  = $row['name'];
            $i++;
            }
        }
        print_r(json_encode($data));
    }

    public function printSellerMenu(){
        $this->menu = new \application\models\SellerMenuModel();
        $this->header=false; $this->footer=false;
        $row = $this->menu->get('code,name,use_yn,url', array("code"=>$this->param['ident']));
        echo json_encode($row);
    }

    public function sortableSellerMenu(){
        $this->menu = new \application\models\SellerMenuModel();
        $this->header = false;  $this->footer = false;
        $sortList = explode(",", $_REQUEST['orderby']);
        $sortList = array_filter($sortList);
        $upper = substr($sortList[0],0,-2);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i;
            $res = $this->menu->set($arr,$arr['id'],"move");
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "관리자 메뉴가 순서가 변경되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/sellerMenuList?menu=".$upper);
    }

    public function addSellerMenu(){
        $this->menu = new \application\models\SellerMenuModel();
        $res = $this->menu->add( array("id"=>$this->param['ident']) );
        $msg = $res=="000" ? "메뉴가 추가되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/sellerMenuList?menu=".$this->param['ident']);
    }

    public function removeSellerMenu(){
        $this->menu = new \application\models\SellerMenuModel();
        $res = $this->menu->remove($this->param['ident']);
        $msg = $res=="000" ? "메뉴가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $upper = substr($this->param['ident'],0,-2);
        access($msg , "/Setting/sellerMenuList?menu=".$upper);
    }

    public function setSellerMenu(){
        $this->menu = new \application\models\SellerMenuModel();
        $res = $this->menu->set($_POST,$this->param['ident']);
        $msg = $res=="000" ? "관리자 메뉴가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/sellerMenuList?menu=".$this->param['ident']);
    }

    // 환경 설정-----------------------------------------------------------
    public function config(){  
        $this->row = $this->config;
    }   

    public function setConfig(){  
        $this->header=false; $this->footer=false;
        $config = new \application\models\ConfigModel();
        $res = $config->set($_POST);
        $msg = $res=="000" ? "기본 환경 설정이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    //----------------------------------------------------------------------
    public function mailList(){
        $templateModel = new \application\models\TemplateModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "tp_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search = array();
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['col'] = $_REQUEST['col'];
        $this->search['colby'] = $_REQUEST['colby'];
        $this->search['tp_type'] = "1";
        $cnt = $templateModel->get("count(tp_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $templateModel->get($this->col,$this->search,true,$this->sql);
        $this->returnUrl = _REQUEST_URI;
    }

    public function mailForm(){
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Setting/mailList":$_REQUEST['returnUrl'];
    }

    public function mailModify(){
        $templateModel = new \application\models\TemplateModel();
        $this->row = $templateModel->get( $this->col, array("tp_id"=>$this->param['ident']));
        $this->row['tp_content'] = get_text($this->row['tp_content'],0);
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Setting/mailList":$_REQUEST['returnUrl'];
    }

    public function smsList(){
        $templateModel = new \application\models\TemplateModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "tp_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search = array();
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['col'] = $_REQUEST['col'];
        $this->search['colby'] = $_REQUEST['colby'];
        $this->search['tp_type'] = "2";
        $cnt = $templateModel->get("count(tp_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $templateModel->get($this->col,$this->search,true,$this->sql);
        $this->returnUrl = _REQUEST_URI;
    }

    public function smsForm(){
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Setting/smsList":$_REQUEST['returnUrl'];
    }

    public function smsModify(){
        $templateModel = new \application\models\TemplateModel();
        $this->row = $templateModel->get( $this->col, array("tp_id"=>$this->param['ident']));
        $this->row['tp_content'] = get_text($this->row['tp_content'],0);
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Setting/mailList":$_REQUEST['returnUrl'];
    }

    public function testSend(){
        $this->header=false; $this->footer=false;
        $templateModel = new \application\models\TemplateModel();
        $res = $templateModel->sendMail($_SESSION['user_id'],$_POST['tpId']);
        $msg = $res == "000" ? "템플릿이 발송되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function previewPopup(){
        $this->header='head'; $this->footer=false;
        $templateModel = new \application\models\TemplateModel();
        $administratorModel = new \application\models\AdministratorModel();
        $col = "adm_id as userId,adm_name as userName,adm_email as userEmail, adm_cellphone as userCellphon";
        $user = $administratorModel->get($col,array("adm_id"=>$_SESSION['user_id']));
        $defaultModel = new \application\models\DefaultModel();
        $col = "pt_name as senderName,shop_customer_service_email as senderEmail,shop_customer_service_tel as senderTel,shop_url as shopUrl, shop_pc_logo as shopLogo";
        $shop = $defaultModel->get($col, array("pt_id"=>"admin"));
        $tp = $templateModel->get("tp_id as tpId,tp_title as title,tp_content as content",array("tp_id"=>$this->param['ident']));
        $this->row = array_merge($user,$tp,$shop);
        $this->row['content'] = stripslashes($this->row['content']);
        $this->row['content'] = contentReplace($this->row);
    }

    public function sendLogPopup(){
        $this->header='head'; $this->footer=false;
        $logModel = new \application\models\TemplateSendLogModel();
        $this->search = array();
        $this->search['tp_id'] = $this->param['ident'];
        $this->search['col'] = "tpsl_reg_dt";
        $cnt = $logModel->get("count(tpsl_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $logModel->get($this->col, $this->search, true, $this->sql);
    }

    public function addTemplate(){
        $templateModel = new \application\models\TemplateModel();
        $res = $templateModel->add($_POST);
        $msg = $res == "000" ? "템플릿이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Setting/mailList":$_REQUEST['returnUrl'];
        access($msg , $returnUrl);
    }

    public function setTemplate(){
        $templateModel = new \application\models\TemplateModel();
        $res = $templateModel->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "템플릿이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Setting/mailList":$_REQUEST['returnUrl'];
        access($msg , $returnUrl);
    }

    //--------------------------------------------------------------------------
    public function administratorList(){
        $this->grade = new \application\models\AdministratorGradeModel();
        $this->gr_li = $this->grade->getNameList();
        $this->administrator = new \application\models\AdministratorModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->administrator->getCnt();
    }

    public function administratorListExcel(){
        $this->header = false; $this->footer = false;
        $grade = new \application\models\AdministratorGradeModel();
        $this->gr_li = $grade->getNameList();
        $this->administrator = new \application\models\AdministratorModel();
        if( $this->administrator->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    public function administratorInfoPopup(){
        $this->header='head'; $this->footer=false;
        $this->administrator = new \application\models\AdministratorModel();
        $grade = new \application\models\AdministratorGradeModel();
        $this->gr_li = $grade->getNameList();
        $this->row = $this->administrator->get($this->col, array("adm_id"=>$this->param['ident']));
    }

    public function administratorGradeForm(){
        $this->grade = new \application\models\AdministratorGradeModel();
    }

    public function addAdministrator(){
        $this->header=false; $this->footer=false;
        $this->administrator = new \application\models\AdministratorModel();
        $res = $this->administrator->add($_POST);
        $msg = $res=="000" ? "관리자가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Setting/administratorList");
    }

    public function setAdministrator(){
        $this->header=false; $this->footer=false;
        $this->administrator = new \application\models\AdministratorModel();
        $res = $this->administrator->set($_POST);
        $msg = $res=="000" ? "관리자 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function removeAdministrator(){
        $this->header=false; $this->footer=false;
        $this->administrator = new \application\models\AdministratorModel();
        $res = $this->administrator->remove($this->param['ident']);
        $msg = $res=="000" ? "관리자가 탈퇴처리되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function setAdministratorGrade(){
        $this->grade = new \application\models\AdministratorGradeModel();
        $success = 0;
        foreach($_POST['li'] as $grd){
            $res = $this->grade->set($grd,$grd['id']);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "등급 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }


    public function syncSeller(){
        $this->header=false; $this->footer=false;
        $oldSellerModel = new \application\models\Model("shop_seller");
        $oldMemberModel = new \application\models\Model("shop_member");
        $sellerModel = new \application\models\SellerModel();

        $row = $oldSellerModel->get("*",array("index_no_then_ne"=>0),true);
        $fail = 0;
        $fail_msg = "";
        foreach($row as $sl){
            $mb = $oldMemberModel->get("name,memo",array("id"=> $sl['mb_id']));
            $value=array();
            $value['sl_name'] = $mb['name'];
            $value['sl_id'] = $sl['mb_id'];
            $state = $sl['state'] == 0 ? 1: 2;
            $value['sl_stt'] =  $state;
            $value['sl_reg_dt'] = $sl['reg_time'];
            $value['sl_app_dt'] = $sl['app_time'];
            $value['sl_pay_rate'] = $sl['seller_comm'];
            $value['sl_bank_name'] = $sl['bank_name'];
            $value['sl_bank_account'] = $sl['bank_account'];
            $value['sl_bank_holder'] = $sl['bank_holder'];
            $value['sl_bank_file'] = $sl['company_bank_file']; // https://mwo.kr/data/common/E2Usbv3pVty5yv2TWA4QDy2AKngSUs.pdf
            $manager1 = array($sl['info_name'],$sl['info_tel'],$sl['info_email'],$sl['nateon']);
            $value['sl_manager'] = serialize($manager1);
            $manager2 = array($sl['info_name2'],$sl['info_tel2'],$sl['info_email2'],"");
            $value['sl_manager2'] = serialize($manager2);
            $manager3 = array($sl['info_name3'],$sl['info_tel3'],$sl['info_email3'],"");
            $value['sl_manager3'] = serialize($manager3);
            $manager4 = array($sl['info_name4'],$sl['info_tel4'],$sl['info_email4'],"");
            $value['sl_manager4'] = serialize($manager4);
            $value['sl_company_name'] = $sl['company_name'];
            $value['sl_company_owner'] = $sl['company_owner'];
            $value['sl_company_saupja_no'] = $sl['company_saupja_no'];
            $value['sl_company_saupja_file'] = $sl['company_saupja_file']; // https://mwo.kr/data/common/E2Usbv3pVty5yv2TWA4QDy2AKngSUs.pdf
            $value['sl_company_tolsin_no'] = "";
            $value['sl_company_tolsin_file'] = $sl['compnay_report_file']; // https://mwo.kr/data/common/9F6FZVujNtQbVLuLMyjCtpEFV4Xsc1.jpg
            $value['sl_company_item'] = $sl['company_item'];
            $value['sl_company_service'] = $sl['company_service'];
            $value['sl_company_tel'] = $sl['company_tel'];
            $value['sl_company_email'] = "";
            $value['sl_company_addr'] = $sl['company_addr1']." ".$sl['company_addr2']." ".$sl['company_addr3'];
            $value['sl_delivery_information'] = "";
            $value['sl_adm_memo'] = $mb['memo'];
            $value['sl_introdution'] = "대표 상품 링크 : ".$sl['goods_link']."\n"."홈페이지 주소 : ".$sl['compnay_hompage']."\n".$sl['memo'];
            $res = $sellerModel->add($value,"value");
            if( $res != "000" ){
                $fail++;
                $fail_msg .= "{$sl['mb_id']},";
            }
        }
        $msg = "$fail 개의 공급사 등록이 실패되었습니다.\n$fail_msg";
        access($msg , _PRE_URL);
    }

    public function syncGoods(){
        $this->header=false; $this->footer=false;

        $oldGoodsModel = new \application\models\Model("shop_goods");
        $oldOptionModel = new \application\models\Model("shop_goods_option");
        $oldSellerModel = new \application\models\Model("shop_seller");

        $goodsModel = new \application\models\GoodsModel();
        $optionModel = new \application\models\GoodsOptionModel();

        $row = $oldGoodsModel->get("*",array("index_no_then_ne"=>"0"),true);
        $fail = 0;
        $fail_msg = "";
        foreach($row as $gs){
            $sl = $oldSellerModel->get("mb_id",array("seller_code"=> $gs['mb_id']));
            $value=array();
            $value['gs_id'] = $gs['index_no'];
            $value['gs_code'] = $gs['gcode'];
            $value['gs_reg_dt'] = $gs['reg_time'];
            $value['gs_update_dt'] = $gs['update_time'];
            $value['sl_id'] = $sl['mb_id'];
            $value['gs_ctg'] = $gs['ca_id']; 
            $value['gs_ctg2'] = $gs['ca_id2']; 
            $value['gs_ctg3'] = $gs['ca_id3']; 
            $value['gs_name'] = $gs['gname']; 
            $value['gs_explan'] = $gs['explan']; 
            $value['gs_keywords'] = $gs['keywords']; 
            if( $gs['shop_state'] == "0" )   $state = "2";
            else if( $gs['shop_state'] == "1" )   $state = "1";
            else   $state = "3";
            $value['gs_stt'] = $state;
            $value['gs_isopen'] = $gs['isopen'];
            $value['gs_consumer_price'] = $gs['normal_price'];
            $value['gs_supply_price'] = $gs['supply_price'];
            $value['gs_price'] = $gs['goods_price'];
            $value['gs_rate'] = round( (( $gs['goods_price'] - $gs['supply_price'] ) / $gs['goods_price'] )*100 );

            //$value['gs_price_auto'] = 1;
            $tmpArr = array(0.8,0.85,0.9,0.95,1,1.05,1.1,1.15,1.2);
            for($i=1;$i<10;$i++){
                $price = round($value['gs_price']*$tmpArr[$i-1],-1);
                if($price < $value['gs_supply_price']) $price = $value['gs_supply_price'];
                if($price > $value['gs_consumer_price']) $price = $value['gs_consumer_price'];
                $value["gs_price_{$i}"] = $price;
            }

            $value['gs_maker'] = $gs['maker'];
            $value['gs_origin'] = $gs['origin'];
            $value['gs_make_year'] = $gs['make_year'];
            $value['gs_make_dm'] = $gs['make_dm'];
            $value['gs_season'] = $gs['season'];
            $value['gs_sex'] = $gs['sex'];
            $value['gs_model_nm'] = $gs['model'];
            $value['gs_detail_content'] = $gs['memo'];
            $value['gs_opt_subject'] = $gs['opt_subject'];
            $value['gs_add_opt_subject'] = $gs['spl_subject'];
            $value['gs_brand'] = $gs['brand_nm'];
            //$value['gs_delivery_type'] = $gs['sc_type'];
            $value['gs_delivery_type'] = 1;
            $value['gs_delivery_charge'] = $gs['sc_amt'];
            $value['gs_delivery_free'] = $gs['sc_minimum'];
            $value['gs_claim_delivery_charge'] = $gs['sc_amt'] * 2;
            $value['gs_delivery_each_use'] = $gs['sc_each_use'];
            //$value['gs_delivery_region'] = $gs['zone'];
            $value['gs_delivery_region'] = "1";
            $value['gs_delivery_region_msg'] = $gs['zone_msg'];
            $value['gs_info_type'] = $gs['info_gubun'];
            $value['gs_info_value'] = $gs['info_value'];
            $value['gs_simg_type'] = $gs['simg_type'];

            if(!empty($gs['simg1'])) $value['gs_simg1'] = $gs['simg1'];
            if(!empty($gs['simg2'])) $value['gs_simg2'] = $gs['simg2'];
            if(!empty($gs['simg3'])) $value['gs_simg3'] = $gs['simg3'];
            if(!empty($gs['simg4'])) $value['gs_simg4'] = $gs['simg4'];
            if(!empty($gs['simg5'])) $value['gs_simg5'] = $gs['simg5'];
            if( $value['gs_simg_type'] != 1 ){
                $ori_file = "/var/www/html/public_html/data/goods/".$value['gs_simg1'];
                $mv_path =  "/var/www/html/my-custom-platform/public/mwo/data/goods/{$value['gs_code']}";
                $mv_file =  "{$mv_path}/{$value['gs_simg1']}";
                if (!file_exists($mv_path)) {
                    $res =  mkdir($mv_path, 0777, true);
                }
                if (file_exists($ori_file)) {
                    $res = shell_exec("cp {$ori_file} {$mv_file}");
                }
            }
         
            /*
            if( $value['gs_simg_type'] != 1 ){
                if(!empty($gs['simg1'])) $value['gs_simg1'] = "https://mwo.kr/data/goods/".$gs['simg1'];
                if(!empty($gs['simg2'])) $value['gs_simg2'] = "https://mwo.kr/data/goods/".$gs['simg2'];
                if(!empty($gs['simg3'])) $value['gs_simg3'] = "https://mwo.kr/data/goods/".$gs['simg3'];
                if(!empty($gs['simg4'])) $value['gs_simg4'] = "https://mwo.kr/data/goods/".$gs['simg4'];
                if(!empty($gs['simg5'])) $value['gs_simg5'] = "https://mwo.kr/data/goods/".$gs['simg5'];
            }else{
                if(!empty($gs['simg1'])) $value['gs_simg1'] = $gs['simg1'];
                if(!empty($gs['simg2'])) $value['gs_simg2'] = $gs['simg2'];
                if(!empty($gs['simg3'])) $value['gs_simg3'] = $gs['simg3'];
                if(!empty($gs['simg4'])) $value['gs_simg4'] = $gs['simg4'];
                if(!empty($gs['simg5'])) $value['gs_simg5'] = $gs['simg5'];
            }
            */

            $value['gs_stock_qty'] = $gs['stock_qty'];
            $gs_stock_qty_noti = only_number($gs['noti_qty']);
            $gs_stock_qty_noti = $gs_stock_qty_noti > 10?10:$gs_stock_qty_noti;
            $value['gs_stock_qty_noti'] = $gs_stock_qty_noti;
            $res = $goodsModel->add($value,"value");
            if( $res != "000" ){
                $fail++;
                $fail_msg .= "{$gs['index_no']},";
            }

            if( $res == "000" ){
                $optList = $oldOptionModel->get("*",array("gs_id"=>$value['gs_id']),true);
                $stock = 0;
                foreach($optList as $opt){
                    $optValue = array();
                    $optValue['gs_opt_id'] = $opt['io_no'];       
                    $optValue['gs_opt_code'] = "";       
                    $optValue['gs_opt_name'] = trim($opt['io_id']);   
                    $optValue['gs_opt_type'] = "1";       
                    $optValue['gs_opt_orderby'] = "1";       
                    $optValue['gs_id'] = $opt['gs_id'];       
                    $optValue['gs_opt_add_price'] = $opt['io_price'];       
                    $optValue['gs_opt_supply_price'] = get_supply_price($value['gs_price'] +  $optValue['gs_opt_add_price'], $value['gs_rate']);
                    $gs_opt_stock_qty = only_number($opt['io_stock_qty']);
                    $gs_opt_stock_qty = $gs_opt_stock_qty >= 999 ? 999 :  $gs_opt_stock_qty;
                    $optValue['gs_opt_stock_qty'] =  $gs_opt_stock_qty;
                    $optValue['gs_opt_stock_qty_noti'] = 10;
                    $gs_opt_use_yn = $opt['io_use'] ==1 ? "y":"n";
                    $optValue['gs_opt_use_yn'] = $gs_opt_use_yn;
                    //$optValue['gs_opt_reg_dt'] = "";
                    //$optValue['gs_opt_update_dt'] = "";       
                    $res2 = $optionModel->add($optValue,"value");
                    if( $res2 != "000" ){
                        $fail_msg .= "{$gs['index_no']},";
                    } 
                    if( $res2 == "000" ){
                        if( $gs_opt_use_yn == "y" ) $stock += $optValue['gs_opt_stock_qty'];
                    }   
                }   
                if( $stock > 0 ) $goodsModel->set(array("gs_stock_qty"=>$stock),$value['gs_id'],"value");
            }
        }
        $msg = "{$fail} 개의 상품 등록이 실패되었습니다.\n{$fail_msg}";
        access($msg , _PRE_URL);
    }

    public function syncOrder(){
        $this->header=false; $this->footer=false;
        $oldGoodsModel = new \application\models\Model("shop_goods");
        $oldOptionModel = new \application\models\Model("shop_goods_option");
        $oldSellerModel = new \application\models\Model("shop_seller");
        $oldOrderModel = new \application\models\Model("shop_order");
        $oldCartModel = new \application\models\Model("shop_cart");

        $orderModel = new \application\models\OrderModel();
        $optionModel = new \application\models\GoodsOptionModel();

        //$row = $oldOrderModel->get("*",array("index_no_then_ge"=>"41000"),true);
        $row = $oldOrderModel->get("*",array("index_no_then_ge"=>"35000","index_no_then_le"=>"40000"),true);
        $fail = 0;
        $fail_msg = "";
// 주문단계
$gw_status = array(
    "1"=>"1",
    "2"=>"2",
    "3"=>"11",
    "4"=>"13",
    "5"=>"14",
    "6"=>"42",
    "7"=>"37",
    "8"=>"29",
    "9"=>"42",
    "10"=>"31",
    "11"=>"33",
    "12"=>"21",
    "13"=>"27",
    "14"=>"41"
);
        foreach($row as $od){
            $sl = $oldSellerModel->get("mb_id",array("seller_code"=> $od['seller_id']));
            $check = $orderModel->get("count(od_id) as cnt", array("od_id"=>$od['od_id']));
            if( !empty($check['cnt']) ) continue;
            $value=array();
            $value['od_id'] = $od['od_id'];
            $value['od_no'] = $od['od_no'];
            $value['pt_id'] = "admin";
            $value['od_stt'] = $gw_status[$od['dan']];
            $value['od_dt'] = $od['od_time'];
            $value['od_rcent_dt'] = $od['rcent_time'];
            $value['od_paymethod'] = "vbank";
            $value['mb_id'] = "";
            $value['orderer_name'] = $od['name'];
            $value['orderer_cellphone'] = $od['cellphone'];
            $value['orderer_email'] = $od['email'];
            $value['orderer_zip'] = $od['zip'];
            $value['orderer_addr1'] = $od['addr1'];
            $value['orderer_addr2'] = $od['addr2'];
            $value['orderer_addr3'] = $od['addr3'];
            $value['orderer_jibeon'] = $od['addr_jibeon'];
            $value['receiver_name'] = $od['b_name'];
            $value['recevier_cellphone'] = $od['b_cellphone'];
            $value['receiver_zip'] = $od['b_zip'];
            $value['receiver_addr1'] = $od['b_addr1'];
            $value['receiver_addr2'] = $od['b_addr2'];
            $value['receiver_addr3'] = $od['b_addr3'];
            $value['receiver_jibeon'] = $od['b_addr_jibeon'];
            $value['receiver_delivery_msg'] = $od['memo'];
            $value['gs_id'] = $od['gs_id'];
            $cart = $oldCartModel->get("io_id,ct_qty",array("od_id"=>$od['od_id']));
            if( $cart['ct_qty'] != $od['sum_qty'] ){
                echo $od['gs_id'];
                echo "<br>";
            }
            $gs_opt_name = trim(str_replace(":",chr(30),$cart['io_id']));
            $opt = $optionModel->get("gs_opt_id",array("gs_opt_name"=>$gs_opt_name));
            $gs_opt_id =!empty($opt['gs_opt_id'])?$opt['gs_opt_id']:"0";
            $value['gs_opt_id'] = $gs_opt_id;
            $value['sl_id'] = !empty($sl['mb_id'])?$sl['mb_id']:"";
            $value['seller_pay_stt'] = 1;
            $value['partner_pay_stt'] = 1;
            $value['od_qty'] = $od['sum_qty'];
            $value['od_goods_price'] = $od['goods_price'];
            $value['od_supply_price'] = $od['supply_price'];
            $value['od_amount'] = $od['use_price'];
            $value['od_delivery_charge'] = $od['baesong_price'];
            $value['od_delivery_charge_dosan'] = 0;
            $value['od_cancel_amount'] = $od['cancel_price'];
            $value['od_return_amount'] = $od['refund_price'];
            $value['od_pay_request_dt'] = $od['receipt_time'];
            $value['od_pay_approved_dt'] = $od['receipt_time'];
            $value['od_pay_approved_dt'] = $od['receipt_time'];
            $delivery = explode("|",$od['delivery']);
            $delivery = $delivery[0];
            switch($delivery){
                case "CJ대한통운": $od_delivery_company = "100";break;
                case "한진택배": $od_delivery_company = "102";break;
                case "KG로지스": $od_delivery_company = "103";break;
                case "KGB택배": $od_delivery_company = "104";break;
                case "KG옐로우캡택배": $od_delivery_company = "105";break;
                case "CVSnet편의점택배": $od_delivery_company = "106";break;
                case "롯데택배": $od_delivery_company = "101";break;
                case "이노지스택배": $od_delivery_company = "110";break;
                case "우체국": $od_delivery_company = "107";break;
                case "로젠택배": $od_delivery_company = "108";break;
                case "동부택배": $od_delivery_company = "109";break;
                case "대신택배": $od_delivery_company = "111";break;
                case "경동택배": $od_delivery_company = "112";break;
            }
            $od_delivery_company = "100";
            $value['od_delivery_company'] = $od_delivery_company;
            $value['od_delivery_no'] = $od['delivery_no'];
            $value['od_delivery_dt'] = $od['delivery_date'];
            $value['od_invoice_dt'] = $od['invoice_date'];
            $value['od_cancel_request_dt'] = $od['cancel_date'];
            $value['od_cancel_dt'] = $od['cancel_date'];
            $value['od_return_request_dt'] = $od['return_date2'];
            $value['od_return_dt'] = $od['return_date'];
            $value['od_change_request_dt'] = $od['change_date2'];
            $value['od_change_dt'] = $od['change_date'];
            $od_goods = unserialize($od['od_goods']);
            $od_goods_info = array();
            $od_goods_info['simg'] = $od_goods['simg1'];
            $od_goods_info['goodsId'] = $od['gs_id'];
            $od_goods_info['goodsCode'] = $od_goods['gcode'];
            $od_goods_info['brand'] = $od_goods['brand_nm'];
            $od_goods_info['seller'] = $value['sl_id'];
            $od_goods_info['goodsName'] = $od_goods['gname'];
            $od_goods_info['consumerPrice'] = $od_goods['normal_price'];
            $od_goods_info['supplyPrice'] = $od_goods['supply_price'];
            $od_goods_info['claimDeliveryCharge'] = "0";
            $od_goods_info['deliveryType'] = "1";
            $od_goods_info['deliveryCharge'] = $od_goods['sc_amt'];
            $od_goods_info['deliveryFree'] = "0";
            $od_goods_info['deliveryEachUse'] = "1";
            $od_goods_info['optionId'] = $gs_opt_id;
            $od_goods_info['optionName'] = $cart['io_id'];
            $od_goods_info['optionStockQty'] = $od_goods['stock_qty'];
            $od_goods_info['addPrice'] = "0";
            //$od_goods_info = $orderModel->getGoodsInfo($gs_opt_id);
            $value['od_goods_info'] = json_encode($od_goods_info);
            $res = $orderModel->add($value,"value");
            if( $res != "000") {
                $fail++;
                $fail_msg .= "{$od['od_id']},";
            }
        }

        $msg = "{$fail} 개의 주문 등록이 실패되었습니다.\n {$fail_msg}";
        //access($msg , _PRE_URL);
    }
}
?>
