<?php
namespace application\Admin\controllers;

class PartnerController extends Controller{
    public $col;
    public $cnt;

    public function init(){ 
        $this->col = "*";
    }

    public function list(){
        $this->grade = new \application\models\PartnerGradeModel();
        $this->partner = new \application\models\PartnerModel();
        $this->pay = new \application\models\PartnerPayModel();

        $this->gr_li = $this->grade->getNameList("a");

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "2";
        $this->cnt = $this->partner->getCnt();
    }

    public function listExcel(){
        $this->grade = new \application\models\PartnerGradeModel();
        $this->gr_li = $this->grade->getNameList("a");
        $this->partner = new \application\models\PartnerModel();

        $this->header = false;  $this->footer = false;
        if( $this->partner->getCnt() < 1 ){ access("출력할 자료가 없습니다."); }
    }

    public function popup(){
        $this->partner = new \application\models\PartnerModel();
        $this->grade = new \application\models\PartnerGradeModel();
        $this->gr_li = $this->grade->getNameList("a");

        $this->header='head'; $this->footer=false;
        $this->tabs = "<ul class='tabs'>";
        $active=$this->param['page']=="infoPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/infoPopup/{$this->param['ident']}'>가맹점 정보</a></li> ";
        $active=$this->param['page']=="policyPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/policyPopup/{$this->param['ident']}'>쇼핑몰 정책</a></li> ";
        $active=$this->param['page']=="designPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/designPopup/{$this->param['ident']}'>쇼핑몰 디자인</a></li> ";
        $active=$this->param['page']=="categoryPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/categoryPopup/{$this->param['ident']}'>카테고리 설정</a></li> ";
        $active=$this->param['page']=="menuPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/menuPopup/{$this->param['ident']}'>쇼핑몰 메뉴</a></li> ";
        $active=$this->param['page']=="gnbPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/gnbPopup/{$this->param['ident']}'>쇼핑몰 GNB</a></li> ";
        $active=$this->param['page']=="layoutPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/layoutPopup/{$this->param['ident']}'>쇼핑몰 레이아웃</a></li> ";
        $active=$this->param['page']=="pgPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Partner/pgPopup/{$this->param['ident']}'>개별 PG 정보</a></li> ";
        $this->tabs .= "</ul>";
        $this->row = $this->partner->get($this->col, array("pt_id"=>$this->param['ident']));
    }

    public function infoPopup(){
        $this->popup();
        $this->row['pt_bank_info'] = unserialize($this->row['pt_bank_info']);
        $this->row['pt_manager'] = unserialize($this->row['pt_manager']);
        $this->row['shop_info_manager'] = unserialize($this->row['shop_info_manager']);
        $this->row['shop_customer_service_info'] = unserialize($this->row['shop_customer_service_info']);
    }
    public function policyPopup(){
        $this->popup();
    }
    public function pgPopup(){
        $this->popup();
    }
    public function designPopup(){
        $this->popup();
        $this->row['shop_head_tag'] = stripslashes($this->row['shop_head_tag']);
        $this->row['shop_body_tag'] = stripslashes($this->row['shop_body_tag']);
    }
    public function categoryPopup(){
        $this->popup();
        $this->changeMode = "modify";
        if(empty($this->row['shop_use_ctg'])){
            $this->row['shop_use_ctg'] = $this->default['shop_use_ctg'];
            $this->changeMode = "add";
        }
        $this->row['shop_use_ctg'] = unserialize($this->row['shop_use_ctg']);
        $this->category = new \application\models\CategoryModel();
    }

    public function menuPopup(){
        $this->popup();
        $gnb = new \application\models\GnbMenuModel();
        $this->row['shop_default_menu'] = $gnb->get("*", array("pt_id"=>$this->param['ident']));
        $this->row['shop_default_menu_mode'] = "modify";
        if(empty($this->row['shop_default_menu'])){
            $this->row['shop_default_menu'] = $gnb->get("*", array("pt_id"=>"admin"));
            $this->row['shop_default_menu_mode'] = "add";
        }
    }

