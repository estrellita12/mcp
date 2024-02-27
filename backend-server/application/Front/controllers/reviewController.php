<?php
namespace application\Front\controllers;

use \Exception;

class reviewController extends Controller{
    private $model;
    private $search;
    private $sql;

    public function init(){
        try{
            $this->model = new \application\models\GoodsReviewModel();
            $this->search = array();
            $this->sql = "";
            $this->col = array(
                "gs_rv_id"=>"gs_rv_id",
                "gs_id"=>"gs_id",
                "od_id"=>"od_id",
                "gs_rv_name"=>"gs_rv_name",
                "gs_rv_opt_name"=>"gs_rv_opt_name",
                "mb_id"=>"mb_id",
                "gs_rv_cnt"=>"ifnull(gs_rv_cnt,0)",
                "gs_rv_star_rating"=>"gs_rv_star_rating",
                "gs_rv_star_rating2"=>"gs_rv_star_rating2",
                "gs_rv_star_average"=>"gs_rv_star_average",
                "gs_rv_content"=>"gs_rv_content",
                "gs_rv_img"=>"ifnull(gs_rv_img,'')",
                "gs_rv_img2"=>"ifnull(gs_rv_img2,'')",
                "gs_rv_img3"=>"ifnull(gs_rv_img3,'')",
                "gs_rv_sl_id"=>"gs_rv_sl_id",
                "gs_rv_reg_dt"=>"gs_rv_reg_dt",
                "gs_rv_reply"=>"ifnull(gs_rv_reply,'')",
                "gs_rv_reply_dt"=>"gs_rv_reply_dt",
            );
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    private function getSearch($request=array()){
        try{
            $this->search = array();
            $this->search['gs_rv_hidden_yn'] = "n";

            if( !empty($request['gs_id']) ) $this->search['gs_id'] = $request['gs_id'];
            if( !empty($request['mb_id']) ) $this->search['mb_id'] = $request['mb_id'];
            if( !empty($request['gs_rv_img']) ) $this->search['gs_rv_img_then_ne'] = "";
            if( !empty($request['col']) ) $this->search['col'] = $request['col'];
            if( !empty($request['colby']) ) $this->search['colby'] = $request['colby'];

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function getList(){
        try{
            $request = array();
            if( !empty($this->request['get']) ) $request = $this->request['get'];
            if( empty($request['gs_id']) )  $this->result("002");

            $this->getSearch($request);
            $col = get_column_as($this->col,array(),false);
            $row = $this->model->get($col,$this->search,true);
            if( empty($row) )       $this->result("001");
            if( !is_array($row) )   $this->result($row);
            $this->response_json("000",array("list"=>$row));

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function get(){
        try{
            if( empty($this->param['ident']) )  $this->result("002");

            $this->getSearch($request);
            $this->search['gs_rv_id'] = $this->param['ident'];
            $col = get_column_as($this->col,array(),false);
            $row = $this->model->get($col,$this->search);
            if( empty($row) )       $this->result("001");
            if( !is_array($row) )   $this->result($row);
            $this->response_json("000",array("data"=>$row));

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function add(){
        try{
            $request = array();
            if( !empty($this->request['put']) ) $request = $this->request['put'];
            if( empty($request['gs_id']) ) $this->result("002");

            $value = array();
            $value['shop'] = $this->shopId;
            $value['goodsId'] = $request['gs_id'];
            if( !empty($request['od_id']) ) $value['odId'] = $request['od_id'];
            if( !empty($request['gs_rv_name']) ) $value['goodsName'] = $request['gs_rv_name'];
            if( !empty($request['gs_rv_opt_name']) ) $value['goodsOptName'] = $request['gs_rv_opt_name'];
            if( !empty($request['mb_id']) ) $value['userId'] = $request['mb_id'];
            if( !empty($request['gs_rv_star_rating']) ) $value['rating'] = $request['gs_rv_star_rating'];
            if( !empty($request['gs_rv_star_rating2']) ) $value['rating2'] = $request['gs_rv_star_rating2'];
            if( !empty($request['gs_rv_star_average']) ) $value['ratingAvg'] = $request['gs_rv_star_average'];
            if( !empty($request['gs_rv_img']) ) $value['reviewImg'] = $request['gs_rv_img'];
            if( !empty($request['gs_rv_img2']) ) $value['reviewImg2'] = $request['gs_rv_img2'];
            if( !empty($request['gs_rv_img3']) ) $value['reviewImg3'] = $request['gs_rv_img3'];
            if( !empty($request['gs_rv_content']) ) $value['content'] = $request['gs_rv_content'];
            if( !empty($request['gs_rv_like_cnt']) ) $value['likeCnt'] = $request['gs_rv_like_cnt'];
            if( !empty($request['gs_rv_sl_id']) ) $value['seller'] = $request['gs_rv_sl_id'];
            if( !empty($request['gs_rv_cnt']) ) $value['reviewCnt'] = $request['gs_rv_cnt'];
            $res = $this->model->add($value);
            $this->response_json($res,array("id"=>$this->model->pdo->lastInsertId()));
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function set(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");
            
            $row = $this->model->get("mb_id,gs_qa_passwd",array("gs_qa_id"=>$this->param['ident']));
            if( !empty($request['gs_qa_passwd']) ){
                if( $request['gs_qa_passwd'] != $row['gs_qa_passwd'] ) $this->result("004");
            }else{
                if( empty($this->userId) || $row['mb_id'] != $this->userId ) $this->result("004");
            }

            $value = array();
            if( !empty($request['gs_rv_star_rating']) ) $value['rating'] = $request['gs_rv_star_rating'];
            if( !empty($request['gs_rv_star_rating2']) ) $value['rating2'] = $request['gs_rv_star_rating2'];
            if( !empty($request['gs_rv_star_average']) ) $value['ratingAvg'] = $request['gs_rv_star_average'];
            if( !empty($request['gs_rv_img']) ) $value['reviewImg'] = $request['gs_rv_img'];
            if( !empty($request['gs_rv_img2']) ) $value['reviewImg2'] = $request['gs_rv_img2'];
            if( !empty($request['gs_rv_img3']) ) $value['reviewImg3'] = $request['gs_rv_img3'];
            if( !empty($request['gs_rv_content']) ) $value['content'] = $request['gs_rv_content'];
            $res = $this->model->set($value,$this->param['ident']);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function remove(){
        try{
            if( empty($this->param['ident']) ) $this->result("002");
            if( empty($this->userId) )  $this->result("004");
            $row = $this->model->get("mb_id",array("gs_rv_id"=>$this->param['ident']));
            if( $row['mb_id'] != $this->userId ) $this->result("004");
            
            $res = $this->model->remove($this->param['ident']);
            $this->response_json($res);

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

}
