<section class="cont_inner">
    <h1 class="pg_tit">배너 순서 변경 > <?= $GLOBALS['banner'][$_REQUEST['device']][$_REQUEST['position']]?></h1>
    <form name="fbannerForm" action="/Design/sortableBanner" method="POST">
        <input type="hidden" name="orderby" id="orderby">
            <div class="chead02_wrap">
                <div class="h2">배너 순서 변경</div>
                <p class="pg_info">
                    배너를 드래그하여 순서를 변경해주세요. 변경 후 변경 사항 적용 버튼을 클릭해야 반영됩니다.<br>
                    특정 가맹점 배너는 전체 가맹점 배너 보다 무조건 앞서 노출됩니다.
                </p>
                <div class="rect_wrap">
                    <button type="submit"  class="fr btn_small btn_red">변경 사항 적용</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="w50">순서</th>
                            <th scope="col" class="w100">가맹점</th>
                            <th scope="col" class="w150">카테고리</th>
                            <th scope="col" class="w50">출력</th>
                            <th scope="col" class="w200">노출 영역</th>
                            <th scope="col" class="w120">시작 일시</th>
                            <th scope="col" class="w120">종료 일시</th>
                            <th scope="col" class="w120">등록일</th>
                        </tr>
                    </thead>
                    <tbody class="sortable">
                        <?php $i=0; foreach( $this->bannerModel->get($this->col,$this->search,true,$this->sql) as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['bn_id']?>">
                            <td class="w50 orderby"><?=$i+1?></td>
                            <td class="w100"><?=$row['pt_id']=="admin"?"전체":$this->pt_li[$row['pt_id']]?></td>
                            <td class="w150 tal"><?=$this->categoryModel->getNavStr($row['ctg_id'])?></td>
                            <td class="w50"><?=img_visible($row['bn_show_yn'],'y',20)?></td>
                            <td class="w200 tal">
                                <span><?=$GLOBALS['banner'][$row['bn_device']][$row['bn_position']]?></span>
                                <button type="button" class="marl10 fr btn_small btn_gray img_view">이미지 닫기</button><br><br><br>
                                <?=get_img(_BANNER,$row['bn_img'],"100px","banner_img fr")?>
                            </td>
                            <td class="w120"><?=check_time($row['bn_begin_dt'])==true?$row['bn_begin_dt']:"제한 없음"?></td>
                            <td class="w120"><?=check_time($row['bn_end_dt'])==true?$row['bn_end_dt']:"제한 없음"?></td>
                            <td class="w120"><?=substr($row['bn_reg_dt'],0,10)?></td>
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
        var $con = $(this).closest("td").find(".banner_img");
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
    $("#orderby").val(str);
    }
    });
    });
</script>
