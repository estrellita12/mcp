<?php
namespace application\Front\models;

use \Exception;

class GoodsModel extends \application\models\GoodsModel{
    public $col;
    public $sql;
    public $search;
    public $shopId;
    public function __construct( $shopId, $shopGrade="", $shopUseCtg="", $userGrade="" ){
        parent::__construct ();
        $this->shopId = $shopId;
        $this->shopGrade = $shopGrade;
        $this->shopUseCtg = $shopUseCtg;
        $this->userGrade = $userGrade;
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

        $this->col['gs_price'] = "gs_price_{$shopGrade}";
        if( !empty($userGrade) ){
            $memberGradeModel = new \application\models\MemberGradeModel();
            $mg = $memberGradeModel->get("mb_grade_price_sale, mb_grade_sale_unit,mb_grade_sale_cut",array("mb_grade_id"=>$userGrade));
            if( !empty($mg['mb_grade_price_sale']) ){
                if( $mg['mb_grade_sale_unit'] == "1" ){
                    $gs_price = "( gs_price_{$shopGrade} * ( (100 - {$mg['mb_grade_price_sale']})/100 ) )  ";
                    $this->col['gs_price'] = "( TRUNCATE({$gs_price},{$mg['mb_grade_sale_cut']}) )"; // 버림
                }else{
                    $gs_price = "( gs_price_{$shopGrade} - {$mg['mb_grade_price_sale']} ) ";
                    $this->col['gs_price'] = "( TRUNCATE({$gs_price},{$mg['mb_grade_sale_cut']}) )"; // 버림
                }
            }
        }
        $this->col['gs_rate'] = "((gs_consumer_price - gs_price) / gs_consumer_price)";


        $this->sql = "";
        $this->search = array();
        foreach($this->shopUseCtg as $ctg){
            if( !empty($this->sql) ) $this->sql .= " or ";
            $this->sql .= " ( gs_ctg like '{$ctg}%' or gs_ctg2 like '{$ctg}%' or gs_ctg3 like '{$ctg}%' ) ";
        }
        $this->sql = " and ({$this->sql}) ";
        $this->sql .= " and ( gs_only_pt_yn = 'n' or ( gs_only_pt_yn = 'y' and gs_only_pt_id = '{$this->shopId}' ) ) ";

        $this->search['col'] = "gs_update_dt";
        $this->search['gs_stt'] = "2";
        $this->search['gs_sales_begin_dt_then_le'] = _DATE_YMDHIS;   
        $this->search['gs_sales_end_dt_then_ge'] = _DATE_YMDHIS;   
        $this->search['gs_buy_use_grade'] = "10";
        if( !empty($this->userGrade) ) $this->search['gs_buy_use_grade_ge'] = $this->userGrade;
    }


    public function get( $col="*", $request, $fetchAll=false, $sql_where="",$parameter=array()){
        $sql = $this->sql;
        $search = $this->search;

        if( !empty($request['rpp']) ) $search['rpp'] = $request['rpp'];
        if( !empty($request['page']) ) $search['page'] = $request['page'];

        if( !empty($request['gs_ctg']) ){
            $sql .= " and ( gs_ctg like '{$request['gs_ctg']}%' or gs_ctg2 like '{$request['gs_ctg']}%' or gs_ctg3 like '{$request['gs_ctg']}%' ) ";
        }
        if( !empty($request['gs_id']) ) {
            if( strpos($request['gs_id'],",") !== false ){
                $search['gs_id_in_'] = get_list($request['gs_id']);
                $search['col'] = " field (gs_id, {$request['gs_id']}) "; 
            }else{
                $search['gs_id'] = $request['gs_id'];
            }
        } 
        if( !empty($request['gs_delivery_type']) ) $search['gs_delivery_type'] = $request['gs_delivery_type'];
        if( !empty($request['sl_id']) ) $search['sl_id'] = $request['sl_id'];
        if( !empty($request['gs_price_le']) ) $search["gs_price_{$this->shopGrade}_then_le"] = $request['gs_price_le'];
        if( !empty($request['gs_price_ge']) ) $search["gs_price_{$this->shopGrade}_then_ge"] = $request['gs_price_ge'];
        if( !empty($request['keyword']) ){
            $keyword = explode(" ",$request['keyword']);
            foreach( $keyword as $k ){
                $sql .= "and ((gs_name like '%{$k}%') or (gs_brand like '%{$k}%') or (gs_keywords like '%{$k}%'))";
            }
        }
        if( !empty($request['col']) ){
            $search['col'] = $request['col'];
            if( !empty($request['colby']) ){
                $search['colby'] = $request['colby'];
            }else{
                $search['colby'] = "desc";
            }
        }
        return parent::get($col, $search, $fetchAll, $sql, $parameter);
    }
}
