<?php
require_once('/var/www/html/my-custom-platform/sabangnet/common.php');
sbnet_log("/bbs/login_check.php",array_merge($_POST,$_FILES));

$sellerModel=new \application\models\SellerModel();

$mb_id = trim($_POST['mb_id']);
$mb_password = trim($_POST['mb_password']);

if(!$mb_id || !$mb_password)
    alert('회원아이디나 비밀번호가 공백이면 안됩니다.');


if( !empty($_REQUEST['url']) ) {
    $url = $_REQUEST['url'];
    $link = urldecode($url);
    if (preg_match("/\?/", $link))
        $split= "&amp;";
    else
        $split= "?";

    $post_check_keys = array('mb_id', 'mb_password', 'x', 'y', 'url', 'slr_url');
    foreach($_POST as $key=>$value) {
        if ($key && !in_array($key, $post_check_keys)) {
            $link .= "$split$key=$value";
            $split = "&amp;";
        }
    }
} else  {
    $link =  "http://"._HOST."/mypage/page.php?code=seller_main";
}

$res = $sellerModel->login($mb_id,$mb_password);
if($res=="000"){
    set_session('ss_mb_id', $mb_id);
    set_session('ss_mb_passwd', $mb_password);
}

goto_url($link);

?>


