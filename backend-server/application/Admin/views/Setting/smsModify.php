<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Setting/setTemplate/<?=$this->param['ident']?>" method="POST">
            <input type="hidden" name="returnUrl" value="<?=$this->returnUrl?>">
            <input type="hidden" name="id" value="<?=$this->row['tp_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">SMS 등록 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">치환코드</th>
                        <td colspan="3">
                            <p>{이름} {아이디}</p>
                            <p class="info">위 제공하는 치환코드를 SMS내용에 입력하시면 자동으로 변환되어 SMS에 적용 됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">SMS 제목</th>
                        <td colspan="3">
                            <input type="text" name="title" class="required" placeholder="제목 없음" size="40" value="<?=$this->row['tp_title']?>" required>
                            <p class="info">Example) 최대 10,000포인트 득템찬스!! 이벤트에 참여하세요!</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">SMS 내용</th>
                        <td><textarea name="content" style="height:200px;"><?=$this->row['tp_content']?></textarea></td>
                        <th scope="row">전환 내용</th>
                        <td><textarea name="replaceMsg" style="height:200px;"><?=$this->row['tp_replace_msg']?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row">템플릿 코드</th>
                        <td colspan="3"><input type="text" name="code" value="<?=$this->row['tp_code']?>"></td>
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
