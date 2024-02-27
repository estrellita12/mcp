<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
    <form action="/Setting/setDefault" method="POST">
        <div class="rhead01_wrap">
            <div class="h2">전자 결제(PG) 정보</div>
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
                            <?=get_frm_chkbox($name,"y",$this->row["shop_paymethod_".$name."_yn"],$label)?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">결제 테스트</th>
                        <td>
                            <?=get_frm_radio('pgTest','y',$this->row['shop_pg_test_yn'],'테스트결제')?>
                            <?=get_frm_radio('pgTest','n',$this->row['shop_pg_test_yn'],'실결제')?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">결제 대행사</th>
                        <td>
                            <select name="pgService">
                                <?=get_frm_option('inicis',$this->row['shop_pg_service'],'KG 이니시스');?>
                                <?=get_frm_option('kcp',$this->row['shop_pg_service'],'NHN KCP');?>
                                <?=get_frm_option('toss',$this->row['shop_pg_service'],'토스페이먼트');?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="rhead01_wrap">
            <div class="h2">결제 대행사 계약정보</div>
            <table class="pg inicis">
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="col">KG이니시스 상점 아이디</th>
                        <td>
                            <input type="text" name="pgMid" value="<?=$this->row['shop_pg_mid']?>" size=60 >
                            <p class="info">KG이니시스로 부터 발급 받으신 상점아이디(MID)를 입력해 주십시오.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">KG이니시스 웹결제 사인키</th>
                        <td>
                            <input type="text" name="pgKey1"  value="<?=$this->row['shop_pg_key1']?>" size=60 >
                            <p class="info">
                            KG이니시스에서 발급받은 웹결제 사인키를 입력합니다.<br>
                            관리자 페이지의 상점정보 > 계약정보 > 부가정보의 웹결제 signkey생성 조회 버튼 클릭, 
                            팝업창에서 생성 버튼 클릭 후 해당 값을 입력합니다.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">가상계좌 입금통보 URL</th>
                        <td>
                            <p class="info">
                            http://majorworld.shop/api/inicis/vbank<br>
                            위 주소를 KG이니시스 관리자 > 거래조회 > 가상계좌 > 입금통보방식선택 > URL 수신 설정에 입력하셔야 자동으로 입금 통보됩니다.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="pg kcp">
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="col">NHN KCP SITE CODE</th>
                        <td>
                            <input type="text" name="pgMid"  value="<?=$this->row['shop_pg_mid']?>" size=60 >
                            <p class="info">NHN KCP에서 발급받으신 사이트코드를 입력해 주세요.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">NHN KCP SITE KEY</th>
                        <td>
                            <input type="text" name="pgKey1" value="<?=$this->row['shop_pg_key1']?>" size=60 >
                            <p class="info">
                            25자리 영대소문자와 숫자 - 그리고 _ 로 이루어 집니다. SITE KEY 발급 NHN KCP 전화: 1544-8660<br>
                            예) 1Q9YRV83gz6TukH8PjH0xFf__
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">가상계좌 입금통보 URL</th>
                        <td>
                            <p class="info">
                            http://majorworld.shop/api/kcp/vbank<br>
                            위 주소를 NHN KCP 관리자 > 상점정보관리 > 정보변경 > 공통URL 정보 > 공통URL 변경후에 입력하셔야 자동으로 입금 통보됩니다.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="pg toss">
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="col">토스페이먼츠 상점 아이디</th>
                        <td>
                            <input type="text" name="pgMid" value="<?=$this->row['shop_pg_mid']?>" size=60 >
                            <p class="info">토스페이먼츠에서 받은 si_로 시작하는 상점 ID를 입력하세요.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">토스페이먼츠 MERT KEY</th>
                        <td>
                            <input type="text" name="pgKey1" value="<?=$this->row['shop_pg_key1']?>" size=60 >
                            <p class="info">
                            토스페이먼츠 상점 MertKey는 상점관리자 → 계약정보 → 상점정보관리에서 확인할 수 있습니다.<br>
                            예) 95160cce09854ef44d2edb2bfb05f9f3
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">토스페이먼츠 MERT KEY</th>
                        <td>
                            <input type="text" name="pgKey2" value="<?=$this->row['shop_pg_key2']?>" size=60 >
                            <p class="info">
                            토스페이먼츠 상점 MertKey는 상점관리자 → 계약정보 → 상점정보관리에서 확인할 수 있습니다.<br>
                            예) test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="col">가상계좌 입금통보 URL</th>
                        <td>
                            <p class="info">
                            http://majorworld.shop/api/kcp/vbank<br>
                            위 주소를 결제 대행사 관리자 페이지에 입력하셔야 자동으로 입금 통보됩니다.
                            </p>
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
<script>
    $(function(){
        let chk = ".<?=empty($this->row['shop_pg_service'])?'inicis':$this->row['shop_pg_service']?>";
        $(".pg").hide();
        $(".pg input").attr("disabled", true);
        $(chk).show();
        $(chk+" input").attr("disabled", false);

        $("select[name=pgService]").change(function(){
            chk = "."+this.value;
            $(".pg").hide();
            $(".pg input").attr("disabled", true);
            $(chk).show();
            $(chk+" input").attr("disabled", false);
        });
    });
</script>
