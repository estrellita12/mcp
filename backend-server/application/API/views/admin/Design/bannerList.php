<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?></h1>
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">노출 영역</th>
                        <td>
                            <select name="pos">
                                <?= get_frm_option('', $_REQUEST['pos'], '전체'); ?>
                                <?php foreach( $GLOBALS['banner'] as $position => $title ) { ?>
                                <?= get_frm_option($position, $_REQUEST['pos'], $title); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공개설정</th>
                        <td>
                            <?=get_frm_radio("shw","",$_REQUEST['shw'],"전체");?>
                            <?=get_frm_radio("shw","y",$_REQUEST['shw'],"공개");?>
                            <?=get_frm_radio("shw","n",$_REQUEST['shw'],"비공개");?>
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
                        <a href="/Design/bannerForm" class="fr btn_small btn_red">배너 추가</a>
                    </div>
                    <div class="btn_wrap">
                    </div>
                    <p class="info">※ 가맹점에서 등록한 배너는 무조건 첫번째로 보여지게 됩니다.</p>
                    <p class="info">※ 배너의 순서를 변경하고자 한다면, 노출 영역을 선택해 주세요.</p>
                    <div class="chead01_wrap">
                        <table>
                            <colgroup>
                                <col class="w40">   <!-- 체크박스 -->
                                <col class="w50">   <!-- 순서 -->
                                <col class="w180">   <!-- 카테고리 -->
                                <col class="w40">   <!-- 출력 -->
                                <col class="w300">   <!-- 노출 영역 -->
                                <col>   <!-- 링크주소 -->
                                <col>   <!-- 시작 시간 -->
                                <col>   <!-- 종료 시간 -->
                                <col class="w100">   <!-- 등록일 -->
                                <col class="w60">   <!-- 관리 -->
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                    <th scope="col">순서</th>
                                    <th scope="col">카테고리</th>
                                    <th scope="col">출력</th>
                                    <th scope="col">노출 영역</th>
                                    <th scope="col">링크 주소</th>
                                    <th scope="col">시작 일시</th>
                                    <th scope="col">종료 일시</th>
                                    <th scope="col">등록일</th>
                                    <th scope="col">관리</th>
                                </tr>
                            </thead>
                            <tbody class="<?=!empty($_REQUEST['pos']) && $_REQUEST['shw']=='y'?"sortable":""?>">
                            <?php $i=0; foreach( $this->banner->getList($this->column) as $row) {?>
                            <tr class="list<?=$i%2?>" data-idx="<?=$row['pt_id']=='admin'?$row['idx']:''?>">
                                <td>
                                    <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]">
                                </td>
                                <td class="<?=$row['pt_id']=='admin'?'orderby':''?>"><?=$row['pt_id']=='admin'?$row['orderby']:$this->pt_li[$row['pt_id']]?></td>
                                <td><?=$this->category->getCtgNav($row['ctg'])?></td>
                                <td><?=img_visible($row['show_yn'],'y',20)?></td>
                                <td class="tal">
                                    <span><?=$GLOBALS['banner'][$row['position']]?></span>
                                    <button type="button" class="marl10 fr btn_small btn_blue img_view">이미지 보기</button>
                                    <img src="<?=_BANNER?><?=$row['img_file']?>" class="dn w100p mart5">
                                </td>
                                <td class="padl10 tal"><a href="<?=$row['url_link']?>" target="_blank"><?=$row['url_link']?></a></td>
                                <td><?=check_time($row['begin_dt'])==true?$row['begin_dt']:"제한 없음"?></td>
                                <td><?=check_time($row['end_dt'])==true?$row['end_dt']:"제한 없음"?></td>
                                <td><?=substr($row['reg_dt'],0,10)?></td>
                                <td><a href="/Design/bannerForm/<?=$row['idx']?>" class="btn btn_white btn_small">수정</a></td>
                            </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                        <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
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

    $(".sortable").sortable({
        update:function(index){
            str = "";
            i = 1;
            $('.sortable tr').each(function(index){
                var idx = $(this).attr('data-idx');
                if(idx=='') return;
                str += idx+",";
                $(this).children(".orderby").text(i++);
            })
            console.log(str);
            sortableUpdate(event, '/Design/sortableBanner',str);
        }
    });
});
</script>
