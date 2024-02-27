<?php
namespace application\Front\controllers;

use \Exception;

class cartController extends Controller{
    private $col;
    private $sql;
    private $search;

    public function init(){
        $this->model = new \application\models\CartModel();
        $this->cartModel = new \application\models\CartModel();

        $this->col = array(
            "cart_id"=>"cart_id",
            "mb_id"=>"mb_id",
            "cart_direct"=>"cart_direct",
            "cart_od_no"=>"cart_od_no",
            "gs_opt_id"=>"gs_opt_id",
            "cart_qty"=>"cart_qty",
            "gs_id"=>"gs_id",
            "gs_name"=>"gs_name",
            "gs_code"=>"gs_code",
            "gs_ctg"=>"gs_ctg",
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
            "gs_svideo_url"=>"gs_svideo_url",
            "gs_opt_subject"=>"gs_opt_subject",
            "gs_add_opt_subject"=>"gs_add_opt_subject",
            "gs_order_qty"=>"gs_order_qty",
            "gs_view_cnt"=>"gs_view_cnt",
            "gs_order_max_qty"=>"gs_order_max_qty",
            "gs_order_min_qty"=>"gs_order_min_qty",
            "gs_opt_name"=>"gs_opt_name",
            "gs_opt_add_price"=>"gs_opt_add_price",
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
    }

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
        if( !empty($_SESSION['user_grade']) )   $this->search['gs_buy_use_grade_ge'] = $_SESSION['user_grade'];
        else  $this->search['gs_buy_use_grade'] = "10";

        if( !empty($this->userId) )         $this->search['mb_id'] = $this->userId;
        if( !empty($request['cart_direct']) )    $this->search['cart_direct'] = $request['cart_direct'];
    }

    public function getList(){
        if( empty($this->request['get']) ) 
            $this->request['get'] = array();
        $request = $this->request['get'];
        if( !empty($_COOKIE['cart_direct']) ) $request['cart_direct'] = $_COOKIE['cart_direct'];
        if( empty($this->userId) && empty($request['cart_direct']) ) $this->result("002");

        $this->cartModel->goodsLeftJoin();
        $this->getSearch($request);
        $col = get_column_as($this->col,array(),false);
        $row = $this->cartModel->get($col,$this->search,true,$this->sql);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function add(){
        $request = array();
        if( !empty($this->request['put']) ) $request = $this->request['put'];

        if( !empty($_COOKIE['cart_direct']) ) $request['cart_direct'] = $_COOKIE['cart_direct'];

        if( empty($this->userId) && empty($request['cart_direct']) ) $this->result("002");
        if( empty($request['gs_id']) )  $this->result("002");
        if( empty($request['gs_opt_id']) )  $this->result("002");
        if( empty($request['cart_qty']) )  $this->result("002");

        $value = array();
        if( !empty($this->userId) ) $value['userId'] = $this->userId;
        if( !empty($request['cart_direct']) ) $value['direct'] = $request['cart_direct'];
        $value['goodsId'] = $request['gs_id'];
        $value['optionId'] = $request['gs_opt_id'];
        $value['qty'] = $request['cart_qty'];

        $cnt = $this->cartModel->get("count(cart_id) as cnt,cart_id", array("gs_id"=>$request['gs_id'],"gs_opt_id"=>$request['gs_opt_id']));

        if($cnt['cnt'] > 0) $res = $this->cartModel->set($value,$cnt['cart_id']);
        else $res = $this->cartModel->add($value);

        $this->response_json($res);
    }

    public function set(){
        $request = array();       
        if( !empty($this->request['post']) ) $request = $this->request['post'];

        $value = array();
        if( !empty($this->userId) ) $value['userId'] = $this->userId;
        if( !empty($request['cart_direct']) ) $value['direct'] = $request['cart_direct'];
        if( empty( $value['userId'] ) && empty($value['direct']) ) $this->result("002");
        if( !empty($request['gs_id']) )  $value['goodsId'] = $request['gs_id'];
        if( !empty($request['gs_opt_id']) )  $value['optionId'] = $request['gs_opt_id'];
        if( !empty($request['cart_qty']) ) $value['qty'] = $request['cart_qty'];
        
        $res = $this->cartModel->set($value,$this->param['ident']);
        $this->response_json($res);
    }

    public function remove(){
        $request = array();
        if( !empty($this->request['delete']) ) $request = $this->request['post'];
        if( empty($this->param['ident']) ) $this->result("002");
        $row = $this->cartModel->get("mb_id,cart_direct", array("cart_id"=>$this->param['ident']));
        if( !empty($row['mb_id']) && $row['mb_id'] != $this->userId ) $this->result("002");
        if( !empty($_COOKIE['cart_direct']) ) $request['cart_direct'] = $_COOKIE['cart_direct'];
        if( !empty($request['cart_direct']) && $row['cart_direct'] != $request['cart_direct'] ) $this->result("002");
        $res = $this->cartModel->remove($this->param['ident']);
        $this->response_json($res);
    }

}
