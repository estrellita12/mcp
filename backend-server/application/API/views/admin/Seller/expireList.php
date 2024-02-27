<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span> <?=$preMenu['name']?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit">  <?=$preMenu['name'];?>  </h1>
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <!--
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
                    -->
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term">
                                <?= get_frm_option('reg_dt', $_REQUEST['term'], '가입일'); ?>
                                <?= get_frm_option('app_dt', $_REQUEST['term'], '승인일'); ?>
                                <?= get_frm_option('exp_dt', $_REQUEST['term'], '만료일'); ?>
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
                    <input type="reset" value="초기화" id="freset" class="btn_medium btn_gray">
                </div>
            </div>
        </form>
        <form>
            <div class="layout01_wrap">
                <div class="layout_inner">
                    <div class="rect_wrap">
                        <span class="cnt_wrap">
                            검색된 공급사 :<b class="cnt"><?= $this->cnt ?></b>개
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
                                <col class="w40">   <!-- 체크박스 -->
                                <col>  <!-- 가맹점명 -->
                                <col>  <!-- 가맹점ID -->
                                <col>  <!-- 가입일시 -->
                                <col>  <!-- 승인일시 -->
                                <col>  <!-- 만료일시 -->
                                <col>  <!-- 분양몰URL -->
                                <col class="w100">   <!-- 담당자 정보 > 이름 -->
                                <col class="w150">   <!-- 담당자 정보 > 전화번호 -->
                                <col class="w150">   <!-- 담당자 정보 > 이메일 -->
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                    <th scope="col" rowspan="2"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">가맹점명</a></th>
                                    <th scope="col" rowspan="2"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                    <th scope="col" rowspan="2"><a href="<?=get_sort_url("reg_dt",$_REQUEST['colBy'])?>">가입일시</a></th>
                                    <th scope="col" rowspan="2"><a href="<?=get_sort_url("app_dt",$_REQUEST['colBy'])?>">승인일시</a></th>
                                    <th scope="col" rowspan="2"><a href="<?=get_sort_url("exp_dt",$_REQUEST['colBy'])?>">만료일시</a></th>
                                    <th scope="col" rowspan="2">가맹점 도메인</th>
                                    <th scope="col" colspan="3" class="th_bg">담당자 정보</th>
                                </tr>
                                <tr>
                                    <th scope="col" class="th_bg">이름</th>
                                    <th scope="col" class="th_bg">전화번호</th>
                                    <th scope="col" class="th_bg">이메일</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach($this->seller->getList($this->col) as $row) { ?>
                            <tr class="list<?=$i%2?>">
                                <td>
                                    <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]" value="">
                                </td>
                                <td><?=$row['name']?></td>
                                <td><?=$row['id']?></td>
                                <td><?=$row['reg_dt']?></td>
                                <td><?=$row['app_dt']?></td>
                                <td><?=$row['exp_dt']?></td>
                                <td><?=$row['shop_url']?></td>
                                <td><?=$row['manager_name']?></td>
                                <td><?=$row['manager_cellphone']?></td>
                                <td><?=$row['manager_email']?></td>
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
