<?php
namespace application\models;

class GoodsOptionModel extends Model{
    var $colArr;   

    public function __construct( ){
        parent::__construct ( 'web_goods_option');
        $this->colArr = array(
            "optionId"=>"gs_opt_id",
            "bacode"=>"gs_opt_code",
            "optionName"=>"gs_opt_name",
            "optionType"=>"gs_opt_type",
            "goodsId"=>"gs_id",
            "addPrice"=>"gs_opt_add_price",
            "optionStockQty"=>"gs_opt_stock_qty",
            "useYn"=>"gs_opt_use_yn",
        );
    }

    public function getValue($arr, $mode="add"){
        if( empty($arr) ) return;

        if( $mode=="add" ){
            $value['gs_id'] = $arr['goodsId']; 
            $value['gs_opt_reg_dt'] = _DATE_YMDHIS;
        }

        if( !empty($this->preValue['gs_id']) ) $gs_id = $this->preValue['gs_id'];
        if( !empty($value['gs_id']) ) $gs_id = $value['gs_id'];
        if( empty($gs_id) ) return;

        if( !empty($arr['name']) ) $value['gs_opt_name'] = $arr['name'];
        if( !empty($arr['code']) ) $value['gs_opt_code'] = $arr['code'];
        if( !empty($arr['type']) ) $value['gs_opt_type'] = $arr['type'];
        if( !empty($arr['orderby']) ) $value['gs_opt_orderby'] = $arr['orderby'];
        if( isset($arr['addPrice']) ) $value['gs_opt_add_price'] = only_number($arr['addPrice']);
        if( isset($arr['supplyPrice']) ) $value['gs_opt_supply_price'] = only_number($arr['supplyPrice']);
        if( isset($arr['stockQty']) ) $value['gs_opt_stock_qty'] = only_number($arr['stockQty']);
        if( isset($arr['qtyNoti']) ) $value['gs_opt_stock_qty_noti'] = $arr['qtyNoti'];
        if( !empty($arr['useYn']) ) $value['gs_opt_use_yn'] = $arr['useYn'];
        $value['gs_opt_update_dt'] = _DATE_YMDHIS;

        $gs_opt_add_price = 0;
        if( isset($this->preValue['gs_opt_add_price']) ) $gs_opt_add_price = $this->preValue['gs_opt_add_price'];
        if( isset($value['gs_opt_add_price']) ) $gs_opt_add_price = $value['gs_opt_add_price'];

        $goodsModel = new \application\models\GoodsModel();
        $goodsRow = $goodsModel->get("gs_rate,gs_price,gs_supply_price",array("gs_id"=>$gs_id));
        $rate = (100 - $goodsRow['gs_rate'])/100;
        $gs_opt_supply_price = round((($gs_opt_add_price+ $goodsRow['gs_price']) * $rate),-1);
        $value['gs_opt_supply_price'] = $gs_opt_supply_price;

        return $value;
    }

    public function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("gs_opt_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "goodsId" ) $this->getSearch("gs_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" ) $this->getSearch("gs_opt_name",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['optionId']) ) $this->getParameter("gs_opt_id",$_REQUEST['optionId']);
        if( !empty($_REQUEST['goodsId']) ) $this->getParameter("gs_id",$_REQUEST['goodsId']);

        if( !empty($_REQUEST['type']) ) $this->getParameter("gs_opt_type",$_REQUEST['type']);
        if( !empty($_REQUEST['leQty']) )    $this->getInterval("gs_opt_stock_qty",$_REQUEST['leQty'],"le");
        if( !empty($_REQUEST['geQty']) )   $this->getInterval("gs_opt_stock_qty",$_REQUEST['geQty'],"ge");
        if( !empty($_REQUEST['useYn']) ) $this->getParameter("gs_opt_use_yn",$_REQUEST['useYn']);
        if( !empty($_REQUEST['qtyNoti']) ){
            $this->sql_where .= " and ( gs_opt_stock_qty <= gs_opt_stock_qty_noti ) ";
        }
        return $this->sql_where;
    }

    public function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) )  $this->sql_order = " order by gs_id, gs_opt_orderby asc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'id' ) $this->sql_order = " order by gs_opt_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsId' ) $this->sql_order = " order by gs_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'type' ) $this->sql_order = " order by gs_opt_type {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'stockQty' ) $this->sql_order = " order by gs_opt_stock_qty {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by gs_opt_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'updateDate' ) $this->sql_order = " order by gs_opt_update_dt {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

    public function set($arr, $id, $type="arr"){
        if( empty($arr) ) return "002";
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $this->preValue = $this->get("*", array("gs_opt_id"=>$id));

        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        $search = " and gs_opt_id = '{$id}' ";
        $res = $this->update($value,$search);
        if( $res == "000" ){
            $exclude = array('gs_opt_stock_qty_noti','gs_opt_update_dt');
            $data = $this->addLog($id,$value,$exclude,"수정");
        }
        return $res;
    }

    public function add($arr, $type="arr"){
        if($type == "arr")  $value = $this->getValue($arr,'add');
        else $value = $arr; 
        $res = $this->insert($value);
        if($res=="000"){
            $data = $this->addLog($this->pdo->lastInsertId(),array(),array(),"등록");
        }
        return $res;
    }

    public function remove($id){
        $sql_where = " and gs_opt_id = '{$id}' ";
        $res = $this->delete($sql_where);
        if($res=="000"){
            $data = $this->addLog($id,array(),array(),"삭제");
        }
        return $res;
    }

    public function duplication($id, $goodsId){    
        $exclude = array('gs_opt_id','gs_id','gs_opt_reg_dt','gs_opt_update_dt');
        $col = get_column(array_keys($this->col_nm), $exclude, false);
        $value = $this->get($col, array("gs_opt_id"=>$id));
        $value['gs_id'] = $goodsId;
        $value['gs_opt_reg_dt'] = _DATE_YMDHIS;
        $value['gs_opt_update_dt'] = _DATE_YMDHIS;
        $res = $this->add($value,"value");
        return $res;
    }

    public function order($id,$qty,$order=true){
        if($order){
            $sql = "update ".$this->tb_nm." set gs_opt_stock_qty = gs_opt_stock_qty - $qty where gs_opt_id = '".$id."' ";
        }else{
            $sql = "update ".$this->tb_nm." set gs_opt_stock_qty = gs_opt_stock_qty + $qty where gs_opt_id = '".$id."' ";
        }
        return $this->execute( $sql );
    }

}
