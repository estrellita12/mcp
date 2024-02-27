<?php
namespace application\models;

use \PDO;

class CartGoodsJoinModel extends Model{

    var $colArr;   

    function __construct( ){
        //parent::__construct ( '( select b.*, a.gs_opt_id as gs_opt_id, a.gs_id as gs_opt_gs_id, a.gs_opt_code gs_opt_code, a.gs_opt_name as gs_opt_name, a.gs_opt_add_price as gs_opt_add_price, a.gs_opt_stock_qty as gs_opt_stock_qty, a.gs_opt_use_yn as gs_opt_use_yn from web_goods_option a left join web_goods b on a.gs_id=b.gs_id ) c ' );
        parent::__construct ( '( select a.cart_id as cart_id,a.cart_direct as cart_direct, a.mb_id as mb_id, a.cart_od_no as cart_od_no, a.cart_qty as cart_qty, a.cart_reg_dt as cart_reg_dt, b.gs_opt_id as gs_opt_id, b.gs_id as gs_opt_gs_id, b.gs_opt_code gs_opt_code, b.gs_opt_name as gs_opt_name, b.gs_opt_type as gs_opt_type, b.gs_opt_add_price as gs_opt_add_price, b.gs_opt_stock_qty as gs_opt_stock_qty, b.gs_opt_stock_qty_noti as gs_opt_stock_qty_noti, b.gs_opt_use_yn as gs_opt_use_yn, b.gs_opt_reg_dt as gs_opt_reg_dt, b.gs_opt_update_dt as gs_opt_update_dt, c.* from web_cart a left join web_goods_option b on a.gs_opt_id=b.gs_opt_id left join web_goods c on b.gs_id=c.gs_id ) d ' );

        $this->cart = new \application\models\CartModel();
        $this->optJoin = new \application\models\GoodsOptionJoinModel();
        $this->colArr = array_merge($this->cart->colArr, $this->optJoin->colArr);
    }

    function getWhere(){
        parent::getWhere();
        $this->cart->getWhere();
        $this->sql_where .= $this->cart->sql_where;
        $this->optJoin->getWhere();
        $this->sql_where .= $this->optJoin->sql_where;
        $this->parameter = array_merge($this->cart->parameter, $this->optJoin->parameter);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by sl_id desc ";
    }

}
