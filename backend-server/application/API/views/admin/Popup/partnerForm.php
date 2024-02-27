<div id="new_win">
    <div class="pg_header">
        <h1>가맹점 정보 수정</h1>
    </div>
    <section class="cont_inner">
        <ul class="anchor">
            <li><a href="/PopUp/memberForm/<?= $this->row['id'] ?>">가맹점정보수정</a></li>
            <li><a href="/PopUp/memberOrder/<?= $this->row['id'] ?>">수수료내역</a></li>
        </ul>

        <div class="tbl_frm02">
            <form name="fpartnerform" id="fpartnerform" action="/Popup/partnerFormUpdate" method="post">
                <input type="hidden" name="id" value="<?=$this->row['id']?>">
                <h3>기본 정보</h3>
                <table class="tablef">
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">가맹점명</th>
                        <td><input type="text" name="name" value="<?=$this->row['name']?>" class="frm_input" placeholder=""></td>
                        <th scope="row">아이디</th>
                        <td><?=$this->row['id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td colspan="3"><input type="text" name="passwd" value="" class="frm_input"></td>
                    </tr>
                   <tr>
                        <th scope="row">등급</th>
                        <td colspan="3">
                            <select id="grade" name="grade">
                                <?php foreach($this->query->getRowAll("web_member_grade","*"," and name!='' "," order by idx desc ") as $row){ ?>
                                    <?= get_frm_option( $row['idx'], $this->row['grade'], $row['name']) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">쇼핑몰 타이틀</th>
                        <td><input type="text" name="shop_title" value="<?=$this->def['shop_title']?>" class="frm_input" size="30"></td>
                        <th scope="row">쇼핑몰 도메인</th>
                        <td><input type="text" name="shop_url" value="<?=$this->row['shop_url']?>" class="frm_input"></td>
                    </tr>
                     <tr>
                        <th scope="row">테마</th>
                        <td><input type="text" name="theme" value="<?=$this->def['theme']?>" class="frm_input" size="30"></td>
                        <th scope="row">모바일 테마</th>
                        <td><input type="text" name="mtheme" value="<?=$this->def['mtheme']?>" class="frm_input" size="30"></td>
                    </tr>

                    <tr>
                        <th scope="row" class="th_bg fc_00f">수수료</th>
                        <td colspan="3"><input type="text" name="pay_rate" value="<?=$this->row['pay_rate']?>" class="frm_input" placeholder=""></td>
                    </tr>
                    <tr class="pt_pay_fld">
                        <th scope="row" class="th_bg fc_00f">은행정보</th>
                        <td colspan="3">
                            <input type="text" name="bank_name" value="<?=$this->row['bank_name']?>" class="frm_input" placeholder="은행명">
                            <input type="text" name="bank_account" value="<?=$this->row['bank_account']?>" class="frm_input" placeholder="계좌번호" size="30">
                            <input type="text" name="bank_holder" value="<?=$this->row['bank_holder']?>" class="frm_input" placeholder="예금주명">
                            <span class="info fc_125">위 계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</span>          
                        </td>
                    </tr>
                    </tbody>
                </table>

                <h3 class="mart30">사업자정보</h3>
                <table class="tablef">
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">회사명</th>
                        <td colspan="3">
                            <input type="text" name="company_name" value="<?=$this->def['company_name']?>" class="frm_input">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">사업자 유형</th>
                        <td colspan="3">
                            <?= get_frm_radio("company_type","1",$this->def['company_type'],"일반과세자");?>
                            <?= get_frm_radio("company_type","2",$this->def['company_type'],"간이과세자");?>
                            <?= get_frm_radio("company_type","3",$this->def['company_type'],"면세사업자");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">대표명</th>
                        <td colspan="3">
                            <input type="text" name="company_owner" value="<?=$this->def['company_owner']?>" class="frm_input">
                        </td>
                    </tr>
                                       <tr>
                        <th scope="row">사업장주소</th>
                        <td colspan="3">
                            <input type="text" name="company_addr" value="<?=$this->def['company_addr']?>" class="frm_input">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">대표 전화 번호</th>
                        <td><input type="text" name="company_tel" value="<?=$this->def['company_tel']?>" class="frm_input"></td>
                        <th scope="row">대표 이메일</th>
                        <td><input type="text" name="company_email" value="<?=$this->def['company_email']?>" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">사업자등록번호</th>
                        <td><input type="text" name="company_saupja_no" value="<?=$this->def['company_saupja_no']?>" class="frm_input"></td>
                        <th scope="row">파일</th>
                        <td><input type="file" name="saupja_file"></td>
                    </tr>
                    <tr>
                        <th scope="row">업태</th>
                        <td><input type="text" class="frm_input"></td>
                        <th scope="row">종목</th>
                        <td><input type="text" class="frm_input"></td>
                    </tr>

                    <tr>
                        <th scope="row">통신판매신고번호</th>
                        <td colspan="3"><input type="text" name="tongsin_no" value="<?=$this->def['tongsin_no']?>" class="frm_input"></td>
                    </tr>

                    <tr>
                        <th scope="row">정보 책임자</th>
                        <td colspan="3">
                            <input type="text" name="" value="<?=$this->def['info']?>" class="frm_input" placeholder="이름">
                            <input type="text" name="" value="<?=$this->def['info']?>" class="frm_input" placeholder="전화번호">
                            <input type="text" name="" value="<?=$this->def['info']?>" class="frm_input" placeholder="이메일">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">관리자메모</th>
                        <td colspan="3"><textarea name="memo" class="frm_textbox" rows="3"></textarea></td>
                    </tr>
                    </tbody>
                </table>
                <h2 class="mart30">담당자 정보</h2>
                <table class="tablef">
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">담당자 이름</th>
                        <td><input type="text" name="manager_name" value="<?=$this->row['manager_name']?>" class="frm_input" placeholder=""></td>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager_cellphone" value="<?=$this->row['manager_cellphone']?>" class="frm_input" placeholder=""></td>
                    </tr>

                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager_email" value="<?=$this->row['manager_email']?>" class="frm_input" placeholder=""></td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrapper">
                    <input type="submit" value="저장" class="btn btn_medium btn_black" accesskey="s">
                    <button type="button" class="btn btn_medium btn_red" onclick="member_leave();">탈퇴</button>
                    <button type="button" class="btn btn_medium btn_white" onclick="window.close();">닫기</button>
                </div>
            </form>
        </div>
    </section>
</div>
