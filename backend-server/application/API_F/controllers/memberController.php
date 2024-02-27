<?php
namespace application\API_F\controllers;

class memberController extends Controller 
{
    function init(){ 
        $this->temp();
        $this->member = new \application\models\MemberModel();
        $this->col = "*";
        $this->kakaoAdmin = "6485dc728dcd7c18456984820e505c66";
    }

    function get(){
        $id = $this->param['ident'];
        echo json_encode($this->member->get("*", array("mb_id"=>$id)));
    }

    function connectCheck(){
        $msg = "success";
        $data = null;
        $channelList = array(
            "roadshow" => 4
        );        
        try{
            $channelName = $this->param['ident'];
            $channelCode = $channelList[$channelName];
            $uuid = $_REQUEST['uuid'];
    
            if(empty($channelCode)) $msg = "invalid channel name";
            if(empty($uuid)) $msg = "empty uuid";
            if($msg == "success"){
                $data = $this->member->get("mb_name as name, mb_cellphone as cellphone", array("mb_sns_id_$channelCode" => $uuid));
                if(empty($data)) $msg = "not member";
                else if($data == "002") $msg = "code error";
            }
        }catch(Exception $e){
            $msg = "error";
        }
        echo json_encode(array("message" => $msg, "data" => $data));
    }

    function getList(){
        echo json_encode($this->member->getList());
    }

    function set(){
        $token = $this->accessInfo;
        $info = $this->putData;
        echo json_encode($this->member->set($info['params'], $token['index']));
    }    

    function point(){ //both plus and minus
        $response = array("res" => "success");
        $params = $this->putData;
        try{
            //init
            $userId = empty($params['id']) ? $this->accessInfo['index'] : $params['id'];
            $type = $params['type'];
            $amount = 0;
            
            //switch
            if($type == "join"){
                $amount = 500;
                $memberLeave = new \application\models\MemberLeaveModel(); // condition chk 
                $leaveChk = $memberLeave->get("*", array("mb_cellphone"=>$params["phone"]));
                if(!empty($leaveChk)) exit;
            }
            if($type == "invite"){
                $amount = 1000;
                $memberLeave = new \application\models\MemberLeaveModel(); // condition chk 
                $leaveChk = $memberLeave->get("*", array("mb_cellphone"=>$params["phone"]));
                if(!empty($leaveChk)) exit;
            } 
            if($type == "attend"){
                $amount = 100;
                // condition chk 
                $attendChk = $this->member->get("mb_daily_attend", array("mb_id"=>$userId));
                if(empty($attendChk)){
                    $response['res'] = "not";
                    echo json_encode($response);
                    exit;
                }
                if($attendChk["mb_daily_attend"] && $attendChk["mb_daily_attend"] > _DATE_YMD){
                    $response['res'] = "already";
                    echo json_encode($response);                    
                    exit;
                }
                //update attendance
                $attendUpdate = $this->member->set(array("dailyAttend"=>_DATE_YMDHIS), $userId);
                if($attendUpdate != "000"){
                    $response['res'] = "failed";
                    echo json_encode($response);                    
                    exit;
                }
            } 
            
            //execute
            if($amount > 0) $result = $this->member->savePoint($userId,$amount,$type);
            if($amount < 0) $result = $this->member->usePoint($userId,$amount*-1,$type);
            $response['amount'] = $amount;

            if($result != "000") $response['res'] = "failed";
        }catch(Exception $e){
            $response['res'] = "systemErr";
        }
        echo json_encode($response);
    }

    function setNewPhone(){
        $res = "success";
        try{
            //init
            $info = $this->putData;
            $putParams = $info['params'];
            $user = $this->jwt->dehashing($putParams['memberToken']);

            //duplicate Chk
            $_REQUEST['shop'] = $this->shopId;
            $_REQUEST['srch'] = 'cellphone';
            $_REQUEST['kwd'] = $putParams['cellphone'];
            $memberChk = $this->member->getList();
            if(count($memberChk)){
                $res = "phoneAlready";
            }else{
            //exec
                $updateResult = $this->member->set($putParams, $user['userId']);
                if($updateResult != "000" && $updateResult != "001") $res = "updateErr";
            } 
        }catch(Exception $e){
            $res = "systemErr";
        }
        echo json_encode($res);
    }    

