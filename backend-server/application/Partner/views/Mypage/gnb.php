<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="flogo" method="post" action="/Mypage/setGnb/<?=$this->my['pt_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">쇼핑몰 GNB 관리</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w60">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">제목</th>
                            <th scope="col">URL</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody id="gnb_sortable" class="gnb" style="height:50px;">
                    <?php foreach($this->my['shop_gnb'] as $gnb){ ?>
                    <tr>
                        <td>
                            <input type="text" name="gnbTitle[]" value="<?=stripslashes($gnb['title'])?>" class="w100p" required>
                        </td>
                        <td>
                            <input type="text" name="gnbUrl[]" value="<?=$gnb['url']?>" class="w100p" required>
                        </td>
                        <td>
                            <button type="button" class="btn_small btn_gray" onclick="trDel(this)">삭제</button>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="tar mart10"><button type="button" onclick="gnbAdd()" class="btn_small btn_red">추가</button></div>
            </div>
            <div class="confirm_wrap">
                <?php if($this->my['shop_gnb_mode']=="modify"){ ?>
                <a href="/Mypage/removeGnb/<?=$this->my['pt_id']?>" class="btn_large btn_gray">삭제(본사 설정 반영)</a>
                <?php } ?>
                <input type="submit" value="저장" class="btn_large btn_theme">
            </div>
        </form>
        <div class="help_wrap">
            <div class="h2">도움말</div>
            <div class="h3">쇼핑몰 GNB는 무엇인가요?</h3>
            <ul>
                <li>쇼핑몰 상단에 표시되는 메뉴들을 의미합니다.</li>
            </ul>
            <div class="h3">순서 변경은 어떻게 하나요??</h3>
            <ul>
                <li>순서 변경을 원하는 메뉴 클릭 후 드래그앤 드롭 해주시면 순서가 변경됩니다.</li>
            </ul>
            <div class="h3">본사 설정을 따라가고 싶다면 어떻게 하나요?</h3>
            <ul>
                <li>기본값이 본사 설정입니다.</li>
                <li>별도로 설정을 한 경우, 삭제 버튼을 클릭하시면 본사 설정을 따라가게 됩니다.</li>
            </ul>
        </div>

    </div>
</section>
<script>
$(function() {
        $( "#gnb_sortable, #gnb_sortable_example" ).sortable({
connectWith: ".gnb"
}).disableSelection();

        });

function gnbAdd(){
    var str = "<tr>";
    str += "<td><input type=\"text\" name=\"gnbTitle[]\" placeholder=\"이름\" class=\"w100p\" required></td>";
    str += "<td><input type=\"text\" name=\"gnbUrl[]\" placeholder=\"연결 링크 주소\" class=\"w100p\" required></td>";
    str += "<td><button type=\"button\" class=\"btn_small btn_gray\" onclick=\"trDel(this)\">삭제</button></td>";
    str += "</tr>";
    $("#gnb_sortable").append(str);
}


function frmSubmit(){
    $(".example_print input").attr("disabled","disabled");
}
</script>

