<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?></h1>
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
                        <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('id', get_request("srch"), '아이디'); ?>
                                <?= get_frm_option('name', get_request("srch"), '회원명'); ?>
                                <?= get_frm_option('cellphone', get_request("srch"), '전화번호'); ?>
                                <?= get_frm_option('email', get_request("srch"), '이메일'); ?>
                                <?= get_frm_option('shop', get_request("srch"), '가맹점(ID)'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="w200 select2">
                                <?= get_frm_option("", get_request("shop"), "전체"); ?>
                                <?php foreach($this->pt_li as $key=>$value){ ?>
                                <?= get_frm_option($key, get_request("shop"), $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <div>
                                <select name="term" class="w130">
                                    <?= get_frm_option('regDate', $_REQUEST['term'], '가입일'); ?>
                                    <?= get_frm_option('lastLoginDate', $_REQUEST['term'], '마지막 로그인일'); ?>
                                </select>
                                <?=get_date_group('beg','end',false)?>
                            </div>
                            <div class="mart5">
                                <?=get_frm_date('beg',get_request("beg"),"date")?>
                                <?=get_frm_date('end',get_request("end"),"date")?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">등급</th>
                        <td>
                            <?=get_frm_radio("grade","", get_request("grade"), "전체"); ?>
                            <?php foreach($this->gr_li as $id=>$name){ ?>
                            <?=get_frm_radio("grade",$id, get_request("grade"), $name); ?>
                            <?php } ?>
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
        <form action="/Member/listUpdate" method="post">
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 회원 : <b class="cnt"><?=number_format($this->cnt) ?></b> 명
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Member/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Member/form" class="btn_small btn_white">+ 회원 추가</a>
                    <a href="#" id="sleep" class="list_update btn_small btn_line_blue" data-tab="Member">휴면 회원 처리</a>
                    <!--
                    <a href="#" id="smsPopup" class="list_update btn_small btn_blue" data-tab="Member" data-type="popup">SMS 전송</a>
                    <a href="#" id="mailPopup" class="list_update btn_small btn_blue" data-tab="Member" data-type="popup">Email 전송</a>
                    -->
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w140">  <!-- 회원명 -->
                            <col class="w140">  <!-- 아이디 -->
                            <col class="w80">  <!-- 승인 상태 -->
                            <col class="w80">  <!-- 등급 -->
                            <col class="w80">  <!-- 가입가맹점 -->
                            <col class="w140">  <!-- 전화번호 -->
                            <col class="w150">  <!-- 이메일 -->
                            <col class="w100">  <!-- 마케팅 수신 동의 -->
                            <col class="w100">  <!-- 마케팅 수신 동의 -->
                            <col class="w150">  <!-- 가입일시 -->
                            <col class="w150">  <!-- 마지막 로그인 일시 -->
                            <col class="w140">  <!-- 로그인 IP -->
                            <col class="w100">   <!-- 로그인수 -->
                            <col class="w100">   <!-- 포인트 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">회원명</th>
                                <th scope="col">아이디</th>
                                <th scope="col">승인 상태</th>
                                <th scope="col">등급</th>
                                <th scope="col">가맹점</th>
                                <th scope="col">전화번호</th>
                                <th scope="col">이메일</th>
                                <th scope="col">SMS 수신 동의</th>
                                <th scope="col">이메일 수신 동의</th>
                                <?=get_sort_tag("regDate","가입일시")?>
                                <?=get_sort_tag("lastLoginDate","마지막 로그인 일시")?>
                                <th scope="col">로그인 IP</th>
                                <?=get_sort_tag("loginCnt","로그인수")?>
                                <?=get_sort_tag("point","포인트")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->member->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idl[<?=$i?>]" value="<?=$row['mb_id']?>">
                                <input type="checkbox" name="chk[]" value="<?=$i?>">
                            </td>
                            <td><?=$row['mb_name']?></td>
                            <td><?=mb_id($row['mb_id'])?></td>
                            <td><?=$GLOBALS['mb_stt'][$row['mb_stt']]; ?></td>
                            <td><?=$this->gr_li[$row['mb_grade']]?></td>
                            <td><?=pt_id($row['pt_id'],$this->pt_li[$row['pt_id']]); ?></td>
                            <td><?=$row['mb_cellphone']?></td>
                            <td><?=$row['mb_email']?></td>
                            <td><?=img_yn($row['mb_smsser_yn'],'y')?></td>
                            <td><?=img_yn($row['mb_emailser_yn'],'y')?></td>
                            <td><?=$row['mb_reg_dt']?></td>
                            <td><?=$row['mb_last_login_dt']?></td>
                            <td><?=$row['mb_last_login_ip']?></td>
                            <td class="tar"><?=number_format($row['mb_login_cnt'])?></td>
                            <td class="tar"><?=number_format($row['mb_point'])?> p</td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
