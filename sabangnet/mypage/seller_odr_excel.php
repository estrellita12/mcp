<?php
include_once("/var/www/html/my-custom-platform/sabangnet/common.php");
sbnet_log("/mypage/seller_odr_excel.php",$_REQUEST);

if( empty($_SESSION['user_id']) ){
    access("로그인한 회원만 접근 가능합니다.",_URL);
}

$orderModel = new \application\models\OrderModel();
$search = array();
$search["sl_id"] = $_SESSION['user_id'];
$search["od_stt_then_ge"] = "1";
if( $_REQUEST['code'] ){
    $code = substr($_REQUEST['code'],-1);
    $search["od_stt"] = $code;
}
$rowAll = $orderModel->get("*",$search,true);

include_once("/var/www/html/my-custom-platform/sabangnet/mypage/seller_odr_excel.sub.php");
?>
