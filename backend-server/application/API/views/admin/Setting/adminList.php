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
                            <select name="term">
                                <?= get_frm_option('reg_dt', $_REQUEST['term'], '가입일'); ?>
                            </select>
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
                        검색된 관리자 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
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
                    <a href="#" id="fexcel" class="btn_small btn_white" data-file="/Setting/adminListExcel"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a>
                    <a href="/Setting/adminListExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                    <a href="/Setting/adminForm" class="fr btn_small btn_red"><i class="ionicons ion-android-add"></i> 관리자 추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w150">   <!-- 관리자 이름 -->
                            <col class="w200">   <!-- 아이디 -->
                            <col class="w60">   <!-- 등급 -->
                            <col class="w150">   <!-- 가입일 -->
                            <col class="w150">   <!-- 최근 로그인 일시 -->
                            <col>   <!-- 관리자 설명 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">관리자 명</a></th>
                                <th scope="col"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col"><a href="<?=get_sort_url("grade",$_REQUEST['colBy'])?>">등급</a></th>
                                <th scope="col"><a href="<?=get_sort_url("reg_dt",$_REQUEST['colBy'])?>">가입일</a></th>
                                <th scope="col"><a href="<?=get_sort_url("last_login_dt",$_REQUEST['colBy'])?>">최근 로그인 일시</a></th>
                                <th scope="col"><a href="<?=get_sort_url("memo",$_REQUEST['colBy'])?>">관리자 설명</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->admin->getList($this->column) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i;?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$row['name']?></td>
                            <td><a href="#" onclick="winOpen('/Setting/popup/<?=$row['id']?>','adminForm','1200','600','yes');" ><?=$row['id']?></a></td>
                            <td><?=$row['grade']?></td>
                            <td><?=substr($row['reg_dt'],0,10)?></td>
                            <td><?=$row['last_login_dt']?></td>
                            <td><?=$row['memo']?></td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                </div>
            </div>
        </div>
    </section>
</div>
