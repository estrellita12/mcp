<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fflatForm" action="/Board/addFlat" method="POST" onsubmit="return fsubmit(this)">
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
                            <input type="text" id="flat_title" name="title" class="required" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">PC 내용</th>
                        <td colspan="3"><?=editor_html("pc", null)?></td>
                    </tr>
                    <tr>
                        <th scope="row">모바일 내용</th>
                        <td colspan="3"><?=editor_html("mobile", null)?></td>
                    </tr>                        
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s" >
                <a href="<?=urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
            </div>
        </form>
    </div>
</section>
