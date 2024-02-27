<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name']?></h1>
        <form name="fmemberForm" action="/Member/add" method="POST" onsubmit="return fsubmit(this)">
            <div class="rhead01_wrap">
                <h2>사이트 이용정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">아이디</th>
                        <td>    
                            <input type="text" id="mbid" name="id" class="required" required>
                            <button type="button" id="idck" class="btn btn_small btn_gray">중복확인</button>
                            <p id="idck_res" class="info"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td><input type="password" id="passwd" name="passwd" class="required" autocomplete="on" required></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호 확인</th>
                        <td>
                            <input type="password" id="passwd_ck" name="passwd_ck" class="required" autocomplete="on" required>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>개인 정보 입력</h2>
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
                            <span class="info">
                                <label><input type="checkbox" id="smsser" name="smsser" value="Y" checked="checked"> 문자메세지를 받겠습니다.</label>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>
                            <input type="text" id="email" name="email">
                            <span class="info">
                                <label><input type="checkbox" id="emailser" name="emailser" value="Y" checked="checked"> 정보 메일을 받겠습니다.</label>
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
                            <button type="button" class="btn_small btn_black" onclick="winZip('fmemberForm', 'zip', 'addr1', 'addr2', 'addr3');">주소검색</button><br>
                            <input type="text" name="addr1" id="mb_addr1" class="frm_address" size="60">
                            <label for="reg_mb_addr1">기본주소</label><br>
                            <input type="text" name="addr2" id="mb_addr2" class="frm_address" size="60">
                            <label for="reg_mb_addr2">상세주소</label><br>
                            <input type="text" name="addr3" id="reg_mb_addr3" class="frm_address" size="60" readonly="readonly">
                            <label for="reg_mb_addr3">참고항목</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="pt_id" id="pt_id">
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,"killdeal",$name); ?>
                                <?php } ?>
                            </select>

                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
                </div>
            </form>
        </div>
    </section>
</div>
<script>
    $(function(){
        $('#idck').click(function(){
            var mbid = $('#mbid').val();
            if( !mbid ) return;
            $.ajax({
                type : "GET",
                url : '/Member/overChk',
                data : {'mbid' : mbid},
                dataType : 'json',
                success : function(data){
                    console.log(data['res']);
                    if(data['res']){
                        $('#idck_res').html('사용 가능한 아이디 입니다.');
                        $('#idck_res').attr('over','true');
                    }else{
                        $('#idck_res').html('중복된 아이디 입니다.');
                        $('#idck_res').attr('over','false');
                    }
                },
                error : function(data){ 
                    console.log(data);
                }
            });
        });
        
    });

    function fsubmit(obj){
        if( $('#idck_res').attr('over') ){
            alert("아이디 중복확인을 진행해야합니다..");
            return false;
        }

        if( $('#passwd').val() != $('#passwd_ck').val() ){
            alert("비밀번호 확인이 비밀번호와 동일하지 않습니다.");
            return false;
        }
        return true;
    }
</script>
