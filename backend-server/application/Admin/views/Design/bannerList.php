<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch">
            <div class="search_wrap">
                <div class="h2">상세 검색</div>
                <table>
                    <colgroup>
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">디바이스설정</th>
                        <td>
                            <select name="device" class="w200" onchange="location='<?=get_query("position,device,showYn")."&device="?>'+this.value;">
                                <?= get_frm_option("1",get_request("device"), "PC 배너"); ?>
                                <?= get_frm_option("2",get_request("device"), "모바일 배너"); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" value="<?=get_request("ctg")?>">
                            <?=$this->category->printDepthList(1, get_request("ctg"), 'ctg1'); ?>
                            <?=$this->category->printDepthList(2, get_request("ctg"), 'ctg2'); ?>
                            <script>
$(function() {
        $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="select2 w200" id="shop">
                                <?= get_frm_option("", get_request("shop"), "전체"); ?>
                                <?php foreach($this->pt_li as $key=>$value){ ?>
                                <?= get_frm_option($key, get_request("shop"), $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">배너 그룹</th>
                        <td>
                            <select name="position" class="select2 w300" >
                                <?= get_frm_option('', get_request("position"), '전체'); ?>
                                <?php foreach( $this->gr_li as $position => $title ) { ?>
                                <?= get_frm_option($position, get_request("position"), $title); ?>
                                <?php } ?>
                            </select>
                            <p class="info">노출 영역을 선택하시면 순서 변경을 위한 버튼이 출력됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">노출 설정</th>
                        <td>
                            <?=get_frm_radio("showYn","",get_request("showYn"),"전체");?>
                            <?=get_frm_radio("showYn","y",get_request("showYn"),"노출");?>
                            <?=get_frm_radio("showYn","n",get_request("showYn"),"비노출");?>
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
                        검색된 배너 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="/Design/bannerForm?device=<?=$_REQUEST['device']?>&returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn_small btn_white">+ 배너 추가</a>
                    <?php if( !empty($_REQUEST['position']) ){ ?>
                    <a href="#" onclick="winOpen('/Design/bannerOdrPopup?device=<?=$_REQUEST['device']?>&position=<?=get_request("position")?>','bannerSortable','1200','800','yes');" class="btn_small btn_red">순서 변경</a>
                    <?php } ?>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table class="draggable">
                        <thead>
                            <tr>
                                <th scope="col" class="w40"></th>
                                <th scope="col" class="w100">노출 가맹점 </th>
                                <th scope="col" class="w200">카테고리</th>
                                <th scope="col" class="w300">노출 영역</th>
                                <th scope="col" class="w150">링크 주소</th>
                                <th scope="col" class="w60">노출</th>
                                <th scope="col" class="w120">시작 일시</th>
                                <th scope="col" class="w120">종료 일시</th>
                                <?=get_sort_tag("regDate","등록일시","w120")?>
                                <th scope="col" class="w60">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->banner->getList($this->col) as $row) { ?>
                        <tr class="list<?=$i%2?>" >
                            <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td><?=$row['pt_id']=="admin"?"전체":$this->pt_li[$row['pt_id']]?></td>
                            <td class="tal"><?=$this->category->getNavStr($row['ctg_id'])?></td>
                            <td class="tal">
                                <span><?=$this->gr_li[$row['bn_position']]?></span>
                                <button type="button" class="marl10 fr btn_small btn_gray img_view">이미지 닫기</button><br><br>
                                <?=get_img(_BANNER,$row['bn_img'],"200px","fr banner_img")?>
                            </td>
                            <td class="padl10 tal"><a href="<?=$row['bn_url']?>" target="_blank"><?=$row['bn_url']?></a></td>
                            <td><?=img_visible($row['bn_show_yn'],'y')?></td>
                            <td><?=check_time($row['bn_begin_dt'])==true?$row['bn_begin_dt']:"제한 없음"?></td>
                            <td><?=check_time($row['bn_end_dt'])==true?$row['bn_end_dt']:"제한 없음"?></td>
                            <td><?=$row['bn_reg_dt']?></td>
                            <td><a href="/Design/bannerModify/<?=$row['bn_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn btn_white btn_small">수정</a></td>
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
                var $con = $(this).closest("td").find(".banner_img");
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
