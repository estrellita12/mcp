<?php
namespace application\Front\controllers;

use \Exception;

class orderController extends Controller{
    public $col;
    public $search;
    public $sql;

    public function init(){}

    public function getList(){
        try{
            $this->orderModel = new \application\Front\models\OrderModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
            $request = array();
            if( !empty($this->request['get']) ) $request = $this->request['get'];
            if( !empty($this->userId) ) $request['mb_id'] = $this->userId; 
            else unset($request['mb_id']);

            $col = get_column_as($this->orderModel->col,array(),false);
            $row = $this->orderModel->get($col,$request,true);
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);

            $this->response_json("000",array("list"=>$row));

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function get(){
        try{
            $this->orderModel = new \application\Front\models\OrderModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
            $request = array();
            if( !empty($this->request['get']) ) $request = $this->request['get'];
            if( empty($this->param['ident']) ) $this->result("002");
            $request['od_id'] = $this->param['ident'];
            if( !empty($this->userId) ) $request['mb_id'] = $this->userId; 
            else unset($request['mb_id']);

            $col = get_column_as($this->orderModel->col,array(),false);
            $row = $this->orderModel->get($col,$request);
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);

            $this->response_json("000",array("data"=>$row));

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function set(){
        try{
            $this->orderModel = new \application\models\OrderModel();
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($request['od_stt']) ) $this->result("002");
            if( empty($this->param['ident']) ) $this->result("002");
            
            $od_stt = 42;
            switch($request['od_stt']){
                case "complete":$od_stt = "14";break;
                case "change":$od_stt = "21";break;
                case "return":$od_stt = "31";break;
                case "cancel1":$od_stt = "41";break;
                case "cancel2":$od_stt = "42";break;
                default:$this->result("002");
            }

            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( !in_array($od_stt, $GLOBALS['od_stt'][$row['od_stt']]['next']) ){
                $this->result("115",array("this"=>$od_stt,"arr"=>$GLOBALS['od_stt'][$od_stt]['next']));
            }

            $arr = array();
            if( !empty($request['od_change_opt_id']) ) $arr['changeOptId'] = $request['od_change_opt_id'];
            if( !empty($request['od_change_msg']) ) $arr['changeMessage'] = $request['od_change_msg'];
            if( !empty($request['od_cancel_reason']) ) $arr['cancelReason'] = $request['od_cancel_reason'];
            if( !empty($request['od_return_reason']) ) $arr['returnReason'] = $request['od_return_reason'];
            $res = $this->orderModel->changeState($od_stt,$this->param['ident'],$arr);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function confirm(){
        try{
            $this->orderModel = new \application\models\OrderModel();
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");

            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( $row['od_stt'] != "14" )  $this->result("115");

            $value = array();
            $od_confirm_yn = "y";
            if( !empty($request['confirm']) ) $od_confirm_yn = $request['od_confirm_yn'];
            $value['confirm'] = $od_confirm_yn;
            $res = $this->orderModel->set($value,$this->param['ident']);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function complete(){
        try{
            $this->orderModel = new \application\models\OrderModel();
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");
            $od_stt = "14";
            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( !in_array($od_stt, $GLOBALS['od_stt'][$od_stt]['next']) ){
                $this->result("115");
            }
            $arr = array();
            $res = $this->orderModel->changeState($od_stt,$this->param['ident'],$arr);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

/*
    public function changeRequest(){
        try{
            $this->orderModel = new \application\models\OrderModel();
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");
            $od_stt = "21";
            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( !in_array($od_stt, $GLOBALS['od_stt'][$od_stt]['next']) ){
                $this->result("115");
            }
            $arr = array();
            if( !empty($request['od_change_opt_id']) ) $arr['changeOptId'] = $request['od_change_opt_id'];
            if( !empty($request['od_change_msg']) ) $arr['changeMessage'] = $request['od_change_msg'];
            $res = $orderModel->changeState("21",$this->param['ident'],$arr);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function returnRequest(){
        try{
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");
            $od_stt = "31";
            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( !in_array($od_stt, $GLOBALS['od_stt'][$od_stt]['next']) ){
                $this->result("115");
            }
            $arr = array();
            if( !empty($request['od_return_reason']) ) $arr['returnReason'] = $request['od_return_reason'];
            $res = $orderModel->changeState($od_stt,$this->param['ident'],$arr);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function cancelRequest(){
        try{
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");

            $od_stt = "41";
            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( !in_array($od_stt, $GLOBALS['od_stt'][$od_stt]['next']) ){
                $this->result("115");
            }
            $arr = array();
            if( !empty($request['od_cancel_reason']) ) $arr['cancelReason'] = $request['od_cancel_reason'];
            $res = $this->orderModel->changeState($od_stt,$this->param['ident'],$arr);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }
*/
    public function cancel(){
        try{
            $this->orderModel = new \application\models\OrderModel();
            $reqeust = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($this->param['ident']) ) $this->result("002");

            $od_stt = "42";
            $row = $this->orderModel->get("od_stt",array("od_id"=>$this->param['ident']));
            if( !in_array($od_stt, $GLOBALS['od_stt'][$od_stt]['next']) ){
                $this->result("115");
            }
            $arr = array();
            if( !empty($request['od_cancel_reason']) ) $arr['cancelReason'] = $request['od_cancel_reason'];
            $res = $this->orderModel->changeState($od_stt,$this->param['ident'],$arr);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }
}
