<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabInfo['name']?></h1>
    <form action="/Setting/setLayout" method="POST" onsubmit="return frmExample()">
        <div class="chead02_wrap">
            <div class="h2">쇼핑몰 메인 레이아웃 관리</div>
            <table>
                <colgroup>
                    <col class="w200">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">메인 레이아웃 설정</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="vat">
                            <table>
                                <colgroup>
                                    <col class="w150">
                                    <col>
                                    <col class="w250">
                                    <col>
                                    <col>
                                    <col class="w120">
                                    <col class="w120">
                                    <col class="w60">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col" class="bg_light_yellow">타이틀</th>
                                        <th scope="col" class="bg_light_yellow">더보기 URL</th>
                                        <th scope="col" class="bg_light_yellow" >타입</th>
                                        <th scope="col" class="bg_light_yellow">정적</th>
                                        <th scope="col" class="bg_light_yellow">디자인</th>
                                        <th scope="col" class="bg_light_yellow">(PC)출력갯수</th>
                                        <th scope="col" class="bg_light_yellow">(모바일)출력갯수</th>
                                        <th scope="col">삭제</th>
                                    </tr>
                                </thead>
                                <tbody id="main_sortable" class="main_layout" style="height:50px;">
                                    <?php foreach($this->row['shop_main_layout'] as $mainLayout){ ?>
                                    <tr>
                                        <td>
                                            <input type="text" name="mainLayoutTitle[]" value="<?=stripslashes($mainLayout['title'])?>"  class="w100p">
                                        </td>
                                        <td>
                                            <input type="text" name="mainLayoutUrl[]" value="<?=$mainLayout['url']?>"  class="w100p">
                                        </td>
                                        <td>
                                            <select name="mainLayoutApiUrl[]" class="w100 api-type" onchange="apiTypeList(this)" data-col="<?php echo $mainLayout['apiCol'] ?>">
                                                <?php echo get_frm_option("goods",$mainLayout['api'],"상품")?>
                                                <?php echo get_frm_option("banner",$mainLayout['api'],"배너")?>
                                                <?php echo get_frm_option("plan",$mainLayout['api'],"기획전")?>
                                                <?php echo get_frm_option("media",$mainLayout['api'],"미디어")?>
                                                <?php echo get_frm_option("board",$mainLayout['api'],"게시판")?>
                                            </select>   
                                            <span class="w100">
                                            </span>
                                        </td>
                                        <td>
                                            <select name="mainLayoutType[]" class="w100p">
                                                <?php echo get_frm_option("1",$mainLayout['type'],"고정 레이아웃")?>
                                                <?php echo get_frm_option("2",$mainLayout['type'],"스와이프 레이아웃")?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="mainLayoutDesign[]" class="w100p">
                                                <?php echo get_frm_option("1",$mainLayout['design'],"이미지형")?>
                                                <?php echo get_frm_option("2",$mainLayout['design'],"이미지+타이틀형")?>
                                                <?php echo get_frm_option("3",$mainLayout['design'],"이미지+타이틀+상품형")?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="mainLayoutCnt[]" value="<?=$mainLayout['cnt']?>"  class="w40">
                                            <input type="number" name="mainLayoutRpp[]" value="<?=$mainLayout['rpp']?>"  class="w40">
                                        </td>
                                        <td>
                                            <input type="number" name="mainLayoutMCnt[]" value="<?=$mainLayout['mcnt']?>"  class="w40">
                                            <input type="number" name="mainLayoutMRpp[]" value="<?=$mainLayout['mrpp']?>"  class="w40">
                                        </td>
                                        <td><button type="button" class="btn_small btn_white" onclick="trDel(this)">삭제</button></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                        <tr>
                            <td class="tac"> <button type="button" onclick="mainLayoutAdd()" class="btn btn_ssmall btn_red">추가</button></td>
                        </tr>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="confirm_wrap">
            <input type="submit" value="저장" id="btn_submit" class="btn btn_large btn_black" accesskey="s">
        </div>
    </form>
</section>
<script>
    $(function(){
        $( "#main_sortable_example, #main_sortable" ).sortable({
            connectWith: ".main_layout"
        }).disableSelection();

        $(".api-type").each(function(idx,el){
            apiTypeList(el); 
        });
    });

    function apiTypeList(obj){
        var str = "";
        var val = $(obj).val();
        var col =  $(obj).data('col') ;
        switch(val){
        case "goods":
            str+= "<select name='mainLayoutApiCol[]' class='w100'>";
            str += "<option value='col=orderQty&colby=desc' "+(col=='col=orderQty&colby=desc'?"selected":"")+">인기상품</option>";
            str += "<option value='col=regDate&colby=desc' "+(col=='col=regDate&colby=desc'?"selected":"")+">신상품</option>";
            str += "<option value='type=1' "+(col=='type=1'?"selected":"")+">메뉴1</option>";
            str += "<option value='type=2' "+(col=='type=2'?"selected":"")+">메뉴2</option>";
            str+= "</select>"
            break;
        case "banner":
            str+= "<select name='mainLayoutApiCol[]' class='w100' style='font-size:10px;'>";
            <?php foreach($GLOBALS['banner'][1] as $idx=>$title){ ?>
            str += "<option value='position=<?=$idx?>' "+(col=='position=<?=$idx?>'?"selected":"")+"><?=$title?></option>";
            <?php } ?>
            str+= "</select>"
            break;
        case "media":
            str+= "<select name='mainLayoutApiCol[]' class='w100'>";
            str += "<option value='type=1' "+(col=='type=1'?"selected":"")+">Shorts 미디어</option>";
            str += "<option value='type=2' "+(col=='type=2'?"selected":"")+">기본 미디어</option>";
            str+= "</select>"
            break;
        case "plan":
            str += "<input type='text' name='mainLayoutApiCol[]' value='' size='4' class='w100' readonly>";
            break;
        default:
            str += "<input type='text' name='mainLayoutApiCol[]' value='"+col+"' size='4' class='w100'>";
        }
        $(obj).next().html(str);
    }

    function frmExample(){
        $(".example_print input").attr("disabled","disabled");
    }

    function mainLayoutAdd(){
        var str = "<tr>";
            str += "<td><input type=\"text\" name=\"mainLayoutTitle[]\" placeholder=\"이름\" class=\"w100p\"></td>";
            str += "<td><input type=\"text\" name=\"mainLayoutUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\"></td>";
            str += "<td>";
            str += "<select type=\"text\" name=\"mainLayoutApiUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100 api-type\" onchange=\"apiTypeList(this)\">";
            str += "<option value=\"goods\">상품</option>";
            str += "<option value=\"banner\">배너</option>";
            str += "<option value=\"plan\">기획전</option>";
            str += "<option value=\"media\">미디어</option>";
            str += "<option value=\"board\">게시판</option>";
            str += "</select>";
            str += "<span class=\"w100\">"
            str+= "<select name='mainLayoutApiCol[]' class='w100'>";
            str += "<option value='col=orderSum&rpp=12' >인기상품</option>";
            str += "<option value='col=regDate&rpp=12' >신상품</option>";
            str += "<option value='type=1' >메뉴1</option>";
            str += "<option value='type=2' >메뉴2</option>";
            str += "</span>";
            str += "</td>";
            str += "<td>";
            str += "<select type=\"text\" name=\"mainLayoutType[]\" class=\"w100p\">";
            str += "<option value=\"1\">고정 레이아웃</option>";
            str += "<option value=\"2\">스와이프 레이아웃</option>";
            str += "</select>";
            str += "</td>";
            str += "<td>";
            str += "<select type=\"text\" name=\"mainLayoutDesign[]\" class=\"w100p\">";
            str += "<option value=\"1\">이미지형</option>";
            str += "<option value=\"2\">이미지+타이틀형</option>";
            str += "<option value=\"3\">이미지+타이틀+상품형</option>";
            str += "</select>";
            str += "</td>";
            str += "<td><input type=\"number\" name=\"mainLayoutCnt[]\" class=\"w40\"><input type=\"number\" name=\"mainLayoutRpp[]\" class=\"w40\"></td>";
            str += "<td><input type=\"number\" name=\"mainLayoutMCnt[]\" class=\"w40\"><input type=\"number\" name=\"mainLayoutMRpp[]\" class=\"w40\"></td>";
            str += "</tr>";
        $("#main_sortable").append(str);
    }

</script>

