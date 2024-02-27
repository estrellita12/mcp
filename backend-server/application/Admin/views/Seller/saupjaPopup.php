<section class="contents">
    <h1 class="cont_title" id="pg_tit">사업자 정보</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="fsellerForm" action="/Seller/set" method="POST" enctype="MULTIPART/FORM-DATA">
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
                            <?=get_frm_radio("companyType",$num,$this->row['sl_company_type'],$type);?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">회사 이름</th>
                        <td><input type="text" name="companyName" class="frm_input"  value="<?=$this->row['sl_company_name']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">대표자 이름</th>
                        <td><input type="text" name="owner" class="frm_input"  value="<?=$this->row['sl_company_owner']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록 번호</th>
                        <td><input type="text" name="saupjaNo" class="frm_input"  value="<?=$this->row['sl_company_saupja_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록증 파일</th>
                        <td>
                            <input type="file" name="saupjaFile" class="frm_input" value="<?=$this->row['sl_company_saupja_file']?>" >
                            <?php if(!empty($this->row['sl_company_saupja_file'])) { ?>
                            <a href="<?=_FILE.$this->row['sl_company_saupja_file']?>" class="btn_small btn_white" download>다운로드</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고 번호</th>
                        <td><input type="text" name="tolsinNo" class="frm_input"  value="<?=$this->row['sl_company_tolsin_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 파일</th>
                        <td>
                            <input type="file" name="tolsinFile" class="frm_input" value="<?=$this->row['sl_company_tolsin_file']?>" >
                            <?php if(!empty($this->row['sl_company_tolsin_file'])) { ?>
                            <a href="<?=_FILE.$this->row['sl_company_tolsin_file']?>" class="btn_small btn_white" download>다운로드</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">업태</th>
                        <td><input type="text" name="companyItem" class="frm_input"  value="<?=$this->row['sl_company_item']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">종목</th>
                        <td><input type="text" name="companyService" class="frm_input"  value="<?=$this->row['sl_company_service']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 주소</th>
                        <td><input type="text" name="companyAddr" class="frm_input"  value="<?=$this->row['sl_company_addr']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 전화 번호</th>
                        <td><input type="text" name="companyTel" class="frm_input"  value="<?=$this->row['sl_company_tel']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 메일 번호</th>
                        <td><input type="text" name="companyEmail" class="frm_input"  value="<?=$this->row['sl_company_email']?>" size=60 ></td>
                    </tr>
                    </tbody>
                </table>
            </div>
           <div class="confirm_wrap">
                <input type="submit" value="수정" class="btn_medium btn_theme" accesskey="s">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
