<?php
namespace application\models;

use \PDO;

class PlanModel extends Model{
    
    var $colArr;
    function __construct( ){
        parent::__construct ( 'web_plan' );
        $this->colArr = array(
            "planId"=>"plan_id",
            "shop"=>"pt_id",
            "ctgId"=>"ctg_id",
            "title"=>"plan_title",
            "content"=>"plan_content",
            "goodsList"=>"plan_goods_list",
            "listImg"=>" if(plan_list_img != '', concat('"._PLAN."','/',plan_list_img) , '')",
            "topImg"=>" if(plan_top_img != '', concat('"._PLAN."','/',plan_top_img) , '')",
            "show"=>"plan_show_yn",
            "device"=>"plan_device",
            "orderby"=>"plan_orderby",
            "beginDate"=>"plan_begin_dt",
            "endDate"=>"plan_end_dt",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode == "add"){
            $value['plan_reg_dt'] = _DATE_YMDHIS; // 등록 일시
            if( !empty($arr['orderby']) )       $value['plan_orderby'] = 1;  
        }
        $value['plan_update_dt'] =  _DATE_YMDHIS; // 수정 일시
        if( !empty($arr['shop']) )          $value['pt_id'] = $arr['shop']; // 가맹점
        if( !empty($arr['ctg']) )           $value['ctg_id'] = $arr['ctg']; // 카테고리 아이디
        if( !empty($arr['title']) )         $value['plan_title'] = $arr['title']; // 기획전명
        if( !empty($arr['content']) )       $value['plan_content'] = $arr['content'];  
        //if( !empty($arr['goodsList']) )     $value['plan_goods_list'] = implode(",",$arr['goodsList']);  
        if( !empty($arr['goodsList']) )     $value['plan_goods_list'] = $arr['goodsList'];  
        if( !empty($arr['showYn']) )          $value['plan_show_yn'] = $arr['showYn'];  
        if( !empty($arr['device']) )        $value['plan_device'] = $arr['device'];  
        if( !empty($arr['orderby']) )       $value['plan_orderby'] = $arr['orderby'];  
        if( !empty($arr['beginDate']) ){
            if(is_array($arr['beginDate'])) $value['plan_begin_dt'] = implode(" ",$arr['beginDate']);
            else $value['plan_begin_dt'] = _BEGIN_DATE;
        }
        if( !empty($arr['endDate']) ){
            if(is_array($arr['endDate']))  $value['plan_end_dt'] = implode(" ",$arr['endDate']);
            else $value['plan_end_dt'] = _END_DATE;
        }

        if( !empty($arr['updateDate']) )    $value['plan_update_dt'] = $arr['regDate'];  
        try{
            $upl = new \application\models\UploadImage(_ROOT._PLAN);
            if( !empty($arr['listImgDel']) )    $upl->del($arr['oriListImgFile']);
            if( !empty($arr['topImgDel']) )    $upl->del($arr['oriTopImgFile']);
            if( !empty($_FILES['listImgFile']) && !empty($_FILES['listImgFile']['name'])  ){
                $filename = $upl->upload($_FILES['listImgFile']);
                if(!empty($filename)) $value['plan_list_img'] = $filename;
            }
            if( !empty($_FILES['topImgFile']) && !empty($_FILES['topImgFile']['name'])  ){
                $filename = $upl->upload($_FILES['topImgFile']);
                if(!empty($filename)) $value['plan_top_img'] = $filename;
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
            if( $_REQUEST['srch'] == "title" ) $this->getSearch("plan_title",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['shop']) && $_REQUEST['shop']!="all" ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['showYn']) ) $this->sql_where .= " and plan_show_yn = '{$_REQUEST['showYn']}' ";
        if( !empty($_REQUEST['useCtg']) )   $this->getParameter("ctg_id",$_REQUEST['useCtg']);
        if( !empty($_REQUEST['ctg']) ) $this->getSearch("ctg_id",$_REQUEST['ctg'],"right");
  
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("plan_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("plan_reg_dt",$_REQUEST['end'],"le");
            }else if( $_REQUEST['term'] == "showDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("plan_begin_dt",$_REQUEST['beg'],"le");
                if( !empty($_REQUEST['end']) ) $this->getTerm("plan_end_dt",$_REQUEST['end'],"ge");
            }else  if( $_REQUEST['term'] == "beginDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("plan_begin_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("plan_begin_dt",$_REQUEST['end'],"le");
            }else if( $_REQUEST['term'] == "endDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("plan_end_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("plan_end_dt",$_REQUEST['end'],"le");
            }

        }

        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order ))   $this->sql_order = " order by pt_id desc ,  plan_orderby asc ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }
/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $search = " and plan_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/
    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";;

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and plan_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr ){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    function remove( $id ){
        if(empty($id)) return "002";
        $search = " and plan_id = '{$id}' ";
        return $this->delete($search);
    }

    function move($arr,$id){
        $value['plan_orderby'] = $arr['orderby'];
        return $this->set($value,$id,"value");
    }
}
?>
