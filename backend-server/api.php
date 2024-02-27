<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$httpOrigin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : null;
if (in_array($httpOrigin, [
    'http://127.0.0.1:3000',
    'http://127.0.0.1',
    'http://58.124.40.193:3000',
    'http://58.124.40.193',
    'http://majorworld.shop:3001',
    'http://majorworld.shop', 
    'http://www.majorworld.shop:3001',
    'http://www.majorworld.shop', 
    'http://choi.majorworld.shop:3001',
    'http://choi.majorworld.shop',
    'http://moon.majorworld.shop:3001',
    'http://moon.majorworld.shop',
    'http://an.majorworld.site:3000',
    'http://an.majorworld.site',
    'http://choi.majorworld.site:3001',
    'http://choi.majorworld.site',
    'http://211.37.174.67:3000',
    'http://211.37.174.67'
])) header("Access-Control-Allow-Origin: {$httpOrigin}");
//header("Access-Control-Allow-Origin: {$httpOrigin}");
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token');
header('Access-Control-Allow-Headers: authorization, client-security-token');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

define('_APPDIR', 'application/API/');
require_once $_SERVER['DOCUMENT_ROOT'].'/backend-server/common.php';
new application\API\Route();
?>
