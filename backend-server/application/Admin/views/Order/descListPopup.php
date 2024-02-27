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
        <form action="/Order/listUpdateState" method="post">
            <div class="chead02_wrap">
                <div class="h2">세부 주문 내역 ( <b class="fc_red"><?= number_format($this->cnt) ?></b> 개 )</div>
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w100">
                        <col class="w50">
                        <col class="w40">
                        <col class="w50">
                        <col class="w50">
                        <col class="w50">
                        <col class="w50">
                        <col class="w60">
                        <col class="w60">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">상품주문번호</th>
                            <th scope="col">주문상품</th>
                            <th scope="col">판매자</th>
                            <th scope="col">수량</th>
                            <th scope="col">상품금액</th>
                            <th scope="col">(-)포인트</th>
                            <th scope="col">(-)쿠폰</th>
                            <th scope="col">(+)배송비</th>
                            <th scope="col">(+)추가배송비</th>
                            <th scope="col">주문상태</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->li as $row){ $gs = json_decode($row['od_goods_info'],true);  ?>
                    <tr>
                        <!--
                        <td>
                            <input type="hidden" name="userId[<?=$i?>]" value="<?=$row['mb_id']?>">
                            <input type="hidden" name="odId[<?=$i?>]" value="<?=$row['od_id']?>">
                            <input type="hidden" name="odNo[<?=$i?>]" value="<?=$row['od_no']?>">
                            <input type="checkbox" name="chk[]" value="<?=$i?>">
                        </td>
                        -->
                        <td><?=od_id($row['od_id'])?></td>
                        <td class="dot tal"><?=$gs['goodsName']?></td>
                        <td><?=sl_id($row['sl_id'])?></td>
                        <td><?=number_format($row['od_qty'])?></td>
                        <td><?=number_format($row['od_goods_price'])?></td>
                        <td><?=number_format($row['od_use_point'])?></td>
                        <td><?=number_format($row['od_use_coupon'])?></td>
                        <td><?=number_format($row['od_delivery_charge'])?></td>
                        <td><?=number_format($row['od_delivery_charge_dosan'])?></td>
                        <td>
                            <select name="state" id="state">
                                <?php if($_SESSION['user_grade'] == "1" ){ ?>
                                <?php foreach( $GLOBALS['od_stt'] as $key => $value ){ ?>
                                <?=get_frm_option($key, $row['od_stt'], $value['title'] )?>
                                <?php } ?>
                                <?php }else{ ?>
                                <?=get_frm_option($row['od_stt'],$row['od_stt'],$GLOBALS['od_stt'][$row['od_stt']]['title'] )?>
                                <?php foreach( $GLOBALS['od_stt'][$row['od_stt']]['next'] as $key ){ ?>
                                <?=get_frm_option($key, $row['od_stt'], $GLOBALS['od_stt'][$key]['title'] )?>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
        <form>
            <div class="rhead01_wrap">
                <div class="h2">결제 정보</div>
                <table>
                    <colgroup>
                        <col>
                        <col>
                    </colgroup>
                    <tbody> 
                    <tr>
                        <td style="vertical-align:top">
                            <table>
                                <colgroup>
                                    <col class="w150">
                                    <col>
                                </colgroup>
                                <tbody> 
                                <tr>
                                    <th>총 상품 금액</th>
                                    <td class="fw_500"><?=number_format($this->row['od_goods_price'])?> 원</td>
                                </tr>
                                <tr>
                                    <th>쿠폰 할인금액</th>
                                    <td class="fw_500 bg_light_blue fc_blue">(-) <?=number_format($this->row['od_use_coupon'])?> 원</td>
                                </tr>
                                <tr>
                                    <th>포인트 할인금액</th>
                                    <td class="fw_500 bg_light_blue fc_blue">(-) <?=number_format($this->row['od_use_point'])?> 원</td>
                                </tr>
                                <tr>
                                    <th>총 배송비</th>
                                    <td class="fw_500"><?=number_format($this->row['od_delivery_charge'])?> 원</td>
                                </tr>
                                <tr>
                                    <th>실 결제금액</th>
                                    <td class="fw_500"><?=number_format($this->row['od_amount'])?> 원</td>
                                </tr>
                                <tr>
                                    <th>취소 금액</th>
                                    <td class="fw_500 fc_red">(-) <?=number_format($this->row['od_cancel_amount'])?> 원</td>                                
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="vertical-align:top">
                            <table>
                                <colgroup>
                                    <col class="w150">
                                    <col>
                                </colgroup>
                                <tbody> 
                                <tr>
                                    <th>결제대행사</th>
                                    <td>
                                        <?php if(!empty($row['od_pg_company'])){ ?>
                                        <a href="<?=$GLOBALS['pg_company'][$row['od_pg_company']][1]?>" target="_blank" class="btn_small btn_gray">
                                            <?=$GLOBALS['pg_company'][$row['od_pg_company']][0]?> 바로가기
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제 방법</th>
                                    <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                                </tr>
                                <?php if($row['od_paymethod']=="card"){ ?>
                                <tr>
                                    <th>카드 요청일시</th>
                                    <td><?=$row['od_pay_request_dt']?></td>
                                </tr>
                                <tr>
                                    <th>카드 승인일시</th>
                                    <td><?=$row['od_pay_approved_dt']?></td>
                                </tr>
                                <?php }else if($row['od_paymethod']=="vbank"){ ?>
                                <tr>
                                    <th>계좌번호</th>
                                    <td><?=$row['od_vbank']?></td>
                                </tr>
                                <tr>
                                    <th>입금자명</th>
                                    <td><?=$row['od_vbank_deposit']?></td>
                                </tr>
                                <tr>
                                    <th>입금확인 일시</th>
                                    <td><?=$row['od_receipt_dt']?></td>
                                </tr>
                                <?php } ?>
                                <?php if($row['od_tax_invoice']=="s"){ ?>
                                <tr>
                                    <th>현금영수증 신청 정보</th>
                                    <td><?=$row['od_taxsave_info']?></td>
                                </tr>
                                <?php } ?>
                                <?php if($row['od_tax_invoice']=="b"){ ?>
                                <tr>
                                    <th>세금 계산서 신청 정보</th>
                                    <td><?=$row['od_taxbill_info']?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
        <form>
            <div class="rhead01_wrap">
                <div class="h2">주문자 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody> 
                    <tr>
                        <th>주문자 이름</th>
                        <td><?=$row['orderer_name']?></td>
                        <th>주문자 아이디</th>
                        <td><?=mb_id($row['mb_id'])?></td>
                    </tr>
                    <tr>
                        <th>주문자 전화번호</th>
                        <td><?=$row['orderer_cellphone']?></td>
                        <th>주문자 이메일</th>
                        <td><?=$row['orderer_email']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">수령자 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody> 
                    <tr>
                        <th>수령자 이름</th>
                        <td colspan="3"><input type="text" name="receiverName" value="<?=$row['receiver_name']?>" readonly></td>
                    </tr>
                    <tr>
                        <th>수령자 전화번호</th>
                        <td><input type="text" name="receiverCellphone" value="<?=$row['receiver_cellphone']?>" readonly></td>
                        <th>수령자 이메일</th>
                        <td><input type="text" name="receiverEmail" value="<?=$row['receiver_email']?>" readonly></td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td colspan="3">
                            <input type="text" name="receiverZip" value="<?=$row['receiver_zip']?>" size="8" maxlength="5" readonly>
                            <a href="javascript:winZip('freceiverForm', 'receiverZip', 'receiverAddr1', 'receiverAddr2', 'receiverAddr3');" class="btn_small btn_gray">주소검색</a>
                            <p class="mart5"><input type="text" name="receiverAddr1" value="<?=$row['receiver_addr1']?>" size="60" readonly> 기본주소</p>
                            <p class="mart5"><input type="text" name="receiverAddr2" value="<?=$row['receiver_addr2']?>" size="60" readonly> 상세주소</p>
                            <p class="mart5"><input type="text" name="receiverDeliveryMsg" value="<?=$row['receiver_delivery_msg']?>" size="60" readonly> 배송메세지
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



