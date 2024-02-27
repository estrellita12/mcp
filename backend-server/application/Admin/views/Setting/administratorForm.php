<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fmangerForm" action="/Setting/addAdministrator" method="POST" onsubmit="return frmRegSubmit(this)">
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
                            <input type="text" id="userId" name="id" maxlength="20" class="required" required>
                            <p id="userIdCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td>
                            <input type="password" id="passwd" name="passwd" maxlength="20" class="required" autocomplete="on" required>
                            <p id="passwdCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호 확인</th>
                        <td>
                            <input type="password" id="passwdRepeat" name="passwdRepeat" maxlength="20" class="required" autocomplete="on" required>
                            <p id="passwdRepeatCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">관리자 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">이름</th>
                        <td><input type="text" id="mbnm" name="name"></td>
                    </tr>
                    <tr>
                        <th scope="row">전화번호</th>
                        <td><input type="text" id="cellphone" name="cellphone"></td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td><input type="text" id="email" name="email"></td>
                    </tr>
                    <tr>
                        <th scope="row">기타 정보</th>
                        <td><input type="text" id="info" name="info"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="/Setting/administratorList" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
        $('#userId').keyup(function(){
                var userId = $('#userId').val();
                if ( !isId(userId) ){
                $('#userIdCheck').html('5~20자의 영문 소문자, 숫자와 특수기호(_),(-)만 사용 가능합니다.');
                return;
                }else{
                $.ajax({
type : "GET",
url : '/User/overChk',
data : {'id' : userId},
dataType : 'json',
success : function(data){
if(data['res']){
$('#userIdCheck').html('사용 가능한 아이디 입니다.');
$('#userIdCheck').addClass('success');
}else{
$('#userIdCheck').html('중복된 아이디 입니다.');
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
