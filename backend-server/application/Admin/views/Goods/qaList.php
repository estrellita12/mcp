<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
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
                                <?= get_frm_option('id', get_request("srch"), '문의번호'); ?>
                                <?= get_frm_option('goodsId', get_request("srch"), '상품번호(ID)'); ?>
                                <?= get_frm_option('title', get_request("srch"), '문의제목'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급사</th>
                        <td>
                            <select name="seller" class="w200 select2">
                                <?= get_frm_option('',get_request("seller"),"전체"); ?>
                                <?php foreach( $this->sl_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,get_request("seller"),$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="w200 select2">
                                <?= get_frm_option('',get_request("shop"),"전체"); ?>
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,get_request("shop"),$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>기간 검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?=get_frm_option('regDate',get_request("term"),'등록일')?>
                                <?=get_frm_option('answerDate',get_request("term"),'답변일')?>
                            </select>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"))?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">답변 여부</th>
                        <td>
                            <?=get_frm_radio("answerYn","",get_request("answerYn"),"전체")?>
                            <?=get_frm_radio("answerYn","n",get_request("answerYn"),"답변대기")?>
                            <?=get_frm_radio("answerYn","y",get_request("answerYn"),"답변완료")?>
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
                        검색된 문의 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Goods/qaListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w60">   <!-- 체크박스 -->
                            <col class="w100">   <!-- 문의 유형 -->
                            <col class="w100">   <!-- 상품 번호 -->
                            <col>  <!-- 문의 제목 -->
                            <col class="w100">  <!-- 답변 여부 -->
                            <col class="w100">  <!-- 작성자 -->
                            <col class="w120">  <!-- 공급사 -->
                            <col class="w120">   <!-- 가맹점 -->
                            <col class="w150">   <!-- 작성일 -->
                            <col class="w100">   <!-- 숨김 여부 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <?=get_sort_tag("type","문의유형")?>
                                <th scope="col">상품 번호(ID)</th>
                                <th scope="col">문의 제목</th>
                                <th scope="col">답변 여부</th>
                                <th scope="col">작성자</th>
                                <th scope="col">공급사</th>
                                <th scope="col">가맹점</th>
                                <?=get_sort_tag("regDate","작성일")?>
                                <th scope="col">숨김 여부</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->qa->getList($this->col) as $row) { ?>
                        <tr class="list<?= $i%2 ?>">
                            <td><?=$row['gs_qa_id']?></td>
                            <td><?=$GLOBALS['qa_type'][$row['gs_qa_type']]?></td>
                            <td><?=gs_id($row['gs_id'])?></td>
                            <td class="tal dot">    
                                <a href="#" onclick="winOpen('/Goods/qaDescPopup/<?=$row['gs_qa_id']?>','QaForm','900','600','yes');" >
                                    <?=empty($row['gs_qa_title'])?$row['gs_qa_content']:$row['gs_qa_title']?>
                                </a>
                            </td>
                            <td><?=img_yn($row['gs_qa_answer_yn'],'y')?></td>
                            <td><?=mb_id($row['mb_id'])?></td>
                            <td><?=sl_id($row['gs_qa_sl_id'],$this->sl_li[$row['gs_qa_sl_id']])?></td>
                            <td><?=pt_id($row['gs_qa_pt_id'],$this->pt_li[$row['gs_qa_pt_id']])?></td>
                            <td><?=$row['gs_qa_reg_dt']?></td>
                            <td><?=img_visible($row['gs_qa_hidden_yn'],'n')?></td>
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
