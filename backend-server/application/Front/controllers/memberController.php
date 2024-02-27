<?php
namespace application\Front\controllers;

use \Exception;

class memberController extends Controller{
    private $col;
    private $sql;
    private $search;

    public function init(){
        try{
            $this->memberModel = new \application\models\MemberModel();
            $this->col = array(
                "mb_id"=>"mb_id",
                "mb_name"=>"ifnull(mb_name,'')",
                "mb_img"=>"ifnull(mb_img,'')",
                "mb_grade"=>"ifnull(mb_grade,'')",
                "mb_point"=>"ifnull(mb_point,0)",
                "mb_birth"=>"ifnull(mb_birth,'')",
                "mb_gender"=>"ifnull(mb_gender,'')",
                "mb_email"=>"ifnull(mb_email,'')",
                "mb_cellphone"=>"ifnull(mb_cellphone,'')",
                "mb_zip"=>"ifnull(mb_zip,'')",
                "mb_addr1"=>"ifnull(mb_addr1,'')",
                "mb_addr2"=>"ifnull(mb_addr2,'')",
                "mb_addr3"=>"ifnull(mb_addr3,'')",
                "mb_baesong_msg"=>"ifnull(mb_baesong_msg,'')",
                "mb_smsser_yn"=>"ifnull(mb_smsser_yn,'n')",
                "mb_emailser_yn"=>"ifnull(mb_emailser_yn,'n')",
            );
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function getSearch($request){
        try{
            $this->sql = "";
            $this->search = array();
            $this->search['pt_id'] = $this->shopId;
            $this->search['mb_stt'] = "2";
            $this->search['mb_block_yn'] = "n";
            if( !empty($request['mb_id']) ) $this->search['mb_id'] = $request['mb_id'];
            if( !empty($request['mb_sns_id_1']) ) $this->search['mb_sns_id_1'] = $request['mb_sns_id_1'];
            if( !empty($request['mb_sns_id_2']) ) $this->search['mb_sns_id_2'] = $request['mb_sns_id_2'];
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    /*
    public function getList(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];

        $col = get_column_as($this->col,array(),false);
        $this->getSearch($request);
        $list = $this->memberModel->get($col,$this->search,true,$this->sql);
        if( !is_array($list) ) $this->result($list);
        $this->response_json("000",array("list"=>$list));
    }
     */

    public function get(){
        try{
            if( empty($this->param['ident']) ) $this->result("002");
            if( empty($this->userId) )  $this->result("403");
            if( $this->userId != $this->param['ident'] ) $this->result("403");
            $request = array("mb_id"=>$this->userId);

            $this->getSearch($request);
            $col = get_column_as($this->col,array(),false);
            $row = $this->memberModel->get($col, $this->search,false,$this->sql);
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);
            //$this->response_json("000",array("data"=>base64_encode(json_encode($row))));
            $this->response_json("000",array("data"=>$row));
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function add(){
        try{
            $request = array();
            if( !empty($this->request['put']) ) $request = $this->request['put'];
            if( empty($request) ) $this->result("002",array("request"=>$request));

            $value = array();
            $value['shop'] = $this->shopId;
            if( !empty($request['mb_id']) ) $value['id'] = $request['mb_id'];
            if( !empty($request['mb_passwd']) ) $value['passwd'] = $request['mb_passwd'];
            if( !empty($request['mb_name']) ) $value['name'] = $request['mb_name'];
            if( !empty($request['mb_cellphone']) ) $value['cellphone'] = $request['mb_cellphone'];
            if( !empty($request['mb_email']) ) $value['email'] = $request['mb_email'];
            if( !empty($request['mb_img']) ) $value['img'] = $request['mb_img'];
            if( !empty($request['mb_birth']) ) $value['birth'] = $request['mb_birth'];
            if( !empty($request['mb_gender']) ) $value['gender'] = $request['mb_gender'];
            if( !empty($request['mb_smsser_yn']) ) $value['smsser'] = $request['mb_smsser_yn'];
            if( !empty($request['mb_emailser_yn']) ) $value['emailser'] = $request['mb_emailser_yn'];
            if( !empty($request['mb_zip']) )    $value['zip'] = $request['mb_zip'];
            if( !empty($request['mb_addr1']) )  $value['addr1'] = $request['mb_addr1'];
            if( !empty($request['mb_addr2']) )  $value['addr2'] = $request['mb_addr2'];
            if( !empty($request['mb_addr3']) )  $value['addr3'] = $request['mb_addr3'];
            if( !empty($request['mb_baesong_msg']) )  $value['baesongMsg'] = $request['mb_baesong_msg'];
            $res = $this->memberModel->add($value);
            $this->response_json($res);
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function set(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($request) ) $this->result("002");
            if( empty($this->param['ident']) ) $this->result("002");
            if( empty($this->userId) ) $this->result("403");
            if( $this->userId != $this->param['ident'] )  $this->result("403");

            $value = array();
            if( !empty($request['mb_passwd']) )     $value['passwd'] = $request['mb_passwd'];
            if( !empty($request['mb_name']) )   $value['name'] = $request['mb_name'];
            if( !empty($request['mb_cellphone']) )  $value['cellphone'] = $request['mb_cellphone'];
            if( !empty($request['mb_email']) )  $value['email'] = $request['mb_email'];
            if( !empty($request['mb_img']) )    $value['img'] = $request['mb_img'];
            if( !empty($request['mb_birth']) )  $value['birth'] = $request['mb_birth'];
            if( !empty($request['mb_gender']) )     $value['gender'] = $request['mb_gender'];
            if( !empty($request['mb_smsser_yn']) )  $value['smsser'] = $request['mb_smsser_yn'];
            if( !empty($request['mb_emailser_yn']) )    $value['emailser'] = $request['mb_emailser_yn'];
            if( !empty($request['mb_zip']) )    $value['zip'] = $request['mb_zip'];
            if( !empty($request['mb_addr1']) )  $value['addr1'] = $request['mb_addr1'];
            if( !empty($request['mb_addr2']) )  $value['addr2'] = $request['mb_addr2'];
            if( !empty($request['mb_addr3']) )  $value['addr3'] = $request['mb_addr3'];
            if( !empty($request['mb_baesong_msg']) )  $value['baesongMsg'] = $request['mb_baesong_msg'];
            $res = $this->memberModel->set($value,$this->param['ident']);
            $this->response_json($res);

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function remove(){
        try{
            $request = array();
            if( !empty($this->request['delete']) ) $request = $this->request['delete'];
            if( empty($this->param['ident']) ) $this->result("002");
            if( empty($this->userId) ) $this->result("403");
            if( $this->userId != $this->param['ident'] )  $this->result("403");

            $isKakao = false; $isNaver = false;
            $data = $this->memberModel->get("mb_sns_id_1,mb_sns_id_2",array("mb_id"=>$this->param['ident']));
            if( !empty($data['mb_sns_id_1']) ) $isKakao = true;
            if( !empty($data['mb_sns_id_2']) ) $isNaver = true;

            $value = array();
            $value['id'] = $this->param['ident'];
            $value['shop'] = $this->shopId;
            $value['reason'] = "자발적 탈퇴";
            if( !empty($request['mb_leave_reason']) ) $value['reason'] = $request['mb_leave_reason'];
            $res = $this->memberModel->leave($this->param['ident'],$value);
            if( $res != "000" ) $this->result($res,"000이 아님");

            if( $isKakao ){
                if( !empty($request['access_token']) ){
                    $url = 'https://kapi.kakao.com/v1/user/unlink';
                    $curlHandle = curl_init($url);
                    curl_setopt_array($curlHandle, [
                        CURLOPT_POST => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer ' . $request['access_token'],
                            'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                        ),
                    ]);
                    $response = curl_exec($curlHandle);
                    $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
                    if( $httpCode!="200" ) $this->result("104",$response);
                    $user = json_decode($response,true);
                    curl_close($curlHandle);
                }
            }
            session_unset();
            session_destroy();
            $this->response_json("000");

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    /*
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
     */

    public function over(){ 
        try{
            if( empty($this->param['ident']) ) $this->result("002");

            $this->userModel = new \application\models\UserModel();
            if( !$this->userModel->overChk("user_id",$this->param['ident']) ) $this->result("003");
            $this->response_json("000");

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function login(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($request['user_id']) || empty($request['user_passwd']) )  $this->result("002");
            $id = $request['user_id'];
            $pw = $request['user_passwd'];

            $row = $this->memberModel->get("mb_id,pt_id,mb_name,mb_passwd,mb_grade,mb_stt,mb_login_cnt,count(mb_id) as cnt",array("mb_id"=>$id));
            if( $row['cnt'] < 1 ) $this->result("100");
            if( !password_verify($pw, $row['mb_passwd']) )  $this->result("102");
            if ( $row['mb_stt'] != 2 ) $this->result("103");
            if($row['pt_id'] != $this->shopId) $this->result("101");
            $value['mb_last_login_dt'] = _DATE_YMDHIS;
            $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
            $res = $this->memberModel->set($value,$id,"value");
            if($res!="000") $this->result($res);

            set_session("user_id",$row['mb_id']);
            set_session("user_type",'member');
            set_session("user_grade",$row['mb_grade']);
            set_session("is_member","1");

            $direct = "";
            if( !empty($_COOKIE['direct']) ) $direct = $_COOKIE['direct'];
            if( empty($direct) && !empty($request['direct']) ) $direct = $request['direct'];
            if( !empty($direct) ){
                $cartModel = new \application\models\CartModel();
                $cartModel->login($id,$direct);
            }
            $row = $this->memberModel->get("mb_id, pt_id, mb_name, mb_grade", array("mb_id"=>$id));
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);
            $enc = new \application\models\EncryptToken();
            $arr = array(
                "isAuth"=>true,
                "shopId"=>$this->shopId,
                "shopName"=>$this->shopName,
                "shopGrade"=>$this->shopGrade,
                "shopUseCtg"=>$this->shopUseCtg,
                "userId"=>$row['mb_id'],
                "userName"=>$row['mb_name'],
                "userGrade"=>$row['mb_grade'],
            );
            $token = $enc->encrypt($arr);
            $this->response_json($res,array("user"=>json_encode($row), "token"=>$token));

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }


    public function kakao(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            if( empty($request['access_token']) ){
                $client_id = $request['client_id'];
                $redirect_uri = $request['redirect_uri'];
                $code = $request['code'];

                // token 받기
                $url = 'https://kauth.kakao.com/oauth/token';
                $curlHandle = curl_init($url);
                $data =  array(
                    "grant_type"=>"authorization_code",
                    "client_id"=>$client_id,
                    "redirect_uri"=>$redirect_uri,
                    "code"=>$code,
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
                $data = json_decode($response,true);
                curl_close($curlHandle);
                $token = $data['access_token'];
            }else{
                $token = $request['access_token'];
            }

            // 사용자 정보 가져오기
            $url = 'https://kapi.kakao.com/v2/user/me';
            $curlHandle = curl_init($url);
            curl_setopt_array($curlHandle, [
                CURLOPT_POST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token,
                    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                ),
            ]);
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            if( $httpCode!="200" ) $this->result("104",$response);
            $user = json_decode($response,true);
            curl_close($curlHandle);
            $value = array();
            $row = $this->memberModel->get("mb_id,mb_stt,mb_login_cnt,count(mb_id) as cnt", array("mb_sns_id_1"=>$user['id']) );
            if( $row['cnt'] < 1 || empty($row['mb_id']) ){ // 사용자 존재 여부 확인
                $arr = array();
                $arr['id'] = uniqid();
                $arr['passwd'] = uniqid();
                $arr['snsid1'] = $user['id']; 
                $arr['shop'] = $this->shopId; 
                if( !empty($user['kakao_account']['email']) )
                    $value['email'] = $user['kakao_account']['email'];
                if( !empty($user['kakao_account']['profile']['nickname']) )
                    $value['name'] = $user['kakao_account']['profile']['nickname'];
                if( !empty($user['kakao_account']['profile']['profile_image_url']) )
                    $arr["img"] = "data:image/jpg;base64,".base64_encode(file_get_contents($user['kakao_account']['profile']['profile_image_url']));
                $res = $this->memberModel->add($arr);
                $row = $this->memberModel->get("mb_id,mb_stt,mb_login_cnt,count(mb_id) as cnt",array("mb_sns_id_1"=>$user['id']));
            }
            if ( $row['mb_stt'] != 2 ) $this->result("100");

            $value['mb_last_login_dt'] = _DATE_YMDHIS;
            $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
            $res = $this->memberModel->set($value,$row['mb_id'],"value");

            $row = $this->memberModel->get("mb_id, pt_id, mb_name, mb_grade", array("mb_sns_id_1"=>$user['id']));
            if( empty($row) ) $this->result("001");
            if( !is_array($row) ) $this->result($row);
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

            $enc = new \application\models\EncryptToken();
            $arr = array(
                "isAuth"=>true,
                "shopId"=>$this->shopId,
                "shopName"=>$this->shopName,
                "shopGrade"=>$this->shopGrade,
                "shopUseCtg"=>$this->shopUseCtg,
                "userId"=>$row['mb_id'],
                "userName"=>$row['mb_name'],
                "userGrade"=>$row['mb_grade'],
            );
            $token = $enc->encrypt($arr);
            $this->response_json($res,array("data"=>$row, "token"=>$token));

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function logout(){
        try{
            if( empty($this->param['ident']) ) $this->result('102');
            if( empty($this->userId) ) $this->result("403");
            if( $this->userId != $this->param['ident'] ) $this->result("403");
            session_unset();
            session_destroy();
            $this->response_json("000");

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }


    public function send(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            //if( !empty($this->request['get']) ) $request = $this->request['get'];
            $type = $this->param['ident'];
            if( $type == "sms" ){
                $this->sendSms($request);
            }
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function sendSms($request){
        try{
            if( empty($request['sms_receiver_phone']) ) $this->result("002");
            $request['sms_receiver_phone'] = only_number($request['sms_receiver_phone']);

            $templateModel = new \application\models\TemplateModel();
            $authNum = mt_rand(1000,9999);
            $value = array();
            $value['userCellphone'] = $request['sms_receiver_phone'];
            $value['certNum'] = $authNum;
            /*
            $res = $templateModel->send("",13,$value);
            if( $res != "000" ) $this->result($result);
            set_session( $request['sms_receiver_phone'] , $authNum ); 
            set_session( "auth_timeout" , time() );
            $this->response_json("000");
            */
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function check(){
        try{
            $request = array();
            if( !empty($this->request['post']) ) $request = $this->request['post'];
            //if( !empty($this->request['get']) ) $request = $this->request['get'];
            $type = $this->param['ident'];
            if( $type == "sms" ){
                $this->checkSms($request);
            }
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function checkSms($request){
        try{
            if( empty($request['sms_receiver_phone']) ) $this->result("002");
            $request['sms_receiver_phone'] = only_number($request['sms_receiver_phone']);
            $request['sms_auth_number'] = only_number($request['sms_auth_number']);
            
            // 테스트 
            set_session( $request['sms_receiver_phone'] , "1234" ); 
            /*
            if( !get_session("auth_timeout") || (time() - get_session("auth_timeout") > 300) ){
                $this->result("302",array("session"=>$_SESSION,"request"=>$request));
                unset_session($request['sms_receiver_phone']);
                unset_session("auth_timeout");
            }
            if( get_session($request['sms_receiver_phone']) != $request['sms_auth_number'] ) 
                $this->result("006");
            */
            unset_session($request['sms_receiver_phone']);
            unset_session("auth_timeout");
            set_session("isAuth",1);
            set_session("userCellphone",$request['sms_receiver_phone']);
            $this->response_json( "000");

        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function passwd(){
        $request = array();
        if( !empty($this->request['post']) ) $request = $this->request['post'];
        if( empty($this->param['ident']) ) $this->result("002");
        if( empty($this->userId) )  $this->result("403");
        if( $this->userId != $this->param['ident'] ) $this->result("403");
        $id = $this->userId;
        $pw = $request['mb_passwd'];

        $row = $this->memberModel->get("mb_passwd",array("mb_id"=>$id));
        if( empty($row) ) $this->result("100");
        if( !is_array($row) ) $this->result("100");
        if( !password_verify($pw, $row['mb_passwd']) )  $this->response_json("102");
        $this->response_json("000");
    }

}