    function remove(){
        $res = 'success';
        try{
            //sessionChk
            if(empty($this->accessInfo)) {
                echo json_encode('sessionErr');
                exit;
            }

            //memberId
            $selfId = $this->accessInfo['index'];
            $selfInfo = $this->member->get( 'mb_sns_id_1, mb_apple_refresh, mb_cellphone', array("mb_id"=>$selfId) );

            //identify Chk
            if($selfId != $this->param['ident']){
                echo json_encode('identifyErr');
                exit;
            }

            //delete member
            $arr = array(
                "id"=>$selfId,
                "shop"=>$this->shopId,
                "reason"=>'자발적 탈퇴',
                "cellphone"=>$selfInfo['mb_cellphone']
            );
            $deleted = $this->member->leave($selfId,$arr);
            if($deleted != '000'){
                $res = 'delete Err';
            }else{
                //break team
                $this->teamOrder = new \application\models\OrderTeamModel();
                $teamBroken = $this->teamOrder->memberBreak($selfId);
                if($teamBroken != "000" && $teamBroken != "001") $res = 'teamErr';
                
                //order team reset
                $this->order = new \application\models\OrderModel();
                $orderReset = $this->order->resetTeam($selfId);
                if($orderReset != "000" && $orderReset != "001") $res = 'orderErr';

                //delete billing
                $this->memberBilling = new \application\models\MemberBillingModel();
                $billingDeleted = $this->memberBilling->removeMember($selfId);
                if($billingDeleted != "000" && $billingDeleted != "001") $res = 'billingErr';

                //delete address                
                $this->memberAddress = new \application\models\MemberAddressModel();
                $addressDeleted = $this->memberAddress->removeMember($selfId);
                if($addressDeleted != "000" && $addressDeleted != "001") $res = 'addressErr';

                //delete review   
                $this->review = new \application\models\GoodsReviewModel();
                $reviewDeleted = $this->review->removeMember($selfId);
                if($reviewDeleted != "000" && $reviewDeleted != "001") $res = 'reviewErr';

                //delete wish
                $this->wish = new \application\models\GoodsWishModel();
                $wishDeleted = $this->wish->removeMember($selfId);
                if($wishDeleted != "000" && $wishDeleted != "001") $res = 'wishErr';
            } 

            //kakao unlink
            if(!empty($selfInfo['mb_sns_id_1'])){
                $url = 'https://kapi.kakao.com/v1/user/unlink';
                $curlHandle = curl_init($url);

                $data =  array(
                    "target_id_type"=>"user_id",
                    "target_id"=>$selfInfo['mb_sns_id_1'],
                );
                curl_setopt_array($curlHandle, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: KakaoAK ' . (!empty($_REQUEST['kakaoAdmin']) ? $_REQUEST['kakaoAdmin'] : $this->kakaoAdmin),
                        'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                    ),
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ]);
                $response = curl_exec($curlHandle);
                $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
                if( $httpCode!="200" ) $res = $response;
                curl_close($curlHandle);
            }

            //apple unlink
            if(!empty($selfInfo['mb_apple_refresh'])){
                //token
                $refresh = $selfInfo['mb_apple_refresh'];

                //generate secret key
                $privKey = openssl_pkey_get_private(file_get_contents('key/AuthKey_'.$this->appleKey.'.pem', true));
                $secret = generateJWT($this->appleKey, $this->appleTeam, $this->appleService, $privKey);

                //access_token request 
                $data = [
                    'client_id' => $this->appleService,
                    'client_secret' => $secret,
                    'token' => $refresh,
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://appleid.apple.com/auth/revoke');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $serverOutput = curl_exec($ch);
                curl_close($curlHandle);
            }

        }catch(Exception $e){
            $res = 'systemErr';
        }
        echo json_encode($res);        
    }
    
}
