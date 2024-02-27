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
                        <th>기간검색</th>
                        <td>
                            <input type="hidden" name="scDT" value="od_time">
                            <?=get_search_date('scDT_S','scDT_E',$_REQUEST['scDT_S'],$_REQUEST['scDT_E'])?>
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
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 가맹점 :<b class="cnt"><?= $this->cnt ?></b>개
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
                    <!-- <a href="#" id="frmExcel" class="btn_small btn_white" data-file="/Partner/excelDownload"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a> -->
                    <a href="/Partner/turnoverExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col>  <!-- 가맹점명 -->
                            <col>  <!-- 가맹점ID -->
                            <col>  <!-- 기간 -->
                            <col>   <!-- 주문건 -->
                            <col>   <!-- 주문수량 -->
                            <col>   <!-- 순매출 -->
                            <col>   <!-- 실결제액 -->
                            <col class="w100">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">가맹점명</a></th>
                                <th scope="col"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col">기간</th>
                                <th scope="col"><a href="<?=get_sort_url("od_cnt",$_REQUEST['colBy'])?>">주문건</th>
                                <th scope="col"><a href="<?=get_sort_url("sum_qty",$_REQUEST['colBy'])?>">주문수량</th>
                                <th scope="col"><a href="<?=get_sort_url("goods_price",$_REQUEST['colBy'])?>">순매출</th>
                                <th scope="col"><a href="<?=get_sort_url("use_price",$_REQUEST['colBy'])?>">실결제액</th>
                                <th scope="col">다운로드</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->order->getList($this->column) as $row ) { ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i;?>]" value="<?=$row['pt_id']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$this->pt_li[$row['pt_id']]?></td>
                            <td><a href="#" onclick="winOpen('/Partner/popupForm/<?=$row['pt_id']?>','partnerForm','1200','600','yes');" ><?=$row['pt_id']?></a></td>
                            <td><?= empty($_REQUEST['scDT_S']) && empty($_REQUEST['scDT_E']) ?"전체":$_REQUEST['scDT_S']." ~ ".$_REQUEST['scDT_E'] ?></td>
                            <td><?=number_format($row['od_cnt'])?> 건</td>
                            <td><?=number_format($row['sum_qty'])?> 개</td>
                            <td><?=number_format($row['goods_price'])?> 원</td>
                            <td><?=number_format($row['use_price'])?> 원</td>
                            <td><a href="/Partner/turnoverDescExcel?scPT=<?=$row['pt_id']?>&<?=get_qstr()?>" class="btn_small btn_white">다운로드</a></td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                </div>
                <div class="info tar">
                    <p>※순매출 : 포인트,쿠폰 사용 금액도 포함하고 있으며, 배송비는 제외되어있습니다. </p>
                    <p>※실결제액 : 고객이 PG를 이용하여 실제 결제된 금액입니다.</p>
                </div>
            </div>
        </div>
    </section>
</div>
