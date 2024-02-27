<section class="contents">
    <h1 class="cont_title">팝업 순서 변경</h1>
    <div class="cont_wrap">
        <form name="fplanForm" action="/Design/sortablePopup" method="POST">
            <input type="hidden" name="orderby" id="orderby">
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 팝업 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <span class="right_wrap">
                        <button type="submit" class="btn_small btn_red">변경 사항 적용</button>
                    </span>
                </div>
                <div class="chead02_wrap">
                    <table>
                        <colgroup>
                            <col class="w50">   <!-- 순서 -->
                            <col class="w40">   <!-- 출력 -->
                            <col class="w300">   <!-- 노출 영역 -->
                            <col>   <!-- 시작 시간 -->
                            <col>   <!-- 종료 시간 -->
                            <col class="w100">   <!-- 등록일 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">순서</th>
                                <th scope="col">출력</th>
                                <th scope="col">노출 영역</th>
                                <th scope="col">시작 일시</th>
                                <th scope="col">종료 일시</th>
                                <th scope="col">등록일</th>
                            </tr>
                        </thead>
                        <tbody class="sortable">
                        <?php $i=0; foreach( $this->popup->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['pp_id']?>">
                            <td class="orderby"><?=$i+1?></td>
                            <td><?=img_visible($row['pp_show_yn'],'y',20)?></td>
                            <td class="tal"><?=$row['pp_title']?></td>
                            <td><?=check_time($row['pp_begin_dt'])==true?$row['pp_begin_dt']:"제한 없음"?></td>
                            <td><?=check_time($row['pp_end_dt'])==true?$row['pp_end_dt']:"제한 없음"?></td>
                            <td><?=substr($row['pp_reg_dt'],0,10)?></td>
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
//console.log(str);
$("#orderby").val(str);
//sortableUpdate(event, '/Design/sortableBanner',str);
}
});
        });
</script>
