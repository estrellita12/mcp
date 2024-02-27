<section class="contents">
    <p class="cont_title">회원 정보</p>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="fmemberForm" action="/Member/set/<?=$this->param['ident']?>" method="POST">
            <input type="hidden" name="id" value="<?=$this->row['mb_id']?>">
            <div class="rhead01_wrap">
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
                        <th scope="row">아이디</th>
                        <td><span class="marr10"><?=$this->row['mb_id']?></span><img src="<?=$this->row['mb_img']?>" class="w30"></td>
                        <th scope="row">가맹점</th>
                        <td><?=$this->pt_li[$this->row['pt_id']]?></td>
                    </tr>
                    <tr>
                        <th scope="row">회원명</th>
                        <td>
                            <input type="text" name="name" value="<?=$this->row['mb_name']?>" required itemname="회원명" class="required">
                        </td>
                        <th scope="row">비밀번호</th>
                        <td><input type="text" name="passwd" value=""></td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <th scope="row">성별</th>
                        <td>
                            <?= get_frm_radio("gender","m",$this->row['mb_gender'],"남"); ?>
                            <?= get_frm_radio("gender","w",$this->row['mb_gender'],"여"); ?>
                        </td>
                        <th scope="row">생년월일(8자)</th>
                        <td><input type="date" name="birth" value="<?=$this->row['mb_birth'];?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">E-Mail</th>
                        <td><input type="text" name="email" value="<?=$this->row['mb_email']?>" itemname="E-Mail"  size="30"></td>
                        <th scope="row">마케팅 메일 허용</th>
                        <td>
                            <?= get_frm_radio("emailser","y",$this->row['mb_emailser_yn'],"예"); ?>
                            <?= get_frm_radio("emailser","n",$this->row['mb_emailser_yn'],"아니오"); ?>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">휴대전화</th>
                        <td><input type="text" name="cellphone" value="<?=$this->row['mb_cellphone']?>"></td>
                        <th scope="row">마케팅 문자 허용</th>
                        <td>
                            <?= get_frm_radio("smsser","y",$this->row['mb_smsser_yn'],"예"); ?>
                            <?= get_frm_radio("smsser","n",$this->row['mb_smsser_yn'],"아니오"); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td colspan="3">
                            <input type="text" name="zip" value="<?=$this->row['mb_zip']?>" size="8" maxlength="5">
                            <a href="javascript:winZip('fmemberForm', 'zip', 'addr1', 'addr2', 'addr3');" class="btn_small btn_gray">주소검색</a>
                            <p class="mart5"><input type="text" name="addr1" value="<?=$this->row['mb_addr1']?>" size="60"> 기본주소</p>
                            <p class="mart5"><input type="text" name="addr2" value="<?=$this->row['mb_addr2']?>" size="60"> 상세주소</p>
                            <p class="mart5"><input type="text" name="addr3" value="<?=$this->row['mb_addr3']?>" size="60"> 참고항목
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">등급</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option($idx, $this->row['mb_grade'], "[".$idx."] ".$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                        <th scope="row">포인트</th>
                        <td>
                            <b><?=$this->row['mb_point']?></b> Point
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">기타 정보</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                    </tr>
                    <tr>
                        <th scope="row">회원 가입 일시</th>
                        <td><?=$this->row['mb_reg_dt']?></td>
                        <th scope="row">로그인 횟수</th>
                        <td><?=$this->row['mb_login_cnt'] ?> 회</td>
                    </tr>
                    <tr>
                        <th scope="row">마지막 접속 일시</th>
                        <td><?=$this->row['mb_last_login_dt']?></td>
                        <th scope="row">마지막 접속 IP</th>
                        <td><?=$this->row['mb_last_login_ip']?></td>
                    </tr>
                    <tr>
                        <th scope="row">사용자 차단</th>
                        <td colspan="3">
                            <?=get_frm_chkbox("block","y",$this->row['mb_block_yn'],"해당 사용자를 차단합니다.")?>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">관리자메모</th>
                        <td colspan="3"><textarea name="memo" class="frm_textbox" rows="3"><?= $this->row['mb_adm_memo'] ?></textarea></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="수정" class="btn_medium btn_theme" accesskey="s">
                <!--
            <a href="/Member/remove/<?=$this->row['mb_id']?>" class="btn_medium btn_red" onclick="return confirm('해당 회원을 탈퇴 처리 하시겠습니까?\n 탈퇴 처리된 회원 데이터는 복구 불가능합니다.')">탈퇴</a>
            -->
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
