<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('title', get_request("srch"), '제목'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("srch")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', get_request("term"), '등록일'); ?>
                                <?= get_frm_option('updateDate', get_request("term"), '수정일'); ?>
                            </select>
                            <?=get_search_date('beg','end',get_request("beg"), get_request("end"))?>
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
                        검색된 SMS :  <b class="cnt"><?= $this->cnt ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( isset($_REQUEST['rpp'])?$_REQUEST['rpp']:"" ); ?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Setting/smsForm" class="btn_small btn_white">+ SMS 추가</a>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w200">  <!-- SMS 제목 -->
                            <col class="w100">  <!-- 미리보기 -->
                            <col class="w150">  <!-- 등록 일시 -->
                            <col class="w150">  <!-- 수정 일시 -->
                            <col class="w100">  <!-- 발송 기록 -->
                            <col class="w50">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">SMS 제목</th>
                                <th scope="col">미리보기</th>
                                <?=get_sort_tag("tp_reg_dt","등록일시")?>
                                <?=get_sort_tag("tp_update_dt","수정일시")?>
                                <th scope="col">발송기록</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->row as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td><?=$row['tp_id']?></td>
                            <td class="tal dot">
                                <a href="/Setting/smsModify/<?=$row['tp_id']?>"><?=$row['tp_title']?></a>
                                <?=id_log($row['tp_id'],"web_template");?>
                            </td>
                            <td>
                                <a href="#" onclick="winOpen('/Setting/previewPopup/<?=$row['tp_id']?>','previewPopup','900','600','yes');">Example</a>
                            </td>
                            <td><?=$row['tp_reg_dt']?></td>
                            <td><?=$row['tp_update_dt']?></td>
                            <td>
                                <a href="#" onclick="winOpen('/Setting/sendLogPopup/<?=$row['tp_id']?>','sendLog','900','600','yes');">
                                    상세 보기
                                </a>
                            </td>
                            <td><a href="/Setting/mailModify/<?=$row['tp_id']?>" class="btn_small btn_white">수정</a></td>
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
