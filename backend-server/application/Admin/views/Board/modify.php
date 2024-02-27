<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fboardForm" enctype="MULTIPART/FORM-DATA" action="/Board/set/<?=$this->param['ident']?>" method="POST">
            <input type="hidden" name="preUrl" value="<?=$_GET['returnUrl']?>" >
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
                        <td><?=$this->row['bo_id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">그룹</th>
                        <td>
                            <select name="group">
                                <?php foreach($this->bogr_li as $key=>$value){ ?>
                                <?=get_frm_option($key,$this->row['bogr_id'],$value); ?>
                                <?php } ?>
                            </select>                            
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">게시판 제목</th>
                        <td><input type="text" name="name" class="required" value=<?=$this->row['bo_name']?> required></td>
                    </tr>
                    <tr>
                        <th scope="row">스킨 디렉토리</th>
                        <td>
                            <select name="skin">
                                <?php foreach($GLOBALS['skin_type'] as $value){ ?>
                                <?=get_frm_option($value,$this->row['bo_skin'],$value); ?>
                                <?php } ?>
                            </select>                            
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <th scope="row">분류</th>
                        <td>
                            <p class="info">분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #은 입력하지 마세요. (예: #질문|#답변 [X])</p>
                            <input type="text" name="category" value=<?=$this->row['bo_category']?>>
                            <span class="info">
                                <label><input type="checkbox" name="use_category" value='Y' <?=get_checked('Y',$this->row['bo_use_category'])?>> 사용</label>
                            </span>                                              
                        </td>
                    </tr>                                        
                    <tr>
                        <th scope="row">게시판 테이블 넓이</th>
                        <td>
                            <p class="info">100 이하는 %로 작동 합니다.</p>
                            <input type="number" name="width" class="required" value=<?=$this->row['bo_width']?> required>
                        </td>                    
                    </tr>
                    <tr>
                        <th scope="row">페이지당 목록 수</th>
                        <td>
                            <p class="info">한 페이지 내에서 나타나는 게시물 최대 개수입니다.</p>
                            <input type="number" name="page" class="required" value=<?=$this->row['bo_page']?> required>
                        </td>                    
                    </tr>
                    -->
                    <tr>
                        <th scope="row">제목 길이</th>
                        <td>
                            <p class="info">게시판 목록에서 표시되는 제목 텍스트 길이를 글자 수 만큼 제한합니다.</p>
                            <input type="number" name="title_limit" value=<?=$this->row['bo_title_limit']?>>
                        </td>                    
                    </tr>                        
                    <tr>
                        <th scope="row">목록보기 권한</th>
                        <td>
                            <select name="list_perm">
                                <?php foreach($GLOBALS['user_type'] as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['bo_list_perm'], $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                        
                    <tr>
                        <th scope="row">글읽기 권한</th>
                        <td>
                            <select name="read_perm">
                                <?php foreach($GLOBALS['user_type'] as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['bo_read_perm'], $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                        
                    <tr>
                        <th scope="row">글쓰기 권한</th>
                        <td>
                            <select name="write_perm">
                                <?php foreach($GLOBALS['user_type'] as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['bo_write_perm'], $name) ;?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>                        
                    <tr>
                        <th scope="row">글답변 권한</th>
                        <td>
                            <select name="reply_perm">
                                <?php foreach($GLOBALS['user_type'] as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['bo_reply_perm'], $name) ;?>
                                <?php } ?>
                            </select>
                            <label class="marl10"><input type="checkbox" name="use_reply" value="y" <?=get_checked('y',$this->row['bo_use_reply'])?>> 사용</label>
                        </td>
                    </tr>                          
                    <tr>
                        <th scope="row">코멘트쓰기 권한</th>
                        <td>
                            <select name="comment_perm">
                                <?php foreach($GLOBALS['user_type'] as $idx=>$name){ ?>
                                <?= get_frm_option( $idx, $this->row['bo_comment_perm'], $name) ;?>
                                <?php } ?>
                            </select>
                            <label class="marl10"><input type="checkbox" name="use_comment" value="y" <?=get_checked('y',$this->row['bo_use_comment'])?>> 사용</label>
                        </td>
                    </tr>                          
                    <tr>
                        <th scope="row">파일 업로드</th>
                        <td>
                            <label><input type="checkbox" name="use_upload" value="y" <?=get_checked('y',$this->row['bo_use_upload'])?>> 사용</label>
                        </td>
                    </tr>                          
                    <tr>
                        <th scope="row">비밀글</th>
                        <td>
                            <?php foreach( $GLOBALS['bo_use_secret'] as $key=>$value ){ ?>
                            <?=get_frm_radio("use_secret",$key,$this->row['bo_use_secret'],$value)?>
                            <?php } ?>
                        </td>                        
                    </tr>                                                     
                    <tr>
                        <th scope="row">글내용 옵션</th>
                        <td>
                            <?php foreach( $GLOBALS['bo_content_opt'] as $key=>$value ){ ?>
                            <?=get_frm_radio("content_opt",$key,$this->row['bo_content_opt'],$value)?>
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
                        <td><input type="text" name="t_file" value=<?=$this->row['bo_t_file']?>></td>
                    </tr>
                    <tr>
                        <th scope="row">하단 파일 경로</th>
                        <td><input type="text" name="d_file" value=<?=$this->row['bo_d_file']?>></td>
                    </tr>
                    <tr>
                        <th scope="row">상단 이미지</th>
                        <td>
                            <input type="file" name="t_img" id="t_img">
                            <input type="checkbox" name="t_img_del" value=<?=$this->row['bo_t_img']?>>
                            <label for="t_img_del">삭제</label>
                            <div class="img_wrap mart10"> <?=get_img( _BOARD,$this->row['bo_t_img'] , 160)?> </div>                            
                            <span class="info">권장 사이즈 (000px * 000px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">하단 이미지</th>
                        <td>
                            <input type="file" name="d_img" id="d_img">
                            <input type="checkbox" name="d_img_del" value=<?=$this->row['bo_d_img']?>>
                            <label for="d_img_del">삭제</label>
                            <div class="img_wrap mart10"> <?=get_img( _BOARD,$this->row['bo_d_img'] , 160)?> </div>   
                            <span class="info">권장 사이즈 (000px * 000px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">상단 내용</th>
                        <td colspan="3"><textarea name="t_content" class="frm_textbox" rows="3" ><?=$this->row['bo_t_content']?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="row">하단 내용</th>
                        <td colspan="3"><textarea name="d_content" class="frm_textbox" rows="3" ><?=$this->row['bo_d_content']?></textarea></td>
                    </tr>                        
                    <tr>
                        <th scope="row">글쓰기 기본 내용</th>
                        <td colspan="3"><textarea name="default_text" class="frm_textbox" rows="3" ><?=$this->row['bo_default_text']?></textarea></td>
                    </tr>
                </table>
            </div>            
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                <a href="<?=urldecode($_GET['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
                <a href="/Board/remove/<?=$this->row['bo_id']?>?preUrl=<?=urlencode($_GET['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 게시판을 삭제 하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.\n해당 게시판에 속한 게시글이 모두 삭제됩니다.')">삭제</a>
            </div>
        </form>
    </div>
</section>
