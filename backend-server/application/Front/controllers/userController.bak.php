<?php
namespace application\Front\controllers;

class userController extends Controller{
    public function init(){
        $this->tokenCheck();
        $this->member = new \application\models\MemberModel();
    }

    function add(){
        parse_str(file_get_contents("php://input"), $_PUT);
        $_PUT['shop'] = $this->shopId;
        $res = $this->member->add($_PUT);
        $arr = array("result"=>$res);
        echo json_encode($arr);
    }

    function set(){
        if( isset($_SESSION['user_id']) && $_SESSION['user_id'] == $this->param['ident'] ){
            $res = $this->member->set($_POST,$this->param['ident']);
        }else{
            $this->result("403");
        }
        $arr = array("result"=>$res );
        echo json_encode($arr);
    }

    function get(){
        $res = "000";
        $colArr = array("id","shop","name","grade","email","cellphone","zip","addr1","addr2","smsser","gender","birth");
        if( isset($_SESSION['user_id']) && $_SESSION['user_id'] == $this->param['ident'] ){
            $row = $this->member->get($_SESSION['user_id'],$this->member->getCol($colArr));
        }else{
            $this->result("403");
        }

        $arr = array("result"=>$res, "data"=> base64_encode(json_encode($row)) );
        echo json_encode($arr);
    }

    function login(){
        if( empty($this->request['post']) ) 
            $this->response_json("002");
        $request = $this->request['post'];
        if( empty($request['userId']) || empty($request['passwd']) ) 
            $this->response_json("002");
        $id = $request['userId'];
        $pw = $request['passwd'];

        $row = $this->member->get("mb_id,pt_id,mb_name,mb_passwd,mb_grade,mb_stt,mb_login_cnt,count(mb_id) as cnt",array("mb_id"=>$id));
        if( $row['cnt'] < 1 ) $this->result("100");
        if( !password_verify($pw, $row['mb_passwd']) )  $this->result("102");
        if ( $row['mb_stt'] != 2 ) $this->result("103");
        if($row['pt_id'] != $this->shopId) $this->result("101");
        $value['mb_last_login_dt'] = _DATE_YMDHIS;
        $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
        $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
        $res = $this->member->set($value,$id,"value");
        if($res!="000") $this->result($res);

        set_session("user_id",$row['mb_id']);
        set_session("user_type",'member');
        set_session("user_grade",$row['mb_grade']);
        set_session("is_member","1");

/*
        $this->cart = new \application\models\CartModel();
        $_REQUEST['direct'] = $_COOKIE['direct'];
        foreach($this->cart->getList("cart_id") as $row){
            $arr['userId'] = $_SESSION['user_id'];
            $arr['direct'] = '';
            $this->cart->set($arr,$row['cart_id']);
        }

*/
        $row = $this->member->get("mb_id, pt_id, mb_name, mb_grade", array("mb_id"=>$id));
        $this->response_json("000",array("data"=>base64_encode(json_encode($row)),"id"=>$row['mb_id']));
    }

    function confirm(){
        $id = $this->param['ident'];
        $pw = $_POST['passwd'];
        if( empty($id) || empty($pw) ) $this->result("102");
        if( !isset($_SESSION['user_id']) || $_SESSION['user_id'] != $this->param['ident'] ) $this->result("403");

        $row = $this->member->get($id,"mb_id,pt_id,mb_name,mb_passwd,mb_grade,mb_stt,mb_login_cnt,count(mb_id) as cnt");
        if( !password_verify($pw, $row['mb_passwd']) )  $this->result("102");
        if( $row['cnt'] < 1 ) $this->result("100");
        if( $row['mb_stt'] != 2 ) $this->result("103");
        if( $row['pt_id'] != $this->shopId ) $this->result("101");

        $arr = array("result"=>"000");
        echo json_encode($arr);
    }

    function kakao(){
        // 토큰 받기
        $url = 'https://kauth.kakao.com/oauth/token';
        $curlHandle = curl_init($url);
        $data =  array(
            "grant_type"=>"authorization_code",
            "client_id"=>"548e315af87a32c3eae8d23cb2da8aac",
            "redirect_uri"=>$_POST['redirect_url'],
            "code"=>$_POST['code'],
        );
        curl_setopt_array($curlHandle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
            ),
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);
        $response = curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        if( $httpCode!="200" ) $this->result("104",$response);
        $token = json_decode($response,true);
        curl_close($curlHandle);

