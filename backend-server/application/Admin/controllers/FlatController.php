<?php
namespace application\Admin\controllers;

class FlatController extends Controller
{
    var $flat;
    var $col;
    var $cnt;
    var $row;

    function init(){ 
        $this->flat = new \application\models\FlatModel();
        $this->col = "*";
    }

    function list(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 30;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->flat->getCnt();                
    } 
    
    function add(){
        $res = $this->flat->add($_POST);
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "r";
        header('location:/Flat/list?act='.$act_msg.'&res='.$res_msg);                 
    }

    function set(){
        $res = $this->flat->set(($_POST),$this->param['ident']);
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "u";
        header('location:/Flat/list?act='.$act_msg.'&res='.$res_msg);                         
    }

    function modify(){
        $this->row = $this->flat->get($this->param['ident']);
    }

    function overChk(){ 
        $this->header=false; $this->footer=false;
        $res = $this->flat->overChk("fl_title",$_GET['title']);
        echo json_encode(array('res'=>$res));
    }

    function multiple(){
        $btn_nm = $_POST['btn_nm'];
        $chk = $_POST['chk'];
        $data = $_POST['fl_title'];
        $act_msg='';
        $res_msg='';
        if($btn_nm == "선택수정"){
            foreach($chk as $value){
                $action = $this->flat->set(array('title'=>$data[$value]), $value);
                if($action != "000") $action_chk = 1;
            }
            $act_msg = 'u';
        }else if($btn_nm == "선택삭제"){
            foreach($chk as $value){
                $action = $this->flat->delete("and idx = {$value}");
                if($action != "000") $action_chk = 1;
            }
            $act_msg = 'd';
        }         
        $res_msg = !$action_chk ? 's' : 'f';            
        header('location:'._PRE_URL.'?act='.$act_msg.'&res='.$res_msg);                         
    }            
}

?>
