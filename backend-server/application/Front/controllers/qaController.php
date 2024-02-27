<?php
namespace application\Front\controllers;

use \Exception;

class qaController extends Controller{
    private $model;
    private $search;
    private $sql;

    public function init(){
        try{
            $this->model = new \application\models\GoodsQaModel();
            $this->col = array(
                "gs_qa_id"=>"gs_qa_id",
                "gs_id"=>"gs_id",
                "gs_qa_sl_id"=>"gs_qa_sl_id",
                "mb_id"=>"mb_id",
                "gs_qa_writer_email"=>"ifnull(gs_qa_writer_email,'')",
                "gs_qa_email_notice_yn"=>"gs_qa_email_notice_yn",
                "gs_qa_writer_cellphone"=>"ifnull(gs_qa_writer_cellphone,'')",
                "gs_qa_cellphone_notice_yn"=>"gs_qa_cellphone_notice_yn",
                "gs_qa_type"=>"gs_qa_type",
                "gs_qa_title"=>"gs_qa_title",
                "gs_qa_content"=>"gs_qa_content",
                "gs_qa_secret_yn"=>"gs_qa_secret_yn",
                "gs_qa_passwd"=>"ifnull(gs_qa_passwd,'')",
                "gs_qa_reg_dt"=>"gs_qa_reg_dt",
                "gs_qa_answer"=>"ifnull(gs_qa_answer,'')",
                "gs_qa_answer_yn"=>"ifnull(gs_qa_answer_yn,'n')",
                "gs_qa_answer_dt"=>"gs_qa_answer_dt",
            );
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    private function getSearch($request=array()){
        try{
            $this->sql = "";
            $this->search = array();
            $this->search['gs_qa_hidden_yn'] = "n";
            /*
            if( empty($this->userId) ){
                $this->search['gs_qa_secret_yn'] = "n";
            }else{
                $this->sql = " and ( gs_qa_secret_yn = 'n' or (gs_qa_secret_yn = 'y' and mb_id='{$this->userId}') )  ";
            }
            */
            if( !empty($request['gs_id']) ) $this->search['gs_id'] = $request['gs_id'];
            if( !empty($request['mb_id']) ) $this->search['mb_id'] = $request['mb_id'];
            if( !empty($request['gs_qa_dt_beg']) ) $this->search['gs_qa_reg_dt_then_ge'] = $request['gs_qa_dt_beg']." 00:00:00";
            if( !empty($request['gs_qa_dt_end']) ) $this->search['gs_qa_reg_dt_then_le'] = $request['gs_qa_dt_end']." 23:59:59";
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
            $this->getSearch($request);

            $col = get_column_as($this->col,array(),false);
            $row = $this->model->get($col,$this->search,true,$this->sql);
            if( empty($row) )  $this->result("001");
            if( !is_array($row) )  $this->result($row);
            $this->response_json("000",array("list"=>$row));
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function get(){
        try{
            if( empty($this->param['ident']) )  $this->result("002");

            $this->getSearch();
            $this->search['gs_qa_id'] = $this->param['ident'];

            $col = get_column_as($this->col,array(),false,$this->sql);
            $row = $this->model->get($col,$this->search);
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);
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
            //if( !empty($this->userId) ) $value['userId'] = $this->userId;
            //else $value['userId'] = "nonMember";
            if( !empty($this->userId) ) $value['userId'] = $this->userId;
            if( !empty($request['mb_id']) ) $value['userId'] = $request['mb_id'];
            if( !empty($request['gs_qa_sl_id']) ) $value['seller'] = $request['gs_qa_sl_id'];
            if( !empty($request['gs_qa_title']) ) $value['title'] = $request['gs_qa_title'];
            if( !empty($request['gs_qa_type']) ) $value['type'] = $request['gs_qa_type'];
            if( !empty($request['gs_qa_writer_email']) ) $value['writerEmail'] = $request['gs_qa_writer_email'];
            if( !empty($request['gs_qa_email_notice_yn']) ) $value['emailNoticeYn'] = $request['gs_qa_email_notice_yn'];
            if( !empty($request['gs_qa_writer_cellphone']) ) $value['writerCellphone'] = $request['gs_qa_writer_cellphone'];
            if( !empty($request['gs_qa_cellphone_notice_yn']) ) $value['cellphoneNoticeYn'] = $request['gs_qa_cellphone_notice_yn'];
            if( !empty($request['gs_qa_content']) ) $value['content'] = $request['gs_qa_content'];
            if( !empty($request['gs_qa_secret_yn']) ) $value['secret'] = $request['gs_qa_secret_yn'];
            if( !empty($request['gs_qa_passwd']) ) $value['passwd'] = $request['gs_qa_passwd'];
            $res = $this->model->add($value);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function set(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");
            
            $search = array();
            $search['gs_qa_id'] = $this->param['ident'];
            if( !empty($request['gs_qa_passwd']) ){
                $search['gs_qa_passwd'] = $request['gs_qa_passwd'];
                $required = true;
            }
            if( !empty($this->userId) ){
                $search['mb_id'] = $this->userId;
                $required = true;
            }
            if( !$required ) $this->result("004");

            $row = $this->model->get("mb_id,gs_qa_passwd",$search);
            if( empty($row) ) $this->response_json("001");
            if( !is_array($row) ) $this->response_json("001");

            $value = array();
            if( !empty($request['gs_qa_title']) ) $value['title'] = $request['gs_qa_title'];
            if( !empty($request['gs_qa_type']) ) $value['type'] = $request['gs_qa_type'];
            if( !empty($request['gs_qa_writer_email']) ) $value['writerEmail'] = $request['gs_qa_writer_email'];
            if( !empty($request['gs_qa_email_notice_yn']) ) $value['emailNoticeYn'] = $request['gs_qa_email_notice_yn'];
            if( !empty($request['gs_qa_writer_cellphone']) ) $value['writerCellphone'] = $request['gs_qa_writer_cellphone'];
            if( !empty($request['gs_qa_cellphone_notice_yn']) ) $value['cellphoneNoticeYn'] = $request['gs_qa_cellphone_notice_yn'];
            if( !empty($request['gs_qa_content']) ) $value['content'] = $request['gs_qa_content'];
            if( !empty($request['gs_qa_secret_yn']) ) $value['secret'] = $request['gs_qa_secret_yn'];
            $res = $this->model->set($value,$this->param['ident']);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }


    public function remove(){
        try{
            if( empty($this->param['ident']) ) $this->result("002");
            $required = false;   
            $search = array();
            $search['gs_qa_id'] = $this->param['ident'];
            if( !empty($request['gs_qa_passwd']) ){
                $search['gs_qa_passwd'] = $request['gs_qa_passwd'];
                $required = true;
            }
            if( !empty($this->userId) ){
                $search['mb_id'] = $this->userId;
                $required = true;
            }
            if( !$required ) $this->result("004");

            $row = $this->model->get("mb_id,gs_qa_passwd",$search);
            $res = $this->model->remove($this->param['ident']);
            $this->response_json($res);

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }
}
