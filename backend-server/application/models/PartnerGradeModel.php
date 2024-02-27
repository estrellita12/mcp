<?php
namespace application\models;

use \PDO;

class PartnerGradeModel extends Model{

    function __construct( ){
        parent::__construct ( 'web_partner_grade' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if( !empty($arr['id']) )     $value['pt_grade_id'] = $arr['id'];
        if( isset($arr['name']) )     $value['pt_grade_name'] = $arr['name']; 
        if( !empty($arr['sale']) )     $value['pt_grade_price_sale'] = $arr['sale'];
        if( !empty($arr['saleUnit']) )     $value['pt_grade_sale_unit'] = $arr['saleUnit'];
        if( !empty($arr['saleCut']) )     $value['pt_grade_sale_cut'] = $arr['saleCut'];
        if( isset($arr['memo']) )     $value['pt_grade_adm_memo'] = $arr['memo']; 
        return $value;
    }

    function getNameList(){
        $row = $this->selectAll("pt_grade_id, pt_grade_name", "and pt_grade_name!=''", "order by pt_grade_id desc");
        $gr_li = array();
        if( is_array($row) ){
            for($i=0;$i<count($row);$i++ ){
                $gr_li[$row[$i]['pt_grade_id']] = $row[$i]['pt_grade_name'];
            }
        }
        return $gr_li;
    }

    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and pt_grade_id = '{$id}' ";
        return $this->update($value,$search);
    }

}
?>
