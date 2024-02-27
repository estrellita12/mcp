<div id="new_win">
    <div class="pg_header">
        <h1>회원 정보 수정</h1>
    </div>
    <section class="cont_inner">
        <ul class="anchor">
            <li><a href="/PopUp/memberForm/<?= $this->row['id'] ?>">회원정보수정</a></li>
            <li><a href="/PopUp/memberOrder/<?= $this->row['id'] ?>">주문내역</a></li>
            <li><a href="/PopUp/memberPoint/<?= $this->row['id'] ?>">포인트</a></li>
        </ul>
        <form name="fregisterForm" action="/Popup/memberFormUpdate" method="POST">
            <input type="hidden" name="id" value="<?=$this->row['id']?>">
            <h3>기본정보</h3>
            <div class="tbl_frm02">
                <table class="tablef">
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">회원명</th>
                        <td>
                            <input type="text" name="name" value="<?=$this->row['name']?>" required itemname="회원명" class="frm_input required">
                        </td>
                        <th scope="row">아이디</th>
                        <td><?=$this->row['id']?></td>
                    </tr>
                    <tr>
                        <th scope="row">비밀번호</th>
                        <td><input type="text" name="passwd" value="" class="frm_input"></td>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="pt_id" class="required" required>
                                <?php foreach($this->partner->getList() as $pt){ ?>
                                <?= get_frm_option($pt[id],$this->row['pt_id'],$pt['name']); ?>
                                <?php } ?>
                            </select> 
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">성별</th>
                        <td>
                            <?= get_frm_radio("gender","M",$this->row['gender'],"남"); ?>
                            <?= get_frm_radio("gender","W",$this->row['gender'],"여"); ?>
                        </td>
                        <th scope="row">생년월일(8자)</th>
                        <td>    
                            <select name="yy" id="year"></select>
                            <select name="mm" id="month"></select>
                            <select name="dd" id="day"></select>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">E-Mail</th>
                        <td><input type="text" name="email" value="<?=$this->row['email']?>" itemname="E-Mail" class="frm_input" size="30"></td>
                        <th scope="row">메일수신</th>
                        <td>
                            <?= get_frm_radio("emailser","Y",$this->row['emailser'],"예"); ?>
                            <?= get_frm_radio("emailser","N",$this->row['emailser'],"아니오"); ?>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">휴대전화</th>
                        <td><input type="text" name="cellphone" value="<?=$this->row['cellphone']?>" class="frm_input"></td>
                        <th scope="row">문자수신</th>
                        <td>
                            <?= get_frm_radio("smsser","Y",$this->row['smsser'],"예"); ?>
                            <?= get_frm_radio("smsser","N",$this->row['smsser'],"아니오"); ?>
                        </td>

                    </tr>

                    <tr>
                        <th scope="row">주소</th>
                        <td colspan="3">
                            <input type="text" name="zip" value="<?=$this->row['zip']?>" class="frm_input" size="8" maxlength="5">
                            <a href="javascript:win_zip('fmemberform', 'zip', 'addr1', 'addr2', 'addr3');" class="btn btn_small btn_gray">주소검색</a>
                            <p class="mart5"><input type="text" name="addr1" value="<?=$this->row['addr1']?>" class="frm_input" size="60"> 기본주소</p>
                            <p class="mart5"><input type="text" name="addr2" value="<?=$this->row['addr2']?>" class="frm_input" size="60"> 상세주소</p>
                            <p class="mart5"><input type="text" name="addr3" value="<?=$this->row['addr3']?>" class="frm_input" size="60"> 참고항목
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">등급</th>
                        <td>
                            <select id="grade" name="grade">
                                <?php foreach($this->query->getRowAll("web_member_grade","*"," and name != '' " , " order by idx desc ") as $row){ ?>
                                <?= get_frm_option($row['idx'], $this->row['grade'], "[".$row['idx']."] ".$row['name']); ?>
                                <?php } ?>
                            </select>
                        </td>
                        <th scope="row">포인트</th>
                        <td>
                            <b><?=$this->row['point']?></b> Point
                            <a href="" onclick="win_open(this,'pop_point_req','600','500','yes');return false;" class="btn btn_small btn_gray marl10">강제적립</a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <h3 class="mart30">기타정보</h3>
                <table class="tablef">
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                    </tr>
                    <tr>
                        <th scope="row">회원가입일</th>
                        <td><?=$this->row['reg_date']?></td>
                        <th scope="row">로그인횟수</th>
                        <td><?=$this->row['login_sum'] ?> 회</td>
                    </tr>
                    <tr>
                        <th scope="row">최근접속일</th>
                        <td><?=$this->row['last_login_date']?></td>
                        <th scope="row">접근차단일자</th>
                        <td>
                            <input type="text" name="intercept_date" value="" id="intercept_date" class="frm_input" size="10" maxlength="8">
                            <input type="checkbox" value="20211112" id="mb_intercept_date_set_today" onclick="if(this.form.intercept_date.value==this.form.intercept_date.defaultValue) { this.form.intercept_date.value=this.value; } else {
                            this.form.intercept_date.value=this.form.intercept_date.defaultValue; }">
                            <label for="mb_intercept_date_set_today">접근차단일을 오늘로 지정</label>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">구매횟수</th>
                        <td><?= $this->order->getOrderCnt($this->row['id'])?> 회</td>
                        <th scope="row">총구매금액</th>
                        <td><?= number_format( $this->order->getSumPrice($this->row['id']) ) ?> 회</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <th scope="row">관리자메모</th>
                        <td colspan="3"><textarea name="memo" class="frm_textbox" rows="3"><?= $this->row['memo'] ?></textarea></td>
                    </tr>
                    </tbody>
                </table>

                <div class="confirm_wrapper">
                    <input type="submit" value="저장" class="btn btn_medium btn_black" accesskey="s">
                    <button type="button" class="btn btn_medium btn_red" onclick="member_leave();">탈퇴</button>
                    <button type="button" class="btn btn_medium btn_white" onclick="window.close();">닫기</button>
                </div>
            </div>
        </form>
    </section>
