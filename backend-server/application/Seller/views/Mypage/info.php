<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fsellerForm" action="/Mypage/set" method="POST" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="returnUrl" value="/Mypage/info">
            <input type="hidden" name="id" value="<?=$this->my['sl_id']?>">
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
                            <th scope="my">공급사명</th>
                            <td>
                                <input type="text" name="name" value="<?=$this->my['sl_name']?>" class="required" required>
                            </td>
                            <th scope="my">승인 상태</th>
                            <td><?=$GLOBALS['sl_stt'][$this->my['sl_stt']]?></td>
                        </tr>
                        <tr>
                            <th scope="my">아이디</th>
                            <td><?=$this->my['sl_id']?></td>
                            <th scope="my">비밀번호</th>
                            <td><input type="text" name="passwd" value=""></td>
                        </tr>
                        <tr>
                            <th scope="my">수수료</th>
                            <td><?=$this->my['sl_pay_rate']?> %</td>
                            <th scope="my">등급</th>
                            <td><?=$this->gr_li[$this->my['sl_grade']]?></td>
                        </tr>
                        <tr>
                            <th scope="my">은행정보</th>
                            <td colspan="3">
                                <input type="text" name="bankName" value="<?=$this->my['sl_bank_name']?>" placeholder="은행명" required>
                                <input type="text" name="bankAccount" value="<?=$this->my['sl_bank_account']?>" placeholder="계좌번호" size="30" required>
                                <input type="text" name="bankHolder" value="<?=$this->my['sl_bank_holder']?>" placeholder="예금주명" required>
                                <div class="info"><p>계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</p></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">담당자 정보</div>
                <div class="info">주 담당자로서, 재고 알림 등 기타 메일이 전송되는 담당자입니다.</div>
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
                            <td><input type="text" name="manager[]" value="<?=$this->my['sl_manager'][0]?>" placeholder="" required></td>
                            <th scope="my">담당자 전화번호</th>
                            <td><input type="text" name="manager[]" value="<?=$this->my['sl_manager'][1]?>"  placeholder="" required></td>
                        </tr>
                        <tr>
                            <th scope="my">담당자 메일</th>
                            <td><input type="text" name="manager[]" value="<?=$this->my['sl_manager'][2]?>" placeholder="" required></td>
                            <th scope="my">담당자 기타 정보</th>
                            <td><input type="text" name="manager[]" value="<?=$this->my['sl_manager'][3]?>" placeholder=""></td>
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
                            <th scope="my">담당자 이름</th>
                            <td><input type="text" name="manager2[]" value="<?=$this->my['sl_manager2'][0]?>" placeholder=""></td>
                            <th scope="my">담당자 전화번호</th>
                            <td><input type="text" name="manager2[]" value="<?=$this->my['sl_manager2'][1]?>"  placeholder=""></td>
                        </tr>
                        <tr>
                            <th scope="my">담당자 메일</th>
                            <td><input type="text" name="manager2[]" value="<?=$this->my['sl_manager2'][2]?>" placeholder=""></td>
                            <th scope="my">담당자 기타 정보</th>
                            <td><input type="text" name="manager2[]" value="<?=$this->my['sl_manager2'][3]?>" placeholder=""></td>
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
                            <th scope="my">담당자 이름</th>
                            <td><input type="text" name="manager3[]" value="<?=$this->my['sl_manager3'][0]?>" placeholder=""></td>
                            <th scope="my">담당자 전화번호</th>
                            <td><input type="text" name="manager3[]" value="<?=$this->my['sl_manager3'][1]?>"  placeholder=""></td>
                        </tr>
                        <tr>
                            <th scope="my">담당자 메일</th>
                            <td><input type="text" name="manager3[]" value="<?=$this->my['sl_manager3'][2]?>" placeholder=""></td>
                            <th scope="my">담당자 기타 정보</th>
                            <td><input type="text" name="manager3[]" value="<?=$this->my['sl_manager3'][3]?>" placeholder=""></td>
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
                            <th scope="my">담당자 이름</th>
                            <td><input type="text" name="manager4[]" value="<?=$this->my['sl_manager4'][0]?>" placeholder=""></td>
                            <th scope="my">담당자 전화번호</th>
                            <td><input type="text" name="manager4[]" value="<?=$this->my['sl_manager4'][1]?>"  placeholder=""></td>
                        </tr>
                        <tr>
                            <th scope="my">담당자 메일</th>
                            <td><input type="text" name="manager4[]" value="<?=$this->my['sl_manager4'][2]?>" placeholder=""></td>
                            <th scope="my">담당자 기타 정보</th>
                            <td><input type="text" name="manager4[]" value="<?=$this->my['sl_manager4'][3]?>" placeholder=""></td>
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
                                <?=get_frm_radio("companyType",$num,$this->my['sl_company_type'],$type);?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">회사 이름</th>
                            <td><input type="text" name="companyName" class="frm_input"  value="<?=$this->my['sl_company_name']?>" size=60 required></td>
                        </tr>
                        <tr>
                            <th scope="col">대표자 이름</th>
                            <td><input type="text" name="owner" class="frm_input"  value="<?=$this->my['sl_company_owner']?>" size=60 ></td>
                        </tr>
                        <tr>
                            <th scope="col">사업자 등록 번호</th>
                            <td><input type="text" name="saupjaNo" class="frm_input"  value="<?=$this->my['sl_company_saupja_no']?>" size=60 required></td>
                        </tr>
                        <tr>
                            <th scope="col">사업자 등록증 파일</th>
                            <td>
                                <input type="file" name="saupjaFile" class="frm_input" value="<?=$this->my['sl_company_saupja_file']?>" >
                                <?php if(!empty($this->my['sl_company_saupja_file'])) { ?>
                                <a href="<?=_FILE.$this->my['sl_company_saupja_file']?>" class="btn_small btn_white" download>다운로드</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">통신 판매업 신고 번호</th>
                            <td><input type="text" name="tolsinNo" class="frm_input"  value="<?=$this->my['sl_company_tolsin_no']?>" size=60 ></td>
                        </tr>
                        <tr>
                            <th scope="col">통신 판매업 파일</th>
                            <td>
                                <input type="file" name="tolsinFile" class="frm_input" value="<?=$this->my['sl_company_tolsin_file']?>" >
                                <?php if(!empty($this->my['sl_company_tolsin_file'])) { ?>
                                <a href="<?=_FILE.$this->my['sl_company_tolsin_file']?>" class="btn_small btn_white" download>다운로드</a>
                                <?php } ?>
                            </td>
                        </tr>

                        <tr>
                            <th scope="col">업태</th>
                            <td><input type="text" name="companyItem" class="frm_input"  value="<?=$this->my['sl_company_item']?>" size=60 ></td>
                        </tr>
                        <tr>
                            <th scope="col">종목</th>
                            <td><input type="text" name="companyService" class="frm_input"  value="<?=$this->my['sl_company_service']?>" size=60 ></td>
                        </tr>
                        <tr>
                            <th scope="col">회사 주소</th>
                            <td><input type="text" name="companyAddr" class="frm_input"  value="<?=$this->my['sl_company_addr']?>" size=60 ></td>
                        </tr>
                        <tr>
                            <th scope="col">회사 전화 번호</th>
                            <td><input type="text" name="companyTel" class="frm_input"  value="<?=$this->my['sl_company_tel']?>" size=60 ></td>
                        </tr>
                        <tr>
                            <th scope="col">회사 메일 번호</th>
                            <td><input type="text" name="companyEmail" class="frm_input"  value="<?=$this->my['sl_company_email']?>" size=60 ></td>
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
