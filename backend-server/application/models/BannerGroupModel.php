<?php
namespace application\models;

class BannerGroupModel extends Model{
    function __construct( ){
        parent::__construct ( 'web_banner_group' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode == "add"){
            $value['bngr_reg_dt'] =  _DATE_YMDHIS; // 등록일시
        }
        $value['bngr_update_dt'] =  _DATE_YMDHIS; // 수정 일시
        if( !empty($arr['name']) )   $value['bngr_name'] = $arr['name'];
        if( !empty($arr['device']) )   $value['bngr_device'] = $arr['device'];
        if( !empty($arr['width']) )   $value['bngr_w_size'] = $arr['width'];
        if( !empty($arr['height']) )   $value['bngr_h_size'] = $arr['height'];
        return $value;
    }

    function getWhere(){
        parent::getWhere();
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by bngr_update_dt asc"; 
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by bngr_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'updateDate' ) $this->sql_order = " order by bngr_update_dt {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }
    function set($arr, $id='',$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002"; 
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        $search = " and bngr_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    function remove( $id ){
        if(empty($id)) return "002";
        $search = " and bngr_id = '{$id}' ";
        return $this->delete($search);
    }

    function getNameList($device="a"){
        $search = array();
        if( $device != "a" ){
            $search['bngr_device'] = $device;
        }
        $search['bngr_device_in_'] = "1,2";
        $search['col'] = "bngr_reg_dt";
        $search['colby'] = "asc";
        $rowAll = $this->get("bngr_id,bngr_name,bngr_w_size, bngr_h_size",$search,true);
        $gr_li = array();
        foreach($rowAll as $row){
            $gr_li[$row['bngr_id']] = "{$row['bngr_name']} ({$row['bngr_w_size']} X {$row['bngr_h_size']})";
        }
        return $gr_li;
    }   



}
?>
