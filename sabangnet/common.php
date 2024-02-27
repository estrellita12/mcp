<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('_APPDIR', '/var/www/html/my-custom-platform/');
define('_COLOR', '#00b8d2');
require_once '/var/www/html/my-custom-platform/backend-server/application/libs/config.php';
require_once '/var/www/html/my-custom-platform/backend-server/application/libs/common.lib.php';

function goto_url($url){
    echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
    echo "<script type='text/javascript'>location.replace('{$url}');</script>";
    exit;
}

function sbnet_log($page="",$e=""){
    $file = "/var/www/html/my-custom-platform/log/sbnet_"._DATE_YMD.".txt";
    $arr['DATE'] = _DATE_YMDHIS;
    $arr['Page'] = $page;
    $arr['Exception'] = $e;
    error_log(print_r($arr,true) ,3, $file);
}
require_once('/var/www/html/my-custom-platform/backend-server/application/models/Model.php');
require_once('/var/www/html/my-custom-platform/backend-server/application/models/UploadImage.php');
require_once('/var/www/html/my-custom-platform/backend-server/application/models/ConfigModel.php');
require_once('/var/www/html/my-custom-platform/backend-server/application/models/DefaultModel.php');
require_once("/var/www/html/my-custom-platform/backend-server/application/models/GoodsModel.php");
require_once("/var/www/html/my-custom-platform/backend-server/application/models/GoodsOptionModel.php");
require_once("/var/www/html/my-custom-platform/backend-server/application/models/SellerModel.php");
require_once("/var/www/html/my-custom-platform/backend-server/application/models/OrderModel.php");
require_once("/var/www/html/my-custom-platform/backend-server/application/models/OrderNoModel.php");
require_once("/var/www/html/my-custom-platform/backend-server/application/models/TemplateModel.php");
require_once("/var/www/html/my-custom-platform/backend-server/application/models/UpdateLogModel.php");
?>
