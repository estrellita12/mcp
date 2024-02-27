<?php
namespace application\Admin\controllers;

class BoardController extends Controller{
    public $col;
    public $cnt;

    public function init(){ 
/*
        $this->board_group = new \application\models\BoardGroupModel();
        $this->board = new \application\models\BoardModel();
        $grade = new \application\models\MemberGradeModel();
        $this->gr_li = $grade->getNameList();
        $this->bogr_li = $this->board_group->getNameList();

        $this->last_idx = $this->board->selectAuto();
*/
        $this->col = "*";
    }

    public function groupList(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->boardGroup->getCnt();                
    }

    public function groupListExcel(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $this->header = false; $this->footer = false;
        if( $this->boardGroup->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    public function addGroup(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $res = $this->boardGroup->add($_POST);
        $msg = $res == "000" ? "게시판 그룹이 추가 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Board/groupList");
/*
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "r";
        header('location:/Board/groupList?act='.$act_msg.'&res='.$res_msg);                 
*/
    }

    public function overChk(){ 
        $this->boardGroup = new \application\models\BoardGroupModel();
        $this->header=false; $this->footer=false;
        $res = $this->boardGroup->overChk("bogr_id",$_GET['id']);
        echo json_encode(array('res'=>$res));
    }

    public function groupModify(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $this->row = $this->boardGroup->get("*",array("bogr_id"=>$this->param['ident']));
    }
    
    public function setGroup(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $res = $this->boardGroup->set(($_POST),$this->param['ident']);
        $msg = $res == "000" ? "게시판 그룹 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Board/groupList");
        /*
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "u";
        header('location:/Board/groupList?act='.$act_msg.'&res='.$res_msg);                 
        */
    }
 
    public function removeGroup(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $res = $this->boardGroup->remove($this->param['ident']);
        $msg = $res == "000" ? "게시판 그룹이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Board/groupList");
        /*
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "u";
        header('location:/Board/groupList?act='.$act_msg.'&res='.$res_msg);                 
        */
    }
 
   
    /*
    function groupMultiple(){
        $btn_nm = $_POST['btn_nm'];
        $chk = $_POST['chk'];
        $data = $_POST['bogr_name'];
        $action_chk = 0;
        $act_msg='';
        $res_msg='';
        if($btn_nm == "선택수정"){
            foreach($chk as $value){
                $action = $this->board_group->set(array('name'=>$data[$value]), $value);
                if($action != "000") $action_chk = 1;                
            }
            $act_msg = 'u';
        }else if($btn_nm == "선택삭제"){
            foreach($chk as $value){
                $action = $this->board_group->delete("and bogr_id='{$value}'");
                if($action != "000") $action_chk = 1;   

                $result = $this->board->selectAll('idx',"and bogr_id = '{$value}'");
                foreach($result as $each_value){
                    $action2 = $this->board->delete($each_value['idx']);
                }
            }
            $act_msg = 'd';
        } 
        $res_msg = !$action_chk ? 's' : 'f';            
        header('location:'._PRE_URL.'?act='.$act_msg.'&res='.$res_msg);                 
    }    
    */

    function list(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 30;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->board->getCnt();
        $this->bogr_li = $this->board_group->getNameList();
        unset(($this->bogr_li)['']);
    }

    function listExcel(){
        $this->header = false; $this->footer = false;
        if( !empty( $this->param['ident'] ) ){
            $_REQUEST['idxl'] = $this->param['ident'];
            $_REQUEST['col'] = " FIELD ( idx, {$this->param['ident']} ) ";
        }
        if( $this->board->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }    
    
   
    function add(){
        $res = $this->board->add($_POST);
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "r";
        header('location:/Board/list?act='.$act_msg.'&res='.$res_msg);                         
    }
    
    function modify(){
        $this->row = $this->board->get($this->param['ident']);
    }    

    function set(){
        $res = $this->board->set(($_POST),$this->param['ident']);
        $res_msg = $res == "000" ? "s" : "f";
        $act_msg = "u";
        header('location:/Board/list?act='.$act_msg.'&res='.$res_msg);                         
    }

    function multiple(){
        $btn_nm = $_POST['btn_nm'];
        $chk = $_POST['chk'];
        $data = $_POST['bogr_list'];
        $act_msg='';
        $res_msg='';
        if($btn_nm == "선택수정"){
            foreach($chk as $value){
                $action = $this->board->set(array('group'=>$data[$value]), $value);
                if($action != "000") $action_chk = 1;
            }
            $act_msg = 'u';
        }else if($btn_nm == "선택삭제"){
            foreach($chk as $value){
                $action = $this->board->delete($value);
                if($action != "000") $action_chk = 1;
            }
            $act_msg = 'd';
        }         
        $res_msg = !$action_chk ? 's' : 'f';            
        header('location:'._PRE_URL.'?act='.$act_msg.'&res='.$res_msg);                         
    }        
}

?>
