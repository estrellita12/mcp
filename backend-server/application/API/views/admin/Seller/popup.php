<div id="newWin">
    <div class="pg_header">
        <p class="pg_tit" id="pg_tit">가맹점 정보</p>
    </div>
    <section class="popup_inner">
        <ul class="tabs">
            <li><a href="#seller">공급사 정보</a></li>
            <li><a href="#baesong">배송 정책 정보</a></li>
        </ul>
        <div class="tab_container">
            <div id="seller" class="tab_content">
                <form name="fsellerForm" action="/Seller/set" method="POST">
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
                                <th scope="row">공급사명</th>
                                <td>
                                    <input type="text" name="name" value="<?=$this->row['name']?>" required itemname="공급사명" class="required">
                                </td>
                                <th scope="row">승인 상태</th>
                                <td><?=$GLOBALS['sl_state'][$this->row['state']]?></td>
                            </tr>
                            <tr>
                                <th scope="row">아이디</th>
                                <td><?=$this->row['id']?></td>
                                <th scope="row">비밀번호</th>
                                <td><input type="text" name="passwd" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">등급</th>
                                <td colspan="3">
                                    <select id="grade" name="grade">
                                        <?php foreach($this->gr_li as $idx=>$name){ ?>
                                        <?= get_frm_option( $idx, $this->row['grade'], $name) ;?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">수수료</th>
                                <td colspan="3"><input type="text" name="pay_rate" value="<?=$this->row['pay_rate']?>" placeholder=""></td>
                            </tr>
                            <tr>
                                <th scope="row">은행정보</th>
                                <td colspan="3">
                                    <input type="text" name="bank_name" value="<?=$this->row['bank_name']?>" placeholder="은행명">
                                    <input type="text" name="bank_account" value="<?=$this->row['bank_account']?>" placeholder="계좌번호" size="30">
                                    <input type="text" name="bank_holder" value="<?=$this->row['bank_holder']?>" placeholder="예금주명">
                                    <div class="info"><p>※ 계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</p></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <input type="hidden" name="id" value="<?=$this->row['id']?>">
                        <h2>담당자 정보</h2>
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
                                <td><input type="text" name="manager_name" value="<?=$this->row['manager_name']?>" placeholder=""></td>
                                <th scope="row">담당자 전화번호</th>
                                <td><input type="text" name="manager_cellphone" value="<?=$this->row['manager_cellphone']?>"  placeholder=""></td>
                            </tr>
                            <tr>
                                <th scope="row">담당자 메일</th>
                                <td colspan="3"><input type="text" name="manager_email" value="<?=$this->row['manager_email']?>" placeholder=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>사업자 정보</h2>
                        <table>
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
                                    <input type="text" name="company_name" value="<?=$this->row['company_name']?>">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">사업자 유형</th>
                                <td colspan="3">
                                    <?= get_frm_radio("company_type","1",$this->row['company_type'],"일반과세자");?>
                                    <?= get_frm_radio("company_type","2",$this->row['company_type'],"간이과세자");?>
                                    <?= get_frm_radio("company_type","3",$this->row['company_type'],"면세사업자");?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">대표명</th>
                                <td colspan="3">
                                    <input type="text" name="company_owner" value="<?=$this->row['company_owner']?>">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">사업장주소</th>
                                <td colspan="3">
                                    <input type="text" name="company_addr" value="<?=$this->row['company_addr']?>" size=50>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">대표 전화 번호</th>
                                <td><input type="text" name="company_tel" value="<?=$this->row['company_tel']?>"></td>
                                <th scope="row">대표 이메일</th>
                                <td><input type="text" name="company_email" value="<?=$this->row['company_email']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">사업자등록번호</th>
                                <td><input type="text" name="company_saupja_no" value="<?=$this->row['company_saupja_no']?>"></td>
                                <th scope="row">파일</th>
                                <td><input type="file" name="saupja_file"></td>
                            </tr>
                            <tr>
                                <th scope="row">업태</th>
                                <td><input type="text"></td>
                                <th scope="row">종목</th>
                                <td><input type="text"></td>
                            </tr>
                            <tr>
                                <th scope="row">관리자메모</th>
                                <td colspan="3"><textarea name="memo" class="frm_textbox" rows="3"></textarea></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black" accesskey="s">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="baesong" class="tab_content">
                <form action="/Seller/baesongUpdate" method="POST" onsubmit="return fregform_submit(this);">
                    <input type="hidden" name="id" value="<?=$this->param['ident']?>">
                    <div class="rhead01_wrap">
                        <h2>배송 정책</h2>
                        <table>
                            <colgroup>
                                <col class="w130">
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row" rowspan="4">기본 배송 정책</th>
                                <td><?=get_frm_radio('dv_charge_method','1',$this->row['dv_charge_method'],'무료 배송');?></td>
                                <td>배송비가 부과되지 않습니다.</td>
                            </tr>
                            <tr>
                                <td><?=get_frm_radio('dv_charge_method','2',$this->row['dv_charge_method'],'착불 배송');?> </td>
                                <td>주문시 또는 장바구니에 배송비가 [착불]이라는 글이 출력되며 배송비는 부과되지 않습니다.</td>
                            </tr>
                            <tr>
                                <td><?=get_frm_radio('dv_charge_method','3',$this->row['dv_charge_method'],'유료 배송');?> </td>
                                <td><input type="text" name="dv_charge_3">원을 주문 금액 또는 수량에 상관없이 동일 주문건에 배송비를 한번만 부과됩니다.</td>
                            </tr>
                            <tr>
                                <td><?=get_frm_radio('dv_charge_method','4',$this->row['dv_charge_method'],'조건부 무료 배송');?> </td>
                                <td><input type="text" name="dv_charge_4">원의 배송비를 부과하며, 단 주문금액이 <input type="text" name="dv_charge_free">이면 무료배송 처리됩니다.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>배송/교환/반품 안내</h2>
                        <div class="info"><p>※SSO연동을 진행하는 경우, 반드시 입력해야하는 정보입니다.</p></div>
                        <div>   
                            <?php echo editor_html('baesong_cont', get_text($this->row['baesong_cont'],0)); ?>
                        </div>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black" accesskey="s">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
function fregform_submit(f) {
    <?php echo get_editor_js('baesong_cont'); ?>

    return true;
}

$(document).ready(function() {
        //$(".tab_content").hide(); 
        $("ul.tabs li:first").addClass("active").show(); 
        $(".tab_content:first").show(); 
        $("#pg_tit").html ( $("ul.tabs li:first").children("a").html()) ;

        $("ul.tabs li").click(function() {
                $("ul.tabs li").removeClass("active"); 
                $(this).addClass("active"); 
                $(".tab_content").hide(); 
                var activeTab = $(this).find("a").attr("href");
                $(activeTab).fadeIn("fast");
                $("#pg_tit").html ( $(this).children("a").html() );
                $('.naver_se2').css('height', '300px'); 
                $('.naver_se2').attr('src',$('.naver_se2').attr('src'));
                return false;
                });

        });
</script>
