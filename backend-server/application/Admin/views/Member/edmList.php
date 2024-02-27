<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabPageInfo['name']?></h1>
    <form action="" method="GET">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w120">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('title', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '제목'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="w130">
                                <?= get_frm_option('', isset($_REQUEST['shop'])?$_REQUEST['shop']:"", '전체'); ?>
                                <?php foreach($this->pt_li as $key=>$value){ ?>
                                <?= get_frm_option($key, isset($_REQUEST['shop'])?$_REQUEST['shop']:"", $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', isset($_REQUEST['term'])?$_REQUEST['term']:"", '등록일'); ?>
                                <?= get_frm_option('sendDate', isset($_REQUEST['term'])?$_REQUEST['term']:"", '발송일'); ?>
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
    <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 EDM :  <b class="cnt"><?= $this->cnt ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] ); ?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Marketing/edmForm" class="btn_small btn_white">+ EDM 추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w200">  <!-- EDM 제목 -->
                            <col class="w100">  <!-- 미리보기 -->
                            <col class="w100">  <!-- 가맹점 -->
                            <col class="w150">  <!-- 등록 일시 -->
                            <col class="w150">  <!-- 발송 일시 -->
                            <col class="w60">   <!-- 승인 여부 -->
                            <col class="w50">   <!-- 발송 여부 -->
                            <col class="w100">   <!-- 발송 메세지 -->
                            <col class="w50">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">EDM 제목</th>
                                <th scope="col">미리보기</th>
                                <th scope="col">가맹점</th>
                                <?=get_sort_tag("regDate","등록일시")?>
                                <?=get_sort_tag("sendDate","발송예정일시")?>
                                <th scope="col">승인 여부</th>
                                <th scope="col">발송 여부</th>
                                <th scope="col">발송 메세지</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach( $this->edm->getList($this->col) as $row) { ?>
                            <tr class="list<?=$i%2?>">
                                <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                                <td class="tal dot">
                                    <a href="/Marketing/edmModify/<?=$row['edm_id']?>"><?=$row['edm_title']?></a>
                                </td>
                                <td><a href="#" onclick="winOpen('/Marketing/edmPreviewPopup/<?=$row['edm_id']?>','edmPopup','900','600','yes');"> Example</a></td>
                                <td><?=pt_id($row['pt_id'],$this->pt_li[$row['pt_id']]); ?></td>
                                <td><?=$row['edm_reg_dt']?></td>
                                <td><?=$row['edm_send_dt']?></td>
                                <td><?=$GLOBALS['edm_stt'][$row['edm_stt']]?></td>
                                <td><?=img_success($row['edm_send_yn'],"y")?></td>
                                <td>
                                    <a href="#" onclick="winOpen('/Marketing/edmLog/<?=$row['edm_id']?>','edmer','900','600','yes');">
                                        <?=$row['edm_send_res']?>
                                    </a>
                                </td>
                                <td><a href="/Marketing/edmModify/<?=$row['edm_id']?>" class="btn_small btn_white">수정</a></td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </div>
    </form>
</section>
