<?php
namespace application\Admin\controllers;

class MainController extends Controller{
    public $col;
    public $search;
    public $sql;
    public $cnt;

    public function init(){
        $this->col= "*";
        $this->search = array();
        $this->sql = "";
        $this->cnt = 0;
    }

    public function index(){
        $this->header="header";

        $orderModel = new \application\models\OrderModel();
        $search = array();
        $date =  _DATE_YMD." 00:00:00";
        $search["od_dt_then_ge"] = $date;
        $search["od_stt_in_all"] = $GLOBALS['od_stt_type']['주문'];
        $col = " count(distinct od_id) as od_cnt";
        $col .= ", sum(if(od_amount,od_amount,0)) as od_amount ";
        $this->today =  $orderModel->get($col,$search);

        $search = array();
        $search["od_stt_then_ne"] = "0";
        $col = " count(distinct od_id) as od_cnt";
        $col .= ", count( if(od_stt = 2,1,null) ) as pay_cnt";
        $col .= ", count( if(od_stt = 3,1,null) ) as comp_cnt";
        $col .= ", count( if(od_stt = 11,1,null) ) as ready_cnt";
        $col .= ", count( if(od_stt = 12,1,null) ) as delivery_cnt";
        $col .= ", count( if(od_stt = 21 or od_stt = 22,1,null) ) as change_cnt";
        $col .= ", count( if(od_stt = 31 or od_stt = 32,1,null) ) as return_cnt";
        $col .= ", count( if(od_stt = 41 or od_stt = 42,1,null) ) as cancel_cnt";
        $this->order =  $orderModel->get($col,$search);

        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $col = "dc_dt, count(distinct od_id) as od_cnt ";
        $table = " (  select * from web_order where od_stt in ({$GLOBALS['od_stt_type']['주문']})) ";
        $this->analysis = $analysisModel->getAnalysis($col, $table,"od_dt");

        $goodsModel = new \application\models\GoodsModel();
        $col = "count(gs_id) as cnt";
        $search = array("gs_stt"=>1);
        $cnt =  $goodsModel->get($col,$search);
        $this->goods['wait_cnt'] = empty($cnt['cnt'])?0:$cnt['cnt'];
        $search = array("gs_stt"=>3);
        $cnt =  $goodsModel->get($col,$search);
        $this->goods['defer_cnt'] = empty($cnt['cnt'])?0:$cnt['cnt'];

        $qaModel = new \application\models\GoodsQaModel();
        $search = array();
        $search['gs_qa_answer_yn'] = "n";
        $this->answer = $qaModel->get("count(gs_qa_id) as qa_cnt",$search);
    }
}
?>
