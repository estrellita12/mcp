<?php
namespace application\models;

class PostCommentModel extends Model{
    private $tb_id = "";
    function __construct($id){
        parent::__construct ( "web_board{$id}_comment" );
        $this->tb_id = $id;
    }
    
    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){  
            $value['boco_reg_dt'] = _DATE_YMDHIS;
            $value['bopo_id'] = $arr['post'];
            if( !empty($arr['depth']) )           $value['boco_depth'] = $arr['depth'];
            if( !empty($arr['pid']) )           $value['boco_pid'] = $arr['pid'];
        }
        if( !empty($arr['userId']) )          $value['user_id'] = $arr['userId'];
        if( !empty($arr['userName']) )          $value['user_name'] = $arr['userName'];
        if( !empty($arr['comment']) )          $value['boco_comment'] = $arr['comment'];
        $value['boco_ip'] =  $_SERVER['REMOTE_ADDR'];
        //$value['boco_update_dt'] = _DATE_YMDHIS;
        
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
        if( empty($this->sql_order )) $this->sql_order = " order by boco_reg_dt desc "; 
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';

            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by boco_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'id' ) $this->sql_order = " order by boco_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'name' ) $this->sql_order = " order by boco_name {$_REQUEST['colby']} ";
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
        $search = " and boco_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type='arr'){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        $res = $this->insert($value);
        if( $res == "000" ){
            $postModel = new \application\models\PostModel($this->tb_id);
            $postModel->addComment($value['bopo_id']);
        }
        return $res;
    }

    function remove($id){
        if(empty($id)) return "002";
        $search = " and boco_id = '{$id}' ";
        $res = $this->delete($search);
        if( $res=="000" ){
            $row = $this->get("boco_id",array("boco_pid"=>$id),true);
            if( empty($row) ) return;
            foreach($row as $p){
                $this->remove($p['boco_id']);
            }
        }
        return $res;
    }

    public $depthList = array();
    /*
    function getDepthList($id){
        $search = array("boco_id"=>$id);
        $row = $this->get("*",$search);
        array_push($this->depthList,$row);

        $search = array("boco_pid"=>$id);
        $rowAll = $this->get("*",$search,true);
        if(!empty($rowAll)){
            foreach($rowAll as $row){
                $this->getDepthList($row['boco_id']);
            }       
        }
        return $this->depthList;
    }
    */
    function getDepthList($post, $id='0'){
        $search = array("boco_pid"=>$id, "bopo_id"=>$post, "col"=>"boco_reg_dt", "colby"=>"asc");
        $rowAll = $this->get("*",$search,true);
        if(!empty($rowAll)){
            foreach($rowAll as $row){
                array_push($this->depthList,$row);
                $this->getDepthList($post, $row['boco_id']);
            }       
        }
        return $this->depthList;
    }
 
}
?>
