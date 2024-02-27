<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

define('_COLOR', '#4046f4');

define('_APPDIR', 'application/Partner/');
require_once $_SERVER['DOCUMENT_ROOT'].'/backend-server/common.php';
new application\Partner\Route();
?>
