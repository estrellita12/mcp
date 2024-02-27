<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$this->menu->getName( _SCRIPT_URL );?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->menu->getName( _SCRIPT_URL );?> </h1>
        <form action="/Board/boardGroupFormUpdate" method="POST">
            <input type="hidden" name="mode" value="<?=$_GET['mode']?>">
            <input type="hidden" name="idx" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <h2>그룹 정보 입력</h2>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">그룹아이디</th>
                        <td><input type="text" name="id" value="<?=isset($this->row['id'])?$this->row['id']:''?>" class="required"></td>
                    </tr>
                    <tr>
                        <th scope="row">그룹이름</th>
                        <td><input type="text" name="name" value="<?=isset($this->row['name'])?$this->row['name']:''?>" class="required"></td>
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
