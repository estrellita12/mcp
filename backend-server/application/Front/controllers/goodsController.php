<?php
namespace application\Front\controllers;

class goodsController extends Controller{
    private $col;
    private $sql;
    private $search;

    public function init(){
        $this->goodsModel = new \application\Front\models\GoodsModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
    }

    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        if( !empty($request['type']) ){
            $gnbMenuModel = new \application\models\GnbMenuModel();
            $row = $gnbMenuModel->get("menu_{$request['type']}_goods_list as goods_list",array("pt_id"=>$this->shopId));
            if( empty($row) ){
                $row = $gnbMenuModel->get("menu_{$request['type']}_goods_list as goods_list",array("pt_id"=>"admin"));
            }
            if( !empty($row['goods_list']) ){
                $request['gs_id'] = $row['goods_list'];
            }
        }

        $col = get_column_as($this->goodsModel->col,array("gs_detail_content"),false);
        $row = $this->goodsModel->get($col,$request,true);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function get(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        if( empty($this->param['ident']) ) $this->result("002");
        $request['gs_id'] = $this->param['ident'];  
        $this->goodsModel->leftJoin("gs_id","web_goods_review","gs_id");
        $this->goodsModel->sql_group = "group by gs_id";
        $colArr = $this->goodsModel->col;
        $colArr['gs_review_avg_sum'] = "sum(gs_rv_star_average)";
        $colArr['gs_review_cnt'] = "count(gs_rv_star_average)";
        $colArr['gs_review_avg'] = "if(count(gs_rv_star_average)>0,sum(gs_rv_star_average)/count(gs_rv_star_average),0)";

        $col = get_column_as($colArr,array(),false);
        $row = $this->goodsModel->get($col,$request,false);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);

        $row['gs_detail_content'] = stripslashes($row['gs_detail_content']);
        $search = array();
        $search['gs_id'] = $this->param['ident'];
        $search['gs_opt_use_yn'] = "y";
        $search['col'] = "gs_opt_orderby";
        $optionModel = new \application\models\GoodsOptionModel();
        $optionList = $optionModel->get("gs_opt_id,gs_opt_code,gs_opt_name,gs_opt_add_price",$search,true);
        $row['gs_opt_li'] = $optionList;

        $sellerModel = new \application\models\SellerModel();
        $delivery = $sellerModel->get("sl_delivery_information",array("sl_id"=>$row['sl_id']));
        $row['gs_delivery_information'] = $delivery['sl_delivery_information'];
        $this->response_json("000",array("data"=>$row));
    }

    public function cnt(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        if( !empty($request['rpp']) ) unset($request['rpp']);
        if( !empty($request['page']) ) unset($request['page']);
        $this->getSearch($request);
        $row = $this->goodsModel->get("count(gs_id) as cnt",$this->search,false,$this->sql);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("cnt"=>$row['cnt']));
    }

    public function category(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        $request['col'] = "ctg_cnt";
        $request['colby'] = "desc";

        $depth = $this->param['ident'] * 3;
        $this->goodsModel->sql_group = " group by gs_ctg ";
        $row = $this->goodsModel->get("left(gs_ctg,{$depth}) as gs_ctg,count(gs_ctg) as ctg_cnt",$request,true);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

}

