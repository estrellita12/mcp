<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="/Setting/setConfig" method="POST" onsubmit="return fcommaSubmit(this);">
            <div class="rhead01_wrap">
                <div class="h2">정보 노출 설정</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">구매 후기</th>
                        <td>
                            <?=get_frm_radio("reviewOnly","y",$this->row['cf_review_only_pt_yn'],"해당 가맹점몰에서만 노출");?>
                            <?=get_frm_radio("reviewOnly","n",$this->row['cf_review_only_pt_yn'],"모든 가맹점에서 노출");?>
                        </td>
                        <th scope="col">게시판 게시글</th>
                        <td>
                            <?=get_frm_radio("boardOnly","y",$this->row['cf_board_only_pt_yn'],"해당 가맹점몰에서만 노출");?>
                            <?=get_frm_radio("boardOnly","n",$this->row['cf_board_only_pt_yn'],"모든 가맹점에서 노출");?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">정책 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">장바구니 보관일수</th>
                        <td><input type="text" name="keepCart" class="tar"  value="<?=$this->row['cf_keep_cart_term']?>">일</td>
                        <th scope="col">찜 보관일수</th>
                        <td><input type="text" name="keepWish" class="tar" value="<?=$this->row['cf_keep_wish_term']?>">일</td>
                    </tr>
                    <tr>
                        <th scope="col">구매확정 강제 승인</th>
                        <td><input type="text" name="keepConfirm" class="tar" value="<?=$this->row['cf_keep_confirm_term']?>">일</td>
                        <th scope="col">미입금 주문 내역</th>
                        <td><input type="text" name="keepMisu" class="tar" value="<?=$this->row['cf_keep_misu_term']?>">일</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">이미지 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">PC 로고 사이즈</th>
                        <td>
                            <input type="text" name="pcLogoWidth" value="<?=$this->row['cf_pc_logo_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="pcLogoHeight" value="<?=$this->row['cf_pc_logo_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                        <th scope="col">모바일 로고 사이즈</th>
                        <td>
                            <input type="text" name="mLogoWidth" value="<?=$this->row['cf_m_logo_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="mLogoHeight" value="<?=$this->row['cf_m_logo_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">SNS 썸네일 사이즈</th>
                        <td>
                            <input type="text" name="snsLogoWidth" value="<?=$this->row['cf_sns_logo_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="snsLogoHeight" value="<?=$this->row['cf_sns_logo_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                        <th scope="col">파비콘 사이즈</th>
                        <td>
                            <input type="text" name="faviconWidth" value="<?=$this->row['cf_favicon_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="faviconHeight" value="<?=$this->row['cf_favicon_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">기본 배너 사이즈</th>
                        <td>
                            <input type="text" name="bannerWidth" value="<?=$this->row['cf_bn_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="bannerHeight" value="<?=$this->row['cf_bn_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                        <th scope="col">와이드 배너 사이즈</th>
                        <td>
                            <input type="text" name="wideBannerWidth" value="<?=$this->row['cf_wide_bn_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="wideBannerHeight" value="<?=$this->row['cf_wide_bn_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">모바일 배너 사이즈</th>
                        <td colspan="3">
                            <input type="text" name="mBannerWidth" value="<?=$this->row['cf_m_bn_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="mBannerHeight" value="<?=$this->row['cf_m_bn_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">상품 썸네일</th>
                        <td colspan="3">
                            <input type="text" name="simgWidth" value="<?=$this->row['cf_simg_size_w']?>" placeholder="가로길이" size="7"> X
                            <input type="text" name="simgHeight" value="<?=$this->row['cf_simg_size_h']?>" placeholder="세로길이" size="7">px
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="chead02_wrap">
                <div class="h2">택배사 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col class="w300">
                        <col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">코드</th>
                            <th scope="col">택배사</th>
                            <th scope="col">송장 조회 링크</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $this->row['cf_delivery_company'] as $key=>$value) { ?>
                    <tr>
                        <td><?=$key?></td>
                        <td><input type="text" name="delivery[<?=$key?>][company]" value="<?=$value['company']?>" placeholder="택배사" class="w100p"></td>
                        <td class="tal"><input type="text" name="delivery[<?=$key?>][link]" value="<?=$value['link']?>" placeholder="송장 조회 링크" class="w100p"></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
            </div>
        </form>
    </div>
</section>
