<?php
namespace application\models;

use \PDO;

class CartModel extends Model{
    var $colArr;   
    function __construct( ){
        parent::__construct ( 'web_cart' );
        $this->colArr = array(
            "cartId"=>"cart_id",
            "userId"=>"mb_id",
            "odNo"=>"cart_od_no",
            "goodsId"=>"gs_id",
            "optionId"=>"gs_opt_id",
            "qty"=>"cart_qty",
            "direct"=>"cart_direct",
            "regDate"=>"cart_reg_dt",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            $value['cart_reg_dt'] = _DATE_YMDHIS;
            if( !empty($arr['goodsId']) )           $value['gs_id'] = $arr['goodsId']; 
            if( !empty($arr['optionId']) )     $value['gs_opt_id'] = $arr['optionId'];
        }

        if( !empty($arr['odNo']) )           $value['cart_od_no'] = $arr['odNo']; 
        if( !empty($arr['qty']) )          $value['cart_qty'] = $arr['qty'];  
        if( !empty($arr['userId']) )            $value['mb_id'] = $arr['userId'];
        if( isset($arr['direct']) )            $value['cart_direct'] = $arr['direct'];
        $value['cart_device_ip'] = $_SERVER['REMOTE_ADDR'];
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['cartId']) ) $this->getParameter("cart_id",$_REQUEST['cartId']);
        if( !empty($_REQUEST['odNo']) ) $this->getParameter("cart_od_no",$_REQUEST['odNo']);
        if( !empty($_REQUEST['userId']) ) $this->getParameter("mb_id",$_REQUEST['userId']);
        if( !empty($_REQUEST['direct']) ) $this->getParameter("cart_direct",$_REQUEST['direct']);
        if( !empty($_REQUEST['goodsId']) ) $this->getParameter("gs_id",$_REQUEST['goodsId']);
        if( !empty($_REQUEST['optionId']) ) $this->getParameter("gs_opt_id",$_REQUEST['optionId']);
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by gs_id,cart_reg_dt desc "; 
    }
/*
    function get($id, $col="*"){
        if( empty($id) ) return "002";
        $sql_where = " and cart_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id,$type="arr"){
        if(empty($id)) $id=$arr['id'];
        if(empty($id)) return "002";

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and cart_id = '{$id}' ";
        $res = $this->update($value,$search);
        return $res;
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $res = $this->insert($value);
        return $res;
    }

    function remove($id){
        if(empty($id)) return"002";
        $search = " and cart_id = '{$id}' ";
        $res = $this->delete($search);
        return $res;
    }

    function order($no){
        if(empty($no)) return"002";
        $search = " and cart_od_no = '{$no}' ";
        $res = $this->delete($search);
        return $res;
    }

    function login($userId, $direct){
        if( empty($userId) || empty($direct) ) return"002";
        $value['mb_id'] = $userId;
        $value['cart_direct'] = "";
        $search = " and cart_direct = '{$direct}' ";
        $res = $this->update($value,$search);
        return $res;
    }

    function goodsLeftJoin(){
        $gs_opt_col_nm = $this->getColName("web_goods_option");
        $gs_col_nm = $this->getColName("web_goods");
        $col_nm = array_merge( $this->col_nm , $gs_col_nm,$gs_opt_col_nm );

        $col = "";      
        foreach($col_nm as $k=>$v){
            if( !empty($col ) ) $col .= ",";
            if(array_key_exists($k,$this->col_nm)){
                $col .= "a.$k as $k";
            }else if(array_key_exists($k,$gs_opt_col_nm)){
                $col .= "b.$k as $k";
            }else{
                $col .= "c.$k as $k";
            }
        }
        $this->sql_from = "( select $col from {$this->tb_nm} a left join web_goods_option b on a.gs_opt_id = b.gs_opt_id join web_goods c on b.gs_id = c.gs_id  ) d  ";
        $this->col_nm = $col_nm;
 
        
            
    }

}
?>
