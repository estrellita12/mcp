<?php

$servername = "localhost";
$user = "acm";
$password = "acm0419!!";
$dbname = "custom";

$connect = mysqli_connect($servername, $user, $password,$dbname);
if (!$connect) {
    die("서버와의 연결 실패! : ".mysqli_connect_error());
}
$sql = "SELECT shop_pc_theme, shop_m_theme FROM web_partner WHERE pt_id = 'alldeal'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    header('HTTP/1.1 307 Temporary move');
}

if($row['shop_pc_theme']=="Basic"){
    //header('Location: /Basic/'.$_GET);
    require( './Basic/index.html');
    //require( './Basic/'.$_GET['url'] );
    //require( './Basic/index.html' );
}

?>
