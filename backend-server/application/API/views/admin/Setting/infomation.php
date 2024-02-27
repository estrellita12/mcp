<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?> </h1>
        <form action="/Setting/setDefault" method="POST" onsubmit="fSubmit(this);">
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->row['id']?>">
                <h2>기본 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">쇼핑몰 도메인</th>
                        <td>https://<input type="text" id="shop_url" name="shop_url" value="<?=$this->row['shop_url']?>"></td>
                    </tr>
                    <tr>
                        <th scope="row">SSO 정보</th>
                        <td>
                            <input type="checkbox" name="sso_yn" value="Y" id="sso_yn" <?=$this->row['sso_yn']=="y"?"checked":""?>> 
                            <label for="sso_yn">회원 SSO 연결 사용</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가격 정책</th>
                        <td>
                            <select id="grade" name="grade">
                                <option value="9" selected="selected">A 오픈마켓</option>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="rhead01_wrap">
                <h2>사업자 정보</h2>
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
                            <?=get_frm_radio("company_type",$num,$this->row['company_type'],$type);?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">회사 이름</th>
                        <td><input type="text" name="company_name" class="frm_input"  value="<?=$this->row['company_name']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">대표자 이름</th>
                        <td><input type="text" name="company_owner" class="frm_input"  value="<?=$this->row['company_owner']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">사업자 등록 번호</th>
                        <td><input type="text" name="company_saupja_no" class="frm_input"  value="<?=$this->row['company_saupja_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">통신 판매업 신고 번호</th>
                        <td><input type="text" name="company_tolsin_no" class="frm_input"  value="<?=$this->row['company_tolsin_no']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">업태</th>
                        <td><input type="text" name="company_item" class="frm_input"  value="<?=$this->row['company_item']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">종목</th>
                        <td><input type="text" name="company_service" class="frm_input"  value="<?=$this->row['company_service']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 주소</th>
                        <td><input type="text" name="company_addr" class="frm_input"  value="<?=$this->row['company_addr']?>" size=100 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 전화 번호</th>
                        <td><input type="text" name="company_tel" class="frm_input"  value="<?=$this->row['company_tel']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 팩스 번호</th>
                        <td><input type="text" name="company_fax" class="frm_input"  value="<?=$this->row['company_fax']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">회사 메일 번호</th>
                        <td><input type="text" name="company_email" class="frm_input"  value="<?=$this->row['company_email']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">정보 책임자</th>
                        <td>
                            <input type="text" name="info_name" class="frm_input"  value="<?=$this->row['info_name']?>" >
                            <input type="text" name="info_email" class="frm_input"  value="<?=$this->row['info_email']?>" size=40 >
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2 class="mart30">포인트/쿠폰 정책</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">쿠폰 사용 여부</th>
                        <td colspan="3">
                            <?=get_frm_radio("coupon_yn","y",$this->row['coupon_yn'],"사용");?>
                            <?=get_frm_radio("coupon_yn","n",$this->row['coupon_yn'],"미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">포인트 사용 여부</th>
                        <td colspan="3">
                            <?=get_frm_radio("point_yn","y",$this->row['point_yn'],"사용");?>
                            <?=get_frm_radio("point_yn","n",$this->row['point_yn'],"미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">최소 결제 포인트</th>
                        <td><input type="text" name="point_use_min" class="frm_input w80 tar" maxlength="7"  value="<?=number_format($this->row['point_use_min'])?>" onkeyup="inputNumberFormat(this)" >point</td>
                        <th scope="col">최대 결제 포인트</th>
                        <td><input type="text" name="point_use_max" class="frm_input w80 tar"  maxlength="8" value="<?=number_format($this->row['point_use_max'])?>" onkeyup="inputNumberFormat(this)" >point</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </section>
</div>
<script>
function fSubmit(obj){
    var min = uncomma( obj['point_use_min'].value );
    obj['point_use_min'].value = min;;
    var max = uncomma( obj['point_use_max'].value );
    obj['point_use_max'].value = max;
}   
</script>
