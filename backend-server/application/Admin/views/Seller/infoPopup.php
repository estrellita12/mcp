<section class="contents">
    <h1 class="cont_title" id="pg_tit">공급사 정보</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="fsellerForm" action="/Seller/set" method="POST" enctype="MULTIPART/FORM-DATA">
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->row['sl_id']?>">
                <div class="h2">기본 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">공급사명</th>
                        <td>
                            <input type="text" name="name" value="<?=$this->row['sl_name']?>" required itemname="공급사명" class="required">
                        </td>
                        <th scope="row">승인 상태</th>
                        <td><?=$GLOBALS['sl_stt'][$this->row['sl_stt']]?></td>
                    </tr>
                    <tr>
                        <th scope="row">아이디</th>
                        <td><?=$this->row['sl_id']?></td>
                        <th scope="row">비밀번호</th>
                        <td><input type="text" name="passwd" value=""></td>
                    </tr>
                    <tr>
                        <th scope="row">수수료</th>
                        <td><input type="text" class="tar" name="rate" value="<?=$this->row['sl_pay_rate']?>" size="5">%</td>
                        <th scope="row">등급</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['sl_grade'], $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">은행정보</th>
                        <td colspan="3">
                            <input type="text" name="bankName" value="<?=$this->row['sl_bank_name']?>" placeholder="은행명" required>
                            <input type="text" name="bankAccount" value="<?=$this->row['sl_bank_account']?>" placeholder="계좌번호" size="30" required>
                            <input type="text" name="bankHolder" value="<?=$this->row['sl_bank_holder']?>" placeholder="예금주명" required>
                            <div class="info"><p>※ 계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</p></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
           <div class="rhead01_wrap">
                <div class="h2">기타 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">가입일시</th>
                        <td><?=$this->row['sl_reg_dt']?></td>
                        <th scope="col">승인일시</th>
                        <td><?=$this->row['sl_app_dt']?></td>
                    </tr>
                    <tr>
                        <th scope="col">로그인 횟수</th>
                        <td><?=$this->row['sl_login_cnt']?></td>
                        <th scope="col">마지막 로그인 일시</th>
                        <td><?=$this->row['sl_last_login_dt']?></td>
                    </tr>
                    <tr>
                        <th scope="col">관리자 메모</th>
                        <td colspan="3">
                            <textarea value="memo"><?=$this->row['sl_adm_memo']?></textarea>
                            <p class="info">해당 내용은 공급사에 노출되지 않습니다. </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
           <div class="confirm_wrap">
                <input type="submit" value="수정" class="btn_medium btn_theme" accesskey="s">
                <a href="/Seller/expire/<?=$this->row['sl_id']?>" class="btn_medium btn_red" onclick="return confirm('해당 공급사를 만료 처리 하시겠습니까?\n만료 처리된 회원 데이터는 복구 불가능합니다.\n해당 공급사가 판매 중인 상품이 모두 만료(삭제)처리 됩니다.')">만료</a>
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
