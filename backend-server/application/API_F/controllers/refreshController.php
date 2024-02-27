<?php
namespace application\API_F\controllers;

class refreshController extends Controller 
{
    function init(){ 
        $this->jwt = new \application\models\JWT();
    }    

    function getList(){
        $refreshCoin = $_REQUEST['data'];
        $dehashedCoin = $this->jwt->dehashing($refreshCoin);
        $result = array();
        if($dehashedCoin == "EXPIRED"){
            $result['res'] = "EXPIRED";
        }else if($dehashedCoin == "SIGNATURE ERROR"){
            $result['res'] = "FAILED";
        }else{
            $result['res'] = 'SUCCESS';
            $result['token'] = array(
                'access' => $this->jwt->hashing(array("index" => $dehashedCoin['index'], "exp" => time()+($this->expiration))),
                'refresh' => $this->jwt->hashing(array("index" => $dehashedCoin['index'], "exp" => time()+2*($this->expiration)))
            );
        }
        echo json_encode($result);
    }
}
?>
