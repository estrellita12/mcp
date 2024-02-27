<div id="newWin">
    <div class="pg_header">
        <p class="pg_tit" id="pg_tit">주문 상세 정보</p>
    </div>
    <section class="popup_inner">
        <ul class="tabs">
            <li><a href="#od_goods">주문 상품 목록</a></li>
            <li><a href="#od_paymethod">주문 결제 내역</a></li>
        </ul>
        <div class="tab_container">
            <div id="od_goods" class="tab_content">
                <form name="fregisterForm" action="/Popup/memberFormUpdate" method="POST">
                    <div class="chead01_wrap">
                        <input type="hidden" name="id" value="<?=$this->row['id']?>">
                        <h2>주문 상품 목록</h2>
                        <div class="para">주문 일시 <b><?=$this->row['od_time']?></b> | 주문 총액 <b><?=number_format($this->row['sum_use_price'])?></b>원 </div>
                        <table>
                            <colgroup>
                                <col class="w50">
                                <col class="w60">
                                <col>
                                <col class="w110">
                                <col class="w80">
                                <col class="w50">
                                <col class="w70">
                                <col class="w60">
                                <col class="w70">
                                <col class="w70">
                                <col class="w70">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">이미지</th>
                                    <th scope="col">주문상품</th>
                                    <th scope="col">주문상태</th>
                                    <th scope="col">공급사</th>
                                    <th scope="col">수량</th>
                                    <th scope="col">상품금액</th>
                                    <th scope="col">배송비</th>
                                    <th scope="col">쿠폰할인</th>
                                    <th scope="col">포인트할인</th>
                                    <th scope="col">실결제액</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach($this->row as $od) { $gs = unserialize($od['od_goods']); ?>
                            <tr class="list<?=$i%2?>">
                                <td>
                                    <input type="hidden" name="idx[<?=$i?>]" value="<?=$od['od_id']?>">
                                    <input type="checkbox" name="chk[]">
                                </td>
                                <td>
                                    <a href="" title="상품 상세 페이지로 이동"><img src='https://killdeal.co.kr/data/goods/<?=$gs['simg1']?>' alt='' class="gs_img" width="40px"></a>
                                </td>
                                <td class="tal">
                                    <a href="" title="상품 수정 페이지로 이동" class="gs_name"><?=$gs['gname']?></a>
                                    <p class="gs_option">옵션</p>
                                    <p class="baesong_frm">
                                    <select>
                                        <option>배송사 선택</option>
                                    </select>
                                    <input type="text" placeholder="개별 운송장 번호">
                                    </p>
                                </td>
                                <td>
                                    <select>
                                        <?php foreach( $GLOBALS['od_status'] as $num=>$x ){ ?>
                                        <?=get_frm_option($num,$od['dan'],$x)?>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><?=$this->seller->getName($od['seller_id'])?></td>
                                <td><?=$od['sum_qty']?></td>
                                <td><?=number_format($od['goods_price'])?></td>
                                <td><?=number_format($od['baesong_price'])?></td>
                                <td><?=number_format($od['use_coupon'])?></td>
                                <td><?=number_format($od['use_point'])?></td>
                                <td><?=number_format($od['use_price'])?></td>
                            </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                        <p class="para mart10">
                        <span class="marr5">선택한 상품을</span>
                        <button class="btn_small btn_red">주문상태저장</button> 
                        <button class="btn_small btn_white">운송장 번호 수정</button> 
                        </p>
                    </div>
                </form>
            </div>
            <div id="od_paymethod" class="tab_content ">
                <form name="fregisterForm" action="/Popup/memberFormUpdate" method="POST">
                    <div class="rhead01_wrap">
                        <h2>관리자 메모</h2>
                        <textarea></textarea>
                        <div class="confirm_wrap">
                            <button class="btn_medium btn_black">관리자 메모 수정</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="od_paymethod" class="tab_content">
                <div class="twin01_wrap fixed-clear">
                    <h2>결제 상세 정보</h2>
                    <div>
                        <h3 class="tac padb10">결제 상세 정보</h3>
                        <table>
                            <colgroup>
                                <col class="w100">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">총 상품 금액</th>
                                <td class="bg_white"><?=number_format($this->row['sum_goods_price'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">총 배송비</th>
                                <td><span>(+) </span><?=number_format($this->row['sum_baesong_price'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">총 쿠폰할인</th>
                                <td><span>(-) </span><?=number_format($this->row['sum_coupon_price'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">총 포인트할인</th>
                                <td><span>(-) </span><?=number_format($this->row['sum_use_point'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">실 결제 금액</th>
                                <td class="bg_white"><?=number_format($this->row['sum_use_price'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">환불 취소액 </th>
                                <td><?=number_format($this->row['sum_calcel_price'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">포인트 적립 </th>
                                <td><?=number_format($this->row['use_point_ice'])?></td>
                            </tr>
                            <tbody>
                        </table>
                    </div>
                    <div>
                        <h3 class="tac padb10">결제 상세 정보</h3>
                        <table>
                            <colgroup>
                                <col class="w100">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">주문 번호</th>
                                <td><?=number_format($this->row['use_point_ice'])?></td>
                                <tr>
                                    <th scope="row">주문 일시</th>
                                    <td><?=$this->row['od_time']?></td>
                                </tr>
                                <tr>
                                    <th scope="row">가맹점</th>
                                    <td><?=$this->partner->getName($this->row['pt_id'])?></td>
                                </tr>
                                <tr>
                                    <th scope="row">주문 채널</th>
                                    <td><?=$this->row['od_mobile']?"모바일 주문":"PC 주문"?></td>
                                </tr>
                                <tr>
                                    <th scope="row">결제 방법</th>
                                    <td><?=$this->row['paymethod']?></td>
                                </tr>
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="od_paymethod" class="tab_content">
                <div class="twin01_wrap fixed-clear">
                    <h2>주문자 / 배송지 정보</h2>
                    <div>
                        <h3 class="tac padb10">주문하신 분</h3>
                        <table>
                            <colgroup>
                                <col class="w100">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">이름</th>
                                <td><input type="text" name="name" value="<?=$this->row['name']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">전화번호</th>
                                <td><input type="text" name="cellphone" value="<?=$this->row['cellphone']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">주소</th>
                                <td>
                                    <label for="reg_mb_zip" class="sound_only">우편번호</label>
                                    <input type="text" name="zip" id="mb_zip"  size="8" maxlength="5">
                                    <button type="button" class="btn_small btn_black" onclick="win_zip('fregisterForm', 'zip', 'addr1', 'addr2', 'addr3');">주소검색</button><br>
                                    <input type="text" name="addr1" id="mb_addr1" class="frm_address" size="30">
                                    <label for="reg_mb_addr1">기본주소</label><br>
                                    <input type="text" name="addr2" id="mb_addr2" class="frm_address" size="30">
                                    <label for="reg_mb_addr2">상세주소</label><br>
                                    <input type="text" name="addr3" id="reg_mb_addr3" class="frm_address" size="30" readonly="readonly">
                                    <label for="reg_mb_addr3">참고항목</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail</th>
                                <td><input type="text" name="email" value="<?=$this->row['email']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">IP Address</th>
                                <td><?=$this->row['od_ip']?></td>
                            </tr>
                            <tbody>
                        </table>
                    </div>
                    <div>
                        <h3 class="tac padb10">받으시는 분</h3>
                        <table>
                            <colgroup>
                                <col class="w100">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">이름</th>
                                <td><input type="text" name="name" value="<?=$this->row['name']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">전화번호</th>
                                <td><input type="text" name="name" value="<?=$this->row['name']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">주소</th>
                                <td>
                                    <label for="reg_mb_zip" class="sound_only">우편번호</label>
                                    <input type="text" name="zip" id="mb_zip"  size="8" maxlength="5">
                                    <button type="button" class="btn_small btn_black" onclick="win_zip('fregisterForm', 'zip', 'addr1', 'addr2', 'addr3');">주소검색</button><br>
                                    <input type="text" name="addr1" id="mb_addr1" class="frm_address" size="30">
                                    <label for="reg_mb_addr1">기본주소</label><br>
                                    <input type="text" name="addr2" id="mb_addr2" class="frm_address" size="30">
                                    <label for="reg_mb_addr2">상세주소</label><br>
                                    <input type="text" name="addr3" id="reg_mb_addr3" class="frm_address" size="30" readonly="readonly">
                                    <label for="reg_mb_addr3">참고항목</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">전달메세지</th>
                                <td><?=$this->row['b_addr_jipeon']==""?"없음":$this->row['b_addr_jipeon']?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <button class="btn_medium btn_black">관리자 메모 수정</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(function(){
        /*
           $(".tab_content").hide();
           $("ul.tabs li:first").addClass("active").show();
           $(".tab_content:first").show();
           $("#pg_tit").html ( $("ul.tabs li:first").children("a").html()) ;

           $("ul.tabs li").click(function() {
           $("ul.tabs li").removeClass("active");
           $(this).addClass("active");
           $(".tab_content").hide();

           var activeTab = $(this).find("a").attr("href");
           $(activeTab).fadeIn();

           $("#pg_tit").html ( $(this).children("a").html() );
           return false;
           });
         */
        });

</script>
