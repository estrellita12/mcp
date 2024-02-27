<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
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
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', isset($_REQUEST['term'])?$_REQUEST['term']:"", '가입일'); ?>
                                <?= get_frm_option('lastLoginDate', isset($_REQUEST['term'])?$_REQUEST['term']:"", '마지막 로그인일'); ?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
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
                <span class="rpp_wrap">
                    <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                        <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                    </select>
                </span>
                <span class="right_wrap">
                    <a href="/Administrator/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">엑셀저장</a>
                </span>
            </div>
            <div class="btn_wrap">
                <a href="/Administrator/form" class="btn_small btn_white">+ 관리자 추가</a>
            </div>
            <div class="chead01_wrap">
                <table>
                    <colgroup>
                        <col class="w40">   <!-- 체크박스 -->
                        <col class="w100">  <!-- 관리자명 -->
                        <col class="w150">  <!-- 아이디 -->
                        <col class="w100">  <!-- 등급 -->
                        <col class="w150">  <!-- 이메일 -->
                        <col class="w150">  <!-- 전화번호 -->
                        <col class="w100">  <!-- 기타정보 -->
                        <col class="w60">   <!-- 상태 -->
                        <col class="w100">  <!-- 로그인 횟수 -->
                        <col class="w150">  <!-- 가입일시 -->
                        <col class="w150">  <!-- 마지막 로그인 일시 -->
                        <col class="w150">  <!-- 마지막 로그인 IP -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">관리자명</th>
                            <th scope="col">아이디</th>
                            <th scope="col">등급</th>
                            <th scope="col">이메일</th>
                            <th scope="col">전화번호</th>
                            <th scope="col">기타정보</th>
                            <th scope="col">상태</th>
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
                            <td><?=$row['adm_name']?></td>
                            <td><a href="#" onclick="winOpen('/Administrator/infoPopup/<?=$row['adm_id']?>','adminForm','900','600','yes');" ><?=$row['adm_id']?></a></td>
                            <td><?=$this->gr_li[$row['adm_grade']]?></td>
                            <td><?=$row['adm_email']?></td>
                            <td><?=$row['adm_cellphone']?></td>
                            <td><?=$row['adm_info_other']?></td>
                            <td><?=$GLOBALS['adm_stt'][$row['adm_stt']]?></td>
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
    </div>
</section>
