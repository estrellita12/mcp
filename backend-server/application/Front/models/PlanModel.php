<?php
namespace application\Front\models;

use \Exception;

class PlanModel extends \application\models\PlanModel{
    public $col;
    public $sql;
    public $search;
    public $shopId;

    public function __construct( $shopId="", $shopGrade="", $shopUseCtg="", $userGrade="" ){
        parent::__construct ();
        $this->shopId = $shopId;
        $this->shopGrade = $shopGrade;
        $this->shopUseCtg = $shopUseCtg;
        $this->userGrade = $userGrade;
        $this->col = array(
            "plan_id"=>"plan_id",
            "ctg_id"=>"ctg_id",
            "plan_title"=>"plan_title",
            "plan_goods_list"=>"plan_goods_list",
            "plan_content"=>"plan_content",
            "plan_list_img"=>"if( plan_list_img != '', concat('"._PLAN."','/',plan_list_img), '')",
            "plan_top_img"=>"if( plan_top_img != '', concat('"._PLAN."','/',plan_top_img), '')",
            "plan_begin_dt"=>"plan_begin_dt",
            "plan_end_dt"=>"plan_end_dt",
        );

        $this->sql = "";
        $this->search = array();
        $this->search = array();
        $this->search['ctg_id_in_'] = implode(",",$this->shopUseCtg);
        $this->search['pt_id_in_'] = "admin,".$this->shopId;
        $this->search['plan_show_yn'] = "y";
        //$this->search['plan_begin_dt_then_le'] = _DATE_YMDHIS;
        //$this->search['plan_end_dt_then_ge'] = _DATE_YMDHIS;
        $this->search['col'] = "plan_orderby";
    }


    public function get( $col="*", $request, $fetchAll=false, $sql_where="",$parameter=array()){
        $sql = $this->sql;
        $search = $this->search;
        if( !empty($request['plan_id']) ) $search['plan_id'] = $request['plan_id'];
        if( !empty($request['rpp']) ) $search['rpp'] = $request['rpp'];
        if( !empty($request['page']) ) $search['page'] = $request['page'];
        if( !empty($request['plan_begin_date']) ) $search['plan_begin_dt_then_ge'] = $request['plan_begin_date']." 00:00:00";
        if( !empty($request['plan_end_date']) ) $search['plan_end_dt_then_le'] = $request['plan_end_date']." 23:59:59";
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
