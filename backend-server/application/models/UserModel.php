<?php
namespace application\models;

use \PDO;

class UserModel extends Model{
    function __construct( ){
        parent::__construct ( 'web_user' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){  
            if( empty($arr['id']) ) return;
            $value['user_id'] = $arr['id'];
            $value['user_type'] = $arr['type'];
            $value['user_reg_dt'] = _DATE_YMDHIS;
        }
        return $value;
    }

    function getWhere(){
        parent::getWhere();
    }

    function getOrder(){
        parent::getOrder();
    }
/*
    function get($id, $col="*"){
        if( empty($id) ) return "002";
        $search = " and user_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/
    function add($arr, $type='arr'){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        if( !$this->overChk('user_id', $value['user_id']) ) return "003";
        return $this->insert($value);
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and user_id = '{$id}' ";
        return $this->delete($search);
    }

    function getType($id){
        if( empty($id) ) return "002";
        $search = array("user_id"=>$id);
        $row = $this->get( "user_type", $search );
        switch($row['user_type']){
            case "Administrator":
                return "adm_id";
            case "Seller":
                return "sl_id";
            case "Partner":
                return "pt_id";
            default :
                return "mb_id";
        }
    }
}

?>
