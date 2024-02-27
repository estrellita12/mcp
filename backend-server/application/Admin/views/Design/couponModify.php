<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/setCoupon/<?=$this->param['ident']?>" method="POST" enctype="MULTIPART/FORM-DATA">
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
                        <td><input type="text" name="title" value="<?=$this->row['cp_title']?>" size="40" required></td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td><?=get_frm_chkbox("useYn","y",$this->row['cp_use_yn'],"노출함")?></td>
                    </tr>   
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('beginDate', $this->row['cp_begin_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('endDate', $this->row['cp_end_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">목록 이미지</th>
                        <td>
                            <input type="hidden" name="oriListImgFile" id="oriListImgFile" value="<?=$this->row['cp_list_img']?>">
                            <input type="file" name="listImgFile">
                            <input type="checkbox" name="listImgFileEel" value="<?=$this->row['cp_list_img']?>" id="listImgFileEel">
                            <label for="listImgFileEel">삭제</label>
                            <div class="mart5">
                                <?=get_img(_COUPON,$this->row['cp_list_img'],"300px")?>
                            </div>
                        </td>
                    </tr>  

                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=get_return_url("/Design/couponList")?>" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
