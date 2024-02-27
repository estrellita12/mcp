    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
        <form name="fboardGroupModify" action="/Board/groupSet/<?=$this->param['ident']?>" method="POST" onsubmit="return fsubmit(this)">
            <div class="rhead01_wrap">
                <div class="h2">게시판 그룹정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w170">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">그룹아이디</th>
                        <td><?=$this->row['bogr_id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">그룹명</th>
                        <td><input type="text" name="name" class="required" value="<?=$this->row['bogr_name']?>" required></td>
                    </tr>
                </table>
            </div>
           <div class="confirm_wrap">
                <input type="submit" value="수정" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </div>
</section>
