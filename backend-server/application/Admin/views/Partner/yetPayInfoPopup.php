<section class="contents">
    <h1 class="cont_title">정산 예정 상세 정보</h1>
    <div class="cont_wrap">
        <form name="fpartnerPayForm" action="/Partner/calculate" method="POST" onsubmit="return frmCommaSubmit()">
            <div class="rhead01_wrap">
                <div class="h2">세부 사항</div>
                <table>
                    <colgroup>
                        <col class="w200"> 
                        <col>
                    </colgroup>
                    <tbody>     
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <input type="hidden" name="shop" value="<?=$this->pt['pt_id']?>">
                            <?=$this->pt['pt_name']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">계약 수수료</th>
                        <td><input type="hidden" name="rate" value="<?=$this->pt['pt_pay_rate']?>"><?=$this->pt['pt_pay_rate']?> %</td>
                    </tr>
                    <tr>
                        <th scope="row">은행</th>
                        <td><input type="hidden" name="bank" value="<?=$this->pt['pt_bank_info'][0]?>"><?=$this->pt['pt_bank_info'][0]?></td>
                    </tr>
                    <tr>
                        <th scope="row">계좌번호</th>
                        <td><input type="hidden" name="account" value="<?=$this->pt['pt_bank_info'][1]?>"><?=$this->pt['pt_bank_info'][1]?></td>
                    </tr>
                    <tr>
                        <th scope="row">예금주</th>
                        <td><input type="hidden" name="holder" value="<?=$this->pt['pt_bank_info'][2]?>"><?=$this->pt['pt_bank_info'][2]?></td>
                    </tr>
                    <tr>
                        <th scope="row">정산 대상 기간 </th>
                        <td>
                            <input type="hidden" name="begin" value="<?=$_REQUEST['beg']?>">
                            <input type="hidden" name="end" value="<?=$_REQUEST['end']?>">
                            <?=$_REQUEST['beg']?> ~ <?=$_REQUEST['end']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="orderList" value="<?=$this->orderList['od_idl']?>">
                            <?=$this->orderList['od_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">차감 정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="cancelList" value="<?=$this->cancelList['od_idl']?>">
                            <?=$this->cancelList['od_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">총 상품 금액</th>
                        <td>    
                            <input type="hidden" name="goodsPrice" value="<?=$this->orderList['tot_goods_price']?>">
                            <?=number_format($this->orderList['tot_goods_price'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_blue">주문 정산 금액</th>
                        <td>
                            <input type="hidden" name="orderCommission" value="<?=$this->orderList['order_commission']?>">
                            <?=number_format($this->orderList['order_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_red">포인트 사용 금액</th>
                        <td>
                            <input type="hidden" name="point" value="<?=$this->orderList['tot_point']?>">
                            <?=number_format($this->orderList['tot_point'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_red">쿠폰 사용 금액</th>
                        <td>
                            <input type="hidden" name="coupon" value="<?=$this->orderList['tot_coupon']?>">
                            <?=number_format($this->orderList['tot_coupon'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_red">차감 정산 수수료</th>
                        <td>
                            <input type="hidden" name="cancelCommission" value="<?=$this->cancelList['cancel_commission']?>">
                            <?=number_format($this->cancelList['cancel_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">실 정산 지급액</th>
                        <td>    
                            <input type="text" name="commission" value="<?=number_format($this->commission)?>" class="tar comma"> 원
                            <p class="info">
                            실 정산 지급액은 기본 정산 금액 - ( 포인트 사용 금액 + 쿠폰 사용 금액 + 미처리 차감 정산 수수료) 으로 계산되었습니다. <br>
                            실 정산 지급액을 임의로 변경 할 수 있으나, 그 사유에 대해서 꼭 메모하여 주시기 바랍니다.
                            </p> 
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td>
                            <textarea name="memo"></textarea>
                            <p class="info">해당 메모는 가맹점에게 노출됩니다.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="정산 처리" class="btn_medium btn_red">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
