<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

define('_COLOR', '#00b8d2');

define('_APPDIR', 'application/Seller/');
require_once $_SERVER['DOCUMENT_ROOT'].'/backend-server/common.php';
new application\Seller\Route();
?>