        // 사용자 정보 가져오기
        $url = 'https://kapi.kakao.com/v2/user/me';
        $curlHandle = curl_init($url);
        curl_setopt_array($curlHandle, [
            CURLOPT_POST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token['access_token'],
                'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
            ),
        ]);
        $response = curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        if( $httpCode!="200" ) $this->result("104",$response);
        $user = json_decode($response,true);
        curl_close($curlHandle);
        $value = array();
        $row = $this->member->select("mb_id,mb_stt,pt_id,mb_passwd,mb_grade,mb_login_cnt,count(mb_id) as cnt"," and mb_sns_id_1 = '{$user['id']}'" );
        if( $row['cnt'] < 1 ){ // 사용자 존재 여부 확인
            $arr = array();
            $arr['id'] = uniqid();
            $arr['passwd'] = uniqid();
            $arr['snsid1'] = $user['id']; 
            $arr['shop'] = $this->shopId; 
            $arr['email'] = $user['kakao_account']['email']; 
            $arr['name'] = $user['kakao_account']['profile']['nickname']; 
            $arr['img'] = $user['kakao_account']['profile']['profile_image_url']; 
            $res = $this->member->add($arr);
            $row = $this->member->get($arr['id'],"mb_id,mb_stt,pt_id,mb_passwd,mb_grade,mb_login_cnt,count(mb_id) as cnt");
        }

        if ( $row['mb_stt'] != 2 ) $this->result("100");

        $value['mb_last_login_dt'] = _DATE_YMDHIS;
        $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
        $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
        $res = $this->member->set($value,$row['mb_id'],"value");
        set_session("user_id",$row['mb_id']);
        set_session("user_type",'member');
        set_session("user_grade",$row['mb_grade']);
        set_session("is_member","1");
        set_session("access_token",$token['access_token']);

        $this->cart = new \application\models\CartModel();
        $_REQUEST['direct'] = $_COOKIE['direct'];
        foreach($this->cart->getList("cart_id") as $row){
            $arr['userId'] = $_SESSION['user_id'];
            $arr['direct'] = '';
            $this->cart->set($arr,$row['cart_id']);
        }

        $row = $this->member->get($_SESSION['user_id'],$this->member->getCol());
        $arr = array("result"=>$res,"id"=>$row['id'], "data"=> base64_encode(json_encode($row)), token=>$token );
        echo json_encode($arr);
    }

    function logout(){
        $id = $this->param['ident'];
        if(empty($id)) $this->result('102');
        if( !isset($_SESSION['user_id']) || $_SESSION['user_id'] != $this->param['ident'] ) $this->result("403");
        session_unset();
        session_destroy();
        $arr = array( "result"=>"000");
        echo json_encode($arr);
    }

    function over(){ 
        $this->user = new \application\models\UserModel();
        $res = "003";
        if($this->user->overChk("user_id",$_GET['userId'])){
            $res = "000";
        }
        $arr = array( "result"=>$res);
        echo json_encode($arr);
    }

    function remove(){
        parse_str(file_get_contents("php://input"), $_DELETE);

        $id = $this->param['ident'];
        if(empty($id)) $this->result('102');
        if( !isset($_SESSION['user_id']) || $_SESSION['user_id'] != $this->param['ident'] ) $this->result("403");

        $arr = array(
            "id"=>$id,
            "shop"=>$this->shopId,
            "reason"=>$_DELETE['reason'] 
        );
        $res = $this->member->leave($id,$arr);

        if($_DELETE['isSns'] == 'y'){
            $url = 'https://kapi.kakao.com/v1/user/unlink';
            $curlHandle = curl_init($url);
            curl_setopt_array($curlHandle, [
                CURLOPT_POST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $_SESSION['access_token'],
                    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                ),
            ]);
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            if( $httpCode!="200" ) $this->result("104",$response);
            $user = json_decode($response,true);
            curl_close($curlHandle);
        }
        session_unset();
        session_destroy();
        $arr = array("result"=>$res );
        echo json_encode($arr);
    }

}

