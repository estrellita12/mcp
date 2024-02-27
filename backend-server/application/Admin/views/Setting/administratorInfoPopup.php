<section class="contents">
    <h1 class="cont_title">관리자 정보</h1>
    <div class="cont_wrap">
        <form name="fadminForm" action="/Setting/setAdministrator/<?=$this->param['ident']?>" method="POST">
            <input type="hidden" name="id" value="<?=$this->row['adm_id']?>">
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
                        <td colspan="3"><?=$this->row['adm_id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">관리자명</th>
                        <td><input type="text" name="name" value="<?=$this->row['adm_name']?>" placeholder="관리자명" class="required" required></td>
                        <th scope="row">비밀번호</th>
                        <td><input type="password" name="passwd" value="" autocomplete="on" placeholder="비밀번호" ></td>
                    </tr>
                    <tr>
                        <th scope="row">E-Mail</th>
                        <td colspan="3"><input type="text" name="email" value="<?=$this->row['adm_email']?>" itemname="E-Mail"  size="30"></td>
                    </tr>
                    <tr>
                        <th scope="row">휴대전화</th>
                        <td colspan="3"><input type="text" name="cellphone" value="<?=$this->row['adm_cellphone']?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">등급</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option($idx, $this->row['adm_grade'], "[".$idx."] ".$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">기타 정보</th>
                        <td><input type="text" name="info" value="<?=$this->row['adm_info_other']?>" size="30"></td>

                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="chead02_wrap">
                <div class="h2">개별 권한 설정</div>
                <p class="info">개별 권한 및 등급이 접근 가능 권한이어야만 해당 탭에 접근 가능합니다.</p>
                <table>
                    <colgroup>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <thead>
                        <th scope="col">회원관리</th>
                        <th scope="col">가맹점관리</th>
                        <th scope="col">공급사관리</th>
                        <th scope="col">상품관리</th>
                        <th scope="col">디자인관리</th>
                        <th scope="col">주문관리</th>
                        <th scope="col">통계관리</th>
                        <th scope="col">게시판관리</th>
                        <th scope="col">환경설정</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?=get_frm_chkbox("authMember","y",$this->row['adm_auth_member']," 허용")?></td>
                        <td><?=get_frm_chkbox("authPartner","y",$this->row['adm_auth_partner']," 허용")?></td>
                        <td><?=get_frm_chkbox("authSeller","y",$this->row['adm_auth_seller']," 허용")?></td>
                        <td><?=get_frm_chkbox("authGoods","y",$this->row['adm_auth_goods']," 허용")?></td>
                        <td><?=get_frm_chkbox("authDesign","y",$this->row['adm_auth_design']," 허용")?></td>
                        <td><?=get_frm_chkbox("authOrder","y",$this->row['adm_auth_order']," 허용")?></td>
                        <td><?=get_frm_chkbox("authDefault","y",$this->row['adm_auth_default']," 허용")?></td>
                        <td><?=get_frm_chkbox("authBoard","y",$this->row['adm_auth_board']," 허용")?></td>
                        <td><?=get_frm_chkbox("authSetting","y",$this->row['adm_auth_setting']," 허용")?></td>
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
                        <th scope="row">회원 가입 일시</th>
                        <td><?=$this->row['adm_reg_dt']?></td>
                        <th scope="row">로그인횟수</th>
                        <td><?=$this->row['adm_login_cnt'] ?> 회</td>
                    </tr>
                    <tr>
                        <th scope="row">마지막 로그인 일시</th>
                        <td><?=$this->row['adm_last_login_dt']?></td>
                        <th scope="row">마지막 로그인 IP</th>
                        <td><?=$this->row['adm_last_login_ip']?></td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 차단</th>
                        <td colsapn="3">
                            <?=get_frm_chkbox("blockYn","y",$this->row['adm_block_yn']," 해당 관리자를 차단합니다.")?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td colspan="3"><textarea name="memo"><?=$this->row['adm_memo']?></textarea></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" class="btn_medium btn_theme" accesskey="s">
                <?php if($this->row['adm_id']!="admin"){ ?>
                <a href="/Setting/removeAdministrator/<?=$this->row['adm_id']?>" class="btn_medium btn_red" onclick="return confirm('해당 관리자를 탈퇴 처리 하시겠습니까?\n 탈퇴 처리된 회원 데이터는 복구 불가능합니다.')">탈퇴</a>
                <?php } ?>
                <button type="button" class="btn_medium btn_white" onclick="opener.location.reload();window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
