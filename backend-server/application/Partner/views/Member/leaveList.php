<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="search_wrap">
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
                        <th>기간검색</th>
                        <td>
                            <div>
                                <select name="term" class="w130">
                                    <?= get_frm_option('od_dt', get_request("term"), '주문일'); ?>
                                    <?= get_frm_option('od_rcent_dt', get_request("term"), '최종처리일'); ?>
                                </select>
                                <?=get_date_group('beg','end',false)?>
                            </div>
                            <div class="mart5">
                                <?=get_frm_date('beg',get_request("beg"),"date")?>
                                <?=get_frm_date('end',get_request("end"),"date")?>
                            </div>

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
                <div class="btn_wrap">
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">
                            <col class="w150">
                            <col>
                            <col class="w150">
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">아이디</th>
                                <th scope="col">탈퇴사유</th>
                                <?=get_sort_tag("mb_leave_dt","탈퇴일시")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->row as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td class="tac"><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td class="tac"><?=$row['mb_id']?></td>
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
