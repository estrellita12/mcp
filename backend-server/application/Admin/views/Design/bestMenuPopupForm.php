<style>
.drag_list01 {}
.drag_list01 ul > li { cursor:pointer }
.drag_list01 ul > li > span{ display : inline-block }
.drag_list01 ul > li > span{ width:70px; }
.drag_list01 ul > li > span:nth-child(1){ width:40px; }
.drag_list01 ul > li > span:nth-child(2){ width:50px; }
.drag_list01 ul > li > span:nth-child(3){ width:60px; }
.drag_list01 ul > li > span:nth-child(4){ width:400px; }
.drag_list01 ul > li > span:nth-child(11){ width:40px; }
.drag_list01 ul > li > span:nth-child(12){ width:40px; }
.drag_list01 ul > li > span:nth-child(13){ width:40px; }
</style>


<div id="newWin">
    <div class="pg_header">
        <p class="pg_tit" id="pg_tit"><?=$this->row['name'] ?></p>
    </div>
    <section class="popup_inner">
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
                            <select name="scCol">
                                <?= get_frm_option('gname', $_REQUEST['scCol'], '상품명'); ?>
                                <?= get_frm_option('idx', $_REQUEST['scCol'], '상품코드'); ?>
                            </select>
                            <input type="text" name="scV" value="<?php echo $_REQUEST['scV']; ?>" size="30">
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
        <br>
            <?php if( trim(get_where()) != "" ){ ?>
                <div class="chead01_wrap">
                <h2 class="cnt_wrap">
                    <span>검색된 총 상품수 : <span class="cnt"><?= number_format( $this->query->getCnt("web_goods", get_where() ) ) ?></span>개</span>
                </h2>

                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w50">  <!-- 이미지 -->
                            <col class="w100">  <!-- 상품번호/상품코드 -->
                            <col>  <!-- 상품명 / 카테고리 -->
                            <col class="w80">   <!-- 재고 -->
                            <col class="w80">   <!-- 진열 -->
                            <col class="w80">   <!-- 가격정보 > 공급가 -->
                            <col class="w80">   <!-- 가격정보 > 판매가 -->
                            <col class="w80">   <!-- 가격정보 > 판매가 -->
                            <col class="w80">   <!-- 가격정보 > 판매가 -->
                            <col class="w50">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                <th scope="col" rowspan="2">이미지</th>
                                <th scope="col"><a href="<?=get_sort_url("idx",$_REQUEST['ColBy'])?>">상품번호</a></th>
                                <th scope="col"><a href="<?=get_sort_url("gname",$_REQUEST['ColBy'])?>">상품명</a></th>
                                <th scope="col"><a href="<?=get_sort_url("sum_qty",$_REQUEST['ColBy'])?>">재고</a></th>
                                <th scope="col"><a href="<?=get_sort_url("isopen",$_REQUEST['ColBy'])?>">진열</a></th>
                                <th scope="col"><a href="<?=get_sort_url("update_time",$_REQUEST['ColBy'])?>">공급가</a></th>
                                <th scope="col"><a href="<?=get_sort_url("goods_price_9",$_REQUEST['ColBy'])?>">폐쇄몰가</a></th>
                                <th scope="col"><a href="<?=get_sort_url("goods_price_8",$_REQUEST['ColBy'])?>">반폐쇄몰가</a></th>
                                <th scope="col"><a href="<?=get_sort_url("goods_price_7",$_REQUEST['ColBy'])?>">오픈몰가</a></th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                        <?php $i=0; foreach($this->query->getRowAll("web_goods","*",get_where(), get_orderBy(), get_limit() ) as $row) { ?>
                        <tr class="list<?= $i%2 ?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i;?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]" value="">
                            </td>
                            <td><img src="https://killdeal.co.kr/data/goods/<?=$row['simg1']?>" width=30></td>
                            <td><?=$row['idx']?></td>
                            <td><?=$row['gname']?></td>
                            <td><?=number_format($row['stock_qty'])?></td>
                            <td><?=$row['isopen']?></td>
                            <td><?=number_format($row['supply_price'])?></td>
                            <td><?=number_format($row['goods_price_9'])?></td>
                            <td><?=number_format($row['goods_price_8'])?></td>
                            <td><?=number_format($row['goods_price_7'])?></td>
                            <td>    
                                <button type="button" onclick="menuGoodsAdd(this,'<?=$this->param[ident]?>','<?=$row['idx']?>')" class="btn btn_white btn_ssmall" <?=  in_array($row['idx'],$this->list)?"disabled":""?>>추가</button>
                            </td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->query->getCnt("web_goods",get_where())/$_REQUEST['showCnt']), get_query('page') ); ?>
                </div>
            <?php } ?>
        <div class="chead01_wrap">
            <h2>상품 목록</h2>
            <table>
                <colgroup>
                    <col class="w40">   <!-- 체크박스 -->
                    <col class="w50">  <!-- 이미지 -->
                    <col class="w100">  <!-- 상품번호/상품코드 -->
                    <col>  <!-- 상품명 / 카테고리 -->
                    <col class="w80">   <!-- 재고 -->
                    <col class="w80">   <!-- 진열 -->
                    <col class="w80">   <!-- 가격정보 > 공급가 -->
                    <col class="w80">   <!-- 가격정보 > 판매가 -->
                    <col class="w80">   <!-- 가격정보 > 판매가 -->
                    <col class="w80">   <!-- 가격정보 > 판매가 -->
                    <col class="w50">   <!-- 관리 -->
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col" class="tac">번호</th>
                        <th scope="col" class="tac">이미지</th>
                        <th scope="col" class="tac">상품번호</th>
                        <th scope="col" class="tac">상품명</th>
                        <th scope="col" class="tac">재고</th>
                        <th scope="col" class="tac">진열</th>
                        <th scope="col" class="tac">공급가</th>
                        <th scope="col" class="tac">폐쇄몰가</th>
                        <th scope="col" class="tac">반폐쇄몰가</th>
                        <th scope="col" class="tac">오픈몰가</th>
                        <th scope="col" class="tac">관리</th>
                    </tr>
                </thead>
                <tbody id="goods_inner" class="sortable">
