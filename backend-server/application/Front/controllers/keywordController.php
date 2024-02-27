<?php
namespace application\Front\controllers;

class keywordController extends Controller{
    public function init(){
        $this->keywordModel = new \application\models\KeywordModel();
    }
    
    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        $search = array();
        $search['keyword_cnt_then_ge'] = 0;
        $search['col'] = "keyword_cnt";
        $search['colby'] = "desc";
        $search['rpp'] = 10;
        if( !empty($request['keyword_update_date']) ) $search['keyword_update_dt_then_ge'] = $request['keyword_update_date']." 00:00:00";
        if( !empty($request['keyword_relation']) ) $search['keyword_title_like_all'] = $request['keyword_relation'];
        $row = $this->keywordModel->get("keyword_title,keyword_cnt",$search,true);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function add(){
        $request = array();
        if( !empty($this->request['put']) ) $request = $this->request['put'];
        if( empty($request['keyword_title']) ) $this->result("002");
        $res = $this->keywordModel->search($request['keyword_title']);

        if( !empty($request['keyword_relation_pre']) ){
            $kwRelationModel = new \application\models\KeywordRelationModel();
            $value = array();
            $value['pre'] = $request['keyword_relation_pre'];
            $value['next'] = $request['keyword_title']; 
            $kwRelationModel->add($value);
        }
        $this->response_json($res);
    }
    
    public function relation(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        if( empty($request['keyword_title']) ) $this->result("002");

        $kwRelationModel = new \application\models\KeywordRelationModel();
        $row = $kwRelationModel->search("keyword_title",$request['keyword_title']);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }
}
