<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <p class="cont_info">
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w140">
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
                    <input type="submit" value="검색" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="right_wrap">
                        <a href="/Partner/orderAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w150">
                            <col class="w100">
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
                                <th>가맹점</th>
                                <?=get_sort_tag("cnt","주문 건수")?>
                                <?=get_sort_tag("sum_qty","주문 갯수")?>
                                <?=get_sort_tag("sum_goods_price","상품 총액")?>
                                <th>포인트 총액</th>
                                <th>쿠폰 총액</th>
                                <?=get_sort_tag("sum_amount","판매 총액")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($this->row as $row){ ?>
                        <tr>
                            <td><?=$_REQUEST['beg']?> ~ <?=$_REQUEST['end']?></td>
                            <td><?=pt_id($row['pt_id'],$this->pt_li[$row['pt_id']])?></td>
                            <td><?=number_format($row['cnt'])?>건</td>
                            <td><?=number_format($row['sum_qty'])?>개</td>
                            <td><?=number_format($row['sum_goods_price'])?>원</td>
                            <td><?=number_format($row['sum_point'])?>원</td>
                            <td><?=number_format($row['sum_coupon'])?>원</td>
                            <td><?=number_format($row['sum_amount'])?>원</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>
