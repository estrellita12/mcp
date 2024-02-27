<?php
namespace application\Seller\controllers;

class JoinController{
    public $param;
    public $query;

    public function __construct($params){
        $this->param = $params;
        $method = isset($this->param['page']) ? $this->param['page'] : 'index';
        if(method_exists($this,$method)) $this->$method();
    }

    public function index(){
        require_once(_VIEW."/head.php");
        $path = _VIEW."/{$this->param['menu']}/{$this->param['page']}.php";
        if(file_exists($path)) require_once($path);
        require_once(_VIEW."/footer.php");
    }

    public function overChk(){ 
        $this->header=false; $this->footer=false;
        $userModel = new \application\models\UserModel();
        $res = $userModel->overChk("user_id",$_GET['id']);
        echo json_encode(array('res'=>$res));
    }

    public function add(){
        $sellerModel = new \application\models\SellerModel();
        $res = $sellerModel->add($_POST);
        $msg = $res == "000" ? "공급사가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $msg = "입점 신청이 완료되었습니다. 2~3일 내로 연락드리겠습니다. ";
        access($msg , "/Login");
    }




}

?>
