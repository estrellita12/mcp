<?php
namespace application\Admin\controllers;

class UserController extends Controller
{
    var $user;
    var $cnt;
    var $col;

    function init(){ 
        $this->user = new \application\models\UserModel();
        $this->col = "*";
    }

    function overChk(){ 
        $this->header=false; $this->footer=false;
        $res = $this->user->overChk("user_id",$_GET['id']);
        echo json_encode(array('res'=>$res));
    }

}
?>
