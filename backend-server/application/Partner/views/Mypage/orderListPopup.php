<section class="contents">
    <h1 class="cont_title">주문 내역</h1>
    <div class="cont_wrap">
        <form>
            <div class="chead01_wrap" id="reload_wrap">
                <div class="h2">주문 내역 ( <b class="fc_red"><?= number_format($this->cnt) ?></b> 개 )</div>
                <table>
                    <colgroup>
                        <col class="w140">      <!-- 주문일시 -->
                        <col class="w130">      <!-- 주문번호 -->
                        <col class="w100">      <!-- 주문일련번호 -->
                        <col class="w100">      <!-- 주문상품 -->
                        <col class="w50">       <!-- 수량 -->
                        <col class="w80">      <!-- 총 상품 금액 -->
                        <col class="w80">      <!-- 배송비 -->
                        <col class="w100">      <!-- 주문상태 -->
                        <col class="w140">      <!-- 최종처리일시 -->
                        <col class="w80">      <!-- 결제방법 -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">주문일시</th>
                            <th scope="col">주문번호</th>
                            <th scope="col">주문일련번호</th>
                            <th scope="col">주문상품</th>
                            <th scope="col">수량</th>
                            <th scope="col">총 상품 금액</th>
                            <th scope="col">배송비</th>
                            <th scope="col">주문상태</th>
                            <th scope="col">최종처리일시</th>
                            <th scope="col">결제방법</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->orderModel->get($this->col,$this->search,true) as $row){   $gs = json_decode($row['od_goods_info'],true);  ?>
                    <tr>
                        <td><?=$row['od_dt']?></td>
                        <td><?=od_no($row['od_no'])?></td>
                        <td><?=od_id($row['od_id'])?></td>
                        <td class="dot"><?=$gs['goodsName']?></td>
                        <td><?=number_format($row['od_qty'])?></td>
                        <td><?=number_format($row['od_goods_price'])?></td>
                        <td><?=number_format($row['od_delivery_charge']+$row['od_delivery_charge_dosan'])?></td>
                        <td><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                        <td><?=$row['od_rcent_dt']?></td>
                        <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            <div class="confirm_wrap">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>

