<?php
include_once("../common.php");
$code = empty($_REQUEST['code'])?"seller_main":$_REQUEST['code'];
if( empty($_SESSION['is_seller']) ) move("/bbs/login.php");
?>
<html lang="ko">
    <head>
        <title>공급사 관리자 페이지</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no,user-scalable=no,viewport-fit=cover">
        <link rel="stylesheet" type="text/css" href="/public/css/seller.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <script src="/public/js/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    </head>
    <body>
        <div id="container" class="padt50">
            <header id="hd">
                <div id="hd_wrap">
                    <div id="logo"><a href="http://sbnet.customdx.kr/index.php">MCP SELLER</a></div>
                    <div id="tnb">
                        <ul>
                            <li><a href="/index.php">홈</a></li>
                            <li id="tnb_logout"><a href="/bbs/logout.php">로그아웃</a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <?php include_once("./{$code}.php"); ?>
        </div>
    </body>
</html>
