<section class="contents">
    <h1 class="cont_title">정산 예정 상세 정보</h1>
    <div class="cont_wrap">
        <form name="fsellerPayForm" action="/Seller/calculate/<?=$this->param['ident']?>" method="POST" onsubmit="return frmCommaSubmit()">
            <input type="hidden" name="orderList" value="<?=$this->row['od_idl']?>">
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
                            <input type="hidden" name="seller" value="<?=$this->seller['sl_id']?>">
                            <?=$this->seller['sl_name']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">계약 수수료</th>
                        <td><input type="hidden" name="rate" value="<?=$this->seller['sl_pay_rate']?>"><?=$this->seller['sl_pay_rate']?> %</td>
                    </tr>
                    <tr>
                        <th scope="row">은행</th>
                        <td><input type="hidden" name="bank" value="<?=$this->seller['sl_bank_name']?>"><?=$this->seller['sl_bank_name']?></td>
                    </tr>
                    <tr>
                        <th scope="row">계좌번호</th>
                        <td><input type="hidden" name="account" value="<?=$this->seller['sl_bank_account']?>"><?=$this->seller['sl_bank_account']?></td>
                    </tr>
                    <tr>
                        <th scope="row">예금주</th>
                        <td><input type="hidden" name="holder" value="<?=$this->seller['sl_bank_holder']?>"><?=$this->seller['sl_bank_holder']?></td>
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
                        <th scope="row" class="fc_blue">총 공급가액</th>
                        <td>
                            <input type="hidden" name="supplyPrice" value="<?=$this->row['tot_supply_price']?>">
                            <?=number_format($this->row['tot_supply_price'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_blue">배송비</th>
                        <td>
                            <?=number_format($this->row['tot_delivery_charge'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_blue">교환/반품 배송비</th>
                        <td>
                            <input type="hidden" name="deliveryCharge" value="<?=$this->row['tot_delivery_charge']?>">
                            <?=number_format($this->row['tot_claim_delivery_charge'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">지불 예정 정산 금액</th>
                        <td>    
                            <input type="text" name="commission" value="<?=number_format($this->row['tot_supply_price']+$this->row['tot_delivery_charge']+$this->row['tot_claim_delivery_charge'])?>" class="tar comma"> 원
                            <p class="info">지불 예정 정산 금액을 임의로 변경 할 수 있으나, 그 사유에 대해서 꼭 메모하여 주시기 바랍니다.</p> 
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td>
                            <textarea name="memo"></textarea>
                            <p class="info">해당 메모는 판매자에게 노출됩니다.</p>
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
