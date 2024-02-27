<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name']?></h1>
        <form name="fForm" action="/Design/bannerFormUpdate<?=get_data($this->param['ident'],'/')?>" method="POST" onsubmit="return frm_submit(document.frm);">
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
                            <?=$this->category->printDepthList(1, $this->row['ctg'],'ctg1'); ?>
                            <?=$this->category->printDepthList(2, $this->row['ctg'],'ctg2'); ?>
                            <script>
                            $(function() {
                                $("#ctg1").ctg_select_box("#ctg",5,"/Design/getNextCtg","=카테고리선택=");
                                $("#ctg2").ctg_select_box("#ctg",5,"/Design/getNextCtg","=카테고리선택=");
                            });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">노출 영역</th>
                        <td>
                            <select name="pos">
                                <?php foreach( $GLOBALS['banner'] as $position => $title ) { ?>
                                <?= get_frm_option($position, $this->row['position'], $title); ?>
                                <?php } ?>
                            </select>
                            <p class="info">
                                [고정] 같은 위치에 고정되어 노출되며 2개이상 등록시 랜덤으로 노출됩니다.<br>
                                [연속] 2개이상 등록시 세로로 연속하여 노출됩니다.<br>
                                [롤링] 2개이상 등록시 슬라이드형식으로 롤링되며 노출됩니다.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">출력 여부</th>
                        <td>
                            <input type="checkbox" name="show_yn" value="y" id="show_yn_yes" <?=get_checked($this->row['show_yn'], "y");?> ><label for="show_yn_yes"> 노출함</label>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">배너 파일<br>(1980X400)</th>
                        <td>
                            <input type="hidden" name="ori_img_file" id="img_file" value="<?=$this->row['img_file']?>">
                            <input type="file" name="img_file">
                            <input type="checkbox" name="img_file_del" value="<?=$this->row['img_file']?>" id="img_file_del"> <label for="img_file_del">삭제</label>
                            <div class="mart5">
                                <?=get_img(_BANNER.$this->row['img_file'],"50px")?>
                            </div>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">배너 파일<br>(1200X400)</th>
                        <td>
                            <input type="hidden" name="ori_img_file2" id="img_file2" value="<?=$this->row['img_file2']?>">
                            <input type="file" name="img_file2">
                            <input type="checkbox" name="img_file2_del" value="<?=$this->row['img_file2']?>" id="img_file2_del"> <label for="img_file2_del">삭제</label>
                            <div class="mart5">
                                <?=get_img(_BANNER.$this->row['img_file2'],"50px")?>
                            </div>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">배너 파일<br>(900X400)</th>
                        <td>
                            <input type="hidden" name="ori_img_file3" id="img_file3" value="<?=$this->row['img_file3']?>">
                            <input type="file" name="img_file3">
                            <input type="checkbox" name="img_file3_del" value="<?=$this->row['img_file3']?>" id="img_file3_del"> <label for="img_file3_del">삭제</label>
                            <div class="mart5">
                                <?=get_img(_BANNER.$this->row['img_file3'],"50px")?>
                            </div>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">링크 주소</th>
                        <td>
                            <input type="text" name="url_link" value="<?=isset($this->row['url_link'])?$this->row['url_link']:""?>" size="40">
                            <p class="info">[외부링크] http:// 를 포함해 절대경로로 입력해주시기 바랍니다.<br>
                            <span class="fc_197">절대경로 예시) http://test.com/shop/listtype.php?type=1</span>
                            </p>
                            <p class="info">[내부링크] http:// 를 제외한 상대경로로 입력해주시기 바랍니다.<br>
                            <span class="fc_197">상대경로 예시) /shop/listtype.php?type=1</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('begin_dt', $this->row['begin_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('end_dt', $this->row['end_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">배경 색상</th>
                        <td>
                            <input type="text" name="bg_color"  value="<?=isset($this->row['bg_color'])?$this->row['bg_color']:""?>" >
                            <p class="info">"#" 기호없이 색상값 6자만 입력하세요. 예) F6E3FB </p>
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
}
</script>
