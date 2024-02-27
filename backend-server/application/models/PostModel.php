<?php
namespace application\models;

class PostModel extends Model{
    function __construct($id){
        parent::__construct ( "web_board{$id}_post" );
    }
    
    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){  
            if( !empty($arr['userId']) )          $value['user_id'] = $arr['userId'];
            $value['bopo_reg_dt'] = _DATE_YMDHIS;
        }
        if( !empty($arr['title']) )         $value['bopo_title'] = $arr['title'];
        if( !empty($arr['content']) )       $value['bopo_content'] = $arr['content'];
        if( !empty($arr['secretYn']) )      $value['bopo_secret_yn'] = $arr['secretYn'];
        if( !empty($arr['userName']) )          $value['user_name'] = $arr['userName'];
        if( isset($arr['display']) )          $value['bopo_main_display'] = $arr['display'];
        if( !empty($arr['pid']) )          $value['bopo_pid'] = $arr['pid'];
        if( !empty($arr['depth']) )          $value['bopo_depth'] = $arr['depth'];
        $value['bopo_update_dt'] = _DATE_YMDHIS;
        
        try{
            $upl = new \application\models\UploadFile(_ROOT._POST);
            if( !empty($_FILES['file1']) && !empty($_FILES['file1']['name'])  ){
                $filename = $upl->upload($_FILES['file1']);
                if(!empty($filename)) $value['bogo_file1'] = $filename;
            }
            if( !empty($_FILES['file2']) && !empty($_FILES['file2']['name'])  ){
                $filename = $upl->upload($_FILES['file2']);
                if(!empty($filename)) $value['bogo_file2'] = $filename;
            }
        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("bopo_id",$_REQUEST['kwd']);
            else if( $_REQUEST['srch'] == "title" ) $this->getSearch("bopo_title",$_REQUEST['kwd']);
        }
        if( isset($_REQUEST['depth']) ) $this->getParameter("bopo_depth",$_REQUEST['depth']);
        if( isset($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);

        // 기간 검색
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("bopo_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("bopo_reg_dt",$_REQUEST['end'],"le");
            }
        }

        return $this->sql_where;
    } 
    
    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by bopo_reg_dt desc "; 
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by bopo_reg_dt {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }    

/*
    function get($id, $col='*'){
        $sql_where = " and idx = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr, $id='', $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "003";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        $search = " and bopo_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type='arr'){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    function remove($id){
        if(empty($id)) return "002";
        $search = " and bopo_id = '{$id}' ";
        $res = $this->delete($search);
        if( $res=="000" ){
            $row = $this->get("bopo_id",array("bopo_pid"=>$id),true);
            if( empty($row) ) return;
            foreach($row as $p){
                $this->remove($p['bopo_id']);
            }
        }
        return $res;
    }

    public $depthList = array();
    function getDepthList( $id = '0'){
        $search = array("bopo_pid"=>$id, "col"=>"bopo_reg_dt", "colby"=>"asc");
        $rowAll = $this->get("*",$search,true);
        if(!empty($rowAll)){
            foreach($rowAll as $row){
                array_push($this->depthList,$row);
                $this->getDepthList($row['bopo_id']);
            }       
        }
        return $this->depthList;
    }
 
    function addComment( $id=''){
        $sql = "update {$this->tb_nm} set  bopo_comment_count = bopo_comment_count + 1  where bopo_id = {$id}";
        return $this->execute($sql);
    }

    function view( $id=''){
        $sql = "update {$this->tb_nm} set  bopo_view_count = bopo_view_count + 1  where bopo_id = {$id}";
        return $this->execute($sql);
    }



}
?>
