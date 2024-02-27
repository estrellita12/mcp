<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Setting/addTemplate" method="POST">
            <input type="hidden" name="returnUrl" value="<?=$this->returnUrl?>">
            <input type="hidden" name="type" value="1">
            <div class="rhead01_wrap">
                <div class="h2">메일 등록  정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">치환코드</th>
                        <td>
                            <p>{이름} {아이디} </p>
                            <p class="info">위 제공하는 치환코드를 메일내용에 입력하시면 자동으로 변환되어 메일에 적용 됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">메일 제목</th>
                        <td>
                            <input type="text" name="title" class="required" placeholder="제목없음" size="40" required>
                            <p class="info">Example) 최대 10,000포인트 득템찬스!! 이벤트에 참여하세요!</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">메일 내용</th>
                        <td> <?= editor_html('content', get_text('',0)) ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=urldecode($this->returnUrl)?>" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
