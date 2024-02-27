<?php
namespace application\API\controllers;

class goodsController extends Controller
{
    function getList(){
        $col = "gs_id as id,gs_code as code, gs_ctg as ctg , gs_brand as brand, gs_name as name, gs_price as goodsPrice, gs_consumer_price as consumerPrice, gs_simg1 as simg1";
        $goods = new \application\models\GoodsModel();
        $_REQUEST['ctg'] = implode(",",_CATEGORY);
        $_REQUEST['state'] = "2";
        $_REQUEST['col'] = $_GET['type'];
        $_REQUEST['term'] = "salesDate";
        $_REQUEST['shop'] = _SHOP;
        $_REQUEST['page'] = 1;
        $_REQUEST['rpp'] = $_GET['rpp'];
        $row = $goods->getList($col);
        $arr = array("res"=>"000","client"=>_SHOP,"data"=>$row);
        echo json_encode($arr);
    }

     function get(){
        $goods = new \application\models\GoodsModel();
        $row = $goods->get($this->params['ident'],$col);
        $arr = array("res"=>"000","client"=>_SHOP,"data"=>$row);
        echo json_encode($arr);
    }

}

