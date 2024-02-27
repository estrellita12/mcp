<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fboardGroupModify" action="/Design/setBannerGroup/<?=$this->param['ident']?>" method="POST">
            <input type="hidden" name="preUrl" value="<?=$_GET['returnUrl']?>">
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
                        <td><?=$this->row['bngr_id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">그룹명</th>
                        <td><input type="text" name="name" class="required" value="<?=$this->row['bngr_name']?>" required></td>
                    </tr>
                    <tr>
                        <th scope="row">디바이스</th>
                        <td>
                            <select name="device" required>
                                <?php foreach($GLOBALS['device'] as $key=>$value){ ?>
                                <?=get_frm_option($key,$this->row['bngr_device'],$value)?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가로 크기(px)</th>
                        <td><input type="text" name="width" class="required" value="<?=$this->row['bngr_w_size']?>" required></td>
                    </tr>
                    <tr>
                        <th scope="row">세로 크기(px)</th>
                        <td><input type="text" name="height" class="required" value="<?=$this->row['bngr_h_size']?>" required></td>
                    </tr>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                <a href="<?=urldecode($_GET['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
                <a href="/Design/removeBannerGroup/<?=$this->row['bogr_id']?>?preUrl=<?=urlencode($_GET['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 배너 그룹을 삭제 하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.\n해당 그룹에 속한 배너가 모두 삭제됩니다.')">삭제</a>
            </div>
        </form>
    </div>
</section>
