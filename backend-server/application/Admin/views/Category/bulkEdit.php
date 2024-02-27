<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabInfo['name']?></h1>
    <div class="pg_info">
        <ul>
            <li>엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</li>
            <li>엑셀파일을 저장하실 때는 Excel 97 - 2003 통합문서 (*.xls)로 저장하셔야 합니다.</li>
            <li>엑셀데이터는 3번째 라인부터 저장되므로 다운로드 파일 타이틀은 지우시면 안됩니다.</li>
        </ul>
    </div>
    <form name="fcategoryForm" action="/Category/uploadExcel" method="POST" enctype="multipart/form-data">
        <div class="rhead01_wrap">
            <div class="h2">관리자 메뉴 일괄 수정</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">파일 다운로드</th>
                        <td><a href="/Category/listExcel" class="btn btn_small btn_blue">데이터 다운로드</a></td>
                    </tr>
                    <tr>
                        <th scope="row">파일 업로드</th>
                        <td><input type="file" name="bulkExcel"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="confirm_wrap">
            <input type="submit" value="등록" id="btn_submit" class="btn_large btn_black" accesskey="s">
        </div>
    </form>
</section>
