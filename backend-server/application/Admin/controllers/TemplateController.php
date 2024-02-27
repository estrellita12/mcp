<?php
namespace application\Admin\controllers;

class TemplateController extends Controller
{
    var $pt_li;
    var $row;
    var $cnt;
    var $col;

    function init(){ 
        $this->template = new \application\models\TemplateModel();
        $this->col = "*";
    }

    function mailList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['type'] = 1;
        $this->cnt = $this->template->getCnt();
        $this->col = "tp_id,tp_title,tp_reg_dt,tp_update_dt";
    }

    function mailModify(){
        $this->col = "tp_id,tp_title,tp_content";
        $this->row = $this->template->get($this->param['ident'], $this->col);
        $this->row['tp_content'] = get_text($this->row['tp_content'],0);
    }

    function testMail(){
        $res = $this->template->testSendMail($_POST);
        $msg = $res == "000" ? "메일이 발송되었습니다" : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function mailPreviewPopup(){
        $this->header='head'; $this->footer=false;
        $administrator = new \application\models\AdministratorModel();
        $this->user = $administrator->get($_SESSION['user_id'],"adm_id as id,adm_name as name,adm_email as email");

        $this->col = "tp_id,tp_title,tp_content";
        $this->row = $this->template->get($this->param['ident'], $this->col);
        $this->row['tp_content'] = get_text($this->row['tp_content'],0);
        $this->row['tp_content'] = contentReplace(array("id"=>$this->user['id'],"name"=>$this->user['name']), $this->default, $this->row['tp_content']);
    }

    function sendLogPopup(){
        $this->header='head'; $this->footer=false;
        $this->log = new \application\models\TemplateSendLogModel();
        $_REQUEST['tpId'] = $this->param['ident'];
        $this->cnt = $this->log->getCnt();
    }

    function add(){
        $res = $this->template->add($_POST);
        $msg = $res == "000" ? "템플릿이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    function set(){
        $res = $this->template->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "템플릿이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }
}
?>
