<?php
namespace application\Partner\controllers;

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
        $boardModel = new \application\models\BoardModel();
        $this->board = $boardModel->get("bo_id,bo_name",array("bogr_id"=>"partner_service_center"));
        if( !empty($this->board) ){
            $postModel = new \application\models\PostModel($this->board['bo_id']);
            $search = array();
            $search['bopo_secret_yn'] = "n";
            $search["col"] = "bopo_reg_dt";
            $search["colby"] = "desc";
            $search["rpp"] = "1";
            $row = $postModel->get("*",$search);
            $this->board['list'] = $row;
            if( empty($row) ) $this->board = array();
        }

        $orderModel = new \application\models\OrderModel();
        $search = array();
        $date = date("Y-m-d")." 00:00:00";
        $search["od_dt_then_ge"] = $date;
        $search["od_stt_in_all"] = $GLOBALS['od_stt_type']['주문'];
        $search["pt_id"] = $_SESSION['user_id'];
        $col = " count(distinct od_id) as od_cnt";
        $col .= ", sum(if(od_amount,od_amount,0)) as od_amount ";
        $this->today =  $orderModel->get($col,$search);

        $search = array();
        $search["od_stt_then_ge"] = "2";
        $search["pt_id"] = $_SESSION['user_id'];
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
        $search = array();
        $search['dc_dt_then_ge'] = _DATE_YMD_OD." 00:00:00";
        $search['dc_dt_then_le'] = _DATE_YMD." 23:59:59";
        $col = "dc_dt, count(distinct od_id) as od_cnt ";
        $table = "( select * from web_order where pt_id='{$_SESSION['user_id']}' and od_stt in ({$GLOBALS['od_stt_type']['주문']}) )";
        $this->analysis = $analysisModel->getAnalysis($col, $table, "od_dt", $search);

        $search = array();
        $search['dc_dt_then_ge'] = _DATE_YMD." 00:00:00";
        $search['dc_dt_then_le'] = _DATE_YMD." 23:59:59";
        $col = "dc_dt, count(distinct mb_id) as mb_cnt ";
        $table = "( select * from web_member where pt_id='{$_SESSION['user_id']}' )";
        $this->member = $analysisModel->getAnalysis($col, $table, "mb_reg_dt",$search);
        $this->member = $this->member[0];
    }

    public function notice(){
        $this->header="head"; $this->footer=false;
        $boardModel = new \application\models\BoardModel();
        $rowAll = $boardModel->get("bo_id,bo_name",array("bogr_id"=>"partner_service_center"),true);
        $this->bo_li = array();
        foreach($rowAll as $row){
            $this->bo_li[$row['bo_id']] = $row['bo_name'];
        } 
        if( empty($_REQUEST['board']) ) $_REQUEST['board'] = $rowAll[0]['bo_id'];
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));;
        $this->replyAllow = false;
        if( $this->boardRow['bo_use_reply'] == "y" ){
            if( $this->boardRow['bo_reply_perm']=="partner" || $this->boardRow['bo_reply_perm']=="guest" ){
                $this->replyAllow = true;
            }
        }

        $this->postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->search = array();
        $this->search['bopo_depth'] = "0";
        $this->search['bopo_secret_yn'] = "n";
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "bopo_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        $cnt = $this->postModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $this->postModel->get($this->col,$this->search,true);
    }

    public function postView(){
        $this->header="head"; $this->footer=false;
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Main/notice");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($this->boardRow['bo_read_perm']!="partner") access($msg,"/Main/notice");
        $this->replyAllow = false;
        if( $this->boardRow['bo_use_reply'] == "y" ){
            if( $this->boardRow['bo_reply_perm']=="partner" || $this->boardRow['bo_reply_perm']=="guest" ){
                $this->replyAllow = true;
            }
        }
        $this->commentAllow = false;
        if( $this->boardRow['bo_use_comment'] == "y" ){
            if( $this->boardRow['bo_comment_perm']=="partner" || $this->boardRow['bo_comment_perm']=="guest" ){
                $this->commentAllow = true;
            }
        }

        $this->postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $this->postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Main/notice");

        $this->commentModel = new \application\models\PostCommentModel($_REQUEST['board']);
        $this->commentRow = $this->commentModel->get("*",array("bopo_id"=>$this->param['ident']),true);
    }

    public function postAnswer(){
        $this->header="head"; $this->footer=false;
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Main/notice");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($this->boardRow['bo_reply_perm']!="partner") access($msg,"/Main/notice");
        
        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Main/notice");
    }

    public function addAnswer(){
        $this->header=false; $this->footer=false;
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Main/notice");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($boardRow['bo_reply_perm']!="partner") access($msg,"/Main/notice");

        $postModel = new \application\models\PostModel($_POST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
print_r($_POST);
/*
        $res = $postModel->add($_POST);
        $msg = $res == "000" ? "게시글이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
*/
    }

    public function addComment(){
        $this->header=false; $this->footer=false;
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Main/notice");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $boardRow = $boardModel->get("bo_comment_perm",array("bo_id"=>$_REQUEST['board']));
        if($boardRow['bo_comment_perm']!="partner") access($msg,"/Main/notice");
 
        $commentModel = new \application\models\PostCommentModel($_REQUEST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $commentModel->add($_POST);
        $msg = $res == "000" ? "댓글이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg, _PRE_URL);
    }


}
?>
