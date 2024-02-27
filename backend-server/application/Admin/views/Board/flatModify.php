<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?> </h1>
    <form name="fflatModify" action="/Board/setFlat/<?=$this->param['ident']?>" method="POST" onsubmit="return fsubmit(this)">
        <input type="hidden" name="preUrl" value="<?=empty($_REQUEST['returnUrl'])?"/Board/flatList":urldecode($_REQUEST['returnUrl'])?>">
        <div class="rhead01_wrap">
            <div class="h2">개별페이지 정보 입력</div>
            <table>
                <colgroup>
                    <col class="w170">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">페이지 제목</th>
                        <td>
                            <input type="text" id="flat_title" name="title" class="required" value="<?=$this->row['fl_title']?>" required>
                            <button type="button" id="idck" class="btn btn_small btn_gray">중복확인</button>
                            <p id="idck_res" class="info"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">PC 내용</th>
                        <td colspan="3"><?=editor_html("pc", get_text($this->row['fl_pc'],0))?></td>
                    </tr>
                    <tr>
                        <th scope="row">모바일 내용</th>
                        <td colspan="3"><?=editor_html("mobile", get_text($this->row['fl_mobile'],0))?></td>
                    </tr>                        
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="수정" id="btn_submit" class="btn_large btn_black" accesskey="s">
                <a href="<?=empty($_REQUEST['returnUrl'])?"/Board/flatList":urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
                <a href="/Board/removeFlat/<?=$this->row['fl_id']?>?preUrl=<?=urlencode($_REQUEST['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 게시판을 삭제 하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.\n해당 게시판에 속한 게시글이 모두 삭제됩니다.')">삭제</a>
            </div>
        </form>
    </div>
</section>
