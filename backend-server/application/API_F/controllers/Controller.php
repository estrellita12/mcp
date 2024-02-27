<?php
namespace application\API_F\controllers;

class Controller 
{
    var $param; // 전달된 파라미터  menu/page/ident/action
    var $url;

    var $expiration = 86400;
    var $access;
    var $accessInfo;
    var $refreshChk;
    var $jwt;

    var $shopId;
    var $shopName;
    var $shopGrade;
    var $shopUseCtg;
    var $shopKakaoKey;
    var $shopTossClient;
    var $shopTossSecret;
    var $shopDefault;

    //생성자
    function __construct($params){
        /*-------------------------------- SET ------------------------------------*/
        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');
        //$this->check();
        
        /*----------------------------- TOKEN CHK ---------------------------------*/
        $this->jwt = new \application\models\JWT();
        $headers = apache_request_headers();        

        $this->access = !empty($headers['Authorization']) ? $headers['Authorization'] : null;
        $this->refreshChk = $params['collection'] == "refresh" ? 1 : 0;
        
        if($this->access && !$this->refreshChk){
            try{
                $this->accessInfo = $this->jwt->dehashing($this->access);
                if($this->accessInfo == "EXPIRED") http_response_code(401); //token expired
                if($this->accessInfo == "SIGNATURE ERROR") http_response_code(403); //token signature not matching

                $memberModel = new \application\models\MemberModel();
                $row = $memberModel->get( $memberModel->getCol(), array("mb_id"=>$this->accessInfo['index']) );
                if(!$row) http_response_code(410); //token member deleted
            }catch(Exception $e){
                http_response_code(403);
            }
        }  

        /*------------------------------- ROUTE -----------------------------------*/
        $this->param = $params;
        if($_SERVER['REQUEST_METHOD']=='GET'){
            if( !empty($this->param['ident']) ) $method = 'get';
            else  $method = 'getList';
        }else if($_SERVER['REQUEST_METHOD']=='POST'){
            $this->postData = json_decode(file_get_contents('php://input'), true);            
            $method = 'add';
        }else if($_SERVER['REQUEST_METHOD']=='PUT'){
            $this->putData = json_decode(file_get_contents('php://input'), true);            
            $method = 'set';
        }else if( $_SERVER['REQUEST_METHOD']=='DELETE' ){
            if( !empty($this->param['ident']) ) $method = 'remove';
            //else  $method = 'removeList';
        }else{
            $method = 'report';
        }

        if( !empty($this->param['controller']) ){
            $method = $this->param['controller'];
        }

        $this->init();

        if( method_exists($this,$method) ) $this->$method();
    }

    function check(){}

    function init(){

    }

    function temp(){
        $httpHost = $_SERVER['HTTP_HOST'];
        $partner = new \application\models\PartnerModel();
        $search = " and shop_url = '".$httpHost."'";

        $row = $partner->select($partner->getCol(), $search);
        if(empty($row)) {
            exit;
        }
        
        $default = new \application\models\DefaultModel();
        $def = $default->get($default->getCol(), array("df_id"=>"1"));
        foreach($row as $key=>$value){
            if(empty($value)) $row[$key] = $def[$key];
        }

        $row['useCtg'] = unserialize($row['useCtg']);
        //$row['gnb'] = unserialize($row['gnb']);
        //$row['main'] = unserialize($row['main']);
        $row['csInfo'] = unserialize($row['csInfo']);
        $row['headTag'] = stripslashes($row['headTag']);
        $row['bodyTag'] = stripslashes($row['bodyTag']);

        $this->shopId = $row['shopId'];
        $this->shopName = $row['shopName'];
        $this->shopGrade = $row['shopGrade'];
        $this->shopUseCtg = $row['useCtg'];
        $this->shopKakaoKey = $row['loginKakaoApiKey'];
        $this->shopTossClient = $row['pgClientKey'];
        $this->shopTossSecret = $row['pgSecretKey'];
        $this->shopTossMid = $row['pgMid'];
        $this->shopDefault = $def;

        $this->appleKey = '82NR45563P';
        $this->appleTeam = 'N6AG22AY8K';
        $this->appleService = 'kr.alldeal.signin';
        $this->redirect = 'https://alldeal.kr/api_f/login/check/apple';                
    }

    function report(){
        $arr = array("result"=>$this->method,"client"=>_PTID,"data"=>$row);
        echo json_encode($arr);
    }
}
?>
