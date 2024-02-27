<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <div class="h2">상세 검색</div>
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>기간 검색</th>
                            <td>
                                <div>
                                    <select name="term" class="w130">
                                        <?= get_frm_option('od_dt',get_request("term"), '주문일'); ?>
                                        <?= get_frm_option('od_rcent_dt', get_request("term"), '최종처리일'); ?>
                                    </select>
                                    <?=get_date_group('beg','end',false)?>
                                </div>
                                <div class="mart5">
                                    <?=get_frm_date('beg',get_request("beg"),"date")?>
                                    <?=get_frm_date('end',get_request("end"),"date")?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 공급사 :<b class="cnt"><?= $this->cnt ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] ); ?>
                        </select>
                    </span>
                    <span class="right_wrap">
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w100">  <!-- 공급사명 -->
                            <col class="w100">  <!-- 공급사ID -->
                            <col class="w100">  <!-- 정산 시작일 -->
                            <col class="w100">  <!-- 정산 종료일 -->
                            <col class="w100">  <!-- 지급 수수료 -->
                            <col class="w130">  <!-- 주문 내역 -->
                            <col class="w80">  <!-- 정산 은행 -->
                            <col class="w120">  <!-- 정산 은행 -->
                            <col class="w100">  <!-- 정산 은행 -->
                            <col class="w100">  <!-- 정산 정보 -->
                            <col class="w150">  <!-- 처리 일시 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">공급사 명</th>
                                <th scope="col">공급사 아이디</th>
                                <th scope="col">정산 시작일</th>
                                <th scope="col">정산 종료일</th>
                                <?=get_sort_tag("spay_order_commission","지급수수료")?>
                                <th scope="col">정산 주문건</th>
                                <th scope="col">정산 은행</th>
                                <th scope="col">정산 계좌번호</th>
                                <th scope="col">정산 예금주</th>
                                <th scope="col">정산 정보</th>
                                <?=get_sort_tag("spay_reg_dt","처리일시")?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($this->row as $row) { ?>
                            <tr class="list<?=$i%2?>">
                                <td class="tac"><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                                <td><?=$this->my['sl_name']?></td>
                                <td><?=$row['sl_id']?></td>
                                <td><?=$row['spay_begin']?></td>
                                <td><?=$row['spay_end']?></td>
                                <td><?=number_format($row['spay_commission'])?>원</td>
                                <td><a href="#" onclick="winOpen('/Mypage/orderListPopup/<?=$row['spay_order_idl'].",".$row['spay_cancel_idl'].",".$row['spay_delivery_idl']?>','sellerForm','900','600','yes');" >주문 내역</a></td>
                                <td><?=$row['spay_bank']?></td>
                                <td><?=$row['spay_account']?></td>
                                <td><?=$row['spay_holder']?></td>
                                <td><a href="#" onclick="winOpen('/Mypage/payInfoPopup/<?=$row['spay_id']?>','sellerForm','900','600','yes');" >상세 정보</a></td>
                                <td><?=$row['spay_reg_dt']?></td>
                            </tr>
                            <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
