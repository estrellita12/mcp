<section class="cont_inner">
    <h1 class="pg_tit"><?=empty($this->tabInfo['name'])?"상품 선택":$this->tabInfo['name'];?></h1>
    <form action="#" method="GET">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w100">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch">
                                <?= get_frm_option('name', $_REQUEST['srch'], '상품명'); ?>
                                <?= get_frm_option('id', $_REQUEST['srch'], '상품번호'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=!empty($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
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
    <form method="POST">
        <div class="chead01_wrap ofxh">
            <table>
                <colgroup>
                    <col class="w100">   <!-- 상품 번호 -->
                    <col class="w200">  <!-- 상품명  -->
                    <col class="w70">   <!-- 재고 -->
                    <col class="w70">   <!-- 재고 -->
                    <col class="w70">   <!-- 재고 -->
                    <col class="w70">   <!-- 재고 -->
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">상품번호(ID)</th>
                        <th scope="col">옵션명</th>
                        <th scope="col">타입</th>
                        <?=get_sort_tag("stockQty","재고")?>
                        <th scope="col">사용여부</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="plan_gs_example" class="sortable">
                    <?php $i=0; foreach($this->option->getList($this->col) as $row) { ?>
                    <tr>
                        <td><input type="hidden" name="goodsList[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                        <td class="tal"><?=$row['gs_opt_name']?></td>
                        <td><?=$GLOBALS['gs_opt_type'][$row['gs_opt_type']]?></td>
                        <td><?=number_format($row['gs_opt_stock_qty'])?></td>
                        <td><?=$row['gs_opt_use_yn']?></td>
                        <td><a href="#" onclick="selectGoods(<?=$row['gs_opt_id']?>)" class="btn_small btn_white">선택</a></td>
                    </tr>
                    <?php  $i++; } ?>
                </tbody>
            </table>
            <?= str_paging("10", $_REQUEST['page'], ceil($this->option->getCnt()/$_REQUEST['rpp']), get_query('page') ); ?>
        </div>
    </form>
</section>
<script>
function selectGoods(gs_id)
{
    var of = window.opener.<?=$_GET['opener']?>;
    of.goodsOptionId.value=gs_id;
/*
    of.<?php echo ($_GET['frm_zip']); ?>.value = zip;
    of.<?php echo ($_GET['frm_addr1']); ?>.value = addr1;
    of.<?php echo ($_GET['frm_addr2']); ?>.value = addr2;
    of.<?php echo ($_GET['frm_addr3']); ?>.value = addr3;
    of.<?php echo ($_GET['frm_addr2']); ?>.focus();
    window.close();
*/
    window.close();
}
</script>

