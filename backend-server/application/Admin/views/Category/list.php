<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabInfo['name']?></h1>
    <div class="chead02_wrap">
        <div class="h2">카테고리 순위</div>
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
                        <?=$this->category->printDepthList($i, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"",'ctg'.$i,' class="ctgmulti-select" multiple','a' ); ?>
                        <div class="confirm_wrap">
                            <button type="button" class="btn_ssmall btn_white" onclick="moveCtg('ctg<?=$i?>', 'prev')">▲ 위로</button>
                            <button type="button" class="btn_ssmall btn_white" onclick="moveCtg('ctg<?=$i?>', 'next')">▼ 아래로</button>
                            <button type="button" class="btn_ssmall btn_red" onclick="addCtg('ctg','<?=$i?>')">추가</button>
                            <!-- <button type="button" class="btn_ssmall btn_gray" onclick="removeCtg('ctg')">삭제</button> -->
                        </div>
                    </td>
                    <?php } ?>
                    <script>
                        $(function() {
                            $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                            $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                            $("#ctg3").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                            $("#ctg4").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
                            $("#ctg5").ctg_select_box("#ctg",5,"","=카테고리선택=");
                        });
                    </script>
                </tr>
            </tbody>
        </table>
    </div>
    <form name="fcategoryForm" id="fForm" action="/Category/set/<?=!empty($_REQUEST['ctg'])?$_REQUEST['ctg']:""?>" method="POST" enctype="MULTIPART/FORM-DATA" >
        <!-- <input type="hidden" name="ctg" id="ctg" value="<?=!empty($_REQUEST['ctg'])?$_REQUEST['ctg']:""?>" > -->
        <div class="rhead01_wrap">
            <div class="h2">카테고리 관리</div>
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
                        <th scope="row">카테고리코드</th>
                        <td> <input type="text" name="ctg" id="ctg" value="<?=!empty($_REQUEST['ctg'])?$_REQUEST['ctg']:""?>" readonly ></td>
                    </tr>
                    <tr>
                        <th scope="row">공개설정</th>
                        <td>
                            <?=get_frm_radio("useYn","y","","공개");?>
                            <?=get_frm_radio("useYn","n","","비공개");?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="confirm_wrap">
                <input type="submit" value="수정" id="btn_submit" class="btn_medium btn_black" accesskey="s">
            </div>
        </div>
    </form>
</section>
<script>
    function changeData(code){
        $("#fForm").attr("action","/Category/set/"+code);
        $.ajax({
            type: "POST",
            url: '/Category/get/'+code,
            data: { "code":code },
            dataType: 'json',
            success: function(data){
                $("#fForm input[name='title']").val(data['title']);
                $("#fForm input[name='useYn'][value='"+data['useYn']+"']").prop("checked","true");
            }
        });
    }

    function addCtg(sel_id,depth){
        var ca_id = $('#'+sel_id).val();
        var upper = ca_id.substr(0,(depth-1)*3);
        if( depth!="1" && ( !ca_id || !upper ) ) return;
        if( upper.length < ((depth-1)*3) ) return;
        location.href='/Category/add/'+upper;
    }

    function removeCtg(sel_id){
        var ca_id = $('#'+sel_id).val();
        if( ca_id==null || ca_id=="" ){
            alert("카테고리가 선택되지 않았습니다");
            return;
        }
        location.href='/Category/remove/'+ca_id;
    }

    function moveCtg(sel_id,pos){
        var code = $('#'+sel_id).val();
        if( code==null || code=="" ){
            alert("카테고리가 선택되지 않았습니다");
            return;
        }
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
        location.href='/Category/sortable?orderby='+str;
    }
</script>
