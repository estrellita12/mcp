<section class="cont_inner">
    <h1 class="pg_tit">기획전 순서 변경</h1>
    <form name="fplanForm" action="/Design/sortablePlan" method="POST">
        <input type="hidden" name="orderby" id="orderby">
        <div class="layout_inner">
            <div class="chead02_wrap">
                <div class="h2">순서 변경</div>
                <p class="pg_info">원하는 항목을 선택하여 드래그 앤 드롭으로 순서를 변경하세요.변경된 순서는 변경 사항 적용 버튼을 클릭해야 반영됩니다. </p>
                <div class="rect_wrap">
                    <span class="right_wrap">
                        <button type="submit" class="btn_small btn_red">변경 사항 적용</button>
                    </span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="w50">순서</th>
                            <th scope="col" class="w120">가맹점</th>
                            <th scope="col" class="w160">카테고리</th>
                            <th scope="col" class="w40">출력</th>
                            <th scope="col" class="w200">노출 영역</th>
                            <th scope="col" class="w100">시작 일시</th>
                            <th scope="col" class="w100">종료 일시</th>
                        </tr>
                    </thead>
                    <tbody class="sortable">
                        <?php $i=0; foreach( $this->planModel->get($this->col,$this->search,true,$this->sql) as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['plan_id']?>">
                            <td class="orderby"><?=$i+1?></td>
                            <td><?=$row['pt_id']=='admin'?"전체":$this->pt_li[$row['pt_id']]?></td>
                            <td class="tal"><?=$this->categoryModel->getNavStr($row['ctg_id'])?></td>
                            <td><?=img_visible($row['plan_show_yn'],'y',20)?></td>
                            <td class="tal dot">
                                <?=$row['plan_title'];?>
                                <button type="button" class="marl10 fr btn_small btn_gray img_view">이미지 닫기</button><br><br><br>
                                <?=get_img(_PLAN,$row['plan_list_img'],"100px","fr plan_img")?>
                            </td>
                            <td><?=check_time($row['plan_begin_dt'])==true?$row['plan_begin_dt']:"제한 없음"?></td>
                            <td><?=check_time($row['plan_end_dt'])==true?$row['plan_end_dt']:"제한 없음"?></td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
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
    $("#orderby").val(str);
    //sortableUpdate(event, '/Design/sortableBanner',str);
    }
    });
    });
</script>
