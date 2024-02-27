<?php
namespace application\models;

use \PDO;

class GoodsOptionJoinModel extends Model{

    var $colArr;   

    function __construct( ){
        parent::__construct ( '( select b.*, a.gs_opt_id as gs_opt_id, a.gs_opt_supply_price,a.gs_opt_code gs_opt_code, a.gs_opt_name as gs_opt_name,a.gs_opt_type as gs_opt_type, a.gs_opt_add_price as gs_opt_add_price, a.gs_opt_stock_qty as gs_opt_stock_qty, a.gs_opt_stock_qty_noti as gs_opt_stock_qty_noti, a.gs_opt_use_yn as gs_opt_use_yn, a.gs_opt_reg_dt as gs_opt_reg_dt, a.gs_opt_update_dt as gs_opt_update_dt, a.gs_opt_orderby as gs_opt_orderby from web_goods_option a left join web_goods b on a.gs_id=b.gs_id ) c ' );
        $this->option = new \application\models\GoodsOptionModel();
        $this->goods = new \application\models\GoodsModel();
        $this->colArr = array_merge($this->goods->colArr, $this->option->colArr);
    }

    function getWhere(){
        parent::getWhere();
        $this->option->getWhere();
        $this->sql_where .= $this->option->sql_where;
        $this->goods->getWhere();
        $this->sql_where .= $this->goods->sql_where;
        $this->parameter = array_merge($this->goods->parameter, $this->option->parameter);
    }

    function getOrder(){
        parent::getOrder();
    }

    function getOption($id, $col='*', $falg=""){
        if( empty($id) ) return "002";
        $sql_where = " and gs_opt_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
}
