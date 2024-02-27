<?php
namespace application\models;

use \PDO;

class AdminGradeModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_admin_grade' );
    }

    function getNameList(){
        $gr_li[''] = "전체";
        $row = $this->selectAll("adm_grade, adm_grade_name", "and adm_grade_name!=''", "order by adm_grade desc");
        for($i=0;$i<count($row);$i++ ){
            $gr_li[$row[$i]['adm_grade']] = $row[$i]['adm_grade_name'];
        }
        return $gr_li;
    }

   function set($arr){
        try{
            for($i=0; $i<count($arr['id']); $i++){
                // 실제 번호를 넘김
                $idx = $arr['id'][$i];

                $sql = "update ".$this->tb_nm." set
                    adm_grade_name='{$arr['name'][$i]}',
                    adm_grade_price_sale ='{$arr['sale'][$i]}',
                    adm_grade_sale_unit ='{$arr['sale_unit'][$i]}',
                    adm_grade_sale_cut ='{$arr['sale_cut'][$i]}',
                    adm_grade_adm_memo ='{$arr['memo'][$i]}'
                    where adm_grade='{$arr['id'][$i]}' ";
                $res = $this->execute($sql);
            }
        }catch(Exception $e){
            return false;
        }
        return true;
    }
}
?>
