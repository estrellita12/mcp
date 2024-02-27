<?php
namespace application\models;

use \PDO;

class SellerGradeModel extends Model
{

    function __construct( ){
        parent::__construct ( 'web_seller_grade' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if( !empty($arr['id']) )     $value['sl_grade_id'] = $arr['id'];
        if( isset($arr['name']) )     $value['sl_grade_name'] = $arr['name']; 
        if( !empty($arr['sale']) )     $value['sl_grade_price_sale'] = $arr['sale'];
        if( !empty($arr['saleUnit']) )     $value['sl_grade_sale_unit'] = $arr['saleUnit'];
        if( !empty($arr['saleCut']) )     $value['sl_grade_sale_cut'] = $arr['saleCut'];
        if( isset($arr['memo']) )     $value['sl_grade_adm_memo'] = $arr['memo']; 
        return $value;
    }

    function getNameList(){
        $row = $this->selectAll("sl_grade_id, sl_grade_name", "and sl_grade_name!=''", "order by sl_grade_id desc");
        for($i=0;$i<count($row);$i++ ){
            $gr_li[$row[$i]['sl_grade_id']] = $row[$i]['sl_grade_name'];
        }
        return $gr_li;
    }

    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and sl_grade_id = '{$id}' ";
        return $this->update($value,$search);
    }
}
?>
