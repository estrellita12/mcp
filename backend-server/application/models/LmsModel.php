<?php
namespace application\models;

use \PDO;

class LmsModel extends Model
{

    function __construct( ){
        parent::__construct ( 'web_lms' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        $value = array();
        if( $mode=="add" ){
            $value['lms_reg_dt'] = _DATE_YMDHIS; // SMS 등록 일시
            $value['lms_send_yn'] = 'n'; // SMS 발송 여부
        }
        if( !empty($arr['title']) )     $value['lms_title'] = $arr['title']; // SMS 제목
        if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop']; // SMS 타겟 가맹점
        if( !empty($arr['opt']) )       $value['lms_send_option'] = $arr['opt']; // SMS 발송 옵션
        if( !empty($arr['content']) )   $value['lms_content'] = $arr['content']; // SMS 내용
        if( !empty($arr['sendDate']) )  $value['lms_send_dt'] = implode(" ",$arr['sendDate']);  // 메일 발송 시간
        if( !empty($arr['memo']) )      $value['lms_adm_memo'] = $arr['memo'];  // 메일에 대한 관리자 메모
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['shop']) ) $this->sql_where .= " and pt_id = '{$_REQUEST['shop']}' ";
        if( !empty($_REQUEST['search']) ||  !empty($_REQUEST['srch']) ){
            $search_arr = get_search();
            if( !empty( $search_arr['title'] ) ) $this->sql_where .= " and lms_title {$search_arr['title']} ";
        }

        // 기간 검색
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ) $this->getTerm("lms_reg_dt");
            if( $_REQUEST['term'] == "sendDate" ) $this->getTerm("lms_send_dt");
        }

        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by lms_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by lms_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'sendDate' ) $this->sql_order = " order by lms_send_dt {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

/*
    function get($id, $col='*'){
        $search = " and lms_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/

    function set($arr, $id){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $value = $this->getValue($arr,'set');
        $search = " and lms_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and lms_id = '{$id}' ";
        return $this->delete($search);
    }
}
?>
