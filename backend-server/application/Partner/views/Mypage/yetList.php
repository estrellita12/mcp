<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="pg_info marl10">
        최종처리일이 선택 기간에 포함되는 주문건들이 정산 대상 주문건들입니다.<br>
        주문 상태가 <b>
            <?php foreach( explode(",",$GLOBALS['od_stt_type']['정산']) as $type){
            echo $GLOBALS['od_stt'][$type]['title'].",";
            }
            ?>
        </b>주문건들은 기본 정산으로 진행하고,<br>
        정산 완료 처리된 <b>반품 완료</b>건만 차감 정산으로 진행합니다.
    </div>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <div>
                                <select name="term" class="w130">
                                    <?= get_frm_option('od_dt', get_request("term"), '주문일'); ?>
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
        <div class="list_wrap">
            <div class="rect_wrap">
                <span class="cnt_wrap">
                    검색된 주문건 :<b class="cnt"><?= $this->cnt ?></b>개
                </span>
                <span class="rpp_wrap">
                    <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                        <?= get_frm_rpp( $_REQUEST['rpp'] ); ?>
                    </select>
                </span>
                <span class="right_wrap">
                    <a href="/Mypage/yetListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel" id="getDownload"> 엑셀저장</a>
                </span>
            </div>
            <div class="chead01_wrap" id="reload_wrap">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="w40"></th>
                            <th scope="col" class="w140">주문일시</th>
                            <th scope="col" class="w120">주문번호</th>
                            <th scope="col" class="w100">주문일련번호</th>
                            <th scope="col" class="w120">상품명</th>
                            <th scope="col" class="w100">총상품금액</th>
                            <th scope="col" class="w100">포인트금액</th>
                            <th scope="col" class="w100">쿠폰금액</th>
                            <th scope="col" class="w100">정산금액</th>
                            <th scope="col" class="w80">결제방법</th>
                            <th scope="col" class="w100">주문상태</th>
                            <th scope="col" class="w140">최종처리일시</th>
                            <th scope="col" class="w80">정산상태</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach($this->row as $row) { $goods = json_decode($row['od_goods_info'],true)?>
                    <tr class="list<?=$i%2?>">
                        <td class="tac"><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                        <td><?=$row['od_dt']?></td>
                        <td><?=od_no($row['od_no'])?></td>
                        <td><?=od_id($row['od_id'])?></td>
                        <td><?=$goods['goodsName']?></td>
                        <td><?=number_format($row['od_goods_price'])?>원</td>
                        <td><?=number_format($row['od_use_point'])?>원</td>
                        <td><?=number_format($row['od_use_coupon'])?>원</td>
                        <td><?=number_format(($row['od_goods_price']*($this->my['pt_pay_rate']/100))-$row['od_use_point']-$row['od_use_coupon'])?>원</td>
                        <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                        <td><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                        <td><?=$row['od_rcent_dt']?></td>
                        <td><?=$GLOBALS['pay_stt'][$row['partner_pay_stt']]?></td>
                    </tr>
                    <?php  $i++; } ?>
                    </tbody>
                </table>
            </div>
            <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
        </div>
    </div>
</section>
