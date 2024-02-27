<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <div class="h2">상세검색</div>
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
                                <?= get_frm_option('name', get_request("srch"), '가맹점명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', get_request("term"), '가입일'); ?>
                                <?= get_frm_option('appDate', get_request("term"), '승인일'); ?>
                                <?= get_frm_option('expDate', get_request("term"), '만료일'); ?>
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
                        검색된 가맹점 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp(get_request("rpp")); ?>
                        </select>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col>   <!-- 가맹점명 -->
                            <col>   <!-- 가맹점ID -->
                            <col>   <!-- 가입일 -->
                            <col>   <!-- 가입일 -->
                            <col>   <!-- 가입일 -->
                            <col>   <!-- URL -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">가맹점명</th>
                                <th scope="col">아이디</th>
                                <?=get_sort_tag("regDate","가입일시")?>
                                <?=get_sort_tag("appDate","승인일시")?>
                                <?=get_sort_tag("expDate","만료일시")?>
                                <th scope="col">가맹점 도메인</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->partner->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td class="tac"><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td><?=$row['pt_name']?></td>
                            <td><?=pt_id($row['pt_id'])?>
                                <td><?=$row['pt_reg_dt']?></td>
                                <td><?=$row['pt_app_dt']?></td>
                                <td><?=$row['pt_exp_dt']?></td>
                                <td><a href="https://<?=$row['shop_url']?>" target="_blank"> <?=$row['shop_url']?> </a></td>
                                <td><a href="/Partner/remove/<?=$row['pt_id']?>" onclick="return confirm('해당 가맹점을 삭제 처리 하시겠습니까?\n삭제 처리된 가맹점 데이터는 복구 불가능하며, 해당 가맹점 회원 및 가맹점이 등록한 모든 데이터가 삭제 됩니다.')"  class="btn btn_white btn_small"> 삭제 </a></td>
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