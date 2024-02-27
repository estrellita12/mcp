<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$this->menu->getName( _SCRIPT_URL );?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->menu->getName( _SCRIPT_URL );?></h1>
        <!--
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="scCol">
                                <?= get_frm_option('id', $_REQUEST['scCol'], '아이디'); ?>
                                <?= get_frm_option('name', $_REQUEST['scCol'], '회원명'); ?>
                                <?= get_frm_option('cellphone', $_REQUEST['scCol'], '전화번호'); ?>
                                <?= get_frm_option('email', $_REQUEST['scCol'], '이메일'); ?>
                                <?= get_frm_option('addr', $_REQUEST['scCol'], '주소'); ?>
                                <?= get_frm_option('pt_id', $_REQUEST['scCol'], '가맹점명'); ?>
                            </select>
                            <input type="text" name="scV" value="<?php echo $_REQUEST['scV']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">출력 기기</th>
                        <td>
                            <select name="device">
                                <?php foreach( $GLOBALS['device'] as $dev ) { ?>
                                <?= get_frm_option($dev, $_REQUEST['device'], $dev); ?>
                                <?php } ?>
                            </select>
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
        -->
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 타임세일 : <b class="cnt"><?=number_format($this->totCnt)?></b> 개
                    </span>
                    <span>
                        <select id="showCnt" onchange="location='<?=get_query("showCnt,page")."showCnt="?>'+this.value;" >
                            <?= get_frm_option('10', $_REQUEST['showCnt'], '10줄 정렬'); ?>
                            <?= get_frm_option('30', $_REQUEST['showCnt'], '30줄 정렬'); ?>
                            <?= get_frm_option('50', $_REQUEST['showCnt'], '50줄 정렬'); ?>
                            <?= get_frm_option('100', $_REQUEST['showCnt'], '100줄 정렬'); ?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="#" id="frmExcel" class="btn_small btn_white" data-file="/Partner/partnerListExcel"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a>
                    <a href="/Partner/partnerListExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                    <a href="/Design/timesaleForm" class="fr btn_small btn_red">타임세일 추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w40">   <!-- 번호 -->
                            <col class="w40">   <!-- 출력 -->
                            <col class="w400">   <!-- 타임세일명 -->
                            <col>   <!-- 시작일 -->
                            <col>   <!-- 종료일 -->
                            <col>   <!-- 판매수량 -->
                            <col>   <!-- 매출총액 -->
                            <col>   <!-- 등록일 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                <th scope="col">번호</th>
                                <th scope="col">출력</th>
                                <th scope="col">타임세일명</th>
                                <th scope="col">시작일</th>
                                <th scope="col">종료일</th>
                                <th scope="col">판매총량</th>
                                <th scope="col">판매총액</th>
                                <th scope="col">등록일</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->rowAll as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['idx']?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$row['idx'];?></td>
                            <td><?=img_visible($row['use_yn'],'y',20)?></td>
                            <td class="marl10 tal"><?=$row['title'];?></td>
                            <td><?=check_time($row['begin_date'])==true?substr($row['begin_date'],0,16):"제한 없음"?></td>
                            <td><?=check_time($row['end_date'])==true?substr($row['end_date'],0,16):"제한 없음"?></td>
                            <?php $gsSales = $this->timesale->getGsSales($row['goods_list'],$row['begin_date'],$row['end_date']) ?>
                            <td><?=number_format($gsSales['sum_qty']);?>개</td>
                            <td><?=number_format($gsSales['sum_use_price']);?>원</td>
                            <td><?=substr($row['reg_date'],0,16)?></td>
                            <td><a href="/Design/timesaleForm/<?=$row['idx']?>?mode=u" class="btn btn_white btn_small">수정</a></td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->totCnt/$_REQUEST['showCnt']), get_query('page') ); ?>

                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(function(){
    $(".img_view").click(function(){
        var $con = $(this).closest("td").find(".dn");
        if($con.is(":visible")) {
            $con.slideUp("fast");
            $(this).text("이미지 보기");
        } else {
            $con.slideDown("fast");
            $(this).text("이미지 닫기");
        }
    });
});
</script>
