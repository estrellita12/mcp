<?php
namespace application\API_F\controllers;

class TestController extends Controller 
{
    function test(){ 
        echo "test";
    }    

    function init(){ 
        $this->jwt = new \application\models\JWT();
    }    

    function getList(){
        $nowAccess = $this->access ? $this->jwt->dehashing($this->access) : 'IS NOT TOKEN INFO';

        $access_time = !empty($nowAccess['exp']) ? $nowAccess['exp'] - time() : $nowAccess;

        $res = array('access' => $access_time);
        echo json_encode([$nowAccess, $res]);
    }
}
?>