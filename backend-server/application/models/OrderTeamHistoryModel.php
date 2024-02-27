<?php
namespace application\models;

use \PDO;

class OrderTeamHistoryModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_order_team_history' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['teamId']) ) return;
            $value['od_team_id'] = $arr['teamId'];
            if( !empty($arr['change']) ) $value['od_team_history_change'] = $arr['change']; 
            if( !empty($arr['self']) ) $value['od_team_history_who'] = $arr['self']; 
            $value['od_team_history_when'] = _DATE_YMDHIS; 
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['teamId']) ) $this->getParameter("od_team_id",$_REQUEST['teamId']);
        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by od_team_history_when asc ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }

/*
    function get($id, $col="*"){
        $sql_where = " and od_team_history_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }
}
?>
