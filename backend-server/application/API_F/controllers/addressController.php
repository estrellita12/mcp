<?php
namespace application\API_F\controllers;

class addressController extends Controller 
{
    function init(){ 
        $this->memberAddress = new \application\models\MemberAddressModel();
        $this->col = "*";
    }

    function get(){
        /*
        $id = $this->param['ident'];
        echo json_encode($this->member->get($id));
        */
    }

    function getList(){
        $id = $this->accessInfo['index'];
        $_REQUEST['memberId'] = $id;
        echo json_encode($this->memberAddress->getList($this->memberAddress->getCol()));
        /*
        echo json_encode($this->member->getList());
        */
    }

    function set(){
        /*
        $token = $this->accessInfo;
        $info = $this->putData;
        echo json_encode($this->member->set($info['params'], $token['index']));
        */
    }    

    function add(){
        $arr = $this->postData['params'];
        if(empty($arr) || count($arr) == 0){
            echo json_encode('empty data');
            exit;
        }
        echo json_encode($this->memberAddress->add($arr));
    }    
    
    function remove(){
        $id = $this->param['ident'];
        echo json_encode($this->memberAddress->remove($id));
    }    
}
