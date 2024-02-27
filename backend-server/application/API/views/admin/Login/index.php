<div id="login">
    <div class="log_inner">
        <div class="mtxt">관리자 로그인</div>
        <form action="/Login/loginCheck" method="POST">
            <div>
                <label for="login_id" class="sound_only">회원아이디</label>
                <input type="text" name="id" id="login_id" class="frm_input" maxlength="20" placeholder="아이디">
            </div>
            <div>
                <label for="login_pw" class="sound_only">비밀번호</label>
                <input type="password" name="passwd" id="login_pw" class="frm_input" maxlength="20" autocomplete="on"  placeholder="비밀번호">
            </div>
            <div><input type="submit" class="btn_large btn_black" value="로그인"></div>
        </form>
    </div>
</div>
