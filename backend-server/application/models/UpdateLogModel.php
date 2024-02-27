<?php
namespace application\models;

use \Exception;

class UpdateLogModel extends Model{

    public function __construct( ){
        parent::__construct ( 'web_update_log' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['targetId']) ) return;
            $value['log_target_table'] = $arr['targetTable'];
            $value['log_target_id'] = $arr['targetId'];
            $value['log_by_id'] = !empty($_SESSION['user_id'])?$_SESSION['user_id']:"";
            $value['log_by_id_type'] = !empty($_SESSION['user_type'])?$_SESSION['user_type']:"";
            if( !empty($arr['data']) ) $value['log_change_data'] = $arr['data']; 
            if( !empty($arr['memo']) ) $value['log_memo'] = $arr['memo']; 
            $value['log_reg_dt'] = _DATE_YMDHIS; 
        }
        return $value;
    }

    public function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        $res = $this->insert($value);
        return $res;
    }
}
?>
