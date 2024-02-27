<?php
namespace application\models;

use \PDO;

class MemberGradeModel extends Model{
    var $colArr;

    function __construct( ){
        parent::__construct ( 'web_member_grade' );
        $this->colArr = array(
            "mbGradeId"=>"mb_grade_id",
            "mbGradeName"=>"mb_grade_name",
            "mbGradeSale"=>"mb_grade_price_sale",
            "mbGradeSaleUnit"=>"mb_grade_sale_unit",
            "mbGradeSaleCut"=>"mb_grade_sale_cut",
            "mbGradeMemo"=>"mb_grade_adm_memo"
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if( !empty($arr['id']) )     $value['mb_grade_id'] = $arr['id'];
        if( isset($arr['name']) )     $value['mb_grade_name'] = $arr['name']; 
        if( !empty($arr['sale']) )     $value['mb_grade_price_sale'] = $arr['sale'];
        if( !empty($arr['saleUnit']) )     $value['mb_grade_sale_unit'] = $arr['saleUnit'];
        if( !empty($arr['saleCut']) )     $value['mb_grade_sale_cut'] = $arr['saleCut'];
        if( !empty($arr['memo']) )     $value['mb_grade_adm_memo'] = $arr['memo']; 
        return $value;
    }

    function getNameList(){
        $row = $this->selectAll("mb_grade_id, mb_grade_name", "and mb_grade_name!=''", "order by mb_grade_id desc");
        for($i=0;$i<count($row);$i++ ){
            $gr_li[$row[$i]['mb_grade_id']] = $row[$i]['mb_grade_name'];
        }
        return $gr_li;
    }
/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and mb_grade_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and mb_grade_id = '{$id}' ";
        return $this->update($value,$search);
    }
}
?>
