<section class="cont_inner">
    <h1 class="pg_tit">상품 설정</h1>
    <div class="pg_info">
        <ul>
            <li>원하는 항목을 선택하여 왼쪽의 상품을 오른쪽으로  드래그 앤 드롭하여 옮겨주세요.</li>
            <li>오른쪽에 선택된 상품들은 변경 사항 적용 버튼을 클릭해야 반영됩니다. </li>
        </ul>
    </div>
    <form action="#" method="GET" id="frmSearch" name="frmSearch">
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
                                <?= get_frm_option('id', $_REQUEST['srch'], '상품번호(ID)'); ?>
                                <?= get_frm_option('name', $_REQUEST['srch'], '상품명'); ?>
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
    <form action="/Design/setPlanGoods/<?=$this->param['ident']?>" method="POST" onsubmit="return frmExample()">
        <div class="chead02_wrap">
            <table>
                <colgroup>
                    <col>
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <td class="tal rect_wrap">
                            <span class="cnt_wrap">
                                <div class="h2">검색된 총 상품수 : <span class="cnt"><?= number_format( $this->goods->getCnt() ) ?></span> 개</div>
                            </span>
                        </td> 
                        <td class="tal rect_wrap">
                            <span class="cnt_wrap">
                                <div class="h2">검색된 총 상품수 : <span class="cnt" id="cfCnt"><?=$this->gsCnt?></span> 개</div>
                            </span>
                            <span class="right_wrap padt4">
                                <button type="button"  class="btn_small btn_blue" onClick="putGoodsList()">변경 사항 적용</button>
                            </span>
                        </td> 
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <div class="chead01_wrap">
                                <table>
                                    <colgroup>
                                        <col class="w80">   <!-- 상품 번호 -->
                                        <col class="w200">  <!-- 상품명  -->
                                        <col class="w60">   <!-- 재고 -->
                                        <col class="w60">   <!-- 재고 -->
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <?=get_sort_tag("id","상품번호(ID)")?>
                                            <th scope="col">상품명</th>
                                            <th scope="col">진열</th>
                                            <?=get_sort_tag("stockQty","재고")?>
                                        </tr>
                                    </thead>
                                    <tbody id="gs_sortable_example" class="sortable">
                                        <?php $i=0; foreach($this->goods->getList($this->col) as $row) { ?>
                                            <tr data-idx="<?=$row['gs_id']?>">
                                            <td><input type="hidden" name="goodsList[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                                            <td class="tal dot"><?=$row['gs_name']?></td>
                                            <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                            <td><?=number_format($row['gs_stock_qty'])?></td>
                                        </tr>
                                        <?php  $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= str_paging("10", $_REQUEST['page'], ceil($this->goods->getCnt()/$_REQUEST['rpp']), get_query('page') ); ?>
                        </td>
                        <td style="vertical-align:top">
                            <input type="hidden" name="goodsList" id="goodsList" value="<?=$this->param['ident']?>">
                            <table id="sort_table">
                                <colgroup>
                                    <col class="w60">   <!-- 상품 번호 -->
                                    <col class="w200">  <!-- 상품명  -->
                                    <col class="w50">   <!-- 진열 -->
                                    <col class="w50">   <!-- 재고 -->
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col" class="nsort">상품 번호</th>
                                        <th scope="col">상품명</th>
                                        <th scope="col">진열</th>
                                        <th scope="col" class="nsort">재고</th>
                                    </tr>
                                </thead>
                                <tbody id="gs_sortable" class="sortable" style="height:30px">
                                    <?php $i=0; foreach($this->gsList as $row) { ?>
                                    <tr data-idx="<?=$row['gs_id']?>">
                                        <td><input type="hidden" name="goodsList[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                                        <td class="tal"><?=$row['gs_name']?></td>
                                        <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                        <td><?=number_format($row['gs_stock_qty'])?></td>
                                    </tr>
                                    <?php  $i++; } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
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

        $(".sortable").sortable({
        update:function(index){
            str = "";
            $('#gs_sortable tr').each(function(index){
                var idx = $(this).attr('data-idx');
                if(idx=='') return;
                if(str!="") str += ",";
                str += idx;
                })
                $("#goodsList").val(str);
            }
        })
    }

    $(function() {
        ready();
   });

    function putGoodsList(){
        var li = $("#goodsList").val();
        //$(window.opener.load_wrap).load("/Design/planModify?test=asd&goodsId="+li+" #load_wrap");
        $(window.opener.load_wrap).load(window.opener.location.pathname+"?col=field&goodsId="+li+" #load_wrap");
        //var of = window.opener.frmPlan;
        //of.goodsList.value = li;
        setTimeout(function(){
            window.close();
        },400);
    }
</script>
