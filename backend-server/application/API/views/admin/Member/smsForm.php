<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name'];?></h1>
        <form name="fForm" action="/Member/smsFormUpdate<?=get_data($this->param['ident'],'/')?>" onsubmit="return fForm_submit(this);"  method="POST">
            <input type="hidden" name="idx" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <h2>SMS 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">치환코드</th>
                        <td>
                            <p>{이름} {레벨명} {아이디} {이메일}</p>
                            <p class="info">위 제공하는 치환코드를 SMS내용에 입력하시면 자동으로 변환되어 SMS에 적용 됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">SMS 제목</th>
                        <td>
                            <input type="text" name="title" class="required" value="<?=get_data($this->row['title'])?>" placeholder="제목 없음" required>
                            <p class="info">Example) 최대 10,000포인트 득템찬스!! 이벤트에 참여하세요!</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">SMS 내용</th>
                        <td>
                            <div class="phone_wrap">
                                <div class="phone_inner">
                                    <div class="top"></div>
                                    <div class="middel">
                                        <p>제목없음</p>
                                        <textarea name="content"><?=get_data($this->row['content'])?></textarea>
                                    </div>
                                    <div class="bottom"></div>
                                </div>
                                <div class="phone"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">발송 옵션</th>
                        <td>
                            <input type="text" name="opt" value="<?=get_data($this->row['opt'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">발송 일시</th>
                        <td>
                            <?php if( !empty($this->row['send_dt']) ) $send_dt = explode(" ",$this->row['send_dt'])  ?>
                            <input type="hidden" name="send_dt" id="send_dt" value="<?=get_data($send_dt)?>" required>
                            <input type="date" name="send_date" class="required" value="<?=isset($send_dt)?$send_dt[0]:""?>" required>
                            <input type="time" name="send_time" class="required" value="<?=isset($send_dt)?$send_dt[1]:""?>" required>
                        </td>
                    </tr>   

                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
                </div>
            </form>
        </div>
    </section>
</div>
<script>
function fForm_submit(f){
    f.send_dt.value = f.send_date.value+" "+f.send_time.value;
}
</script>
