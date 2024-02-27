<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name'];?></h1>
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
                            <select name="srch">
                                <?= get_frm_option('title', $_REQUEST['srch'], '제목'); ?>
                            </select>
                            <input type="text" name="kwd" value="<?php echo $_REQUEST['kwd']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term">
                                <?= get_frm_option('reg_dt', $_REQUEST['term'], '등록일'); ?>
                                <?= get_frm_option('send_dt', $_REQUEST['term'], '발송일'); ?>
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
        <form>
            <div class="layout01_wrap">
                <div class="layout_inner">
                    <div class="rect_wrap">
                        <span class="cnt_wrap">
                            총 SMS :  <b class="cnt"><?= $this->cnt ?></b> 개
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
                        <a href="/Member/smsForm" class="fr btn_small btn_red">SMS 추가</a>
                    </div>
                    <div class="chead01_wrap">
                        <table>
                            <colgroup>
                                <col class="w40">   <!-- 체크박스 -->
                                <col>               <!-- 메일 제목 -->
                                <col class="w160">  <!-- 메모 -->
                                <col>               <!-- 등록 일시 -->
                                <col>               <!-- 발송 일시 -->
                                <col class="w60">   <!-- 관리 -->
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                    <th scope="col">SMS 제목</th>
                                    <th scope="col">발송 옵션</th>
                                    <th scope="col"><a href="<?=get_sort_url("reg_dt",$_REQUEST['colBy'])?>">등록 일시</a></th>
                                    <th scope="col"><a href="<?=get_sort_url("send_dt",$_REQUEST['colBy'])?>">발송 일시</a></th>
                                    <th scope="col">관리</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach($this->sms->getList($this->col) as $row) {?>
                            <tr class="list<?=$i%2?>">
                                <td>
                                    <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]">
                                </td>
                                <td><?=$row['title']?></td>
                                <td><?=$row['opt']?></td>
                                <td><?=$row['reg_dt']?></td>
                                <td><?=$row['send_dt']?></td>
                                <td><a href="/Member/smsForm/<?=$row['idx']?>?mode=u" class="btn btn_white btn_small">수정</a></td>
                            </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                        <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
