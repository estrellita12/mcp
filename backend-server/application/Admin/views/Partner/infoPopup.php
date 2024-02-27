<section class="contents">
    <h1 class="cont_title">가맹점 정보</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="fpartnerForm" action="/Partner/set/<?=$this->param['ident']?>" method="POST">
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->row['pt_id']?>">
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
                        <th scope="row">가맹점명</th>
                        <td>
                            <input type="text" name="name" value="<?=$this->row['pt_name']?>" required itemname="회원명" class="required">
                        </td>
                        <th scope="row">승인 상태</th>
                        <td><?=$GLOBALS['pt_stt'][$this->row['pt_stt']]?></td>
                    </tr>
                    <tr>
                        <th scope="row">아이디</th>
                        <td><?=$this->row['pt_id']?></td>
                        <th scope="row">비밀번호</th>
                        <td><input type="text" name="passwd" value=""></td>
                    </tr>
                    <tr>
                        <th scope="row">수수료</th>
                        <td><input type="text" name="rate" class="tar" value="<?=$this->row['pt_pay_rate']?>" size="5"> %</td>
                        <th scope="row">가격 정책</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['pt_grade'], $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">입금 계좌 정보</th>
                        <td colspan="3">
                            <input type="text" name="bank[]" value="<?=isset($this->row['pt_bank_info'][0])?$this->row['pt_bank_info'][0]:""?>" placeholder="은행명" required>
                            <input type="text" name="bank[]" value="<?=isset($this->row['pt_bank_info'][1])?$this->row['pt_bank_info'][1]:""?>" placeholder="계좌번호" size="30" required>
                            <input type="text" name="bank[]" value="<?=isset($this->row['pt_bank_info'][2])?$this->row['pt_bank_info'][2]:""?>" placeholder="예금주명" required>
                            <p class="info">계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</p>
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <th scope="row">추가 권한</th>
                        <td colspan="3">
                            <input type="checkbox" name="ownpg" value="y" id="ownpg" <?=get_checked('y',$this->row['pt_own_pg_yn'])?> >
                            <label for="ownpg">개별 PG 결제 허용</label>
                            <input type="checkbox" name="owngs" value="y" id="owngs" <?=get_checked('y',$this->row['pt_own_gs_yn'])?>> 
                            <label for="owngs">개별 상품 판매 허용</label>
                        </td>
                    </tr>
                    -->
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
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
                        <td><input type="text" name="manager[]" value="<?=isset($this->row['pt_manager'][0])?$this->row['pt_manager'][0]:""?>"></td>
                        <th scope="row">담당자 전화번호</th>
                        <td><input type="text" name="manager[]" value="<?=isset($this->row['pt_manager'][1])?$this->row['pt_manager'][1]:""?>"  placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="row">담당자 메일</th>
                        <td><input type="text" name="manager[]" value="<?=isset($this->row['pt_manager'][2])?$this->row['pt_manager'][2]:""?>" placeholder=""></td>
                        <th scope="row">담당자 기타정보</th>
                        <td><input type="text" name="manager[]" value="<?=isset($this->row['pt_manager'][3])?$this->row['pt_manager'][3]:""?>" placeholder=""></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">사업자 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">사업자 유형</th>
                        <td>
                            <?php foreach($GLOBALS['company_type'] as $num=>$type){?>
                            <?=get_frm_radio("companyType",$num,$this->row['shop_company_type'],$type);?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">회사 이름</th>
                        <td><input type="text" name="companyName"  value="<?=$this->row['shop_company_name']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">대표자 이름</th>
                        <td><input type="text" name="owner" value="<?=$this->row['shop_company_owner']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록 번호</th>
                        <td><input type="text" name="saupjaNo" class="frm_input"  value="<?=$this->row['shop_company_saupja_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록증 사본</th>
                        <td>
                            <input type="file" name="saupjaFile" class="frm_input" value="<?=$this->row['shop_company_saupja_file']?>" >
                            <?php if(!empty($this->row['shop_company_saupja_file'])) { ?>
                            <a href="<?=_FILE.$this->row['shop_company_saupja_file']?>" class="btn_small btn_white" download>다운로드</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고 번호</th>
                        <td><input type="text" name="tolsinNo" class="frm_input"  value="<?=$this->row['shop_company_tolsin_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고증 사본</th>
                        <td>
                            <input type="file" name="tolsinFile" class="frm_input"  value="<?=$this->row['shop_company_tolsin_file']?>" size=60 >
                            <?php if(!empty($this->row['shop_company_tolsin_file'])) { ?>
                            <a href="<?=_FILE.$this->row['shop_company_tolsin_file']?>" class="btn_small btn_white" download>다운로드</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">업태</th>
                        <td><input type="text" name="companyItem" class="frm_input"  value="<?=$this->row['shop_company_item']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">종목</th>
                        <td><input type="text" name="companyService" class="frm_input"  value="<?=$this->row['shop_company_service']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 주소</th>
                        <td><input type="text" name="companyAddr" class="frm_input"  value="<?=$this->row['shop_company_addr']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 전화 번호</th>
                        <td><input type="text" name="companyTel" class="frm_input"  value="<?=$this->row['shop_company_tel']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 팩스 번호</th>
                        <td><input type="text" name="companyFax" class="frm_input"  value="<?=$this->row['shop_company_fax']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 메일 번호</th>
                        <td><input type="text" name="companyEmail" class="frm_input"  value="<?=$this->row['shop_company_email']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">정보 책임자</th>
                        <td>
                            <input type="text" name="info[]" class="frm_input"  value="<?=isset($this->row['shop_info_manager'][0])?$this->row['shop_info_manager'][0]:""?>" >
                            <input type="text" name="info[]" class="frm_input"  value="<?=isset($this->row['shop_info_manager'][1])?$this->row['shop_info_manager'][1]:""?>" size=40 >
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--
        <div class="rhead01_wrap">
            <div class="h2">CS 운영 정보</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="col">상담가능시간</th>
                        <td><input type="text" name="cs[]" class="frm_input"  value="<?=$this->row['shop_customer_service_info'][0]?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">점심시간</th>
                        <td><input type="text" name="cs[]" class="frm_input"  value="<?=$this->row['shop_customer_service_info'][1]?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">휴무일</th>
                        <td><input type="text" name="cs[]" class="frm_input"  value="<?=$this->row['shop_customer_service_info'][2]?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">문의 전화</th>
                        <td>
                            <input type="text" name="csTel" class="frm_input"  value="<?=$this->row['shop_customer_service_tel']?>" size=60 >
                            <p class="info">알림톡/SMS 발송시 발신번호로 사용되는 번호입니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">문의 메일</th>
                        <td>
                            <input type="text" name="csEmail" class="frm_input"  value="<?=$this->row['shop_customer_service_email']?>" size=60 >
                            <p class="info">메일 발송시 발신주소로 사용되는 주소입니다.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        -->
            <div class="confirm_wrap">
                <input type="submit" value="저장" class="btn_medium btn_theme">
                <a href="/Partner/expire/<?=$this->row['pt_id']?>" class="btn_medium btn_red" onclick="return confirm('해당 가맹점을 만료 처리 하시겠습니까?\n만료 처리된 회원 데이터는 복구 불가능합니다.\n해당 가맹점의 등록 정보 및 가입 회원이 모두 삭제됩니다.')">만료</a>
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
