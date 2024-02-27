<?php
namespace application\Partner\controllers;

class LoginController{
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

    public function loginCheck(){
        if( isset($_SESSION['is_partner']) ){
            access("이미 로그인 중입니다.", _URL );
            die();
        }

        $id = $_POST['id'];
        $passwd = $_POST['passwd'];
        $partner = new \application\models\PartnerModel();
        $res = $partner->login($id,$passwd);
        if($res=="000"){
            access("로그인 되었습니다. \\n [{$_SESSION['user_grade']}] {$_SESSION['user_id']}님 환영합니다 :D", _URL );
        }else{
            access("계정 정보가 올바르지 않습니다.");
            die();
        }
    }

    public function logout(){
        session_unset(); 
        session_destroy(); 
        access("로그아웃 되었습니다.", _URL."/Login");
        die();
    }
}

?>
