<section class="contents">
    <h1 class="cont_title">미디어 순서 변경</h1>
    <p class="pg_info">원하는 항목을 선택하여 드래그 앤 드롭으로 순서를 변경하세요.<br>변경된 순서는 변경 사항 적용 버튼을 클릭해야 반영됩니다. </p>
    <div class="cont_wrap">
        <form name="fmediaForm" action="/Design/sortableMedia" method="POST">
            <input type="hidden" name="orderby" id="orderby">
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 배너 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <span class="right_wrap">
                        <button type="submit" class="btn_small btn_red">변경 사항 적용</button>
                    </span>
                </div>
                <div class="chead02_wrap">
                    <table>
                        <colgroup>
                            <col class="w50">   <!-- 순서 -->
                            <col class="w180">   <!-- 카테고리 -->
                            <col class="w40">   <!-- 출력 -->
                            <col class="w300">   <!-- 노출 영역 -->
                            <col>   <!-- 시작 시간 -->
                            <col>   <!-- 종료 시간 -->
                            <col class="w100">   <!-- 등록일 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">순서</th>
                                <th scope="col">카테고리</th>
                                <th scope="col">출력</th>
                                <th scope="col">노출 영역</th>
                                <th scope="col">시작 일시</th>
                                <th scope="col">종료 일시</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody class="sortable">
                        <?php $i=0; foreach( $this->media->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['media_id']?>">
                            <td class="orderby"><?=$i+1?></td>
                            <td><?=$this->category->getNavStr($row['ctg_id'])?></td>
                            <td><?=img_visible($row['media_show_yn'],'y',20)?></td>
                            <td class="tal"><?=$row['media_title']?></td>
                            <td><?=check_time($row['media_begin_dt'])==true?$row['media_begin_dt']:"제한 없음"?></td>
                            <td><?=check_time($row['media_end_dt'])==true?$row['media_end_dt']:"제한 없음"?></td>
                            <td><?=substr($row['media_reg_dt'],0,10)?></td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
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
