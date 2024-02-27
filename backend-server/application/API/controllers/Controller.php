<?php
namespace application\API\controllers;

use \Exception;

abstract class Controller{
    var $param;        

    //생성자
    function __construct($params){
        try{
            $this->param = $params;
            if($_SERVER['REQUEST_METHOD']=='GET'){
                if( isset($this->param['ident']) ) $method = 'get';
                else  $method = 'getList';
            }else if($_SERVER['REQUEST_METHOD']=='POST'){
                $method = 'set';
            }else if($_SERVER['REQUEST_METHOD']=='PUT'){
                $method = 'add';
                parse_str(file_get_contents("php://input"), $_PUT);
            }else if( $_SERVER['REQUEST_METHOD']=='DELETE' ){
                $method = 'remove';
                parse_str(file_get_contents("php://input"), $_DELETE);
            }else{
                $method = 'notFound';
            }

            if( !empty($this->param['method']) ){
                $method = $this->param['method'];
            }
            $this->init();
            if( method_exists($this,$method) ){ $this->$method(); }else{ $this->notFound(); }
        }catch(Exception $e){
            $this->result("500",$e->getMessage());
        }
    }

    abstract function init();

    function notFound(){
        //http_response_code(404);
        $this->result("404","Not Found File (존재하지 않는 파일입니다.)");
    }

    function tokenCheck($lv=1){
        $this->temp();return;
        try{
            $headers = apache_request_headers();
            $token = $headers['Authorization'];
            if( empty($token) ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");

            $enc = new \application\models\EncryptToken();
            $data = $enc->decrypt($token);
            if( empty($data) || !is_array($data) ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");
            if( empty($data['is_auth']) || $data['is_auth'] < 1 ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");

            $this->isAuth = $data['is_auth'];
            if($this->isAuth==1){ // 일반 사용자
                $this->shopId = $data['shop_id'];
                $this->shopName = $data['shop_name'];
                $this->shopGrade = $data['shop_grade'];
                $this->shopUseCtg = $data['shop_use_ctg'];
            }else{
                if( empty($data['user_id']) ) throw new Exception("Permission Denied (인증 오류가 발생하였습니다.)");
                if($this->isAuth==2){ // 가맹점 Partner
                    // user_id, user_pw 체크
                    $partner = new \application\models\PartnerModel();
                    //$row = $partner->get($data['user_id'],$partner->getCol(array("state","useCtg")));
                    $row = $partner->get($partner->getCol(array("state","useCtg")), array("pt_id"=>$data['user_id']));
                    if($row['state']!=2) throw new Exception("Permission Denied (허용되지 않은 사용자 입니다.)");
                    $this->userId = $data['user_id'];
                    $this->useCtg = $row['useCtg'];
                }else if($this->isAuth==3){ // 판매자 Seller
                    $this->userId = $data['user_id'];   
                    // user_id, user_pw 체크   
                }
            }
        }catch(Exception $e){
            //http_response_code(403);
            $this->result("403",$e->getMessage());
        }
    }

    function temp(){
        try{
            $this->isAuth = 1;
            if($this->isAuth==1){
                $httpHost = $_SERVER['HTTP_HOST'];
                $partner = new \application\models\PartnerModel();
                $search = " and shop_url = '".$httpHost."'";

                $row = $partner->select($partner->getCol(), $search);
                if(empty($row)) {
                    exit;
                }
                $default = new \application\models\DefaultModel();
                $def = $default->get($default->getCol());
                foreach($row as $key=>$value){
                    if(empty($value)) $row[$key] = $def[$key];
                }
                $row['useCtg'] = unserialize($row['useCtg']);
                $row['gnb'] = unserialize($row['gnb']);
                $row['main'] = unserialize($row['main']);
                $row['csInfo'] = unserialize($row['csInfo']);
                $row['headTag'] = stripslashes($row['headTag']);
                $row['bodyTag'] = stripslashes($row['bodyTag']);

                $this->shopId = $row['shopId'];
                $this->shopName = $row['shopName'];
                $this->shopGrade = $row['shopGrade'];
                $this->shopUseCtg = $row['useCtg'];
            }else if($this->isAuth==2){
                $this->userId = 'custom';
            }else if($this->isAuth==3){
                $this->userId = "majorgolf";
            }
        }catch(Exception $e){
            $this->result("500",$e);
        }
    }

    function result($code,$e=''){
        $arr = array( "result"=>$code, "error"=>$e );
        echo json_encode($arr);
        exit;
    }

}
?>
