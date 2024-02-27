<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?></h1>
    <form action="" method="GET" name="frmSearch" id="frmSearch">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w120">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('id', $_REQUEST['srch'], '상품번호'); ?>
                                <?= get_frm_option('code', $_REQUEST['srch'], '상품코드'); ?>
                                <?= get_frm_option('name', $_REQUEST['srch'], '상품명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급사</th>
                        <td>
                            <select name="seller" class="w130">
                                <?= get_frm_option('',$_REQUEST['seller'],"전체"); ?>
                                <?php foreach( $this->sl_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,$_REQUEST['seller'],$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" value="<?=isset($_REQUEST['ctg'])?$_REQUEST['ctg']:""?>">
                            <?=$this->category->printDepthList(1, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg1'); ?>
                            <?=$this->category->printDepthList(2, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg2'); ?>
                            <?=$this->category->printDepthList(3, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg3'); ?>
                            <?=$this->category->printDepthList(4, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg4'); ?>
                            <?=$this->category->printDepthList(5, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg5'); ?>
                            <script>
                                $(function() {
                                    $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                                    $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                                    $("#ctg3").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                                    $("#ctg4").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                                    $("#ctg5").ctg_select_box("#ctg",5,"","=카테고리선택=");
                                });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?=get_frm_option('regDate',$_REQUEST['term'],'등록일')?>
                                <?=get_frm_option('updateDate',$_REQUEST['term'],'수정일')?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">재고</th>
                        <td>
                            <input type="text" name="bqty" value="<?=isset($_REQUEST['bqty'])?$_REQUEST['bqty']:""?>" size=10> 개 이상 ~ 
                            <input type="text" name="eqty" value="<?=isset($_REQUEST['eqty'])?$_REQUEST['eqty']:""?>" size=10> 개 이하
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">판매여부</th>
                        <td>
                            <?=get_frm_radio("isopen","",isset($_REQUEST['isopen'])?$_REQUEST['isopen']:"","전체")?>
                            <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
                            <?=get_frm_radio("isopen",$key,isset($_REQUEST['isopen'])?$_REQUEST['isopen']:"",$value)?>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="confirm_wrap">
                <input type="submit" value="검색" id="fsearch" class="btn_medium btn_black">
                <input type="reset" value="초기화" id="freset" class="btn_medium btn_gray">
            </div>
        </div>
    </form>
    <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
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
                        <a href="/Goods/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w100">   <!-- 상품 번호 -->
                            <col class="w100">  <!-- 상품 코드 -->
                            <col class="w300">  <!-- 상품명 -->
                            <col class="w100">  <!-- 공급사 -->
                            <col class="w250">  <!-- 대표 카테고리 -->
                            <col class="w60">  <!-- 진열 -->
                            <col class="w60">  <!-- 재고 -->
                            <col class="w60">  <!-- 재고 -->
                            <col class="w150">  <!-- 등록일 -->
                            <col class="w150">  <!-- 수정일 -->
                            <col class="w100">  <!-- 소비자가 -->
                            <col class="w100">  <!-- 공급가 -->
                            <col class="w100">  <!-- 판매가 -->
                            <col class="w70">  <!-- 조회수 -->
                            <col class="w70">  <!-- 판매수량 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <?=get_sort_tag("id","상품번호(ID)")?>
                                <?=get_sort_tag("code","상품코드")?>
                                <th scope="col">상품명</th>
                                <?=get_sort_tag("seller","공급사")?>
                                <th scope="col">카테고리</th>
                                <?=get_sort_tag("isopen","진열")?>
                                <?=get_sort_tag("stockQty","재고")?>
                                <?=get_sort_tag("qtyNoti","통보수량")?>
                                <?=get_sort_tag("regDate","등록일시")?>
                                <?=get_sort_tag("updateDate","수정일시")?>
                                <?=get_sort_tag("consumerPrice","소비자가")?>
                                <?=get_sort_tag("supplyPrice","공급가")?>
                                <?=get_sort_tag("goodsPrice","판매가")?>
                                <?=get_sort_tag("viewCnt","조회수")?>
                                <?=get_sort_tag("orderQty","판매수량")?>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($this->goods->getList($this->col) as $row) { ?>
                            <tr class="list<?= $i%2 ?>">
                                <td>
                                    <input type="hidden" name="idxl[<?=$i;?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]" value="">
                                </td>
                                <td><a href="/Goods/modify/<?=$row['gs_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['gs_id']?></a></td>
                                <td><?=$row['gs_code']?></td>
                                <td class="tal dot"><?=$row['gs_name']?></td>
                                <td>    
                                    <a href="#" onclick="winOpen('/Seller/popup/<?=$row['sl_id']?>','sellerForm','900','600','yes');" >
                                        <?=$this->sl_li[$row['sl_id']]?>
                                    </a>
                                </td>
                                <td class="tal ctg_nav">
                                    <?=$this->category->getNavStr(isset($row['gs_ctg'])?$row['gs_ctg']:"")?><br>
                                    <?=$this->category->getNavStr(isset($row['gs_ctg_2'])?$row['gs_ctg_2']:"")?>
                                    <?=$this->category->getNavStr(isset($row['gs_ctg_3'])?$row['gs_ctg_3']:"")?>
                                </td>
                                <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                <td><?=number_format($row['gs_stock_qty'])?></td>
                                <td><?=number_format($row['gs_stock_qty_noti'])?></td>
                                <td><?=$row['gs_reg_dt']?></td>
                                <td><?=$row['gs_update_dt']?></td>
                                <td><?=number_format($row['gs_consumer_price'])?>원</td>
                                <td><?=number_format($row['gs_supply_price'])?>원</td>
                                <td><?=number_format($row['gs_price'])?>원</td>
                                <td><?=number_format($row['gs_view_cnt'])?>회</td>
                                <td><?=number_format($row['gs_order_qty'])?>개</td>
                                <td><a href="/Goods/modify/<?=$row['gs_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_white btn_small">수정</a></td>
                            </tr>
                            <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </div>
    </form>
</section>
