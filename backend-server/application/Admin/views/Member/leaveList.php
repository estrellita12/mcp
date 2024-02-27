<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
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
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>가맹점</th>
                        <td>
                            <select name="shop" class="w200 select2">
                                <?= get_frm_option('', get_request("shop"), '전체'); ?>
                                <?php foreach($this->pt_li as $id=>$name){ ?>
                                <?= get_frm_option($id, get_request("shop"), $name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option("leaveDate", get_request("term"), "탈퇴일"); ?>
                            </select>
                            <?=get_search_date('beg','end', get_request("beg"), get_request("end"))?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_theme btn_medium">
                    <input type="button" value="초기화" id="frest" class="btn_white btn_medium">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 회원 : <b class="cnt"><?= $this->cnt ?></b>명
                    </span>
                    <span class="rpp_wrap"> 
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                </div>
                <div class="chead02_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w50">
                            <col class="w200">
                            <col class="w150">
                            <col>
                            <col class="w170">
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">아이디</th>
                                <th scope="col">가입가맹점</th>
                                <th scope="col">탈퇴사유</th>
                                <?=get_sort_tag("leaveDate","탈퇴일시")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->leave->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td class="tac"><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td class="tac"><?=$row['mb_id']?></td>
                            <td class="tac"><?=$this->pt_li[$row['pt_id']]?></td>
                            <td><?=$row['mb_leave_reason']?></td>
                            <td class="tac"><?=$row['mb_leave_dt']?></td>
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
