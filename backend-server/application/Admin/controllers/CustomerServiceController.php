<?php
namespace application\Admin\controllers;

class CustomerServiceController extends Controller{
    var $pt_li;
    var $gr_li;
    var $member;
    var $row;
    var $cnt;
    var $col;

    function init(){ 
        $this->partner = new \application\models\PartnerModel();
        $this->pt_li = $this->partner->getNameList("n");

        $this->cs = new \application\models\CustomerServiceModel();
        $this->col = "*";
    }

    function list(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->cs->getCnt();
    }

    function listExcel(){
        $this->header = false; $this->footer = false;
        if( $this->cs->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }


    function formPopup(){
        $this->header = "head"; $this->footer = false;
        $this->order = new \application\models\OrderModel();
        $this->row = $this->order->get("*",array("od_id"=>$this->param['ident']));
    }

    function add(){
        $res = $this->cs->add($_POST);
        $msg = $res == "000" ? "CS 이력이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
            
    }

}
?>
