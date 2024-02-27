<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch" onsubmit="return frmCommaSubmit()">
            <div class="h2">상세 검색</div>
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                        <?php require_once(_VIEW."Goods/query.inc.php") ?>
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
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <select onchange="getExcelUrl(this)" class="w150">
                            <option value="/Goods/listExcel?<?=get_qstr("rpp,page")?>">검색 결과</option>
                            <option value="/Goods/bulkEditExcel?<?=get_qstr("rpp,page")?>">일괄 상품 수정</option>
                        </select>
                        <a href="/Goods/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel" id="getDownload"> 엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Goods/form?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+ 상품 추가</a>
                    <a href="#" id="copy" class="list_update btn_small btn_line_blue" data-tab="Goods">선택 복사</a>
                    <a href="#" id="remove" class="list_update btn_small btn_line_red" data-tab="Goods">선택 삭제 요청</a>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
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
                            <col class="w60">
                            <col class="w100">  <!-- 판매가 -->
                            <col class="w150">  <!-- 등록일 -->
                            <col class="w150">  <!-- 수정일 -->
                            <col class="w70">  <!-- 조회수 -->
                            <col class="w70">  <!-- 판매수량 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <?=get_sort_tag("gs_id","상품번호(ID)")?>
                                <th scope="col">이미지</th>
                                <th scope="col">상품명</th>
                                <?=get_sort_tag("sl_id","공급사")?>
                                <?=get_sort_tag("gs_isopen","진열")?>
                                <?=get_sort_tag("gs_stock_qty","재고")?>
                                <?=get_sort_tag("gs_consumer_price","소비자가")?>
                                <?=get_sort_tag("gs_supply_price","공급가")?>
                                <th scope="col">수수료</th>
                                <?=get_sort_tag("gs_price","판매가")?>
                                <?=get_sort_tag("gs_reg_dt","등록일시")?>
                                <?=get_sort_tag("gs_update_dt","수정일시")?>
                                <?=get_sort_tag("gs_view_cnt","조회수")?>
                                <?=get_sort_tag("gs_order_qty","판매수량")?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($this->row as $row) { ?>
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
                                <td rowspan="2"><?=$this->my['sl_name']?></td>
                                <td rowspan="2"><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                <td rowspan="2"><?=number_format($row['gs_stock_qty'])?></td>
                                <td rowspan="2"><?=number_format($row['gs_consumer_price'])?>원</td>
                                <td rowspan="2"><?=number_format($row['gs_supply_price'])?>원</td>
                                <td rowspan="2"><?=round((($row['gs_price']-$row['gs_supply_price'])/$row['gs_price'])*100)?>%</td>
                                <td rowspan="2"><?=number_format($row['gs_price'])?>원</td>
                                <td rowspan="2"><?=$row['gs_reg_dt']?></td>
                                <td rowspan="2"><?=$row['gs_update_dt']?></td>
                                <td rowspan="2"><?=number_format($row['gs_view_cnt'])?>회</td>
                                <td rowspan="2"><?=number_format($row['gs_order_qty'])?>개</td>
                            </tr>
                            <tr class="list<?= $i%2 ?>">
                                <td class="tal ctg_nav">
                                    <?=$this->categoryModel->getNavStr(isset($row['gs_ctg'])?$row['gs_ctg']:"")?>
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
        <div class="help_wrap"> 
            <div class="h2">도움말</div>
            <div class="h3">상품 수정 페이지는 어떻게 하나요??</div>
            <ul>
                <li>상품번호(ID) 클릭시 해당 상품 수정 페이지로 이동됩니다.</li>
            </ul>
            <div class="h3">선택 보류는 무엇인가요?</div>
            <ul>
                <li>상품리스트 내 운영자가 선택한 상품을 보류처리하여 판매를 중지합니다.</li>
                <li>보류된 상품은 판매 보류 상품 페이지에서 확인 가능합니다.</li>
            </ul>

        </div>

    </div>
</section>
