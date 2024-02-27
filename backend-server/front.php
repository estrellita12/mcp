<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();
$httpOrigin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
if (in_array($httpOrigin, [
    'http://127.0.0.1:3001',
    'http://127.0.0.1',
    'http://58.124.40.193:3001',
    'http://58.124.40.193',
    'http://211.37.174.67:3001',
    'http://211.37.174.67',
    'http://211.45.162.45',
    'http://211.45.162.45:3001',
    'http://www.majorworld.site:3001',
    'http://www.majorworld.site', 
    'http://127.0.0.1:3000',
    'http://localhost:3000',
    'http://172.20.100.43:3000',
])) header("Access-Control-Allow-Origin: {$httpOrigin}");
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token');
//header('Access-Control-Allow-Headers: authorization, client-security-token');
//header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

define('_APPDIR', 'application/Front/');
require_once $_SERVER['DOCUMENT_ROOT'].'/backend-server/common.php';
new application\Front\Route();
?>
