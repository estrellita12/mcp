<?php
print_r($_GET);
echo '<script src="/public/js/jquery-1.8.3.min.js"></script>';

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {   //https 통신
    echo '<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>'.PHP_EOL;
} else {  //http 통신
    echo '<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>'.PHP_EOL;
}
?>
<script>
$(function() {
    var el_id = document.getElementById("daum_juso_wrap");
    new daum.Postcode({
        oncomplete: function(data) {
            var address1 = "",
                address2 = "";
            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                address1 = data.roadAddress;

                //법정동명이 있을 경우 추가한다.
                if(data.bname !== ''){
                    address2 += data.bname;
                }
                // 건물명이 있을 경우 추가한다.
                if(data.buildingName !== ''){
                    address2 += (address2 !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                address2 = (address2 !== '' ? ' ('+ address2 +')' : '');
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                address1 = data.jibunAddress;
            }
            put_data5(data.zonecode, address1, "", address2, data.addressType);
        },
        width : "100%",
        height : "100%"
    }).embed(el_id);
});
</script>
<style>
#daum_juso_wrap{position:absolute;left:0;top:0;width:100%;height:100%}
</style>

<div id="daum_juso_wrap" class="daum_juso_wrap"></div>

<script>
function put_data5(zip, addr1, addr2, addr3, jibeon)
{
    var of = window.opener.<?=$_GET['frm_name']?>;
    of.<?php echo ($_GET['frm_zip']); ?>.value = zip;
    of.<?php echo ($_GET['frm_addr1']); ?>.value = addr1;
    of.<?php echo ($_GET['frm_addr2']); ?>.value = addr2;
    of.<?php echo ($_GET['frm_addr3']); ?>.value = addr3;
    /*
    if( jibeon ){
        if(of.<?php echo ($_GET['frm_jibeon']); ?> !== undefined){
            of.<?php echo ($_GET['frm_jibeon']); ?>.value = jibeon;
        }
    }
    */
    of.<?php echo ($_GET['frm_addr2']); ?>.focus();
    window.close();
}
</script>

