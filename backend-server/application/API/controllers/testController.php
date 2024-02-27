<?php
namespace application\API\controllers;

class testController extends Controller
{
    function getList(){
        $arr = array("result"=>"000", "client"=>"asd", "data"=>$_REQUEST);
        echo json_encode($arr);
    }

    function get(){
        $arr = array("result"=>"000", "client"=>"asd", "data"=>$_REQUEST);
        echo json_encode($arr);
    }

    function set(){
        $arr = array("result"=>"000", "client"=>"asd", "data"=>$_REQUEST);
        echo json_encode($arr);
    }
}
?>
