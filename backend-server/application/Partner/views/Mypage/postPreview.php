<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?> </h1>
    <form name="fboardForm" enctype="MULTIPART/FORM-DATA" action="/Board/addPost" method="POST">
        <input type="hidden" name="board" value="<?=$_REQUEST['board']?>">
        <div class="rhead01_wrap">
            <div class="h2">게시글 정보 입력</div>
            <table>
                <colgroup>
                    <col class="w170">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">게시판</th>
                        <td>
                            <select name="board" class="w200" onchange="location='<?=get_query("board")."&board="?>'+this.value;">
                                <?php foreach($this->bo_li as $key=>$value){ ?>
                                <?= get_frm_option($key, $_REQUEST['board'], $value); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">제목</th>
                        <td><input type="text" name="title" class="required" value="<?=$this->row['bopo_title']?>" required></td>
                    </tr>
                    <?php if( $this->boardRow['bo_use_upload'] == "y" ){ ?>
                    <tr>
                        <th scope="row">파일 첨부1</th>
                        <td><input type="text" name="file1" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">파일 첨부</th>
                        <td><input type="text" name="file1" class="required"></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th scope="row">옵션</th>
                        <td>
                            <?php if( $this->boardRow['bo_use_secret'] == "1" ){ ?>
                            <label><input type="checkbox" name="secretYn" value="y" <?=get_checked('y',$this->row['bopo_secret_yn'])?> > 비밀글</label>
                            <?php }else if( $this->row['bo_use_secret'] == "2" ){ ?>
                            <label><input type="checkbox" name="secretYn" value="y" <?=get_checked('y',$this->row['bopo_secret_yn'])?> readonly > 비밀글</label>
                            <?php } ?>
                            <label><input type="checkbox" name="display" value="1" <?=get_checked('1',$this->row['bopo_main_display'])?> > 메인고정</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">비밀글</th>
                        <td>

                                <iframe src="<?=_PUBLIC?>/iframe.html" id="content" frameborder="0" scrolling="no" style="width:100%"></iframe>
                                <textarea id="data" name="content" class="dn"><?=get_text($this->row['bopo_content'],0)?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_black" accesskey="s">
                <a href="<?=_PRE_URL?>" class="btn_large btn_white" accesskey="s">목록</a>
            </div>
        </form>
    </div>
</section>
<script>
    $(function(){
        $("#content").on("load", function() {
            let data =  $("#data").val();
            let wrapper = $("#content").contents().find("#wrapper");
            $(wrapper).append(data);
            $("#content").css('height',$(wrapper).height());
        });
    })
</script>
