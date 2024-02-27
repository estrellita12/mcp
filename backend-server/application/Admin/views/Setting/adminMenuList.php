<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <div class="chead02_wrap">
            <div class="h2">관리자 페이지 메뉴</div>
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="tac"><span class="tooltip">1 Depth<span class="tooltiptext">해당 Depth는 추가/삭제가 불가능 합니다.</span></span></th>
                        <th scope="col" class="tac">2 Depth</th>
                        <th scope="col" class="tac">3 Depth</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <?php for($i=1;$i<=3;$i++){ ?>
                    <td>
                        <?=$this->menu->printDepthList($i, isset($_REQUEST['menu'])?$_REQUEST['menu']:"",'menu'.$i, ' class="multiple-select" multiple' ); ?>
                        <div class="confirm_wrap">
                            <button type="button" class="btn_ssmall btn_white" onclick="moveMenu('menu<?=$i?>', 'prev')">▲ 위로</button>
                            <button type="button" class="btn_ssmall btn_white" onclick="moveMenu('menu<?=$i?>', 'next')">▼ 아래로</button>
                            <?php if( $i!="1" ){ ?>
                            <button type="button" class="btn_ssmall btn_red" onclick="addMenu('menu','<?=$i?>')">추가</button>
                            <button type="button" class="btn_ssmall btn_gray" onclick="removeMenu('menu')">삭제</button>
                            <?php } ?>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
                </tbody>
            </table>
        </div>
        <script>
            $(function() {
                    $("#menu1").ctg_select_box("#menu",5,"/Setting/getNextAdminMenu","==메뉴 선택==");
                    $("#menu2").ctg_select_box("#menu",5,"/Setting/getNextAdminMenu","==메뉴 선택==");
                    $("#menu3").ctg_select_box("#menu",5,"/Setting/getNextAdminMenu","==메뉴 선택==");
                    });
        </script>
        <br>
        <form name="fForm" id="fForm" action="/Setting/setMenu" method="POST">
            <input type="hidden" id="menu" name="menu" value="">
            <div class="rhead01_wrap">
                <div class="h2">관리자 메뉴 관리</div>
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
                            <?=get_frm_radio("use","y","","사용");?>
                            <?=get_frm_radio("use","n","","미사용");?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">페이지 URL</th>
                        <td><input type="text" name="url"></td>
                    </tr>
                    <tr>
                        <th scope="row">접속 허가 등급</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->gr_li as $id=>$name){ ?>
                                <?= get_frm_option($id,"",$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="수정" id="btn_submit" class="btn_medium btn_theme">
                </div>
            </div>
        </form>
        <div class="help_wrap"> 
            <div class="h2">도움말</div>
            <div class="h3">메뉴 수정을 어떻게 하나요?</div>
            <ul>
                <li>메뉴 클릭시 하단에 관리자 메뉴 관리에 해당 메뉴에 대한 정보가 표시됩니다.</li>
                <li>정보 수정 후 수정 버튼을 클릭하면 메뉴가 수정됩니다. </li>
            </ul>
            <div class="h3">접속 허가 등급은 무엇인가요?</div>
            <ul>
                <li>메뉴 접근시 접속 허가 등급보다 높은 등급의 관리자만 접근이 가능합니다.</li>
                <li>상위 Depth에 접근 권한이 없다면, 하위 Depth에도 접근이 불가합니다. </li>
            </ul>
        </div>
    </div>
</section>
<script>
    $(function(){
            <?php if(!empty($_REQUEST['menu'])){ ?>           
            changeData("<?=$_REQUEST['menu']?>")
            <?php } ?>

            })

function changeData(code){
    $("#fForm").attr("action","/Setting/setAdminMenu/"+code);
    $.ajax({
type: "POST",
url: '/Setting/printAdminMenu/'+code,
data: { "code":code },
dataType: 'json',
success: function(data){
$("#fForm input[name='name']").val(data['name']);
$("#fForm input[name='url']").val(data['url']);
$("#fForm input[name='use'][value='"+data['use_yn']+"']").prop("checked","true");
$("#grade").val(data['show_grade']).prop("selected",true);
if(code.length==4){
$("#fForm input[name='url']").attr("disabled",true);
$("#fForm input[name='url']").val(data['url']);
}else{
$("#fForm input[name='url']").removeAttr("disabled");
$("#fForm input[name='url']").val(data['url']);
}
},
error:function(e){
console.log(e);
}
});
}

function addMenu(sel_id,depth){
    var code = $('#'+sel_id).val();
    var upper = code.substr(0,(depth-1)*2);
    if( depth!="1" && ( !code || !upper ) ) return;
    if( upper.length < ((depth-1)*2) ) return;
    location.href='/Setting/addAdminMenu/'+upper;
}

function removeMenu(sel_id){
    var code = $('#'+sel_id).val();
    location.href='/Setting/removeAdminMenu/'+code;
}

function moveMenu(sel_id, pos){
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
    location.href='/Setting/sortableAdminMenu?orderby='+str;
}

</script>
