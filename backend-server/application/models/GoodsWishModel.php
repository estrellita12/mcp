<?php
namespace application\models;

use \PDO;
use \Exception;

class GoodsWishModel extends Model
{
    var $colArr;
    function __construct(){
        parent::__construct ( 'web_goods_wish' );
        $this->colArr = array(
            "id"=>"gs_wi_id",
            "memberId"=>"mb_id",
            "goodsId"=>"gs_id",
            "time"=>"gs_wi_time",
            "wishIp"=>"gs_wi_ip",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            if( empty($arr['memberId']) || empty($arr['goodsId'])) return;
            $value['mb_id'] = $arr['memberId']; // 회원 고유번호
            $value['gs_id'] = $arr['goodsId']; // 상품 고유번호
            $value['gs_wi_time'] = _DATE_YMDHIS; // 등록일시
            $value['gs_wi_ip'] = _GUEST; // 접속 IP
        }
        /* UPDATE 기능 필요 시 추가 작성 */
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['id']) )           $this->getParameter("gs_wi_id",$_REQUEST['id']);
        if( !empty($_REQUEST['memberId']) )     $this->getParameter("mb_id",$_REQUEST['memberId']);
        if( !empty($_REQUEST['goodsId']) )      $this->getParameter("gs_id",$_REQUEST['goodsId']);
        if( !empty($_REQUEST['wishIp']) )       $this->getParameter("gs_wi_ip",$_REQUEST['wishIp']);

        if( !empty($_REQUEST['time']) ){
            if( $_REQUEST['time'] == "gs_wi_time" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("gs_wi_time",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("gs_wi_time",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by gs_wi_id desc ";    // 기본 정렬 방식 설정

        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'memberId' ) $this->sql_order = " order by mb_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsId' ) $this->sql_order = " order by gs_id {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and gs_wi_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/

    function set($arr,$id,$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $preValue = $this->get("*", array("gs_wi_id"=>$id));

        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $flag = false;
        foreach($preValue as $k=>$v){
            if( isset($value[$k]) && strcmp($value[$k],$v)!=0 ) $flag = true;
        }
        if($flag){
            $search = " and gs_wi_id = '{$id}' ";
            $res = $this->update($value,$search);
            return $res;
        }else{
            return "001";
        }
    }

    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $res = $this->insert($value);
        return $res;
    }

    function remove($id){
        if(empty($id)) return"002";
        $search = " and gs_wi_id = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }    

    function removeMember($mb_id){
        if(empty($mb_id)) return"002";
        $search = " and mb_id = '{$mb_id}' ";
        $res = $this->delete($search);
        return $res;
    }            
}
?>
