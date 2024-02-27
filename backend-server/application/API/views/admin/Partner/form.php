<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?> </h1>
        <form name="fpartnerForm" action="/Partner/add" method="POST" onsubmit="return fsubmit(this)">
            <div class="rhead01_wrap">
                <h2>사이트 이용정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
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
                    <tr>
                        <th scope="row">가맹점명</th>
                        <td><input type="text" name="name" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td><input type="password" name="passwd" class="required" autocomplete='on' required></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호 확인</th>
                        <td><input type="password" name="passwd_ck" class="required" autocomplete='on' required></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>쇼핑몰 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">쇼핑몰 타이틀</th>
                        <td><input type="text" name="shop_title" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">도메인</th>
                        <td><input type="text" name="shop_url" ></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="rhead01_wrap">
                <h2>사업자 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">회사명</th>
                        <td><input type="text" name="company_name"></td>
                    </tr>
                    <tr>
                        <th scope="row">대표자명</th>
                        <td><input type="text" name="company_owner"></td>
                    </tr>
                    <tr>
                        <th scope="row">사업자등록번호</th>
                        <td><input type="text" name="company_saupja_no"></td>
                    </tr>
                    <tr>
                        <th scope="row">회사 전화번호</th>
                        <td><input type="text" name="company_tel"></td>
                    </tr>
                    <tr>
                        <th scope="row">회사 전화번호</th>
                        <td><input type="text" name="company_tel"></td>
                    </tr>
                    <tr>
                        <th scope="row">회사 주소</th>
                        <td><input type="text" name="company_tel"></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="rhead01_wrap">
                <h2>정산 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">수수료</th>
                        <td>
                            <label><input type="number" name="pay_rate" value="7"> %</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">은행 정보</th>
                        <td>
                            <input type="text" name="bank_name" placeholder="은행이름">
                            <input type="text" name="bank_account" placeholder="계좌번호">
                            <input type="text" name="bank_holder" placeholder="예금주">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>담당자 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">이름</th>
                        <td>
                            <input type="text" name="manager_name">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">전화번호</th>
                        <td>
                            <input type="text" name="manager_cellphone">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>
                            <input type="text" name="manager_email">
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
                url : '/Partner/overChk',
                data : {'mbid' : mbid},
                dataType : 'json',
                success : function(data){
                    console.log(data);
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
        if( $('#idck_res').attr('over') !='true' ){
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
