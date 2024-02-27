<?php
    include_once("../common.php");

    $od_id = $_REQUEST['od_id'];
    $orderModel = new \application\Models\OrderModel();
    $row = $orderModel->get("*",array("od_id"=>$od_id));
?>

<html lang="ko"><head>
<meta charset="utf-8">
<title>주문내역 수정</title>
<link rel="stylesheet" href="https://mwo.kr/admin/css/admin.css?ver=20230117160851">
<link rel="shortcut icon" href="https://mwo.kr/data/banner/3Qg8153KHL9BefvC1M2YpXvMqC58Hp.ico" type="image/x-icon">
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var tb_url       = "https://mwo.kr";
var tb_bbs_url   = "https://mwo.kr/bbs";
var tb_shop_url  = "https://mwo.kr/shop";
var tb_admin_url = "https://mwo.kr/admin";
</script>
<script src="https://mwo.kr/js/jquery-1.8.3.min.js"></script>
<script src="https://mwo.kr/js/jquery-ui-1.10.3.custom.js"></script>
<script src="https://mwo.kr/js/common.js?ver=20230117160851"></script>
<script src="https://mwo.kr/js/categorylist.js?ver=20230117160851"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.jquery.min.js" integrity="sha512-MbDx1x0iTEQCAUPl8rkCL5QKfPGVRgxZWodQm1+dJ936z/MHayw4L9p/M0kpD3xpvtb/lYEFRUuQnInmwiKTmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.css" integrity="sha512-cm7yvgAX8av8cXybw6ZxVdmC0L6dOBwdszHDOBEFCntm1LuaSZyDeIeL261f2jm1jolnA6N5P+2NGakEHrgC7Q==" crossorigin="anonymous" referrerpolicy="no-referrer">

</head>
<body>

<div id="sodr_pop" class="new_win">
    <h1>주문내역 수정</h1>

    <section id="anc_sodr_list">
        <h4 class="anc_tit">주문상품 목록</h4>
        <ul class="anchor">
    <li><a href="#anc_sodr_list">주문상품 목록</a></li>
    <li><a href="#anc_sodr_pay">주문결제 내역</a></li>
    <li><a href="#anc_sodr_memo">관리자메모</a></li>
    <li><a href="#anc_sodr_addr">주문자/배송지 정보</a></li>
</ul>        <div class="local_desc02 local_desc">
            <p>
            주문일시 <strong>2022-08-23 00:00 (화)</strong> <span class="fc_214">|</span>
            주문총액 <strong>30,000</strong>원
            <a href="javascript:win_open('https://mwo.kr/admin/order/order_print.php?od_id=2000268964','order_print','670','600','yes');" class="btn_small blue fr"><i class="fa fa-print"></i> 주문서출력</a><span class="fc_214">|</span>
            쇼핑몰 주문번호 <strong>220823test2</strong> 
            </p>
        </div>

        <form name="frmorderform" method="post" action="./pop_orderstatusupdate.php" onsubmit="return form_submit(this);">
            <input type="hidden" name="od_id" value="2000268964">
            <input type="hidden" name="od_hp" value="010-0000-1111">
            <input type="hidden" name="od_email" value="choimr@mwd.kr">
            <input type="hidden" name="mb_id" value="비회원">
            <input type="hidden" name="pt_id" value="admin">
            <input type="hidden" name="pg_cancel" value="0">

            <div class="tbl_head01">
                <table id="sodr_list">
                    <colgroup>
                        <col class="w40">
                        <col class="w60">
                        <col>
                        <col class="w90">
                        <col class="w90">
                        <col class="w60">
                        <col class="w70">
                        <col class="w70">
                        <col class="w70">
                        <col class="w70">
                        <col class="w70">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">
                                <label for="chkall" class="sound_only">주문 전체</label>
                                <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form);">
                            </th>
                            <th scope="col">이미지</th>
                            <th scope="col">주문상품</th>
                            <th scope="col">주문상태</th>
                            <th scope="col">판매자</th>
                            <th scope="col">수량</th>
                            <th scope="col">상품금액</th>
                            <th scope="col">배송비</th>
                            <th scope="col">쿠폰할인</th>
                            <th scope="col">포인트결제</th>
                            <th scope="col">실결제액</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                                        <tr class="list0">
                        <td>
                            <input type="hidden" name="od_no[0]" value="202208232000268964">
                            <input type="hidden" name="current_status[0]" value="7">
                            <label for="chk_0" class="sound_only">2000268964</label>
                            <input type="checkbox" name="chk[]" value="0" id="chk_0">
                        </td>
                        <td>
                            <a href="https://mwo.kr/shop/view.php?index_no=40" target="_blank"><img src="https://mwo.kr/img/noimage.gif" width="40" height="40"></a>
                        </td>
                        <td class="tal">
                            <a href="https://mwo.kr/admin/goods.php?code=form&amp;w=u&amp;gs_id=40" target="_blank">6장 1세트/2022 리카타 노블레스 그레이스 컬러 양피 골프장갑</a>
                                                        <div class="sod_opt"><ul>
