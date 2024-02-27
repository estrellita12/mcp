<section class="contents">
    <h1 class="cont_title">CustomerService 이력 등록</h1>
    <div class="cont_wrap">
        <form name="fmemberForm" action="/Order/addCs" method="POST">
            <div class="rhead01_wrap">
                <div class="h2">CS 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <td scope="row">주문번호</td>
                            <td><input type="hidden" name="odNo" value="<?=$this->row['od_no']?>"><?=$this->row['od_no']?></td>
                        </tr>
                        <tr>
                            <td scope="row">주문일련번호</td>
                            <td><input type="hidden" name="odId" value="<?=$this->row['od_id']?>"><?=$this->row['od_id']?></td>
                        </tr>
                        <tr>
                            <td scope="row">주문자</td>
                            <td><input type="hidden" name="userId" value="<?=$this->row['mb_id']?>"><?=$this->row['mb_id']?></td>
                        </tr>
                        <tr>
                            <td scope="row">CS 타입</td>
                            <td>    
                                <select name="type" class="w200">
                                    <?php foreach($GLOBALS['cs_type'] as $type){ ?>
                                    <option value="<?=$type?>"><?=$type?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">CS 내용</td>
                            <td><textarea name="message"></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" class="btn_medium btn_theme" accesskey="s">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>

