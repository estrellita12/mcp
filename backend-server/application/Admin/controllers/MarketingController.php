<?php
namespace application\Admin\controllers;

class MarketingController extends Controller{
    public $pt_li;
    public $row;
    public $cnt;
    public $col;

    function init(){ 
        $this->lms = new \application\models\LmsModel();
        $this->col = "*";
    }

    function edmList(){
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList("a");
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


}
