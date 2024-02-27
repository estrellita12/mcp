    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
        <form name="fflatForm" action="/Flat/add" method="POST" onsubmit="return fsubmit(this)">
            <div class="rhead01_wrap">
                <div class="h2">개별페이지 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w170">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">페이지 제목</th>
                        <td>
                            <input type="text" id="flat_title" name="title" class="required" required>
                            <button type="button" id="idck" class="btn btn_small btn_gray">중복확인</button>
                            <p id="idck_res" class="info"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">PC 내용</th>
                        <td colspan="3"><?=editor_html("pc", null)?></td>
                    </tr>
                    <tr>
                        <th scope="row">모바일 내용</th>
                        <td colspan="3"><?=editor_html("mobile", null)?></td>
                    </tr>                        
                </table>
            </div>
           <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_black" accesskey="s" >
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
    $('#idck').click(function(){
        var flat_title = $('#flat_title').val();
        if( !flat_title ) return;
        $.ajax({
            type : "GET",
            url : '/Flat/overChk',
            data : {'title' : flat_title},
            dataType : 'json',
            success : function(data){
                if(data['res']){
                    $('#idck_res').html('사용 가능한 아이디 입니다.');
                    $('#idck_res').attr('over','true');
                }else{
                    $('#idck_res').html('중복된 아이디 입니다.');
                    $('#idck_res').attr('over','false');
                }
            },
            error : function(data){
                console.log(data);
            }
        });
    });
});

function fsubmit(obj){
    if( !$('#idck_res').attr('over') ){
        d_msg("알림","중복된 페이지 제목이거나 중복확인이 진행 되지 않았습니다.","alert");
        return false;
    }
    return true;
}
</script>

