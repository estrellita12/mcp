<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>  
    <div class="cont_wrap">
        <form name="fForm" action="/Setting/setTemplate/<?=$this->param['ident']?>" method="POST">
            <input type="hidden" name="returnUrl" value="<?=$this->returnUrl?>">
            <input type="hidden" name="id" value="<?=$this->row['tp_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">메일 세부 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">치환코드</th>
                        <td>
                            <p>{이름} {아이디} {쇼핑몰} {도메인} {로고}</p>
                            <p class="info">위 제공하는 치환코드를 메일내용에 입력하시면 자동으로 변환되어 메일에 적용 됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">메일 제목</th>
                        <td>
                            <input type="text" name="title" class="required" value="<?=$this->row['tp_title']?>" placeholder="제목없음" size="50" required>
                            <p class="info">Example) 최대 10,000포인트 득템찬스!! 이벤트에 참여하세요!</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">메일 내용</th>
                        <td> <?= editor_html('content', $this->row['tp_content'] ) ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=urldecode($this->returnUrl)?>" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
