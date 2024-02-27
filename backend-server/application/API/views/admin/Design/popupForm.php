<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name'];?></h1>
        <form name="fForm" action="/Design/popupFormUpdate" method="POST" onsubmit="return frm_submit(document.frm);">
            <input type="hidden" name="mode" value="<?=$_GET['mode']?>">
            <input type="hidden" name="idx" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <h2>팝업 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">팝업명</th>
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
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('begin_date', $this->row['begin_date']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('end_date', $this->row['end_date']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">팝업 크기</th>
                        <td>
                            <input type="text" name="width"  value="<?=isset($this->row['width'])?$this->row['width']:""?>" size=5>
                            X <input type="text" name="height"  value="<?=isset($this->row['height'])?$this->row['height']:""?>" size=5>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">팝업 위치</th>
                        <td>
                            <input type="text" name="top"  value="<?=isset($this->row['top'])?$this->row['top']:""?>" size=5>
                            X <input type="text" name="left"  value="<?=isset($this->row['left'])?$this->row['left']:""?>" size=5>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?php echo editor_html('memo', get_text($this->row['memo'],0)); ?></td>
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
    <?php echo get_editor_js('memo'); ?>
    return true;
}
</script>
