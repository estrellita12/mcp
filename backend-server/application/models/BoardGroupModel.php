<?php
namespace application\models;

use \PDO;

class BoardGroupModel extends Model{

    function __construct( ){
        parent::__construct ( 'web_board_group' );
    }
    
    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            if( empty($arr['id']) ) return;
            $value['bogr_id'] = $arr['id']; // 그룹 아이디
            $value['bogr_reg_dt'] = _DATE_YMDHIS; // 그룹 생성 일시
        }
        $value['bogr_update_dt'] = _DATE_YMDHIS; 

        if( !empty($arr['name']) )      $value['bogr_name'] = $arr['name']; // 그룹 이름
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("bogr_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" ) $this->getSearch("bogr_name",$_REQUEST['kwd']);
        }
        // 기간 검색
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("bogr_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("bogr_reg_dt",$_REQUEST['end'],"le");
            }
        }
        return $this->sql_where;
    }    

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by bogr_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by bogr_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'updateDate' ) $this->sql_order = " order by bogr_update_dt {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }        

/*
    function get($id, $col='*'){
        $sql_where = " and bogr_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id=''){
        if( empty($id) ) return "003";
        $value = $this->getValue($arr,'set');
        $search = " and bogr_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        if( !$this->overChk('bogr_id', $value['bogr_id']) ) return false;
        return $this->insert($value);
    }
    
    function remove($id){
        if(empty($id)) return"002";
        $search = " and bogr_id = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }    

    function getNameList(){
        $row = $this->selectAll("bogr_id, bogr_name", "and bogr_name!=''", "order by bogr_reg_dt desc");
        for($i=0;$i<count($row);$i++ ){
            $bogr_li[$row[$i]['bogr_id']] = $row[$i]['bogr_name'];
        }
        return $bogr_li;
    }
}
?>
