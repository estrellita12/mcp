<div id="newWin">
    <div class="pg_header">
        <p class="pg_tit" id="pg_tit">회원 정보</p>
    </div>
    <section class="popup_inner">
        <div id="adminForm">
            <form name="fadminForm" action="/Setting/setAdmin/<?=$this->param['ident']?>" method="POST">
                <div class="rhead01_wrap">
                    <input type="hidden" name="id" value="<?=$this->row['id']?>">
                    <h2>기본 정보</h2>
                    <table>
                        <colgroup>
                            <col class="w130">
                            <col>
                            <col class="w130">
                            <col>
                        </colgroup>
                        <tbody>
                        <tr>
                            <th scope="row">회원명</th>
                            <td>
                                <input type="text" name="name" value="<?=$this->row['name']?>" required itemname="회원명" class="required">
                            </td>
                            <th scope="row">아이디</th>
                            <td><?=$this->row['id']?></td>
                        </tr>
                        <tr>
                            <th scope="row">비밀번호</th>
                            <td><input type="text" name="passwd" value=""></td>
                            <th scope="row">등급</th>
                            <td>
                                <select id="grade" name="grade">
                                    <?php foreach($this->gr_li as $idx=>$name){ ?>
                                    <?= get_frm_option($idx, $this->row['grade'], "[".$idx."] ".$name); ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="rhead01_wrap">
                    <h2>기타 정보</h2>
                    <table>
                        <colgroup>
                            <col class="w130">
                            <col>
                            <col class="w130">
                            <col>
                        </colgroup>
                        <tbody>
                        <tr>
                            <th scope="row">회원가입일</th>
                            <td><?=$this->row['reg_dt']?></td>
                            <th scope="row">최근접속일</th>
                            <td><?=$this->row['last_login_dt']?></td>
                        </tr>
                    </tr>
                    <tr>
                        <th scope="row">관리자 설명</th>
                        <td colspan="3"><input name="memo" class="frm_input" value="<?=$this->row['memo']?>" size="70"></td>
                    </tr>
                    </tbody>
                </table>

                <div class="confirm_wrap">
                    <input type="submit" value="저장" class="btn_medium btn_black" accesskey="s">
                    <button type="button" class="btn_medium btn_red" onclick="leave();">탈퇴</button>
                    <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                </div>
            </div>
        </form>
    </div>
</section>
</div>

