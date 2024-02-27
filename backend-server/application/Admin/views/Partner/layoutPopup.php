<section class="contents">
    <h1 class="cont_title">쇼핑몰 레이아웃</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="flogo" method="post" action="/Partner/setLayout/<?=$this->param['ident']?>" onsubmit="return frmSubmit()">
            <div class="chead02_wrap">
                <div class="h2">쇼핑몰 메인 레이아웃 관리</div>
                <div class="info">레이아웃을 별도로 설정하지 않으면 본사 설정을 따라가게 됩니다.<br>수정버튼을 클릭하면 <b>별도의 레이아웃</b>가 생성되고, 삭제버튼을 클릭하면 <b>별도의 레이아웃</b>이 삭제됩니다.</div>
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
                                    <col class="w100">
                                    <col class="w100">
                                    <col class="w50">
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
                                        <th scope="col" class="bg_light_yellow"></th>
                                    </tr>
                                </thead>
                                <tbody id="main_sortable" class="main_layout" style="height:50px;">
                                <?php foreach($this->row['shop_main_layout'] as $mainLayout){ ?>
                                <tr class="layout">
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
                                    <td><button type="button" class="btn_ssmall btn_gray" onclick="trDel(this)">삭제</button></td>
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
    $(function(){
        $( "#main_sortable_example, #main_sortable" ).sortable({
            connectWith: ".main_layout"
        }).disableSelection();

        $(".api-type").each(function(idx,el){
            apiTypeList(el); 
        });
    });

    function frmExample(){
        $(".example_print input").attr("disabled","disabled");
    }

</script>


