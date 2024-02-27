<?php require_once('../common.php'); ?>
<html lang="ko">
<head>
<title>공급사 관리자 페이지</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no,user-scalable=no,viewport-fit=cover">
<link rel="stylesheet" type="text/css" href="/public/css/seller.css">
</head>
<body>
<div id="login_wrap">
    <div class="login_header">
        <img src="/public/img/mw-logo.png">
    </div>
    <div class="intro">
        <section class="around">
            <div class="intro_text"> 
                <h2>
                    안녕하세요<br>e-commerce의 모든 것<br><span class="company"><span>메이저월드</span> 입니다.</span>
                </h2>
                <div class="smile"><img src="/public/img/smile-pc.png" alt="smlie"></div>
            </div>
            <div class="login_inner"> 
                <div class="mtxt">판매자 로그인</div>
                <form action="http://<?=_HOST?>/bbs/login_check.php" method="POST">
                    <div>
                        <label for="login_id" class="sound_only">회원아이디</label>
                        <input type="text" name="mb_id" id="login_id" class="frm_input" maxlength="20" placeholder="아이디 입력">
                    </div>
                    <div>
                        <label for="login_pw" class="sound_only">비밀번호</label>
                        <input type="password" name="mb_password" id="login_pw" class="frm_input" maxlength="20" autocomplete="on" placeholder="비밀번호 입력">
                    </div>
                    <div><input type="submit" class="btn_large btn_black" value="로그인"></div>
                </form>
            </div>
        </section>
    </div>
    <div class="cont1">
        <section class="around">
            <div class="txt tac">
                <h3>10년이란 시간 동안</h3>
                <p><mark class="min">메이저라는 이름의 무게를 생각하며</mark><br>
                이커머스 시장의 선두주자가 되기위해<br>
                끊임없이 노력하고 있습니다.</p>
            </div>
            <div class="img"><img src="/public/img/city_pc.png"></div>
        </section>
    </div>
    <div class="cont2">
        <section>
            <div class="txt">
                <p><b>그 결과,</b> 온라인 커머스의 강자답게<br> 10년간 유통기술 투자로 연속 성장세를 이어 업계 1위<b>e-commerce 전문회사</b>가 되었습니다.</p>
            </div>
            <div class="graph"><img src="/public/img/graph.png"></div><!-- graph -->
        </section>
    </div>
    <div class="cont3">
        <div class="txt tac">
            <h4>직접 운영 및 자가 물류센터</h4>
            <h1>총합 5,000평 이상 확보</h1>
        </div>
        <img src="/public/img/cont3-bg-pc.jpg">
    </div>
    <div class="cont4">
        <section>
            <h4>메이저월드는</h4>
            <h3 class="ybox tac">타 대행사와는 차별화된<br>이커머스 전문 토탈 서비스</h3>
            <h4>를 제공합니다.</h4>
        </section>
    </div>
</div>
<footer id="ft">
    <p>Copyright © 엠더블유홀딩스(주). All rights reserved.</p>
</footer>
</body>
</html>
