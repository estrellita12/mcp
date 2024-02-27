<section class="contents">
    <h1 class="cont_title" id="pg_tit">메일 미리보기</h1>
    <div class="cont_wrap">
        <form action="/Setting/testSend" method="post">
            <input type="hidden" name="tpId" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <div class="h2">테스트 계정 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">아이디</th>
                        <td><?=$this->row['userId']?></td>
                    </tr>   
                    <tr>
                        <th scope="row">이름</th>
                        <td><?=$this->row['userName']?></td>
                    </tr>
                    <tr>
                        <th scope="row">메일 주소</th>
                        <td><?=$this->row['userEmail']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">미리보기</div>
                <table>
                    <colgroup>
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <td><?=$this->row['title']?></td>
                    </tr>   
                    <tr>
                        <td>   
                            <span>보낸 사람 : <?=$this->row['senderName']?> &lt;<?=$this->row['senderEmail']?>&gt;</span><br>
                            <span>받는 사람 : <?=$this->row['userName']?> &lt;<?=$this->row['userEmail']?>&gt;</span> 
                        </td>
                    </tr>   
                    <tr>
                        <td class="tac">
                            <iframe src="/public/iframe.html" id="content" frameborder="0" scrolling="no" style="width:95%; min-height:200px; overflow-x:hidden; overflow:auto"></iframe>
                            <textarea id="data" name="content" class="dn"><?=$this->row['content']?></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="테스트 발송" class="btn_medium btn_gray">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
<script>
$("#content").on("load", function() {
        let data =  $("#data").val();
        let wrapper = $("#content").contents().find("#wrapper");
        $(wrapper).append(data);
        $("#content").css('height',$(wrapper).height());
        });
</script>