<li class="ty">그레이스 남성 24호 3장 2세트 (+0원)</li>
</ul></div>                                                        <textarea name="change_memo[0]" class="change_memo_area" style="display:block" placeholder="교환/반품에 대한 내용을 메모할 수 있습니다.">5 반품중</textarea>                        </td>
                        <td>
                            반품완료                                                    </td>                
                        <td>엠더블유(TEST)</td>
                        <td>2</td>
                        <td class="tar">30,000</td>
                        <td class="tar">0</td>
                        <td class="tar">0</td>
                        <td class="tar">0</td>
                        <td class="td_price">30,000</td>
                    </tr>
                                        </tbody>
                </table>
            </div>
            <div class="local_frm02">
                <i class="ionicons ion-alert-circled fc_red"></i> 환불, 반품완료 후 <b>"PG부분취소"</b>를 통해 신용카드 및 계좌이체 결제취소를 해주셔야 <b>"PG 신용카드 승인취소 처리"</b>가 완료됩니다.
            </div>

                        <div class="btn_list marb20">
                <input type="hidden" name="chk_cnt" value="1">
                <strong class="marr5">선택한 상품을</strong>
                                <input type="submit" name="act_button" value="주문상태저장" class="btn_lsmall red" onclick="document.pressed=this.value">
                
                
                                            </div>
                    </form>

        
                <section id="sodr_qty_log">
            <h3>주문 전체취소 처리 내역</h3>
            <div>
                2022-08-31 15:56:04 mwholdings 주문취소 처리<br>            </div>
        </section>
            </section>
    <section id="anc_sodr_pay" class="new_win_desc mart30">
        <h3 class="anc_tit">주문 상태 변경 내역<a href="javascript:win_open('https://mwo.kr/admin/order/order_log.php?od_id=2000268964','order_log','670','400','yes')" class="fr btn_small red">+ CS일반</a></h3>
        <div class="tbl_head01">
            <table id="sodr_list">
                <colgroup>
                    <col class="w40">
                    <col class="w150">
                    <col>
                    <!-- <col> -->
                    <col class="w150">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">처리자</th>
                        <th scope="col">처리 내용</th>
                        <!-- <th scope="col">교환/반품 메모(8/23~)</th> -->
                        <th scope="col">처리 일시</th>
                    </tr>
                </thead>
                <tbody class="list">
                                <tr>
                    <td>1</td>
                    <td>mwholdings</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>테이블 테스트</td> -->
                    <td>2022-12-05 14:54:13</td>
                </tr>
                                <tr>
                    <td>2</td>
                    <td>mwholdings</td>
                    <td class="tal">테이블 테스트</td>
                    <!-- <td></td> -->
                    <td>2022-12-05 14:54:13</td>
                </tr>
                                <tr>
                    <td>3</td>
                    <td>mwholdings</td>
                    <td class="tal">권한 테스트!</td>
                    <!-- <td></td> -->
                    <td>2022-12-05 14:51:53</td>
                </tr>
                                <tr>
                    <td>4</td>
                    <td>mwholdings</td>
                    <td class="tal">공급사 테스트입니다.</td>
                    <!-- <td></td> -->
                    <td>2022-12-05 14:36:20</td>
                </tr>
                                <tr>
                    <td>5</td>
                    <td>admin</td>
                    <td class="tal">배송 후 반품</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 13:16:26</td>
                </tr>
                                <tr>
                    <td>6</td>
                    <td>admin</td>
                    <td class="tal">반품 중</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 13:16:06</td>
                </tr>
                                <tr>
                    <td>7</td>
                    <td>admin</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>5 반품중</td> -->
                    <td>2022-09-15 12:45:36</td>
                </tr>
                                <tr>
                    <td>8</td>
                    <td>admin</td>
                    <td class="tal">반품신청</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 12:45:36</td>
                </tr>
                                <tr>
                    <td>9</td>
                    <td>admin</td>
                    <td class="tal">반품 중</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 12:45:15</td>
                </tr>
                                <tr>
                    <td>10</td>
                    <td>admin</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>5 반품중</td> -->
                    <td>2022-09-15 12:44:29</td>
                </tr>
                                <tr>
                    <td>11</td>
                    <td>admin</td>
                    <td class="tal">반품신청</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 12:44:29</td>
                </tr>
                                <tr>
                    <td>12</td>
                    <td>admin</td>
                    <td class="tal">교환 중</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 12:44:07</td>
                </tr>
                                <tr>
                    <td>13</td>
                    <td>admin</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>5 반품중</td> -->
                    <td>2022-09-15 12:41:44</td>
                </tr>
                                <tr>
                    <td>14</td>
                    <td>admin</td>
                    <td class="tal">교환신청</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 12:41:44</td>
                </tr>
                                <tr>
                    <td>15</td>
                    <td>admin</td>
                    <td class="tal">교환 중</td>
                    <!-- <td></td> -->
                    <td>2022-09-15 12:41:26</td>
                </tr>
                                <tr>
                    <td>16</td>
                    <td>fofo36</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>5 반품중</td> -->
                    <td>2022-09-05 16:31:57</td>
                </tr>
                                <tr>
                    <td>17</td>
                    <td>fofo36</td>
                    <td class="tal">교환신청</td>
                    <!-- <td></td> -->
                    <td>2022-09-05 16:31:57</td>
                </tr>
                                <tr>
                    <td>18</td>
                    <td>mwholdings</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>5 반품중</td> -->
                    <td>2022-08-31 16:27:56</td>
                </tr>
                                <tr>
                    <td>19</td>
                    <td>mwholdings</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>1 반품신청
