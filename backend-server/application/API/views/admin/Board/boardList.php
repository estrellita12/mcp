<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$this->menu->getName( _SCRIPT_URL );?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->menu->getName( _SCRIPT_URL );?> </h1>
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
                            <select name="scCol">
                                <?= get_frm_option('id', $_REQUEST['scCol'], '게시판 제목'); ?>
                                <?= get_frm_option('name', $_REQUEST['scCol'], '그룹이름'); ?>
                            </select>
                            <input type="text" name="scV" value="<?php echo $_REQUEST['scV']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="scDT">
                                <?= get_frm_option('reg_date', $_REQUEST['scDT'], '등록일'); ?>
                            </select>
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
                        검색된 게시판 :<b class="cnt"><?= number_format($this->totCnt) ?></b>개
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
                    <a href="/Board/boardForm" class="fr btn_small btn_red"><i class="ionicons ion-android-add"></i> 게시판추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col>   <!-- 그룹아이디 -->
                            <col>   <!-- 그룹이름 -->
                            <col>   <!-- 스킨 -->
                            <col>   <!-- 목록 -->
                            <col>   <!-- 읽기 -->
                            <col>   <!-- 쓰기 -->
                            <col>   <!-- 답글 -->
                            <col>   <!-- 코멘트 -->
                            <col>   <!-- 등록일 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                <th scope="col">테이블</th>
                                <th scope="col"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">게시판 제목</a></th>
                                <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">그룹이름</a></th>
                                <th scope="col">스킨</th>
                                <th scope="col">목록</th>
                                <th scope="col">읽기</th>
                                <th scope="col">쓰기</th>
                                <th scope="col">답글</th>
                                <th scope="col">코멘트</th>
                                <th scope="col"><a href="<?=get_sort_url("reg_date",$_REQUEST['colBy'])?>">등록일</a></th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->rowAll as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i;?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td>web_board_<?=$row['idx']?></td>
                            <td><?=$row['name']?></td>
                            <td><?=$row['gr_id']?></td>
                            <td><?=$row['skin']?></td>
                            <td><?=$row['list_priv']?></td>
                            <td><?=$row['read_priv']?></td>
                            <td><?=$row['write_priv']?></td>
                            <td><?=$row['reply_priv']?></td>
                            <td><?=$row['tail_priv']?></td>
                            <td><?=substr($row['reg_date'],0,10)?></td>
                            <td><a href="/Board/boardForm/<?=$row['idx']?>?mode=u" class="btn_white btn_small">수정</a></td>
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
