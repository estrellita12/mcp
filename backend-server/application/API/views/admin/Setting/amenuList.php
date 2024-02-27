<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name'];?></h1>
        <div class="chead01_wrap">
            <h2>관리자 페이지 메뉴</h2>
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="tac">1 Depth</th>
                        <th scope="col" class="tac">2 Depth</th>
                        <th scope="col" class="tac">3 Depth</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <?php for($i=1;$i<=3;$i++){ ?>
                    <td>
                        <?=$this->amenu->printDepthList($i, $_REQUEST['amenu'],'menu'.$i, ' class="ctgmulti-select" multiple' ); ?>
                        <div class="confirm_wrap">
                            <button type="button" class="btn_ssmall btn_white" onclick="moveAmenu('menu<?=$i?>', 'prev')">▲ 위로</button>
                            <button type="button" class="btn_ssmall btn_white" onclick="moveAmenu('menu<?=$i?>', 'next')">▼ 아래로</button>
                            <button type="button" class="btn_ssmall btn_red" onclick="addAmenu('menu','<?=$i?>')">추가</button>
                            <button type="button" class="btn_ssmall btn_gray" onclick="removeAmenu('menu')">삭제</button>
                        </div>
                    </td>
                    <?php } ?>
                    <script>
                    $(function() {
                        $("#menu1").ctg_select_box("#menu",5,"/Setting/getNextMenu","==메뉴 선택==");
                        $("#menu2").ctg_select_box("#menu",5,"/Setting/getNextMenu","==메뉴 선택==");
                        $("#menu3").ctg_select_box("#menu",5,"/Setting/getNextMenu","==메뉴 선택==");
                    });
                    </script>
                </tr>
                </tbody>
            </table>
        </div>
        <form name="fForm" id="fForm" action="/Setting/setAmenu" method="POST">
            <input type="hidden" id="menu" name="menu" value="">
            <div class="rhead01_wrap">
                <h2>관리자 메뉴 관리</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">메뉴명</th>
                        <td><input type="text" name="name" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">사용설정</th>
                        <td>
                            <?=get_frm_radio("use_yn","y","","사용");?>
                            <?=get_frm_radio("use_yn","n","","미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">메뉴URL</th>
                        <td><input type="text" name="url"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="수정" id="btn_submit" class="btn_medium btn_black">
                </div>
            </div>
        </form>
    </div>
</section>
</div>
<script>
function changeData(code){
    $("#fForm").attr("action","/Setting/setAmenu/"+code);
    $.ajax({
    type: "POST",
        url: '/Setting/printAmenu/'+code,
        data: { "code":code },
        dataType: 'json',
        success: function(data){
            console.log(code);
            $("#fForm input[name='name']").val(data['name']);
            $("#fForm input[name='url']").val(data['url']);
            $("#fForm input[name='use_yn'][value='"+data['use_yn']+"']").prop("checked","true");
            if(code.length==4){
                $("#fForm input[name='url']").attr("disabled","true");
                $("#fForm input[name='url']").val(data['url']);
            }else{
                $("#fForm input[name='url']").removeAttr("disabled");
                $("#fForm input[name='url']").val(data['url']);
            }

        }
    });
}

function addAmenu(sel_id,depth){
    var code = $('#'+sel_id).val();
    var upper = code.substr(0,(depth-1)*2);
    if( depth!="1" && ( !code || !upper ) ) return;
    if( upper.length < ((depth-1)*2) ) return;
    location.href='/Setting/addAmenu/'+upper;
}

function removeAmenu(sel_id){
    var code = $('#'+sel_id).val();
    location.href='/Setting/removeAmenu/'+code;
}

function moveAmenu(sel_id, pos){
    var code = $('#'+sel_id).val()[0];
    var arr = [];
    var num = 0;
    $('#'+sel_id+" > option").each(function(index){
        var idx = $(this).val();
        if(idx == '') return;
        if(idx == code){
            num = index;
            return;
        }
        arr.push( idx );
    });
    if(pos=='prev') num=num-2;
    arr.splice(num,0,code);
    var str = arr.join(",");
    console.log(str);
    location.href='/Setting/sortableAmenu?list='+str;
}

</script>
