<section class="cont_inner">
    <h1 class="pg_tit"><?=isset($this->tabInfo['name'])?$this->tabInfo['name']:"EDM 미리보기";?></h1>
    <div class="pg_info">미리보기 내용이 올바르게 보이지 않는 경우 새로고침(F5)을 해주시기 바랍니다.</div>
    <div class="tab_container">
        <form action="/Marketing/testSendEdm" method="post">
            <input type="hidden" name="edmId" value="<?=$this->param['ident']?>">
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
                            <td><input type="hidden" name="userId" value="<?=$this->user['id']?>"><?=$this->user['id']?></td>
                        </tr>   
                        <tr>
                            <th scope="row">이름</th>
                            <td><?=$this->user['name']?></td>
                        </tr>
                        <tr>
                            <th scope="row">메일 주소</th>
                            <td><?=$this->user['email']?></td>
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
                            <td><input type="hidden" name="title" value="<?=$this->row['edm_title']?>"><?=$this->row['edm_title']?></td>
                        </tr>   
                        <tr>
                            <td>
                                <input type="hidden" name="userId" value="<?=$this->user['id']?>">
                                <input type="hidden" name="senderName" value="<?=$this->default['pt_name']?>">
                                <input type="hidden" name="senderEmail" value="<?=$this->default['shop_customer_service_email']?>">
                                <input type="hidden" name="userName" value="<?=$this->user['name']?>">
                                <input type="hidden" name="userEmail" value="<?=$this->user['email']?>">
                                <span>보낸 사람 : <?=$this->default['pt_name']?> &lt;<?=$this->default['shop_company_email']?>&gt;</span><br>
                                <span>받는 사람 : <?=$this->user['name']?> &lt;<?=$this->user['email']?>&gt;</span> 
                            </td>
                        </tr>   
                        <tr>
                            <td class="tac">
                                <iframe src="/public/iframe.html" id="content"  frameborder="0" scrolling="no" style="width:95%; min-height:200px; overflow-x:hidden; overflow:auto"></iframe>
                                <textarea id="data" name="content" class="dn"><?=$this->row['edm_content']?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <?php if($this->row['edm_stt']=="2" ){ ?>
                <a href="/Marketing/sendEdm/<?=$this->row['edm_id']?>" class="btn_medium btn_red">발송(삭제 예정)</a>
                <?php } ?>
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
