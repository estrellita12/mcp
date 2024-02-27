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
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('id', get_request("srch"), '아이디'); ?>
                                <?= get_frm_option('name', get_request("srch"), '공급사명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', get_request("term"), '가입일'); ?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
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
                        검색된 공급사 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w200">   <!-- 공급사명 -->
                            <col class="w200">   <!-- 공급사ID -->
                            <col class="w200">   <!-- 가입일 -->
                            <col class="w200">   <!-- 가입일 -->
                            <col class="w200">   <!-- 가입일 -->
                            <col class="w150">   <!-- 회사명 -->
                            <col class="w150">   <!-- 대표자명  -->
                            <col class="w150">   <!-- 사업자 번호 -->
                            <col class="w150">   <!-- 업태 -->
                            <col class="w150">   <!-- 종목 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">공급사명</th>
                                <th scope="col">아이디</th>
                                <?=get_sort_tag("regDate","가입일시")?>
                                <?=get_sort_tag("appDate","승인일시")?>
                                <?=get_sort_tag("expDate","만료일시")?>
                                <th scope="col">회사명</th>
                                <th scope="col">대표자명</th>
                                <th scope="col">사업자번호</th>
                                <th scope="col">업태</th>
                                <th scope="col">종목</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->seller->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>">
                            <td>
                                <input type="hidden" name="idl[<?=$i;?>]" value="<?=$row['sl_id']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$row['sl_name']?></td>
                            <td><?=sl_id($row['sl_id'])?></td>
                            <td><?=$row['sl_reg_dt']?></td>
                            <td><?=$row['sl_app_dt']?></td>
                            <td><?=$row['sl_exp_dt']?></td>
                            <td><?=$row['sl_company_name']?></td>
                            <td><?=$row['sl_company_owner']?></td>
                            <td><?=$row['sl_company_saupja_no']?></td>
                            <td><?=$row['sl_company_item']?></td>
                            <td><?=$row['sl_company_service']?></td>
                            <td><a href="/Seller/remove/<?=$row['sl_id']?>" onclick="return confirm('해당 공급사를 삭제 처리 하시겠습니까?\n삭제 처리된 공급사 데이터는 복구 불가능하며, 해당 공급사가 등록한 모든 데이터가 삭제 됩니다.')"  class="btn btn_white btn_small"> 삭제 </a></td>
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
