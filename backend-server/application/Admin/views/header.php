<?php 
if(!defined('_INNER')) exit;
require_once _VIEW."/head.php"; 

$activeDepth1=array();

$search = array();
$search['code_length_eq'] = 2;
$search['use_yn'] = "y";
$search['col'] = "orderby";
$search['show_grade_then_ge'] = $_SESSION['user_grade'];
$depth1 = $this->gnb->get("*",$search,true);
?>
<div id="container" class="padt90">
    <header id="hd">
        <div id="hd_wrap">
            <div id="logo"><a href="<?=_URL?>/Main">MCP Administrator</a></div>
            <div id="tnb">
                <ul>
                    <li><a href="">관리자메뉴얼</a></li>
                    <li><a href="/Main">관리자홈</a></li>
                    <li id="tnb_logout"><a href="/Login/logout">로그아웃</a></li>
                </ul>
            </div>
        </div>
    </header>
    <nav id="gnb">
        <ul id="gnb_wrap">
            <?php 
            foreach( $depth1 as $item ){ 
            $active = false;
            if( isset($this->tabPageInfo['tab']) && $this->tabPageInfo['tab'] == $item['tab'] ){
            $activeDepth1 = $item;
            $flag = true;
            }
            if( !isset($_SESSION[$item['tab']]) && $_SESSION['user_id']!='admin' ) continue;
            ?>
            <li class="gnb_list <?= $this->tabPageInfo['tab'] == $item['tab'] ? "active": ""  ?>" >
            <a href="<?=$item['url']?>"><?=$item['name']?></a>
            </li>
            <?php } ?>
        </ul>
    </nav>

