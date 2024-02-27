<section class="contents">
    <h1 class="cont_title">쇼핑몰 GNB</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="flogo" method="post" action="/Partner/setGnb/<?=$this->param['ident']?>" onsubmit="return frmSubmit()">
            <div class="rhead01_wrap">
                <div class="h2">쇼핑몰 GNB 관리</div>
                <p class="info">쇼핑몰 GNB 영역에 노출하고자 하는 메뉴를 드래그하여 원하는 순서대로 오른쪽에 배치하시면 됩니다.</p>
                <div class="info">레이아웃을 별도로 설정하지 않으면 본사 설정을 따라가게 됩니다.<br>수정버튼을 클릭하면 <b>별도의 레이아웃</b>가 생성되고, 삭제버튼을 클릭하면 <b>별도의 레이아웃</b>이 삭제됩니다.</div>
                <table>
                    <colgroup>
                        <col class="w200">
                        <col class="w200">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">쇼핑몰 메뉴</th>
                            <th scope="col"><span class="tooltip">GNB 설정 메뉴<span class="tooltiptext">지정된 순서대로 GNB 영역에 노출 됩니다.</span></span></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="vat" rowspan="2">
                            <table>
                                <colgroup>
                                    <col class="w150">
                                    <col>
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col" class="bg_light_yellow">제목</th>
                                        <th scope="col" class="bg_light_yellow">URL</th>
                                    </tr>
                                </thead>


                                <tbody id="gnb_sortable_example" class="example_print gnb">
                                <?php for($i=1;$i<=9;$i++){ ?>
                                <?php if( in_array( $this->row['shop_default_menu']["menu_{$i}_url"] , $this->row['shop_gnb'] ) ) continue; ?>
                                <tr>
                                    <td>
                                        <input type="text" name="gnbTitle[]" value="<?=stripslashes($this->row['shop_default_menu']["menu_{$i}_title"])?>"  class="w100p">
                                    </td>
                                    <td>
                                        <input type="text" name="gnbUrl[]" value="<?=$this->row['shop_default_menu']["menu_{$i}_url"]?>" class="w100p" readonly>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </td>

                        <td class="vat">
                            <table>
                                <colgroup>
                                    <col class="w150">
                                    <col>
                                </colgroup>

                                <thead>
                                    <tr>
                                        <th scope="col" class="bg_light_yellow">제목</th>
                                        <th scope="col" class="bg_light_yellow">URL</th>
                                    </tr>
                                </thead>
                                <tbody id="gnb_sortable" class="gnb" style="height:50px;">
                                <?php foreach($this->row['shop_gnb'] as $gnb){ ?>
                                <tr>
                                    <td>
                                        <input type="text" name="gnbTitle[]" value="<?=stripslashes($gnb['title'])?>" class="w100p">
                                    </td>
                                    <td>
                                        <input type="text" name="gnbUrl[]" value="<?=$gnb['url']?>"  class="w100p">
                                    </td>
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
            <div class="confirm_wrap">
                <?php if($this->row['shop_default_layout_mode']=="modify"){ ?>
                <a href="/Partner/resetLayout/<?=$this->param['ident']?>" class="btn_medium btn_gray">삭제(본사 설정 반영)</a>
                <?php } ?>
                <input type="submit" value="수정" class="btn_medium btn_theme">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
<script>
$(function() {

        $( "#gnb_sortable, #gnb_sortable_example" ).sortable({
connectWith: ".gnb"
}).disableSelection();

        });

function gnbAdd(){
    var str = "<tr>";
    str += "<td><input type=\"text\" name=\"gnbTitle[]\" placeholder=\"이름\" class=\"w100p\"></td>";
    str += "<td><input type=\"text\" name=\"gnbUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\"></td>";
    str += "<td><input type=\"text\" name=\"gnbApiUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\"></td>";
    str += "</tr>";
    $("#gnb_sortable").append(str);
}


function frmSubmit(){
    $(".example_print input").attr("disabled","disabled");
}
</script>

