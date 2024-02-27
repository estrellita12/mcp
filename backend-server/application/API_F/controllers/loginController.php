<?php
namespace application\API_F\controllers;

class loginController extends Controller 
{
    function init(){ 
        $this->temp();
        $this->member = new \application\models\MemberModel();
        $this->jwt = new \application\models\JWT();
    }

    function phone(){
        $result = array();
        try{
            $id = $this->param['ident'];
            $row = $this->member->get("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt", array("mb_id"=>$id));
            $value = array();
            if(count($row)){
                $value['mb_last_login_dt'] = _DATE_YMDHIS;
                $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
                $res = $this->member->set($value,$row['mb_id'],"value");

                $result['token'] = array(
                    'access' => $this->jwt->hashing(array("index" => $id, "exp" => time()+($this->expiration))),
                    'refresh' => $this->jwt->hashing(array("index" => $id, "exp" => time()+2*($this->expiration)))
                );
                $result['res'] = "SUCCESS";
            };
        }catch(Exception $e){
            $result['res'] = "FAILED";
        }
        echo json_encode($result);
    }

    function kakao(){
        $result = array();
        try{
            // get token
            $post = $this->postData['params'];
            $url = 'https://kauth.kakao.com/oauth/token';
            $curlHandle = curl_init($url);
            $data =  array(
                "grant_type"=>"authorization_code",
                "client_id"=>!empty($post['client_id'])?$post['client_id']:$this->shopKakaoKey, //without client_id, possibly occuring error when client requests in TEST environment.
                "redirect_uri"=>$post['redirect_uri'],
                "code"=>$post['code'],
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

            // get customer info
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
            
            //check service terms (marketing)
            $data =  array(
                "target_id_type"=>"user_id",
                "target_id"=>$user['id'],
            );
            $url = 'https://kapi.kakao.com/v1/user/service/terms'."?".http_build_query($data, '', '&');
            $curlHandle = curl_init($url);
            curl_setopt_array($curlHandle, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $token['access_token'],
                )
            ]);
            $response = curl_exec($curlHandle);
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            if( $httpCode!="200" ) $this->result("104",$response);
            $terms = json_decode($response,true);
            $termsData = $terms['allowed_service_terms'];
            $keyChk = array_search('MarketingConsent', array_column($termsData, 'tag'));
            curl_close($curlHandle);

            $value = array();
            $result['type'] = 'login';
            $row = $this->member->select("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt"," and mb_sns_id_1 = '{$user['id']}' and pt_id = '{$this->shopId}'");
            if( $row['cnt'] < 1 ){ // if not member -> JOIN
                //init
                $result['type'] = 'join';
                $result['nick'] = $user['properties']['nickname'];
                $arr = array();

                //phone info duplicate check
                if(empty($user['kakao_account']['phone_number'])){
                    $result['res'] = "FAILED";
                    echo json_encode($result);
                    exit;
                }else{
                    $phoneArr = explode(" ", $user['kakao_account']['phone_number']);
                    $phoneInfo = "0{$phoneArr[1]}";
                    $phoneChk = $this->member->get("mb_id,mb_stt,pt_id,count(mb_id) as cnt", array("mb_cellphone"=>$phoneInfo, "pt_id"=>$this->shopId));   
                    if( $phoneChk['cnt'] > 0 ){ // duplicate phone number
                        $result['res'] = "DUPLICATE";
                        $result['kakaoId'] = $user['id'];
                        $result['userId'] = $phoneChk['mb_id'];
                        echo json_encode($result);
                        exit;                       
                    } 
                    $arr['cellphone'] = $phoneInfo;
                }

                //default values
                $birthDay = date("m-d"); //default birth : register day
                $birthYear = date("y")."-";
                $gender = 'm';
                $img = $post['defaultImg'];
                $smsser = $keyChk ? 'y' : 'n';
                $emailser = $keyChk ? 'y' : 'n';

                //push values
                if(!empty($user['kakao_account']['email'])) $arr['email'] = $user['kakao_account']['email'];
                if(!empty($user['kakao_account']['gender'])) $gender = $user['kakao_account']['gender'];
                if(!empty($user['kakao_account']['birthday'])) $birthDay = $user['kakao_account']['birthday'];
                if(!empty($user['kakao_account']['birthyear'])) $birthYear = $user['kakao_account']['birthyear'];
                if(!empty($user['properties']['profile_image'])){
                    $rawImg = file_get_contents($user['properties']['profile_image']);
                    $img = 'data:image/jpg;base64,'.base64_encode($rawImg);
                }
                $arr['id'] = uniqid();
                $arr['passwd'] = uniqid();
                $arr['snsid1'] = $user['id']; 
                $arr['shop'] = $this->shopId; 
                $arr['name'] = $user['properties']['nickname']; 
                $arr['gender'] = $gender; 
                $arr['birth'] = "{$birthYear}{$birthDay}"; 
                $arr['img'] = $img;
                $arr['smsser'] = $smsser;
                $arr['emailser'] = $emailser;

                //user info to request point api on client side
                $result['id'] = $arr['id'];
                $result['phone'] = $arr['cellphone'];

                //add member
                $res = $this->member->add($arr);
                $row = $this->member->get("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt", array("mb_id"=>$arr['id']));
            }
            
            //LOGIN
            if( $row['mb_stt'] != 2 ){
                $result['res'] = "FAILED";
                echo json_encode($result);
                exit;
            }

            $value['mb_last_login_dt'] = _DATE_YMDHIS;
            $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
            $res = $this->member->set($value,$row['mb_id'],"value");

            $result['token'] = array(
                'access' => $this->jwt->hashing(array("index" => $row['mb_id'], "exp" => time()+($this->expiration))),
                'refresh' => $this->jwt->hashing(array("index" => $row['mb_id'], "exp" => time()+2*($this->expiration)))
            );
            $result['res'] = "SUCCESS";
        }catch(Exception $e){
            $result['res'] = "FAILED";
            $result['error'] = $e;
        }
        
