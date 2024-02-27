<section class="contents">
    <h1 class="cont_title">주문 상세 목록</h1>
    <div class="cont_wrap">
        <form>
            <div class="rhead01_wrap">
                <div class="h2">주문 정보</div>
                <table>
                    <colgroup>
                        <col class="w100">
                        <col>
                        <col class="w100">
                        <col>
                        <col class="w100">
                        <col>
                    </colgroup>
                    <tbody> 
                    <tr>
                        <th>가맹점</th>
                        <td><?=pt_id($this->row['pt_id'],$this->pt_li[$this->row['pt_id']])?></td>
                        <th>주문일시</th>
                        <td><?=$this->row['od_dt']?></td>
                        <th>주문 번호</th>
                        <td><?=$this->row['od_no']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
        <form name="forderForm" action="/Order/set/<?=$this->row['od_id']?>" method="POST">
            <input type="hidden" name="id" value="<?=$this->row['od_id']?>">
            <div class="chead02_wrap">
                <div class="h2">세부 주문 내역 ( <b class="fc_red"><?= number_format($this->cnt) ?></b> 개 )</div>
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w100">
                        <col class="w40">
                        <col class="w50">
                        <col class="w50">
                        <col class="w50">
                        <col class="w50">
                        <col class="w50">
                        <col class="w50">
                        <col class="w70">
                        <col class="w60">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">상품주문번호</th>
                            <th scope="col">주문상품</th>
                            <th scope="col">수량</th>
                            <th scope="col">상품금액</th>
                            <th scope="col">(+)배송비</th>
                            <th scope="col">(-)포인트</th>
                            <th scope="col">(-)쿠폰</th>
                            <th scope="col">실결제액</th>
                            <th scope="col">취소금액</th>
                            <th scope="col">반품/환불금액</th>
                            <th scope="col">주문상태</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->order->getList($this->col) as $row){   $gs = json_decode($row['od_goods_info'],true);  ?>
                    <tr>
                        <td><?=od_id($row['od_id'])?></td>
                        <td class="dot"><?=$gs['goodsName']?></td>
                        <td><?=number_format($row['od_qty'])?></td>
                        <td><?=number_format($row['od_goods_price'])?></td>
                        <td><?=number_format($row['od_delivery_charge']+$row['od_delivery_charge_dosan'])?></td>
                        <td><?=number_format($row['od_use_point'])?></td>
                        <td><?=number_format($row['od_use_coupon'])?></td>
                        <td><?=number_format($row['od_amount'])?></td>
                        <td><?=number_format($row['od_cancel_amount'])?></td>
                        <td><?=number_format($row['od_return_amount'])?></td>
                        <td><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2"><b>총계</b></td>
                        <td><b><?=number_format($this->row['od_qty'])?></b></td>
                        <td><b><?=number_format($this->row['od_goods_price'])?></b></td>
                        <td><b><?=number_format($this->row['od_delivery_charge'])?></b></td>
                        <td><b><?=number_format($this->row['od_use_point'])?></b></td>
                        <td><b><?=number_format($this->row['od_use_coupon'])?></b></td>
                        <td><b><?=number_format($this->row['od_amount'])?></b></td>
                        <td><b><?=number_format($this->row['od_cancel_amount'])?></b></td>
                        <td><b><?=number_format($this->row['od_return_amount'])?></b></td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