    public function gnbPopup(){
        $this->popup();
        $gnb = new \application\models\GnbMenuModel();
        $this->row['shop_default_menu'] = $gnb->get("*", array("pt_id"=>$this->param['ident']));
        $this->row['shop_default_menu_mode'] = "modify";
        if(empty($this->row['shop_default_menu'])){
            $this->row['shop_default_menu'] = $gnb->get("*", array("pt_id"=>"admin"));
            $this->row['shop_default_menu_mode'] = "add";
        }

        $this->row['shop_default_layout_mode'] = "modify";
        if( empty( $this->row['shop_gnb'] ) ){
            $this->row['shop_gnb'] = $this->default['shop_gnb'];
            $this->row['shop_default_layout_mode'] = "add";
        }

        $this->row['shop_gnb'] = json_decode($this->row['shop_gnb'],true);
    }

    public function layoutPopup(){
        $this->popup();
        $this->row['shop_default_layout_mode'] = "modify";
        if( empty( $this->row['shop_main_layout'] ) ){
            $this->row['shop_main_layout'] = $this->default['shop_main_layout'];
            $this->row['shop_default_layout_mode'] = "add";
        }
        $this->row['shop_main_layout'] = json_decode($this->row['shop_main_layout'],true);
    }


    public function menuGoodsListPopup(){
        $this->header = "head"; $this->footer=false;
        $partnerModel = new \application\models\PartnerModel();
        $pt = $partnerModel->get("*",array("pt_id"=>$this->param['ident']));

        $this->categoryModel = new \application\models\CategoryModel();
        if( empty($pt['shop_use_ctg']) ){
            $defaultModel = new \application\models\DefaultModel();
            $default = $defaultModel->get("shop_use_ctg",array("pt_id"=>"admin"));
            $pt['shop_use_ctg'] = $default['shop_use_ctg'];
        }
        $pt['shop_use_ctg'] = unserialize($pt['shop_use_ctg']);
        $sql = "";
        foreach($pt['shop_use_ctg'] as $ctg){
            if( !empty($sql) ) $sql .= " or ";
            $sql .= " ( gs_ctg like '{$ctg}%' or  gs_ctg2 like '{$ctg}%' or  gs_ctg3 like '{$ctg}%' ) ";
        }
        $this->sql = " and ( {$sql} ) ";

        $this->goodsModel = new \application\models\GoodsModel();
        $this->selected = array();
        if( !empty($this->param['action']) ){
            $search = array();
            $search['gs_id_in_all'] = $this->param['action'];
            $search['col'] = "  field (gs_id,{$this->param['action']}) ";
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
    /*
    public function menuGoodsListPopup(){
        $this->partner = new \application\models\PartnerModel();

        $this->header = "head"; $this->footer=false;
        $gnbModel = new \application\models\GnbMenuModel();
        $this->goods = new \application\models\GoodsModel();
        $col = "menu_{$this->param['action']}_goods_list";
        $goods_list = $gnbModel->get($col,array("pt_id"=>$this->param['ident']));
        if( !empty($goods_list[$col]) ){
            //$this->row = $this->goods->selectAll("*"," and gs_id in ( $goods_list[$col] ) ", " order by field (gs_id,$goods_list[$col])" );
            $this->row = $this->goods->get("*", array("gs_id_in_"=>$goods_list[$col], "col" =>"field (gs_id,$goods_list[$col])"),true);
        }else{
            $this->row = array();
        }

        $this->gsCnt = count($this->row);
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $row = $this->partner->get("shop_use_ctg", array("pt_id"=>$this->param['ident']));
        if(empty($row['shop_use_ctg'])){
            $row['shop_use_ctg'] = $this->default['shop_use_ctg'];
        }
        $ctgList = unserialize($row['shop_use_ctg']);
        $_REQUEST['useCtg'] = implode(",",$ctgList);
        $_REQUEST['shop'] = $this->param['ident'];
    }
    */

    public function add(){
        $this->partner = new \application\models\PartnerModel();
        $res = $this->partner->add($_POST);
        $msg = $res == "000" ? "가맹점이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Partner/newList");
    }

    public function set(){
        $this->partner = new \application\models\PartnerModel();
        $this->header=""; $this->footer="";
        $res = $this->partner->set(array_merge($_POST,$_FILES),$this->param['ident']);
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function setGnb(){
        $this->partner = new \application\models\PartnerModel();
        $gnb = array();
        for($i=0;$i<count($_POST['gnbTitle']);$i++){
            $gnb[$i]['title']=$_POST['gnbTitle'][$i];
            $gnb[$i]['url']=$_POST['gnbUrl'][$i];
        }
        $res = $this->partner->set(array("id="=>$this->param['ident'],"gnb"=>$gnb),$this->param['ident']);
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function setLayout(){
        $this->partner = new \application\models\PartnerModel();
        $mainLayout = array();
        for($i=0;$i<count($_POST['mainLayoutTitle']);$i++){
            $mainLayout[$i]['title']=$_POST['mainLayoutTitle'][$i];
            $mainLayout[$i]['url']=$_POST['mainLayoutUrl'][$i];
            $mainLayout[$i]['api']=$_POST['mainLayoutApiUrl'][$i];
            $mainLayout[$i]['apiCol']=$_POST['mainLayoutApiCol'][$i];
            $mainLayout[$i]['type']=$_POST['mainLayoutType'][$i];;
            $mainLayout[$i]['design']=$_POST['mainLayoutDesign'][$i];
            $mainLayout[$i]['cnt']=$_POST['mainLayoutCnt'][$i];
            $mainLayout[$i]['rpp']=$_POST['mainLayoutRpp'][$i];
            $mainLayout[$i]['mcnt']=$_POST['mainLayoutMCnt'][$i];
            $mainLayout[$i]['mrpp']=$_POST['mainLayoutMRpp'][$i];
        }

        $res = $this->partner->set(array("id="=>$this->param['ident'],"mainLayout"=>$mainLayout),$this->param['ident']);
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function resetLayout(){
        $this->partner = new \application\models\PartnerModel();
        $res = $this->partner->resetLayout($this->param['ident']);
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function setMenu(){
        $gnb = new \application\models\GnbMenuModel();
        $res = $gnb->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "가맹점 메뉴 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function removeMenu(){
        $this->partner = new \application\models\PartnerModel();
        $gnb = new \application\models\GnbMenuModel();
        $res = $gnb->remove($this->param['ident']);
        $msg = $res == "000" ? "가맹점 메뉴 정보가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function removeCategory(){
        $this->partner = new \application\models\PartnerModel();
        $arr = array('shop_use_ctg'=>'');
        $res = $this->partner->set($arr,$this->param['ident'],"value");
        $msg = $res == "000" ? "가맹점 카테고리 정보가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function remove(){
        $this->partner = new \application\models\PartnerModel();
        $res = $this->partner->remove($this->param['ident']);
        $msg = $res == "000" ? "가맹점 정보가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function expire(){
        $this->partner = new \application\models\PartnerModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->partner->expire($id);
            if( $res == "000" ) $success++;
        }
        $msg = $success > 0 ? $success."개의 가맹점을 만료 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function newList(){
        $this->partner = new \application\models\PartnerModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "1";
        $this->cnt = $this->partner->getCnt();
    }

    public function approval(){
        $this->partner = new \application\models\PartnerModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->partner->approval($id);
            if( $res == "000" ) $success++;
        }
        $msg = $success > 0 ? $success."개의 가맹점을 승인 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function expireList(){
        $this->partner = new \application\models\PartnerModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "3";
        $this->cnt = $this->partner->getCnt();
    }

    public function gradeForm(){
        $this->grade = new \application\models\PartnerGradeModel();
    }

    public function setGrade(){
        $this->grade = new \application\models\PartnerGradeModel();
        $success = 0;
        foreach($_POST['li'] as $grd){
            $res = $this->grade->set($grd,$grd['id']);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "등급 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function orderListPopup(){
        $this->header = "head"; $this->footer = false;
        $this->order = new \application\models\OrderModel();
        $_REQUEST['id'] = $this->param['ident'];
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->order->getCnt();
    }

    public function yetList(){
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("a");
        $this->pt_li['admin'] = "본사";
        $this->order = new \application\models\OrderModel();

        $_REQUEST['partnerPay'] = "list";
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['term']) ) $_REQUEST['term'] = "orderDate";
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $this->col = " pt_id, group_concat(od_id) as od_idl, count(*) as od_cnt ";
        $this->col .= " , sum( if( partner_pay_stt = 1, od_goods_price, 0) ) as tot_goods_price   ";
        $this->col .= " , sum( if( partner_pay_stt = 1, od_use_point, 0) ) as tot_point   ";
        $this->col .= " , sum( if( partner_pay_stt = 1, od_use_coupon, 0) ) as tot_coupon   ";
        $this->col .= " , sum( if( partner_pay_stt != 1, od_goods_price, 0) ) as cancel_goods_price ";
        $this->col .= " , sum( if( partner_pay_stt != 1, od_use_point, 0) ) as cancel_point ";
        $this->col .= " , sum( if( partner_pay_stt != 1, od_use_coupon, 0) ) as cancel_coupon ";
        $this->order->sql_orderby = " order by tot_goods_price ";
        $this->order->sql_group = " group by pt_id ";
        $this->cnt = $this->order->getCnt();
    }

    public function yetPayInfoPopup(){
        $this->partner = new \application\models\PartnerModel();
        $this->order = new \application\models\OrderModel();

        $this->header = "head"; $this->footer = false;
        $this->pt = $this->partner->get("*", array("pt_id"=>$this->param['ident']));
        $this->pt['pt_bank_info'] = unserialize($this->pt['pt_bank_info']);

        $this->col = " pt_id, group_concat(od_id) as od_idl, count(*) as od_cnt ";
        $this->col .= " , sum(od_goods_price) as tot_goods_price  ";
        $this->col .= " , sum(od_use_point) as tot_point  ";
        $this->col .= " , sum(od_use_coupon) as tot_coupon  ";
        $this->col .= " , sum( if( partner_pay_stt != 1, od_goods_price, 0) ) as cancel_goods_price ";
        $this->col .= " , sum( if( partner_pay_stt != 1, od_use_point, 0) ) as cancel_point ";
        $this->col .= " , sum( if( partner_pay_stt != 1, od_use_coupon, 0) ) as cancel_coupon ";

        $_REQUEST['shop'] = $this->param['ident'];
        $_REQUEST['partnerPay'] = "order";
        $this->orderList = $this->order->getSum($this->col);
        $this->orderList['order_commission'] = ($this->orderList['tot_goods_price']*$this->pt['pt_pay_rate'])/100;

        $_REQUEST['partnerPay'] = "cancel";
        $this->cancelList = $this->order->getSum($this->col);
        $this->cancelList['order_commission'] = ($this->cancelList['tot_goods_price']*$this->pt['pt_pay_rate'])/100;
        $this->cancelList['cancel_commission'] = $this->cancelList['order_commission'] - $this->cancelList['tot_point'] - $this->cancelList['tot_coupon'];

        $this->commission = $this->orderList['order_commission'];
        $this->commission -= $this->orderList['tot_point'];
        $this->commission -= $this->orderList['tot_coupon'];
        $this->commission -= $this->cancelList['cancel_commission'];
    }   

    public function yetListDescExcel(){
        $this->partner = new \application\models\PartnerModel();
        $this->order = new \application\models\OrderModel();

        $this->header = false; $this->footer = false;
        $this->pt = $this->partner->get("pt_id,pt_name,pt_pay_rate,pt_bank_info", array("pt_id"=>$this->param['ident']));
        $this->pt['pt_bank_info'] = unserialize($this->pt['pt_bank_info']);

        $_REQUEST['shop'] = $this->param['ident'];
        $_REQUEST['partnerPay'] = "order";
        $this->orderList = $this->order->getList($this->col);
        $_REQUEST['partnerPay'] = "cancel";
        $this->cancelList = $this->order->getList($this->col);
    }


    public function calculate(){
        $this->pay = new \application\models\PartnerPayModel();
        $this->order = new \application\models\OrderModel();

        $res = $this->pay->add($_POST);

        $success = 0;
        foreach( explode(",",$_POST['orderList']) as $odId ){
            $res1 = $this->order->partnerCalculate($odId);
            if ( $res1 == "000" ) $success++;
        }
        foreach( explode(",",$_POST['cancelList']) as $odId ){
            $res2 = $this->order->partnerCalculate($odId);
            if ( $res2 == "000" ) $success++;
        }

        $msg = $res=="000" ? $success."개의 주문건의 정산 처리가 완료되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function payList(){
        $this->partner = new \application\models\PartnerModel();
        $this->pay = new \application\models\PartnerPayModel();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->pt_li = $this->partner->getNameList();
        $this->cnt = $this->pay->getCnt();
    }

    public  function payInfoPopup(){
        $this->partner = new \application\models\PartnerModel();
        $this->pay = new \application\models\PartnerPayModel();

        $this->header="head"; $this->footer=false;
        $this->pt_li = $this->partner->getNameList();
        $this->row = $this->pay->get("*", array("ppay_id"=>$this->param['ident']));
    }

    public function payCancel(){
        $this->partner = new \application\models\PartnerModel();
        $this->order = new \application\models\OrderModel();
        $this->pay = new \application\models\PartnerPayModel();

        $this->header="head"; $this->footer=false;
        $this->pt_li = $this->partner->getNameList();

        $success = 0;
        foreach( explode(",",$_POST['orderList']) as $odId ){
            $res1 = $this->order->partnerCalculate($odId,"cancel");
            if ( $res1 == "000" ) $success++;
        }
        foreach( explode(",",$_POST['cancelList']) as $odId ){
            $res2 = $this->order->partnerCalculate($odId,"cancel");
            if ( $res2 == "000" ) $success++;
        }
        $res = $this->row = $this->pay->cancel($this->param['ident']);
        $msg = $res=="000" ? $success."개의 주문건의 정산 처리가 취소되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }
    public function orderDailyAnalysis(){
        $this->partner = new \application\models\PartnerModel();
        $this->order = new \application\models\OrderModel();
        $this->analysis = new \application\models\AnalysisModel();

        $this->pt_li = $this->partner->getNameList("a");
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문'];
        $search['col'] = "dc_dt";
        $search['colby'] = "asc";
 
        $col = "dc_dt";
        foreach($this->pt_li as $key=>$value){
            $col .= ", sum(if(pt_id='$key',od_amount,'0')) as {$key}";
        }
        $this->row = $this->analysis->getAnalysis($col,"web_order","od_dt",$search);
    }

    public function orderDailyAnalysisExcel(){
        $this->partner = new \application\models\PartnerModel();
        $this->order = new \application\models\OrderModel();
        $this->analysis = new \application\models\AnalysisModel();
        $this->pt_li = $this->partner->getNameList("a");
        $this->header = false;  $this->footer = false;

        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문'];
        $search['col'] = "dc_dt";
        $search['colby'] = "asc";
 
        $col = "dc_dt";
        foreach($this->pt_li as $key=>$value){
            $col .= ", count(if(pt_id='$key',1,null)) as {$key}_count";
            $col .= ", sum(if(pt_id='$key',od_amount,'0')) as {$key}_amount";
            $col .= ", sum(if(pt_id='$key',od_qty,'0')) as {$key}_qty";
        }
        $this->rowAll = $this->analysis->getAnalysis($col,"web_order","od_dt",$search);
    }


    public function orderAnalysis(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");

        $orderModel = new \application\models\OrderModel();
        $orderModel->sql_group = " group by pt_id ";
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "od_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $search = array();
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문'];
        $search['col'] =  $_REQUEST['col'];
        $search['colby'] = $_REQUEST['colby'];
        $col = "pt_id,count(od_id) as cnt";
        $col .= ",sum(od_qty) as sum_qty";
        $col .= ", sum(od_goods_price) as sum_goods_price";
        $col .= ", sum(od_use_point) as sum_point";
        $col .= ", sum(od_use_coupon) as sum_coupon";
        $col .= ", sum(od_amount) as sum_amount";
        $this->row = $orderModel->get($col, $search,true);
    }

    public function orderAnalysisExcel(){
        $this->header = false;  $this->footer = false;

        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");

        $orderModel = new \application\models\OrderModel();
        $orderModel->sql_group = " group by pt_id ";
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "od_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $search = array();
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문'];
        $search['col'] =  $_REQUEST['col'];
        $search['colby'] = $_REQUEST['colby'];
        $col = "pt_id,count(od_id) as cnt";
        $col .= ",sum(od_qty) as sum_qty";
        $col .= ", sum(od_goods_price) as sum_goods_price";
        $col .= ", sum(od_use_point) as sum_point";
        $col .= ", sum(od_use_coupon) as sum_coupon";
        $col .= ", sum(od_amount) as sum_amount";
        $this->row = $orderModel->get($col, $search,true);
    }

}
?>