</div>

<script>
function member_leave() {
    if(confirm("영구 탈퇴처리 하시겠습니까?\n한번 삭제된 데이터는 복구 불가능합니다.")) {
        var token = get_ajax_token();
        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }
        location.href = "/PopUp/memberLeave/<?=$this->row['id'] ?>&token="+token;
        return true;
    } else {
        return false;
    }
}

$(document).ready(function(){
        var now = new Date();

        //var year = now.getFullYear();
        //var mon = (now.getMonth() + 1) > 9 ? ''+(now.getMonth() + 1) : '0'+(now.getMonth() + 1);
        //var day = (now.getDate()) > 9 ? ''+(now.getDate()) : '0'+(now.getDate());

        <?php $birth = explode("-",$this->row['birth']); ?>
        var year = "<?= $birth[0] ?>";
        var mon = "<?= $birth[1] ?>";
        var day = "<?= $birth[2] ?>"; 

        //년도 selectbox만들기
        for(var i = 1900 ; i <= year ; i++) {
        $('#year').append('<option value="' + i + '">' + i + '년</option>');
        }

        // 월별 selectbox 만들기
        for(var i=1; i <= 12; i++) {
        var mm = i > 9 ? i : "0"+i ;
        $('#month').append('<option value="' + mm + '">' + mm + '월</option>');
        }

        // 일별 selectbox 만들기
        for(var i=1; i <= 31; i++) {
        var dd = i > 9 ? i : "0"+i ;
        $('#day').append('<option value="' + dd + '">' + dd+ '일</option>');
        }
        $("#year  > option[value="+year+"]").attr("selected", "true");
        $("#month  > option[value="+mon+"]").attr("selected", "true");
        $("#day  > option[value="+day+"]").attr("selected", "true");

})



</script>
