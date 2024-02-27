<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch" onsubmit="return frmCommaSubmit()">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <?php require_once(_VIEW."/Goods/query.inc.php") ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="freset" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 상품 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Goods/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="#" id="defer" class="list_update btn_small btn_line_blue" data-tab="Goods">상품 보류</a>
                    <span class="right_wrap">
                        <a href="#" id="removeReal" class="list_update btn_small btn_red" data-tab="Goods">상품 DB 삭제</a>
                    </span>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w100">   <!-- 상품 번호 -->
                            <col class="w70">  <!-- 이미지 -->
                            <col class="w300">  <!-- 상품명 -->
                            <col class="w100">  <!-- 공급사 -->
                            <col class="w60">  <!-- 진열 -->
                            <col class="w60">  <!-- 재고 -->
                            <col class="w100">  <!-- 소비자가 -->
                            <col class="w100">  <!-- 공급가 -->
                            <col class="w60">  <!-- 수수료 -->
                            <col class="w100">  <!-- 판매가 -->
                            <?php foreach($this->pt_gr_li as $idx=>$grade){ ?>
                            <col class="w100">  <!-- 판매가(A) -->
                            <?php } ?>
                            <col class="w150">  <!-- 등록일 -->
                            <col class="w150">  <!-- 수정일 -->
                            <col class="w70">  <!-- 조회수 -->
                            <col class="w70">  <!-- 판매수량 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <?=get_sort_tag("id","상품번호(ID)")?>
                                <th scope="col">이미지</th>
                                <th scope="col">상품명</th>
                                <?=get_sort_tag("seller","공급사")?>
                                <?=get_sort_tag("isopen","진열")?>
                                <?=get_sort_tag("stockQty","재고")?>
                                <?=get_sort_tag("consumerPrice","소비자가")?>
                                <?=get_sort_tag("supplyPrice","공급가")?>
                                <th scope="col">수수료</th>
                                <?=get_sort_tag("goodsPrice","판매가")?>
                                <?php foreach($this->pt_gr_li as $idx=>$grade){ ?>
                                <?=get_sort_tag("goodsPrice{$idx}",$grade)?>
                                <?php } ?>
                                <?=get_sort_tag("regDate","등록일시")?>
                                <?=get_sort_tag("updateDate","수정일시")?>
                                <?=get_sort_tag("viewCnt","조회수")?>
                                <?=get_sort_tag("orderQty","판매수량")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->goods->getList($this->col) as $row) { ?>
                        <tr class="list<?= $i%2 ?>">
                            <td rowspan="2">
                                <input type="hidden" name="idl[<?=$i;?>]" value="<?=$row['gs_id']?>">
                                <input type="checkbox" name="chk[]" value="">
                            </td>
                            <td rowspan="2"><?=gs_id($row['gs_id'])?></td>
                            <td rowspan="2">
                                <?=get_img( _GOODS.$row['gs_code'],$row['gs_simg1'], $w='50', $class="" )?>
                            </td>
                            <td class="tal dot"><?=gs_name($row['gs_id'],$row['gs_name'])?></td>
                            <td rowspan="2"><?=sl_id($row['sl_id'],$this->sl_li[$row['sl_id']])?></td>
                            <td rowspan="2"><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                            <td rowspan="2"><?=number_format($row['gs_stock_qty'])?></td>
                            <td rowspan="2"><?=number_format($row['gs_consumer_price'])?>원</td>
                            <td rowspan="2"><?=number_format($row['gs_supply_price'])?>원</td>
                            <td rowspan="2"><?=round((($row['gs_price']-$row['gs_supply_price'])/$row['gs_price'])*100)?>%</td>
                            <td rowspan="2"><?=number_format($row['gs_price'])?>원</td>
                            <?php foreach($this->pt_gr_li as $idx=>$grade){ ?>
                            <td rowspan="2"><?=number_format($row["gs_price_{$idx}"])?>원</td>
                            <?php } ?>
                            <td rowspan="2"><?=$row['gs_reg_dt']?></td>
                            <td rowspan="2"><?=$row['gs_update_dt']?></td>
                            <td rowspan="2"><?=number_format($row['gs_view_cnt'])?>회</td>
                            <td rowspan="2"><?=number_format($row['gs_order_qty'])?>개</td>
                        </tr>
                        <tr class="list<?= $i%2 ?>">
                            <td class="tal ctg_nav">
                                <?=$this->category->getNavStr(isset($row['gs_ctg'])?$row['gs_ctg']:"")?>
                                <?php if( !empty($row['gs_ctg2']) &&  !empty($row['gs_ctg3']) ){ echo "외 2개"; ?>
                                <?php }else if( !empty($row['gs_ctg2']) ) echo "외 1개"; ?>
                            </td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>

                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