2 반품중
1 반품신청
3 반품완료
4 반품중
5 반품중</td> -->
                    <td>2022-08-31 16:26:18</td>
                </tr>
                                <tr>
                    <td>20</td>
                    <td>admin</td>
                    <td class="tal">교환/반품 메모 수정</td>
                    <!-- <td>1 반품신청
2 반품중
1 반품신청
3 반품완료
4 반품중</td> -->
                    <td>2022-08-31 16:25:08</td>
                </tr>
                                <tr>
                    <td>21</td>
                    <td>mwholdings</td>
                    <td class="tal">배송 후 반품</td>
                    <!-- <td></td> -->
                    <td>2022-08-31 15:56:04</td>
                </tr>
                                <tr>
                    <td>22</td>
                    <td>admin</td>
                    <td class="tal">반품신청</td>
                    <!-- <td></td> -->
                    <td>2022-08-31 15:54:44</td>
                </tr>
                                <tr>
                    <td>23</td>
                    <td>mwholdings</td>
                    <td class="tal">반품 중</td>
                    <!-- <td></td> -->
                    <td>2022-08-31 15:53:31</td>
                </tr>
                                <tr>
                    <td>24</td>
                    <td>mwholdings</td>
                    <td class="tal">반품신청</td>
                    <!-- <td></td> -->
                    <td>2022-08-31 15:53:12</td>
                </tr>
                                <tr>
                    <td>25</td>
                    <td>mwholdings</td>
                    <td class="tal">배송완료</td>
                    <!-- <td></td> -->
                    <td>2022-08-25 12:09:36</td>
                </tr>
                                <tr>
                    <td>26</td>
                    <td>mwholdings</td>
                    <td class="tal">배송준비</td>
                    <!-- <td></td> -->
                    <td>2022-08-25 12:08:26</td>
                </tr>
                                <tr>
                    <td>27</td>
                    <td>admin</td>
                    <td class="tal">사방넷 주문서 수집</td>
                    <!-- <td></td> -->
                    <td>2022-08-23 09:20:01</td>
                </tr>
                                </tbody>
            </table>
        </div> 
    </section>
    
    <section id="anc_sodr_pay" class="new_win_desc mart30">
        <h3 class="anc_tit">주문결제 내역</h3>
        <ul class="anchor">
    <li><a href="#anc_sodr_list">주문상품 목록</a></li>
    <li><a href="#anc_sodr_pay">주문결제 내역</a></li>
    <li><a href="#anc_sodr_memo">관리자메모</a></li>
    <li><a href="#anc_sodr_addr">주문자/배송지 정보</a></li>
