<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fpartnerForm" action="/Mypage/set/<?=$this->my['pt_id']?>" method="POST">
            <div class="rhead01_wrap">
                <div class="h2">카테고리 설정</div>
                <table>
                    <colgroup>
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <td>    
                            <ul>
                                <?php foreach($this->categoryModel->getDepthList(1,'') as $d1){  
                                $flag=false;
                                foreach($this->my['shop_use_ctg'] as $k => $val){
                                if(preg_match("/^".$d1['ctg_id']."/", $val)) $flag=true;
                                }
                                ?>
                                <li class="dep1li pointer">
                                <input type="checkbox" class="dep1" name="ctg1[]" value="<?=$d1['ctg_id']?>" <?=$flag?'checked':''?>>
                                <span><?=$d1['ctg_title']?></span>
                                <ul class="dep2li dn">
                                    <?php  foreach($this->categoryModel->getDepthList(2,$d1['ctg_id']) as $d2){  ?>
                                    <li class="marl20 pointer">
                                    <input type="checkbox" class="dep2" name="ctg2[]" value="<?=$d2['ctg_id']?>" <?=in_array($d2['ctg_id'],$this->my['shop_use_ctg'])?'checked':''?>>
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
                <a href="/Mypage/removeCategory/<?=$this->my['pt_id']?>" class="btn_large btn_gray">삭제(본사 설정 반영)</a>
                <?php } ?>
                <input type="submit" value="저장" class="btn_large btn_theme">
            </div>
        </form>
        <div class="help_wrap">
            <div class="h2">도움말</div>
            <div class="h3">카테고리 설정은 무엇인가요?</h3>
            <ul>
                <li>카테고리를 체크한 뒤 저장하면, 쇼핑몰에 체크된 카테고리만 출력됩니다.</li>
            </ul>
            <div class="h3">본사 설정을 따라가고 싶다면 어떻게 하나요?</h3>
            <ul>
                <li>기본값이 본사 설정입니다.</li>
                <li>별도로 설정을 한 경우, 삭제 버튼을 클릭하시면 본사 설정을 따라가게 됩니다.</li>
            </ul>
        </div>
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

