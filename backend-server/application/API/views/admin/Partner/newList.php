<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span> <?=$preMenu['name']?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name'];?>  </h1>
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
                            <select name="term">
                                <option value="reg_dt">가입일</option>
                                <option value="app_dt">승인일</option>
                            </select>
                            <?=get_search_date('beg','end',$_REQUEST['beg'],$_REQUEST['end'])?>
                        </td>
                    </tr>
                    <tr>
                        <th>등급</th>
                        <td>
                            <?=get_frm_radio("grd","all",$_REQUEST['grd'],"전체" );?>
                            <?php foreach($this->gr_li as $idx=>$name){ ?>
                            <?=get_frm_radio("grd",$idx, $_REQUEST['grd'], $name); ?>
                            <?php } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn btn_medium btn_black">
                    <input type="reset" value="초기화" id="freset" class="btn btn_medium btn_gray">
                </div>
            </div>
        </form>
        <form>
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
                    <a href="#" id="frmExcel" class="btn_small btn_white" data-file="/Partner/newListExcel"><img src="<?=_ICON?>/excel_download.png" width=15> 선택항목 엑셀저장</a>
                    <a href="/Partner/newListExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>/excel_download.png" width=15> 검색결과 엑셀저장</a>
                    <a href="/Partner/form" class="fr btn_small btn_red"><i class="ionicons ion-android-add"></i> 가맹점추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col>  <!-- 가맹점명 -->
                            <col>  <!-- 가맹점ID -->
                            <col>  <!-- 가입일시 -->
                            <col>  <!-- 분양몰URL -->
                            <col>   <!-- 담당자 정보 > 이름 -->
                            <col>   <!-- 담당자 정보 > 전화번호 -->
                            <col>   <!-- 담당자 정보 > 이메일 -->
                            <col class="w60">   <!-- 승인 버튼 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">가맹점명</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("reg_dt",$_REQUEST['colBy'])?>">가입일시</a></th>
                                <th scope="col" rowspan="2">가맹점 도메인</th>
                                <th scope="col" colspan="3" class="th_bg">담당자 정보</th>
                                <th scope="col" rowspan="2">관리</th>
                            </tr>
                            <tr>
                                <th scope="col" class="th_bg">이름</th>
                                <th scope="col" class="th_bg">전화번호</th>
                                <th scope="col" class="th_bg">이메일</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->partner->getList("*") as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]" value="">
                            </td>
                            <td><?=$row['name']?></td>
                            <td><a href="#" onclick="win_open('/Partner/popupForm/<?=$row['id']?>','partnerForm','1200','600','yes');" ><?=$row['id']?></a></td>
                            <td><?=$row['reg_dt']?></td>
                            <td><?=$row['id']?></td>
                            <td><?=$row['manager_name']?></td>
                            <td><?=$row['manager_cellphone']?></td>
                            <td><?=$row['manager_email']?></td>
                            <td><a href="/Partner/approval/<?=$row['id']?>" class="btn btn_small btn_white">승인</a></td>
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
