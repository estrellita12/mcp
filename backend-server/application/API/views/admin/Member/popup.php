<div id="newWin">
    <div class="pg_header">
        <p class="pg_tit" id="pg_tit">회원 정보</p>
    </div>
    <section class="popup_inner">
        <ul class="tabs">
            <li><a href="#memberForm">회원 정보 수정</a></li>
            <li><a href="#memberOrder">회원 주문 내역</a></li>
        </ul>
        <div class="tab_container">
            <div id="memberForm" class="tab_content">
                <form name="fmemberForm" action="/Member/set/<?=$this->param['ident']?>" method="POST">
                    <div class="rhead01_wrap">
                        <input type="hidden" name="id" value="<?=$this->row['id']?>">
                        <h2>기본 정보</h2>
                        <table>
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
                                    <input type="text" name="name" value="<?=$this->row['name']?>" required itemname="회원명" class="required">
                                </td>
                                <th scope="row">아이디</th>
                                <td><?=$this->row['id']?></td>
                            </tr>
                            <tr>
                                <th scope="row">비밀번호</th>
                                <td><input type="text" name="passwd" value=""></td>
                                <th scope="row">가맹점</th>
                                <td>
                                    <select name="pt_id" class="required" required>
                                        <?php foreach($this->pt_li as $id=>$name){ ?>
                                        <?= get_frm_option($id,$this->row['pt_id'],$name); ?>
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
                                <td><input type="date" name="birth" value="<?=$this->row['birth'];?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">E-Mail</th>
                                <td><input type="text" name="email" value="<?=$this->row['email']?>" itemname="E-Mail"  size="30"></td>
                                <th scope="row">메일수신</th>
                                <td>
                                    <?= get_frm_radio("emailser","Y",$this->row['emailser'],"예"); ?>
                                    <?= get_frm_radio("emailser","N",$this->row['emailser'],"아니오"); ?>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">휴대전화</th>
                                <td><input type="text" name="cellphone" value="<?=$this->row['cellphone']?>"></td>
                                <th scope="row">문자수신</th>
                                <td>
                                    <?= get_frm_radio("smsser","Y",$this->row['smsser'],"예"); ?>
                                    <?= get_frm_radio("smsser","N",$this->row['smsser'],"아니오"); ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">주소</th>
                                <td colspan="3">
                                    <input type="text" name="zip" value="<?=$this->row['zip']?>" size="8" maxlength="5">
                                    <a href="javascript:win_zip('fmemberForm', 'zip', 'addr1', 'addr2', 'addr3');" class="btn_small btn_gray">주소검색</a>
                                    <p class="mart5"><input type="text" name="addr1" value="<?=$this->row['addr1']?>" size="60"> 기본주소</p>
                                    <p class="mart5"><input type="text" name="addr2" value="<?=$this->row['addr2']?>" size="60"> 상세주소</p>
                                    <p class="mart5"><input type="text" name="addr3" value="<?=$this->row['addr3']?>" size="60"> 참고항목
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">등급</th>
                                <td>
                                    <select id="grade" name="grade">
                                        <?php foreach($this->gr_li as $idx=>$name){ ?>
                                        <?= get_frm_option($idx, $this->row['grade'], "[".$idx."] ".$name); ?>
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
                    </div>
                    <div class="rhead01_wrap">
                        <h2>기타 정보</h2>
                        <table>
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
                                <td><?=$this->row['reg_dt']?></td>
                                <th scope="row">로그인횟수</th>
                                <td><?=$this->row['login_sum'] ?> 회</td>
                            </tr>
                            <tr>
                                <th scope="row">최근접속일</th>
                                <td><?=$this->row['last_login_dt']?></td>
                                <th scope="row">접근차단일자</th>
                                <td>
                                    <input type="text" name="intercept_date" value="" id="intercept_date" size="10" maxlength="8">
                                    <input type="checkbox" value="20211112" id="mb_intercept_date_set_today" onclick="if(this.form.intercept_date.value==this.form.intercept_date.defaultValue) { this.form.intercept_date.value=this.value; } else {
                                    this.form.intercept_date.value=this.form.intercept_date.defaultValue; }">
                                    <label for="mb_intercept_date_set_today">접근차단일을 오늘로 지정</label>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row">구매횟수</th>
                                <td><?= $this->row['order_sum']?> 회</td>
                                <th scope="row">총구매금액</th>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <th scope="row">관리자메모</th>
                                <td colspan="3"><textarea name="memo" class="frm_textbox" rows="3"><?= $this->row['memo'] ?></textarea></td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="confirm_wrap">
                            <input type="submit" value="저장" class="btn_medium btn_black" accesskey="s">
                            <button type="button" class="btn_medium btn_red" onclick="leave();">탈퇴</button>
                            <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="memberOrder" class="tab_content">
                <form>
                    <div class="chead01_wrap">
                        <h2>기타 정보</h2>
                        <table>
                            <colgroup>
                                <col class="w50">
                                <col class="w170">
                                <col class="w100">
                                <col>
                                <col class="w50">
                                <col class="w80">
                                <col class="w90">
                                <col class="w80">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">주문번호</th>
                                    <th scope="col">주문자</th>
                                    <th scope="col">주문상품</th>
                                    <th scope="col">수량</th>
                                    <th scope="col">주문상태</th>
                                    <th scope="col">총주문액</th>
                                    <th scope="col">결제방법</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
function leave() {
    if(confirm("영구 탈퇴처리 하시겠습니까?\n한번 삭제된 데이터는 복구 불가능합니다.")) {
        var token = get_ajax_token();
        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }
        location.href = "/Member/remove/<?=$this->row['id'] ?>&token="+token;
        return true;
    } else {
        return false;
    }
}

$(document).ready(function(){
    $(".tab_content").hide();
    $("ul.tabs li:first").addClass("active").show();
    $(".tab_content:first").show();
    $("#pg_tit").html ( $("ul.tabs li:first").children("a").html()) ;

    $("ul.tabs li").click(function() {
        $("ul.tabs li").removeClass("active");
        $(this).addClass("active");
        $(".tab_content").hide();

        var activeTab = $(this).find("a").attr("href");
        $(activeTab).fadeIn();

        $("#pg_tit").html ( $(this).children("a").html() );
        return false;
    });
})
</script>
