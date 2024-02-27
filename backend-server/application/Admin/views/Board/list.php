<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
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
                                <?= get_frm_option('id', get_request("srch"), '게시판 번호(ID)'); ?>
                                <?= get_frm_option('name', get_request("srch"), '게시판 제목'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">그룹</th>
                        <td>
                            <select name="group" class="w130">
                                <?= get_frm_option("", get_request("group"), "전체"); ?>
                                <?php foreach($this->bogr_li as $key=>$value){ ?>
                                <?= get_frm_option($key, get_request("group"), $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                    
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', $_REQUEST['term'], '등록일시'); ?>
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
                        검색된 게시판: <b class="cnt"><?=number_format($this->cnt) ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <!-- <a href="/Board/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a> -->
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Board/form?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+ 게시판 추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="w40"></th>
                                <th scope="col" class="w200">게시판명</th>
                                <th scope="col" class="w100">그룹</th>
                                <th scope="col" class="w100">스킨</th>
                                <th scope="col" class="w100">목록</th>
                                <th scope="col" class="w100">읽기</th>
                                <th scope="col" class="w100">쓰기</th>
                                <th scope="col" class="w100">답글</th>
                                <th scope="col" class="w100">코멘트</th>
                                <?=get_sort_tag("regDate","등록일시","w140")?>
                                <th scope="col" class="w80">바로가기</th>
                                <th scope="col" class="w80">수정</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->board->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>">
                            <td><a href="/Board/modify/<?=$row['bo_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['bo_id']?></a></td>
                            <td><a href="/Board/modify/<?=$row['bo_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['bo_name']?></a></td>
                            <td><?=$this->bogr_li[$row['bogr_id']]?></td>
                            <td><?=$row['bo_skin']?></td>
                            <td><?=$GLOBALS['user_type'][$row['bo_list_perm']]?></td>
                            <td><?=$GLOBALS['user_type'][$row['bo_read_perm']]?></td>
                            <td><?=$GLOBALS['user_type'][$row['bo_write_perm']]?></td>
                            <td><?=$GLOBALS['user_type'][$row['bo_reply_perm']]?></td>
                            <td><?=$GLOBALS['user_type'][$row['bo_comment_perm']]?></td>
                            <td><?=$row['bo_reg_dt']?></td>
                            <td><a href="/Board/postList?board=<?=$row['bo_id']?>" class="btn_small btn_white">바로가기</a></td>
                            <td><a href="/Board/modify/<?=$row['bo_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">수정</a></td>
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
            <div class="h3">게시판은 어떻게 수정하나요?</div>
            <ul>
                <li>게시판번호(ID)를 클릭하면 게시판 수정 페이지로 이동됩니다. </li>
            </ul>
        </div>
    </div>
</section>
