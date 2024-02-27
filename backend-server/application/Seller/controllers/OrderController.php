<?php
namespace application\Seller\controllers;

class OrderController extends Controller{
    public $cnt;
    public $col;

    public function init(){ 
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();

        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $this->order = new \application\models\OrderModel();
        $this->orderModel = new \application\models\OrderModel();
        $this->col = "*";
    }

    public function getSearch(){
        $search = array();
        $search['sl_id'] = $this->my['sl_id'];
        $search['col'] = "od_dt";
        $search['colby'] = "desc";
        $search['od_stt_then_ge'] = "1";
        if( !empty($_REQUEST['rpp']) ){
            $search['rpp'] = $_REQUEST['rpp'];
        }
        if( !empty($_REQUEST['page']) ){
            $search['page'] = $_REQUEST['page'];
        }
        if( !empty($_REQUEST['state']) ){
            if( is_array($_REQUEST['state']) ){
                $state = array_filter( $_REQUEST['state']);
                $search["od_stt_in_all"] = implode(",",$state);
            }else{
                $search['od_stt'] = $_REQUEST['state'];
            }
        }
        if( !empty($this->stt) ){
            $search['od_stt'] = $this->stt;
        }
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['shop']) ){
            $search['pt_id'] = $_REQUEST['shop'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['confirm']) ){
            $search["od_confirm_yn"] = $_REQUEST['confirm'];
        }

        if( !empty($_REQUEST['state']) ){
            if( is_array($_REQUEST['state']) ){
                $state = array_filter( $_REQUEST['state']);
                $search["od_stt_in_all"] = implode(",",$state);
            }else{
                $search['od_stt'] = $_REQUEST['state'];
            }
        }

        if( empty($_REQUEST['paymethod']) ){
            $arr = array_keys($GLOBALS['paymethod']);
            array_push($arr,"all");
            $_REQUEST['paymethod'] = $arr;
        }

        if( empty($_REQUEST['paymethod']) ){
            $paymethod = array_filter( $_REQUEST['paymethod']);
            $search["od_paymethod_in_all"] = implode(",",$paymethod);
        }
        return $search;
    }

    public function getNoList(){
        $this->search = $this->getSearch();
        $row = $this->orderModel->get("count(od_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];

        $this->rowArr = array(); 
        foreach($this->orderModel->get($this->col,$this->search,true) as $row){
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
        if( empty($_REQUEST['term']) ) $_REQUEST['term'] = "od_dt";
        if( empty($_REQUEST['state']) ) {
            $arr = array_keys($GLOBALS['od_stt']);
            array_push($arr,"all");
            $_REQUEST['state'] = $arr;
        }
        $this->getNoList();                    
    }

    public function list1(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "1";
        $this->stt = "1";
        $this->getNoList();                    
    }

    public function list2(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "2";
        $this->stt = "2";
        $this->getNoList();                    
    }

    public function list3(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "3";
        $this->stt = "3";
        $this->getNoList();                    
    }

    public function list11(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "11";
        $this->stt = "11";
        $this->getNoList();  
    }

    public function list12(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "12";
        $this->stt = "12";
        $this->getNoList();                    
    }

    public function list13(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "13";
        $this->stt = "13";
        $this->getNoList();                    
    }

    public function list14(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "14";
        $this->stt = "14";
        $this->getNoList();                    
    }

    public function changeList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "22";
        $this->getNoList();                    
    }

    public function returnList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "32";
        $this->getNoList();                    
    }

    public function cancelList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "41";
        $this->getNoList();                    
    }

    public function listExcel(){
        $this->header = false; $this->footer = false;
        $this->search = $this->getSearch();
        $row = $this->orderModel->get("count(od_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
        if( $this->cnt < 1 ) access("출력할 자료가 없습니다.");
        $this->row = $this->orderModel->get($this->col,$this->search,true);
    }

    public function descPopup(){
        $this->header='head'; $this->footer=false;
        $this->row = $this->orderModel->get($this->col,array("od_id"=>$this->param['ident']));
        if( $this->row['sl_id'] != $this->my['sl_id'] ) access("접근 권한이 존재하지 않습니다.","close");
        $this->row['od_goods_info'] = json_decode($this->row['od_goods_info'],true);
        if( !empty($this->row['od_claim_delivery_charge']) ){
            $this->claimDeliveryCharge = $this->row['od_claim_delivery_charge'];
        }else{
            $this->claimDeliveryCharge = $this->row['od_goods_info']['claimDeliveryCharge']+($this->row['od_delivery_charge_dosan']*2);
        }
        $csModel = new \application\models\CustomerServiceModel();
        $search = array();
        $search['od_id'] = $this->param['ident'];
        $this->cs = $csModel->get("*",$search,true);
    }

    public function csFormPopup(){
        $this->header = "head"; $this->footer = false;
        $csModel = new \application\models\CustomerServiceModel();
        $orderModel = new \application\models\OrderModel();
        $this->row = $orderModel->get("*",array("od_id"=>$this->param['ident']));
    }

    public function addCs(){
        $this->header=false; $this->footer=false;
        $csModel = new \application\models\CustomerServiceModel();
        $res = $csModel->add($_POST);
        $msg = $res == "000" ? "CS 이력이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function listUpdateState(){
        $this->header=false; $this->footer=false;
        $chk = $_POST['chk'];
        if(empty($chk)) access("상태 변경을 위한 주문를 선택하여 주시기 바랍니다." , _PRE_URL);
        $success = 0;
        $state = $_POST['state'];
        $message = $_POST['message'];
        foreach($chk as $i){
            $odId = $_POST['odId'][$i];
            $arr = array(
                "odId"=>$odId,
                "state"=>$state,
                "type"=>"일괄처리",
                "message"=>$message,
            );
            if(!empty($_POST['deliveryCompany'][$i])) $arr['deliveryCompany'] = $_POST['deliveryCompany'][$i];
            if(!empty($_POST['deliveryNo'][$i])) $arr['deliveryNo'] = $_POST['deliveryNo'][$i];
            if(!empty($_POST['deliveryCompany2'][$i])) $arr['deliveryCompany2'] = $_POST['deliveryCompany2'][$i];
            if(!empty($_POST['deliveryNo2'][$i])) $arr['deliveryNo2'] = $_POST['deliveryNo2'][$i];
            if(!empty($_POST['deliveryCompany3'][$i])) $arr['deliveryCompany3'] = $_POST['deliveryCompany3'][$i];
            if(!empty($_POST['deliveryNo3'][$i])) $arr['deliveryNo3'] = $_POST['deliveryNo3'][$i];
            if(!empty($_POST['deliveryCompany4'][$i])) $arr['deliveryCompany4'] = $_POST['deliveryCompany4'][$i];
            if(!empty($_POST['deliveryNo4'][$i])) $arr['deliveryNo4'] = $_POST['deliveryNo4'][$i];
            $res = $this->orderModel->changeState($arr['state'],$odId,$arr);
            if($res=="000") $success++;
        }

        $msg = $success > 0 ? $success."개의 주문 상태값을 수정 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function setState(){
        $this->header=false; $this->footer=false;
        $res = $this->orderModel->changeState($_POST['state'],$_POST['odId'],$_POST);
        $msg = $res == "000" ? "주문 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function set(){
        $res = $this->orderModel->set($_POST,$_POST['id']);
        $msg = $res == "000" ? "주문 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }


    public function deliveryBultDownload(){
        $this->header = false; $this->footer = false;
        $_REQUEST['state'] = "11";
        $this->search = $this->getSearch();
        $row = $this->orderModel->get("count(od_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
        if( $this->cnt < 1 ) access("출력할 자료가 없습니다.");
        $this->row = $this->orderModel->get($this->col,$this->search,true);
    }

    public function deliveryBultUpload(){
        $this->header = false; $this->footer = false;
        $orderModel = new \application\models\OrderModel();
        $bulkModel = new \application\models\BulkExcel();
        $rowAll = $bulkModel->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            if($i<3) continue;
            $odNo= $row['1']; // 주문번호
            $odId= $row['2']; // 주문일련번호
            $deliveryCompany = $row['14']; // 택배사
            $deliveryNo = $row['15']; // 운송장번호
            if( empty($deliveryCompany) || empty($deliveryNo) ) continue;
            $order =  $orderModel->get("sl_id,od_stt",array("od_id"=>$odId));
            if( $order['sl_id'] != $this->my['sl_id'] ) continue;
            if( $order['od_stt'] != 11 && $order['od_stt'] != 12 ) continue;
            $arr = array(
                "odId"=>$odId,
                "type"=>"일괄처리",
                "message"=>"송장 일괄 등록",
            );
            $arr['deliveryCompany'] = $deliveryCompany;
            $arr['deliveryNo'] = $deliveryNo;
            $res = $this->order->changeState("13",$odId,$arr);
            if($res=="000") $success++;
        }

        $msg = $success > 0 ? $success."건의 송장 등록이 완료되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function analysis(){
        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $col = "dc_dt";
        $col .= ", count(distinct od_id) as od_cnt ";
        $table = " ( select * from web_order where sl_id='{$_SESSION['user_id']}' and od_stt in ({$GLOBALS['od_stt_type']['주문']})  ) ";
        $this->row = $analysisModel->getAnalysis($col,$table,"od_dt");
    }

    public function analysisExcel(){
        $this->header = false; $this->footer = false;
        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $col = "dc_dt";
        $col .= ", count(distinct od_id) as od_cnt ";
        $col .= ", sum(if(od_qty,od_qty,0)) as sum_qty ";
        $col .= ", sum(if(od_amount,od_amount,0)) as od_amount ";
        $table = " ( select * from web_order where sl_id='{$_SESSION['user_id']}' and od_stt in ({$GLOBALS['od_stt_type']['주문']})  ) ";
        $this->row = $analysisModel->getAnalysis($col,$table,"od_dt");
    }
}
?>
