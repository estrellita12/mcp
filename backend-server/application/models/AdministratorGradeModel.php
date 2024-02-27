<?php
namespace application\models;

use \PDO;

class AdministratorGradeModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_administrator_grade' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if( !empty($arr['id']) )     $value['adm_grade_id'] = $arr['id'];
        if( isset($arr['name']) )     $value['adm_grade_name'] = $arr['name']; 
        if( !empty($arr['sale']) )     $value['adm_grade_price_sale'] = $arr['sale'];
        if( !empty($arr['saleUnit']) )     $value['adm_grade_sale_unit'] = $arr['saleUnit'];
        if( !empty($arr['saleCut']) )     $value['adm_grade_sale_cut'] = $arr['saleCut'];
        if( !empty($arr['memo']) )     $value['adm_grade_adm_memo'] = $arr['memo']; 
        return $value;
    }

    function getNameList(){
        $row = $this->selectAll("adm_grade_id, adm_grade_name", "and adm_grade_name!=''", "order by adm_grade_id desc");
        for($i=0;$i<count($row);$i++ ){
            $gr_li[$row[$i]['adm_grade_id']] = $row[$i]['adm_grade_name'];
        }
        return $gr_li;
    }

    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and adm_grade_id = '{$id}' ";
        return $this->update($value,$search);
    }

}
?>
