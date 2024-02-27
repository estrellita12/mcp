<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name']?></h1>
        <form name="fForm" action="/Design/planFormUpdate/<?=get_data($this->param['ident'],"/")?>" method="POST" onsubmit="return frm_submit(document.frm);">
            <input type="hidden" name="idx" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <h2>배너 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" value="<?=$this->row['ctg']?>">
                            <?=$this->category->printDepthList(1, $this->row['ctg'], 'ctg1'); ?>
                            <?=$this->category->printDepthList(2, $this->row['ctg'], 'ctg1'); ?>
                            <script>
                            $(function() {
                                $("#ctg1").ctg_select_box("#ctg",5,"/Ajax/getNextCtg","=카테고리선택=");
                                $("#ctg2").ctg_select_box("#ctg",5,"/Ajax/getNextCtg","=카테고리선택=");
                            });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기획전명</th>
                        <td>
                            <input type="text" name="title" value="<?=isset($this->row['title'])?$this->row['title']:""?>" size="40">
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">출력 여부</th>
                        <td>
                            <input type="checkbox" name="show_yn" value="y" id="show_yn" <?=get_checked($this->row['show_yn'], "y");?> ><label for="show_yn"> 노출함</label>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">링크 주소</th>
                        <td><input type="text" value="http://majorworld.shop/Shop/planList/<?=$this->row['idx']?>" class="readonly" readonly size=50>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('begin_date', $this->row['begin_date']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('end_date', $this->row['end_date']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?php echo editor_html('memo', get_text($this->row['memo'],0)); ?></td>
                    </tr>   
                    <tr>
                        <th scope="row">관련 상품 코드</th>
                        <td><textarea name="goods_list"><?=isset($this->row['goods_list'])?$this->row['goods_list']:""?></textarea></td>
                    </tr>   
                    <tr>
                        <th scope="row">목록 이미지</th>
                        <td>
                            <input type="hidden" name="ori_limg_file" id="limg_file" value="<?=$this->row['limg_file']?>">
                            <input type="file" name="limg_file">
                            <input type="checkbox" name="limg_file_del" value="<?=$this->row['limg_file']?>" id="limg_file_del"> <label for="limg_file_del">삭제</label>
                            <div class="mart5">
                                <?=get_img(_PLAN.$this->row['limg_file'],"300px")?>
                            </div>
                        </td>
                    </tr>  
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
                </div>
            </form>
        </div>
    </section>
</div>
<script>
function frm_submit(){
    <?php echo get_editor_js('baesong_cont'); ?>
    return true;
}
</script>
