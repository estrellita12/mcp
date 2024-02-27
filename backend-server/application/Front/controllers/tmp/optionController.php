<?php
namespace application\API\controllers;

use \Exception;

class optionController extends Controller{

    function init(){
        $this->tokenCheck();
        $this->option = new \application\models\GoodsOptionModel();
    }

    function getList(){
        if(empty($_GET['goodsId'])) $this->result("002");

        $res = "000";
        $colArr = array("optionId","bacode","optionName","goodsId","addPrice","optionStockQty");
        $_REQUEST['useYn'] = 'y';
        $_REQUEST['goodsId'] = $_GET['goodsId'];
        $row = $this->option->getList($this->option->getCol($colArr));  
        if(!is_array($row)) $this->result($res);
        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function get(){
        $res = "000";
        $colArr = array("optionId","bacode","optionName","goodsId","addPrice","optionStockQty","useYn");
        $row = $this->option->get($this->param['ident'],$this->option->getCol($colArr));
        if(!is_array($row)) $this->result($res);
        $arr = array("result"=>"000","data"=>$row);
        echo json_encode($arr);
    }

}

