<section class="contents">
    <h1 class="cont_title">카테고리 설정</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="fpartnerForm" action="/Partner/set/<?=$this->param['ident']?>" method="POST">
            <div class="rhead01_wrap">
                <div class="h2">카테고리 설정</div>
                <p class="info">카테고리를 별도로 설정하지 않으면 본사 설정을 따라가게 됩니다.</p>
                <p class="info">수정버튼을 클릭하면 <b>별도의 카테고리</b>가 생성되고, 삭제버튼을 클릭하면 <b>별도의 카테고리</b>가 삭제됩니다.</p>
                <table>
                    <colgroup>
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <td>    
                            <ul>
                                <?php foreach($this->category->getDepthList(1,'') as $d1){  
                                $flag=false;
                                foreach($this->row['shop_use_ctg'] as $k => $val){
                                if(preg_match("/^".$d1['ctg_id']."/", $val)) $flag=true;
                                }
                                ?>
                                <li class="dep1li pointer">
                                <input type="checkbox" class="dep1" name="ctg1[]" value="<?=$d1['ctg_id']?>" <?=$flag?'checked':''?>>
                                <span><?=$d1['ctg_title']?></span>
                                <ul class="dep2li dn">
                                    <?php  foreach($this->category->getDepthList(2,$d1['ctg_id']) as $d2){  ?>
                                    <li class="marl20 pointer">
                                    <input type="checkbox" class="dep2" name="ctg2[]" value="<?=$d2['ctg_id']?>" <?=in_array($d2['ctg_id'],$this->row['shop_use_ctg'])?'checked':''?>>
                                    <span><?=$d2['ctg_title']?></span>
                                    </li>
                                    <?php } ?>
                                </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <?php if($this->changeMode == "modify"){ ?>
                <a href="/Partner/removeCategory/<?=$this->param['ident']?>" class="btn_medium btn_gray">삭제(본사 설정 반영)</a>
                <?php } ?>
                <input type="submit" value="수정" class="btn_medium btn_theme">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
<script>
$(function() {
        $('.dep1li').click(function(){
                $('.dep2li').css('display','none');
                $(this).children('.dep2li').css('display','block');
                });

        $('.dep1').click(function(){
                if( $(this).prop('checked') ){
                $(this).nextAll('.dep2li').find('.dep2').prop('checked',true);
                }else{
                $(this).nextAll('.dep2li').find('.dep2').prop('checked',false);
                //$(this).next('.dep2li').find('.dep2').prop('checked',false);
                }
                });

        $('.dep2').click(function(){
                if( $(this).prop('checked') ){
                $(this).closest('.dep1li').children('.dep1').prop('checked',true);
                }
                });

});
</script>

