<?php
namespace application\Front\controllers;

class boardController extends Controller{
    private $model;
    private $search;
    private $sql;

    public function init(){}

    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $boardModel = new \application\Front\models\BoardModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
        $col = get_column_as($boardModel->col,array(),false);
        $row = $boardModel->get($col,$request,true);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function get(){
        if( empty($this->param['ident']) ) $this->result("002");

        $request = array();
        $request['bo_id'] = $this->param['ident'];

        $boardModel = new \application\Front\models\BoardModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
        if( !empty($this->request['get']) ) $request = $this->request['get'];
    
        $col = get_column_as($boardModel->col,array(),false);
        $row = $boardModel->get($col,$request,false);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("data"=>$row));
    }

    public function post(){
        $postModel = new \application\Front\models\PostModel($this->param['ident'],$this->shopId,$this->shopGrade,$this->shopUseCtg);
        switch($_SERVER['REQUEST_METHOD']){
        case "POST":
        case "post":
            $this->postSet($postModel);
            break;
        case "PUT":case "put":
            $this->postAdd($postModel);
            break;
        case "DELETE": case "delete":
            $this->postRemove($postModel);
            break;
        default:
            if( !empty($this->param['subident']) ) $this->postGet($postModel);
            else $this->postGetList($postModel);
        }
    }

    public function postGetList($postModel){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $exclude = array("bopo_content");
        if( !empty($request['has_content']) && $request['has_content']=="y" ) $exclude = array();
        $col = get_column_as($postModel->col,$exclude,false);
        $row = $postModel->get($col,$request,true);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function postGet($postModel){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $postModel->view($this->param['subident']);
        $request['bopo_id'] = $this->param['subident'];
        $col = get_column_as($postModel->col,array(),false);
        $row = $postModel->get($col,$request,false);
        if( empty($row) )  $this->result("001");
        if( !is_array($row) )  $this->result($row);
        $this->response_json("000",array("data"=>$row));
    }

    public function postSet($postModel){
        $request = array();
        if( !empty($this->request['post']) ) $request = $this->request['post'];

        $value = array();
        if( !empty($request['bopo_pid']) ) $value['pid'] = $request['bopo_pid'];
        if( !empty($request['bopo_depth']) ) $value['depth'] = $request['bopo_depth'];
        if( !empty($request['bopo_title']) ) $value['title'] = $request['bopo_title'];
        if( !empty($request['bopo_content']) ) $value['content'] = $request['bopo_content'];
        if( !empty($request['bopo_secret_yn']) ) $value['secretYn'] = $request['bopo_secret_yn'];
        if( !empty($request['user_id']) ) $value['userId'] = $request['user_id'];
        if( !empty($request['user_name']) ) $value['userName'] = $request['user_name'];
        //if( !empty($request['bopo_main_display']) ) $value['display'] = $request['bopo_main_display'];
        if( !empty($request['bopo_file1']) ) $value['file1'] = $request['bopo_file1'];
        if( !empty($request['bopo_file2']) ) $value['file2'] = $request['bopo_file2'];
        $res = $postModel->set($value, $this->param['subident']);
        $this->response_json($res);
    }

    public function postAdd($postModel){
        $request = array();
        if( !empty($this->request['put']) ) $request = $this->request['put'];

        $value = array();
        if( !empty($request['bopo_pid']) ) $value['pid'] = $request['bopo_pid'];
        if( !empty($request['bopo_depth']) ) $value['depth'] = $request['bopo_depth'];
        if( !empty($request['bopo_title']) ) $value['title'] = $request['bopo_title'];
        if( !empty($request['bopo_content']) ) $value['content'] = $request['bopo_content'];
        if( !empty($request['bopo_secret_yn']) ) $value['secretYn'] = $request['bopo_secret_yn'];
        if( !empty($request['user_id']) ) $value['userId'] = $request['user_id'];
        if( !empty($request['user_name']) ) $value['userName'] = $request['user_name'];
        //if( !empty($request['bopo_main_display']) ) $value['display'] = $request['bopo_main_display'];
        if( !empty($request['bopo_file1']) ) $value['file1'] = $request['bopo_file1'];
        if( !empty($request['bopo_file2']) ) $value['file2'] = $request['bopo_file2'];
        $res = $postModel->add($value);
        $this->response_json($res);
    }

    public function postRemove($postModel){
        $request = array();
        if( !empty($this->request['delete']) ) $request = $this->request['delete'];
        $res = $postModel->remove($this->param['subident']);
        $this->response_json($res);
    }




}
?>
