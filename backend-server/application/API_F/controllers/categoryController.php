<?php
namespace application\API_F\controllers;

class categoryController extends Controller
{
    var $category;
    var $col;

    function init(){ 
        $this->category = new \application\models\CategoryModel();
        $this->col = "*";
    }

    function getList(){
        echo json_encode($this->category->getNameList($_GET['depth'] ? $_GET['depth'] : 1));
    }
    /*
    var $category;
    var $cnt;
    var $row;
    var $col;

    function init(){ 
        $this->category = new \application\models\CategoryModel();
        $this->col = "*";
    }

    function list(){
        $this->cnt = $this->category->getCnt();
    }

    function listExcel(){
        $this->header = false; $this->footer = false;
        $_REQUEST['col'] = "id";
        $_REQUEST['colby'] = "asc";
    }

    function get(){
        $this->header=false; $this->footer=false;
        echo json_encode( $this->category->get($this->param['ident'], 'ctg_id as ctg,ctg_title as title,ctg_use_yn as useYn') );
    }

    function getNext(){
        $this->header=false; $this->footer=false;
        $depth = $_POST['depth'];
        $upper = $_POST['upper'];
        $length = 3 * $depth;
        $data = array();
        if(!empty($depth)) {
            $res = $this->category->getDepthList($depth, $upper, 'a');
            $i=0;
            foreach( $res as $row) {
                $data[$i]['optionValue'] = $row['ctg_id'];
                $data[$i]['optionText']  = $row['ctg_title'];
                $i++;
            }
        }
        print_r(json_encode($data));
    }

    function add(){
        $res = $this->category->newAdd( array("id"=>$this->param['ident']) );
        $msg = $res == "000" ? "카테고리가 등록되었습니다." : $res. "실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    function set(){
        $res = $this->category->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "카테고리 정보가 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    function uploadExcel(){
        $this->header = false; $this->footer = false;
        $bulk = new \application\models\BulkExcel();
        $res = $bulk->upload();
        $flag = false;
        foreach( $res as $row ){
            $id = $row[2].$row[3].$row[4].$row[5].$row[6];
            if(!is_numeric($id)) continue;
            $len = strlen($id);
            $arr['id'] = $id;
            $arr['title'] = $row[1];
            $arr['upper'] = substr($id,0,($len-3)); 
            $arr['orderby'] = $row[7];
            $arr['useYn'] = $row[8];
            $res = $this->category->set($arr,$id);
            if($res!="000") $res = $this->category->add($arr,$id);
            if($res=="000") $flag = true;
        }
        $msg = $flag ? "카테고리 정보가 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    function remove(){
        $res = $this->category->remove($this->param['ident']);
        $msg = $res=="000" ? "카테고리 정보가 삭제되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    function sortable(){
        $this->header = false;  $this->footer = false;
        $flag = false;
        $idx_list = $_REQUEST['list'];
        $arr = explode(",",$idx_list);
        for($i=1;$i<=count($arr);$i++){
            $_POST['orderby']= "$i";
            $res = $this->category->set($_POST,$arr[$i-1],'move');
            if($res=="000") $flag = true;
        }
        $msg = $flag ? "카테고리 순서가 변경되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }
    */

}
