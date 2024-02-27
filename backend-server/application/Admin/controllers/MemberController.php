<?php
namespace application\Admin\controllers;

class MemberController extends Controller{
    public $col;
    public $cnt;

    public function init(){ 
        $this->col = "*";
    }

    public function list(){
        $this->member = new \application\models\MemberModel();
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n",3);

        $this->grade = new \application\models\MemberGradeModel();
        $this->gr_li = $this->grade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->member->getCnt();
    }

    public function form(){
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n");
    }

    public function listExcel(){
        $this->member = new \application\models\MemberModel();
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n",3);

        $this->grade = new \application\models\MemberGradeModel();
        $this->gr_li = $this->grade->getNameList();

        $this->header = false; $this->footer = false;
        if( $this->member->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    public function get(){ 
        $this->member = new \application\models\MemberModel();
        $this->header=false; $this->footer=false;
        $this->col = "mb_id as id, mb_name as name, mb_zip as zip, mb_addr1 as addr1, mb_addr2 as addr2, mb_addr3 as addr3, mb_cellphone as cellphone, mb_email as email , pt_id as shop";
        $row = $this->member->get($this->col,array("mb_id"=>$this->param['ident']));
        echo json_encode($row);
    }

    public function popup(){
        $this->member = new \application\models\MemberModel();
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n",3);

        $this->grade = new \application\models\MemberGradeModel();
        $this->gr_li = $this->grade->getNameList();

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
        $this->row = $this->member->get($this->col, array("mb_id"=>$this->param['ident']));
        if(empty($this->row)) access("존재하지 않는 회원입니다.","close");
    }

    public function savePoint(){
        $memberModel = new \application\models\MemberModel();
        $res = $memberModel->savePoint($this->param['ident'],$_GET['point'],"관리자 직접 추가");
        $msg = $res == "000" ? "회원 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function usePoint(){
        $memberModel = new \application\models\MemberModel();
        $res = $memberModel->usePoint($this->param['ident'],$_GET['point'],"잘못 지급");
        $msg = $res == "000" ? "회원 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }



    public function orderListPopup(){
        $this->popup();
        $this->order = new \application\models\OrderModel();
        $_REQUEST['userId'] = $this->param['ident'];
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->order->getCnt();
    }

    public function add(){
        $this->member = new \application\models\MemberModel();
        $_POST['state'] = "2";  // config 정책에 따라 결정되도록 설정 변경
        $res = $this->member->add($_POST);
        $msg = $res == "000" ? "회원이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Member/list");
    }

    public function set(){
        $this->member = new \application\models\MemberModel();
        $res = $this->member->set($_POST, $this->param['ident']);
        $msg = $res == "000" ? "회원 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function sleep(){
        $this->member = new \application\models\MemberModel();
        $this->sleep = new \application\models\MemberSleepModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->member->sleep($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."명 회원이 휴먼 처리 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function wake(){
        $this->member = new \application\models\MemberModel();
        $this->sleep = new \application\models\MemberSleepModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->member->wake($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."명 회원의 휴먼 상태가 해제 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function remove(){
        $this->member = new \application\models\MemberModel();
        $id = $this->param['ident'];
        $arr = array(
            "id"=>$id,
            "shop"=>$row['pt_id'],
            "reason"=>"관리자 탈퇴 처리"    
        );
        $res = $this->member->leave($id,$arr);
        $msg = $res == "000" ? "회원 탈퇴 처리가 완료 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    public function sleepList(){
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n",3);

        $this->grade = new \application\models\MemberGradeModel();
        $this->gr_li = $this->grade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->sleep = new \application\models\MemberSleepModel();
        $this->cnt = $this->sleep->getCnt();
    }

    public function sleepListExcel(){
        $this->sleep = new \application\models\MemberSleepModel();
        $this->header = false; $this->footer = false;
        if( $this->sleep->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    public function leaveList(){
        $this->partner = new \application\models\PartnerModel();
        $this->leave = new \application\models\MemberLeaveModel();
        $this->pt_li = $this->partner->getNameList("n",3);
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->leave->getCnt();
    }

    public function leaveListExcel(){
        $this->leave = new \application\models\MemberLeaveModel();
        $this->header = false; $this->footer = false;
        if( !empty( $this->param['ident'] ) ){
            $_REQUEST['idxl'] = $this->param['ident'];
            $_REQUEST['col'] = " FIELD ( idx, {$this->param['ident']} ) ";
        }
        if( $this->leave->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    function gradeForm(){
        $this->grade = new \application\models\MemberGradeModel();
    }

    function setGrade(){
        $this->grade = new \application\models\MemberGradeModel();
        $success = 0;
        foreach($_POST['li'] as $grd){
            $res = $this->grade->set($grd,$grd['id']);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "등급 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function mailPopup(){
        $this->header='head'; $this->footer=false;
        $this->template = new \application\models\TemplateModel();
        $_REQUEST['type'] = "1";
        $this->cnt = $this->template->getCnt();
    }

    function sendMail(){
        $template = new \application\models\TemplateModel();
        $success = 0;
        $tpId = $_POST['tpId'];
        $idl = explode(",",$_POST['idl']);
        foreach($idl as $userId){
            $res = $template->sendMail($userId,$tpId);
            if( $res == "000" ) $success++;
        }
        $msg = $success > 0 ? $success."개의 메일이 발송되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    function smsPopup(){
        $this->header='head'; $this->footer=false;
        $this->template = new \application\models\TemplateModel();
        $_REQUEST['type'] = "2";
        $this->cnt = $this->template->getCnt();
    }

    function approval(){
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->member->approval($id);
            if( $res == "000" ) $success++;
        }
        $msg = $success > 0 ? $success."명의 회원을 승인 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function edmList(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a","3");

        $this->edm = new \application\models\EdmModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->edm->getCnt();
        $this->col = "*";
    }

    function edmModify(){
        $this->row = $this->edm->get($this->param['ident'], $this->col);
    }

    function edmPreviewPopup(){
        $this->header='head'; $this->footer=false;
        $administrator = new \application\models\AdministratorModel();
        $this->user = $administrator->get($_SESSION['user_id'],"adm_id as id,adm_name as name,adm_email as email");
        $this->row = $this->edm->get($this->param['ident'], $this->col);
        $this->row['edm_content'] = get_text($this->row['edm_content'],0);
        $this->row['edm_content'] = contentReplace(array("id"=>$this->user['id'],"name"=>$this->user['name']),$this->default,$this->row['edm_content']);
    }

    function addEdm(){
        $res = $this->edm->add($_POST);
        $msg = $res == "000" ? "EDM이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Marketing/edmList");
    }

    function setEdm(){
        $res = $this->edm->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "EDM이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function testSendEdm(){
        $res = $this->edm->testSend($_POST);
        $msg = $res == "000" ? "EDM이 테스트 발송되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function sendEdm(){
        $res = $this->edm->send($this->param['ident']);
        $msg = $res == "000" ? "EDM이 발송되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    function retryEdm(){
        $res = $this->edm->retry($this->param['ident']);
        $msg = $res == "000" ? "EDM이 발송되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }

    function removeEdm(){
        $res = $this->edm->remove($this->param['ident']);
        $msg = $res == "000" ? "EDM이 삭제되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Marketing/edmList");
    }

    function edmLog(){
        $this->header='head'; $this->footer=false;
        $this->log = new \application\models\EdmLogModel();
        $_REQUEST['edmId'] = $this->param['ident'];
        $this->cnt = $this->log->getCnt();
    }

    function lmsList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->lms->getCnt();
    }

    function lmsPreviewPopup(){
        $this->header='head'; $this->footer=false;
        $administrator = new \application\models\AdministratorModel();
        $this->user = $administrator->get($_SESSION['userID'],"adm_id as id,adm_name as name,adm_email as email, adm_cellphone as cellphone");
        $this->row = $this->lms->get($this->param['ident'], $this->col);
        $this->row['lms_content'] = get_text($this->row['lms_content'],0);
        $this->row['lms_content'] = contentReplace(array("id"=>$this->user['id'],"name"=>$this->user['name']),$this->default,$this->row['lms_content']);
    }

    function testSendLms(){
        $this->header=false; $this->footer=false;
        print_r($_REQUEST);
    }

    function sendLms(){
        $this->header=false; $this->footer=false;
        print_r($_REQUEST);
    }

    function retryLms(){
        $this->header=false; $this->footer=false;
        print_r($_REQUEST);
    }

    function lmsLog(){
        $this->header='head'; $this->footer=false;
        $this->log = new \application\models\LmsLogModel();
        $_REQUEST['lmsId'] = $this->param['ident'];
        $this->cnt = $this->log->getCnt();
    }

    function lmsModify(){
        $this->lms = new \application\models\LmsModel();
        $this->row = $this->lms->get($this->param['ident'], $this->col);
    }

    function addLms(){
        $this->lms = new \application\models\LmsModel();
        $res = $this->lms->add($_POST);
        $msg = $res =="000" ? "LMS가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Marketing/lmsList");
    }

    function setLms(){
        $this->lms = new \application\models\LmsModel();
        $res = $this->lms->set($_POST, $this->param['ident']);
        $msg = $res == "000" ? "LMS가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Marketing/lmsList");
    }

    function removeLms(){
        $res = $this->lms->remove($this->param['ident']);
        $msg = $res == "000" ? "LMS가 삭제되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Marketing/lmsList");
    }

    public function registerDailyAnalysis(){
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n");

        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['col'] = "dc_dt";
        $search['colby'] = "asc";
        $col = " dc_dt ";
        foreach($this->pt_li as $key=>$value){
            $col .= ", sum(if(pt_id='$key',1,'0')) as $key";
        }
        $this->analysis = new \application\models\AnalysisModel();
        $this->row = $this->analysis->getAnalysis($col,"web_member","mb_reg_dt",$search);
    }

    public function registerDailyAnalysisExcel(){
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n");
        $this->analysis = new \application\models\AnalysisModel();

        $this->header = false; $this->footer = false;
        if( !isset($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( !isset($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;

        $col = " dc_dt ";
        foreach($this->pt_li as $key=>$value){
            $col .= ", sum(if(pt_id='$key',1,'0')) as $key";
        }
        $this->row = $this->analysis->getAnalysis($col,"web_member","mb_reg_dt");
    }


    public function registerAnalysis(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("n");

        $memberModel = new \application\models\MemberModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "reg_cnt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $search = array();
        $search['mb_reg_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['mb_reg_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['col'] = $_REQUEST['col'];
        $search['colby'] = $_REQUEST['colby'];
        $memberModel->sql_group = " group by pt_id "; 
        $this->row = $memberModel->get("count(mb_id) as reg_cnt, count(mb_sns_id_1) as sns_reg_cnt, pt_id",$search,true);
    }

    public function registerAnalysisExcel(){
        $this->header=false; $this->footer=false;
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("n");

        $memberModel = new \application\models\MemberModel();
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['mb_reg_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['mb_reg_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $memberModel->sql_group = " group by pt_id "; 
        $this->row = $memberModel->get("count(mb_id) as reg_cnt, count(mb_sns_id_1) as sns_reg_cnt, pt_id",$search,true);
    }

}
?>
