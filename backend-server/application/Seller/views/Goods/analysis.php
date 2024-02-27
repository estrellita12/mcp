<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="h2">주문 검색</div>
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
                                <?=get_frm_date('beg',get_request("beg"),"date")?>
                                <?=get_frm_date('end',get_request("end"),"date")?>
                                <?=get_date_group('beg','end',false)?>
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
                        총 판매갯수 :<b class="cnt"><?= number_format($this->sum) ?></b>개
                    </span>
                    <span class="right_wrap">
                        <a href="/Goods/analysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead02_wrap">
                    <table>
                        <colgroup>
                            <col class="w60">
                            <col class="w300">
                            <col class="w100">
                            <col class="w100">
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th colspan="2">상품</th>
                                <th>주문건수</th>
                                <th>판매총액</th>
                                <th>판매수량</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($this->row as $row){ $goods = json_decode($row['od_goods_info'],true); ?>
                            <tr>
                                <td><?=gs_id($row['gs_id'])?></td>
                                <td class="tal dot"><?=$goods['goodsName']?></td>
                                <td><?=number_format($row['od_cnt'])?>건</td>
                                <td><?=number_format($row['sum_amount'])?>원</td>
                                <td><div style="width:<?=($row['sum_qty']/$this->sum)*100?>%" class="bg_theme fc_white padt3 padb3"><?=$row['sum_qty']?>개</div></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>
