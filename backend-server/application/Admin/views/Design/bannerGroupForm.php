<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fboardGroupForm" action="/Design/addBannerGroup" method="POST">
            <input type="hidden" name="preUrl" value="<?=$_GET['returnUrl']?>">
            <div class="rhead01_wrap">
                <div class="h2">배너 그룹정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w170">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">그룹명</th>
                        <td>
                            <input type="text" name="name" class="required" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">디바이스</th>
                        <td>
                            <select name="device" required>
                                <?php foreach($GLOBALS['device'] as $key=>$value){ ?>
                                <?=get_frm_option($key,"",$value)?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가로 크기(px)</th>
                        <td><input type="text" name="width" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">세로 크기(px)</th>
                        <td><input type="text" name="height" class="required" required></td>
                    </tr>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                <a href="<?=urldecode($_GET['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
            </div>
        </div>
    </form>
</div>
</section>
