<?php
namespace application\Partner\controllers;

class MemberController extends Controller{
    public $col;
    public $search;
    public $sql;

    public function init(){ 
        $this->col = "*";
        $this->search = array();
        $this->sql = "";
    }

    public function list(){
        $gradeModel = new \application\models\MemberGradeModel();
        $this->gr_li = $gradeModel->getNameList();

        $memberModel = new \application\models\MemberModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = $_REQUEST['beg']." 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = $_REQUEST['end']." 23:59:59";
        }
        if( !empty($_REQUEST['col']) ){
            $this->search['col'] = $_REQUEST['col'];
            if( !empty($_REQUEST['colby']) ) $this->search['colby'] = $_REQUEST['colby'];
        }
        $cnt = $memberModel->get("count(mb_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $memberModel->get($this->col,$this->search,true,$this->sql);
    }

    public function form(){
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Member/list":urlencode($_REQUEST['returnUrl']);
    }
    public function overChk(){
        $this->header=false; $this->footer=false;
        $userModel = new \application\models\UserModel();
        $res = $userModel->overChk("user_id",$_GET['id']);
        echo json_encode(array('res'=>$res));
    }

    public function listExcel(){
        $this->header = false; $this->footer = false;

        $gradeModel = new \application\models\MemberGradeModel();
        $this->gr_li = $gradeModel->getNameList();

        $memberModel = new \application\models\MemberModel();
        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = $_REQUEST['beg']." 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = $_REQUEST['end']." 23:59:59";
        }
        if( !empty($_REQUEST['col']) ){
            $this->search['col'] = $_REQUEST['col'];
            if( !empty($_REQUEST['colby']) ) $this->search['colby'] = $_REQUEST['colby'];
        }
        $row = $memberModel->get("count(mb_id) as cnt",$this->search);
        $this->cnt = $row['cnt'];
        if( $this->cnt < 1 ) access("출력할 자료가 없습니다.");
        $this->row = $memberModel->get($this->col,$this->search,true,$this->sql);
    }

    public function popup(){
        $this->header='head'; $this->footer=false;
        $this->tabs = "<ul class='tabs'>";
        $active = $this->param['page']=="infoPopup"?"active":"";
        $this->tabs .= " <li class={$active}><a href='/Member/infoPopup/{$this->param['ident']}'>회원 정보</a></li> ";
        $active = $this->param['page']=="orderListPopup"?"active":"";
        $this->tabs .= " <li class={$active}><a href='/Member/orderListPopup/{$this->param['ident']}'>주문 내역</a></li> ";
        $this->tabs .= "</ul>";
    }

    public function infoPopup(){
        $this->popup();
        $this->pt_li = $this->partnerModel->getNameList("n",3);
        $gradeModel = new \application\models\MemberGradeModel();
        $this->gr_li = $gradeModel->getNameList();

        $memberModel = new \application\models\MemberModel();
        $this->row = $memberModel->get($this->col, array("mb_id"=>$this->param['ident']));
        if(empty($this->row)) access("존재하지 않는 회원입니다.","close");
    }

    public function orderListPopup(){
        $this->popup();
        $orderModel = new \application\models\OrderModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search = array();
        $this->search['pt_id'] = $_SESSION['user_id'];
        $this->search['mb_id'] = $this->param['ident'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        $this->search['od_stt_then_ge'] = "1";
        $cnt = $orderModel->get("count(od_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];
        $this->row = $orderModel->get($this->col,$this->search,true,$this->sql);
    }

    public function add(){
        $this->header=false;$this->footer=false;
        $memberModel = new \application\models\MemberModel();
        $_POST['state'] = "2";  // config 정책에 따라 결정되도록 설정 변경
        $_POST['shop'] = $this->my['pt_id'];
        $res = $memberModel->add($_POST);
        $msg = $res == "000" ? "회원이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Member/list":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function set(){
        $this->header=false;$this->footer=false;
        $memberModel = new \application\models\MemberModel();
        $_POST['shop'] = $this->my['pt_id'];
        $res = $memberModel->set($_POST, $this->param['ident']);
        $msg = $res == "000" ? "회원 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function sleep(){
        $memberModel = new \application\models\MemberModel();
        //$sleepModel = new \application\models\MemberSleepModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $memberModel->sleep($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."명 회원이 휴먼 처리 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function wake(){
        $memberModel = new \application\models\MemberModel();
        //$sleepModel = new \application\models\MemberSleepModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $memberModel->wake($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."명 회원의 휴먼 상태가 해제 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function remove(){
        $memberModel = new \application\models\MemberModel();
        $id = $this->param['ident'];
        $arr = array(
            "id"=>$id,
            "shop"=>$row['pt_id'],
            "reason"=>"가맹점 관리자 탈퇴 처리"    
        );
        $res = $memberModel->leave($id,$arr);
        $msg = $res == "000" ? "회원 탈퇴 처리가 완료 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function sleepList(){
        $gradeModel = new \application\models\MemberGradeModel();
        $this->gr_li = $gradeModel->getNameList();

        $sleepModel = new \application\models\MemberSleepModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = $_REQUEST['beg']." 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = $_REQUEST['end']." 23:59:59";
        }

        $cnt = $sleepModel->get("count(mb_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $sleepModel->get($this->col,$this->search,true,$this->sql);
    }

    public function leaveList(){
        $gradeModel = new \application\models\MemberGradeModel();
        $this->gr_li = $gradeModel->getNameList();

        $leaveModel = new \application\models\MemberLeaveModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;

        $this->search = array();
        $this->search['pt_id'] = $this->my['pt_id'];
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            $this->search[$_REQUEST['srch']] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = $_REQUEST['beg']." 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = $_REQUEST['end']." 23:59:59";
        }
        if( !empty($_REQUEST['col']) ){
            $this->search['col'] = $_REQUEST['col'];
            if( !empty($_REQUEST['colby']) ){
                $this->search['colby'] = $_REQUEST['colby'];
            }
        }

        $cnt = $leaveModel->get("count(mb_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $leaveModel->get($this->col,$this->search,true,$this->sql);
    }

    public function analysis(){
        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $col = "dc_dt, count(distinct mb_id) as mb_cnt ";
        $this->row = $analysisModel->getAnalysis($col," ( select * from web_member where pt_id='{$_SESSION['user_id']}' ) ","mb_reg_dt",$search);
    }

    public function registerAnalysisExcel(){
        $this->header = false; $this->footer = false;
        $analysisModel = new \application\models\AnalysisModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $col = "dc_dt, count(distinct mb_id) as mb_cnt ";
        $this->row = $analysisModel->getAnalysis($col," ( select * from web_member where pt_id='{$_SESSION['user_id']}' ) ","mb_reg_dt", $search);
    }
}
?>
