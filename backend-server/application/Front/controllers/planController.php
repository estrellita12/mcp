<?php
namespace application\Front\controllers;

class planController extends Controller{
    private $model;
    private $search;
    private $sql;

    public function init(){
        $this->planModel = new \application\Front\models\PlanModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
    }

    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $col = get_column_as($this->planModel->col,array("plan_content"),false);
        $row = $this->planModel->get($col, $request,true);
        if( empty($row) ) $this->result("001"); 
        if( !is_array($row) ) $this->result($row); 
        $this->response_json("000",array("list"=>$row));
    }


    public function get(){
        if( empty($this->param['ident']) ) $this->result("002");
        $request['plan_id'] = $this->param['ident'];
        
        $col = get_column_as($this->planModel->col,array(),false);
        $row = $this->planModel->get($col, $request,false);
        if( empty($row) ) $this->result("001"); 
        if( !is_array($row) ) $this->result($row); 
        $row['plan_goods_list'] = get_list($row['plan_goods_list']);
        $row['plan_content'] = stripslashes($row['plan_content']);
        $this->response_json("000",array("data"=>$row));
    }

    public function goods(){
        if( empty($this->param['ident']) ) $this->result("002");
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $search = array();
        $search['plan_id'] = $this->param['ident'];
        $row = $this->planModel->get("plan_goods_list", $search,false);
        if( empty($row) ) $this->result("001"); 
        if( !is_array($row) ) $this->result($row); 

        $request['gs_id'] = $row['plan_goods_list'];
        $this->goodsModel = new \application\Front\models\GoodsModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
        $col = get_column_as($this->goodsModel->col,array("gs_detail_content"),false);
        $row = $this->goodsModel->get($col, $request,true);
        if( empty($row) ) $this->result("001"); 
        if( !is_array($row) ) $this->result($row); 
        $this->response_json("000",array("list"=>$row));
    }

}

