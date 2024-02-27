<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?> </h1>
    <form action="" method="GET" id="frmSearch" name="frmSearch">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w120">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('no', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문번호'); ?>
                                <?= get_frm_option('id', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문일련번호'); ?>
                                <?= get_frm_option('goodsId', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '상품번호'); ?>
                                <?= get_frm_option('userId', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문자 아이디'); ?>
                                <?= get_frm_option('userName', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문자 이름'); ?>
                                <?= get_frm_option('userCellphone', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문자 전화번호'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="w130">
                                <?= get_frm_option("", "", "전체"); ?>
                                <?php foreach($this->pt_li as $id=>$name){ ?>
                                <?= get_frm_option($id, isset($_REQUEST['shop'])?$_REQUEST['shop']:"", $name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('orderDate', $_REQUEST['term'], '주문일'); ?>
                                <?= get_frm_option('rcentDate', $_REQUEST['term'], '최종처리일'); ?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
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
                        <th scope="row">구매확정</th>
                        <td>
                            <?=get_frm_radio("confirm",'',isset($_REQUEST['confirm'])?$_REQUEST['confirm']:"",'전체')?>
                            <?=get_frm_radio("confirm",'y',isset($_REQUEST['confirm'])?$_REQUEST['confirm']:"",'구매 확정')?>
                            <?=get_frm_radio("confirm",'n',isset($_REQUEST['confirm'])?$_REQUEST['confirm']:"",'구매 미확정')?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="confirm_wrap">
                <input type="submit" value="검색" id="fsearch" class="btn_medium btn_black">
                <input type="button" value="초기화" id="freset" class="btn_medium btn_gray">
            </div>
        </div>
    </form>
    <form action="/Order/listUpdateState" method="post">
        <input type="hidden" name="statePre" value="<?=$_REQUEST['state']?>">
        <div class="layout01_wrap">
            <div class="layout_inner">
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
                    <span class="right_wrap">
                        <select name="state">
                            <?php foreach($GLOBALS['od_stt'][$_REQUEST['state']]['next'] as $stt){ ?>
                            <?=get_frm_option($stt,"",$GLOBALS['od_stt'][$stt]['title']);?>
                            <?php } ?>
                        </select>
                        <input type="submit" class="btn_small btn_red" value="주문 상태 일괄 변경" name="type">
                    </span>
                    <a href="/Order/deliveryBult" class="btn_small btn_line_blue">송장 일괄 등록</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w150">  <!-- 주문일시 -->
                            <col class="w100">   <!-- 가맹점 -->
                            <col class="w130">  <!-- 주문번호 -->
                            <col class="w100">  <!-- 일련번호 -->
                            <col class="w100">  <!-- 공급사 -->
                            <col class="w200">  <!-- 주문 상품 명 -->
                            <col class="w50">   <!-- 수량 -->
                            <col class="w80">   <!-- 배송비 -->
                            <col class="w80">   <!-- 결제금액 -->
                            <col class="w100">   <!-- 결제방법 -->
                            <col class="w100">   <!-- 주문상태 -->
                            <col class="w150">   <!-- 택배사 -->
                            <col class="w120">   <!-- 송장번호 -->
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
                                <th scope="col">주문상품</th>
                                <th scope="col">수량</th>
                                <th scope="col">배송비</th>
                                <th scope="col">결제금액</th>
                                <th scope="col">결제방법</th>
                                <th scope="col">주문상태</th>
                                <th scope="col">택배사</th>
                                <th scope="col">송장번호</th>
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
                                <td rowspan="<?=count($rowArr)?>"><?=pt_id($row['pt_id'],$this->pt_li[$row['pt_id']])?></td>
                                <td rowspan="<?=count($rowArr)?>"><?=od_no($row['od_no'])?></td>
                                <?php } ?>
                                <td><?=od_id($row['od_id'])?></td>
                                <td><?=sl_id($row['sl_id'],$this->sl_li[$row['sl_id']])?></td>
                                <td class="tal dot"><?=gs_name($row['gs_id'],$row['od_goods_info']['goodsName'])?></td>
                                <td><?=$row['od_qty']?></td>
                                <td class="tar"><?=number_format($row['od_delivery_charge']+$row['od_delivery_charge_dosan'])?></td>
                                <td class="tar"><?=number_format($row['od_amount']+$row['od_use_point']+$row['od_use_coupon'])?></td>
                                <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                                <td class="fw_400"><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                                <td>
                                    <select name="deliveryCompany[]">
                                        <?=get_frm_option("",$row['od_delivery_company'],"선택")?>
                                        <?php foreach($this->config['cf_delivery_company'] as $key=>$dv){ ?>
                                        <?=get_frm_option($key,$row['od_delivery_company'],$dv['company'])?>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><input type="text" name="deliveryNo[]" value="<?=$row['od_delivery_no']?>" class="w100p"></td>
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
        </div>
    </form>
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