<?php 
$i=1;
foreach( $this->list as $idx ){ 
    if($idx=="" || $idx==null) continue;
    $gs = $this->query->getRow("web_goods","idx,simg1,gname,normal_price,goods_price,isopen,stock_qty"," and idx=$idx ");
    if($gs=="" || $gs==null) continue;
?>

                <tr data-code="<?=$gs['idx']?>">
                    <td class="tac number"><?=$i;?></td>
                    <td class="tac"> <input type="hidden" name="no" value="<?=$i?>"> <img src="https://killdeal.co.kr/data/goods/<?=$gs['simg1']?>" width=30></td>
                    <td class="tac"><?=$gs['idx']?></td>
                    <td class="tac"><?=$gs['gname']?></td>
                    <td class="tac"><?=number_format($gs['stock_qty'])?></td>
                    <td class="tac"><?=conv_isopen($gs['isopen'])?></td>
                    <td class="tac"><?=number_format($gs['normal_price'])?></td>
                    <td class="tac"><?=number_format($gs['goods_price'])?></td>
                    <td class="tac"><?=number_format($gs['goods_price'])?></td>
                    <td class="tac"><?=number_format($gs['goods_price'])?></td>
                    <td class="tac"><button type="button" onclick="menuGoodsDelete(this,'<?=$this->param[ident]?>','<?=$gs['idx']?>')" class="btn btn_white btn_ssmall">삭제</button></td>
                </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
    <script>
    $( document ).ready(function() {
        $(".sortable").sortable({
        update:function(index){
            str = "";
            $('.sortable tr').each(function(index){
                $(this).children(".number").text(index+1);
                str += $(this).attr('data-code');
                str += ",";
            })
                menuGoodsUpdate(event,'<?=$this->param[ident]?>',str);
        }
        });

    });

    function menuGoodsAdd(event, type,idx){
        $.ajax({
        type: "POST",
            url: '/Ajax/menuGoodsAdd',  
            data: { "type": type, "idx": idx },  
            success: function(data){
                $(event).attr('disabled','true');
                $('#goods_inner').load(location.href+' #goods_inner > *');
                console.log(data);
            }  
        });  
    }

    function menuGoodsUpdate(event, type,gs_list){
        $.ajax({
        type: "POST",
            url: '/Ajax/menuGoodsUpdate',  
            data: { "type": type, "list": gs_list },  
            success: function(data){
                $('#goods_inner').load(location.href+' #goods_inner > *');
                //console.log(data);
            }  
        });  
    }

    function menuGoodsDelete(event, type,idx){
        $.ajax({
        type: "POST",
            url: '/Ajax/menuGoodsDelete',  
            data: { "type": type, "idx": idx },  
            success: function(data){
                $('#goods_inner').load(location.href+' #goods_inner > *');
                //console.log(data);
            }  
        });  
    }



    </script>
