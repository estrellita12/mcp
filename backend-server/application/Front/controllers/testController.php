<?php
namespace application\Front\controllers;

use \Exception;

class testController extends Controller{
    public $col;
    public $search;
    public $sql;

    public function init(){}
    public function getList(){
        $orderModel = new \application\models\OrderNoModel();
        $od_no = "230607154323740";
        $res = $orderModel->changeState2($od_no);
        //$res = $orderModel->changeState42($od_no);
        print_r($res);
    }


}
