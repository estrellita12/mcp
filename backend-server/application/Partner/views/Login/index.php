<div id="login_wrap">
    <div class="login_header">
        <div class="logo_box">
            <img src="/public/img/mw-logo.png">
        </div>
        <ul>
            <li id="qa_link"><a><img src="/public/img/icon/envelope.png" width="16">가입문의</a></li>
            <li id="login_link"><a><img src="/public/img/icon/user.png" width="16">로그인</a></li>
            <li id="join_link"><a><img src="/public/img/icon/edit.png" width="16">신청하러가기</a></li>
        </ul>
        <div id="login_inner">
            <div class="title">로그인</div>
            <form action="/Login/loginCheck" method="POST">
                <input type="text" name="id" id="login_id" class="frm_input" maxlength="20" placeholder="아이디 입력">
                <input type="password" name="passwd" id="login_pw" class="frm_input" maxlength="20" autocomplete="on"  placeholder="비밀번호 입력">
                <input type="submit" class="btn_large btn_theme" value="로그인">
            </form>
        </div>

    </div>
    <div class="intro"></div>
    <div class="login_wrap">
        <div id="cont1" class="cont">
            <section>
                <div class="txt">
                    <p><span>아직도 <b>협찬</b>만 받고 광고비 받고 끝?</span></p>
                    <p><mark>꾸준하게 벌 수 있는데?</mark></p>
                </div>
                <br>
                <div>
                    <img src="/public/img/partner_bg_img1.png">
                </div>
            </section>
        </div>
        <div id="cont2" class="cont">
            <section class="around">
                <div class="txt">
                    <h1><span>커스터마이징 쇼핑몰 솔루션</span></h1>
                    <p><span><b>수익 창출을 돕는 판매 플랫폼</b>으로</span></p>
                    <p><span>해당 쇼핑몰을 통해 판매 시</span></p>
                    <p><span>수수료를 받는 방식입니다.</span></p>
                    <br>
                    <br>
                </div>
                <div>
                    <img src="/public/img/partner_bg_img2.png">
                </div>
            </section>
        </div>
        <div id="cont3" class="cont">
            <section>
                <div class="txt">
                    <h1><span>이런분들께 강력 추천합니다!</span></h1>
                    <p><img src="/public/img/icon/task.png"><span>SNS를 꾸준치 관리하시는 분들!</span></p>
                    <p><img src="/public/img/icon/task.png"><span>투잡이 필요하신 분들!</span></p>
                    <p><span>당신의 홍보 능력으로 수익을 창출해 보세요!</span></p>
                </div>
                <br>
                <div class="img_wrap">
                    <img src="/public/img/partner_bg_img3.png">
                </div>
            </section>
        </div>
    </div>
</div>



<script>
    $(function(){
        $("#login_link").click(function(){
            var state = $("#login_inner").hasClass("active");
            if(state){
                $("#login_inner").removeClass("active");
                }else{
                $("#login_inner").addClass("active");

            }
        })

        cont1 = $('#cont1').position().top;
        cont2 = $('#cont2').position().top - 600;
        cont3 = $("#cont3").position().top - 600;
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll <= cont1) {
                $(".cont").removeClass("active");
                $("#cont1").addClass("active");
                }else if (scroll <= cont2) {
                $(".cont").removeClass("active");
                $("#cont2").addClass("active");
                }else if (scroll <= cont3) {
                $(".cont").removeClass("active");
                $("#cont3").addClass("active");
            } 


        })
    })
</script>
