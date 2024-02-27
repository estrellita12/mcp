<section class="contents">
    <h1 class="cont_title">정산 상세 정보</h1>
    <div class="cont_wrap">
        <form>
            <div class="rhead01_wrap">
                <div class="h2">세부 사항</div>
                <table>
                    <colgroup>
                        <col class="w200"> 
                        <col>
                    </colgroup>
                    <tbody>     
                    <tr>
                        <th scope="row">공급사</th>
                        <td>
                            <?=$this->my['sl_name']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">계약 수수료</th>
                        <td><?=$this->row['spay_rate']?> %</td>
                    </tr>
                    <tr>
                        <th scope="row">은행</th>
                        <td><?=$this->row['spay_bank']?></td>
                    </tr>
                    <tr>
                        <th scope="row">계좌번호</th>
                        <td><?=$this->row['spay_account']?></td>
                    </tr>
                    <tr>
                        <th scope="row">예금주</th>
                        <td><?=$this->row['spay_holder']?></td>
                    </tr>
                    <tr>
                        <th scope="row">정산 대상 기간 </th>
                        <td>
                            <?=$this->row['spay_begin']?> ~ <?=$this->row['spay_end']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="orderList" value="<?=$this->row['spay_order_idl']?>">
                            <?=$this->row['spay_order_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">차감 정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="cancelList" value="<?=$this->row['spay_cancel_idl']?>">
                            <?=$this->row['spay_cancel_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">배송비 정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="deliveryList" value="<?=$this->row['spay_delivery_idl']?>">
                            <?=$this->row['spay_delivery_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_blue">(+) 총 공급가액</th>
                        <td>
                            <?=number_format($this->row['spay_order_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_red">(-) 차감 정산 금액</th>
                        <td>
                            <?=number_format($this->row['spay_cancel_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_blue">(+) 교환/반품 배송비</th>
                        <td>
                            <?=number_format($this->row['spay_delivery_charge'])?> 원
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">지불 예정 정산 금액</th>
                        <td>    
                            <?=number_format($this->row['spay_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td><?=$this->row['spay_adm_memo']?></td>
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



