<?php
namespace application\models;

use \PDO;
use \Exception;

class OrderTeamModel extends Model
{
    var $colArr;
    function __construct(){
        parent::__construct ( 'web_order_team' );
        $this->colArr = array(
            "teamId"=>"od_team_id",
            "teamHost"=>"od_team_host",
            "teamMax"=>"od_team_max",
            "teamCnt"=>"od_team_cnt",
            "goodsId"=>"gs_id",
            "teamTime"=>"od_team_time",
            "teamStatus"=>"od_team_status",
            "teamLatest"=>"od_team_latest",
            "teamRegdate"=>"od_team_regdate"
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            if( empty($arr['teamMax']) || empty($arr['goodsId']) || empty($arr['teamHost'])) return;
            $value['od_team_host'] = $arr['teamHost']; // 방장
            $value['od_team_max'] = $arr['teamMax']; // 최대 인원
            $value['gs_id'] = $arr['goodsId']; // 상품 아이디
            $value['od_team_regdate'] = _DATE_YMDHIS; // 등록일시
        }

        if( !empty($arr['teamCnt']) )     $value['od_team_cnt'] = $arr['teamCnt']; // 참여인원
        if( !empty($arr['teamTime']) )    $value['od_team_time'] = $arr['teamTime']; // 결성 제한시간
        if( !empty($arr['teamStatus']) )  $value['od_team_status'] = $arr['teamStatus']; // 팀 주문 상태
        if( !empty($arr['teamLatest']) )  $value['od_team_latest'] = $arr['teamLatest']; // 마지막 클릭 일시

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['teamId']) )       $this->getParameter("od_team_id",$_REQUEST['teamId']);
        if( !empty($_REQUEST['teamHost']) )     $this->getParameter("od_team_host",$_REQUEST['teamHost']);
        if( !empty($_REQUEST['teamMax']) )      $this->getParameter("od_team_max",$_REQUEST['teamMax']);
        if( !empty($_REQUEST['teamCnt']) )      $this->getParameter("od_team_cnt",$_REQUEST['teamCnt']);
        if( !empty($_REQUEST['goodsId']) )      $this->getParameter("gs_id",$_REQUEST['goodsId']);
        if( !empty($_REQUEST['teamTime']) )     $this->getParameter("od_team_time",$_REQUEST['teamTime']);
        if( !empty($_REQUEST['teamStatus']) )   $this->getParameter("od_team_status",$_REQUEST['teamStatus']);
        if( !empty($_REQUEST['teamLatest']) )   $this->getParameter("od_team_latest",$_REQUEST['teamLatest']);
        if( !empty($_REQUEST['teamRegdate']) )  $this->getParameter("od_team_regdate",$_REQUEST['teamRegdate']);

        //not in
        if( !empty($_REQUEST['notTeamHost']) )  $this->getParameter("od_team_host",$_REQUEST['notTeamHost'], 'cons');

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("od_team_regdate",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("od_team_regdate",$_REQUEST['end'],"le");
            }else if( $_REQUEST['term'] == "timeLimit" ){
                if( !empty($_REQUEST['beg']) ) $this->getInterval("od_team_time",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getInterval("od_team_time",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by od_team_latest asc ";    // 기본 정렬 방식 설정

        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'teamId' ) $this->sql_order = " order by od_team_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamHost' ) $this->sql_order = " order by od_team_host {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamMax' ) $this->sql_order = " order by od_team_max {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamCnt' ) $this->sql_order = " order by od_team_cnt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsId' ) $this->sql_order = " order by gs_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamTime' ) $this->sql_order = " order by od_team_time {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamStatus' ) $this->sql_order = " order by od_team_status {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamLatest' ) $this->sql_order = " order by od_team_latest {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'teamRegdate' ) $this->sql_order = " order by od_team_regdate {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }
/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and od_team_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id,$type="arr"){
        if( empty($id) ) $id = $arr['teamId'];
        if( empty($id) ) return "002";
        $preValue = $this->get("*", array("od_team_id"=>$id) );

        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $flag = false;
        foreach($preValue as $k=>$v){
            if( isset($value[$k]) && strcmp($value[$k],$v)!=0 ) $flag = true;
        }
        if($flag){
            $search = " and od_team_id = '{$id}' ";
            $res = $this->update($value,$search);
            if($res == "000" && !empty($arr["teamHost"]) && !empty($arr["teamStatus"])){            
                $log  = new \application\models\OrderTeamHistoryModel();            
                $log->add(
                    array(
                        "teamId"=>$id,
                        "change"=>$arr["teamStatus"],
                        "self"=>$arr["teamHost"],
                    )
                );
            }            
            return $res;
        }else{
            return "001";
        }
    }

    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $res = $this->insert($value);
        $lastId = $this->pdo->lastInsertId();
        if($res == "000" && !empty($arr["teamHost"]) && !empty($arr["teamStatus"])){            
            $log  = new \application\models\OrderTeamHistoryModel();            
            $log->add(
                array(
                    "teamId"=>$lastId,
                    "change"=>$arr["teamStatus"],
                    "self"=>$arr["teamHost"],
                )
            );
        }
        return array("res" => $res, "lastId" => $lastId);
    }

    function remove($id){
        if(empty($id)) return"002";
        $search = " and od_team_id = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }    

    function memberBreak($mb_id){
        if(empty($mb_id)) return"002";
        $updateArr = array('od_team_status' => 'break');
        $search = " and od_team_host = '{$mb_id}' ";
        $res = $this->update($updateArr, $search);
        return $res;
    }            
}
?>
