<?php
namespace application\models;

class MemberPointModel extends Model{

    public function __construct( ){
        parent::__construct ( 'web_member_point' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            if( !empty($arr['id']) )        $value['mb_id'] = $arr['id'];
            //if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop']; 
            if( !empty($arr['type']) )     $value['mbp_type'] = $arr['type']; 
            if( !empty($arr['point']) )     $value['mbp_point'] = $arr['point']; 
            if( !empty($arr['odNo']) )     $value['mbp_od_no'] = $arr['odNo']; 
            if( !empty($arr['reason']) )    $value['mbp_get_reason'] = $arr['reason'];
            $value['mbp_reg_dt'] = _DATE_YMDHIS;
            $value['mbp_expire_dt'] = date("Y-m-d H:i:s", strtotime("+180 days"));
        }
        return $value;
    }

    public function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        $res = $this->insert($value);
        return $res;
    }
}
?>
