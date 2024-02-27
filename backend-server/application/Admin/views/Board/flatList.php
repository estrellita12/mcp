<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?></h1>
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
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('title', $_REQUEST['srch'], '페이지명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', get_request("term"), '등록일'); ?>
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
        <div class="list_wrap">
            <div class="rect_wrap">
                <span class="cnt_wrap">
                    검색된 게시판: <b class="cnt"><?=number_format($this->cnt) ?></b> 개
                </span>
                <span class="rpp_wrap">
                    <select id="rpp" onchange="location='<?=get_query("rpp,page")."$rpp="?>'+this.value;" >
                        <?= get_frm_rpp( $_REQUEST['rpp'] ); ?>
                    </select>
                </span>
            </div>
            <div class="btn_wrap">
                <a href="/Board/flatForm?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+ 개별페이지 추가</a>
            </div>
            <div class="chead01_wrap" id="reload_wrap">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="w40"></th>
                            <th scope="col" class="w300">페이지명</th>
                            <?=get_sort_tag("regDate","등록일시","w180")?>
                            <?=get_sort_tag("updateDate","수정일시","w180")?>
                            <th scope="col" class="w60">관리</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach( $this->flat->getList($this->col) as $row) {?>
                    <tr class="list<?=$i%2?>">
                        <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                        <td class="tal"><a href="/Board/flatModify/<?=$row['fl_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['fl_title']?></a></td>
                        <td><?=$row['fl_reg_dt']?></td>
                        <td><?=$row['fl_update_dt']?></td>
                        <td><a href="/Board/flatModify/<?=$row['fl_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_white btn_small">수정</a></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
            <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>                    
        </div>
    </div>
</section>
