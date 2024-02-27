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
                                <?= get_frm_option('title', get_request("srch"), '팝업명'); ?>
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
                    <tr>
                        <th scope="row">공개설정</th>
                        <td>
                            <?=get_frm_radio("showYn","",get_request("showYn"),"전체");?>
                            <?=get_frm_radio("showYn","y",get_request("showYn"),"공개");?>
                            <?=get_frm_radio("showYn","n",get_request("showYn"),"비공개");?>
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
                        검색된 팝업 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Design/popupForm?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+팝업 추가</a>
                    <a href="#" onclick="winOpen('/Design/popupOdrPopup','popupSortable','900','600','yes');" class=" btn btn_small btn_red">순서 변경</a>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w100">   <!-- 노출 쇼핑몰 -->
                            <col class="w400">   <!-- 팝업명 -->
                            <col class="w60">   <!-- 출력 -->
                            <col class="w150">   <!-- 시작일 -->
                            <col class="w150">   <!-- 종료일 -->
                            <col class="w150">   <!-- 팝업크기 -->
                            <col class="w150">   <!-- 팝업위치 -->
                            <col class="w70">   <!-- 기기 -->
                            <col class="w120">   <!-- 등록일 -->
                            <col class="w120">   <!-- 수정일 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">노출 쇼핑몰</th>
                                <th scope="col">팝업명</th>
                                <th scope="col">노출</th>
                                <th scope="col">시작일</th>
                                <th scope="col">종료일</th>
                                <th scope="col">크기(가로,세로)</th>
                                <th scope="col">위치(top,left)</th>
                                <th scope="col">기기</th>
                                <?=get_sort_tag("regDate","등록일")?>
                                <?=get_sort_tag("updateDate","수정일")?>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->popup->getList() as $row ) { ?>
                        <tr class="list<?=$i%2?>">
                            <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td><?=$row['pt_id']=='admin'?"전체":$this->pt_li[$row['pt_id']]?></td>
                            <td class="tal dot">
                                <a href="/Design/popupModify/<?=$row['pp_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['pp_title'];?></a>
                            </td>
                            <td><?=img_visible($row['pp_show_yn'],'y')?></td>
                            <td><?=check_time($row['pp_begin_dt'])==true?substr($row['pp_begin_dt'],0,16):"제한 없음"?></td>
                            <td><?=check_time($row['pp_end_dt'])==true?substr($row['pp_end_dt'],0,16):"제한 없음"?></td>
                            <td><?=$row['pp_width'];?>px , <?=$row['pp_width'];?>px</td>
                            <td><?=$row['pp_top'];?>px , <?=$row['pp_left'];?>px</td>
                            <td><?=$row['pp_device'];?></td>
                            <td><?=substr($row['pp_reg_dt'],0,16)?></td>
                            <td><?=substr($row['pp_update_dt'],0,16)?></td>
                            <td><a href="/Design/popupModify/<?=$row['pp_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn btn_white btn_small">수정</a></td>
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

