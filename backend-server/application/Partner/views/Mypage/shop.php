<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="flogo" method="post" action="/Mypage/set/<?=$this->my['pt_id']?>" enctype="MULTIPART/FORM-DATA">
            <div class="rhead01_wrap">
                <div class="h2">쇼핑몰 디자인</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="my">쇼핑몰 도메인</th>
                        <td>https://<input type="text" name="url" value="<?=$this->my['shop_url']?>" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="col">브라우저 타이틀</th>
                        <td><input type="text" name="title" value="<?=$this->my['shop_title']?>" size="40"></td>
                    </tr>
                    <tr>
                        <th scope="col">Description : 메타태그</th>
                        <td><input type="text" name="description" value="<?=$this->my['shop_description']?>" size="60"></td>
                    </tr>
                    <tr>
                        <th scope="col">HEAD 스타일 태그</th>
                        <td><textarea name="headTag"><?=$this->my['shop_head_tag']?></textarea></td>
                    </tr>
                    <tr>
                        <th scope="col">BODY 스크립트 태그</th>
                        <td><textarea name="bodyTag"><?=$this->my['shop_body_tag']?></textarea></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">테마 스킨 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">PC 스킨 테마</th>
                        <td>
                            <select name="pctheme">
                                <?php foreach($GLOBALS['theme'] as $theme){?>
                                <?=get_frm_option($theme,$this->my['shop_pc_theme'])?>
                                <?php } ?>
                            </select>
                        </td>
                        <th scope="col">모바일 스킨 테마</th>
                        <td>
                            <select name="mtheme">
                                <?php foreach($GLOBALS['mtheme'] as $theme){?>
                                <?=get_frm_option($theme,$this->my['shop_m_theme'])?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">쇼핑몰 로고</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="my">대표 로고</th>
                        <td>
                            <input type="file" name="pclogo" id="pclogo">
                            <input type="checkbox" name="pclogo_del" value="<?=$this->my['shop_pc_logo']?>" id="pclogo_del">
                            <label for="pclogo_del">삭제</label>
                            <div class="img_wrap"> <?=get_img( _LOGO,$this->my['shop_pc_logo'] )?> </div>
                            <span class="info">권장 사이즈 (<?=$this->config['cf_pc_logo_size_w']?>px * <?=$this->config['cf_pc_logo_size_h']?>px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="my">모바일 로고</th>
                        <td>
                            <input type="file" name="mlogo" id="mlogo">
                            <input type="checkbox" name="mlogo_del" value="<?=$this->my['shop_m_logo']?>" id="mlogo_del">
                            <label for="mlogo_del">삭제</label>
                            <div class="img_wrap"> <?=get_img( _LOGO,$this->my['shop_m_logo'] )?> </div>
                            <span class="info">권장 사이즈 (<?=$this->config['cf_m_logo_size_w']?>px * <?=$this->config['cf_m_logo_size_h']?>px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="my">SNS 기본 로고</th>
                        <td>
                            <input type="file" name="snslogo" id="snslogo">
                            <input type="checkbox" name="snslogo_del" value="<?=$this->my['shop_sns_logo']?>" id="snslogo_del">
                            <label for="snslogo_del">삭제</label>
                            <div class="img_wrap"> <?=get_img( _LOGO,$this->my['shop_sns_logo'] )?> </div>
                            <span class="info">권장 사이즈 (<?=$this->config['cf_sns_logo_size_w']?>px * <?=$this->config['cf_sns_logo_size_h']?>px)</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">파비콘 (favicon) 설정</div>
                <table class="tablef">
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="my" rowspan="2">파비콘 아이콘<br>(ico파일)</th>
                        <td>
                            <input type="file" name="fav" id="fav">
                            <input type="checkbox" name="fav_del" value="1" id="fav_logo_del">
                            <label for="fav_del">삭제</label>
                            <div class="img_wrap"> <?=get_img( _LOGO,$this->my['shop_favicon'] , $this->config['cf_favicon_size_w'])?> </div>
                            <span class="info">권장 사이즈 (<?=$this->config['cf_favicon_size_w']?>px * <?=$this->config['cf_favicon_size_h']?>px)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="info">
                                <p><strong>파비콘(favicon) 이란?</strong></p>
                                <p>브라우저의 타이틀 옆에 표시되거나 즐겨찾기시 설명 옆에 표시되는 사이트의 아이콘을 말합니다.</p>
                                <p>크롬, 사파리, 오페라등 익스플로러 외 다른 OS이거나 브라우저 버전에 따라 출력이 되지 않을 수 있습니다.</p>
                                <p>파비콘(favicon)은 크기 16x16픽셀, 최대 용량 150KB의 (*.ico) 파일만 사용하실 수 있습니다.</p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="저장" class="btn_large btn_theme" accesskey="s">
            </div>
        </form>
    </div>
</section>
