<section class="contents">
    <p class="cont_title">정산 상세 정보</p>
    <div class="cont_wrap">
        <div id="odList">
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
                            <?=$this->my['pt_id']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">계약 수수료</th>
                        <td><?=$this->row['ppay_rate']?> %</td>
                    </tr>
                    <tr>
                        <th scope="row">은행</th>
                        <td><?=$this->row['ppay_bank']?></td>
                    </tr>
                    <tr>
                        <th scope="row">계좌번호</th>
                        <td><?=$this->row['ppay_account']?></td>
                    </tr>
                    <tr>
                        <th scope="row">예금주</th>
                        <td><?=$this->row['ppay_holder']?></td>
                    </tr>
                    <tr>
                        <th scope="row">정산 대상 기간 </th>
                        <td>
                            <?=$this->row['ppay_begin']?> ~ <?=$this->row['ppay_end']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="orderList" value="<?=$this->row['ppay_order_idl']?>">
                            <?=$this->row['ppay_order_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">차감 정산 주문 번호</th>
                        <td>
                            <input type="hidden" name="cancelList" value="<?=$this->row['ppay_cancel_idl']?>">
                            <?=$this->row['ppay_cancel_idl']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_blue">(+) 총 정산 금액</th>
                        <td>
                            <?=number_format($this->row['ppay_order_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="fc_red">(-) 차감 정산 금액</th>
                        <td>
                            <?=number_format($this->row['ppay_cancel_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">지불 예정 정산 금액</th>
                        <td>    
                            <?=number_format($this->row['ppay_commission'])?> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td><?=$this->row['ppay_adm_memo']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </div>
    </div>
</section>
