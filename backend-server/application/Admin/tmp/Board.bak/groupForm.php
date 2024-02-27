    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
        <form name="fboardGroupForm" action="/Board/groupAdd" method="POST" onsubmit="return fsubmit(this)">
            <div class="rhead01_wrap">
                <div class="h2">게시판 그룹정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w170">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">그룹아이디</th>
                        <td>
                            <input type="text" id="group_id" name="id" class="required" required>
                            <button type="button" id="idck" class="btn btn_small btn_gray">중복확인</button>
                            <p id="idck_res" class="info"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">그룹명</th>
                        <td><input type="text" name="name" class="required" required></td>
                    </tr>
                </table>
            </div>
           <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
    $('#idck').click(function(){
        var bogrid = $('#group_id').val();
        if( !bogrid ) return;
        $.ajax({
            type : "GET",
            url : '/Board/overChk',
            data : {'id' : bogrid},
            dataType : 'json',
            success : function(data){
                console.log(data['res']);
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
    if( $('#idck_res').attr('over') != "true" ){
        d_msg("알림","아이디 중복 확인을 진행 후 중복 되지 않은 아이디만 회원가입이 가능합니다.","alert");
        return false;
    }
    return true;
}
</script>

