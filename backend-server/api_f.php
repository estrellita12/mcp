<?php
$httpOrigin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
if(in_array($httpOrigin, [
    'http://58.229.163.244:3000', // Dev Client Server using CORS
    'http://58.229.163.244',
    'http://58.124.40.193',
    'http://majorworld.shop:3000', // Dev Client Server using CORS
    'http://211.37.174.67:3000',
    'http://211.37.174.67',
    'http://172.20.100.100:3000', // AllDeal Test Server2
    'http://ethanklocked.cafe24.com:3000', // AllDeal Test domain
    'https://www.alldeal.kr', // AllDeal real domain
    'http://127.0.0.1',
    'http://127.0.0.1:3000',
    'http://localhost:3000'
])) header("Access-Control-Allow-Origin: ${httpOrigin}");
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token');
header('Access-Control-Allow-Headers: authorization, refreshtoken, client-security-token');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
define('_APPDIR', 'application/API_F/');
//require_once $_SERVER['DOCUMENT_ROOT'].'/backend-server/common.php';
require_once '/var/www/html/my-custom-platform/backend-server/common.php';


// 객체 생성 요청시 해당 클래스에 대한 내용을 위에 정의한 함수에 의해 찾아낸다
new application\API_F\Route();
?>
