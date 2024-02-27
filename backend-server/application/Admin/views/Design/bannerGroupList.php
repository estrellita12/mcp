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
                                <?= get_frm_option('id', get_request("srch"), '그룹아이디'); ?>
                                <?= get_frm_option('name', get_request("srch"), '그룹명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate',get_request("term"), '등록일'); ?>
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
                        검색된 그룹 : <b class="cnt"><?=number_format($this->cnt) ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Design/bannerGroupForm?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+ 그룹 추가</a>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="w100">그룹아이디</th>
                                <th scope="col" class="w200">그룹명</th>
                                <th scope="col" class="w60">디바이스</th>
                                <th scope="col" class="w60">가로사이즈</th>
                                <th scope="col" class="w60">세로사이즈</th>
                                <?=get_sort_tag("regDate","등록일시","w140")?>
                                <?=get_sort_tag("updateDate","수정일시","w140")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->bannerGroup->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <a href="/Design/bannerGroupModify/<?=$row['bngr_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['bngr_id']?></a>
                            </td>
                            <td class="tal">
                                <a href="/Design/bannerGroupModify/<?=$row['bngr_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['bngr_name']?></a>
                            </td>
                            <td><?=$GLOBALS['device'][$row['bngr_device']]?></td>
                            <td><?=$row['bngr_w_size']?> px</td>
                            <td><?=$row['bngr_h_size']?> px</td>
                            <td><?=$row['bngr_reg_dt']?></td>
                            <td><?=$row['bngr_update_dt']?></td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>                    
            </div>
        </form>        
        <div class="help_wrap"> 
            <div class="h2">도움말</div>
            <div class="h3">배너 그룹은 어떤 뜻인가요?</div>
            <ul>
                <li>그룹으로 묶인 배너는 동일한 곳에 노출됩니다.</li>
            </ul>
            <div class="h3">그룹은 어떻게 수정하나요?</div>
            <ul>
                <li>그룹아이디를 클릭하시면 그룹 수정 페이지로 이동됩니다.</li>
            </ul>
        </div>
    </div>
</section>
