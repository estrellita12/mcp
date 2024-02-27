<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$this->menu->getName( _SCRIPT_URL );?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->menu->getName( _SCRIPT_URL );?> </h1>
        <form action="/Board/boardFormUpdate" method="POST">
            <input type="hidden" name="mode" value="<?=$_GET['mode']?>">
            <input type="hidden" name="idx" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <h2>게시판 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">테이블</th>
                        <td><input type="text" name="idx" value="<?=isset($this->row['idx'])?'web_board_'.$this->row['idx']:''?>" class="readonly" readonly></td>
                    </tr>
                    <tr>
                        <th scope="row">게시판 이름</th>
                        <td><input type="text" name="name" value="<?=isset($this->row['name'])?$this->row['name']:''?>" class="required" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">소속 그룹</th>
                        <td><input type="text" name="gr_id" value="<?=isset($this->row['gr_id'])?$this->row['gr_id']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">스킨 테마</th>
                        <td><input type="text" name="skin" value="<?=isset($this->row['skin'])?$this->row['skin']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">페이지당 목록 수 </th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">목록 보기 권한 </th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">글읽기 권한 </th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">글쓰기 권한 </th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">글답변 권한 </th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">글댓글 권한 </th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀글 기능 사용</th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">에디터 기능 사용</th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">파일 업로드 기능 사용</th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">글 내용 옵션</th>
                        <td><input type="text" name="page_num" value="<?=isset($this->row['page_num'])?$this->row['page_num']:''?>" class="required"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>게시판 추가 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">상단 파일</th>
                        <td><input type="text" name="name" value="<?=isset($this->row['name'])?$this->row['name']:''?>" class="required" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">하단 파일</th>
                        <td><input type="text" name="name" value="<?=isset($this->row['name'])?$this->row['name']:''?>" class="required" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">상단 삽입 이미지</th>
                        <td><input type="text" name="name" value="<?=isset($this->row['name'])?$this->row['name']:''?>" class="required" size=40></td>
                    </tr>
                    <tr>
                        <th scope="row">하단 삽입 이미지</th>
                        <td><input type="text" name="name" value="<?=isset($this->row['name'])?$this->row['name']:''?>" class="required" size=40></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </section>
</div>
