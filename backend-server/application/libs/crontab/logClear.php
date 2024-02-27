<?php
define('_APPDIR', 'application/Admin/');
define('_DOCUMENT_ROOT',"/var/www/html/my-custom-platform/backend-server/");
//require_once _DOCUMENT_ROOT.'common.php';
require_once '/var/www/html/my-custom-platform/backend-server/application/libs/config.php';
require_once '/var/www/html/my-custom-platform/backend-server/application/models/Model.php';

function debug_log($class,$method,$res,$e=''){
    $file = "/var/www/html/my-custom-platform/log/crontab_"._DATE_YMD.".txt";
    $arr['DATE'] = _DATE_YMDHIS;
    $arr['ClassName'] = $class;
    $arr['MethodName'] = $method;
    $arr['ErrorCode'] = $res;
    $arr['Exception'] = $e;
    error_log(print_r($arr,true) ,3, $file);
}

// 예약 일시 > 매월 20일
$new_tb_nm = date("Ym",  strtotime("-25 days") ); // 2023.03.20 -> 202302
$del_date = date("Y-m-01", _SERVER_TIME); // 2023.03.20 -> 2023-03-01
$model = new \application\models\Model();

$sql_where = " log_reg_dt <= str_to_date('{$del_date}', '%Y-%m-%d')";
$sql = "create table if not exists web_update_log_{$new_tb_nm} (select * from web_update_log where {$sql_where} )";
$model->execute($sql);
$sql = "delete from web_update_log where {$sql_where}";
$model->execute($sql);

$sql_where = " od_dt <= str_to_date('{$del_date}', '%Y-%m-%d') and od_stt = 0 ";
$sql = "delete from web_order where {$sql_where}";
$model->execute($sql);
$sql = "delete from web_order_no where {$sql_where}";
$model->execute($sql);

//$row = $model->selectAll("*",$sql);
//print_r($row);
?>
