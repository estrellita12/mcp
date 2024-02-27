<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/addCoupon" method="POST" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="returnUrl" value="<?=$_REQUEST['returnUrl']?>">
            <div class="rhead01_wrap">
                <div class="h2">쿠폰 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop" class="select2 w200"> 
                                <?= get_frm_option("admin",$this->row['pt_id'],"전체"); ?>
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,$this->row['pt_id'],$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">쿠폰명</th>
                        <td><input type="text" name="title" size="40" required></td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td><input type="checkbox" name="useYn" value="y" id="showYn"><label for="showYn"> 노출함</label></td>
                    </tr>   
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td><?=get_frm_date('beginDate', '');?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td><?=get_frm_date('endDate', '' );?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">목록 이미지</th>
                        <td><input type="file" name="listImgFile"></td>
                    </tr>  
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
