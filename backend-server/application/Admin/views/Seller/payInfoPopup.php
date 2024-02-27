<section class="contents">
    <p class="cont_title">정산 상세 정보</p>
    <p class="cont_info">정산 데이터를 삭제하면 정산 처리되었던 주문건들이 이전 상태로 되돌아갑니다.<br>
    기본 정산 건들은 정산 대기 상태가 되고, 차감 정산 건들은 차감 정산 대기 상태가 되오니, 처리시 주의하시기 바랍니다.
    </p>
    <div class="cont_wrap">
        <form name="fsellerPayForm" action="/Seller/payCancel/<?=$this->row['spay_id']?>" method="POST" onsubmit="return frmSubmit()">
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
                            <?=$this->sl_li[$this->row['sl_id']]?>
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
                    <!--
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
                    -->
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
                        <td>
                            <div style="min-height:30px"><?=$this->row['spay_adm_memo']?></div>
                            <p class="info">해당 메모는 판매자에게 노출됩니다.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <?php if($_SESSION['user_grade']>=1){?>
                <input type="submit" value="정산 취소" class="btn_medium btn_red">
                <?php } ?>
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
<script>
function frmSubmit(){
    var res = confirm("해당 정산을 취소 처리 하시겠습니까? \n정산 완료 처리된 주문건들의 상태가 정산 대기 상태로 되돌아갑니다.");
    return res;
}
</script>



