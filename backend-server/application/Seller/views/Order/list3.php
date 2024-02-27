<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="h2">주문 검색</div>
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                        <?php  require_once _VIEW."Order/query.inc.php";  ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_theme">
                    <input type="button" value="초기화" id="freset" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form action="/Order/listUpdateState" method="post">
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
                    <span class="right_wrap">
                        <select name="state">
                            <?php foreach($GLOBALS['od_stt'][$this->stt]['next'] as $stt){ ?>
                            <?=get_frm_option($stt,"",$GLOBALS['od_stt'][$stt]['title']);?>
                            <?php } ?>
                        </select>
                        <input type="submit" class="btn_small btn_red" value="주문 상태 일괄 변경" name="message">
                    </span>
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
                                <th scope="col">공급가액</th>
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
                                    <input type="hidden" name="odId[<?=$i?>]" value="<?=$row['od_id']?>">
                                    <input type="checkbox" name="chk[]" value="<?=$i?>">
                                </td>
                                <?php if($j==0){  ?>
                                <td rowspan="<?=count($rowArr)?>"><?=$row['od_dt']?></td>
                                <td rowspan="<?=count($rowArr)?>"><?=$this->pt_li[$row['pt_id']]?></td>
                                <td rowspan="<?=count($rowArr)?>"><?=$row['od_no']?></td>
                                <?php } ?>
                                <td><?=od_id($row['od_id'])?></td>
                                <td><?=$this->sl_li[$row['sl_id']]?></td>
                                <td class="tal dot"><?=$row['od_goods_info']['goodsName']?></td>
                                <td><?=$row['od_qty']?></td>
                                <td class="tar"><?=number_format($row['od_delivery_charge']+$row['od_delivery_charge_dosan'])?></td>
                                <td class="tar"><?=number_format($row['od_supply_price'])?></td>
                                <td><?=$GLOBALS['paymethod'][$row['od_paymethod']]?></td>
                                <td class="fw_400"><?=$GLOBALS['od_stt'][$row['od_stt']]['title']?></td>
                                <td><?=$row['mb_id']?></td>
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
