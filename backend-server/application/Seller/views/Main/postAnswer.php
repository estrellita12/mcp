<section class="contents">
    <h1 class="cont_title">답글쓰기</h1>
    <div class="cont_wrap">
        <form name="fboardForm" enctype="MULTIPART/FORM-DATA" action="/Main/addAnswer" method="POST">
            <input type="hidden" name="board" value="<?=$_REQUEST['board']?>">
            <input type="hidden" name="pid" value="<?=$this->row['bopo_id']?>">
            <input type="hidden" name="depth" value="<?=$this->row['bopo_depth']+1?>">
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
                            <td><?=$this->boardRow['bo_name']?></td>
                        </tr>
                        <tr>
                            <th scope="row">원글 제목</th>
                            <td><?=$this->row['bopo_title']?></td>
                        </tr>
                        <tr>
                            <th scope="row">제목</th>
                            <td><input type="text" name="title" class="required" size=50 required></td>
                        </tr>
                        <tr>
                            <th scope="row">작성자</th>
                            <td><?=$_SESSION['user_name']?> (<?=$_SESSION['user_id']?>)</td>
                        </tr>
                        <?php if( $this->boardRow['bo_use_upload'] == "y" ){ ?>
                        <tr>
                            <th scope="row">파일 첨부1</th>
                            <td><input type="file" name="file1" class="required"></td>
                        </tr>
                        <tr>
                            <th scope="row">파일 첨부</th>
                            <td><input type="file" name="file1" class="required"></td>
                        </tr>
                        <?php } ?>
                        <?php if( $this->boardRow['bo_use_secret'] != "3" ){ ?>
                        <tr>
                            <th scope="row">옵션</th>
                            <td>
                                <label><input type="checkbox" name="secretYn" value="y" <?=$this->boardRow['bo_use_secret'] == "2"?"checked onClick='return false;'":""?> > 비밀글</label>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row">내용</th>
                            <td>
                                <?= editor_html('content',"") ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="confirm_wrap">
                    <input type="submit" value="등록" id="btn_submit" class="btn_medium btn_theme" accesskey="s">
                    <a href="" onclick="window.close()" class="btn_medium btn_white" accesskey="s">닫기</a>
                </div>
            </div>
        </form>
    </div>
</section>
