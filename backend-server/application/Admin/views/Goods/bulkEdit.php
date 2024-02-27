<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_info">
        <ul>
            <li>엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</li>
            <li>엑셀데이터는 3번째 라인부터 저장되므로 1,2번째 라인은 지우시면 안됩니다.</li>
        </ul>
    </div>
    <div class="cont_wrap">
        <form name="fgoodsForm" action="/Goods/setExcel" method="POST" enctype="MULTIPART/FORM-DATA">
            <div class="rhead01_wrap">
                <div class="h2">상품 일괄 수정</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">파일 다운로드</th>
                        <!--<td><a href="/Goods/bulkEditExcel" class="btn_small btn_blue">데이터 다운로드</a></td>-->
                        <td><a href="/Goods/list" class="btn_small btn_blue">데이터 다운로드</a></td>
                    </tr>
                    <tr>
                        <th scope="row">파일 업로드</th>
                        <td><input type="file" name="bulkExcel"></td>
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

