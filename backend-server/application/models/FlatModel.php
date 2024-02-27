<?php
namespace application\models;

use \PDO;

class FlatModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_flat' );
    }
    
    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            $value['fl_reg_dt'] = _DATE_YMDHIS; // 개별페이지 등록 일시
        }

        if( !empty($arr['title']) )         $value['fl_title'] = $arr['title']; // 개별페이지 제목
        if( !empty($arr['pc']) )            $value['fl_pc'] = $arr['pc']; // pc 내용
        if( !empty($arr['mobile']) )        $value['fl_mobile'] = $arr['mobile']; // 모바일 내용

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "title" ) $this->getSearch("fl_title",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("fl_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("fl_reg_dt",$_REQUEST['end'],"le");
            }
        }
        return $this->sql_where;
    } 
    
    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by fl_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';

            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by fl_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'title' ) $this->sql_order = " order by fl_title {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }    
/*
    function get($id, $col='*'){
        $sql_where = " and idx = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id=''){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "003";
        $value = $this->getValue($arr,'set');
        $search = " and fl_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        if( !$this->overChk('fl_title', $value['fl_title']) ) return false;
        return $this->insert($value);
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and fl_id = '{$id}' ";
        return $this->delete($search);
    }

}
?>
