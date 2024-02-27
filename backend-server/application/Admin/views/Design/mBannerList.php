<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabInfo['name']?></h1>
    <form action="" method="GET">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w120">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">노출 영역</th>
                        <td>
                            <select name="position">
                                <?= get_frm_option('', $_REQUEST['position'], '전체'); ?>
                                <?php foreach( $GLOBALS['banner'] as $position => $title ) { ?>
                                <?= get_frm_option($position, $_REQUEST['position'], $title); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공개설정</th>
                        <td>
                            <?=get_frm_radio("showYn","",isset($_REQUEST['showYn'])?$_REQUEST['showYn']:"","전체");?>
                            <?=get_frm_radio("showYn","y",isset($_REQUEST['showYn'])?$_REQUEST['showYn']:"","공개");?>
                            <?=get_frm_radio("showYn","n",isset($_REQUEST['showYn'])?$_REQUEST['showYn']:"","비공개");?>
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
                    <a href="#" onclick="winOpen('/Design/bannerOdrPopup?device=<?=$_REQUEST['device']?>&position=<?=isset($_REQUEST['position'])?$_REQUEST['position']:""?>','bannerSortable','900','600','yes');" class="btn_small btn_red">순서 변경</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w100">   <!-- 노출쇼핑몰 -->
                            <col class="w150">   <!-- 카테고리 -->
                            <col class="w40">   <!-- 공개 -->
                            <col class="w300">   <!-- 노출 영역 -->
                            <col class="w300">   <!-- 링크주소 -->
                            <col class="w200">   <!-- 시작 시간 -->
                            <col class="w200">   <!-- 종료 시간 -->
                            <col class="w100">   <!-- 등록일 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">번호</th>
                                <th scope="col">노출 쇼핑몰</th>
                                <th scope="col">카테고리</th>
                                <th scope="col">공개</th>
                                <th scope="col">노출 영역</th>
                                <th scope="col">링크 주소</th>
                                <th scope="col">시작 일시</th>
                                <th scope="col">종료 일시</th>
                                <?=get_sort_tag("regDate","등록일")?>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach( $this->banner->getList($this->col) as $row) { ?>
                            <tr class="list<?=$i%2?>" >
                                <td><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                                <td><?=$row['pt_id']=="admin"?"전체":$this->pt_li[$row['pt_id']]?></td>
                                <td><?=$this->category->getNavStr($row['ctg_id'])?></td>
                                <td><?=img_visible($row['bn_show_yn'],'y',20)?></td>
                                <td class="tal">
                                    <span><?=$GLOBALS['banner'][$row['bn_position']]?></span>
                                    <button type="button" class="marl10 fr btn_small btn_gray img_view">이미지 보기</button><br><br>
                                    <img src="<?=_BANNER?><?=$row['bn_m_img']?>" class="dn w100p">
                                </td>
                                <td class="padl10 tal"><a href="<?=$row['bn_url']?>" target="_blank"><?=$row['bn_url']?></a></td>
                                <td><?=check_time($row['bn_begin_dt'])==true?$row['bn_begin_dt']:"제한 없음"?></td>
                                <td><?=check_time($row['bn_end_dt'])==true?$row['bn_end_dt']:"제한 없음"?></td>
                                <td><?=substr($row['bn_reg_dt'],0,10)?></td>
                                <td><a href="/Design/bannerModify/<?=$row['bn_id']?>?returnUrl=<?=urlencode(_REQUEST_URI)?>" class="btn btn_white btn_small">수정</a></td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </div>
    </form>
</section>
<script>
    $(function(){
        $(".img_view").click(function(){
            var $con = $(this).closest("td").find(".dn");
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
