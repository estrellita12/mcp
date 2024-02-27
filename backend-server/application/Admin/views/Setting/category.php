<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
    <div class="pg_info">
        <ul>
            <li>하위 카테고리 중 1개라도 선택된 경우, 상위 카테고리도 반드시 선택되어야합니다.</li>
        </ul>
    </div>
    <form action="/Setting/setDefault" method="POST">
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
                                <?php  foreach($this->category->getDepthList(1,'') as $d1){
                                $flag=false;
                                foreach($this->row['shop_use_ctg'] as $k => $val){
                                if(preg_match("/^".$d1['ctg_id']."/", $val)) {
                                $flag=true;
                                }
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
            <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
        </div>
    </form>
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
            }
        });

        $('.dep2').click(function(){
            if( $(this).prop('checked') ){
                $(this).closest('.dep1li').children('.dep1').prop('checked',true);
            }
        });
    });
</script>
