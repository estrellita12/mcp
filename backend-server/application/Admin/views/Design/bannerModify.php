<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/setBanner/<?=$this->row['bn_id']?>" method="POST" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="preUrl" value="<?=$_REQUEST['returnUrl']?>">
            <input type="hidden" name="id" value="<?=$this->row['bn_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">배너 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">디바이스</th>
                        <td>
                            <select name="device" class="w200" onchange="location='<?=get_query("device")."&device="?>'+this.value;" readonly disabled>
                                <?= get_frm_option("1",$this->row['device'], "PC 배너"); ?>
                                <?= get_frm_option("2",$this->row['device'], "모바일 배너"); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">노출 영역</th>
                        <td>
                            <select name="position" class="select2 w300">
                                <?php foreach( $this->gr_li as $position => $title ) { ?>
                                <?= get_frm_option($position, $this->row['bn_position'], $title); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" value="<?=$this->row['ctg_id']?>">
                            <?=$this->category->printDepthList(1, $this->row['ctg_id'],'ctg1','required'); ?>
                            <?=$this->category->printDepthList(2, $this->row['ctg_id'],'ctg2','required'); ?>
                            <script>
$(function() {
        $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="select2 w200">
                                <?= get_frm_option("admin",$this->row['pt_id'],"전체"); ?>
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,$this->row['pt_id'],$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td>
                            <?=get_frm_chkbox("showYn","y",$this->row['bn_show_yn'],"노출함")?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">배너 파일</th>
                        <td>
                            <input type="hidden" name="oriImgFile" id="oriImgFile" value="<?=$this->row['bn_img']?>">
                            <input type="file" name="imgFile">
                            <input type="checkbox" name="imgFileDel" value="<?=$this->row['bn_img']?>" id="imgFileDel"> <label for="imgFileDel">삭제</label>
                            <div class="mart5">
                                <?=get_img(_BANNER,$this->row['bn_img'],"300px")?>
                            </div>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">링크 주소</th>
                        <td>
                            <input type="text" name="url" value="<?=$this->row['bn_url']?>" size="40" required>
                            <p class="info">[외부링크] http:// 를 포함해 절대경로로 입력해주시기 바랍니다.<br>절대경로 예시) http://test.com/shop/listtype.php?type=1</p>
                            <p class="info">[내부링크] http:// 를 제외한 상대경로로 입력해주시기 바랍니다.<br>상대경로 예시) /shop/listtype.php?type=1</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('beginDate', $this->row['bn_begin_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('endDate', $this->row['bn_end_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">배경 색상</th>
                        <td>
                            <input type="color" name="backgroundColor"  value="<?=$this->row['bn_bg_color']?>" >
                        </td>
                    </tr> 
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white">목록</a>
                    <a href="/Design/removeBanner/<?=$this->param['ident']?>?returnUrl=<?=urlencode($_REQUEST['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 배너를 삭제하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.')">삭제</a>
                </div>
            </div>
        </form>
    </div>
</section>
