<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="/Default/set" method="POST" onsubmit="frmCommaSubmit(this);">
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->row['pt_id']?>">
                <div class="h2">기본 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">쇼핑몰명</th>
                        <td><input type="text" id="name" name="name" value="<?=$this->row['pt_name']?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">가격 정책</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->gr_li as $id=>$name){ ?>
                                <?= get_frm_option( $id, $this->row['pt_grade'], "[".$id."] ".$name) ;?>
                                <?php } ?>
                            </select>
                        </td>
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
                        <td><input type="text" name="companyName" class="frm_input"  value="<?=$this->row['shop_company_name']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">대표자 이름</th>
                        <td><input type="text" name="owner" class="frm_input"  value="<?=$this->row['shop_company_owner']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록 번호</th>
                        <td><input type="text" name="saupjaNo" class="frm_input"  value="<?=$this->row['shop_company_saupja_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록증 사본</th>
                        <td><input type="file" name="saupjaFile" value="<?=$this->row['shop_company_saupja_file']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고 번호</th>
                        <td><input type="text" name="tolsinNo" class="frm_input"  value="<?=$this->row['shop_company_tolsin_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고증 사본</th>
                        <td><input type="file" name="tolsinFile" value="<?=$this->row['shop_company_tolsin_file']?>" size=60 ></td>
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
                            <input type="text" name="info[]" class="frm_input"  value="<?=$this->row['shop_info_manager'][0]?>" >
                            <input type="text" name="info[]" class="frm_input"  value="<?=$this->row['shop_info_manager'][1]?>" size=40 >
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
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
                            <input type="text" name="csEmail" class="frm_input"  value="<?=$this->row['shop_customer_service_email']?>" size=60>
                            <p class="info">메일 발송시 발신주소로 사용되는 주소입니다.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
            </div>
        </form>
        <div class="help_wrap">
            <div class="h2">도움말</div>
            <div class="h3">사업자 정보는 어디에 노출되나요?</div>
            <ul>
                <li>가맹점에서 정보를 설정하지 않은 경우에만 노출되며, 쇼핑몰 맨 하단 Footer에 노출됩니다.</li>
            </ul>
            <div class="h3">CS 운영 정보는 어디에 노출되나요?</div>
            <ul>
                <li>모든 가맹점이 동일하게 노출되며, 쇼핑몰 메인 페이지 하단 고객센터에 노출됩니다.</li>
            </ul>
        </div>
    </div>
</section>
