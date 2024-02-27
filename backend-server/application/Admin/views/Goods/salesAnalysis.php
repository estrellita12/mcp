<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>주문일</th>
                        <td>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"", false)?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        총 판매 상품갯수 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="right_wrap">
                        <a href="/Goods/salesAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead02_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w60">
                            <col class="w300">
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="2">상품</th>
                                <th>판매 갯수</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($this->row as $row){ ?>
                        <tr>
                            <td><?=gs_id($row['gs_id'])?></td>
                            <td class="tal dot"><?=$row['gs_name']?></td>
                            <td><div style="width:<?=($row['sum_qty']/$this->max)*100?>%" class="bg_theme fc_white padt3 padb3 dot"><?=$row['sum_qty']?></div></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
