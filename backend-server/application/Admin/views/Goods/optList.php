<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch" onsubmit="return frmCommaSubmit()">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('id', get_request("srhc"), '옵션번호(ID)'); ?>
                                <?= get_frm_option('goodsId', get_request("srch"), '상품번호(ID)'); ?>
                                <?= get_frm_option('name', get_request("srch"), '옵션명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">옵션 재고</th>
                        <td>
                            <input type="text" name="geQty" class="comma" value="<?=get_request("geQty","number")?>" size=10> 개 이상 ~ 
                            <input type="text" name="leQty" class="comma" value="<?=get_request("leQty","number")?>" size=10> 개 이하
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">옵션 사용 여부</th>
                        <td>
                            <?=get_frm_radio("useYn","",get_request("useYn"),"전체")?>
                            <?=get_frm_radio("useYn","y",get_request("useYn"),"사용")?>
                            <?=get_frm_radio("useYn","n",get_request("useYn"),"미사용")?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">옵션 타입</th>
                        <td>
                            <?=get_frm_radio("type","",get_request("type"),"전체")?>
                            <?=get_frm_radio("type","1",get_request("type"),"필수 옵션")?>
                            <?=get_frm_radio("type","2",get_request("type"),"추가 옵션")?>
                        </td>
                    </tr>
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
                        <select onchange="getExcelUrl(this)">
                            <option value="/Goods/optListExcel?<?=get_qstr("rpp,page")?>">검색 결과</option>
                            <option value="/Goods/optBulkEditExcel?<?=get_qstr("rpp,page")?>">일괄 옵션 수정</option>
                        </select>
                        <a href="/Goods/optListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel" id="getDownload"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w100">   <!-- 상품 번호 -->
                            <col class="w100">   <!-- 옵션 번호 -->
                            <col class="w80">   <!-- 옵션 코드 -->
                            <col class="w200">  <!-- 상품명 -->
                            <col class="w200">  <!-- 옵션명 -->
                            <col class="w60">  <!-- 진열 -->
                            <col class="w100">  <!-- 공급사 -->
                            <col class="w60">  <!-- 옵션타입 -->
                            <col class="w100">  <!-- 추가금액 -->
                            <col class="w80">  <!-- 재고 -->
                            <col class="w80">  <!-- 통보수량 -->
                            <col class="w60">  <!-- 사용 여부 -->
                            <col class="w150">  <!-- 등록일시 -->
                            <col class="w150">  <!-- 등록일시 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <?=get_sort_tag("goodsId","상품번호(ID)")?>
                                <?=get_sort_tag("id","옵션번호(ID)")?>
                                <th scope="col">옵션바코드</th>
                                <th scope="col">상품명</th>
                                <th scope="col">옵션명</th>
                                <th scope="col">진열</th>
                                <th scope="col">공급사</th>
                                <?=get_sort_tag("type","타입")?>
                                <th scope="col">추가금액</th>
                                <?=get_sort_tag("stockQty","재고")?>
                                <th scope="col">통보수량</th>
                                <th scope="col">사용여부</th>
                                <?=get_sort_tag("regDate","등록일시")?>
                                <?=get_sort_tag("updateDate","수정일시")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->option->getList($this->col) as $row) {  ?>
                        <tr class="list<?= $i%2 ?>">
                            <td>
                                <input type="hidden" name="idxl[<?=$i;?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]" value="">
                            </td>
                            <td><?=gs_id($row['gs_id'])?></td>
                            <td><?=$row['gs_opt_id']?></td>
                            <td><?=$row['gs_opt_code']?></td>
                            <td class="tal dot"><?=$row['gs_name']?></td>
                            <td class="tal dot"><?=$row['gs_opt_name']?></td>
                            <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                            <td><?=sl_id($row['sl_id'],$this->sl_li[$row['sl_id']])?></td>
                            <td><?=$GLOBALS['gs_opt_type'][$row['gs_opt_type']]?></td>
                            <td><?=number_format($row['gs_opt_add_price'])?>원</td>
                            <td><?=number_format($row['gs_opt_stock_qty'])?>개</td>
                            <td><?=number_format($row['gs_opt_stock_qty_noti'])?>개</td>
                            <td><?=img_visible($row['gs_opt_use_yn'],'y',20)?></td>
                            <td><?=$row['gs_opt_reg_dt']?></td>
                            <td><?=$row['gs_opt_update_dt']?></td>
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
