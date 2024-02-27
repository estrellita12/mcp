<section class="contents">
    <h1 class="cont_title">주문 상세 정보</h1>
    <div class="cont_wrap">
    <form name="forderForm">
        <input type="hidden" name="odId" value="<?=$this->row['od_id']?>">
        <input type="hidden" name="odNo" value="<?=$this->row['od_no']?>">
        <input type="hidden" name="statePre" value="<?=$this->row['od_stt']?>">
        <input type="hidden" name="userId" value="<?=$this->row['mb_id']?>">
        <input type="hidden" name="message" value="">
        <div class="rhead01_wrap">
            <div class="h2">주문 정보</div>
            <table>
                <colgroup>
                    <col class="w110">
                    <col>
                    <col class="w110">
                    <col>
                    <col class="w110">
                    <col>
                </colgroup>
                <tbody> 
                    <tr>
                        <th>가맹점</th>
                        <td>
                            <?=$this->pt_li[$this->row['pt_id']]?>
                        </td>
                        <th>주문일시</th>
                        <td><?=$this->row['od_dt']?></td>
                        <th>주문 번호</th>
                        <td><?=$this->row['od_no']?></td>
                    </tr>
                    <tr>
                        <th>공급사</th>
                        <td><?=$this->sl_li[$this->row['sl_id']]?></td>
                        <th>주문 일련 번호</th>
                        <td><?=$this->row['od_id']?></td>
                        <th>주문상태</th>
                        <td><?=$GLOBALS['od_stt'][$this->row['od_stt']]['title'] ?></td>
                    </tr>
                    <tr class="dn state" id="state13">
                        <th>택배사</th>
                        <td>
                            <select name="deliveryCompany">
                                <?=get_frm_option("",$this->row['od_delivery_company'],"선택")?>
                                <?php foreach($this->config['cf_delivery_company'] as $key=>$dv){ ?>
                                <?=get_frm_option($key,$this->row['od_delivery_company'],$dv['company'])?>
                                <?php } ?>
                            </select>
                        </td>
                        <th>운송장 번호</th>
                        <td colspan="3">
                            <input type="text" name="deliveryNo" value="<?=$this->row['od_delivery_no']?>">
                        </td>
                    </tr>
                    <tr class="dn state" id="state21">
                        <th>교환 옵션</th>
                        <td><input type="text" name="changeOptId" value="<?=$this->row['od_change_opt_id']?>" class="w100"></td>
                        <th>교환 신청 사유</th>
                        <td colspan="3"><input type="text" name="changeMessage" value="<?=$this->row['od_change_msg']?>"></td>
                    </tr>
                    <tr class="dn state" id="state22">
                        <th>교환 배송비</th>
                        <td colspan="5">
                            해당 제품의 교환 배송비는
                            <input type="text" name="claimDeliveryCharge" value="<?=number_format($this->row['od_goods_info']['claimDeliveryCharge']+($this->row['od_delivery_charge_dosan']*2))?>" class="w80 tar comma" readonly>
                            원 입니다. 
                            <p class="info">교환 배송비는 상품에 등록된 교환 배송비 + ( 추가 배송비 X 2 ) 로 설정 되었습니다.</p>
                            <p class="info">교환 배송비를 입금/결제 받은 뒤 <b>교환 접수</b>로 상태 변경을 처리하시기 바랍니다.</p>
                        </td>
                    </tr>
                    <tr class="dn state" id="state24">
                        <th>택배사</th>
                        <td>
                            <select name="deliveryCompany2">
                                <?=get_frm_option("",$this->row['od_delivery_company2'],"선택")?>
                                <?php foreach($this->config['cf_delivery_company'] as $key=>$dv){ ?>
                                <?=get_frm_option($key,$this->row['od_delivery_company2'],$dv['company'])?>
                                <?php } ?>
                            </select>
                        </td>
                        <th>운송장 번호</th>
                        <td colspan="3">
                            <input type="text" name="deliveryNo2" value="<?=$this->row['od_delivery_no2']?>">
                        </td>
                    </tr>
                    <tr class="dn state" id="state27">
                        <th>택배사</th>
                        <td>
                            <select name="deliveryCompany3">
                                <?=get_frm_option("",$this->row['od_delivery_company3'],"선택")?>
                                <?php foreach($this->config['cf_delivery_company'] as $key=>$dv){ ?>
                                <?=get_frm_option($key,$this->row['od_delivery_company3'],$dv['company'])?>
                                <?php } ?>
                            </select>
                        </td>
                        <th>운송장 번호</th>
                        <td colspan="3">
                            <input type="text" name="deliveryNo3" value="<?=$this->row['od_delivery_no3']?>">
                        </td>
                    </tr>
                    <tr class="dn state" id="state31">
                        <th>반품 신청 사유</th>
                        <td colspan="5">
                            <input type="text" name="returnReason" value="<?=$this->row['od_return_reason']?>" class="w300">
                        </td>
                    </tr>
                    <tr class="dn state" id="state32">
                        <th>반품 배송비</th>
                        <td colspan="5">
                            해당 제품의 반품 배송비는
                            <input type="text" name="claimDeliveryCharge" value="<?=number_format($this->row['od_goods_info']['claimDeliveryCharge']+($this->row['od_delivery_charge_dosan']*2))?>" class="w80 tar comma" readonly>
                            원 입니다. 
                            <p class="info">반품 배송비는 상품에 등록된 반품 배송비 + ( 추가 배송비 X 2 ) 로 설정 되었습니다.</p>
                            <p class="info">반품 배송비를 입금/결제 받은 뒤 <b>반품 접수</b>로 상태 변경을 처리하시기 바랍니다.</p>
                        </td>
                    </tr>
                    <tr class="dn state" id="state34">
                        <th>택배사</th>
                        <td>
                            <select name="deliveryCompany4">
                                <?=get_frm_option("",$this->row['od_delivery_company4'],"선택")?>
                                <?php foreach($this->config['cf_delivery_company'] as $key=>$dv){ ?>
                                <?=get_frm_option($key,$this->row['od_delivery_company4'],$dv['company'])?>
                                <?php } ?>
                            </select>
                        </td>
                        <th>운송장 번호</th>
                        <td colspan="3">
                            <input type="text" name="deliveryNo4" value="<?=$this->row['od_delivery_no4']?>">
                        </td>
                    </tr>
                    <tr class="dn state" id="state41">
                        <th>취소 신청 사유</th>
                        <td colspan="5">
                            <input type="text" name="cancelReason" value="<?=$this->row['od_cancel_reason']?>" class="w300">
                        </td>
                    </tr>
                    <tr class="dn state" id="state42">
                        <th>취소 신청 사유</th>
                        <td colspan="5">
                            <input type="text" name="cancelReason" value="<?=$this->row['od_cancel_reason']?>" class="w300">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="btn_wrap tar">
            </div>
        </div>
    </form>
    <form name="forderForm" action="/Order/set/<?=$this->row['od_id']?>" method="POST" onsubmit="return frmCommaSubmit()">
        <input type="hidden" name="id" value="<?=$this->row['od_id']?>">
        <input type="hidden" name="no" value="<?=$this->row['od_no']?>">
        <div class="rhead01_wrap">
            <div class="h2">세부 주문 정보</div>
            <table>
                <colgroup>
                    <col class="w110">
                    <col>
                    <col class="w110">
                    <col>
                    <col class="w110">
                    <col>
                </colgroup>
                <tbody> 
                    <tr>
                        <th>상품번호(ID)</th>
                        <td><?=$this->row['gs_id']?></td>
                        <th>상품명</th>
                        <td colspan="3"><?=$this->row['gs_id'],$this->row['od_goods_info']['goodsName']?></td>
                    </tr>
                    <tr>
                        <th>옵션번호(ID)</th>
                        <td><?=$this->row['gs_opt_id']?></td>
                        <th>옵션명</th>
                        <td><?=$this->row['od_goods_info']['optionName']?></td>
                        <th>옵션추가금</th>
                        <td><?=number_format($this->row['od_goods_info']['addPrice'])?>원</td>
                    </tr>
                    <tr>
                        <th>상품 가격</th>
                        <td><?=number_format($this->row['od_goods_info']['goodsPrice'])?> 개</td>
                        <th>주문 수량</th>
                        <td class="fw_500"><?=number_format($this->row['od_qty'])?> 개</td>
                        <th>총 상품 가격</th>
                        <td class="fw_500"><?=number_format($this->row['od_goods_price'])?> 원</td>
                    </tr>
                    <tr>
                        <th class="fw_500 fc_blue">(-)포인트</th>
                        <td class="fw_500 bg_light_blue"><?=number_format($this->row['od_use_point'])?> 원</td>
                        <th class="fw_500 fc_blue">(-)쿠폰</th>
                        <td class="fw_500 bg_light_blue"><?=number_format($this->row['od_use_coupon'])?> 원</td>
                        <th></th>
                        <td></td>
                    </tr>
                    <tr>
                        <th class="fw_500 fc_blue">(+)배송비</th>
                        <td class="fw_500 bg_light_blue"><?=number_format($this->row['od_delivery_charge'])?> 원</td>
                        <th class="fw_500 fc_blue">(+)추가 배송비</th>
                        <td class="fw_500 bg_light_blue">
                            <input type="text" name="deliveryChargeDosan" value="<?=number_format($this->row['od_delivery_charge_dosan'])?>" size=5 readonly> 원
                        </td>
                        <th class="fw_500 fc_red">실 결제금액</th>
                        <td class="fw_500 bg_light_red"><?=number_format($this->row['od_amount'])?> 원</td>
                    </tr>
                    <tr>
                        <th>결제 일시</th>
                        <td><?=$this->row['od_pay_approved_dt']?></td>
                        <th>결제 방법</th>
                        <td colspan="3"><?=$GLOBALS['paymethod'][$this->row['od_paymethod']]?></td>
                    </tr>
                    <?php if( !in_array($this->row['od_stt'],array("1","2","11","40","41","42")) ){?>
                    <tr>
                        <th>배송 일시</th>
                        <td><?=$this->row['od_delivery_dt']?></td>
                        <th>배송 완료 일시</th>
                        <td colspan="3"><?=$this->row['od_invoice_dt']?></td>
                    </tr>
                    <tr>
                        <th>택배사</th>
                        <td><?=!empty($this->row['od_delivery_company'])?$this->config['cf_delivery_company'][$this->row['od_delivery_company']]['company']:""?></td>
                        <th>운송장 번호</th>
                        <td><?=$this->row['od_delivery_no']?></td>
                        <th>송장 조회</th>
                        <td>
                            <a href="<?=$this->config['cf_delivery_company'][$this->row['od_delivery_company']]['link'].$this->row['od_delivery_no']?>" class="btn_ssmall btn_white" target="_blank">배송 추적</a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if(floor($this->row['od_stt']/10)==4){?>
                    <tr>
                        <th>취소 일시</th>
                        <td><?=$this->row['od_cancel_dt']?></td>
                        <th>취소 금액</th>
                        <td colspan="3">
                            <span class="marr10"><?=number_format($this->row['od_cancel_amount'])?> 원</span>
                            <?php if($this->row['od_cancel_amount'] < $this->row['od_amount']){ ?>
                            <a class="btn_ssmall btn_red" href="/Order/cancel/<?=$this->row['od_id']?>">결제취소</button>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>취소 사유</th>
                        <td colspan="5"><input type="text" name="cancelReason" value="<?=$this->row['od_cancel_reason']?>" class="w100p" readonly></td>
                    </tr>
                    <?php } ?>
                    <?php if(floor($this->row['od_stt']/10)==2){ ?>
                    <tr>
                        <th>교환 완료 일시</th>
                        <td><?=$this->row['od_change_dt']?></td>
                        <th>교환 옵션</th>
                        <td><?=$this->row['od_change_opt_id']?></td>
                        <th><span class="tooltip">교환 배송비<span class="tooltiptext">고객으로부터 입금/결제 받은 교환 배송비</span></span></th>
                        <td><?=number_format($this->row['od_claim_delivery_charge'])?>원</td>
                    </tr>
                    <tr>
                        <th>교환 사유</th>
                        <td colspan="3"><input type="text" name="changeMessage" value="<?=$this->row['od_change_msg']?>" class="w100p" readonly></td>
                        <th><span class="tooltip">교환 추가금<span class="tooltiptext">교환 신청 옵션의 추가금으로 인하여, 추가 결제된 금액</span></span></th>
                        <td>0 원</td>
                    </tr>
                    <tr>
                        <th>교환 회수 송장</th>
                        <td>
                            <?php if(!empty($this->row['od_delivery_no2'])){ ?>
                            <a href="<?=$this->config['cf_delivery_company2'][$this->row['od_delivery_company2']]['link'].$this->row['od_delivery_no2']?>" class="btn_ssmall btn_white" target="_blank"><?=$this->row['od_delivery_no2']?> 배송 추적</a>
                            <?php } ?>
                        </td>
                        <th>교환 발송 송장</th>
                        <td colspan="3">
                            <?php if(!empty($this->row['od_delivery_no3'])){ ?>
                            <a href="<?=$this->config['cf_delivery_company3'][$this->row['od_delivery_company3']]['link'].$this->row['od_delivery_no3']?>" class="btn_ssmall btn_white" target="_blank"><?=$this->row['od_delivery_no3']?> 배송 추적</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if(floor($this->row['od_stt']/10)==3){ ?>
                    <tr>
                        <th>반품 완료 일시</th>
                        <td colspan="3"><?=$this->row['od_return_dt']?></td>
                        <th><span class="tooltip">반품 배송비<span class="tooltiptext">고객으로부터 입금/결제 받은 반품 배송비</span></span></th>
                        <td><?=number_format($this->row['od_claim_delivery_charge'])?>원</td>
                    </tr>
                    <tr>
                        <th>반품 사유</th>
                        <td colspan="3"><input type="text" name="returnReason" value="<?=$this->row['od_return_reason']?>" readonly class="w100p"></td>
                        <th class="fc_red fw_500">(-)반품/환불 금액</th>
                        <td class="bg_light_red fw_500"><?=number_format($this->row['od_return_amount'])?> 원</td>
                    </tr>
                    <tr>
                        <th>반품 회수 송장</th>
                        <td colspan="5">
                            <?php if(!empty($this->row['od_delivery_no4'])){ ?>
                            <a href="<?=$this->config['cf_delivery_company4'][$this->row['od_delivery_company4']]['link'].$this->row['od_delivery_no4']?>" class="btn_ssmall btn_white" target="_blank"><?=$this->row['od_delivery_no4']?> 배송 추적</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th>구매 확정 여부</th>
                        <td><?=img_success($this->row['od_confirm_yn'],'y')?></td>
                        <th>구매 확정 일시</th>
                        <td colspan="3"><?=$this->row['od_confirm_dt']?></td>
                    </tr>
                </tbody>
            </table>
            <div class="btn_wrap tar">
            </div>
        </div>
    </form>
    <form>
        <div class="chead02_wrap">
            <div class="h2">CS 이력</div>
            <div class="para">해당 주문건에 대한 CS 이력 입니다.</div>
            <table>
                <colgroup>
                    <col class="w40">  <!-- 번호 -->
                    <col class="w150">  <!-- 처리일시 -->
                    <col class="w100">  <!-- 처리자  -->
                    <col class="w120">  <!-- 처리타입  -->
                    <col class="w200">  <!-- 주문상태 -->
                    <col>  <!-- 처리로그 -->
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">일시</th>
                        <th scope="col">처리자</th>
                        <th scope="col">CS 타입</th>
                        <th scope="col">주문상태</th>
                        <th scope="col">CS 내용</th>
                    </tr>
                </thead>
                <tbody>     
                    <?php $i=1; foreach( $this->cs->getList($this->col) as $cs ) { ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$cs['cs_reg_dt']?></td>
                        <td><?=$cs['cs_by_id']?></td>
                        <td><?=$cs['cs_type']?></td>
                        <td>    
                            <?php if($cs['cs_od_stt_pre'] != $cs['cs_od_stt']){ ?>
                            <span class="tx_lt"><?=$cs['cs_od_stt_pre']!=0?$GLOBALS['od_stt'][$cs['cs_od_stt_pre']]['title']:""?></span>
                            <span class="marr5 marl5">→</span>
                            <span><?=$GLOBALS['od_stt'][$cs['cs_od_stt']]['title']?></span>
                            <?php }else{ ?>
                            <span>변동사항없음</span>
                            <?php } ?>
                        </td>
                        <td class="tal"><?=$cs['cs_message']?></td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
            <div class="btn_wrap tar">
                <a href="#" onclick="winOpen('/Order/csFormPopup/<?=$this->row['od_id']?>?type=일반','csForm','700','600','yes')" class="btn_small btn_white">+ 이력 추가</a>
            </div>
        </div>
    </form>
    <form>
        <div class="rhead01_wrap">
            <div class="h2">결제 정보</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody> 
                    <tr>
                        <th>결제대행사</th>
                        <td>
                            <?php if(!empty($this->row['od_pg_company'])){ ?>
                            <a href="<?=$GLOBALS['pg_company'][$this->row['od_pg_company']][1]?>" target="_blank" class="btn_small btn_gray">
                                <?=$GLOBALS['pg_company'][$this->row['od_pg_company']][0]?> 바로가기
                            </a>
                            <?php } ?>
                        </td>
                        <th>결제 방법</th>
                        <td><?=$GLOBALS['paymethod'][$this->row['od_paymethod']]?></td>
                    </tr>
                    <?php if($this->row['od_paymethod']=="신용카드"){ ?>
                    <tr>
                        <th>신용카드 결제금액</th>
                        <td><?=number_format($this->row['od_amount'])?> 원</td>
                        <th>카드 승인일시</th>
                        <td><?=$this->row['od_pay_dt']?></td>
                    </tr>
                    <?php }else if($this->row['od_paymethod']=="가상계좌"){ ?>
                    <tr>
                        <th>계좌번호</th>
                        <td><?=$this->row['od_vbank']?></td>
                        <th>입금자명</th>
                        <td><?=$this->row['od_vbank_deposit']?></td>
                    </tr>
                    <tr>
                        <th>입금액</th>
                        <td><?=number_format($this->row['od_amount'])?> 원</td>
                        <th>입금확인 일시</th>
                        <td><?=$this->row['od_receipt_dt']?></td>
                    </tr>
                    <?php } ?>
                    <?php if($this->row['od_tax_invoice']=="s"){ ?>
                    <tr>
                        <th>현금영수증 신청 정보</th>
                        <td colspan="3"><?=$this->row['od_taxsave_info']?></td>
                    </tr>
                    <?php } ?>
                    <?php if($this->row['od_tax_invoice']=="b"){ ?>
                    <tr>
                        <th>세금 계산서 신청 정보</th>
                        <td colspan="3"><?=$this->row['od_taxbill_info']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
    <form name="freceiverForm" action="/Order/set/<?=$this->row['od_id']?>" method="POST">
        <input type="hidden" name="id" value="<?=$this->row['od_id']?>">
        <input type="hidden" name="no" value="<?=$this->row['od_no']?>">
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
                        <td><?=$this->row['orderer_name']?></td>
                        <th>주문자 아이디</th>
                        <td><?=$this->row['mb_id']?></td>
                    </tr>
                    <tr>
                        <th>주문자 전화번호</th>
                        <td><?=$this->row['orderer_cellphone']?></td>
                        <th>주문자 이메일</th>
                        <td><?=$this->row['orderer_email']?></td>
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
                        <td colspan="3"><input type="text" name="receiverName" value="<?=$this->row['receiver_name']?>" readonly></td>
                    </tr>
                    <tr>
                        <th>수령자 전화번호</th>
                        <td><input type="text" name="receiverCellphone" value="<?=$this->row['receiver_cellphone']?>" readonly></td>
                        <th>수령자 이메일</th>
                        <td><input type="text" name="receiverEmail" value="<?=$this->row['receiver_email']?>" readonly></td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td colspan="3">
                            <input type="text" name="receiverZip" value="<?=$this->row['receiver_zip']?>" size="8" maxlength="5" readonly>
                            <a href="javascript:winZip('freceiverForm', 'receiverZip', 'receiverAddr1', 'receiverAddr2', 'receiverAddr3');" class="btn_small btn_gray">주소검색</a>
                            <p class="mart5"><input type="text" name="receiverAddr1" value="<?=$this->row['receiver_addr1']?>" size="60" readonly> 기본주소</p>
                            <p class="mart5"><input type="text" name="receiverAddr2" value="<?=$this->row['receiver_addr2']?>" size="60" readonly> 상세주소</p>
                            <p class="mart5"><input type="text" name="receiverDeliveryMsg" value="<?=$this->row['receiver_delivery_msg']?>" size="60" readonly> 배송메세지
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

