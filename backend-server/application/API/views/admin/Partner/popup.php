<div id="newWin">
    <div class="pg_header">
        <p class="pg_tit" id="pg_tit">가맹점 정보</p>
    </div>
    <section class="popup_inner">
        <ul class="tabs">
            <li><a href="#partner">가맹점 정보</a></li>
            <li><a href="#infomation">쇼핑몰 정보</a></li>
            <li><a href="#design">쇼핑몰 디자인</a></li>
            <li><a href="#category">카테고리 설정</a></li>
            <li class="<?=$this->def['sso_yn']=='y'?'':'dn'?>" ><a href="#sso">SSO 정보</a></li>
            <li class="<?=$this->row['own_pg']=='y'?'':'dn'?>" ><a href="#pg">PG 정보</a></li>
        </ul>
        <div class="tab_container">
            <div id="partner" class="tab_content">
                <form name="fpartnerForm" action="/Partner/set/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <input type="hidden" name="id" value="<?=$this->row['id']?>">
                        <h2>기본 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w130">
                                <col>
                                <col class="w130">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">가맹점명</th>
                                <td>
                                    <input type="text" name="name" id="ptnm" value="<?=$this->row['name']?>" required itemname="회원명" class="required">
                                </td>
                                <th scope="row">승인 상태</th>
                                <td><?=$GLOBALS['pt_stt'][$this->row['state']]?></td>
                            </tr>
                            <tr>
                                <th scope="row">아이디</th>
                                <td><?=$this->row['id']?></td>
                                <th scope="row">비밀번호</th>
                                <td><input type="text" id="passwd" name="passwd" value=""></td>
                            </tr>
                            <tr>
                                <th scope="row">수수료</th>
                                <td colspan="3">
                                    <input type="text" id="pay_rate" name="pay_rate" class="tar" value="<?=$this->row['pay_rate']?>" size="5"> %
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">은행정보</th>
                                <td colspan="3">
                                    <input type="text" name="bank_name" value="<?=$this->row['bank_name']?>" placeholder="은행명">
                                    <input type="text" name="bank_account" value="<?=$this->row['bank_account']?>" placeholder="계좌번호" size="30">
                                    <input type="text" name="bank_holder" value="<?=$this->row['bank_holder']?>" placeholder="예금주명">
                                    <p class="info">※ 계좌정보는 수수료 정산시 이용 됩니다. 정확히 입력해주세요.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">추가 권한</th>
                                <td colspan="3">
                                    <input type="checkbox" name="own_pg" value="y" id="own_pg" <?=get_checked('y',$this->row['own_pg'])?> >
                                    <label for="own_pg">개별 PG 결제 허용</label>
                                    <input type="checkbox" name="own_goods" value="y" id="own_goods" <?=get_checked('y',$this->row['own_goods'])?>> 
                                    <label for="own_goods">개별 상품 판매 허용</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>담당자 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w130">
                                <col>
                                <col class="w130">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">담당자 이름</th>
                                <td><input type="text" name="manager_name" value="<?=$this->row['manager_name']?>" placeholder=""></td>
                                <th scope="row">담당자 전화번호</th>
                                <td><input type="text" name="manager_cellphone" value="<?=$this->row['manager_cellphone']?>"  placeholder=""></td>
                            </tr>
                            <tr>
                                <th scope="row">담당자 메일</th>
                                <td colspan="3"><input type="text" name="manager_email" value="<?=$this->row['manager_email']?>" placeholder=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="infomation" class="tab_content">
                <form name="fregisterForm" action="/Partner/setDefault/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <h2>기본 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">쇼핑몰 도메인</th>
                                <td>https://<input type="text" id="shop_url" name="shop_url" value="<?=$this->def['shop_url']?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">SSO 정보</th>
                                <td>
                                    <input type="checkbox" name="sso_yn" value="y" id="sso_yn" <?=get_checked('y',$this->def['sso_yn'])?>> 
                                    <label for="sso_yn">회원 SSO 연결 사용</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">등급</th>
                                <td>
                                    <select id="grade" name="grade">
                                        <?php foreach($this->gr_li as $idx=>$name){ ?>
                                        <?= get_frm_option( $idx, $this->def['grade'], $name) ;?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>사업자 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="col">사업자 유형</th>
                                <td>
                                    <?php foreach($GLOBALS['company_type'] as $num=>$type){?>
                                    <?=get_frm_radio("company_type",$num,$this->def['company_type'],$type);?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">회사 이름</th>
                                <td><input type="text" name="company_name" class="frm_input"  value="<?=$this->def['company_name']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">대표자 이름</th>
                                <td><input type="text" name="company_owner" class="frm_input"  value="<?=$this->def['company_owner']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">사업자 등록 번호</th>
                                <td><input type="text" name="company_saupja_no" class="frm_input"  value="<?=$this->def['company_saupja_no']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">통신 판매업 신고 번호</th>
                                <td><input type="text" name="company_tolsin_no" class="frm_input"  value="<?=$this->def['company_tolsin_no']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">업태</th>
                                <td><input type="text" name="company_item" class="frm_input"  value="<?=$this->def['company_item']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">종목</th>
                                <td><input type="text" name="company_service" class="frm_input"  value="<?=$this->def['company_service']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">회사 주소</th>
                                <td><input type="text" name="company_addr" class="frm_input"  value="<?=$this->def['company_addr']?>" size=100 ></td>
                            </tr>
                            <tr>
                                <th scope="col">회사 전화 번호</th>
                                <td><input type="text" name="company_tel" class="frm_input"  value="<?=$this->def['company_tel']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">회사 팩스 번호</th>
                                <td><input type="text" name="company_fax" class="frm_input"  value="<?=$this->def['company_fax']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">회사 메일 번호</th>
                                <td><input type="text" name="company_email" class="frm_input"  value="<?=$this->def['company_email']?>" size=60 ></td>
                            </tr>
                            <tr>
                                <th scope="col">정보 책임자</th>
                                <td>
                                    <input type="text" name="info_name" class="frm_input"  value="<?=$this->def['info_name']?>" >
                                    <input type="text" name="info_email" class="frm_input"  value="<?=$this->def['info_email']?>" size=40 >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2 class="mart30">포인트/쿠폰 정책</h2>
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
                                    <?=get_frm_radio("coupon_yn","y",$this->def['coupon_yn'],"사용");?>
                                    <?=get_frm_radio("coupon_yn","n",$this->def['coupon_yn'],"미사용");?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">포인트 사용 여부</th>
                                <td colspan="3">
                                    <?=get_frm_radio("point_yn","y",$this->def['point_yn'],"사용");?>
                                    <?=get_frm_radio("point_yn","n",$this->def['point_yn'],"미사용");?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">최소 결제 포인트</th>
                                <td><input type="text" name="point_use_min" class="frm_input w80 tar" maxlength="7"  value="<?=number_format($this->def['point_use_min'])?>" onkeyup="inputNumberFormat(this)" >point</td>
                                <th scope="col">최대 결제 포인트</th>
                                <td><input type="text" name="point_use_max" class="frm_input w80 tar"  maxlength="8" value="<?=number_format($this->def['point_use_max'])?>" onkeyup="inputNumberFormat(this)" >point</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="design" class="tab_content">
                <form name="flogo" method="post" action="/Partner/setDefault/<?=$this->def['pt_id']?>" enctype="MULTIPART/FORM-DATA">
                    <div class="rhead01_wrap">
                        <h2>메타태그 설정</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="col">브라우저 타이틀</th>
                                <td><input type="text" name="title" value="<?=$this->def['title']?>"></td>
                            </tr>
                            <tr>
                                <th scope="col">Description : 메타태그</th>
                                <td><input type="text" name="description" value="<?=$this->def['description']?>" size="60"></td>
                            </tr>
                            <tr>
                                <th scope="col">HEAD 상단 태그</th>
                                <td><textarea name="head_tag"><?=$this->def['head_tag']?></textarea></td>
                            </tr>
                            <tr>
                                <th scope="col">BODY 하단 태그</th>
                                <td><textarea name="body_tag"><?=$this->def['body_tag']?></textarea></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>테마 스킨 정보</h2>
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
                                    <select name="theme">
                                        <?php foreach(get_dir_list(_ROOT._THEME) as $dir){ console($dir) ?>
                                        <?=get_frm_option($dir,$this->def['theme'])?>
                                        <?php } ?>
                                    </select>
                                </td>
                                <th scope="col">모바일 스킨 테마</th>
                                <td>
                                    <select name="mtheme">
                                        <?php foreach(get_dir_list(_ROOT._THEME) as $dir){ console($dir) ?>
                                        <?=get_frm_option($dir,$this->def['mtheme'])?>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>쇼핑몰 로고</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">대표 로고</th>
                                <td>
                                    <input type="file" name="pc_logo" id="pc_logo">
                                    <input type="checkbox" name="pc_logo_del" value="<?=$this->def['pc_logo']?>" id="pc_logo_del">
                                    <label for="pc_logo_del">삭제</label>
                                    <div class="img_wrap"> <?=get_img( _LOGO.$this->def['pc_logo'] , 160)?> </div>
                                    <span class="info">권장 사이즈 (160px * 60px)</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">모바일 로고</th>
                                <td>
                                    <input type="file" name="mobile_logo" id="mobile_logo">
                                    <input type="checkbox" name="mobile_logo_del" value="<?=$this->def['pc_logo']?>" id="mobile_logo_del">
                                    <label for="mobile_logo_del">삭제</label>
                                    <div class="img_wrap"> <?=get_img( _LOGO.$this->def['mobile_logo'] , 80)?> </div>
                                    <span class="info">권장 사이즈 (450px * 120px)</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">SNS 기본 로고</th>
                                <td>
                                    <input type="file" name="sns_logo" id="sns_logo">
                                    <input type="checkbox" name="sns_logo_del" value="<?=$this->def['pc_logo']?>" id="sns_logo_del">
                                    <label for="sns_logo_del">삭제</label>
                                    <div class="img_wrap"> <?=get_img( _LOGO.$this->def['sns_logo'] , 200)?> </div>
                                    <span class="info">최소 사이즈 (200px * 200px)</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>파비콘 (favicon) 설정</h2>
                        <table class="tablef">
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row" rowspan="2">파비콘 아이콘<br>(ico파일)</th>
                                <td>
                                    <input type="file" name="favicon" id="favicon">
                                    <input type="checkbox" name="favicon_del" value="1" id="favicon_logo_del">
                                    <label for="favicon_del">삭제</label>
                                    <div class="img_wrap"> <?=get_img( _LOGO.$this->def['favicon'] , 25)?> </div>
                                    <span class="info">고정 사이즈 (16px * 16px)</span>
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
                        <input type="submit" value="저장" class="btn_medium btn_black" accesskey="s">
                    </div>
                </form>
            </div>
            <div id="category" class="tab_content">
                <form name="fpartnerForm" action="/Partner/setDefault/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <h2>카테고리 설정</h2>
                        <table>
                            <colgroup>
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <td>    
                                    <ul>
                                        <?php  foreach($this->category->getDepthList(1,'') as $d1){   
        $flag=false;
                    foreach($this->def['use_ctg'] as $k => $val){
    if(preg_match("/^".$d1['code']."/", $val)) {
        $flag=true;
    }
}
                                    ?>
                                        <li class="dep1li pointer">
                                        <input type="checkbox" class="dep1" name="use_ctg1[]" value="<?=$d1['code']?>" <?=$flag?'checked':''?>>
                                        <span><?=$d1['title']?></span>
                                        <ul class="dep2li dn">
                                            <?php  foreach($this->category->getDepthList(2,$d1['code']) as $d2){ $d2['use_pt'] = unserialize($d2['use_pt'])  ?>
                                            <li class="marl20 pointer">
                                                <input type="checkbox" class="dep2" name="use_ctg2[]" value="<?=$d2['code']?>" <?=in_array($d2['code'],$this->def['use_ctg'])?'checked':''?>>
                                                <span><?=$d2['title']?></span>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="sso" class="tab_content">
                <form name="fpartnerForm" action="/Partner/setDefault/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <h2>DB 연동 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">SSO 연동</th>
                                <td>
                                    <input type="checkbox" name="sso_use" value="1" id="sso_use">
                                    <label for="sso_use">사용함</label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>연동 관련 정보</h2>
                        <div class="info"><p>※SSO연동을 진행하는 경우, 반드시 입력해야하는 정보입니다.</p></div>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">전송 방식</th>
                                <td>
                                    <select>    
                                        <?= get_frm_option("1",$this->def['sso_use'],"NONE");?>
                                        <?= get_frm_option("1",$this->def['sso_use'],"GET");?>
                                        <?= get_frm_option("1",$this->def['sso_use'],"POST");?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">IV</th>
                                <td><input type="text" name="sso_use"></td>
                            </tr>
                            <tr>
                                <th scope="row">KEY</th>
                                <td><input type="text" name="sso_use"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>소셜 로그인 정보</h2>
                        <div class="info"><p>※SSO연동을 진행하지 않는 경우에만 설정가능합니다. </p></div>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="row">소셜 로그인</th>
                                <td>
                                    <input type="checkbox" name="sso_use" value="1" id="sso_use">
                                    <label for="sso_use"> 사용함</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">네이버 Client ID</th>
                                <td>
                                    <input type="text" name="sso_use">
                                    <div class="info"><p>앱설정시 Callback URL에 http://도메인주소/plugin/login-oauth/login_with_naver.php 입력</p></div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">네이버 Client Secret</th>
                                <td><input type="text" name="sso_use"></td>
                            </tr>
                            <tr>
                                <th scope="row">카카오 REST API Key</th>
                                <td>
                                    <input type="text" name="sso_use">
                                    <div class="info"><p>카카오 사이트 설정에서 플랫폼 > Redirect Path에 /plugin/login-oauth/login_with_kakao.php 라고 입력</p></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black" accesskey="s">
                    </div>
                </form>
            </div>
            <div id="pg" class="tab_content">
                <form name="fpartnerForm" action="/Partner/setDefault/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <h2>전자 결제(PG) 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="col">결제 수단</th>
                                <td>
                                    <?php foreach($GLOBALS['paymethod'] as $name=>$label){?>
                                    <input type="checkbox" name="<?=$name?>" class="frm_input" value="y" id="<?=$name?>" <?=get_checked("y",$this->def[$name])?>> 
                                    <label for="<?=$name?>"> <?=$label?></label>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">결제 테스트</th>
                                <td>
                                    <?=get_frm_radio('test_pay','1',$this->def['test_pay'],'테스트결제')?>
                                    <?=get_frm_radio('test_pay','0',$this->def['test_pay'],'실결제')?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">결제 대행사</th>
                                <td>
                                    <select name="pg_service">
                                        <?=get_frm_option('inicis',$this->def['pg_service'],'KG 이니시스');?>
                                        <?=get_frm_option('kcp',$this->def['pg_service'],'NHN KCP');?>
                                        <?=get_frm_option('toss',$this->def['pg_service'],'토스페이먼트');?>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <h2>결제 대행사 계약정보</h2>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th scope="col">상점 아이디</th>
                                <td>
                                    <input type="text" name="pg_mid" class="frm_input"  value="<?=$this->def['pg_mid']?>" size=60 >
                                    <p class="pg inicis info">KG이니시스로 부터 발급 받으신 상점아이디(MID)를 입력해 주십시오.</p>
                                    <p class="pg kcp info">NHN KCP에서 발급받으신 사이트코드를 입력해 주세요.</p>
                                    <p class="pg toss info">LG유플러스 상점아이디를 입력해 주세요.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">SECRET KEY 1</th>
                                <td>
                                    <input type="text" name="pg_key" class="frm_input"  value="<?=$this->def['pg_key']?>" size=60 >
                                    <p class="pg inicis info">KG이니시스에서 발급받은 웹결제 사인키를 입력합니다.<br>관리자 페이지의 상점정보 > 계약정보 > 부가정보의 웹결제 signkey생성 조회 버튼 클릭, 팝업창에서 생성 버튼 클릭 후 해당 값을 입력합니다.</p>
                                    <p class="pg kcp info">25자리 영대소문자와 숫자 - 그리고 _ 로 이루어 집니다. SITE KEY 발급 NHN KCP 전화: 1544-8660<br>예) 1Q9YRV83gz6TukH8PjH0xFf__</p>
                                    <p class="pg toss info">상점MertKey는 LG유플러스 상점관리자 <strong>[계약정보 &gt; 상점정보관리 &gt; 시스템연동정보]</strong>에서 확인하실 수 있습니다.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">SECRET KEY 2</th>
                                <td>
                                    <input type="text" name="pg_key" class="frm_input"  value="<?=$this->def['pg_sign_key']?>" size=60 >
                                    <p class="pg inicis info">KG이니시스에서 발급받은 4자리 상점 키패스워드를 입력합니다.<br>KG이니시스 상점관리자 패스워드와 관련이 없습니다.<br>키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">가상계좌 입금통보 URL</th>
                                <td>
                                    <p class="info">위 주소를 결제 대행사 관리자 페이지에 등록/입력하셔야 자동으로 입금이 통보됩니다.</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <input type="submit" value="저장" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
$(function() {
    $('.dep1li').click(function(){
        $('.dep2li').css('display','none');
        $(this).children('.dep2li').css('display','block');
    });

    $('.dep1').click(function(){
        if( $(this).prop('checked') ){
            console.log('asd');
            $(this).nextAll('.dep2li').find('.dep2').prop('checked',true);
        }else{
            $(this).next('.dep2li').find('.dep2').prop('checked',false);
        }
    });

    $('.dep2').click(function(){
        if( $(this).prop('checked') ){
            $(this).closest('.dep1li').children('.dep1').prop('checked',true);
        }
    });


    $(".tab_content").hide(); 
    $("ul.tabs li:first").addClass("active").show(); 
    $(".tab_content:first").show(); 
    $("#pg_tit").html ( $("ul.tabs li:first").children("a").html()) ;

    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active"); 
        $(this).addClass("active"); 
        $(".tab_content").hide(); 

        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn("fast");

        $("#pg_tit").html ( $(this).children("a").html() );
        return false;
    });

});
</script>
