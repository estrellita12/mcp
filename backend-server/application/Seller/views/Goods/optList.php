<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch" onsubmit="return frmCommaSubmit()">
            <div class="search_wrap">
                <div class="h2">상세 검색</div>
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                            <td>
                                <select name="srch" id="srch" class="w130">
                                    <?= get_frm_option('gs_opt_id', get_request("srch"), '옵션번호(ID)'); ?>
                                    <?= get_frm_option('gs_id', get_request("srch"), '상품번호(ID)'); ?>
                                    <?= get_frm_option('gs_opt_name', get_request("srch"), '옵션명'); ?>
                                </select>
                                <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">상품 승인 상태</th>
                            <td>
                                <?=get_frm_radio("state","2",get_request("state"),"진열상태")?>
                                <?=get_frm_radio("state","1",get_request("state"),"대기상태")?>
                                <?=get_frm_radio("state","3",get_request("state"),"보류상태")?>
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
                        <select onchange="getExcelUrl(this)" class="w150">
                            <option value="/Goods/optListExcel?<?=get_qstr("rpp,page")?>">검색 결과</option>
                            <option value="/Goods/optBulkEditExcel?<?=get_qstr("rpp,page")?>">일괄 옵션 수정</option>
                        </select>
                        <a href="/Goods/optListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel" id="getDownload"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="w40"></th>
                                <th scope="col" class="w100">공급사</th>
                                <?=get_sort_tag("gs_id","상품번호(ID)", "w100")?>
                                <th scope="col" class="w200">상품명</th>
                                <th scope="col" class="w60">진열</th>
                                <?=get_sort_tag("gs_opt_id","옵션번호(ID)", "w100")?>
                                <th scope="col" class="w100">바코드</th>
                                <th scope="col" class="w150">옵션명</th>
                                <th scope="col" class="w60">사용여부</th>
                                <?=get_sort_tag("gs_opt_stock_qty","재고수량","w80")?>
                                <th scope="col" class="w80">통보수량</th>
                                <?=get_sort_tag("gs_opt_reg_dt","등록일시", "w140")?>
                                <?=get_sort_tag("gs_opt_update_dt","수정일시", "w140")?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($this->row as $row) {  ?>
                            <tr class="list<?= $i%2 ?>">
                                <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                                <td><?=$this->my['sl_name']?></td>
                                <td><?=gs_id($row['gs_id'])?></td>
                                <td class="tal dot"><?=$row['gs_name']?></td>
                                <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                <td><?=$row['gs_opt_id']?></td>
                                <td><?=$row['gs_opt_code']?></td>
                                <td class="tal dot"><?=$row['gs_opt_name']?></td>
                                <td><?=img_visible($row['gs_opt_use_yn'],'y',20)?></td>
                                <td><?=number_format($row['gs_opt_stock_qty'])?>개</td>
                                <td><?=number_format($row['gs_opt_stock_qty_noti'])?>개</td>
                                <td><?=$row['gs_opt_reg_dt']?></td>
                                <td><?=$row['gs_opt_update_dt']?></td>
                            </tr>
                            <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            <div class="help_wrap">
                <div class="h2">도움말</div>
                <div class="h3">옵션 추가금은 어떻게 설정하나요?</div>
                <ul>
                    <li>옵션 추가금은 설정이 불가합니다. </li>
                </ul>
            </div>
        </form>
    </div>
</section>
