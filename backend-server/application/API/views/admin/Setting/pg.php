<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?> </h1>
        <form action="/Setting/setDefault" method="POST" onsubmit="fSubmit(this);">
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
                            <input type="checkbox" name="<?=$name?>" class="frm_input" value="y" id="<?=$name?>" <?=get_checked("y",$this->row[$name])?>> 
                            <label for="<?=$name?>"> <?=$label?></label>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">결제 테스트</th>
                        <td>
                            <?=get_frm_radio('test_pay','1',$this->row['test_pay'],'테스트결제')?>
                            <?=get_frm_radio('test_pay','0',$this->row['test_pay'],'실결제')?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">결제 대행사</th>
                        <td>
                            <select name="pg_service">
                                <?=get_frm_option('inicis',$this->row['pg_service'],'KG 이니시스');?>
                                <?=get_frm_option('kcp',$this->row['pg_service'],'NHN KCP');?>
                                <?=get_frm_option('toss',$this->row['pg_service'],'토스페이먼트');?>
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
                            <input type="text" name="pg_mid" class="frm_input"  value="<?=$this->row['pg_mid']?>" size=60 >
                            <p class="pg inicis info">KG이니시스로 부터 발급 받으신 상점아이디(MID)를 입력해 주십시오.</p>
                            <p class="pg kcp info">NHN KCP에서 발급받으신 사이트코드를 입력해 주세요.</p>
                            <p class="pg toss info">LG유플러스 상점아이디를 입력해 주세요.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">SECRET KEY 1</th>
                        <td>
                            <input type="text" name="pg_key" class="frm_input"  value="<?=$this->row['pg_key']?>" size=60 >
                            <p class="pg inicis info">KG이니시스에서 발급받은 웹결제 사인키를 입력합니다.<br>관리자 페이지의 상점정보 > 계약정보 > 부가정보의 웹결제 signkey생성 조회 버튼 클릭, 팝업창에서 생성 버튼 클릭 후 해당 값을 입력합니다.</p>
                            <p class="pg kcp info">25자리 영대소문자와 숫자 - 그리고 _ 로 이루어 집니다. SITE KEY 발급 NHN KCP 전화: 1544-8660<br>예) 1Q9YRV83gz6TukH8PjH0xFf__</p>
                            <p class="pg toss info">상점MertKey는 LG유플러스 상점관리자 <strong>[계약정보 &gt; 상점정보관리 &gt; 시스템연동정보]</strong>에서 확인하실 수 있습니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">SECRET KEY 2</th>
                        <td>
                            <input type="text" name="pg_key" class="frm_input"  value="<?=$this->row['pg_sign_key']?>" size=60 >
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
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </section>
</div>
<script>
    function fSubmit(obj){ }   

    $("select[name=pg_service]").change(function(){
        $(".pg").show();
        $(".pg").not("."+$(this).val() ).hide();
    });

    $(function(){
        $(".pg").not(".pg.<?=$this->row['pg_service']?>").hide();
    });

</script>