</ul>        <form name="frmorderreceiptform" action="./pop_orderformupdate.php" method="post" autocomplete="off">
            <input type="hidden" name="od_id" value="2000268964">
            <input type="hidden" name="mod_type" value="receipt">

            <div class="compare_wrap">
                <section id="anc_sodr_chk" class="compare_left">
                    <h3>결제상세정보 확인</h3>

                    <div class="tbl_frm01">
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">총 주문금액</th>
                                <td class="td_price">30,000원</td>
                            </tr>
                            <tr>
                                <th scope="row">총 상품금액</th>
                                <td class="td_price bg0">30,000원</td>
                            </tr>
                            <tr>
                                <th scope="row" class="fc_197">교환/반품 배송비</th>
                                <td class="td_price fc_197">(+) <input type="text" name="baesong2" value="0" class="frm_input td_price fc_197"></td>
                            </tr>
                            <tr>
                                <th scope="row" class="fc_red">부분 취소 금액<br>(정산시 배송중,배송완료 상태값에만 적용)</th>
                                <td class="td_price bg1 fc_red">(-) <input type="text" name="cancel" value="0" class="td_price fc_red frm_input"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="anc_sodr_paymo" class="compare_right">
                    <h3>결제상세정보 수정</h3>

                    <div class="tbl_frm01">
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">주문번호</th>
                                <td>2000268964</td>
                            </tr>
                            <tr>
                                <th scope="row">주문일시</th>
                                <td>2022-08-23 00:00:00 (화)</td>
                            </tr>
                            <tr>
                                <th scope="row">주문채널</th>
                                <td><strong></strong> PC 쇼핑몰에서 주문</td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="pt_id">가맹점 ID</label></th>
                                <td><input type="text" name="pt_id" value="admin" id="pt_id" class="frm_input" placeholder="없음"> (배송완료 후 수정불가)</td>
                            </tr>
                            <tr>
                                <th scope="row">결제방법</th>
                                <td>-</td>
                            </tr>
                            
                            
                            
                            
                            
                                                        <tr>
                                <th scope="row">결제대행사 링크</th>
                                <td>
                                    <a href="" target="_blank" class="btn_small blue">바로가기</a>                                </td>
                            </tr>
                                                        <tr>
                                <th scope="row">개별 전자결제(PG)</th>
                                <td><strong></strong> PG설정으로 주문</td>
                            </tr>
                                                                                    </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <div class="btn_confirm">
                <input type="submit" value="결제정보 수정" class="btn_medium">
                <a href="javascript:window.close();" class="btn_medium bx-white">닫기</a>
            </div>
        </form>
    </section>

    <section id="anc_sodr_memo">
        <h3 class="anc_tit">관리자메모</h3>
        <ul class="anchor">
    <li><a href="#anc_sodr_list">주문상품 목록</a></li>
    <li><a href="#anc_sodr_pay">주문결제 내역</a></li>
    <li><a href="#anc_sodr_memo">관리자메모</a></li>
    <li><a href="#anc_sodr_addr">주문자/배송지 정보</a></li>
