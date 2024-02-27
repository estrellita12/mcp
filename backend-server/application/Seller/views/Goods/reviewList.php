<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="h2">상세 검색</div>
            <div class="search_wrap">
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
                                    <?= get_frm_option('gs_id', get_request("srch"), '상품번호(ID)'); ?>
                                </select>
                                <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">가맹점</th>
                            <td>
                                <select name="shop" class="w200 select2">
                                    <?= get_frm_option('',$_REQUEST['shop'],"전체"); ?>
                                    <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                    <?= get_frm_option($id,$_REQUEST['shop'],$name); ?>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>기간 검색</th>
                            <td>
                                <div>
                                    <select name="term" class="w130">
                                        <?= get_frm_option('gs_rv_reg_dt', get_request("term"), '상품후기일'); ?>
                                    </select>
                                    <?=get_date_group('beg','end',false)?>
                                </div>
                                <div class="mart5">
                                    <?=get_frm_date('beg',get_request("beg"),"date")?>
                                    <?=get_frm_date('end',get_request("end"),"date")?>
                                </div>
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
                        검색된 후기 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Goods/reviewListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="w40"></th>
                                <?=get_sort_tag("gs_id","상품번호(ID)","w100")?>
                                <th scope="col" class="w200">상품명</th>
                                <th scope="col" class="w100">옵션명</th>
                                <?=get_sort_tag("gs_rv_star_rating","평점","w100")?>
                                <th scope="col" class="w130">작성자</th>
                                <th scope="col" class="w100">공급사</th>
                                <th scope="col" class="w100">가맹점</th>
                                <?=get_sort_tag("gs_rv_reg_dt","등록일시","w140")?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($this->row as $row) { ?>
                            <tr class="list<?= $i%2 ?>">
                                <td><?=$row['gs_rv_id']?></td>
                                <td><?=gs_id($row['gs_id'])?></td>
                                <td class="tal dot"><?=gs_name($row['gs_id'],$row['gs_rv_name'])?></td>
                                <td><?=$row['gs_rv_opt_name']?></td>
                                <td>
                                    <a href="#" onclick="winOpen('/Goods/reviewDescPopup/<?=$row['gs_rv_id']?>','reviewForm','900','600','yes')" >
                                        <?=img_rating($row['gs_rv_star_rating'])?>
                                    </a>
                                </td>
                                <td><?=$row['mb_id']?></td>
                                <td><?=$this->sl_li[$row['gs_rv_sl_id']]?></td>
                                <td><?=$this->pt_li[$row['gs_rv_pt_id']]?></td>
                                <td><?=$row['gs_rv_reg_dt']?></td>
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
