<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?><span class="pg_info">게시글 목록 페이지입니다.</span></h1>
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
                    <th scope="row">게시판</th>
                    <td>
                        <select name="board" class="w200" onchange="location='<?=get_query("board")."&board="?>'+this.value;">
                            <?php foreach($this->bo_li as $key=>$value){ ?>
                            <?= get_frm_option($key, get_request("board"), $value); ?>
                            <?php } ?>
                        </select>
                    </td>
                </tr>     
                <tr>
                    <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                    <td>
                        <select name="srch" id="srch" class="w130">
                            <?= get_frm_option('title', $_REQUEST['srch'], '제목'); ?>
                        </select>
                        <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                    </td>
                </tr>

                <tr>
                    <th scope="row">기간검색</th>
                    <td>
                        <select name="term" class="w130">
                            <?= get_frm_option('regDate', $_REQUEST['term'], '등록일'); ?>
                        </select>
                        <?=get_search_date('beg','end',get_request("beg"), get_request("end"))?>
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
                        검색된 게시글: <b class="cnt"><?=number_format($this->cnt) ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <!--
                    <span class="right_wrap">
                        <a href="/Board/postListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                    -->
                </div>
                <div class="btn_wrap">
                    <a href="/Board/postForm?board=<?=$_REQUEST['board']?>&returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+ 게시글 추가</a>
                </div>
                <div class="chead01_wrap">
                    <table class="draggable">
                        <thead>
                            <tr>
                                <th scope="col" class="w40"></th>
                                <th scope="col" class="w100">게시글번호(ID)</th>
                                <th scope="col" class="w250">제목</th>
                                <th scope="col" class="w80">작성자</th>
                                <th scope="col" class="w80">비밀글</th>
                                <th scope="col" class="w80">메인노출</th>
                                <?=get_sort_tag("regDate","등록일시","w140")?>
                                <th scope="col" class="w80">조회수</th>
                                <th scope="col" class="w80">댓글수</th>
                                <th scope="col" class="w100">가맹점</th>
                                <th scope="col" class="w60">답글</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->row as $row) {?>
                        <tr class="list<?=$i%2?>">
                            <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td>
                                <a href="/Board/postModify/<?=$row['bopo_id']?>?board=<?=$_REQUEST['board']?>&returnUrl=<?=urlencode(_REQUEST_URI)?>">
                                    <?=$row['bopo_id']?>
                                </a>
                            </td>
                            <td class="tal">
                                <a href="/Board/postView/<?=$row['bopo_id']?>?board=<?=$_REQUEST['board']?>&returnUrl=<?=urlencode(_REQUEST_URI)?>">
                                    <?=$row['bopo_title']?>
                                </a>
                            </td>
                            <td><?=$this->user->getType($row['user_id'])($row['user_id'])?></td>
                            <td><?=img_yn($row['bopo_secret_yn'],"y")?></td>
                            <td><?=img_yn($row['bopo_main_display'],"1")?></td>
                            <td><?=$row['bopo_reg_dt']?></td>
                            <td><?=number_format($row['bopo_view_count'])?></td>
                            <td><?=number_format($row['bopo_comment_count'])?></td>
                            <td><?=empty($row['pt_id'])?"":pt_li($row['pt_id'],$this->pt_li[$row['pt_id']])?></td>
                            <td>
                                <?php if($this->boardRow['bo_use_reply'] == "y"){ ?>
                                <a href="/Board/postAnswer/<?=$row['bopo_id']?>?board=<?=$_REQUEST['board']?>&returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_white btn_small">답글</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php $this->postModel->depthList=array();foreach( $this->postModel->getDepthList($row['bopo_id']) as $row2) { ?>
                        <tr class="list0">
                            <td>-</td>
                            <td class="tal">
                                <a href="/Board/postView/<?=$row2['bopo_id']?>?board=<?=$_REQUEST['board']?>&returnUrl=<?=urlencode(_REQUEST_URI)?>">
                                    <span class="padl<?=$row2['bopo_depth']*10?>">[답글]</span> <?=$row2['bopo_title']?>
                                </a>
                            </td>
                            <td><?=$this->userModel->getType($row2['user_id'])($row2['user_id'])?></td>
                            <td><?=img_yn($row2['bopo_secret_yn'],"y")?></td>
                            <td><?=img_yn($row['bopo_main_display'],"1")?></td>
                            <td><?=$row2['bopo_reg_dt']?></td>
                            <td><?=number_format($row2['bopo_view_count'])?></td>
                            <td><?=number_format($row2['bopo_comment_count'])?></td>
                            <td><?=empty($row2['pt_id'])?"":pt_li($row2['pt_id'],$this->pt_li[$row2['pt_id']])?></td>
                        </tr>
                        <?php } ?>


                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>                    
            </div>
        </div>
    </form>        
    <div class="info_wrap">
        <div class="h2">도움말</div>
        <div class="h3">게시글은 어떻게 확인하나요?</h3>
        <ul>
            <li>제목을 클릭하면 게시글 확인 페이지로 이동됩니다.</li>
        </ul>
        <div class="h3">답변은 어떻게 다나요?</h3>
        <ul>
            <li>답변 버튼을 클릭하면 답변 입력 페이지로 이동됩니다.</li>
            <li>답변의 경우, 게시판에서 답변 등록이 허용된 경우에만 버튼이 활성화됩니다.</li>
        </ul>
    </div>
</section>
