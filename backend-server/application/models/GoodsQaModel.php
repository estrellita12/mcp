<?php
namespace application\models;

use \Exception;

class GoodsQaModel extends Model{

    function __construct( ){
        parent::__construct ( 'web_goods_qa' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            $value['gs_qa_reg_dt'] = _DATE_YMDHIS; // 등록일시
        }

        if( !empty($arr['goodsId']) )       $value['gs_id'] = $arr['goodsId']; 
        if( !empty($arr['seller']) )        $value['gs_qa_sl_id'] = $arr['seller']; 
        if( !empty($arr['shop']) )        $value['gs_qa_pt_id'] = $arr['shop']; 
        if( !empty($arr['userId']) )        $value['mb_id'] = $arr['userId']; 
        if( !empty($arr['writerEmail']) )   $value['gs_qa_writer_email'] = $arr['writerEmail']; 
        if( !empty($arr['emailNoticeYn']) )   $value['gs_qa_email_notice_yn'] = $arr['emailNoticeYn']; 
        if( !empty($arr['writerCellphone']) )   $value['gs_qa_writer_cellphone'] = $arr['writerCellphone']; 
        if( !empty($arr['cellphoneNoticeYn']) )   $value['gs_qa_cellphone_notice_yn'] = $arr['cellphoneNoticeYn']; 
        if( !empty($arr['type']) )      $value['gs_qa_type'] = $arr['type']; 
        if( !empty($arr['title']) )      $value['gs_qa_title'] = $arr['title']; 
        if( !empty($arr['content']) )      $value['gs_qa_content'] = $arr['content']; 
        if( !empty($arr['secret']) )      $value['gs_qa_secret_yn'] = $arr['secret']; 
        if( !empty($arr['passwd']) )      $value['gs_qa_passwd'] = $arr['passwd']; 
        //if( !empty($arr['answer']) )      $value['gs_qa_answer'] = $arr['answer']; 
        //if( !empty($arr['answerYn']) )      $value['gs_qa_answer_yn'] = $arr['answerYn']; 
        //$value['gs_qa_answer_dt'] = _DATE_YMDHIS;
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" )         $this->getSearch("gs_qa_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "goodsId" )    $this->getSearch("gs_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "title" )      $this->getSearch("gs_qa_title",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("gs_qa_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("gs_qa_reg_dt",$_REQUEST['end'],"le");
            }
        }

        if( !empty($_REQUEST['id']) )       $this->getParameter("gs_qa_id",$_REQUEST['id']);
        if( !empty($_REQUEST['userId']) )       $this->getParameter("mb_id",$_REQUEST['userId']);
        if( !empty($_REQUEST['goodsId']) )  $this->getParameter("gs_id",$_REQUEST['goodsId']);
        if( !empty($_REQUEST['seller']) )   $this->getParameter("gs_qa_sl_id",$_REQUEST['seller']);
        if( !empty($_REQUEST['shop']) )   $this->getParameter("gs_qa_pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['answerYn']) ) $this->getParameter("gs_qa_answer_yn",$_REQUEST['answerYn']);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by gs_qa_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by gs_qa_reg_dt {$_REQUEST['colby']} ";
        }
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and gs_qa_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id,$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $preValue = $this->get("*", array("gs_qa_id"=>$id));

        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        
        $search = " and gs_qa_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        
        $res = $this->insert($value);
        if( $res=="000" ){
            //$templateModel = new \application\models\TemplateModel();
            //$templateModel->sendMail($value['gs_qa_sl_id'],9);
        }
        return $res;
    }

    function remove($id){
        if( empty($id) ) return"002";
        $search = " and gs_qa_id = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }

    function answer($arr,$id){
        if( empty($arr['answer']) ) return "002";
        $value['gs_qa_answer'] = $arr['answer']; 
        $value['gs_qa_answer_yn'] = 'y';
        $value['gs_qa_answer_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"value");
    }

    function hidden($id){
        $value['gs_qa_hidden_yn'] = 'y';
        return $this->set($value,$id,"value");
    }

}
?>
