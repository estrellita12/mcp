<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<i class="ionicons ion-ios-arrow-right"></i><?=$_REQUEST['Title']?></p>
    </div>
    <section class="cont_inner sec01">
        <h1 class="pg_tit"> <?=$_REQUEST['Title']?> </h1>
        <div class="tbl_frm01">
            <form action="" method="GET">
                <input type="hidden" name="title" value="<?=$_REQUEST['Title']?>">
                <table>
                    <colgroup>
                        <col class="w100">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="scCol">
                                <?= str_option_selected('id', $_REQUEST['scCol'], '아이디'); ?>
                                <?= str_option_selected('name', $_REQUEST['scCol'], '회원명'); ?>
                                <?= str_option_selected('cellphone', $_REQUEST['scCol'], '전화번호'); ?>
                                <?= str_option_selected('email', $_REQUEST['scCol'], '이메일'); ?>
                                <?= str_option_selected('addr', $_REQUEST['scCol'], '주소'); ?>
                            </select>
                            <input type="text" name="scV" value="<?php echo $_REQUEST['scV']; ?>" class="frm_input" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>가맹점</th>
                        <td>
                            <select name="scPT">
                                <?= str_option_selected('', $_REQUEST['scPT'], '전체'); ?>
                                <?php foreach($this->partner->getPartner() as $pt){ ?>
                                <?= str_option_selected($pt['id'], $_REQUEST['scPT'], $pt['name']); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="scDT">
                                <option value="reg_date">가입날짜</option>
                                <option value="last_login_date">마지막 로그인 일시</option>
                            </select>
                            <input type="date" class="frm_input" name="scDT_S" value="<?=$_REQUEST['scDT_S']?>" size="10"> ~ <input type="date" class="frm_input" name="scDT_E" value="<?=$_REQUEST['scDT_E']?>" size="10">
                        </td>
                    </tr>
                    <tr>
                        <th>등급</th>
                        <td>
                            <label><input type="radio" name="scG" id="all">전체</label>
                            <label><input type="radio" name="scG" id="all">일반회원</label>
                            <label><input type="radio" name="scG" id="all">우수회원</label>
                            <label><input type="radio" name="scG" id="all">특별회원</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn_confirm">
                    <input type="submit" value="검색" class="btn btn-medium">
                    <input type="button" value="초기화" id="frmRest" class="btn btn-medium btn-gray">
                </div>
            </form>
        </div>
    </section>
    <section class="cont_inner sec02">
        <div class="tbl_head01">
            <div class="local_frm01">
                <span class="local_ov">
                    총 회원수 : <b class="fc_red"><?= $this->member->getCnt($this->sqlSearch) ?></b>명
                </span>
                <span class="ov_a">
                    <select id="sCnt" onchange="location='<?=_SCRIPT_URI.get_query("sCnt")."sCnt="?>'+this.value;" >
                        <?= str_option_selected('30', $_REQUEST['sCnt'], '30줄 정렬'); ?>
                        <?= str_option_selected('50', $_REQUEST['sCnt'], '50줄 정렬'); ?>
                        <?= str_option_selected('100', $_REQUEST['sCnt'], '100줄 정렬'); ?>
                    </select>
                </span>
            </div>
            <div class="local_frm01">
                <a href="" class="btn btn-lsmall btn-white" title="회원 일괄메일발송">전체메일발송</a>
                <a href="" onclick="win_open(this,'pop_sms','245','360','no');return false" class="btn btn-lsmall btn-white" title="환경설정-SMS기본설정에서 설정 가능">전체문자발송</a>
                <a href="./member/member_list_excel.php?code=list" class="btn btn-lsmall btn-white"><i class="fa fa-file-excel-o"></i> 검색결과 엑셀저장</a>
                <a href="/Member/register" class="fr btn btn-lsmall btn-red"><i class="ionicons ion-android-add"></i> 회원추가</a></div>
            <table>
                <colgroup>
                    <col class="w50">
                    <col class="w150">
                    <col class="w150">
                    <col class="w150">
                    <col class="w110">
                    <col class="w110">
                    <col class="w110">
                    <col class="w130">
                    <col class="w150">
                    <col class="w40">
                    <col class="w40">
                    <col class="w40">
                    <col class="w40">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                        <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['ColBy'])?>">회원명</a></th>
                        <th scope="col"><a href="<?=get_sort_url("id",$_REQUEST['ColBy'])?>">아이디</a></th>
                        <th scope="col"><a href="<?=get_sort_url("grade",$_REQUEST['ColBy'])?>">등급</a></th>
                        <th scope="col"><a href="<?=get_sort_url("pt_id",$_REQUEST['ColBy'])?>">가입가맹점</a></th>
                        <th scope="col">핸드폰</th>
                        <th scope="col">이메일</th>
                        <th scope="col"><a href="<?=get_sort_url("reg_time",$_REQUEST['ColBy'])?>">가입일시</a></th>
                        <th scope="col"><a href="<?=get_sort_url("mb_birth",$_REQUEST['ColBy'])?>">생년월일</a></th>
                        <th scope="col">구매수</th>
                        <th scope="col"><a href="<?=get_sort_url("last_login",$_REQUEST['ColBy'])?>">로그인</a></th>
                        <th scope="col"><a href="<?=get_sort_url("name",$_REQUEST['ColBy'])?>">접근차단</a></th>
                        <th scope="col"><a href="<?=get_sort_url("point",$_REQUEST['ColBy'])?>">포인트</a></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($this->member->sqlMember($this->sqlSearch, $this->sqlOrder, $this->sqlLimit) as $row) { ?>
                <tr>
                    <td>
                        <input type="hidden" name="gs_id[]" value="<?=$row['idx']?>">
                        <input type="checkbox" name="chk[]" value="">
                    </td>
                    <td><?=$row['name']?></td>
                    <td><?=$row['id']?></td>
                    <td><?=$row['grade']?></td>
                    <td><?=$row['pt_id']?></td>
                    <td><?=$row['cellphone']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['reg_time']?></td>
                    <td><?=$row['mb_birth']?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?= str_paging("10", $_REQUEST['Page'], ceil($this->member->getCnt($this->sqlSearch)/$_REQUEST['sCnt']), _SCRIPT_URI.get_query('Page') ); ?>
    </section>
</div>
