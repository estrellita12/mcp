<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?> </h1>
        <form action="" method="GET">
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
                            <select name="srch">
                                <?= get_frm_option('idx', $_REQUEST['srch'], '상품번호'); ?>
                                <?= get_frm_option('gname', $_REQUEST['srch'], '상품명'); ?>
                                <?= get_frm_option('brand_nm', $_REQUEST['srch'], '브랜드'); ?>
                            </select>
                            <input type="text" name="kwd" value="<?=$_REQUEST['kwd']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" value="<?=$_REQUEST['ctg']?>">
                            <?=$this->category->printDepthList(1, $_REQUEST['ctg'], 'ctg1'); ?>
                            <?=$this->category->printDepthList(2, $_REQUEST['ctg'], 'ctg2'); ?>
                            <?=$this->category->printDepthList(3, $_REQUEST['ctg'], 'ctg3'); ?>
                            <?=$this->category->printDepthList(4, $_REQUEST['ctg'], 'ctg4'); ?>
                            <?=$this->category->printDepthList(5, $_REQUEST['ctg'], 'ctg5'); ?>
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
                            <select name="term">
                                <?=get_frm_option('reg_dt',$_REQUEST['term'],'등록일')?>
                                <?=get_frm_option('update_dt',$_REQUEST['term'],'수정일')?>
                            </select>
                            <?=get_search_date('beg','end',$_REQUEST['beg'],$_REQUEST['end'])?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">판매여부</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
                            <?=get_frm_radio("isopen",$key,$_REQUEST['isopen'],$value)?>
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
                        <span>
                            <select id="showCnt" onchange="location='<?=get_query("showCnt,page")."showCnt="?>'+this.value;" >
                                <?= get_frm_option('30', $_REQUEST['showCnt'], '30줄 정렬'); ?>
                                <?= get_frm_option('50', $_REQUEST['showCnt'], '50줄 정렬'); ?>
                                <?= get_frm_option('100', $_REQUEST['showCnt'], '100줄 정렬'); ?>
                            </select>
                        </span>
                    </div>
                    <div class="btn_wrap">
                        <a href="#" id="frmExcel" class="btn_small btn_white" data-file="/Goods/listExcel"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a>
                        <a href="/Goods/listExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                        <a href="/Goods/form" class="fr btn_small btn_red"><i class="ionicons ion-android-add"></i> 상품추가</a>
                    </div>
                    <div class="chead01_wrap" id="dataBox">
                        <table>
                            <colgroup>
                                <col class="w40">   <!-- 체크박스 -->
                                <col class="w60">  <!-- 이미지 -->
                                <col class="w100">  <!-- 상품번호/상품코드 -->
                                <col>   <!-- 상품명 / 공급사 -->
                                <col>   <!-- 상품명 / 카테고리 -->
                                <col class="w100">  <!-- 등록일시 -->
                                <col class="w60">   <!-- 재고/진열 -->
                                <col class="w70">   <!-- 가격정보 > 시중가 -->
                                <col class="w70">   <!-- 가격정보 > 공급가 -->
                                <col class="w70">   <!-- 가격정보 > 폐쇄몰가 -->
                                <col class="w70">   <!-- 가격정보 > 반폐쇄몰가 -->
                                <col class="w70">   <!-- 가격정보 > 오픈몰가 -->
                                <col class="w50">   <!-- 판매통계 > 조회수 -->
                                <col class="w60">   <!-- 판매통계 > 판매수량 -->
                                <col class="w60">   <!-- 관리 -->
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                    <th scope="col" rowspan="2">이미지</th>
                                    <th scope="col"><a href="<?=get_sort_url("idx",$_REQUEST['colBy'])?>">상품번호</a></th>
                                    <th scope="col" colspan="2"><a href="<?=get_sort_url("gname",$_REQUEST['colBy'])?>">상품명</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("reg_dt",$_REQUEST['colBy'])?>">등록일</a></th>
                                    <th scope="col">재고</th>
                                    <th scope="col" colspan="5">가격정보</th>
                                    <th scope="col" colspan="2">판매통계</th>
                                    <th scope="col" rowspan="2">관리</th>
                                </tr>
                                <tr>
                                    <th scope="col"><a href="<?=get_sort_url("gcode",$_REQUEST['colBy'])?>">상품코드</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("sl_id",$_REQUEST['colBy'])?>">공급사</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("ctg",$_REQUEST['colBy'])?>">카테고리</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("update_dt",$_REQUEST['colBy'])?>">수정일</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("isopen",$_REQUEST['colBy'])?>">진열</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("normal_price",$_REQUEST['colBy'])?>">시중가</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("supply_price",$_REQUEST['colBy'])?>">공급가</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("goods_price_9",$_REQUEST['colBy'])?>">폐쇄몰가</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("goods_price_8",$_REQUEST['colBy'])?>">반폐쇄몰가</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("goods_price_7",$_REQUEST['colBy'])?>">오픈몰가</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("readcnt",$_REQUEST['colBy'])?>">조회수</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("sum_qty",$_REQUEST['colBy'])?>">판매수량</a></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach($this->goods->getList($this->column) as $row) { ?>
                            <tr class="list<?= $i%2 ?>">
                                <td rowspan="2" class="tac">
                                    <input type="hidden" name="idx[<?=$i;?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]" value="">
                                </td>
                                <td rowspan="2" class="tac"><img src="https://killdeal.co.kr/data/goods/<?=$row['simg1']?>" width=35px></td>
                                <td class="tac"><?=$row['idx']?></td>
                                <td colspan="2" class="tal"><?=$row['gname']?></td>
                                <td class="tac"><?=substr($row['reg_dt'],0,10)?></td>
                                <td class="tac"><?=number_format($this->option->getSumQty($row['idx']))?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['normal_price'])?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['supply_price'])?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['goods_price_9'])?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['goods_price_8'])?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['goods_price_7'])?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['readcnt'])?></td>
                                <td rowspan="2" class="tac"><?=number_format($row['sum_qty'])?></td>
                                <td rowspan="2" class="tac"><a href="/Goods/form/<?=$row['idx']?>" class="btn_white btn_small">수정</a></td>
                            </tr>
                            <tr class="list<?=$i%2?>">
                                <td class="tac"><?=$row['gcode']?></td>
                                <td class="tal seller"><?=$this->sl_li[$row['sl_id']]?></td>
                                <td class="tal ctg_nav"><?=$this->category->getCtgNav($row['ca_id'])?></td>
                                <td class="tac"><?=substr($row['update_dt'],0,10)?></td>
                                <td class="tac bdr"><?=$GLOBALS['gs_isopen'][$row['isopen']]?></td>
                            </tr>
                            <?php  $i++; } ?>
                            </tbody>
                        </table>
                        <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

