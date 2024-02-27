<?php
namespace application\Admin\controllers;

class AdministratorController extends Controller{
    function init(){
        $this->grade = new \application\models\AdministratorGradeModel();
        $this->gr_li = $this->grade->getNameList();

        $this->administrator = new \application\models\AdministratorModel();
        $this->col = "*";
    }

    function list(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->administrator->getCnt();
    }

    function listExcel(){
        $this->header = false; $this->footer = false;
        if( !empty( $this->param['ident'] ) ){
            $_REQUEST['idxl'] = $this->param['ident'];
            $_REQUEST['col'] = " FIELD ( adm_id, {$this->param['ident']} ) ";
        }
        if( $this->administrator->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    function infoPopup(){
        $this->header='head'; $this->footer=false;
        $this->row = $this->administrator->get($this->param['ident'], $this->col);
    }

    function add(){
        $res = $this->administrator->add($_POST);
        $msg = $res=="000" ? "관리자가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Administrator/list");
    }

    function overChk(){
        $this->header=false; $this->footer=false;
        $res = $this->administrator->overChk("adm_id",$_GET['id']);
        echo json_encode(array('res'=>$res));
    }

    function set(){
        $res = $this->administrator->set($_POST);
        $msg = $res=="000" ? "관리자 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    function setGrade(){
        $success = 0;
        foreach($_POST['li'] as $grd){
            $res = $this->grade->set($grd,$grd['id']);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "등급 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }
}
?>
