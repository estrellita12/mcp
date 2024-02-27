<?php
namespace application\Front\controllers;

class mediaController extends Controller{
    private $model;
    private $search;
    private $sql;

    public function init(){
        $this->model = new \application\models\MediaModel();
        $this->col = array(
            "media_id"=>"media_id",
            "ctg_id"=>"ctg_id",
            "media_title"=>"media_title",
            "media_type"=>"media_type",
            "media_goods_list"=>"media_goods_list",
            "media_refer"=>"media_refer",
            "media_content"=>"media_content",
            "media_list_img"=>"if(media_list_img!='',concat('"._MEDIA."',media_list_img),'')",
            "media_begin_dt"=>"media_begin_dt",
            "media_end_dt"=>"media_end_dt",
        );
    }

    public function getSearch($request = array()){
        $this->search = array();
        $this->search['ctg_id_in_'] = implode(",",$this->shopUseCtg);
        $this->search['pt_id_in_'] = "admin,".$this->shopId;
        $this->search['media_show_yn'] = "y";
        $this->search['media_begin_dt_then_le'] = _DATE_YMDHIS;
        $this->search['media_end_dt_then_ge'] = _DATE_YMDHIS;
        $this->search['col'] = "media_orderby";
        if( !empty($request['rpp']) )  $this->search['rpp'] = $request['rpp'];
        if( !empty($request['media_type']) )  $this->search['media_type'] = $request['media_type'];
    }

    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        $this->getSearch($request);

        $col = get_column_as($this->col,array("media_content"),false);
        $row = $this->model->get($col,$this->search,true);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function get(){
        $request = array();
        if( !empty($this->param['ident']) ) $request = $this->request['get'];
        $this->getSearch($request);
        $this->search['media_id'] = $this->param['ident'];
        $col = get_column_as($this->col,array(),false);
        $row = $this->model->get($col,$this->search,false);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $row['media_goods_list'] = get_list($row['media_goods_list']);
        $row['media_content'] = stripslashes($row['media_content']);
        $this->response_json("000",array("data"=>$row));
    }

    public function goods(){
        if( empty($this->param['ident']) ) $this->result("002");
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $search = array();
        $search['media_id'] = $this->param['ident'];
        $row = $this->model->get("media_goods_list", $search,false);
        if( empty($row) ) $this->result("001"); 
        if( !is_array($row) ) $this->result($row); 

        $request['gs_id'] = $row['media_goods_list'];
        $this->goodsModel = new \application\Front\models\GoodsModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
        $col = get_column_as($this->goodsModel->col,array("gs_detail_content"),false);
        $row = $this->goodsModel->get($col, $request,true);
        if( empty($row) ) $this->result("001"); 
        if( !is_array($row) ) $this->result($row); 
        $this->response_json("000",array("list"=>$row));
    }


}

