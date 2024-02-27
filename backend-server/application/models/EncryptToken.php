<?php
namespace application\models;

class EncryptToken{
    protected $alg;
    protected $secret_key;

    function __construct(){
        $this->alg = 'AES-256-CBC';
        $this->secret_key = "majorworld0811";
    }

    function encrypt(array $data): string{
        $arr = array(
            "isAuth"=>"",
            "shopId"=>"",
            "shopName"=>"",
            "shopGrade"=>"",
            "shopUseCtg"=>"",
            "userId"=>"",
            "userName"=>"",
            "userGrade"=>"",
        );
        $arr['isAuth'] = $data['isAuth'];
        if( !empty($data['shopId']) ) $arr['shopId'] = $data['shopId'];
        if( !empty($data['shopName']) ) $arr['shopName'] = $data['shopName'];
        if( !empty($data['shopGrade']) ) $arr['shopGrade'] = $data['shopGrade'];
        if( !empty($data['shopUseCtg']) ) $arr['shopUseCtg'] = $data['shopUseCtg'];
        if( !empty($data['userId']) ) $arr['userId'] = $data['userId'];
        if( !empty($data['userName']) ) $arr['userName'] = $data['userName'];
        if( !empty($data['userGrade']) ) $arr['userGrade'] = $data['userGrade'];


        $payload = json_encode($arr);
        $enc = openssl_encrypt($payload, 'aes-256-cbc', $this->secret_key, true, str_repeat(chr(0), 16));
        return base64_encode($enc);
    }

    function decrypt($token){
        $data = base64_decode($token);
        $dec = openssl_decrypt($data, 'aes-256-cbc', $this->secret_key, true, str_repeat(chr(0), 16));
        return json_decode($dec,true);
        /*
        // 만료 검사
        $payload = json_decode($parted[1], true);
        if ($payload['exp'] < time()) { // 유효시간이 현재 시간보다 전이면
            return "EXPIRED";
        }
        */
    }
}
?>

