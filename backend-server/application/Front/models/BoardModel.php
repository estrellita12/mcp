<?php
namespace application\Front\models;

use \Exception;

class BoardModel extends \application\models\BoardModel{
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
            "bo_id"=>"bo_id",
            "bogr_id"=>"bogr_id",
            "bo_name"=>"bo_name",
            "bo_skin"=>"bo_skin",
            "bo_list_perm"=>"bo_list_perm",
            "bo_read_perm"=>"bo_read_perm",
            "bo_write_perm"=>"bo_write_perm",
            "bo_reply_perm"=>"bo_reply_perm",
            "bo_comment_perm"=>"bo_comment_perm",
            "bo_use_secret"=>"bo_use_secret",
            "bo_use_upload"=>"bo_use_upload",
            "bo_use_reply"=>"bo_use_reply",
            "bo_use_commnet"=>"bo_use_comment",
            "bo_t_file"=>"ifnull(bo_t_file,'')",
            "bo_d_file"=>"ifnull(bo_d_file,'')",
            "bo_t_img"=>"ifnull(bo_t_img,'')",
            "bo_d_img"=>"ifnull(bo_d_img,'')",
            "bo_t_content"=>"ifnull(bo_t_content,'')",
            "bo_d_content"=>"ifnull(bo_d_content,'')",
            "bo_default_text"=>"ifnull(bo_default_text,'')",
        );
 
        $this->sql = "";
        $this->search = array();
        $this->search['bogr_id'] = "mall_service_center";
    }


    public function get( $col="*", $request, $fetchAll=false, $sql_where="",$parameter=array()){
        $sql = $this->sql;
        $search = $this->search;
        if( !empty($request['rpp']) ) $search['rpp'] = $request['rpp'];
        if( !empty($request['page']) ) $search['page'] = $request['page'];

        if( !empty($request['bogr_id']) ) $search['bogr_id'] = $request['bogr_id'];

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
