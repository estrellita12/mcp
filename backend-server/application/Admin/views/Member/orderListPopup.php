<section class="contents">
    <h1 class="cont_title">주문 내역</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form>
            <div class="chead02_wrap">
                <div class="h2">주문 내역 ( <b class="fc_red"><?= number_format($this->cnt) ?></b> 개 )</div>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col class="w90">
                        <col class="w80">
                        <col>
                        <col class="w50">
                        <col class="w70">
                        <col class="w70">
                        <col class="w70">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">주문번호</th>
                            <th scope="col">주문일련번호</th>
                            <th scope="col">상품번호</th>
                            <th scope="col">상품명</th>
                            <th scope="col">수량</th>
                            <th scope="col">주문상태</th>
                            <th scope="col">총주문액</th>
                            <th scope="col">결제방법</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->order->getList($this->col) as $row){   $gs = json_decode($row['od_goods_info'],true);  ?>
                    <tr>
                        <td><?=od_no($row['od_no'])?></td>
                        <td><?=od_id($row['od_id'])?></td>
                        <td><?=gs_id($row['gs_id'])?></td>
                        <td class="dot"><?=$gs['goodsName']?></td>
                        <td><?=$row['od_qty']?></td>
                        <td><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                        <td><?=number_format($row['od_amount'])?></td>
                        <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
            <div class="confirm_wrap">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
