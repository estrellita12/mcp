<?php
namespace application\Front\controllers;

use \Exception;

abstract class Controller{
    protected $param;        
    public $request;
    public $userId;
    public $userGrade;
    private $test;

    public function __construct($params){
        if( !empty($_REQUEST['test']) && $_REQUEST['test'] == "y" )  $this->test = "y";
        if( $this->test == "y" ){
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }

        try{
            $this->tokenCheck();
            $this->param = $params;
            $this->request = array();

            switch($_SERVER['REQUEST_METHOD']){
            case "GET":
            case "get":
                $this->request['get'] = $_GET;
                if( isset($this->param['ident']) ){
                    $method = 'get';
                }else{ 
                    $method = 'getList';
                }
                break;
            case "POST":
            case "post":
                $this->request['post'] = json_decode(file_get_contents('php://input'), true);
                $method = 'set';
                break;
            case "PUT":case "put":
                $this->request['put'] = json_decode(file_get_contents('php://input'), true);
                $method = 'add';
                break;
            case "DELETE": case "delete":
                $this->request['delete'] = json_decode(file_get_contents('php://input'), true);
                $method = 'remove';
                break;
            default:
                $method = "notFound";
            }
            //$method = "add";
/*
            if($_SERVER['REQUEST_METHOD']=='GET'){
                $this->request['get'] = $_GET;
                if( isset($this->param['ident']) ) $method = 'get';
                else  $method = 'getList';
            }else if($_SERVER['REQUEST_METHOD']=='POST'){
                $this->request['post'] = json_decode(file_get_contents('php://input'), true);
                $method = 'set';
            }else if($_SERVER['REQUEST_METHOD']=='PUT'){
                $this->request['put'] = json_decode(file_get_contents('php://input'), true);
                $method = 'add';
            }else if( $_SERVER['REQUEST_METHOD']=='DELETE' ){
                $this->request['delete'] = json_decode(file_get_contents('php://input'), true);
                $method = 'remove';
            }else{
                $method = 'notFound';
            }
 */

            if( !empty($this->param['method']) ){
                $method = $this->param['method'];
            }

            $this->init();
            if( method_exists($this,$method) ){ 
                $this->$method(); 
            }else{ 
                $this->notFound(); 
            }
        }catch(Exception $e){
            $this->result("500",$e->getMessage());
        }
    }

    abstract function init();

    public function notFound(){
        $this->result("404","Not Found File (존재하지 않는 파일입니다.)");
    }

    public function tokenCheck(){
        try{
            $enc = new \application\models\EncryptToken();
            $headers = apache_request_headers();
            if( !empty($headers['Authorization']) ) $token = $headers['Authorization'];

            if( $this->test == "y" ){
                $token = $enc->encrypt(array("isAuth"=>true,"userId"=>"sdfsdfsdf","userGrade"=>"9"));
            }
            if( empty($token) && !empty($headers['authorization']) ) $token = $headers['authorization'];
            if( empty($token) ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");

            $data = $enc->decrypt($token);
            if( empty($data) || !is_array($data) ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");
            if( empty($data["isAuth"]) || !$data["isAuth"] ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");

            if( !empty($data['userId']) ) $this->userId = $data['userId'];
            //if( !empty($_SESSION['user_id']) ) $this->userId = $_SESSION['user_id'];
            if( !empty($data['userGrade']) ) $this->userGrade = $data['userGrade'];
            //if( !empty($_SESSION['user_grade']) ) $this->userGrade = $_SESSION['user_grade'];

            $httpHost = $_SERVER['HTTP_HOST'];
            $partnerModel = new \application\models\PartnerModel();
            $row = $partnerModel->get("pt_id,pt_name,pt_grade,shop_use_ctg", array("shop_url"=>$httpHost,"pt_stt"=>"2"));
            if( empty($row) ) throw new Exception("Permission Denied (존재하지 않는 가맹점입니다.)");

            $this->shopId = $row['pt_id'];
            $this->shopName = $row['pt_name'];
            $this->shopGrade = $row['pt_grade'];
            $this->shopUseCtg = unserialize($row['shop_use_ctg']);
            if( empty($this->shopUseCtg) ){
                $defaultModel = new \application\models\DefaultModel();
                $row = $defaultModel->get("shop_use_ctg", array("df_id"=>"1"));
                $this->shopUseCtg = unserialize($row['shop_use_ctg']);
            }
        }catch(Exception $e){
            $this->result("403",$e->getMessage());
        }
    }

    protected function result($code,$msg=''){
        $arr = array( "result"=>$code, "error"=>$msg );
        debug_log( static::class,$code,array("error"=>$msg,"request"=>$_REQUEST) );
        echo json_encode($arr);
        exit;
    }

    protected function response_json($result,$data=array()){
        $arr = array( "result"=>(string)$result );
        foreach( $data as $key=>$value ) $arr[$key] = $value;
        echo json_encode($arr);
        exit;
    }

}
?>
