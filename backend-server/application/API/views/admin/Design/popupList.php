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
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 팝업 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <a href="/Design/popupForm" class="fr btn_small btn_red">팝업 추가</a>
                </div>
                <div class="btn_wrap">
                </div>
                <p class="info">※ 가맹점에서 등록한 팝업은 무조건 첫번째로 보여지게 됩니다.</p>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w50">   <!-- 순서 -->
                            <col class="w40">   <!-- 출력 -->
                            <col class="w400">   <!-- 팝업명 -->
                            <col>   <!-- 시작일 -->
                            <col>   <!-- 종료일 -->
                            <col>   <!-- 팝업크기 -->
                            <col>   <!-- 팝업위치 -->
                            <col class="w70">   <!-- 기기 -->
                            <col>   <!-- 등록일 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">순서</th>
                                <th scope="col">출력</th>
                                <th scope="col">팝업명</th>
                                <th scope="col">시작일</th>
                                <th scope="col">종료일</th>
                                <th scope="col">크기(가로,세로)</th>
                                <th scope="col">위치(top,left)</th>
                                <th scope="col">기기</th>
                                <th scope="col">등록일</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody class="<?=$_REQUEST['shw']=='y'?'sortable':''?>">
                        <?php $i=0; foreach( $this->popup->getList() as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['pt_id']=='admin'?$row['idx']:''?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td class="<?=$row['pt_id']=='admin'?'orderby':''?>"><?=$row['pt_id']=='admin'?$row['orderby']:$this->pt_li[$row['pt_id']]?></td>
                            <td><?=img_visible($row['show_yn'],'y',20)?></td>
                            <td class="marl10 tal"><?=$row['title'];?></td>
                            <td><?=check_time($row['begin_date'])==true?substr($row['begin_date'],0,16):"제한 없음"?></td>
                            <td><?=check_time($row['end_date'])==true?substr($row['end_date'],0,16):"제한 없음"?></td>
                            <td><?=$row['width'];?>px , <?=$row['width'];?>px</td>
                            <td><?=$row['top'];?>px , <?=$row['left'];?>px</td>
                            <td><?=$row['device'];?></td>
                            <td><?=substr($row['reg_date'],0,16)?></td>
                            <td><a href="/Design/popupForm/<?=$row['idx']?>?mode=u" class="btn btn_white btn_small">수정</a></td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                     <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['showCnt']), get_query('page') ); ?>

                </div>
            </div>
        </div>
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
            sortableUpdate(event, '/Design/sortablePopup',str);
        }
    });
});

</script>
