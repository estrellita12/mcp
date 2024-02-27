<?php
namespace application\models;

class GoodsHistoryModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_goods_history' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['goodsId']) ) return;
            $value['gs_id'] = $arr['goodsId']; 
            $value['gsh_by_id'] = $_SESSION['user_id'];
            $value['gsh_by_id_type'] = $_SESSION['user_type'];
            if( !empty($arr['data']) )          $value['gsh_change_data'] = $arr['data']; 
            if( !empty($arr['memo']) )          $value['gsh_memo'] = $arr['memo']; 
            $value['gsh_reg_dt'] = _DATE_YMDHIS; 
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['goodsId']) ) $this->getParameter("gs_id",$_REQUEST['goodsId']);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by gsh_reg_dt desc ";  
        return $this->sql_order;
    }

/*
    function get($id, $col="*"){
        $sql_where = " and gsh_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }
}
