<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$this->menu->getName( _SCRIPT_URL );?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$this->menu->getName( _SCRIPT_URL );?></h1>
        <form name="flogo" method="post" action="/Partner/logoUpdate" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="token" value="">
            <div class="rhead01_wrap">
                <h2>쇼핑몰 로고</h2>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">대표 로고</th>
                        <td>
                            <input type="file" name="pc_logo" id="pc_logo">
                            <input type="checkbox" name="pc_logo_del" value="1" id="pc_logo_del">
                            <label for="pc_logo_del">삭제 </label>
                            <div class="img_wrap">
                                <?php if(  $this->row['pc_logo_file'] !="" && file_exists("public/data/logo/".$this->row['pc_logo_file']) ){ ?>
                                <img src="<?=_LOGO.$this->row['pc_logo_file']?>">
                                <?php } ?>
                            </div>
                            <span class="info">권장 사이즈 (160px * 60px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">모바일 로고</th>
                        <td>
                            <input type="file" name="mobile_logo" id="mobile_logo">
                            <input type="checkbox" name="mobile_logo_del" value="1" id="mobile_logo_del">
                            <label for="mobile_logo_del">삭제
                            </label>
                            <div class="img_wrap">
                                <?php if( $this->row['mobile_logo_file'] !="" && file_exists("public/data/logo/".$this->row['mobile_logo_file']) ){ ?>
                                <img src="<?=_LOGO.$this->row['mobile_logo_file']?>">
                                <?php } ?>
                            </div>
                            <span class="info">권장 사이즈 (450px * 120px)</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">SNS 기본 로고</th>
                        <td>
                            <input type="file" name="sns_logo" id="sns_logo">
                            <input type="checkbox" name="sns_logo_del" value="1" id="sns_logo_del">
                            <label for="sns_logo_del">삭제</label>
                            <div class="img_wrap">
                                <?php if( $this->row['sns_logo_file'] !="" && file_exists("public/data/logo/".$this->row['sns_logo_file']) ){ ?>
                                <img src="<?=_LOGO.$this->row['sns_logo_file']?>">
                                <?php } ?>
                            </div>
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
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row" rowspan="2">파비콘 아이콘<br>(ico파일)</th>
                        <td>
                            <input type="file" name="favicon_file" id="favicon_file">
                            <input type="checkbox" name="favicon_file_del" value="1" id="favicon_logo_del">
                            <label for="favicon_file_del">삭제</label>
                            <div class="img_wrap">
                                <?php if(  $this->row['favicon_file'] !="" && file_exists("public/data/logo/".$this->row['favicon_file']) ){ ?>
                                <img src="<?=_LOGO.$this->row['favicon_file']?>">
                                <?php } ?>
                            </div>
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
    </section>
</div>
<script>
$(function(){            
        var now = new Date();
        var year = now.getFullYear();
        var mon = (now.getMonth() + 1) > 9 ? ''+(now.getMonth() + 1) : '0'+(now.getMonth() + 1); 
        var day = (now.getDate()) > 9 ? ''+(now.getDate()) : '0'+(now.getDate());           
        //년도 selectbox만들기               
        for(var i = 1900 ; i <= year ; i++) {
        $('#year').append('<option value="' + i + '">' + i + '년</option>');    
        }

        // 월별 selectbox 만들기            
        for(var i=1; i <= 12; i++) {
        var mm = i > 9 ? i : "0"+i ;            
        $('#month').append('<option value="' + mm + '">' + mm + '월</option>');    
        }

        // 일별 selectbox 만들기
        for(var i=1; i <= 31; i++) {
        var dd = i > 9 ? i : "0"+i ;            
        $('#day').append('<option value="' + dd + '">' + dd+ '일</option>');    
        }
        $("#year  > option[value="+year+"]").attr("selected", "true");        
        $("#month  > option[value="+mon+"]").attr("selected", "true");    
        $("#day  > option[value="+day+"]").attr("selected", "true");       

})

</script>
