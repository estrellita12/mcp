<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/addBanner" method="POST" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="device" value="<?=$_REQUEST['device']?>">
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
                            <select name="device" class="w200" onchange="location='<?=get_query("device")."&device="?>'+this.value;">
                                <?= get_frm_option("1",$_REQUEST['device'], "PC 배너"); ?>
                                <?= get_frm_option("2",$_REQUEST['device'], "모바일 배너"); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">노출 영역</th>
                        <td>
                            <select name="position" class="select2 w300">
                                <?php foreach( $this->gr_li as $position => $title ) { ?>
                                <?= get_frm_option($position, '', $title); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" required>
                            <?=$this->category->printDepthList(1, '','ctg1', 'required'); ?>
                            <?=$this->category->printDepthList(2, '','ctg2', 'required'); ?>
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
                                <?= get_frm_option("admin","","전체"); ?>
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,"",$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td> <input type="checkbox" name="showYn" value="y" id="showYn"><label for="showYn"> 노출함</label></td>
                    </tr>   
                    <?php if($_REQUEST['device']=="1"){ ?>
                    <tr>
                        <th scope="row">PC 배너 파일</th>
                        <td>
                            <input type="file" name="imgFile" onchange="imgChangeHandler(this)"><br>
                            <img id="preview" class="padt5 parl10" style="max-width:400px">
                        </td>
                    </tr>  
                    <?php }else{ ?>
                    <tr>
                        <th scope="row">모바일 배너 파일</th>
                        <td>
                            <input type="file" name="mImgFile" onchange="imgChangeHandler(this)"><br>
                            <img id="preview" class="padt5 parl10" style="max-width:400px">
                        </td>
                    </tr>
                    <?php } ?>  
                    <tr>
                        <th scope="row">링크 주소</th>
                        <td>
                            <input type="text" name="url" size="40" required>
                            <p class="info">[외부링크] http:// 를 포함해 절대경로로 입력해주시기 바랍니다.<br>절대경로 예시) http://도메인/shop/listtype.php?type=1</p>
                            <p class="info">[내부링크] http:// 를 제외한 상대경로로 입력해주시기 바랍니다.<br>상대경로 예시) /shop/listtype.php?type=1</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td><?=get_frm_date('beginDate', '');?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td><?=get_frm_date('endDate', '');?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">배경 색상</th>
                        <td>
                            <input type="color" name="backgroundColor">
                        </td>
                    </tr> 
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=!empty($_REQUEST['returnUrl'])?urldecode($_REQUEST['returnUrl']):"/Design/bannerList"?>" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
function imgChangeHandler(obj){
    if (obj.files && obj.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(obj.files[0]);
    }
}

</script>
