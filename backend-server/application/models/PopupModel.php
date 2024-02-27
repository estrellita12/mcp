<?php
namespace application\models;

use \PDO;

class PopupModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_popup' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode == "add"){
            if( empty($arr['id']) ) return;
            $value['pp_id'] = $arr['id']; //가맹점
            $value['pp_reg_dt'] = _DATE_YMDHIS; // 등록 일시
        }
        $value['pp_update_dt'] =  _DATE_YMDHIS; // 수정 일시

        if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop'];    //가맹점
        if( !empty($arr['showYn']) )      $value['pp_show_yn'] = $arr['showYn'];
        if( !empty($arr['device']) )    $value['pp_device'] = $arr['device'];   
        if( !empty($arr['width']) )     $value['pp_width'] = $arr['width'];    
        if( !empty($arr['height']) )    $value['pp_height'] = $arr['height'];  
        if( !empty($arr['top']) )       $value['pp_top'] = $arr['top'];    
        if( !empty($arr['left']) )      $value['pp_left'] = $arr['left'];  
        if( !empty($arr['content']) )   $value['pp_content'] = $arr['content']; 
        if( !empty($arr['orderby']) )   $value['pp_orderby'] = $arr['orderby']; 
        if( !empty($arr['beginDate']) ) $value['pp_begin_dt'] = $arr['beginDate']; 
        if( !empty($arr['endDate']) )   $value['pp_end_dt'] = $arr['endDate'];    
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "title" ) $this->getSearch("pp_title",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['shop']) && $_REQUEST['shop']!="all" )     $this->sql_where .= " and pt_id = '{$_REQUEST['shop']}' ";
        if( !empty($_REQUEST['device']) )   $this->sql_where .= " and pp_device = '{$_REQUEST['device']}' ";
        if( !empty($_REQUEST['showYn']) )     $this->sql_where .= " and pp_show_yn = '{$_REQUEST['showYn']}' ";
        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order ))   $this->sql_order = " order by pt_id desc, pp_orderby asc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by pp_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'updateDate' ) $this->sql_order = " order by pp_update_dt {$_REQUEST['colby']} ";
        }
    }

/*
    function get($id, $col='*'){
        if(empty($id)) $id = $this->param['ident'];
        if(empty($id)) return "002";
        $sql_where = " and pp_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr, $id, $type="arr"){
        if(empty($id)) $id=$arr['id'];
        if(empty($id)) return "002";

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and pp_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    function remove( $id ){
        if(empty($id)) return "002";
        $search = " and pp_id = '{$id}' ";
        return $this->delete($search);
    }

    function move($arr,$id){
        $value['pp_orderby'] = $arr['orderby'];
        return $this->set($value, $id, "value"); 
    }
   
}


?>
