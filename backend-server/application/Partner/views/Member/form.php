<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="frmMember" id="frmMember" action="/Member/add" method="POST" onsubmit="return frmRegSubmit(this)">
            <input type="hidden" name="returnUrl" value="<?=$this->returnUrl?>">
            <input type="hidden" name="shop" value="<?=$this->my['pt_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">사이트 이용 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">아이디</th>
                        <td>    
                            <input type="text" id="userId" name="id" class="required" required>
                            <!--<button type="button" id="idck" class="btn btn_small btn_black">중복확인</button>-->
                            <p id="userIdCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td>
                            <input type="password" id="passwd" name="passwd" class="required" autocomplete="on" required>
                            <p id="passwdCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호 확인</th>
                        <td>
                            <input type="password" id="passwdRepeat" name="passwdRepeat" class="required" autocomplete="on" required>
                            <p id="passwdRepeatCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">개인 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">이름</th>
                        <td><input type="text" id="mbnm" name="name" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">전화번호</th>
                        <td>
                            <input type="text" id="cellphone" name="cellphone" class="required" required>
                            <span class="padl5">
                                <?=get_frm_chkbox("smsser","y","y","마케팅 문자 허용")?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>
                            <input type="text" id="email" name="email">
                            <span class="padl5">
                                <?=get_frm_chkbox("emailser","y","y","마케팅 메일 허용")?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">생년월일</th>
                        <td><input type="date" id="birth" name="birth"></td>
                    </tr>
                    <tr>
                        <th scope="row">성별</th>
                        <td>
                            <?= get_frm_radio("gender","M","","남"); ?>
                            <?= get_frm_radio("gender","W","","여"); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td>
                            <label for="reg_mb_zip" class="sound_only">우편번호</label>
                            <input type="text" name="zip" id="mb_zip"  size="8" maxlength="5">
                            <button type="button" class="btn_small btn_gray" onclick="winZip('frmMember', 'zip', 'addr1', 'addr2', 'addr3');">주소검색</button><br>
                            <input type="text" name="addr1" id="mb_addr1" class="frm_address" size="60">
                            <label for="reg_mb_addr1">기본주소</label><br>
                            <input type="text" name="addr2" id="mb_addr2" class="frm_address" size="60">
                            <label for="reg_mb_addr2">상세주소</label><br>
                            <input type="text" name="addr3" id="reg_mb_addr3" class="frm_address" size="60" readonly="readonly">
                            <label for="reg_mb_addr3">참고항목</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                <a href="<?=$this->returnUrl?>" class="btn_large btn_white">목록</a>
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
        $('#cellphone').keyup(function(){
                var cellphone = $('#cellphone').val();
                $('#cellphone').val(setCellphone(cellphone));
                });

        $('#userId').keyup(function(){
                var userId = $('#userId').val();
                if ( !isId(userId) ){
                $('#userIdCheck').html('5~20자의 영문 소문자, 숫자와 특수기호(_),(-)만 사용 가능합니다.');
                $('#userIdCheck').removeClass('success');
                return;
                }else{
                $.ajax({
type : "GET",
url : '/Member/overChk',
data : {'id' : userId},
dataType : 'json',
success : function(data){
if(data['res']){
$('#userIdCheck').html('사용 가능한 아이디 입니다.');
$('#userIdCheck').addClass('success');
}else{
$('#userIdCheck').html('중복된 아이디 입니다.');
$('#userIdCheck').removeClass('success');
}
},
error : function(data){ 
console.log(data);
}
});
}
});

$('#passwd').keyup(function(){
        var passwd = $('#passwd').val();
        $('#passwdRepeat').val('');
        if ( !isPassword(passwd) ){
        $('#passwdCheck').html('8~16자 영문 대 소문자, 숫자, 특수문자를 사용하세요.');
        $('#passwdRepeat').attr('readonly',true);
        return;
        }else{
        $('#passwdCheck').html('');
        $('#passwdRepeat').attr('readonly',false);
        return;
        }
        });

$('#passwdRepeat').keyup(function(){
        var passwd = $('#passwd').val();
        var passwdRepeat = $('#passwdRepeat').val();
        if ( passwd != passwdRepeat ){
        $('#passwdRepeatCheck').html('비밀번호가 일치하지 않습니다.');
        return;
        }else{
        $('#passwdRepeatCheck').html('');
        return;
        }
        });
});

function frmRegSubmit(obj){
    if( !$('#userIdCheck').hasClass('success') ){
        alert("아이디 중복 확인을 진행 해주세요.\n중복 되지 않은 아이디만 회원가입이 가능합니다.");
        return false;
    }

    if( $('#passwd').val() != $('#passwdRepeat').val() ){
        alert("비밀번호 확인이 비밀번호와 동일하지 않습니다.");
        return false;
    }

    return true;
}
</script>
