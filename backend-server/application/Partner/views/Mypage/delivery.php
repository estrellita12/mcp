<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?> </h1>
    <form name="fsellerForm" action="/Mypage/set" method="POST" onsubmit="return fsubmit(this)">
        <input type="hidden" name="id" value="<?=$this->my['sl_id']?>">
        <div class="rhead01_wrap">
            <div class="h2">배송 정책</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th>기본 배송 정책 </th>
                        <td>
                            <table>
                                <colgroup>
                                    <col class="w130">
                                    <col>
                                </colgroup>
                                <?php foreach($GLOBALS['dv_type'] as $key=>$value){ ?>
                                <tr>
                                    <td><?=get_frm_radio('deliveryType',$key,$this->my['sl_delivery_type'], $value[0] );?></td>
                                    <td><?=$value[1]?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>착불/선결제<br>유료 배송비</th>
                        <td><input type="text" class="tar" name="deliveryCharge" value="<?=$this->my['sl_delivery_charge']?>">원</td>
                    </tr>
                    <tr>
                        <th>무료 배송을 위한<br>최소 주문 금액</th>
                        <td><input type="text" class="tar" name="deliveryFree" value="<?=$this->my['sl_delivery_free']?>">원</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="rhead01_wrap">
            <div class="h2">배송/교환/반품 안내</div>
            <div class="info"><p>※SSO연동을 진행하는 경우, 반드시 입력해야하는 정보입니다.</p></div>
            <div>   
                <?= editor_html('deliveryInfo', get_text($this->my['sl_delivery_information'],0)) ?>
            </div>
        </div>
        <div class="confirm_wrap">
            <input type="submit" value="저장" id="btn_submit" class="btn_medium btn_black" accesskey="s">
        </div>
    </form>
</section>
