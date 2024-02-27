<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="forderForm" action="/Order/add" method="POST" onsubmit="return frmSubmit(this)">
            <input type="hidden" name="preUrl" value="<?=$_REQUEST['returnUrl']?>" >
            <div class="rhead01_wrap">
                <div class="h2">주문 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">주문 번호</th>
                        <td><input type="text" id="no" name="no" value="<?=_ORDER_NO.mt_rand(100, 999)?>"></td>
                    </tr>
                    <!--
                    <tr>
                        <th scope="row">상품 주문 번호</th>
                        <td><input type="text" id="id" name="id"></td>
                    </tr>
                    -->
                    <tr>
                        <th scope="row">상품 번호(ID)</th>
                        <td>
                            <input type="text" id="goodsId" name="goodsId" required readonly>
                            <a href="#" onclick="winOpen('/Order/goodsListPopup?opener=forderForm','goodsForm', '900','600','yes');" class="btn_small btn_gray">
                                상품 검색
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">상품 옵션 번호(ID)</th>
                        <td>
                            <input type="text" id="goodsOptionId" name="goodsOptionId" required readonly>
                            <a href="#" onclick="optList()" class="btn_small btn_gray">
                                옵션 검색
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">수량</th>
                        <td><input type="text" id="qty" name="qty" value="1" class="required">개</td>
                    </tr>
                    <tr>
                        <th scope="row">결제 방법</th>
                        <td>
                            <select name="paymethod">
                                <?php foreach($GLOBALS['paymethod'] as $key=>$value){ ?>
                                <?=get_frm_option($key,"",$value)?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">배송비</th>
                        <td>
                            <input type="text" id="deliveryCharge" name="deliveryCharge" class="required comma" value="0"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">상품금액</th>
                        <td>
                            <input type="text" id="goodsPrice" name="goodsPrice" class="required comma"> 원
                            <p class="info">세부판매가가 설정 되어 있는상품/가맹점의 경우, 금액을 반드시 다시 한번 확인하시기 바랍니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급가액</th>
                        <td><input type="text" id="supplyPrice" name="supplyPrice" class="required comma"> 원</td>
                    </tr>
                    <tr>
                        <th scope="row">결제금액</th>
                        <td><input type="text" id="amount" name="amount" class="required comma"> 원</td>
                    </tr>
                    <tr>
                        <th scope="row">주문 상태</th>
                        <td>
                            <select name="state">
                                <?php foreach($GLOBALS['od_stt'] as $key=>$value){ ?>
                                <?=get_frm_option($key,"",$value['title'])?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">주문자 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">아이디</th>
                        <td>
                            <input type="text" id="userId" name="userId">
                            <button type="button" onclick="getMember()" class="btn_small btn_gray">불러오기 </button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">이름</th>
                        <td><input type="text" id="userName" name="userName" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">전화번호</th>
                        <td><input type="text" id="userCellphone" name="userCellphone" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td><input type="text" id="userEmail" name="userEmail" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td>
                            <label for="userZip" class="sound_only">우편번호</label>
                            <input type="text" name="userZip" id="userZip"  size="8" maxlength="5">
                            <button type="button" class="btn_small btn_black" onclick="winZip('forderForm', 'userZip', 'userAddr1', 'userAddr2', 'userAddr3');">주소검색</button><br>
                            <input type="text" name="userAddr1" id="userAddr1" class="frm_address" size="60">
                            <label for="userAddr1">기본주소</label><br>
                            <input type="text" name="userAddr2" id="userAddr2" class="frm_address" size="60">
                            <label for="userAddr2">상세주소</label><br>
                            <input type="text" name="userAddr3" id="userAddr3" class="frm_address" size="60" readonly="readonly">
                            <label for="userAddr3">참고항목</label>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop">
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,"",$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">수취인 정보 입력</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">배송지 선택</th>
                        <td><button type="button" onclick="equals()" class="btn_small btn_gray">주문자와 동일</button></td>
                    </tr>
                    <tr>
                        <th scope="row">이름</th>
                        <td><input type="text" id="receiverName" name="receiverName" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">전화번호</th>
                        <td><input type="text" id="receiverCellphone" name="receiverCellphone" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td><input type="text" id="receiverEmail" name="receiverEmail" class="required" required></td>
                    </tr>
                    <tr>
                        <th scope="row">주소</th>
                        <td>
                            <label for="receiverZip" class="sound_only">우편번호</label>
                            <input type="text" name="receiverZip" id="receiverZip"  size="8" maxlength="5">
                            <button type="button" class="btn_small btn_black" onclick="winZip('forderForm', 'receiverZip', 'receiverAddr1', 'receiverAddr2', 'receiverAddr3');">주소검색</button><br>
                            <input type="text" name="receiverAddr1" id="receiverAddr1" class="frm_address" size="60">
                            <label for="receiverAddr1">기본주소</label><br>
                            <input type="text" name="receiverAddr2" id="receiverAddr2" class="frm_address" size="60">
                            <label for="receiverAddr2">상세주소</label><br>
                            <input type="text" name="receiverAddr3" id="receiverAddr3" class="frm_address" size="60" readonly="readonly">
                            <label for="receiverAddr3">참고항목</label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                <a href="<?=urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white">목록</a>
            </div>
        </form>
    </div>
</section>
<script>
function equals(){
    var name = $("input[name='userName']").val();
    if( !name ){
        alert("주문자 정보가 입력되지 않았습니다.");
        return false;
    }
    $("input[name='receiverName']").val( $("input[name='userName']").val() );
    $("input[name='receiverCellphone']").val( $("input[name='userCellphone']").val() );
    $("input[name='receiverEmail']").val( $("input[name='userEmail']").val() );
    $("input[name='receiverZip']").val( $("input[name='userZip']").val() );
    $("input[name='receiverAddr1']").val( $("input[name='userAddr1']").val() );
    $("input[name='receiverAddr2']").val( $("input[name='userAddr2']").val() );
    $("input[name='receiverAddr3']").val( $("input[name='userAddr3']").val() );
}    

function getMember(){
    var userId = $("input[name=userId]").val();
    if( !userId ){
        alert("회원 아이디가 입력되지 않았습니다.");
        return false;
    }        

    $.ajax({
type : "GET",
url : '/Member/get/'+userId,
dataType : 'json',
success : function(data){
$("input[name='userName']").val(data['name']);
$("input[name='userCellphone']").val(data['cellphone']);
$("input[name='userEmail']").val(data['email']);
$("input[name='userZip']").val(data['zip']);
$("input[name='userAddr1']").val(data['addr1']);
$("input[name='userAddr2']").val(data['addr2']);
$("input[name='userAddr3']").val(data['addr3']);
$("select[name=shop]").val(data['shop']).prop("selected",true);
},
error : function(data){ 
return false;
}
});
}

function optList(){
    var goodsId = $("input[name=goodsId]").val();
    if( !goodsId ){
        alert("상품이 선택되지 않았습니다.");
        return false;
    }        

    var url ="/Order/goodsOptList";
    url += "?opener=forderForm";
    url += "&goodsId=";
    url += goodsId;
    winOpen(url,'goodsForm', '900','600','yes');
}

function frmSubmit(obj){
    $(".comma").each(function() {
            data = uncomma( $(this).val() );
            $(this).val(data);
            });

    var no = $('#no').val();
    if( !noid ) return;
    $.ajax({
type : "GET",
url : '/Order/overChk',
data : {'no' : no},
dataType : 'json',
success : function(data){
if(data['res']){
return true;
}else{
return false;
}
},
error : function(data){ 
return false;
}
});
return true;
}
</script>
