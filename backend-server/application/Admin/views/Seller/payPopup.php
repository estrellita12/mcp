<div id="popupContents">
    <section class="cont_inner">
        <p class="pg_tit" id="pg_tit">주문 상세 정보</p>
        <div class="tab_container">
            <div id="odList">
                <form name="fsellerPayForm" action="/Seller/calculate" method="POST">
                    <div class="rhead01_wrap">
                        <div class="h2">정상 세부 사항</div>
                        <table>
                            <colgroup>
                                <col class="w200"> 
                                <col>
                            </colgroup>
                            <tbody>     
                            <tr>
                                <th scope="row">공급사</th>
                                <td><input type="hidden" name="seller" value="<?=$this->pay['seller']?>"><?=$this->pay['seller']?></td>
                            </tr>
                            <tr>
                                <th scope="row">계약 수수료</th>
                                <td><input type="hidden" name="rate" value="<?=$this->sl['sl_pay_rate']?>"><?=$this->sl['sl_pay_rate']?> %</td>
                            </tr>
                            <tr>
                                <th scope="row">은행</th>
                                <td><input type="hidden" name="bank" value="<?=$this->sl['sl_bank_name']?>"><?=$this->sl['sl_bank_name']?></td>
                            </tr>
                            <tr>
                                <th scope="row">계좌번호</th>
                                <td><input type="hidden" name="account" value="<?=$this->sl['sl_bank_account']?>"><?=$this->sl['sl_bank_account']?></td>
                            </tr>
                            <tr>
                                <th scope="row">예금주</th>
                                <td><input type="hidden" name="holder" value="<?=$this->sl['sl_bank_holder']?>"><?=$this->sl['sl_bank_holder']?></td>
                            </tr>
                            <tr>
                                <th scope="row">정산 주문 번호</th>
                                <td>
                                    <input type="hidden" name="orderList" value="<?=implode(",",$this->pay['orderList'])?>">
                                    <?=implode(",",$this->pay['orderList'])?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">총 상품 금액</th>
                                <td>
                                    <?=number_format($this->pay['goodsPrice'])?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">총 포인트 사용 금액</th>
                                <td><?=number_format($this->pay['usePoint'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">총 쿠폰 사용 금액</th>
                                <td><?=number_format($this->pay['useCoupon'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">상품 판매금애 대한 수수료</th>
                                <td><?=number_format($this->pay['commission'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">차감 정산 주문 번호</th>
                                <td>
                                    <input type="hidden" name="cancelList" value="<?=implode(",",$this->cancel['orderList'])?>">
                                    <?=implode(",",$this->cancel['orderList'])?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">총 상품 금액</th>
                                <td><?=number_format($this->cancel['goodsPrice'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">총 포인트 사용 금액</th>
                                <td><?=number_format($this->cancel['usePoint'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">총 쿠폰 사용 금액</th>
                                <td><?=number_format($this->cancel['useCoupon'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">상품 판매금애 대한 수수료</th>
                                <td><?=number_format($this->cancel['commission'])?></td>
                            </tr>
                            <tr>
                                <th scope="row">수수료</th>
                                <td>
                                    <input type="hidden" name="commission" value="<?=($this->pay['commission'] - $this->cancel['commission'])?>">
                                    <?=number_format($this->pay['commission'] - $this->cancel['commission'])?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">관리자 메모</th>
                                <td><textarea name="memo"></textarea></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

