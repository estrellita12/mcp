<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabInfo['name'];?></h1>
    <form name="fForm" action="/Marketing/addLms" method="POST">
        <div class="rhead01_wrap">
            <div class="h2">LMS 정보</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">치환코드</th>
                        <td>
                            <p>{이름} {아이디}</p>
                            <p class="info">위 제공하는 치환코드를 LMS내용에 입력하시면 자동으로 변환되어 LMS에 적용 됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">LMS 제목</th>
                        <td>
                            <input type="text" name="title" class="required" placeholder="제목 없음" size="40" required>
                            <p class="info">Example) 최대 10,000포인트 득템찬스!! 이벤트에 참여하세요!</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">LMS 타겟 가맹점</th>
                        <td>
                            <select name="shop" id="shop" class="w130">
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,"killdeal",$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">LMS 내용</th>
                        <td>
                            <?= editor_html('content', get_text('',0)) ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">발송 옵션</th>
                        <td><input type="text" name="opt"></td>
                    </tr>   
                    <tr>
                        <th scope="row">발송 일시</th>
                        <td>
                            <input type="date" name="sendDate[]" class="required" required>
                            <input type="time" name="sendDate[]" class="required" required>
                        </td>
                    </tr>   
                </tbody>
            </table>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_black" accesskey="s">
                <a href="/Marketing/lmsList" class="btn_large btn_white">목록</a>
            </div>
        </form>
    </div>
</section>
