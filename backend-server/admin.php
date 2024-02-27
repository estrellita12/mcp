<?php
if($_SERVER['REMOTE_ADDR'] = "58.231.24.148"){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
define('_COLOR', '#1f2a40');
define('_APPDIR', 'application/Admin/');
require_once $_SERVER['DOCUMENT_ROOT'].'/backend-server/common.php';

new application\Admin\Route();
?>
