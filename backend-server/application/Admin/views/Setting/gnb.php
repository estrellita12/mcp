<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabInfo['name']?></h1>
    <form action="/Setting/setLayout" method="POST" onsubmit="return frmExample()">
        <div class="rhead01_wrap">
            <div class="h2">PC GNB 관리</div>
            <p class="info">쇼핑몰 GNB 영역에 노출하고자 하는 메뉴를 드래그하여 원하는 순서대로 오른쪽에 배치하시면 됩니다.</p>
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
        <!--
        <div class="rhead01_wrap">
            <div class="h2">모바일 GNB 관리</div>
            <p class="info">쇼핑몰 GNB 영역에 노출하고자 하는 메뉴를 드래그하여 원하는 순서대로 오른쪽에 배치하시면 됩니다.</p>
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
                                <tbody id="mgnb_sortable_example" class="example_print mgnb">
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
                                <tbody id="mgnb_sortable" class="mgnb" style="height:50px;">
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
                        <td class="tac"> <button type="button" onclick="mGnbAdd()" class="btn btn_small btn_red">추가</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        -->
        <div class="confirm_wrap">
            <input type="submit" value="저장" id="btn_submit" class="btn btn_large btn_black" accesskey="s">
        </div>
    </form>
</section>
<script>
    $(function(){
        $( "#gnb_sortable_example, #gnb_sortable" ).sortable({
            connectWith: ".gnb"
        }).disableSelection();

        $( "#mgnb_sortable_example, #mgnb_sortable" ).sortable({
            connectWith: ".mgnb"
        }).disableSelection();

    });

    function frmExample(){
        $(".example_print input").attr("disabled","disabled");
    }

    function gnbAdd(){
        var str = "<tr>";
            str += "<td><input type=\"text\" name=\"gnbTitle[]\" placeholder=\"이름\" class=\"w100p\"></td>";
            str += "<td><input type=\"text\" name=\"gnbUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\"></td>";
            str += "</tr>";
        $("#gnb_sortable").append(str);
    }

    function mGnbAdd(){
        var str = "<tr>";
            str += "<td><input type=\"text\" name=\"gnbTitle[]\" placeholder=\"이름\" class=\"w100p\"></td>";
            str += "<td><input type=\"text\" name=\"gnbUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\"></td>";
            str += "</tr>";
        $("#mgnb_sortable").append(str);
    }

</script>

