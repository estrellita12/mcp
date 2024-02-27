<?php
namespace application\API_F\controllers;

class selfController extends Controller 
{
    var $member;
    var $col;
    var $tokenInfo;

    function init(){ 
        $this->member = new \application\models\MemberModel();
        $this->col = "*";
        if(empty($this->accessInfo)) {
            echo json_encode(null);
            exit;
        }
    }

    function get(){
        $id = $this->accessInfo['index'];
        echo json_encode($this->member->get( $this->member->getCol(), array("mb_id"=>$id) ));
    }

    function set(){
        $token = $this->accessInfo;
        $info = $this->putData;
        echo json_encode($this->member->set($info['params'], $token['index']));
    }    
}
