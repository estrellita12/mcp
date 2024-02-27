<section class="cont_inner">
    <h1 class="pg_tit">진열 상품 설정</h1>
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
                                <?= get_frm_option('name', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '상품명'); ?>
                                <?= get_frm_option('id', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '상품번호'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
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
    <form action="/Partner/setMenu/<?=$this->param['ident']?>" method="POST" onsubmit="return frmExample()">
        <div class="layout02_wrap">
            <div class="layout_inner">
                <div class="chead01_wrap">
                    <div class="rect_wrap">
                        <span class="cnt_wrap">
                            검색된 총 상품수 : <span class="cnt"><?= number_format( $this->goods->getCnt() ) ?></span> 개
                        </span>
                    </div> 
                    <table>
                        <colgroup>
                            <col class="w60">   <!-- 상품 번호 -->
                            <col class="w200">  <!-- 상품명  -->
                            <col class="w50">   <!-- 진열 -->
                            <col class="w70">   <!-- 재고 -->
                            <col class="w70">   <!-- 판매수 -->
                            <col class="w70">   <!-- 조회수 -->
                            <col class="w110">   <!-- 수정일 -->
                            <col class="w110">   <!-- 등록일 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <?=get_sort_tag("id","상품 번호");?>
                                <?=get_sort_tag("name","상품명");?>
                                <th scope="col">진열</th>
                                <?=get_sort_tag("stockQty","재고");?>
                                <?=get_sort_tag("orderQty","판매수");?>
                                <?=get_sort_tag("viewCnt","조회수");?>
                                <?=get_sort_tag("updateDate","수정일시");?>
                                <?=get_sort_tag("regDate","등록일시");?>
                            </tr>
                        </thead>
                        <tbody id="gs_sortable_example" class="sortable">
                            <?php $i=0; foreach($this->goods->getList($this->col) as $row) { ?>
                            <tr>
                                <td><input type="hidden" name="goodsList<?=$this->param['action']?>[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                                <td class="tal"><?=$row['gs_name']?></td>
                                <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                <td><?=number_format($row['gs_stock_qty'])?></td>
                                <td><?=number_format($row['gs_order_qty'])?></td>
                                <td><?=number_format($row['gs_view_cnt'])?></td>
                                <td><?=$row['gs_update_dt']?></td>
                                <td><?=$row['gs_reg_dt']?></td>
                            </tr>
                            <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->goods->getCnt()/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </div>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="tal rect_wrap">
                    <span class="cnt_wrap">
                        선택된 총 상품수 : <span class="cnt" id="cfCnt"><?=$this->gsCnt?></span> 개
                    </span>
                    <span class="right_wrap">
                        <button type="submit"  class="btn_small btn_red">변경 사항 적용</button>
                    </span>
                </div> 
                <div class="chead02_wrap">
                    <table id="sort_table">
                        <colgroup>
                            <col class="w60">   <!-- 상품 번호 -->
                            <col class="w200">  <!-- 상품명  -->
                            <col class="w50">   <!-- 진열 -->
                            <col class="w70">   <!-- 재고 -->
                            <col class="w70">   <!-- 판매수 -->
                            <col class="w70">   <!-- 조회수 -->
                            <col class="w70">   <!-- 수정일 -->
                            <col class="w70">   <!-- 등록일 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <?=get_sort_tag("id","상품 번호");?>
                                <?=get_sort_tag("name","상품명");?>
                                <th scope="col">진열</th>
                                <?=get_sort_tag("stockQty","재고");?>
                                <?=get_sort_tag("orderQty","판매수");?>
                                <?=get_sort_tag("viewCnt","조회수");?>
                                <?=get_sort_tag("updateDate","수정일시");?>
                                <?=get_sort_tag("regDate","등록일시");?>
                            </tr>
                        </thead>

                        <tbody id="gs_sortable" class="sortable" style="height:50px">
                            <?php $i=0; foreach( $this->row as $row) { ?>
                            <tr>
                                <td><input type="hidden" name="goodsList<?=$this->param['action']?>[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                                <td class="tal"><?=$row['gs_name']?></td>
                                <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                <td><?=number_format($row['gs_stock_qty'])?></td>
                                <td><?=number_format($row['gs_order_qty'])?></td>
                                <td><?=number_format($row['gs_view_cnt'])?></td>
                                <td><?=$row['gs_update_dt']?></td>
                                <td><?=$row['gs_reg_dt']?></td>

                            </tr>
                            <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</section>
<script>
    function ready(){
        $(".sortable").mouseup( function(){
            $("#cfCnt").html( $("#sort_table > tbody > tr ").length  );
        });

        $( "#gs_sortable, #gs_sortable_example" ).sortable({
            connectWith: ".sortable"
        }).disableSelection();
    }

    function frmExample(){
        $("#gs_sortable_example input").attr("disabled","disabled");
    }

    $(function() {
        ready();
    });
</script>
