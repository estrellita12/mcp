<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="search_wrap">
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
                                <?= get_frm_option('title', get_request("srch"), '기획전명'); ?>
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
                        검색된 기획전 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Design/planForm?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+기획전 추가</a>
                    <a href="#" onclick="winOpen('/Design/planOdrPopup','planSortable','900','600','yes');" class="btn_small btn_red">순서 변경</a>
                    <div class="right_wrap">
                    </div>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col" class="w40"></th>
                                <th scope="col" class="w120">노출 쇼핑몰</th>
                                <th scope="col" class="w170">카테고리</th>
                                <th scope="col" class="w40">출력</th>
                                <th scope="col" class="w350">기획전명</th>
                                <th scope="col" class="w150">기획전 링크</th>
                                <th scope="col" class="w150">시작 시간</th>
                                <th scope="col" class="w150">종료 시간</th>
                                <?=get_sort_tag("regDate","등록일시","w120")?>
                                <th scope="col" class="w60">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->planModel->get($this->col,$this->search,true,$this->sql) as $row) {?>
                        <tr>
                            <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td><?=$row['pt_id']=='admin'?"전체":$this->pt_li[$row['pt_id']]?></td>
                            <td class="tal"><?=$this->categoryModel->getNavStr($row['ctg_id'])?></td>
                            <td><?=img_visible($row['plan_show_yn'],'y',20)?></td>
                            <td class="tal dot">
                                <a href="/Design/planModify/<?=$row['plan_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>"><?=$row['plan_title'];?></a>
                                <button type="button" class="marl10 fr btn_small btn_gray img_view">이미지 닫기</button><br><br><br>
                                <?=get_img(_PLAN,$row['plan_list_img'],"200px","fr plan_img")?>
                            </td>
                            <td class="tal">
                                <a href="http://majorworld.shop/Shop/planList/<?=$row['plan_id']?>" target="_blank">/Shop/planList/<?=$row['plan_id']?></a>
                            </td>
                            <td><?=check_time($row['plan_begin_dt'])==true?substr($row['plan_begin_dt'],0,16):"제한 없음"?></td>
                            <td><?=check_time($row['plan_end_dt'])==true?substr($row['plan_end_dt'],0,16):"제한 없음"?></td>
                            <td><?=$row['plan_reg_dt']?></td>
                            <td><a href="/Design/planModify/<?=$row['plan_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn btn_white btn_small">수정</a></td>
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
<script>
$(function(){
        $(".img_view").click(function(){
                var $con = $(this).closest("td").find(".plan_img");
                if($con.is(":visible")) {
                $con.slideUp("fast");
                $(this).text("이미지 보기");
                } else {
                $con.slideDown("fast");
                $(this).text("이미지 닫기");
                }
                });
        });
</script>
