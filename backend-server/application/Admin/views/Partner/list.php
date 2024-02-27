<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
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
                            </select>
                            <?=get_search_date('beg','end',get_request("beg"), get_request("end"))?>
                        </td>
                    </tr>
                    <tr>
                        <th>가격 정책</th>
                        <td>
                            <?=get_frm_radio("grade","", get_request("grade"),"전체"); ?>
                            <?php foreach($this->gr_li as $id=>$name){ ?>
                            <?=get_frm_radio("grade",$id, get_request("grade"), $name); ?>
                            <?php } ?>
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
        <form action="/Partner/listUpdate" method="post">
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 가맹점 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( isset($_REQUEST['rpp'])?$_REQUEST['rpp']:"" ) ?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Partner/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Partner/form" class="btn_small btn_white">+ 가맹점 추가</a>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w130">   <!-- 가맹점명 -->
                            <col class="w130">   <!-- 가맹점ID -->
                            <col class="w80">   <!-- 등급 -->
                            <col class="w80">   <!-- 수수료 -->
                            <col class="w80">   <!-- 정산수수료 -->
                            <col class="w150">   <!-- 가입일 -->
                            <col class="w150">   <!-- 승인일 -->
                            <col class="w150">   <!-- URL -->
                            <col class="w100">   <!-- 회사명 -->
                            <col class="w100">   <!-- 대표자명 -->
                            <col class="w100">   <!-- 사업자 등록 번호, -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">가맹점명</th>
                                <th scope="col">아이디</th>
                                <th scope="col">등급</th>
                                <th scope="col">수수료</th>
                                <th scope="col">정산 수수료</th>
                                <?=get_sort_tag("regDate","가입일시")?>
                                <?=get_sort_tag("appDate","승인일시")?>
                                <th scope="col">가맹점 도메인</th>
                                <th scope="col">회사명</th>
                                <th scope="col">대표자명</th>
                                <th scope="col">사업자 등록 번호</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=0; 
                        foreach($this->partner->getList($this->col) as $row) { 
                        $col = " sum(if(pt_id='alldeal',ppay_commission,'0')) as commission ";
                        $search = array("ppay_cancel_yn"=>"n", "pt_id"=>$row['pt_id']);
                        $commission = $this->pay->get($col,$search);
                        ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idl[<?=$i;?>]" value="<?=$row['pt_id']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$row['pt_name']?></td>
                            <td><?=pt_id($row['pt_id'])?> <?=id_log($row['pt_id'],"web_partner")?></td>
                            <td><?=$this->gr_li[$row['pt_grade']]?></td>
                            <td><?=$row['pt_pay_rate']?>%</td>
                            <td><?=number_format($commission['commission'])?>원</td>
                            <td><?=$row['pt_reg_dt']?></td>
                            <td><?=$row['pt_app_dt']?></td>
                            <td><a href="http://<?=$row['shop_url']?>" target="_blank"> <?=$row['shop_url']?> </a></td>
                            <td><?=$row['shop_company_name']?></td>
                            <td><?=$row['shop_company_owner']?></td>
                            <td><?=$row['shop_company_saupja_no']?></td>
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
