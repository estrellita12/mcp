<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="fregisterForm" action="/Mypage/set/<?=$this->my['pt_id']?>" method="POST" onsubmit="return frmCommaSubmit()">
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
                            <?=get_frm_radio("coupon","y",$this->my['shop_coupon_use_yn'],"사용");?>
                            <?=get_frm_radio("coupon","n",$this->my['shop_coupon_use_yn'],"미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">포인트 사용 여부</th>
                        <td colspan="3">
                            <?=get_frm_radio("point","y",$this->my['shop_point_use_yn'],"사용");?>
                            <?=get_frm_radio("point","n",$this->my['shop_point_use_yn'],"미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">최소 결제 포인트</th>
                        <td><input type="text" name="minPoint" class="w80 tar comma" maxlength="7" value="<?=number_format($this->my['shop_min_point'])?>">point</td>
                        <th scope="col">최대 결제 포인트</th>
                        <td><input type="text" name="maxPoint" class="w80 tar comma"  maxlength="8" value="<?=number_format($this->my['shop_max_point'])?>">point</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">회원 연동 정책</div>
                <div class="info"><p> SSO연동의 경우 추가개발이 필요합니다. 개발팀에 문의하여 주시기 바랍니다. </p></div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="my">SSO 정보</th>
                        <td>
                            <?=get_frm_radio("sso","y",$this->my['pt_sso_yn'],"회원 연동")?>
                            <?=get_frm_radio("sso","n",$this->my['pt_sso_yn'],"본사 DB 사용")?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap" id="ssoYes" <?=$this->my['pt_sso_yn']=='y'?'':'style="display:none"'?>>
                <div class="h2">연동 관련 정보</div>
                <div class="info"><p> SSO연동을 진행하는 경우, 반드시 입력해야하는 정보입니다.</p></div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="my">전송 방식</th>
                        <td>
                            <select name="ssoMethod">    
                                <?= get_frm_option("none",$this->my['pt_sso_method'],"NONE");?>
                                <?= get_frm_option("get",$this->my['pt_sso_method'],"GET");?>
                                <?= get_frm_option("post",$this->my['pt_sso_method'],"POST");?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="my">IV</th>
                        <td><input type="text" name="encIv" value="<?=$this->my['pt_sso_enc_iv']?>"></td>
                        <th scope="my">KEY</th>
                        <td><input type="text" name="encKey" value="<?=$this->my['pt_sso_enc_key']?>"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap" id="ssoNo" <?=$this->my['pt_sso_yn']=='n'?'':'style="display:none"'?>>
                <div class="h2">소셜 로그인 정보</div>
                <div class="info"><p> 데이터가 입력된 소셜로그인만 화면에 출력됩니다.</p></div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="my">소셜 로그인</th>
                        <td>
                            <?=get_frm_chkbox("snsLogin","y",$this->my['shop_sns_login_yn'],"사용함")?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="my">네이버 Client ID</th>
                        <td>
                            <input type="text" name="loginNaverClientId" value="<?=$this->my['shop_sns_login_naver_client_id']?>">
                            <div class="info"><p>앱설정시 Callback URL에 http://도메인주소/plugin/login-oauth/login_with_naver.php 입력</p></div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="my">네이버 Client Secret</th>
                        <td>
                            <input type="text" name="loginNaverClientSecret" value="<?=$this->my['shop_sns_login_naver_client_secret']?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="my">카카오 REST API Key</th>
                        <td>
                            <input type="text" name="loginKakaoApiKey" value="<?=$this->my['shop_sns_login_kakao_api_key']?>">
                            <div class="info"><p>카카오 사이트 설정에서 플랫폼 > Redirect Path에 /plugin/login-oauth/login_with_kakao.php 라고 입력</p></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" class="btn_large btn_theme">
            </div>
        </form>
    </div>
</section>
<script>
$(function() {
        $("input[name=sso]").click(function(){
                var sso = $(this).val();
                if(sso=="y"){
                $("#ssoYes").show(); 
                $("#ssoNo").hide(); 
                }else{
                $("#ssoNo").show(); 
                $("#ssoYes").hide(); 
                }
                })
        });
</script>
