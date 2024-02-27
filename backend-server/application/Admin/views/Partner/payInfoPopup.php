<section class="contents">
    <h1 class="cont_title">정산 상세 정보</h1>
    <p class="cont_info">정산 데이터를 삭제하면 정산 처리되었던 주문건들이 이전 상태로 되돌아갑니다.<br>
    기본 정산 건들은 정산 대기 상태가 되고, 차감 정산 건들은 차감 정산 대기 상태가 되오니, 처리시 주의하시기 바랍니다.
    </p>
    <div class="cont_wrap">
        <form name="fpartnerPayForm" action="/Partner/payCancel/<?=$this->row['ppay_id']?>" method="POST" onsubmit="return frmCancelSubmit()">
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
                            <?=$this->pt_li[$this->row['pt_id']]?>
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
                        <tr>
                            <th scope="row" class="fc_blue">기본 정산 금액</th>
                            <td>
                                <?=number_format($this->row['ppay_order_commission'])?> 원
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="fc_red">포인트 사용 금액</th>
                            <td>
                                <?=number_format($this->row['ppay_tot_point'])?> 원
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="fc_red">쿠폰 사용 금액</th>
                            <td>
                                <?=number_format($this->row['ppay_tot_coupon'])?> 원
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="fc_red">차감 정산 수수료</th>
                            <td>
                                <?=number_format($this->row['ppay_cancel_commission'])?> 원
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">실 정산 지급액</th>
                            <td>    
                                <?=number_format($this->row['ppay_commission'])?> 원
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">관리자 메모</th>
                            <td>
                                <div style="min-height:30px"><?=$this->row['ppay_adm_memo']?></div>
                                <p class="info">해당 메모는 가맹점에게 노출됩니다.</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="confirm_wrap">
                    <?php if($_SESSION['user_grade'] >= 1){ ?>
                    <input type="submit" value="정산 취소" class="btn_medium btn_red">
                    <?php } ?>
                    <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
function frmCancelSubmit(){
    var res = confirm("해당 정산을 취소 처리 하시겠습니까? \n정산 완료 처리된 주문건들의 상태가 정산 대기 상태로 되돌아갑니다.");
    return res;
}
</script>

