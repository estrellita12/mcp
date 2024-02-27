<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
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
                                <?= get_frm_option('cellphone', $_REQUEST['srch'], '전화번호'); ?>
                                <?= get_frm_option('email', $_REQUEST['srch'], '이메일'); ?>
                                <?= get_frm_option('addr', $_REQUEST['srch'], '주소'); ?>
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
                                <?= get_frm_option('reg_dt', $_REQUEST['term'], '가입일'); ?>
                                <?= get_frm_option('last_login_dt', $_REQUEST['term'], '마지막 로그인일'); ?>
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
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_black">
                    <input type="button" value="초기화" id="frest" class="btn_medium btn_gray">
                </div>
            </div>
        </form>
        <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 회원 : <b class="cnt"><?=number_format($this->cnt) ?></b> 명
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
                    <a href="#" id="fexcel" class="btn_small btn_white" data-file="sleepList"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a>
                    <a href="/Excel/sleepList?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w50">   <!-- 체크박스 -->
                            <col>   <!-- 회원명 -->
                            <col>   <!-- 아이디 -->
                            <col>   <!-- 등급 -->
                            <col>   <!-- 가입가맹점 -->
                            <col>   <!-- 전화번호 -->
                            <col>   <!-- 이메일 -->
                            <col>   <!-- 마지막 로그인-->
                            <col class="w70">   <!-- 로그인수 -->
                            <col class="w60">   <!-- 구매수 -->
                            <col class="w60">   <!-- 포인트 --> 
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">회원명</a></th>
                                <th scope="col"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col"><a href="<?=get_sort_url("grade",$_REQUEST['colBy'])?>">등급</a></th>
                                <th scope="col"><a href="<?=get_sort_url("pt_id",$_REQUEST['colBy'])?>">가맹점</a></th>
                                <th scope="col"><a href="<?=get_sort_url("cellphone",$_REQUEST['colBy'])?>">전화번호</a></th>
                                <th scope="col">이메일</th>
                                <th scope="col"><a href="<?=get_sort_url("last_login_dt",$_REQUEST['colBy'])?>">마지막 로그인 일시</a></th>
                                <th scope="col">로그인수</th>
                                <th scope="col">구매수</th>
                                <th scope="col"><a href="<?=get_sort_url("point",$_REQUEST['colBy'])?>">포인트</a></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->sleep->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$row['name']?></td>
                            <td><?=$row['id']?></td>
                            <td><?=$this->gr_li[$row['grade']]?></td>
                            <td><?=$this->pt_li[$row['pt_id']]?></td>
                            <td><?=$row['cellphone']?></td>
                            <td><?=$row['email']?></td>
                            <td><?=$row['last_login_date']?></td>
                            <td class="tar"><?=$row['login_sum']?></td>
                            <td class="tar"></td>
                            <td class="tar"><?=$row['point']?> p</td>
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
