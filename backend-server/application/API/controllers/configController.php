<?php
namespace application\API\controllers;

class configController extends Controller{
    function init(){    
        $this->tokenCheck();
        $this->partner = new \application\models\PartnerModel();
        $this->default = new \application\models\DefaultModel();
        $this->config = new \application\models\ConfigModel();
    }

    function get(){
        $res = "000";
        $row = $this->partner->get($this->partner->getCol(), array("pt_id"=>$this->shopId));
        if( empty($row) ) $this->result("001");

        $def = $this->default->get($this->default->getCol(),array("pt_id"=>"admin"));
        foreach($row as $key=>$value){
            if(empty($value)) $row[$key] = $def[$key];
        }

        $config = $this->config->get($this->config->getCol(),array("cf_id"=>1));
        $row['useCtg'] = unserialize($row['useCtg']);
        $row['useCtg'] = json_encode($row['useCtg']);
        $row['csInfo'] = unserialize($row['csInfo']);
        $row['csInfo'] = json_encode($row['csInfo']);
        $row['delivery'] = json_decode($config['delivery'],true);

        $row['headTag'] = stripslashes($row['headTag']);
        $row['bodyTag'] = stripslashes($row['bodyTag']);
        $arr = array("result"=>$res, "data"=>$row);
        echo json_encode($arr);
    }
}
?>
