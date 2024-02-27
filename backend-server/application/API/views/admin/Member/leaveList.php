<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name'];?></h1>
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
                                <?= get_frm_option('id', $_REQUEST['srch'], '아이디'); ?>
                                <?= get_frm_option('name', $_REQUEST['srch'], '회원명'); ?>
                            </select>
                            <input type="text" name="kwd" value="<?php echo $_REQUEST['kwd']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>가맹점</th>
                        <td>
                            <select name="shp">
                                <?= get_frm_option('', $_REQUEST['shp'], '전체'); ?>
                                <?php foreach($this->pt_li as $id=>$name){ ?>
                                <?= get_frm_option($id, $_REQUEST['shp'], $name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term">
                                <?= get_frm_option("leave_dt", $_REQUEST['term'], "탈퇴일"); ?>
                            </select>
                            <?=get_search_date('beg','end',$_REQUEST['beg'],$_REQUEST['end'])?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn btn_black btn_medium">
                    <input type="button" value="초기화" id="frest" class="btn btn_gray btn_medium">
                </div>
            </div>
        </form>
        <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 회원 : <b class="cnt"><?= $this->cnt ?></b>명
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
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w50">
                            <col class="w200">
                            <col class="w150">
                            <col class="w150">
                            <col class="w200">
                            <col >
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">회원명</a></th>
                                <th scope="col"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col"><a href="<?=get_sort_url("pt_id",$_REQUEST['colBy'])?>">가입가맹점</a></th>
                                <th scope="col"><a href="<?=get_sort_url("leave_dt",$_REQUEST['colBy'])?>">탈퇴일시</a></th>
                                <th scope="col"><a href="<?=get_sort_url("memo",$_REQUEST['colBy'])?>">탈퇴사유</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->leave->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td class="tac">
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td class="tac"><?=$row['name']?></td>
                            <td class="tac"><?=$row['id']?></td>
                            <td class="tac"><?=$this->pt_li[$row['pt_id']]?></td>
                            <td class="tac"><?=$row['leave_dt']?></td>
                            <td><?=$row['memo']?></td>
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
