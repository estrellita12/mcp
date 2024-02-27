<?php
namespace application\API\controllers;

class authController extends Controller{
    function init(){}
    function token(){
        $enc = new \application\models\EncryptToken();
        $arr = array(
            'exp' => time() + (360 * 30), // 만료기간
            'iat' => time(), // 생성일
            'is_auth' => "1",
            'shop_id' => $this->shopId,
            'shop_name' => $this->shopName,
            'shop_grade' => $this->shopGrade,
            'shop_use_ctg' => $this->shopUseCtg
        );
        $token = $enc->encrypt($arr);
        return $token;
    }

    function refresh(){
        $res = "000";
        try{
            $httpHost = $_SERVER['HTTP_HOST'];
            $partner = new \application\models\PartnerModel();
            $row = $partner->get( "pt_id, pt_name, pt_grade, shop_use_ctg", array("shop_url"=>$httpHost) );
            if( empty($row) ) exit;

            $this->shopId = $row['pt_id'];
            $this->shopName = $row['pt_name'];
            $this->shopGrade = $row['pt_grade'];
            $this->shopUseCtg = unserialize($row['shop_use_ctg']);
            $token = $this->token();

            $_SESSION['token'] = $token;
            $arr = array("result"=>$res, "token"=>$token);
            echo json_encode($arr);
        }catch(Exception $e){
            $arr = array("result"=>"500", "error"=>$e);
            echo json_encode($arr);
        }
    }
}

