<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?></h1>
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
                        <th scope="row">가입일</th>
                        <td>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"), false)?>
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
                    <div class="right_wrap">
                        <a href="/Member/registerAnalysisExcel?<?=get_qstr("rpp,page")?>" class="btn_excel"> 엑셀저장</a>
                    </div>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w150">
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                            <col class="w100">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>기간</th>
                                <th>가맹점</th>
                                <th>소셜 로그인</th>
                                <th>일반 회원가입</th>
                                <?=get_sort_tag("reg_cnt","총 가입자수")?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($this->row as $row){ ?>
                        <tr>
                            <td><?=$_REQUEST['beg']?> ~ <?=$_REQUEST['end']?></td>
                            <td><?=pt_id($row['pt_id'],$this->pt_li[$row['pt_id']])?></td>
                            <td><?=number_format($row['sns_reg_cnt'])?>명</td>
                            <td><?=number_format($row['reg_cnt'] - $row['sns_reg_cnt'])?>명</td>
                            <td><b><?=number_format($row['reg_cnt'])?>명</b></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</section>
