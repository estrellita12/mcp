<?php
namespace application\Admin\controllers;

class OrderController extends Controller{
    public $search;
    public $cnt;
    public $col;

    public function init(){ 
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();

        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();

        $this->order = new \application\models\OrderModel();
        $this->col = "*";
    }

    public function getNoList(){
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $this->rowArr = array(); 
        foreach($this->order->getList($this->col) as $row){
            $row['od_goods_info'] = json_decode($row['od_goods_info'],true);
            if(empty($this->rowArr) || !array_key_exists($row['od_no'], $this->rowArr)){
                $this->rowArr[$row['od_no']] = array();
                array_push($this->rowArr[$row['od_no']],$row);
            }else if(array_key_exists($row['od_no'], $this->rowArr)) {
                array_push($this->rowArr[$row['od_no']],$row);
            }
        }
        return $this->rowArr;
    }
    public function list(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) {
            $arr = array_keys($GLOBALS['od_stt']);
            array_push($arr,"all");
            $_REQUEST['state'] = $arr;
        }
        if( empty($_REQUEST['term']) ) $_REQUEST['term'] = "orderDate";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }

    public function list1(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "1";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list2(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "2";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list3(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "3";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }

    public function list11(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "11";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list12(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "12";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list13(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "13";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list14(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "14";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }

    public function changeList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "21";
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }

    public function list21(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $_REQUEST['state'] = "21";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list22(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $_REQUEST['state'] = "22";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list29(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $_REQUEST['state'] = "29";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list31(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $_REQUEST['state'] = "31";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list32(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $_REQUEST['state'] = "32";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function returnList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "31";
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list36(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "36";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list41(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "41";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function list42(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "42";
        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }
    public function cancelList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "41";
        if( empty($_REQUEST['paymethod']) ) {
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        $this->cnt = $this->order->getCnt();
        $this->getNoList();                    
    }

    function listExcel(){
        $this->header = false; $this->footer = false;
        if( $this->order->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    public function descPopup(){
        $this->header='head'; $this->footer=false;
        $orderModel = new \application\models\OrderModel();
        $this->row = $orderModel->get($this->col,array("od_id"=>$this->param['ident']));
        $this->row['od_goods_info'] = json_decode($this->row['od_goods_info'],true);
        if( !empty($this->row['od_claim_delivery_charge']) ){
            $this->claimDeliveryCharge = $this->row['od_claim_delivery_charge'];
        }else{
            $this->claimDeliveryCharge = $this->row['od_goods_info']['claimDeliveryCharge']+($this->row['od_delivery_charge_dosan']*2);
        }

        $csModel = new \application\models\CustomerServiceModel();
        $this->cs = $csModel->get("*",array("od_id"=>$this->param['ident']),true);
    }

    public function descListPopup(){
        $this->header='head'; $this->footer=false;

        $orderNoModel = new \application\models\OrderNoModel();
        $search = array();
        $search['od_no'] = $this->param['ident'];
        $this->row = $orderNoModel->get("*",$search);

        $orderModel = new \application\models\OrderModel();
        $search = array();
        $search['od_no'] = $this->param['ident'];
        $this->li = $orderModel->get("*",$search,true);
        $cnt = $orderModel->get("count(od_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];

        $csModel = new \application\models\CustomerServiceModel();
        $this->cs = $csModel->get("*",array("cs_od_no"=>$this->param['ident']),true);
   }

    public function csFormPopup(){
        $this->cs = new \application\models\CustomerServiceModel();
        $this->header = "head"; $this->footer = false;
        $this->order = new \application\models\OrderModel();
        $this->row = $this->order->get("*",array("od_id"=>$this->param['ident']));
    }

    public function addCs(){
        $this->cs = new \application\models\CustomerServiceModel();
        $res = $this->cs->add($_POST);
        $msg = $res == "000" ? "CS 이력이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");

    }




    function overChk(){ 
        $this->header=false; $this->footer=false;
        $res = $this->order->overChk("od_no",$_GET['no']);
        echo json_encode(array('res'=>$res));
    }

    function goodsListPopup(){
        $this->header="head"; $this->footer=false;
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->goods = new \application\models\GoodsModel();
        $this->col = "*";
        $this->cnt = $this->goods->getCnt();
    }

    function goodsOptList(){
        $this->header="head"; $this->footer=false;
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->option = new \application\models\GoodsOptionModel();
        $this->cnt = $this->option->getCnt();
    }


    function add(){
        $partner = new \application\models\PartnerModel();
        $pt = $partner->get("shop_pg_mid,shop_pg_service,pt_grade,shop_pg_test_yn",array("pt_id"=>$_POST['shop']));
        if( !empty($pt['shop_pg_mid']) ){
            $_POST['pgMid'] = $pt['shop_pg_mid'];
            $_POST['pgCompany'] = $pt['shop_pg_service'];
            $_POST['test'] = $pt['shop_pg_test_yn'];
        }else{
            $default = new \application\models\DefaultModel();
            $df = $default->get("shop_pg_mid,shop_pg_service,shop_pg_test_yn",array("df_id"=>"1"));
            $_POST['pgMid'] = $df['shop_pg_mid'];
            $_POST['pgCompany'] = $df['shop_pg_service'];
            $_POST['test'] = $df['shop_pg_test_yn'];
        }

/*
$goods = new \application\models\GoodsModel();
$row1 = $goods->get($_POST['goodsId'],"*");
$_POST['seller'] = $row1['sl_id'];

$option = new \application\models\GoodsOptionModel();
$row2 = $option->get($_POST['goodsOptionId'],"gs_opt_name,gs_opt_add_price");
$_POST['goodsInfo'] = json_encode(array_merge($row1,$row2));
 */
        $this->join = new \application\models\GoodsOptionJoinModel();
        $this->join->colArr['goodsPrice'] = "gs_price_".$pt['pt_grade'];
        $this->join->colArr['supplyPrice'] = "gs_supply_price";
        $this->join->colArr['claimDeliveryCharge'] = "gs_claim_delivery_charge";
        $colArr = array(
            "simg1","goodsId","goodsCode","brand","seller","goodsName",
            "consumerPrice","goodsPrice","supplyPrice","claimDeliveryCharge",
            "deliveryType","deliveryCharge","deliveryFree","deliveryEachUse",
            "optionId","optionName","optionStockQty","addPrice"
        );
        $row = $this->join->get($_POST['goodsOptionId'],$this->join->getCol($colArr));
        $_POST['seller'] = $row['seller'];
        $_POST['goodsInfo'] = json_encode($row);

        $res = $this->order->add($_POST);
        $msg = $res=="000" ? "주문이 등록되었습니다." : "실패\\n다시 시도 해주세요.";
        access($msg , "/Order/list");
    }

    function listUpdateState(){
        $chk = $_POST['chk'];
        if(empty($chk)) access("상태 변경을 위한 주문를 선택하여 주시기 바랍니다." , _PRE_URL);
        $success = 0;
        $state = $_POST['state'];
        $statePre = $_POST['statePre'];
        $type = $_POST['type'];
        foreach($chk as $i){
            $arr = array(
                "odId"=>$_POST['odId'][$i],
                "odNo"=>$_POST['odNo'][$i],
                "userId"=>$_POST['userId'][$i],
                "state"=>$state,
                "statePre"=>$statePre,
                "type"=>$type,
            );
            if(!empty($_POST['deliveryCompany'][$i])) $arr['deliveryCompany'] = $_POST['deliveryCompany'][$i];
            if(!empty($_POST['deliveryNo'][$i])) $arr['deliveryNo'] = $_POST['deliveryNo'][$i];

            if(!empty($_POST['deliveryCompany2'][$i])) $arr['deliveryCompany2'] = $_POST['deliveryCompany2'][$i];
            if(!empty($_POST['deliveryNo2'][$i])) $arr['deliveryNo2'] = $_POST['deliveryNo2'][$i];
            if(!empty($_POST['deliveryCompany3'][$i])) $arr['deliveryCompany3'] = $_POST['deliveryCompany3'][$i];
            if(!empty($_POST['deliveryNo3'][$i])) $arr['deliveryNo3'] = $_POST['deliveryNo3'][$i];
            if(!empty($_POST['deliveryCompany4'][$i])) $arr['deliveryCompany4'] = $_POST['deliveryCompany4'][$i];
            if(!empty($_POST['deliveryNo4'][$i])) $arr['deliveryNo4'] = $_POST['deliveryNo4'][$i];

            $res = $this->order->changeState($arr['state'],$arr['odId'],$arr);
            if($res=="000") $success++;
        }

        $msg = $success > 0 ? $success."개의 주문 상태값을 수정 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function setState(){
        $this->header=false; $this->footer=false;
        $res = $this->order->changeState($_POST['state'],$_POST['odId'],$_POST);
        $msg = $res == "000" ? "주문 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function set(){
        $this->header=false; $this->footer=false;
        $res = $this->order->set($_POST,$_POST['id']);
        $msg = $res == "000" ? "주문 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }



/*
function remove(){
$this->order = new \application\models\OrderModel();
$res = $this->order->remove();
$msg = $res ? "주문 정보가 삭제되었습니다." : "실패\\n다시 시도 해주세요.";
access($msg , _PRE_URL);
}
 */

    function deliveryBultDownload(){
        $this->header = false; $this->footer = false;
        $_REQUEST['state'] = "11";
        if( $this->order->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    function deliveryBultUpload(){
        $this->header = false; $this->footer = false;
        $bulk = new \application\models\BulkExcel();
        $rowAll = $bulk->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            if($i<3) continue;
            // 1 : 주문번호
            // 2 : 주문일련번호
            // 14 : 택배사
            // 15 : 운송장번호
            $arr = array(
                "odId"=>$row['2'],
                "type"=>"송장 일괄 등록",
                "state"=>"13",
                "statePre"=>"11",
            );
            $arr['deliveryCompany'] = $row['14'];
            $arr['deliveryNo'] = $row['15'];
            $res = $this->order->changeState("13",$arr['odId'],$arr);

            if($res=="000") $success++;
        }

        $msg = $success > 0 ? $success."건의 송장 등록이 완료되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    function cancel(){
        $this->order->cancel($this->param['ident']);
    }

    public function salesAnalysis(){
        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $col = "dc_dt, count(distinct od_id) as od_cnt ";
        $table = " (  select * from web_order where od_stt in ({$GLOBALS['od_stt_type']['주문']})) ";
        $this->row = $analysisModel->getAnalysis($col,$table,"od_dt",$search);
    }

    public function salesAnalysisExcel(){
        $this->header = false; $this->footer = false;
        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $col = "dc_dt, count(distinct od_id) as od_cnt ";
        $table = " (  select * from web_order where od_stt in ({$GLOBALS['od_stt_type']['주문']})) ";
        $this->row = $analysisModel->getAnalysis($col,$table,"od_dt",$search);
 
    }

    public function listPopup(){
        $this->header = "head";
        $orderModel = new \application\models\OrderModel();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $search = array();
        $search['od_id_in_all'] = $this->param['ident'];
        $search['rpp'] =  $_REQUEST['rpp'];
        $search['page'] =  $_REQUEST['page'];
        $cnt = $orderModel->get("count(od_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];
        $this->row = $orderModel->get("*",$search,true);
    }

}
?>
