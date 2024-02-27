<?php if(!defined('_INNER')) exit; ?>
<?php require_once _VIEW."/head.php"; ?>

<!-- header 시작 { -->
<header id="hd">
    <div id="hd_wrap">
        <div id="logo"><a href="<?=_URL?>/Main"><img src="/public/img/admin_logo.gif" alt="관리자"></a></div>
        <div id="tnb">
            <ul>
                <li><a href="">관리자메뉴얼</a></li>
                <li><a href="">관리자정보</a></li>
                <li><a href="/Main">관리자홈</a></li>
                <li><a href="/Setting/shoppingMall">쇼핑몰</a></li>
                <li id="tnb_logout"><a href="/Login/logout">로그아웃</a></li>
            </ul>
        </div>
    </div>
</header>
<!-- } header 끝 -->

<!-- nav 시작 { -->
<nav id="gnb">
    <ul id="gnb_wrap">
        <?php foreach($this->gnb->getDepthList(1) as $item){ ?>
        <li class="gnb_list <?= ( $preTab['tab'] ) == $item['tab'] ? "active": ""  ?>" >
            <a href="<?=$item['url']?>"><?=$item['name']?></a>
        </li>
        <?php } ?>
    </ul>
</nav>
<!-- } nav 끝 -->

<!-- container 시작 { -->
<div id="container">


