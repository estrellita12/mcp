<section class="contents">
    <h1 class="cont_title">입점 신청</h1>
    <div class="cont_wrap">
        <form name="fsellerForm" action="/Join/add" method="POST" onsubmit="return frmRegsubmit(this)" enctype="MULTIPART/FORM-DATA">
            <div class="rhead01_wrap">
                <div class="h2">사이트 이용정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w120">
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
                        <th scope="row">공급사명</th>
                        <td><input type="text" name="name" class="required" required></td>
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
                            <input type="password" id="passwdRepeat" name="passwdRepeat" class="required" autocomplete="on" readonly required>
                            <p id="passwdRepeatCheck" class="frm_check"></p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">입금계좌 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">은행명</th>
                        <td><input type="text" name="bank[]" placeholder="은행명" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">계좌번호</th>
                        <td><input type="text" name="bank[]" placeholder="계좌번호" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">예금주</th>
                        <td><input type="text" name="bank[]" placeholder="예금주" ></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">담당자 정보</div>
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">담당자 이름</th>
                        <td><input type="text" name="manager[]" placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager[]" placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager[]"  ></td>

                    </tr>
                    <tr>
                        <th scope="row">담당자 기타정보</th>
                        <td><input type="text" name="manager[]"  ></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">사업자 정보</div>
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">사업자 유형</th>
                        <td>
                            <?php foreach($GLOBALS['company_type'] as $num=>$type){?>
                            <?=get_frm_radio("companyType",$num,'1',$type);?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">회사 이름</th>
                        <td><input type="text" name="companyName" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">대표자 이름</th>
                        <td><input type="text" name="owner" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록 번호</th>
                        <td><input type="text" name="saupjaNo" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록증 파일</th>
                        <td>
                            <input type="file" name="saupjaFile" class="frm_input" value="<?=$this->my['sl_company_saupja_file']?>" >
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고 번호</th>
                        <td><input type="text" name="tolsinNo" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 파일</th>
                        <td>
                            <input type="file" name="tolsinFile" class="frm_input" value="<?=$this->my['sl_company_tolsin_file']?>" >
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">업태</th>
                        <td><input type="text" name="companyItem" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">종목</th>
                        <td><input type="text" name="companyService" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 주소</th>
                        <td><input type="text" name="companyAddr" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 전화 번호</th>
                        <td><input type="text" name="companyTel" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 팩스 번호</th>
                        <td><input type="text" name="companyFax" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 메일 번호</th>
                        <td><input type="text" name="companyEmail" class="frm_input"    size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">정보 책임자 이름</th>
                        <td>
                            <input type="text" name="info[]" class="frm_input" size=40 >
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">정보 책임자 메일</th>
                        <td>
                            <input type="text" name="info[]" class="frm_input" size=40 >
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
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
                $('#userIdCheck').removeClass('success');
                return;
                }else{
                $.ajax({
type : "GET",
url : '/Join/overChk',
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
