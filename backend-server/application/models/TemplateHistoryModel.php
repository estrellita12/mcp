<?php
namespace application\models;

class TemplateHistoryModel extends Model{

    public function __construct( ){
        parent::__construct ( 'web_template_history' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['tpId']) ) return;
            $value['tp_id'] = $arr['tpId'];
            $value['tph_by_id'] = $_SESSION['user_id'];
            $value['tph_by_id_type'] = $_SESSION['user_type'];
            if( !empty($arr['data']) )     $value['tph_change_data'] = $arr['data']; 
            if( !empty($arr['memo']) )     $value['tph_memo'] = $arr['memo']; 
            $value['tph_reg_dt'] = _DATE_YMDHIS; 
        }
        return $value;
    }

    public function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['tpId']) ) $this->getParameter("tp_id",$_REQUEST['tpId']);
        return $this->sql_where;
    }

    public function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by tph_reg_dt desc ";
        return $this->sql_order;
    }

    public function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    /*
    public function set($arr,$id=''){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $value = $this->getValue($arr,'set');
        $search = " and tph_id = '{$id}' ";
        return $this->update($value,$search);
    }
    */

}
