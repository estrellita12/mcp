<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>최근 검색일시</th>
                        <td>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"), false)?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        총 검색어수 :<b class="cnt"><?= number_format($this->cnt) ?></b>개
                    </span>
                    <span class="right_wrap">
                    </span>
                </div>
                <div class="chead02_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w200">
                            <col>
                            <col class="w150">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>검색어</th>
                                <th>검색횟수</th>
                                <th>최근 검색일시</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($this->row as $row){ ?>
                        <tr>
                            <td class="tal dot"><span><?=$row['keyword_title']?></span><a href="/Goods/removeKeyword/<?=$row['keyword_id']?>" class="marl10 vat fc_gray fw_500" onclick="return confirm('해당 검색어를 삭제 하시겠습니까? 삭제 처리된 검색어는 복구가 불가능합니다.')" >x</a></td>
                            <td><div style="width:<?=($row['keyword_cnt']/$this->max)*100?>%" class="bg_theme fc_white padt3 padb3 dot"><?=$row['keyword_cnt']?></div></td>
                            <td><?=$row['keyword_update_dt']?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
    </div>
</section>
