<section class="cont_inner">
    <p class="pg_tit" id="pg_tit"><?=isset($this->tabInfo['name'])?$this->tabInfo['name']:"LMS 미리보기";?></p>
    <div class="tab_container">
        <form action="/Marketing/testSendLms" method="post">
            <input type="hidden" name="lmsId" value="<?=$this->param['ident']?>">
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
                            <td><input type="hidden" name="title" value="<?=$this->row['lms_title']?>"><?=$this->row['lms_title']?></td>
                        </tr>   
                        <tr>
                            <td>
                                <input type="hidden" name="userId" value="<?=$this->user['id']?>">
                                <input type="hidden" name="sender" value="<?=$this->default['pt_name']?>">
                                <input type="hidden" name="senderTel" value="<?=$this->default['shop_company_tel']?>">
                                <input type="hidden" name="userName" value="<?=$this->user['name']?>">
                                <input type="hidden" name="userCellphone" value="<?=$this->user['cellphone']?>">
                                <span>보낸 사람 : <?=$this->default['pt_name']?> &lt;<?=$this->default['shop_company_tel']?>&gt;</span><br>
                                <span>받는 사람 : <?=$this->user['name']?> &lt;<?=$this->user['cellphone']?>&gt;</span> 
                            </td>
                        </tr>   
                        <tr>
                            <td>
                                <div class="phone_wrap">
                                    <div class="title"><input type="hidden" name="title" value="<?=$this->row['lms_title']?>"><?=$this->row['lms_title']?></div>
                                    <div class="content_inner">
                                        <iframe src="/public/iframe.html" id="content" width=100% height=390px style="overflow:hidden"></iframe>
                                        <textarea id="data" name="content" class="dn"><?=$this->row['lms_content']?></textarea>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <?php if($this->row['lms_stt']=="2" ){ ?>
                <a href="/Marketing/sendLms/<?=$this->row['lms_id']?>" class="btn_medium btn_red">발송(삭제 예정)</a>
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
    });
</script>
