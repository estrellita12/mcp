<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fsellerForm" action="/Mypage/set/<?=$this->my['pt_id']?>" method="POST" enctype="MULTIPART/FORM-DATA">
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
                        <th scope="my">가맹점명</th>
                        <td>
                            <input type="text" name="name" value="<?=$this->my['pt_name']?>" required itemname="가맹점명" class="required">
                        </td>
                        <th scope="my">승인 상태</th>
                        <td><?=$GLOBALS['pt_stt'][$this->my['pt_stt']]?></td>
                    </tr>
                    <tr>
                        <th scope="my">아이디</th>
                        <td><?=$this->my['pt_id']?></td>
                        <th scope="my">비밀번호</th>
                        <td><input type="text" name="passwd" value=""></td>
                    </tr>
                    <tr>
                        <th scope="my">수수료</th>
                        <td><?=$this->my['pt_pay_rate']?> %</td>
                        <th scope="my">등급</th>
                        <td><?=$this->gr_li[$this->my['pt_grade']]?></td>
                    </tr>
                    <tr>
                        <th scope="my">은행정보</th>
                        <td colspan="3">
                            <input type="text" name="bank[]" value="<?=isset($this->my['pt_bank_info'][0])?$this->my['pt_bank_info'][0]:""?>" placeholder="은행명" required>
                            <input type="text" name="bank[]" value="<?=isset($this->my['pt_bank_info'][1])?$this->my['pt_bank_info'][1]:""?>" placeholder="계좌번호" size="30" required>
                            <input type="text" name="bank[]" value="<?=isset($this->my['pt_bank_info'][2])?$this->my['pt_bank_info'][2]:""?>" placeholder="예금주명" required>
                            <div class="info"><p>※ 계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</p></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->my['pt_id']?>">
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
                        <th scope="my">담당자 이름</th>
                        <td><input type="text" name="manager[]" value="<?=$this->my['pt_manager'][0]?>" placeholder=""></td>
                        <th scope="my">담당자 전화번호</th>
                        <td><input type="text" name="manager[]" value="<?=$this->my['pt_manager'][1]?>"  placeholder=""></td>
                    </tr>
                    <tr>
                        <th scope="my">담당자 메일</th>
                        <td><input type="text" name="manager[]" value="<?=$this->my['pt_manager'][2]?>" placeholder=""></td>
                        <th scope="my">담당자 기타 정보</th>
                        <td><input type="text" name="manager[]" value="<?=$this->my['pt_manager'][3]?>" placeholder=""></td>
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
                            <?=get_frm_radio("companyType",$num,$this->my['shop_company_type'],$type);?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">회사 이름</th>
                        <td><input type="text" name="companyName" class="frm_input"  value="<?=$this->my['shop_company_name']?>" size=60></td>
                    </tr>
                    <tr>
                        <th scope="col">대표자 이름</th>
                        <td><input type="text" name="owner" class="frm_input"  value="<?=$this->my['shop_company_owner']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록 번호</th>
                        <td><input type="text" name="saupjaNo" class="frm_input"  value="<?=$this->my['shop_company_saupja_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록증 파일</th>
                        <td>
                            <input type="file" name="saupjaFile" class="frm_input" value="<?=$this->my['shop_company_saupja_file']?>" >
                            <?php if(!empty($this->my['shop_company_saupja_file'])) { ?>
                            <a href="<?=_FILE.$this->my['shop_company_saupja_file']?>" class="btn_small btn_white" download>다운로드</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고 번호</th>
                        <td><input type="text" name="tolsinNo" class="frm_input"  value="<?=$this->my['shop_company_tolsin_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 파일</th>
                        <td>
                            <input type="file" name="tolsinFile" class="frm_input" value="<?=$this->my['shop_company_tolsin_file']?>" >
                            <?php if(!empty($this->my['shop_company_tolsin_file'])) { ?>
                            <a href="<?=_FILE.$this->my['shop_company_tolsin_file']?>" class="btn_small btn_white" download>다운로드</a>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <th scope="col">업태</th>
                        <td><input type="text" name="companyItem" class="frm_input"  value="<?=$this->my['shop_company_item']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">종목</th>
                        <td><input type="text" name="companyService" class="frm_input"  value="<?=$this->my['shop_company_service']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 주소</th>
                        <td><input type="text" name="companyAddr" class="frm_input"  value="<?=$this->my['shop_company_addr']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 전화 번호</th>
                        <td><input type="text" name="companyTel" class="frm_input"  value="<?=$this->my['shop_company_tel']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 메일 번호</th>
                        <td><input type="text" name="companyEmail" class="frm_input"  value="<?=$this->my['shop_company_email']?>" size=60 ></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
            </div>
        </form>
    </div>
</section>
