<?php
namespace application\Front\controllers;

class goodsController extends Controller{
    private $col;
    private $sql;
    private $search;

    public function init(){
        $this->goodsModel = new \application\Front\models\GoodsModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
        /*   
        $this->goodsModel = new \application\models\GoodsModel();
        $this->col = array(
            "gs_id"=>"gs_id",
            "gs_name"=>"gs_name",
            "gs_code"=>"gs_code",
            "gs_ctg"=>"gs_ctg",
            "gs_ctg2"=>"gs_ctg2",
            "gs_ctg3"=>"gs_ctg3",
            "gs_buy_use_grade"=>"gs_buy_use_grade",
            "gs_brand"=>"gs_brand",
            "sl_id"=>"sl_id",
            "gs_isopen"=>"gs_isopen",
            "gs_consumer_price"=>"gs_consumer_price",
            "gs_stock_qty"=>"gs_stock_qty",
            "gs_sales_begin_dt"=>"gs_sales_begin_dt",
            "gs_sales_end_dt"=>"gs_sales_end_dt",
            "gs_delivery_type"=>"gs_delivery_type",
            "gs_delivery_charge"=>"gs_delivery_charge",
            "gs_delivery_free"=>"gs_delivery_free",
            "gs_delivery_each_use"=>"gs_delivery_each_use",
            "gs_delivery_region"=>"gs_delivery_region",
            "gs_delivery_region_msg"=>"gs_delivery_region_msg",
            "gs_simg_type"=>"gs_simg_type",
            "gs_simg1"=>"if(gs_simg_type = 0 and gs_simg1 != '', concat('"._GOODS."',gs_code,'/',gs_simg1), gs_simg1)",
            "gs_simg2"=>"if(gs_simg_type = 0 and gs_simg2 != '', concat('"._GOODS."',gs_code,'/',gs_simg2), gs_simg2)",
            "gs_simg3"=>"if(gs_simg_type = 0 and gs_simg3 != '', concat('"._GOODS."',gs_code,'/',gs_simg3), gs_simg3)",
            "gs_simg4"=>"if(gs_simg_type = 0 and gs_simg4 != '', concat('"._GOODS."',gs_code,'/',gs_simg4), gs_simg4)",
            "gs_simg5"=>"if(gs_simg_type = 0 and gs_simg5 != '', concat('"._GOODS."',gs_code,'/',gs_simg5), gs_simg5)",
            "gs_timg1"=>"if(gs_simg_type = 0 and gs_simg1 != '', concat('"._GOODS."',gs_code,'/thumb/',gs_simg1), '')",
            "gs_timg2"=>"if(gs_simg_type = 0 and gs_simg2 != '', concat('"._GOODS."',gs_code,'/thumb/',gs_simg2), '')",
            "gs_timg3"=>"if(gs_simg_type = 0 and gs_simg3 != '', concat('"._GOODS."',gs_code,'/thumb/',gs_simg3), '')",
            "gs_timg4"=>"if(gs_simg_type = 0 and gs_simg4 != '', concat('"._GOODS."',gs_code,'/thumb/',gs_simg4), '')",
            "gs_timg5"=>"if(gs_simg_type = 0 and gs_simg5 != '', concat('"._GOODS."',gs_code,'/thumb/',gs_simg5), '')",
            "gs_video_url"=>"gs_svideo_url",
            "gs_detail_content"=>"gs_detail_content",
            "gs_opt_subject"=>"gs_opt_subject",
            "gs_add_opt_subject"=>"gs_add_opt_subject",
            "gs_order_qty"=>"gs_order_qty",
            "gs_view_cnt"=>"gs_view_cnt",
            "gs_order_max_qty"=>"gs_order_max_qty",
            "gs_order_min_qty"=>"gs_order_min_qty"
        );

        $this->col['gs_price'] = "gs_price_{$this->shopGrade}";
        if( !empty($this->userGrade) ){
            $this->memberGrade = new \application\models\MemberGradeModel();
            $mg = $this->memberGrade->get("mb_grade_price_sale, mb_grade_sale_unit,mb_grade_sale_cut",array("mb_grade_id"=>$this->userGrade));
            if( !empty($mg['mb_grade_price_sale']) ){
                if( $mg['mb_grade_sale_unit'] == "1" ){
                    $gs_price = "( gs_price_{$this->shopGrade} * ( (100 - {$mg['mb_grade_price_sale']})/100 ) )  ";
                    $this->col['gs_price'] = "( TRUNCATE({$gs_price},{$mg['mb_grade_sale_cut']}) )"; // 버림
                }else{
                    $gs_price = "( gs_price_{$this->shopGrade} - {$mg['mb_grade_price_sale']} ) ";
                    $this->col['gs_price'] = "( TRUNCATE({$gs_price},{$mg['mb_grade_sale_cut']}) )"; // 버림
                }
            }
        }
        //$this->col['gs_rate'] = "((gs_consumer_price - gs_price_{$this->shopGrade}) / gs_consumer_price)";
        $this->col['gs_rate'] = "((gs_consumer_price - gs_price) / gs_consumer_price)";
        */
    }
    /*
    public function getSearch($request = array()){
        $this->sql = "";
        foreach($this->shopUseCtg as $ctg){
            if( !empty($this->sql) ) $this->sql .= " or ";
            $this->sql .= " ( gs_ctg like '{$ctg}%' or gs_ctg2 like '{$ctg}%' or gs_ctg3 like '{$ctg}%' ) ";
        }
        $this->sql = " and ({$this->sql}) ";
        $this->sql .= " and ( gs_only_pt_yn = 'n' or ( gs_only_pt_yn = 'y' and gs_only_pt_id = '{$this->shopId}' ) ) ";

        $this->search = array();
        $this->search['gs_stt'] = "2";
        $this->search['gs_sales_begin_dt_then_le'] = _DATE_YMDHIS;   
        $this->search['gs_sales_end_dt_then_ge'] = _DATE_YMDHIS;   
        if( !empty($this->userGrade) ){
           $this->search['gs_buy_use_grade_ge'] = $this->userGrade;
        }else{
            $this->search['gs_buy_use_grade'] = "10";
        }

        if( !empty($request['gs_ctg']) ){
            $this->sql .= " and ( gs_ctg like '{$request['gs_ctg']}%' or gs_ctg2 like '{$request['gs_ctg']}%' or gs_ctg3 like '{$request['gs_ctg']}%' ) ";
        }
        if( !empty($request['col']) ){
            $this->search['col'] = $request['col'];
            if( !empty($request['colby']) ){
                $this->search['colby'] = $request['colby'];
            }else{
                $this->search['colby'] = "desc";
            }
        }
        if( !empty($request['gs_id']) ) {
            $this->search['gs_id_in_'] = $request['gs_id'];
            $this->search['col'] = " field (gs_id, {$request['gs_id']}) "; 
        } 
        if( !empty($request['rpp']) ) $this->search['rpp'] = $request['rpp'];
        if( !empty($request['page']) ) $this->search['page'] = $request['page'];
        if( !empty($request['gs_delivery_type']) ) $this->search['gs_delivery_type'] = $request['gs_delivery_type'];
        if( !empty($request['sl_id']) ) $this->search['sl_id'] = $request['sl_id'];
        if( !empty($request['gs_price_le']) ) $this->search["gs_price_{$this->shopGrade}_then_le"] = $request['gs_price_le'];
        if( !empty($request['gs_price_ge']) ) $this->search["gs_price_{$this->shopGrade}_then_ge"] = $request['gs_price_ge'];
        if( !empty($request['keyword']) ){
            $keyword = explode(" ",$request['keyword']);
            foreach( $keyword as $k ){
                $this->sql .= "and ((gs_name like '%{$k}%') or (gs_brand like '%{$k}%') or (gs_keywords like '%{$k}%'))";
            }
        }
        if( !empty($request['type']) ){
            $gnbMenuModel = new \application\models\GnbMenuModel();
            $row = $gnbMenuModel->get("menu_{$request['type']}_goods_list as goods_list",array("pt_id"=>$this->shopId));
            if( empty($row) ){
                $row = $gnbMenuModel->get("menu_{$request['type']}_goods_list as goods_list",array("pt_id"=>"admin"));
            }
            if( !empty($row['goods_list']) ){
                $this->search['gs_id_in_'] = $row['goods_list'];
                $this->search['col'] = " field (gs_id, {$row['goods_list']}) "; 
            }
        }
        if( empty($this->search['col']) ) $this->search['col'] = "gs_update_dt";
    }
    */
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

        $col = get_column_as($this->goodsModel->col,array(),false);
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
 
        /*
        $this->getSearch($request);
        $this->search['gs_id'] = $this->param['ident'];
        $this->goodsModel->leftJoin("gs_id","web_goods_review","gs_id");
        $this->col['gs_review_avg_sum'] = "sum(gs_rv_star_average)";
        $this->col['gs_review_cnt'] = "count(gs_rv_star_average)";
        $this->col['gs_review_avg'] = "if(count(gs_rv_star_average)>0,sum(gs_rv_star_average)/count(gs_rv_star_average),0)";
        $this->goodsModel->sql_group = "group by gs_id";
        $col = get_column_as($this->col,array(),false);
        $row = $this->goodsModel->get($col,$this->search,false,$this->sql);
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
        */
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

}