</ul>        <div class="local_desc02 local_desc">
            <p>현재 열람 중인 주문에 대한 내용을 메모하는곳입니다.</p>
        </div>

        <form name="frmorderform3" action="./pop_orderformupdate.php" method="post">
            <input type="hidden" name="od_id" value="2000268964">
            <input type="hidden" name="mod_type" value="memo">

            <label for="shop_memo" class="sound_only">관리자메모</label>
            <textarea name="shop_memo" id="shop_memo" rows="8" class="frm_textbox">쇼핑몰명 : 더블플래그(일반), 쇼핑몰 주문번호 : 220823test2
송장등록일시 : 2022-08-25 12:12:31
송장등록일시 : 2022-08-25 12:24:06</textarea>

            <div class="btn_confirm">
                <input type="submit" value="관리자메모 수정" class="btn_medium">
                <a href="javascript:window.close();" class="btn_medium bx-white">닫기</a>
            </div>
        </form>
    </section>

    <section id="anc_sodr_addr">
        <h3 class="anc_tit">주문자/배송지 정보</h3>
        <ul class="anchor">
    <li><a href="#anc_sodr_list">주문상품 목록</a></li>
    <li><a href="#anc_sodr_pay">주문결제 내역</a></li>
    <li><a href="#anc_sodr_memo">관리자메모</a></li>
    <li><a href="#anc_sodr_addr">주문자/배송지 정보</a></li>
</ul>
        <form name="frmorderform2" action="./pop_orderformupdate.php" method="post">
            <input type="hidden" name="od_id" value="2000268964">
            <input type="hidden" name="mod_type" value="info">

            <div class="compare_wrap">
                <section id="anc_sodr_orderer" class="compare_left">
                    <h3>주문하신 분</h3>

                    <div class="tbl_frm01">
                        <table>
                            <colgroup>
                                <col class="w100">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row"><label for="od_name">이름</label></th>
                                <td><input type="text" name="name" value="테스트2" id="od_name" required="" class="frm_input required" style="background-position: right top; background-repeat: no-repeat;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="telephone">전화번호</label></th>
                                <td><input type="text" name="telephone" value="010-0000-1111" id="telephone" class="frm_input"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="cellphone">핸드폰</label></th>
                                <td><input type="text" name="cellphone" value="010-0000-1111" id="cellphone" required="" class="frm_input required" style="background-position: right top; background-repeat: no-repeat;"></td>
                            </tr>
                            <tr>
                                <th scope="row">주소</th>
                                <td>
                                    <label for="zip" class="sound_only">우편번호</label>
                                    <input type="text" name="zip" value="42166" id="zip" required="" class="frm_input required" size="5" maxlength="5" style="background-position: right top; background-repeat: no-repeat;">
                                    <button type="button" class="btn_small grey" onclick="win_zip('frmorderform2', 'zip', 'addr1', 'addr2', 'addr3', 'addr_jibeon');">주소검색</button><br>
                                    <span id="od_win_zip" style="display:block"></span>
                                    <input type="text" name="addr1" value="대구광역시 수성구 수성로 71(상동, 수성동일하이빌레이크시티아파트) 113동1305호" id="addr1" required="" class="frm_input required" size="35" style="background-position: right top; background-repeat: no-repeat;">
                                    <label for="addr1">기본주소</label><br>
                                    <input type="text" name="addr2" value="" id="addr2" class="frm_input" size="35">
                                    <label for="addr2">상세주소</label><br>
                                    <input type="text" name="addr3" value="" id="addr3" class="frm_input" size="35">
                                    <label for="addr3">참고항목</label><br>
                                    <input type="hidden" name="addr_jibeon" value="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="od_email">E-mail</label></th>
                                <td><input type="text" name="email" value="choimr@mwd.kr" id="od_email" required="" class="frm_input required" size="30" style="background-position: right top; background-repeat: no-repeat;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><span class="sound_only">주문하신 분 </span>IP Address</th>
                                <td>더블플래그(일반)</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="anc_sodr_taker" class="compare_right">
                    <h3>받으시는 분</h3>

                    <div class="tbl_frm01">
                        <table>
                            <colgroup>
                                <col class="w100">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row"><label for="b_name">이름</label></th>
                                <td><input type="text" name="b_name" value="테스트2" id="b_name" required="" class="frm_input required" style="background-position: right top; background-repeat: no-repeat;"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="b_telephone">전화번호</label></th>
                                <td><input type="text" name="b_telephone" value="010-0000-1111" id="b_telephone" class="frm_input"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="b_cellphone">핸드폰</label></th>
                                <td><input type="text" name="b_cellphone" value="010-0000-1111" id="b_cellphone" required="" class="frm_input required" style="background-position: right top; background-repeat: no-repeat;"></td>
                            </tr>
                            <tr>
                                <th scope="row">주소</th>
                                <td>
                                    <label for="b_zip" class="sound_only">우편번호</label>
                                    <input type="text" name="b_zip" value="42166" id="b_zip" required="" class="frm_input required" size="5" maxlength="5" style="background-position: right top; background-repeat: no-repeat;">
                                    <button type="button" class="btn_small grey" onclick="win_zip('frmorderform2', 'b_zip', 'b_addr1', 'b_addr2', 'b_addr3', 'b_addr_jibeon');">주소검색</button><br>
                                    <input type="text" name="b_addr1" value="대구광역시 수성구 수성로 71(상동, 수성동일하이빌레이크시티아파트) 113동1305호" id="b_addr1" required="" class="frm_input required" size="35" style="background-position: right top; background-repeat: no-repeat;">
                                    <label for="b_addr1">기본주소</label><br>
                                    <input type="text" name="b_addr2" value="" id="b_addr2" class="frm_input" size="35">
                                    <label for="b_addr2">상세주소</label><br>
                                    <input type="text" name="b_addr3" value="" id="b_addr3" class="frm_input" size="35">
                                    <label for="b_addr3">참고항목</label><br>
                                    <input type="hidden" name="b_addr_jibeon" value="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">전달 메세지</th>
                                <td>없음</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <div class="btn_confirm">
                <input type="submit" value="주문자/배송지 정보 수정" class="btn_medium">
                <a href="javascript:window.close();" class="btn_medium bx-white">닫기</a>
            </div>
        </form>
    </section>

