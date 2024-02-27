<section class="contents">
    <h1 class="cont_title" id="pg_tit">담당자 정보</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="fsellerForm" action="/Seller/set" method="POST" enctype="MULTIPART/FORM-DATA">
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->row['sl_id']?>">
                <div class="h2">담당자 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">담당자 이름</th>
                        <td><input type="text" name="manager[]" value="<?=$this->row['sl_manager'][0]?>" placeholder=""></td>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager[]" value="<?=$this->row['sl_manager'][1]?>"  placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager[]" value="<?=$this->row['sl_manager'][2]?>" placeholder=""></td>
                        <th scope="row">담당자 기타 정보</th>
                        <td><input type="text" name="manager[]" value="<?=$this->row['sl_manager'][3]?>" placeholder=""></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">정산 담당자 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">담당자 이름</th>
                        <td><input type="text" name="manager2[]" value="<?=$this->row['sl_manager2'][0]?>" placeholder=""></td>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager2[]" value="<?=$this->row['sl_manager2'][1]?>"  placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager2[]" value="<?=$this->row['sl_manager2'][2]?>" placeholder=""></td>
                        <th scope="row">담당자 기타 정보</th>
                        <td><input type="text" name="manager2[]" value="<?=$this->row['sl_manager2'][3]?>" placeholder=""></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">CS 담당자 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">담당자 이름</th>
                        <td><input type="text" name="manager3[]" value="<?=$this->row['sl_manager3'][0]?>" placeholder=""></td>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager3[]" value="<?=$this->row['sl_manager3'][1]?>"  placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager3[]" value="<?=$this->row['sl_manager3'][2]?>" placeholder=""></td>
                        <th scope="row">담당자 기타 정보</th>
                        <td><input type="text" name="manager3[]" value="<?=$this->row['sl_manager3'][3]?>" placeholder=""></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">배송 담당자 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">담당자 이름</th>
                        <td><input type="text" name="manager4[]" value="<?=$this->row['sl_manager4'][0]?>" placeholder=""></td>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager4[]" value="<?=$this->row['sl_manager4'][1]?>"  placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager4[]" value="<?=$this->row['sl_manager4'][2]?>" placeholder=""></td>
                        <th scope="row">담당자 기타 정보</th>
                        <td><input type="text" name="manager4[]" value="<?=$this->row['sl_manager4'][3]?>" placeholder=""></td>
                    </tr>
                    </tbody>
                </table>
            </div>
           <div class="confirm_wrap">
                <input type="submit" value="수정" class="btn_medium btn_theme" accesskey="s">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
