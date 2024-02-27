    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
        <form name="fboardForm" enctype="MULTIPART/FORM-DATA" action="/Board/add" method="POST">
            <div class="rhead01_wrap">
                <div class="h2">게시판 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w170">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">아이디</th>
                        <td><?=$this->last_idx?></td>
                    </tr>
                    <tr>
                        <th scope="row">그룹</th>
                        <td>
                            <select name="group">
                                <?php foreach($this->bogr_li as $key=>$value){ ?>
                                <?=get_frm_option($key,null,$value); ?>
                                <?php } ?>
                            </select>                            
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">게시판 제목</th>
                        <td><input type="text" name="name" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">스킨 디렉토리</th>
                        <td>
                            <select name="skin">
                                <?php foreach($this->bogr_li as $key=>$value){ ?>
                                <?=get_frm_option($key,null,$value); ?>
                                <?php } ?>
                            </select>                            
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">분류</th>
                        <td>
                            <p class="info">분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #은 입력하지 마세요. (예: #질문|#답변 [X])</p>
                            <input type="text" name="category">
                            <span class="info">
                                <label><input type="checkbox" name="use_category" value="Y" > 사용</label>
                            </span>                                              
                        </td>
                    </tr>                                        
                    <tr>
                        <th scope="row">게시판 테이블 넓이</th>
                        <td>
                            <p class="info">100 이하는 %로 작동 합니다.</p>
                            <input type="number" name="width" class="required" required>
                        </td>                    
                    </tr>
                    <tr>
                        <th scope="row">페이지당 목록 수</th>
                        <td>
                            <p class="info">한 페이지 내에서 나타나는 게시물 최대 개수입니다.</p>
                            <input type="number" name="page" class="required" required>
                        </td>                    
                    </tr>
                    <tr>
                        <th scope="row">제목 길이</th>
                        <td>
                            <p class="info">게시판 목록에서 표시되는 제목 텍스트 길이를 글자 수 만큼 제한합니다.</p>
                            <input type="number" name="title_limit" >
                        </td>                    
                    </tr>                        
                    <tr>
                        <th scope="row">목록보기 권한</th>
                        <td>
                            <select name="list_perm">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, 'none', $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                        
                    <tr>
                        <th scope="row">글읽기 권한</th>
                        <td>
                            <select name="read_perm">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, null, $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                        
                    <tr>
                        <th scope="row">글쓰기 권한</th>
                        <td>
                            <select name="write_perm">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, null, $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                        
                    <tr>
                        <th scope="row">글답변 권한</th>
                        <td>
                            <select name="reply_perm">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, null, $name) ;?>
                                <?php } ?>
                            </select>
                            <span class="info">
                                <label><input type="checkbox" name="use_reply" value="Y"> 사용</label>
                            </span>                            
                        </td>
                    </tr>                          
                    <tr>
                        <th scope="row">코멘트쓰기 권한</th>
                        <td>
                            <select name="comment_perm">
                                <?php foreach($this->gr_li as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, null, $name) ;?>
                                <?php } ?>
                            </select>
                            <span class="info">
                                <label><input type="checkbox" name="use_comment" value="Y"> 사용</label>
                            </span>                            
                        </td>
                    </tr>                          
                    <tr>
                        <th scope="row">파일 업로드</th>
                        <td>
                            <span class="info">
                                <label><input type="checkbox" name="use_upload" value="Y" > 사용</label>
                            </span>                            
                        </td>
                    </tr>                          
                    <tr>
                        <th scope="row">비밀글</th>
                        <td>
                            <?php foreach( $GLOBALS['bo_use_secret'] as $key=>$value ){ ?>
                            <?=get_frm_radio("use_secret",$key,3,$value)?>
                            <?php } ?>
                        </td>                        
                    </tr>                                                     
                    <tr>
                        <th scope="row">글내용 옵션</th>
                        <td>
                            <?php foreach( $GLOBALS['bo_content_opt'] as $key=>$value ){ ?>
                            <?=get_frm_radio("content_opt",$key,3,$value)?>
                            <?php } ?>
                        </td>
                    </tr>                                                                                                                                                                                                                                                
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">디자인/양식 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w170">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">상단 파일 경로</th>
                        <td><input type="text" name="t_file"></td>
                    </tr>
                    <tr>
                        <th scope="row">하단 파일 경로</th>
                        <td><input type="text" name="d_file"></td>
                    </tr>
                    <tr>
                        <th scope="row">상단 이미지</th>
                        <td>
                            <input type="file" name="t_img" id="t_img" >
                            <span class="info">권장 사이즈 (000px * 000px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">하단 이미지</th>
                        <td>
                            <input type="file" name="d_img" id="d_img" >
                            <span class="info">권장 사이즈 (000px * 000px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">상단 내용</th>
                        <td colspan="3"><textarea name="t_content" class="frm_textbox" rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row">하단 내용</th>
                        <td colspan="3"><textarea name="d_content" class="frm_textbox" rows="3"></textarea></td>
                    </tr>                        
                    <tr>
                        <th scope="row">글쓰기 기본 내용</th>
                        <td colspan="3"><textarea name="default_text" class="frm_textbox" rows="3"></textarea></td>
                    </tr>                                                                                                                                                                                                                                                                 
                </table>
            </div>            
            
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </div>
</section>
