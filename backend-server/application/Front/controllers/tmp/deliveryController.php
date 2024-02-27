<?php
namespace application\API\controllers;

use \Exception;

class deliveryController extends Controller{

    function init(){
        $this->tokenCheck();
        $this->config = new \application\models\ConfigModel();
    }

    function getList(){
        $res = "000";
        $row = $this->config->get($this->config->getCol());
        if( !is_array($row) ) $this->result($row);
        $arr = array("result"=>$res,"data"=>$row['delivery']);
        echo json_encode($arr);
    }
}

