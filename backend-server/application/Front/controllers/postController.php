<?php
namespace application\Front\controllers;

class postController extends Controller{
    private $model;
    private $search;
    private $sql;

    public function init(){
        $this->col = array(
            "bopo_id"=>"bopo_id",
            "bopo_pid"=>"bopo_pid",
            "bopo_depth"=>"bopo_depth",
            "bopo_type"=>"bopo_type",
            //"bopo_order_no"=>"bopo_order_no",
            "bopo_category"=>"bopo_category",
            "bopo_secret_yn"=>"bopo_secret_yn",
            "bopo_use_html"=>"bopo_use_html",
            "user_id"=>"user_id",
            "user_name"=>"user_name",
            "bopo_title"=>"bopo_title",
            "bopo_content"=>"bopo_content",
            "bopo_file1"=>"bopo_file1",
            "bopo_file2"=>"bopo_file2",
            "bopo_view_count"=>"bopo_view_count",
            "bopo_comment_count"=>"bopo_comment_count",
            "bopo_reg_dt"=>"bopo_reg_dt",
            "bopo_update_dt"=>"bopo_update_dt",
            "pt_id"=>"pt_id",
            "bopo_main_display"=>"bopo_main_display",
            "bopo_main_display_order"=>"bopo_main_display_order",
        );
    }
    
    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        if( empty($request['bo_id']) ) $this->result("002");

        $postModel = new \application\models\PostModel($request['bo_id']);
        $search = array();
        $search['bopo_id_then_ne'] = 0;
        if( !empty($request['bopo_pid']) ) $search['bopo_pid'] = $request['bopo_pid'];
        if( !empty($request['bopo_depth']) ) $search['bopo_depth'] = $request['bopo_depth'];
        $search['col'] = "bopo_reg_dt";
        $search['colby'] = "desc";
        $col = get_column_as($this->col,array("bopo_content"),false);
        $row = $postModel->get($col,$search,true);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function get(){
        if( empty($this->param['ident']) ) $this->result("002");

        $postModel = new \application\models\PostModel($request['bo_id']);
        $search = array();
        $search['bopo_id'] = $this->param['ident'];
        $col = get_column_as($this->col,array(),false);
        $row = $postModel->get($col,$search,false);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("data"=>$row));
    }
}
?>
