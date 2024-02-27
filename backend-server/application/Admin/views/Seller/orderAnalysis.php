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
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"), false)?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_black">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_gray">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="right_wrap">
                        <a href="/Seller/orderAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w150">
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>기간</th>
                                <th>공급사</th>
                                <?=get_sort_tag("cnt","주문 건수")?>
                                <?=get_sort_tag("sum_qty","주문 갯수")?>
                                <?=get_sort_tag("sum_goods_price","상품 총액")?>
                                <?=get_sort_tag("sum_supply_price","공급가 총액")?>
                                <?=get_sort_tag("sum_amount","판매 총액")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($this->row as $row){ ?>
                        <tr>
                            <td><?=$_REQUEST['beg']?> ~ <?=$_REQUEST['end']?></td>
                            <td><?=sl_id($row['sl_id'],$this->sl_li[$row['sl_id']])?></td>
                            <td><?=$row['cnt']?></td>
                            <td><?=$row['sum_qty']?></td>
                            <td><?=$row['sum_goods_price']?></td>
                            <td><?=$row['sum_supply_price']?></td>
                            <td><?=$row['sum_amount']?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>
