<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('od_no', get_request("srch"), '주문번호'); ?>
                                <?= get_frm_option('od_id', get_request("srch"), '주문일련번호'); ?>
                                <?= get_frm_option('gs_id', get_request("srch"), '상품번호'); ?>
                                <?= get_frm_option('mb_id', get_request("srch"), '주문자 아이디'); ?>
                                <?= get_frm_option('user_name', get_request("srch"), '주문자 이름'); ?>
                                <?= get_frm_option('userCellphone', get_request("srch"), '주문자 전화번호'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('od_dt', $_REQUEST['term'], '주문일'); ?>
                                <?= get_frm_option('od_rcent_dt', $_REQUEST['term'], '최종처리일'); ?>
                            </select>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"))?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">결제방법</th>
                        <td>
                            <label>
                                <input type="checkbox" id="paymethod" name="paymethod[]" value="" <?=get_checked("",get_request("paymethod"))?> onclick="chkListClick(this)">
                                전체
                            </label>
                            <?php foreach( $GLOBALS['paymethod'] as $key=>$value ){ ?>
                            <label>
                                <input type="checkbox" name="paymethod[]" value="<?=$key?>" <?=get_checked($key,get_request("paymethod"))?> onclick="chkListClick(this)">
                                <?=$value?>
                            </label>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주문상태</th>
                        <td>
                            <span class="w15p inline">
                                <label><input type="checkbox" id="state" name="state[]" value="" <?=get_checked("",get_request("state"))?>  onclick="chkListClick(this)">전체</label>
                            </span>
                            <?php foreach( $GLOBALS['od_stt'] as $key=>$value ){?>
                            <span class="w15p inline">
                                <label><input type="checkbox" name="state[]" value="<?=$key?>" <?=get_checked($key,get_request("state"))?>  onclick="chkListClick(this)"><?=$value['title']?></label>
                            </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">구매확정</th>
                        <td>
                            <?=get_frm_radio("confirm",'',get_request("confirm"),'전체')?>
                            <?=get_frm_radio("confirm",'y',get_request("confirm"),'구매 확정')?>
                            <?=get_frm_radio("confirm",'n',get_request("confirm"),'구매 미확정')?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_theme">
                    <input type="button" value="초기화" id="freset" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 주문건 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Order/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w150">  <!-- 주문일시 -->
                            <col class="w100">   <!-- 가맹점 -->
                            <col class="w130">  <!-- 주문번호 -->
                            <col class="w100">  <!-- 일련번호 -->
                            <col class="w100">  <!-- 공급사 -->
                            <col class="w80">  <!-- 상품 아이디  -->
                            <col class="w200">  <!-- 주문 상품 명 -->
                            <col class="w50">   <!-- 수량 -->
                            <col class="w80">   <!-- 배송비 -->
                            <col class="w80">   <!-- 결제금액 -->
                            <col class="w100">   <!-- 결제방법 -->
                            <col class="w100">   <!-- 주문상태 -->
                            <col class="w150">  <!-- 주문자 아이디 -->
                            <col class="w100">   <!-- 주문자 이름 -->
                            <col class="w130">  <!-- 주문자 전화번호 -->
                            <col class="w130">  <!-- 최종처리일시 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">주문일시</th>
                                <th scope="col" class="bg_light_yellow">가맹점</th>
                                <th scope="col">주문번호</th>
                                <th scope="col">주문일련번호</th>
                                <th scope="col" class="bg_light_blue fc_blue">공급사</th>
                                <th scope="col">상품번호(ID)</th>
                                <th scope="col">주문상품</th>
                                <th scope="col">수량</th>
                                <th scope="col">배송비</th>
                                <th scope="col">결제금액</th>
                                <th scope="col">결제방법</th>
                                <th scope="col">주문상태</th>
                                <th scope="col">주문자 ID</th>
                                <th scope="col">주문자 이름</th>
                                <th scope="col">주문자 전화번호</th>
                                <th scope="col">최종처리일시</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->rowArr as $odNo=>$rowArr){ ?>
                        <?php $j=0; foreach($rowArr as $row){ ?>
                        <tr>
                            <td>
                                <input type="hidden" name="userId[<?=$i?>]" value="<?=$row['mb_id']?>">
                                <input type="hidden" name="odId[<?=$i?>]" value="<?=$row['od_id']?>">
                                <input type="hidden" name="odNo[<?=$i?>]" value="<?=$row['od_no']?>">
                                <input type="checkbox" name="chk[]" value="<?=$i?>">
                            </td>
                            <?php if($j==0){  ?>
                            <td rowspan="<?=count($rowArr)?>"><?=$row['od_dt']?></td>
                            <td rowspan="<?=count($rowArr)?>"><?=$this->pt_li[$row['pt_id']]?></td>
                            <td rowspan="<?=count($rowArr)?>"><?=od_no($row['od_no'])?></td>
                            <?php } ?>
                            <td><?=od_id($row['od_id'])?></td>
                            <td><?=$this->sl_li[$row['sl_id']]?></td>
                            <td><?=$row['gs_id']?></td>
                            <td class="tal dot"><?=$row['od_goods_info']['goodsName']?></td>
                            <td><?=$row['od_qty']?></td>
                            <td class="tar"><?=number_format($row['od_delivery_charge']+$row['od_delivery_charge_dosan'])?></td>
                            <td class="tar"><?=number_format($row['od_amount']+$row['od_use_point']+$row['od_use_coupon'])?></td>
                            <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                            <td class="fw_400"><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                            <td><?=mb_id($row['mb_id'])?></td>
                            <td><?=$row['orderer_name']?></td>
                            <td><?=$row['orderer_cellphone']?></td>
                            <td><?=$row['od_rcent_dt']?></td>
                        </tr>
                        <?php $j++;$i++; } ?>
                        <?php  } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
        <?php if(empty($_REQUEST['paymethod'])){ ?>
        $("input[name='paymethod[]']").prop("checked",true);
        <?php } ?>

        <?php if(empty($_REQUEST['state'])){ ?>
        $("input[name='state[]']").prop("checked",true);
        <?php } ?>

        })
</script>
