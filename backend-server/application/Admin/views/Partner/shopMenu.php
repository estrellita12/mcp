<div id="popupContents">
    <section class="cont_inner">
        <p class="pg_tit" id="pg_tit">가맹점 정보</p>
        <ul class="tabs">
            <li><a tabs="#design">쇼핑몰 디자인</a></li>
            <li><a tabs="#category">노출 카테고리</a></li>
            <li><a tabs="#menu">쇼핑몰 메뉴</a></li>
            <li><a tabs="#layout">쇼핑몰 레이아웃</a></li>
        </ul>
        <div class="tab_container">
            <div id="design" class="tab_content">
                <form name="flogo" method="post" action="/Partner/set/<?=$this->param['ident']?>" enctype="MULTIPART/FORM-DATA">
                    <div class="rhead01_wrap">
                        <div class="h2">쇼핑몰 디자인</div>
                        <table>
                            <colgroup>
                                <col class="w150">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th scope="row">쇼핑몰 도메인</th>
                                    <td>https://<input type="text" name="url" value="<?=$this->row['shop_url']?>"></td>
                                </tr>
                                <tr>
                                    <th scope="col">브라우저 타이틀</th>
                                    <td><input type="text" name="title" value="<?=$this->row['shop_title']?>" size="40"></td>
                                </tr>
                                <tr>
                                    <th scope="col">Description : 메타태그</th>
                                    <td><input type="text" name="description" value="<?=$this->row['shop_description']?>" size="60"></td>
                                </tr>
                                <tr>
                                    <th scope="col">HEAD 상단 태그</th>
                                    <td><textarea name="headTag"><?=$this->row['shop_head_tag']?></textarea></td>
                                </tr>
                                <tr>
                                    <th scope="col">BODY 하단 태그</th>
                                    <td><textarea name="bodyTag"><?=$this->row['shop_body_tag']?></textarea></td>
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
                                            <?=get_frm_option($theme,$this->row['shop_pc_theme'])?>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <th scope="col">모바일 스킨 테마</th>
                                    <td>
                                        <select name="mtheme">
                                            <?php foreach($GLOBALS['mtheme'] as $theme){?>
                                            <?=get_frm_option($theme,$this->row['shop_m_theme'])?>
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
                                    <th scope="row">대표 로고</th>
                                    <td>
                                        <input type="file" name="pclogo" id="pclogo">
                                        <input type="checkbox" name="pclogo_del" value="<?=$this->row['shop_pc_logo']?>" id="pclogo_del">
                                        <label for="pclogo_del">삭제</label>
                                        <div class="img_wrap"> <?=get_img( _LOGO.$this->row['shop_pc_logo'] , $this->config['cf_pc_logo_size_w'])?> </div>
                                        <span class="info">권장 사이즈 (<?=$this->config['cf_pc_logo_size_w']?>px * <?=$this->config['cf_pc_logo_size_h']?>px)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">모바일 로고</th>
                                    <td>
                                        <input type="file" name="mlogo" id="mlogo">
                                        <input type="checkbox" name="mlogo_del" value="<?=$this->row['shop_m_logo']?>" id="mlogo_del">
                                        <label for="mlogo_del">삭제</label>
                                        <div class="img_wrap"> <?=get_img( _LOGO.$this->row['shop_m_logo'] ,  $this->config['cf_m_logo_size_w'])?> </div>
                                        <span class="info">권장 사이즈 (<?=$this->config['cf_m_logo_size_w']?>px * <?=$this->config['cf_m_logo_size_h']?>px)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">SNS 기본 로고</th>
                                    <td>
                                        <input type="file" name="snslogo" id="snslogo">
                                        <input type="checkbox" name="snslogo_del" value="<?=$this->row['shop_sns_logo']?>" id="snslogo_del">
                                        <label for="snslogo_del">삭제</label>
                                        <div class="img_wrap"> <?=get_img( _LOGO.$this->row['shop_sns_logo'] , 200)?> </div>
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
                                    <th scope="row" rowspan="2">파비콘 아이콘<br>(ico파일)</th>
                                    <td>
                                        <input type="file" name="fav" id="fav">
                                        <input type="checkbox" name="fav_del" value="1" id="fav_logo_del">
                                        <label for="fav_del">삭제</label>
                                        <div class="img_wrap"> <?=get_img( _LOGO.$this->row['shop_favicon'] , $this->config['cf_favicon_size_w'])?> </div>
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
                        <input type="submit" value="수정" class="btn_medium btn_black" accesskey="s">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="menu" class="tab_content">
                <form name="" method="post" action="/Partner/setMenu/<?=$this->param['ident']?>">
                    <input type="hidden" name="mode" value="<?=$this->row['shop_default_menu_mode']?>">
                    <input type="hidden" name="id" value="<?=$this->param['ident']?>">
                    <div class="rhead01_wrap">
                        <div class="h2">쇼핑몰 메뉴 관리</div>
                        <p class="info">상품 리스트 변경은 저장 버튼을 클릭한 뒤 가능합니다. (메뉴2,메뉴3,메뉴4)만 상품 리스트 변경이 가능하며, (메뉴1,메뉴5)는 해당 영역에 맞게 자동진열됩니다.</p>
                        <table>
                            <colgroup>
                                <col class="w60">
                                <col class="w150">
                                <col class="w200">
                                <col class="w200">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">메뉴</th>
                                    <th scope="col">메뉴명</th>
                                    <th scope="col">메뉴URL</th>
                                    <th scope="col">상품 리스트</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i=1;$i<=9;$i++){ ?>
                                <tr>
                                    <td>메뉴<?=$i?></td>
                                    <td><input type="text" name="menu_<?=$i?>_title" value='<?=$this->row['shop_default_menu']["menu_{$i}_title"]?>' size=20 placeholder="이름"></td>
                                    <td><input type="text" name="menu_<?=$i?>_url" value='<?=$this->row['shop_default_menu']["menu_{$i}_url"]?>' size=30 readonly class="readonly"></td>
                                    <td>
                                        <?php if($this->row['shop_default_menu_mode']=="modify" && $i>=2 && $i<=4){ ?>
                                        <a href="/Partner/menuPopup/<?=$this->param['ident']?>/<?=$i?>" onclick="winOpen(this,'win','1200','750','yes');return false;" >상품 리스트</a>
                                        <?php }else{ ?>
                                        상품 리스트 (수정 권한 없음)
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <?php if($this->row['shop_default_menu_mode']=="modify"){ ?>
                        <a href="/Partner/removeMenu/<?=$this->param['ident']?>" class="btn_medium btn_gray">삭제(본사 설정 반영)</a>
                        <?php } ?>
                        <input type="submit" value="수정" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="layout" class="tab_content">
                <form name="flogo" method="post" action="/Partner/setLayout/<?=$this->param['ident']?>" onsubmit="return frmExample()">
                    <div class="rhead01_wrap">
                        <div class="h2">쇼핑몰 GNB 관리</div>
                        <p class="info">
                        기본메뉴(왼쪽)는 쇼핑몰 메뉴 탭에서 변경 가능합니다.<br>
                        쇼핑몰 GNB 영역에 노출하고자 하는 메뉴를 드래그하여 원하는 순서대로 오른쪽에 배치하시면 됩니다.
                        </p>
                        <table>
                            <colgroup>
                                <col class="w200">
                                <col class="w200">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">기본 메뉴</th>
                                    <th scope="col"><span class="tooltip">GNB 설정 메뉴<span class="tooltiptext">지정된 순서대로 GNB 영역에 노출 됩니다.</span></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top" rowspan="2">
                                        <table>
                                            <colgroup>
                                                <col class="w120">
                                                <col class="w200">
                                            </colgroup>
                                            <tbody id="gnb_sortable_example" class="gnb example_print">
                                                <?php for($i=1;$i<=9;$i++){ ?>
                                                <?php if( in_array( $this->row['shop_default_menu']["menu_{$i}_url"] , $this->row['shop_gnb'] ) ) continue; ?>
                                                <tr class="ui-state-default">
                                                    <td><input type="text" name="gnbTitle[]" value='<?=$this->row['shop_default_menu']["menu_{$i}_title"]?>' size=15 placeholder="이름"></td>
                                                    <td><input type="text" name="gnbUrl[]" value='<?=$this->row['shop_default_menu']["menu_{$i}_url"]?>' size=25 readonly class="readonly"></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="vertical-align:top">
                                        <table>
                                            <colgroup>
                                                <col class="w120">
                                                <col class="w200">
                                            </colgroup>
                                            <tbody id="gnb_sortable" class="gnb">
                                                <?php foreach($this->row['shop_gnb'] as $gnb_title=>$gnb_value){ ?>
                                                <tr class="ui-state-default">
                                                    <td>
                                                        <input type="text" name="gnbTitle[]" value='<?=$gnb_title?>' size=15 placeholder="이름">
                                                    </td>
                                                    <td><input type="text" name="gnbUrl[]" value='<?=$gnb_value?>' size=25 readonly class="readonly"></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tac"> <button type="button" onclick="gnbAdd()" class="btn btn_small btn_red">추가</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="rhead01_wrap">
                        <div class="h2">쇼핑몰 메인 진열 관리</div>
                        <p class="info">
                        기본메뉴(왼쪽)는 쇼핑몰 메뉴 탭에서 변경 가능합니다.<br>
                        쇼핑몰 메인 페이지 노출하고자 하는 메뉴를 드래그하여 원하는 순서대로 오른쪽에 배치하시면 됩니다.
                        </p>
                        <table>
                            <colgroup>
                                <col class="w200">
                                <col class="w200">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">기본 메뉴</th>
                                    <th scope="col"><span class="tooltip">메인 레이아웃 설정 메뉴<span class="tooltiptext">지정된 순서대로 메인 페이지에 노출 됩니다.</span></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="vertical-align:top" rowspan="2">
                                        <table>
                                            <colgroup>
                                                <col class="w120">
                                                <col class="w200">
                                            </colgroup>
                                            <tbody id="main_sortable_example" class="main example_print">
                                                <?php for($i=1;$i<=9;$i++){ ?>
                                                <?php if( in_array( $this->row['shop_default_menu']["menu_{$i}_url"] , $this->row['shop_main_layout'] ) ) continue; ?>
                                                <tr class="ui-state-default">
                                                    <td><input type="text" name="mainLayoutTitle[]" value='<?=$this->row['shop_default_menu']["menu_{$i}_title"]?>' size=15 placeholder="이름"></td>
                                                    <td>
                                                        <input type="text" name="mainLayoutUrl[]" value='<?=$this->row['shop_default_menu']["menu_{$i}_url"]?>' size=25 readonly class="readonly">
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="vertical-align:top">
                                        <table>
                                            <colgroup>
                                                <col class="w120">
                                                <col class="w200">
                                            </colgroup>
                                            <tbody id="main_sortable" class="main">
                                                <?php foreach($this->row['shop_main_layout'] as $main_title=>$main_value){ ?>
                                                <tr class="ui-state-default">
                                                    <td>
                                                        <input type="text" name="mainLayoutTitle[]" value='<?=$main_title?>' size=15 placeholder="이름">
                                                    </td>
                                                    <td><input type="text" name="mainLayoutUrl[]" value='<?=$main_value?>' size=25 readonly class="readonly"></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tac"> <button type="button" onclick="mainAdd()" class="btn btn_small btn_red">추가</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="confirm_wrap">
                        <?php if($this->row['shop_default_layout_mode']=="modify"){ ?>
                        <a href="/Partner/resetLayout/<?=$this->param['ident']?>" class="btn_medium btn_gray">삭제(본사 설정 반영)</a>
                        <?php } ?>
                        <input type="submit" value="수정" class="btn_medium btn_black">
                        <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                    </div>
                </form>
            </div>
            <div id="category" class="tab_content">
                <form name="fpartnerForm" action="/Partner/set/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <div class="h2">카테고리 설정</div>
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
                                            foreach($this->row['shop_use_ctg'] as $k => $val){
                                            if(preg_match("/^".$d1['ctg_id']."/", $val)) $flag=true;
                                            }
                                            ?>
                                            <li class="dep1li pointer">
                                            <input type="checkbox" class="dep1" name="ctg1[]" value="<?=$d1['ctg_id']?>" <?=$flag?'checked':''?>>
                                            <span><?=$d1['ctg_title']?></span>
                                            <ul class="dep2li dn">
                                                <?php  foreach($this->category->getDepthList(2,$d1['ctg_id']) as $d2){  ?>
                                                <li class="marl20 pointer">
                                                <input type="checkbox" class="dep2" name="ctg2[]" value="<?=$d2['ctg_id']?>" <?=in_array($d2['ctg_id'],$this->row['shop_use_ctg'])?'checked':''?>>
                                                <span><?=$d2['ctg_title']?></span>
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
                        <input type="submit" value="수정" class="btn_medium btn_black">
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

            //var activeTab = $(this).find("a").attr("href");
            var activeTab = $(this).find("a").attr("tabs");
            $(activeTab).fadeIn("fast");

            $("#pg_tit").html ( $(this).children("a").html() );
            return false;
        });

        $( "#gnb_sortable, #gnb_sortable_example" ).sortable({
            connectWith: ".gnb"
        }).disableSelection();

        $( "#main_sortable, #main_sortable_example" ).sortable({
            connectWith: ".main"
        }).disableSelection();

    });

    function frmExample(){
        $(".example_print input").attr("disabled","disabled");
    }

    function gnbAdd(){
        $("#gnb_sortable").append('<tr class="ui-state-default"><td><input type="text" name="gnbTitle[]" size=15 placeholder="이름"></td><td><input type="text" name="gnbUrl[]" size=25 placeholder="연결 링크 주소"></td></tr>');
    }

    function mainAdd(){
        $("#main_sortable").append('<tr class="ui-state-default"><td><input type="text" name="mainLayoutTitle[]" size=15 placeholder="이름"></td><td><input type="text" name="mainLayoutUrl[]" size=25 placeholder="연결 링크 주소"></td></tr>');
    }


</script>

