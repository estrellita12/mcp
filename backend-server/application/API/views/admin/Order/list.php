<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?> </h1>
        <form action="" method="GET">
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
                            <select name="srch">
                                <?= get_frm_option('idx', $_REQUEST['srch'], '상품 번호'); ?>
                                <?= get_frm_option('gcode', $_REQUEST['srch'], '상품 코드'); ?>
                                <?= get_frm_option('gname', $_REQUEST['srch'], '상품명'); ?>
                            </select>
                            <input type="text" name="kwd" value="<?php echo $_REQUEST['kwd']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shp">
                            <?= get_frm_option('', $_REQUEST['shp'], '전체'); ?>
                            <?php foreach($this->pt_li as $id=>$name){ ?>
                            <?= get_frm_option($id, $_REQUEST['shp'], $name); ?>
                            <?php } ?>
                            <select>
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="scDT">
                                <option value="reg_date">등록일시</option>
                                <option value="app_date">수정일시</option>
                            </select>
                            <input type="date" name="scDT_S" value="<?=$_REQUEST['scDT_S']?>" size="10"> ~ <input type="date" name="scDT_E" value="<?=$_REQUEST['scDT_E']?>" size="10">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">결제방법</th>
                        <td>
                            <?=get_frm_radio("paymethod",'card',$_REQUEST['patmethod'],'신용카드')?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주문상태</th>
                        <td>
                            <?php foreach( $GLOBALS['od_status'] as $key=>$value ){ ?>
                            <?=get_frm_radio("dan",$key,$_REQUEST['dan'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">구매확정</th>
                        <td>
                            <?=get_frm_radio("",'',$_REQUEST['patmethod'],'전체')?>
                            <?=get_frm_radio("",'0',$_REQUEST['patmethod'],'구매 확정')?>
                            <?=get_frm_radio("",'1',$_REQUEST['patmethod'],'구매 미확정')?>
                        </td>
                    </tr>


                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_black">
                    <input type="button" value="초기화" id="freset" class="btn_medium btn_gray">
                </div>
            </div>
        </form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 주문건 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
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
                    <a href="#" id="fexcel" class="btn_small btn_white" data-file="/Order/listExcel"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a>
                    <a href="/Order/listExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w170">  <!-- 주문번호 -->
                            <col>               <!-- 주문상품명 -->
                            <col class="w50">   <!-- 수량 -->
                            <col class="w100">  <!-- 상품금액 -->
                            <col class="w80">   <!-- 배송비 -->
                            <col class="w80">   <!-- 주문상태 -->
                            <col class="w150">  <!-- 주문자 -->
                            <col class="w80">   <!-- 총주문금액 -->
                            <col class="w80">   <!-- 결제방법 -->
                            <col class="w80">   <!-- 가맹점 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">주문번호</th>
                                <th scope="col">주문상품</th>
                                <th scope="col">수량</th>
                                <th scope="col">상품금액</th>
                                <th scope="col">배송비</th>
                                <th scope="col">주문상태</th>
                                <th scope="col">주문자</th>
                                <th scope="col">총주문금액</th>
                                <th scope="col">결제방법</th>
                                <th scope="col">가맹점</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($this->order->getList() as $row){ $gs = unserialize($row['od_goods']); ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['od_no']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td>
                                <a href="#" class="od_id" onclick="winOpen('/Order/popup/<?=$row['od_no']?>','OrderForm','1200','600','yes')"><?=$row['od_id']?></a>
                                <p class="row_time"><?=$row['od_dt']?></p>
                            </td>
                            <td class="tal">
                                <a href="" title="상품 상세 페이지로 이동"><?=get_img($gs['simg1'],'25px');?></a>
                                <a href="" title="상품 수정 페이지로 이동" class="gname"><?=$gs['gname']?></a>
                            </td>
                            <td><?=$row['sum_qty']?></td>
                            <td><?=number_format($row['goods_price'])?></td>
                            <td><?=number_format($row['baesong_price'])?></td>
                            <td class="bdr"><?=$GLOBALS['od_status'][$row['dan']]?></td>
                            <td rowspan="<?=$row['rowspan']?>">
                                <a href=""><?=$row['name']?></a>
                                <p>(<?=$row['mb_id']?>)</p>
                            </td>
                            <td rowspan="<?=$row['rowspan']?>"><?=number_format($row['use_price'])?></td>
                            <td rowspan="<?=$row['rowspan']?>"><?=$row['paymethod']?></td>
                            <td rowspan="<?=$row['rowspan']?>"><?=$this->pt_li[$row['pt_id']]?></td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                </div>
            </div>
        </div>
    </section>
</div>
