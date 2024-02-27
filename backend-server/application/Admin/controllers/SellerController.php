<?php
namespace application\Admin\controllers;

use \Exception;

class SellerController extends Controller{
    public $cnt;
    public $col;

    public function init(){ 
       $this->col = "*";
    }

    public function list(){
        $this->seller = new \application\models\SellerModel();
        $grade = new \application\models\SellerGradeModel();
        $this->gr_li = $grade->getNameList();

        $_REQUEST['state'] = "2";
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->seller->getCnt();
    }

    public function listExcel(){
        $this->seller = new \application\models\SellerModel();
        $grade = new \application\models\SellerGradeModel();
        $this->gr_li = $grade->getNameList();

        $this->header = false; $this->footer = false;
        if( $this->seller->getCnt() < 1 ){access("출력할 자료가 없습니다.");exit;}
    }

    public function popup(){
        $this->seller = new \application\models\SellerModel();

        $this->header = 'head'; $this->footer=false;
        $this->tabs = "<ul class='tabs'>";
        $active = $this->param['page']=="infoPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Seller/infoPopup/{$this->param['ident']}'>공급사 정보</a></li> ";
        $active = $this->param['page']=="managerPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Seller/managerPopup/{$this->param['ident']}'>담당자 정보</a></li> ";
        $active = $this->param['page']=="saupjaPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Seller/saupjaPopup/{$this->param['ident']}'>사업자 정보</a></li> ";
        $active = $this->param['page']=="deliveryPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Seller/deliveryPopup/{$this->param['ident']}'>배송정책 정보</a></li> ";
        $active = $this->param['page']=="goodsListPopup"?"active":"";
        $this->tabs .= " <li class='{$active}'><a href='/Seller/goodsListPopup/{$this->param['ident']}'>상품 정보</a></li> ";
        $this->tabs .= "</ul>";
        $this->row = $this->seller->get($this->col, array("sl_id"=>$this->param['ident']));
        if( empty($this->row) ) access("존재하지 않는 회원입니다.","close");
    }

    public function infoPopup(){
        $this->popup();
        $grade = new \application\models\SellerGradeModel();
        $this->gr_li = $grade->getNameList();
    }

    public function managerPopup(){
        $this->popup();
        $this->row['sl_manager'] = !empty($this->row['sl_manager'])?unserialize($this->row['sl_manager']):array(3);
        $this->row['sl_manager2'] = !empty($this->row['sl_manager2'])?unserialize($this->row['sl_manager2']):array("","","","");
        $this->row['sl_manager3'] = !empty($this->row['sl_manager3'])?unserialize($this->row['sl_manager3']):array("","","","");
        $this->row['sl_manager4'] = !empty($this->row['sl_manager4'])?unserialize($this->row['sl_manager4']):array("","","","");
    }
    public function saupjaPopup(){
        $this->popup();
    }

    public function deliveryPopup(){
        $this->popup();
    }

    public function goodsListPopup(){
        $this->popup();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
        $this->goods = new \application\models\GoodsModel();

        $_REQUEST['seller'] = $this->param['ident'];
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->goods->getCnt();
    }

