<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form action="/Default/set" method="POST" onsubmit="frmCommaSubmit(this);">
            <div class="rhead01_wrap">
                <div class="h2">포인트/쿠폰 정책</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">쿠폰 사용 여부</th>
                        <td colspan="3">
                            <?=get_frm_radio("coupon","y",$this->row['shop_coupon_use_yn'],"사용");?>
                            <?=get_frm_radio("coupon","n",$this->row['shop_coupon_use_yn'],"미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">포인트 사용 여부</th>
                        <td colspan="3">
                            <?=get_frm_radio("point","y",$this->row['shop_point_use_yn'],"사용");?>
                            <?=get_frm_radio("point","n",$this->row['shop_point_use_yn'],"미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">최소 결제 포인트</th>
                        <td><input type="text" name="minPoint" class="comma w80 tar" value="<?=number_format($this->row['shop_min_point'])?>">point</td>
                        <th scope="col">최대 결제 포인트</th>
                        <td><input type="text" name="maxPoint" class="comma w80 tar" value="<?=number_format($this->row['shop_max_point'])?>">point</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap" id="ssoNo">
                <div class="h2">소셜 로그인 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">소셜 로그인</th>
                        <td>
                            <?=get_frm_chkbox("snsLogin","y",$this->row['shop_sns_login_yn'],"사용함")?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">네이버 Client ID</th>
                        <td>
                            <input type="text" name="loginNaverClientId" value="<?=$this->row['shop_sns_login_naver_client_id']?>">
                            <div class="info"><p>앱설정시 Callback URL에 http://도메인주소/plugin/login-oauth/login_with_naver.php 입력</p></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">네이버 Client Secret</th>
                        <td>
                            <input type="text" name="loginNaverClientSecret" value="<?=$this->row['shop_sns_login_naver_client_secret']?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카카오 REST API Key</th>
                        <td>
                            <input type="text" name="loginKakaoApiKey" value="<?=$this->row['shop_sns_login_kakao_api_key']?>">
                            <div class="info"><p>카카오 사이트 설정에서 플랫폼 > Redirect Path에 /plugin/login-oauth/login_with_kakao.php 라고 입력</p></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">회원 가입 약관</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">이용약관</th>
                        <td>
                            <?= editor_html('provision', get_text($this->row['shop_provision'],0)) ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">개인정보처리방침</th>
                        <td>
                            <?= editor_html('policy', get_text($this->row['shop_policy'],0)) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
            </div>
        </form>
    </div>
</section>
