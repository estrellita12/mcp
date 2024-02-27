<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name']?></h1>
        <form name="fadminForm" action="/Setting/addAdmin" method="POST"  >
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
                            <input type="text" name="id" class="required" required>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row">이름</th>
                        <td><input type="text" name="name" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td><input type="password" name="passwd" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호 확인</th>
                        <td><input type="password" name="passwd_ck" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 설명</th>
                        <td><input type="text" name="memo"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black">
            </div>
        </form>
    </section>
</div>