    public function add(){
        $this->seller = new \application\models\SellerModel();
        $res = $this->seller->add($_POST);
        $msg = $res == "000" ? "공급사가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Seller/newList");
    }

    public function set(){
        $this->header = false; $this->footer = false;
        $this->seller = new \application\models\SellerModel();
        $res = $this->seller->set( array_merge($_POST,$_FILES) );
        $msg = $res == "000" ? "공급사 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function setOnlyPartner(){
        $this->seller = new \application\models\SellerModel();
        $res = $this->seller->set($_POST);
        if($res=="000"){
            if($_POST['onlyPartnerYn']=="y" && empty($_POST['onlyPartnerId'])) return;
            $goods = new \application\models\GoodsModel();
            $goods->onlyPartner($_POST['id'],$_POST['onlyPartnerYn'],$_POST['onlyPartnerId']);
        }
        $msg = $res == "000" ? "공급사 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }


    public function approval(){
        $this->seller = new \application\models\SellerModel();
        $this->header = false; $this->footer = false;

        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->seller->approval($id);
            if( $res == "000" ) $success++;
        }
        $msg = $success > 0 ? $success."개의 공급사를 승인 처리 하였습니다." :"실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function newList(){
        $this->seller = new \application\models\SellerModel();
        $_REQUEST['state'] = "1";
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->seller->getCnt();
    }

    public function expire(){
        $this->seller = new \application\models\SellerModel();
        $this->header = false; $this->footer = false;
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->seller->expire($id);
            if( $res == "000" ) $success++;
        }
        $msg = $success > 0 ? $success."개의 공급사를 만료 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function expireList(){
        $this->seller = new \application\models\SellerModel();
        $_REQUEST['state'] = "3";
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->seller->getCnt();
    }

    public function remove(){
        $this->seller = new \application\models\SellerModel();
        $this->header = false; $this->footer = false;
        $res = $this->seller->remove($this->param['ident']);
        $msg = $res == "000" ? "공급사 정보가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function gradeForm(){
        $this->grade = new \application\models\SellerGradeModel();
    }

    public function setGrade(){
        $this->grade = new \application\models\SellerGradeModel();
        $success = 0;
        foreach($_POST['li'] as $grd){
            $res = $this->grade->set($grd,$grd['id']);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "등급 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function orderListPopup(){
        $this->order = new \application\models\OrderModel();

        $this->header = "head"; $this->footer = false;
        $_REQUEST['id'] = $this->param['ident'];
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->order->getCnt();
    }

    public function yetList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
 
        $this->sellerModel = new \application\models\SellerModel();
        $orderModel = new \application\models\OrderModel();
        $orderModel->calcUnion($_REQUEST['beg'],$_REQUEST['end'],"seller");
        $search = array();
        $search['od_stt_then_ne'] = "0";
        $search['rpp'] = $_REQUEST['rpp'];
        $search['page'] = $_REQUEST['page'];
     
        $col = " sl_id, group_concat(od_id) as od_idl, count(*) as od_cnt ";
        $col .= " , sum(od_goods_price) as tot_goods_price  ";
        $col .= " , sum(od_supply_price) as tot_supply_price  ";
        $col .= " , sum(od_delivery_charge+od_delivery_charge_dosan) as tot_delivery_charge ";
        $col .= " , sum(od_claim_delivery_charge) as tot_claim_delivery_charge  ";
        $orderModel->sql_group = "group by sl_id";
        $cnt = $orderModel->get("count(sl_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];

        $orderModel->sql_group = "group by sl_id";
        $this->row = $orderModel->get($col,$search,true);
    }


    public function yetPayInfoPopup(){
        $this->header = "head"; $this->footer = false;
        $sellerModel = new \application\models\SellerModel();
        $this->seller = $sellerModel->get("*", array("sl_id"=>$this->param['ident']));

        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
 
        $this->sellerModel = new \application\models\SellerModel();
        $orderModel = new \application\models\OrderModel();
        $orderModel->calcUnion($_REQUEST['beg'],$_REQUEST['end'],"seller");
        $search = array();
        $search['od_stt_then_ne'] = "0";
        $search['sl_id'] = $this->param['ident'];
     
        $col = " sl_id, group_concat(od_id) as od_idl, count(*) as od_cnt ";
        $col .= " , sum(od_goods_price) as tot_goods_price  ";
        $col .= " , sum(od_supply_price) as tot_supply_price  ";
        $col .= " , sum(od_delivery_charge+od_delivery_charge_dosan) as tot_delivery_charge ";
        $col .= " , sum(od_claim_delivery_charge) as tot_claim_delivery_charge  ";
        $this->row = $orderModel->get($col,$search,false);
    }   

    public function yetListDescExcel(){
        $this->header = false; $this->footer = false;
        $this->seller = new \application\models\SellerModel();
        $this->sl = $this->seller->get("sl_id,sl_name,sl_pay_rate,sl_bank_name,sl_bank_account,sl_bank_holder", array("sl_id"=>$this->param['ident']));

        $this->col = " sl_id, od_id, od_no, od_goods_info, od_dt, od_rcent_dt, seller_pay_stt, od_paymethod, od_stt, od_goods_price, od_supply_price  ";
        $this->col .= " , if(od_stt = '29',od_claim_delivery_charge,0) as od_change_delivery_charge  ";
        $this->col .= " , if(od_stt = '37',od_claim_delivery_charge,0) as od_return_delivery_charge  ";

        $this->order = new \application\models\OrderModel();
        $_REQUEST['seller'] = $this->param['ident'];
        $_REQUEST['sellerPay'] = "order";
        $this->orderList = $this->order->getList($this->col);
        $_REQUEST['sellerPay'] = "cancel";
        $this->cancelList = $this->order->getList($this->col);
        $_REQUEST['sellerPay'] = "delivery";
        $this->deliveryList = $this->order->getList($this->col);
    }

    public function calculate(){
        $this->header = false; $this->footer = false;
        $this->yetListDescExcel();
        $value = array();
        $value['seller'] = $_POST['seller'];
        $value['rate'] = $_POST['rate'];
        $value['bank'] = $_POST['bank'];
        $value['account'] = $_POST['account'];
        $value['holder'] = $_POST['holder'];
        $value['begin'] = $_POST['begin'];
        $value['end'] = $_POST['end'];
        $value['orderList'] = json_encode($this->orderList);
        //$value['cancelList'] = json_encode($this->cancelList);
        //$value['deliveryList'] = json_encode($this->deliveryList);
        //$value['goodsPrice'] = $_POST['supplyPrice'];
        //$value['orderCommission'] = $_POST['orderCommission'];
        $value['deliveryCharge'] = $_POST['deliveryCharge'];
        $value['commission'] = $_POST['commission'];
        $value['memo'] = $_POST['memo'];
        $this->pay = new \application\models\SellerPayModel();
        $res = $this->pay->add($value);
        if($res != "000"){
            access( "실패\\n".$GLOBALS['res_code'][$res] , "close");
        }
    
        $this->order = new \application\models\OrderModel();
        $res = $this->order->sellerCalculate($_POST['orderList']);
        
/*
        foreach( explode(",",$_POST['orderList']) as $odId ){
            $success = 0;
            $res1 = $this->order->sellerCalculate($odId);
            if ( $res1 == "000" ) $success++;
        }
        foreach( explode(",",$_POST['cancelList']) as $odId ){
            $res2 = $this->order->sellerCalculate($odId);
            if ( $res2 == "000" ) $success++;
        }
        foreach( explode(",",$_POST['deliveryList']) as $odId ){
            $res3 = $this->order->sellerCalculate($odId);
            if ( $res3 == "000" ) $success++;
        }
*/
        $msg = $res == "000" ? "정산 처리가 완료되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function payList(){
        $this->seller = new \application\models\SellerModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->sl_li = $this->seller->getNameList();
        $this->pay = new \application\models\SellerPayModel();
        $this->cnt = $this->pay->getCnt();
    }

    public function payListDescExcel(){
        $this->header = false; $this->footer = false;

        $payModel = new \application\models\SellerPayModel();
        $this->row = $payModel->get("*",array("spay_id"=>$this->param['ident']));

        $sellerModel = new \application\models\SellerModel();
        $seller = $sellerModel->get("sl_name",array("sl_id"=>$this->row['sl_id']));
        $this->row['sl_name'] = $seller['sl_name'];
        $this->row['beg'] = $this->row['spay_begin'];
        $this->row['end'] = $this->row['spay_end'];
        $this->orderList = json_decode($this->row['spay_order_idl'],true);
        $this->cancelList = json_decode($this->row['spay_cancel_idl'],true);
        $this->deliveryList = json_decode($this->row['spay_delivery_idl'],true);
        /*
        $this->seller = new \application\models\SellerModel();
        $this->sl = $this->seller->get("sl_id,sl_name,sl_pay_rate,sl_bank_name,sl_bank_account,sl_bank_holder", array("sl_id"=>$this->param['ident']));

        $this->col = " sl_id, od_id, od_no, od_goods_info, od_dt, od_rcent_dt, seller_pay_stt, od_paymethod, od_stt, od_goods_price, od_supply_price  ";
        $this->col .= " , if(od_stt = '29',od_claim_delivery_charge,0) as od_change_delivery_charge  ";
        $this->col .= " , if(od_stt = '37',od_claim_delivery_charge,0) as od_return_delivery_charge  ";

        $this->order = new \application\models\OrderModel();
        $_REQUEST['seller'] = $this->param['ident'];
        $_REQUEST['sellerPay'] = "order";
        $this->orderList = $this->order->getList($this->col);
        $_REQUEST['sellerPay'] = "cancel";
        $this->cancelList = $this->order->getList($this->col);
        $_REQUEST['sellerPay'] = "delivery";
        $this->deliveryList = $this->order->getList($this->col);
        */
    }

    public function payInfoPopup(){
        $this->seller = new \application\models\SellerModel();
        $this->header="head"; $this->footer=false;
        $this->sl_li = $this->seller->getNameList();
        $this->pay = new \application\models\SellerPayModel();
        $this->row = $this->pay->get("*",array("spay_id"=>$this->param['ident']));
    }

    public function payCancel(){
        $this->header="head"; $this->footer=false;
        $this->seller = new \application\models\SellerModel();
        $this->sl_li = $this->seller->getNameList();

        $this->order = new \application\models\OrderModel();
        $res = $this->order->sellerCalculate($odId,"cancel");
        /*
        $success = 0;
        foreach( explode(",",$_POST['orderList']) as $odId ){
            $res1 = $this->order->sellerCalculate($odId,"cancel");
            if ( $res1 == "000" ) $success++;
        }
        foreach( explode(",",$_POST['cancelList']) as $odId ){
            $res2 = $this->order->sellerCalculate($odId,"cancel");
            if ( $res2 == "000" ) $success++;
        }
        foreach( explode(",",$_POST['deliveryList']) as $odId ){
            $res3 = $this->order->sellerCalculate($odId,"cancel");
            if ( $res3 == "000" ) $success++;
        }
        */
        $this->pay = new \application\models\SellerPayModel();
        $res = $this->row = $this->pay->cancel($this->param['ident']);
        $msg = $res=="000" ? "정산 처리가 취소되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function orderDailyAnalysis(){
        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $this->analysis = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $_REQUEST['state'] = $GLOBALS['od_stt_type']['주문'];
        $col = "dc_dt";
        foreach($this->sl_li as $key=>$value){
            $col .= ", sum(if(sl_id='$key',od_amount,'0')) as {$key}";
        }
        $this->row = $this->analysis->getAnalysis($col,"web_order","od_dt");
    }

    public function orderDailyAnalysisExcel(){
        $this->header=false; $this->footer=false;
        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $this->analysis = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $_REQUEST['state'] = $GLOBALS['od_stt_type']['주문'];
        $col = "dc_dt";
        foreach($this->sl_li as $key=>$value){
            $col .= ", sum(if(sl_id='$key',od_amount,'0')) as {$key}_amount";
            $col .= ", count(if(sl_id='$key',1,null)) as {$key}_count";
            $col .= ", sum(if(sl_id='$key',od_qty,'0')) as {$key}_qty";
        }
        $this->rowAll = $this->analysis->getAnalysis($col,"web_order","od_dt");
    }



    public function orderAnalysis(){
        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $orderModel = new \application\models\OrderModel();
        $orderModel->sql_group = " group by sl_id ";
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "sum_amount";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";

        $search = array();
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt'] = $GLOBALS['od_stt_type']['주문'];
        $search['col'] = $_REQUEST['col'];
        $search['colby'] = $_REQUEST['colby'];

        $col = "sl_id,count(od_id) as cnt";
        $col .= ",sum(od_qty) as sum_qty";
        $col .= ", sum(od_goods_price) as sum_goods_price";
        $col .= ", sum(od_supply_price) as sum_supply_price";
        $col .= ", sum(od_amount) as sum_amount";
        $this->row = $orderModel->get($col,$search,true);
    }

    public function orderAnalysisExcel(){
        $this->header=false; $this->footer=false;
        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $orderModel = new \application\models\OrderModel();
        $orderModel->sql_group = " group by sl_id ";
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "sum_amount";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";

        $search = array();
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt'] = $GLOBALS['od_stt_type']['주문'];
        $search['col'] = $_REQUEST['col'];
        $search['colby'] = $_REQUEST['colby'];

        $col = "sl_id,count(od_id) as cnt";
        $col .= ",sum(od_qty) as sum_qty";
        $col .= ", sum(od_goods_price) as sum_goods_price";
        $col .= ", sum(od_supply_price) as sum_supply_price";
        $col .= ", sum(od_amount) as sum_amount";
        $this->row = $orderModel->get($col,$search,true);
    }

}

?>