        echo json_encode($result);
    }

    function kakaoConnect(){
        $result = array();
        $result['result'] = 'success';
        try{
            //UPDATE
            $info = $this->putData;
            $putParams = $info['params'];
            $arr['id'] = $putParams['userId'];
            $arr['snsid1'] = $putParams['kakaoId'];
            $updateResult = $this->member->set($arr, $arr['id']);
            if($updateResult != "000" && $updateResult != "001"){
                $result['result'] = 'updateErr';
                echo json_encode($result);
                exit;
            }else{
                //LOGIN
                $userInfo = $this->member->get("mb_id, mb_stt, mb_login_cnt", array("mb_id"=>$arr['id']));   
                if( $userInfo['mb_stt'] != 2 ){
                    $result['result'] = "stateErr";
                    echo json_encode($result);
                    exit;
                }
                $value = array();
                $value['mb_last_login_dt'] = _DATE_YMDHIS;
                $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['mb_login_cnt'] = $userInfo['mb_login_cnt']+1;
                $res = $this->member->set($value,$userInfo['mb_id'],"value");
                $result['token'] = array(
                    'access' => $this->jwt->hashing(array("index" => $userInfo['mb_id'], "exp" => time()+($this->expiration))),
                    'refresh' => $this->jwt->hashing(array("index" => $userInfo['mb_id'], "exp" => time()+2*($this->expiration)))
                );
                $result['type'] = 'login';
            }
        }catch(Exception $e){
            $result['result'] = 'systemErr';
        }
        echo json_encode($result);
    }
    
    //JUST MAPPING UNIQUE USER ID(token.sub) WITH ALLDEAL DATABASE ( NOT USING OR AUTHORIZING TOKEN )
    function apple(){ 
        $result = 'success';
        try{            
            //data
            $hostId = $_POST['state'];
            $code = $_POST['code'];
            $tokens = decode($_POST['id_token']); 
            $user = !empty($_POST['user']) ? json_decode(str_replace('\\','',$_POST['user'])) : null; 
            $appleId = $tokens[1]->sub;
            $destination = 'https://alldeal.kr/Login?applelogin=error';
            $firstName = !empty($user->name->firstName) ? $user->name->firstName : null;
            $lastName = !empty($user->name->lastName) ? $user->name->lastName : null;
            $name = $lastName.$firstName;
            $email = !empty($user->email) ? $user->email : null;

            //check & login
            $row = $this->member->select("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt"," and mb_sns_id_2 = '{$appleId}' and pt_id = '{$this->shopId}'");
            if( $row['cnt'] < 1 ){ // if not member -> JOIN

                //generate secret key
                $privKey = openssl_pkey_get_private(file_get_contents('key/AuthKey_'.$this->appleKey.'.pem', true));
                $secret = generateJWT($this->appleKey, $this->appleTeam, $this->appleService, $privKey);

                //access_token request 
                $data = [
                    'client_id' => $this->appleService,
                    'client_secret' => $secret,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $this->redirect
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://appleid.apple.com/auth/token');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $serverOutput = curl_exec($ch);
                $output = json_decode($serverOutput,true);
                curl_close($ch);
                $refresh = $output['refresh_token'];

                $res = "CONTINUE";
                $sub = $this->jwt->hashing(array("sub" => base64_encode($appleId), "refresh" => base64_encode($refresh), "exp" => time()+($this->expiration)));                
                $destination = 'https://alldeal.kr/Login/Phone?res='.$res.'&sub='.$sub.'&name='.$name.'&email='.$email.(!empty($hostId)?"&hostId=$hostId":"");
            }else{
                //LOGIN
                if( $row['mb_stt'] != 2 || empty($row['mb_id'])){
                    $result['res'] = "FAILED";
                    echo json_encode($result);
                    exit;
                }    
                $res = "LOGIN";
                $memId = $row['mb_id'];
                $destination = 'https://alldeal.kr/Login/Phone?res='.$res.'&memId='.$memId;
            }

        }catch(Exception $e){
            $result['res'] = "FAILED";
            $result['error'] = $e;
            $destination = 'https://alldeal.kr/Login?applelogin=error';
        }
        header('Location:'.$destination);
        exit;
    }

    function appleConnect(){
        $result = array();
        $result['result'] = 'success';
        try{
            //UPDATE
            $info = $this->putData;
            $putParams = $info['params'];
            $appleToken = !empty($putParams['appleId']) ? $this->jwt->dehashing($putParams['appleId']) : null;
            $appleId = $appleToken ? base64_decode($appleToken['sub']) : null;

            $arr['id'] = $putParams['userId'];
            $arr['snsid2'] = $appleId;

            $updateResult = $this->member->set($arr, $arr['id']);
            if($updateResult != "000" && $updateResult != "001"){
                $result['result'] = 'updateErr';
                echo json_encode($result);
                exit;
            }
        }catch(Exception $e){
            $result['result'] = 'systemErr';
        }
        echo json_encode($result);
    }

    function vnoti(){
        $result = array();
        $result['result'] = 'success';
        $result['type'] = 'login';
        $result['nick'] = null;
        try{
            //init
            $post = $this->postData['params'];
            $encoded = $post['code'];

            //decode
            $secret = 'df6j9afxxtbxl16ofcjtiubn1jqme9rf';
            $iv = 'oywx885ouh2d3v84';
            $decoded = openssl_decrypt($encoded, 'aes-256-cbc', $secret, false, $iv);
            $decoded = json_decode($decoded);

            //data
            $id = $decoded->id;
            $cellphone = $decoded->cellphone;            
            $name = $decoded->name;
            $img = $post['img'];

            //check
            if(empty($id) || empty($cellphone) || empty($name) ||empty($img)){
                $result['result'] = 'failed';
                echo json_encode($result);   
                exit;
            }

            //member check
            $row = $this->member->select("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt"," and mb_sns_id_3 = '{$post['id']}' and pt_id = '{$this->shopId}'");

            // if not member
            if( $row['cnt'] < 1 ){ 
                //duplicate chk(phone)
                $phoneChk = $this->member->get("mb_id,mb_stt,pt_id,count(mb_id) as cnt", array("mb_cellphone"=>$cellphone, "pt_id"=>$this->shopId));   
                if( $phoneChk['cnt'] > 0 ){ // duplicate phone number
                    $result['result'] = "duplicate";
                    $result['vnotiId'] = $id;
                    $result['userId'] = $phoneChk['mb_id'];
                    $result['vtoken'] = $decoded->token;
                    echo json_encode($result);
                    exit;                       
                }                 
                
                //join
                //default values
                $result['type'] = 'join';
                $result['nick'] = $name;
                $birthDay = date("m-d"); //default birth : register day
                $birthYear = date("y")."-";
                $gender = 'm';
                $smsser = 'n';
                $emailser = 'n';

                $arr['cellphone'] = $cellphone;
                $arr['id'] = uniqid();
                $arr['passwd'] = uniqid();
                $arr['snsid3'] = $id; 
                $arr['shop'] = $this->shopId; 
                $arr['name'] = $name; 
                $arr['gender'] = $gender; 
                $arr['birth'] = "{$birthYear}{$birthDay}"; 
                $arr['img'] = $img;
                $arr['smsser'] = $smsser;
                $arr['emailser'] = $emailser;

                //add member
                $res = $this->member->add($arr);
                $row = $this->member->get("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt", array("mb_id"=>$arr['id']));
            }

            //login
            if( $row['mb_stt'] != 2 ){
                $result['result'] = "failed";
                echo json_encode($result);
                exit;
            }
            $value['mb_last_login_dt'] = _DATE_YMDHIS;
            $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
            $res = $this->member->set($value,$row['mb_id'],"value");

            $result['token'] = array(
                'access' => $this->jwt->hashing(array("index" => $row['mb_id'], "exp" => time()+($this->expiration))),
                'refresh' => $this->jwt->hashing(array("index" => $row['mb_id'], "exp" => time()+2*($this->expiration)))
            );
            $result['vtoken'] = $decoded->token;
            $result['result'] = "success";
        }catch(Exception $e){
            $result['result'] = 'systemErr';
        }        
        echo json_encode($result);
    }

    function vnotiConnect(){
        $result = array();
        $result['result'] = 'success';
        try{
            //UPDATE
            $info = $this->putData;
            $putParams = $info['params'];
            $arr['id'] = $putParams['userId'];
            $arr['snsid3'] = $putParams['vnotiId'];
            $updateResult = $this->member->set($arr, $arr['id']);
            if($updateResult != "000" && $updateResult != "001"){
                $result['result'] = 'updateErr';
                echo json_encode($result);
                exit;
            }else{
                //LOGIN
                $userInfo = $this->member->get("mb_id, mb_stt, mb_login_cnt", array("mb_id"=>$arr['id']));   
                if( $userInfo['mb_stt'] != 2 ){
                    $result['result'] = "stateErr";
                    echo json_encode($result);
                    exit;
                }
                $value = array();
                $value['mb_last_login_dt'] = _DATE_YMDHIS;
                $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['mb_login_cnt'] = $userInfo['mb_login_cnt']+1;
                $res = $this->member->set($value,$userInfo['mb_id'],"value");
                $result['token'] = array(
                    'access' => $this->jwt->hashing(array("index" => $userInfo['mb_id'], "exp" => time()+($this->expiration))),
                    'refresh' => $this->jwt->hashing(array("index" => $userInfo['mb_id'], "exp" => time()+2*($this->expiration)))
                );
                $result['type'] = 'login';
            }
        }catch(Exception $e){
            $result['error'] = $e;
            $result['result'] = 'systemErr';
        }
        echo json_encode($result);
    }    

    function randomName(){
        $front = ["미운", "고마운", "증오하는", "끔찍한", "무서운", "대단한", "게으른", "건방진", "열등한", "우수한"];
        $middle = ["검정", "흰", "빨간", "노란", "파란", "줄무늬", "점박이", "초록", "회색", "붉은", "하얀"];
        $rear = ["고양이", "뱀", "강아지", "호랑이", "코끼리", "토끼", "돼지", "나무늘보", "다람쥐", "사자"];
        return $front[array_rand($front)]." ".$middle[array_rand($middle)]." ".$rear[array_rand($rear)];
    }

    function roadshow(){
        $result = array();
        $result['result'] = 'success';
        $result['type'] = 'login';
        $result['nick'] = null;
        try{
            //init
            $post = $this->postData['params'];
            $encoded = $post['code'];

            //decode
            $secret = 'GYDKgkCz894mtQ4rO6qB8X0DeVgw0GUx';
            $iv = 'PczjonzNB8XAb8ji';
            $decoded = openssl_decrypt($encoded, 'aes-256-cbc', $secret, false, $iv);
            $decoded = json_decode($decoded);

            //data
            $id = $decoded->uuid;
            $cellphone = $decoded->cellphone;
            $name = $this->randomName();
            $img = $post['img'];

            //check
            if(empty($id) || empty($cellphone) ||empty($img)){
                $result['result'] = 'failed';
                echo json_encode($result);   
                exit;
            }

            //member check
            $row = $this->member->select("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt"," and mb_sns_id_4 = '{$id}' and pt_id = '{$this->shopId}'");

            // if not member
            if( $row['cnt'] < 1 ){ 
                //duplicate chk(phone)
                $phoneChk = $this->member->get("mb_id,mb_stt,pt_id,count(mb_id) as cnt", array("mb_cellphone"=>$cellphone, "pt_id"=>$this->shopId));   
                if( $phoneChk['cnt'] > 0 ){ // duplicate phone number
                    $result['result'] = "duplicate";
                    $result['snsId'] = $id;
                    $result['userId'] = $phoneChk['mb_id'];
                    echo json_encode($result);
                    exit;                       
                }                 
                
                //join
                //default values
                $result['type'] = 'join';
                $result['nick'] = $name;
                $birthDay = date("m-d"); //default birth : register day
                $birthYear = date("y")."-";
                $gender = 'm';
                $smsser = 'n';
                $emailser = 'n';

                $arr['cellphone'] = $cellphone;
                $arr['id'] = uniqid();
                $arr['passwd'] = uniqid();
                $arr['snsid4'] = $id; 
                $arr['shop'] = $this->shopId; 
                $arr['name'] = $name; 
                $arr['gender'] = $gender; 
                $arr['birth'] = "{$birthYear}{$birthDay}"; 
                $arr['img'] = $img;
                $arr['smsser'] = $smsser;
                $arr['emailser'] = $emailser;

                //add member
                $res = $this->member->add($arr);
                $row = $this->member->get("mb_id,mb_stt,pt_id,mb_passwd,mb_login_cnt,count(mb_id) as cnt", array("mb_id"=>$arr['id']));
            }

            //login
            if( $row['mb_stt'] != 2 ){
                $result['result'] = "failed";
                echo json_encode($result);
                exit;
            }
            $value['mb_last_login_dt'] = _DATE_YMDHIS;
            $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $value['mb_login_cnt'] = $row['mb_login_cnt']+1;
            $res = $this->member->set($value,$row['mb_id'],"value");

            $result['token'] = array(
                'access' => $this->jwt->hashing(array("index" => $row['mb_id'], "exp" => time()+($this->expiration))),
                'refresh' => $this->jwt->hashing(array("index" => $row['mb_id'], "exp" => time()+2*($this->expiration)))
            );
            $result['result'] = "success";
        }catch(Exception $e){
            $result['result'] = 'systemErr';
        }        
        echo json_encode($result);
    }

    function roadshowConnect(){
        $result = array();
        $result['result'] = 'success';
        try{
            //UPDATE
            $info = $this->putData;
            $putParams = $info['params'];
            $arr['id'] = $putParams['userId'];
            $arr['snsid4'] = $putParams['roadshowId'];
            $updateResult = $this->member->set($arr, $arr['id']);
            if($updateResult != "000" && $updateResult != "001"){
                $result['result'] = 'updateErr';
                echo json_encode($result);
                exit;
            }else{
                //LOGIN
                $userInfo = $this->member->get("mb_id, mb_stt, mb_login_cnt", array("mb_id"=>$arr['id']));   
                if( $userInfo['mb_stt'] != 2 ){
                    $result['result'] = "stateErr";
                    echo json_encode($result);
                    exit;
                }
                $value = array();
                $value['mb_last_login_dt'] = _DATE_YMDHIS;
                $value['mb_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['mb_login_cnt'] = $userInfo['mb_login_cnt']+1;
                $res = $this->member->set($value,$userInfo['mb_id'],"value");
                $result['token'] = array(
                    'access' => $this->jwt->hashing(array("index" => $userInfo['mb_id'], "exp" => time()+($this->expiration))),
                    'refresh' => $this->jwt->hashing(array("index" => $userInfo['mb_id'], "exp" => time()+2*($this->expiration)))
                );
                $result['type'] = 'login';
            }
        }catch(Exception $e){
            $result['error'] = $e;
            $result['result'] = 'systemErr';
        }
        echo json_encode($result);
    }         
}