<?php

namespace application\models;

class Messenger
{

function __construct(){
}

function test1(){
    return 'test';
}
//    jwt 발급하기
function sendTest(){
    $url = "https://munjaro.net:443/apis/send";
    /*
    $data = "
        key=Dldydgns77!& 
        user_id=leeyh&sender=025114560&
        receiver=01045961458&
        destination=01045961458|김현중&
        sg=test입니다.&
        title=test.
    ";
    */ 
    
    $data = array(
        "key" => "Dldydgns77!",
        "user_id" => "leeyh",
        "sender" => "025114560",
        "receiver" => "01045961458",
        "destination" => "01045961458|김현중",
        "msg" => "test입니다.",
        "title" => "test"        
    );
    
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url); // 연결 URL
//    curl_setopt($ch, CURLOPT_PORT, 443); 
    curl_setopt($ch, CURLOPT_POST, true); // POST로 전송
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 반환값 문자열로 반환
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // POST로 전송할 Data
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $error_msg = 0;
    $info_msg = 0;
    $res = curl_exec($ch);
    if(curl_errno($ch)) $error_msg = curl_error($ch);
    if(curl_getinfo($ch)) $info_msg = curl_error($ch);
    curl_close($ch);
    return array(
        $error_msg,
        $info_msg,
        $res,
        '1'
    );
}

    /*
    protected $alg;
    protected $secret_key;

//    생성자
    function __construct()
    {
        //사용할 알고리즘
        $this->alg = 'sha256';

        // 비밀 키
        $this->secret_key = "your secret key";
    }

//    jwt 발급하기
    function hashing(array $data): string
    {
        // 헤더 - 사용할 알고리즘과 타입 명시
        $header = json_encode(array(
            'alg' => $this->alg,
            'typ' => 'JWT'
        ));

        // 페이로드 - 전달할 데이터
        $payload = json_encode($data);

        // 시그니처
        $signature = hash($this->alg, $header . $payload . $this->secret_key);

        return base64_encode($header . '.' . $payload . '.' . $signature);
    }

//    jwt 해석하기
    function dehashing($token)
    {
        // 구분자 . 로 토큰 나누기
        $parted = explode('.', base64_decode($token));

        $signature = $parted[2];

        // 토큰 만들 때처럼 시그니처 생성 후 비교
        if (hash($this->alg, $parted[0] . $parted[1] . $this->secret_key) != $signature) {
            return "시그니쳐 오류";
        }

        // 만료 검사
        $payload = json_decode($parted[1], true);
        if ($payload['exp'] < time()) { // 유효시간이 현재 시간보다 전이면
            return "만료 오류";
        }
        return json_decode($parted[1], true);
    }
    */
}
?>