</div>

<script>
$(function() {
        // 부분취소창
        $(".orderpartcancel").on("click", function() {
                var href = this.href;
                window.open(href, "partcancelwin", "left=100, top=100, width=600, height=350, scrollbars=yes");
                return false;
                });

        // 2022-02-21 교환, 반품 관련 상태 선택 시 관리자 메모 입력 추가
        $("#order_stat_box").on("change", function(){
                console.log($(this).val());
                $('.change_memo_area').css('display', [7,8,10,11,12,13].includes(Number($(this).val())) && 'block'||'none');
                });
        });

function form_submit(f)
{
    var status = document.pressed;

    if(!is_checked("chk[]")) {
        alert("처리할 자료를 하나 이상 선택해 주십시오.");
        return false;
    }

    if(status == "운송장번호수정") {
        f.action = "./pop_orderbaesongupdate.php";
        return true;
    }

    var $chk = $("input[name='chk[]']");
    var chk_cnt = $chk.size();
    var chked_cnt = $chk.filter(":checked").size();

    if(status == "결제완료" || status == "입금대기" || status == "주문취소" || status == "전체환불" || status == "전체반품") {
        if(chk_cnt != chked_cnt) {
            alert("처리할 자료를 모두 선택해주세요.\n\n일부 상품만 처리할 수 없습니다.");
            return false;
        }
    }

    if(confirm("주문상태를 변경하시겠습니까?")) {
        return true;
    } else {
        return false;
    }
}
</script>


<div id="ajax-loading"><img src="https://mwo.kr/img/ajax-loader.gif"></div>

<script src="https://mwo.kr/admin/js/admin.js?ver=20230117160851"></script>

<script src="https://mwo.kr/js/wrest.js"></script>


</body></html>
