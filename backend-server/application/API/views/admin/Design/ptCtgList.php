<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name']?></h1>
        <div class="chead01_wrap">
            <h2>카테고리 순위</h2>
            <table>
                <thead>
                    <tr>
                        <th scope="col" class="tac">1차 분류</th>
                        <th scope="col" class="tac">2차 분류</th>
                        <th scope="col" class="tac">3차 분류</th>
                        <th scope="col" class="tac">4차 분류</th>
                        <th scope="col" class="tac">5차 분류</th>
                    </tr>
                </thead>
                <tbody>
                <tr>    
                    <?php for($i=1;$i<=5;$i++){ ?>
                    <td class="w20p">
                        <?=$this->category->printDepthList($i, $_REQUEST['ctg'],'ctg'.$i,' class="ctgmulti-select" multiple' ); ?>
                        <div class="confirm_wrap">
                            <button type="button" class="btn_ssmall btn_white" onclick="moveCtg('ctg', 'prev')">▲ 위로</button>
                            <button type="button" class="btn_ssmall btn_white" onclick="moveCtg('ctg', 'next')">▼ 아래로</button>
                            <button type="button" class="btn_ssmall btn_red" onclick="addCtg('ctg','<?=$i?>')">추가</button>
                            <!-- <button type="button" class="btn_ssmall btn_gray" onclick="removeCtg('ctg')">삭제</button> -->
                        </div>
                    </td>
                    <?php } ?>
                    <script>
                    $(function() {
                        $("#ctg1").ctg_select_box("#ctg",5,"/Design/getNextCtg","=카테고리선택=");
                        $("#ctg2").ctg_select_box("#ctg",5,"/Design/getNextCtg","=카테고리선택=");
                        $("#ctg3").ctg_select_box("#ctg",5,"/Design/getNextCtg","=카테고리선택=");
                        $("#ctg4").ctg_select_box("#ctg",5,"/Design/getNextCtg","=카테고리선택=");
                        $("#ctg5").ctg_select_box("#ctg",5,"","=카테고리선택=");
                    });
                    </script>
                </tr>
                </tbody>
            </table>
        </div>
        <form name="fcategoryForm" id="fForm" action="/Design/ctgSet/<?=$_REQUEST['ctg']?>" method="POST" enctype="MULTIPART/FORM-DATA" >
            <input type="hidden" name="ctg" id="ctg" value="<?=$_REQUEST['ctg']?>" >
            <div class="rhead01_wrap">
                <h2>카테고리 관리</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">카테고리명</th>
                        <td><input type="text" name="title" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">공개설정</th>
                        <td>
                            <?=get_frm_radio("show_yn","y","","공개");?>
                            <?=get_frm_radio("show_yn","n","","비공개");?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="수정" id="btn_submit" class="btn_medium btn_black" accesskey="s">
                </div>
            </div>
        </form>
    </div>
</section>
</div>
<script>

function changeCtg(code){
    $("#fForm").attr("action","/Design/setCtg/"+code);
    $.ajax({
        type: "POST",
        url: '/Design/printCtg/'+code,
        data: { "code":code },
        dataType: 'json',
        success: function(data){
            //console.log(data);
            $("#fForm input[name='title']").val(data['title']);
            $("#fForm input[name='show_yn'][value='"+data['show_yn']+"']").prop("checked","true");
        }
    });
}


function addCtg(sel_id,depth){
    var ca_id = $('#'+sel_id).val();
    var upper = ca_id.substr(0,(depth-1)*3);
    if( depth!="1" && ( !ca_id || !upper ) ) return;
    if( upper.length < ((depth-1)*3) ) return;
    location.href='/Design/addCtg/'+upper;
}

function removeCtg(sel_id){
    var ca_id = $('#'+sel_id).val();
    location.href='/Design/removeCtg/'+ca_id;
}

function moveCtg(sel_id,pos){
    var ca_id = $('#'+sel_id).val();
    console.log(ca_id);
    console.log(pos);
}




</script>
