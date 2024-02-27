<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="search_wrap">
                <div class="h2">상세 검색</div>
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', get_request("term"), '가입일'); ?>
                                <?= get_frm_option('lastLoginDate', get_request("term"), '마지막 로그인일'); ?>
                            </select>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"))?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="freset" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 관리자 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Setting/administratorListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Setting/administratorForm" class="btn_small btn_white">+ 관리자 추가</a>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w150">  <!-- 아이디 -->
                            <col class="w130">  <!-- 관리자명 -->
                            <col class="w100">  <!-- 등급 -->
                            <col class="w150">  <!-- 이메일 -->
                            <col class="w150">  <!-- 전화번호 -->
                            <col class="w100">  <!-- 기타정보 -->
                            <col class="w100">  <!-- 로그인 횟수 -->
                            <col class="w150">  <!-- 가입일시 -->
                            <col class="w150">  <!-- 마지막 로그인 일시 -->
                            <col class="w150">  <!-- 마지막 로그인 IP -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">아이디</th>
                                <th scope="col">관리자명</th>
                                <th scope="col">등급</th>
                                <th scope="col">이메일</th>
                                <th scope="col">전화번호</th>
                                <th scope="col">기타정보</th>
                                <?=get_sort_tag("loginCnt","로그인 횟수")?>
                                <?=get_sort_tag("regDate","가입일시")?>
                                <?=get_sort_tag("lastLoginDate","마지막 로그인 일시")?>
                                <th scope="col">마지막 로그인 IP</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->administrator->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td><?=adm_id($row['adm_id'])?><?=id_log($row['adm_id'],"web_administrator")?></td>
                            <td><?=$row['adm_name']?></td>
                            <td><?=$this->gr_li[$row['adm_grade']]?></td>
                            <td><?=$row['adm_email']?></td>
                            <td><?=$row['adm_cellphone']?></td>
                            <td><?=$row['adm_info_other']?></td>
                            <td><?=number_format($row['adm_login_cnt'])?></td>
                            <td><?=$row['adm_reg_dt']?></td>
                            <td><?=$row['adm_last_login_dt']?></td>
                            <td><?=$row['adm_last_login_ip']?></td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
