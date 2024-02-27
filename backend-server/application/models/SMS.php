<?php
namespace application\models;

use \Exception;

class SMS{
    private $sms_url; 
    private $user_id;
    private $user_key;
    private $sender;

    public function send($arr,$test="N"){
        return $this->kpmobile($arr,"N");
    }

    public function kpmobile($arr,$test="N"){
        try{
            $this->sms_url = "https://munjaro.net/apis/send/";
            /*
            $this->user_id = "mwomcp";
            $this->user_key = "major0111!";
            $this->sender = "0264261235";
            */
            $this->user_id = "mwodeal";
            $this->user_key = "major0111!";
            $this->sender = "15449332";

            $sms = array();
            $sms['key'] = $this->user_key;
            $sms['user_id'] = $this->user_id;
            $sms['sender'] = $this->sender;
            $sms['receiver'] = $arr['userCellphone'];
            $sms['msg'] = $arr['content'];
            //$sms['title'] = "";
            //$sms['destination'] = "";
            //$sms['rdate'] = "";
            //$sms['rtime'] = "";
            //$sms['image'] = "";
            $sms['testmode_yn'] = $test;
            $ch = curl_init();                                 //curl 초기화
            curl_setopt($ch, CURLOPT_URL, $this->sms_url);               //URL 지정하기
            curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환 
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
            curl_setopt($ch, CURLOPT_POSTFIELDS, $sms);       //POST data
            $result = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($result,true);
            return array("code"=>$data['result_code']==1?"000":"007","message"=>$result);
        }catch(Exception $e){
            debug_log( static::class,__method__,"007",array("sms"=>$sms,"result"=>$result) ); 
            return "006";
        }

    }
}
