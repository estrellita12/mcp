<?php
include_once("/var/www/html/my-custom-platform/sabangnet/common.php");
sbnet_log("/admin/order/order_update.php",array_merge($_POST,$_FILES));
/*
for($i=0; $i<$count; $i++)
{
    // 실제 번호를 넘김
    $k           = $_POST['chk'][$i];
    $od_no       = $_POST['od_no'][$k];
    $delivery    = $_POST['delivery'][$k];
    $delivery_no = $_POST['delivery_no'][$k];

    $od = get_order($od_no);
    if($od['dan'] != 3) continue;

    change_order_status_4($od_no, $delivery, $delivery_no);

    $od_sms_baesong[$od['od_id']] = $od['cellphone'];
}

foreach($od_sms_baesong as $key=>$recv) {
    $q = get_order($key, 'pt_id');
    icode_order_sms_send($q['pt_id'], $recv, $key, 4);
}

for($i=0; $i<$count; $i++)
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    $sql = " update shop_order
        set delivery    = '{$_POST['delivery'][$k]}'
        , delivery_no = '{$_POST['delivery_no'][$k]}'
        where od_no = '{$_POST['od_no'][$k]}' ";
    sql_query($sql);
}
*/
?>


