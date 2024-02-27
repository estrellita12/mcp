<?php
namespace application\models;

use \Exception;

require_once _LIB.'/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class Mailer{
    private $arr;

    public function send($arr){
        $this->arr = $arr;
        return $this->googleSend();
    }

    public function googleSend( ){
        try{
            $senderName = iconv( "UTF-8","EUC-KR",$this->arr['senderName']);
            $userName = iconv( "UTF-8","EUC-KR",$this->arr['userName']);
            $mailer = new PHPMailer(true);
            $mailer->isSMTP();
            $mailer->Host = "smtp.gmail.com";
            $mailer->SMTPAuth = true;
            $mailer->Port = 587;
            $mailer->SMTPSecure = "TLS";
            $mailer->Username = 'choimr@majorworld.co.kr';
            $mailer->Password = 'ldqyvdlzkvbxkcuw';
            if( empty($this->arr['senderEmail']) ) $this->arr['senderEmail'] = 'choimr@majorworld.co.kr';
            $mailer->setFrom($this->arr['senderEmail'],$senderName);
            $mailer->IsHTML(true);
            $mailer->Encoding = "base64";
            $mailer->CharSet = "euc-kr";
            $mailer->addAddress($this->arr['userEmail'],$userName);
            $mailer->Subject = iconv( "UTF-8","EUC-KR//TRANSLIT",$this->arr['title'] );
            $mailer->Body    = iconv( "UTF-8","EUC-KR//TRANSLIT",stripslashes($this->arr['content']) );
            $res = $mailer->send();
            return array("code"=>$res==1?"000":"006","message"=>$res);
        }catch(Exception $e){
            debug_log( static::class,"006",array($this->arr) ); 
            return "006";
        }
    }


}
