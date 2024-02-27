<?php
namespace application\Front\models;

use \Exception;

class PostModel extends \application\models\PostModel{
    public $col;
    public $sql;
    public $search;
    public $shopId;
    public function __construct( $boid, $shopId, $shopGrade="", $shopUseCtg="", $userGrade="" ){
        parent::__construct ($boid);
        $this->shopId = $shopId;
        $this->shopGrade = $shopGrade;
        $this->shopUseCtg = $shopUseCtg;
        $this->userGrade = $userGrade;
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

        $this->sql = "";
        $this->search = array();
        $this->search['bopo_id_then_ne'] = 0;
    }


    public function get( $col="*", $request, $fetchAll=false, $sql_where="",$parameter=array()){
        $sql = $this->sql;
        $search = $this->search;

        if( !empty($request['rpp']) ) $search['rpp'] = $request['rpp'];
        if( !empty($request['page']) ) $search['page'] = $request['page'];
        if( !empty($request['bopo_title']) ) $search['bopo_title_like_all'] = $request['bopo_title'];
        if( !empty($request['bopo_id']) ) $search['bopo_id'] = $request['bopo_id'];
        if( !empty($request['bopo_pid']) ) $search['bopo_pid'] = $request['bopo_pid'];
        if( !empty($request['bopo_depth']) ) $search['bopo_depth'] = $request['bopo_depth'];
        else $search['bopo_depth'] = "0";

        if( $search['bopo_depth'] == "0" ){
            if( !empty($request['mb_id']) ){
                $this->sql = " and ( bopo_secret_yn == 'n' or  ( bopo_secret_yn == 'y' and user_id='{$request['mb_id']}' ) )";
            }else{
                $this->sql = " and bopo_secret_yn == 'n' ";
            }

            if( !empty($request['user_id']) ){
                $this->sql = " and user_id='{$request['user_id']}' ) )";
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
