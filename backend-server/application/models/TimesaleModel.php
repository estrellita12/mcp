<?php
namespace application\models;

use \PDO;

class TimesaleModel extends Model
{

    public function getValue(){

    }

    // 상품 번호로 판매 수량 및 매출 총액
    public function getGsSales($gs_list,$begin_date,$end_date)
    {
        global $order_list;
        if( strpos($gs_list,",") ){
            $sql_search = " and gs_id in ({$gs_list}) ";
        }else{
            $sql_search = " and gs_id = $gs_list ";
        }
        $sql_search .= " and od_time >= '{$begin_date}' and od_time <= '{$end_date}' ";
        $sql_search .= " and dan in {$order_list} ";
        $sql = "SELECT sum(sum_qty) as sum_qty, sum(use_price) as sum_use_price, sum(goods_price) as sum_goods_price, sum(baesong_price) as sum_baesong_price, sum(use_coupon) as sum_coupon_price, sum(use_point) as sum_use_point FROM web_order where 1 = 1 {$sql_search}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}


?>
