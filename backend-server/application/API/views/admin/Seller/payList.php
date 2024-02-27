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
                            <input type="hidden" name="term" value="pay_time">
                            <?=get_search_date('beg','end',$_REQUEST['beg'],$_REQUEST['end'])?>
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
                    <!-- <a href="#" id="frmExcel" class="btn_small btn_white" data-file="/Seller/payListExcel"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a> -->
                    <a href="/Seller/payListExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>/excel_download.png" width=15> 검색결과 엑셀저장</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col>   <!-- 가맹점명 -->
                            <col>   <!-- 가맹점ID -->
                            <col>   <!-- 판매 상품 금액 -->
                            <col>   <!-- 사용된 포인트 금액 -->
                            <col>   <!-- 사용된 쿠폰 금액 -->
                            <col>   <!-- 수수료 금액 -->
                            <col class="w100">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">가맹점명</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col" colspan="4" class="th_bg">매출 집계</th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("commission",$_REQUEST['colBy'])?>">수수료 금액</a></th>
                                <th scope="col" rowspan="2">상세 내역</th>
                            </tr>
                            <tr>
                                <th scope="col" class="th_bg"><a href="<?=get_sort_url("goods_price",$_REQUEST['colBy'])?>">판매 상품금액</a></th>
                                <th scope="col" class="th_bg"><a href="<?=get_sort_url("goods_price",$_REQUEST['colBy'])?>">판매 상품금액의 %</a></th>
                                <th scope="col" class="th_bg"><a href="<?=get_sort_url("use_point",$_REQUEST['colBy'])?>">사용된 포인트 금액</a></th>
                                <th scope="col" class="th_bg"><a href="<?=get_sort_url("use_coupon",$_REQUEST['colBy'])?>">사용된 쿠폰 금액</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->pay->getList($this->column) as $row) {  ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i;?>]" value="<?=$row['seller_id']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$this->sl_li[$row['seller_id']]?></td>
                            <td><a href="#" onclick="win_open('/Seller/popupForm/<?=$row['seller_id']?>','partnerForm','1200','600','yes');" ><?=$row['seller_id']?></a></td>
                            <td><?=number_format($row['goods_price'])?> 원</td>
                            <td><?=number_format($row['goods_price']*(0.07))?> 원</td>
                            <td><?=number_format($row['use_point'])?> 원</td>
                            <td><?=number_format($row['use_coupon'])?> 원</td>
                            <td><?=number_format($row['commission'])?>원</td>
                            <td><a href="/Seller/payListDescExcel?scSL=<?=$row['seller_id']?>&<?=get_qstr()?>" class="btn_small btn_white">다운로드</a></td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->totCnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                </div>
            </div>
        </div>
    </section>
</div>
