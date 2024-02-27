<?php 
include_once("/var/www/html/my-custom-platform/sabangnet/common.php");
sbnet_log("/mypage/seller_goods_form_update.php",array_merge($_POST,$_FILES));

if( empty($_REQUEST['gs_id']) ){
    $w = "";
    $gs_id = "";
}else{
    $w = "u";
    $gs_id = $_REQUEST['gs_id'];
}

$option_count = count($_POST['opt_id']);
if($option_count) {
    // 옵션명
    $opt1_cnt = $opt2_cnt = $opt3_cnt = 0;
    for($i=0; $i<$option_count; $i++) {
        $opt_val = explode(chr(30), $_POST['opt_id'][$i]);
        if($opt_val[0])
            $opt1_cnt++;
        if($opt_val[1])
            $opt2_cnt++;
        if($opt_val[2])
            $opt3_cnt++;
    }

    if($_POST['opt1_subject'] && $opt1_cnt) {
        $it_option_subject = $_POST['opt1_subject'];
        if($_POST['opt2_subject'] && $opt2_cnt)
            $it_option_subject .= ','.$_POST['opt2_subject'];
        if($_POST['opt3_subject'] && $opt3_cnt)
            $it_option_subject .= ','.$_POST['opt3_subject'];
    }
}

// 상품 정보제공
$value_array = array();
for($i=0; $i<count($_POST['ii_article']); $i++) {
    $key = $_POST['ii_article'][$i];
    $val = $_POST['ii_value'][$i];
    $value_array[$key] = $val;
}
//$it_info_value = addslashes(serialize($value_array));
$it_info_value = $value_array;

$sellerModel = new \application\models\SellerModel();
$seller = $sellerModel->get("*",array("sl_id"=>$_SESSION['user_id']));

unset($value);
$arr = array();
$arr['payRate'] = $seller['sl_pay_rate'];
//$arr['code'] = $_POST['gcode'];
$arr['code'] = get_gs_code();
$arr['seller'] = $_POST['mb_id'];
$arr['goodsCtg'] = $_POST['ca_id'];
$arr['goodsCtg2'] = $_POST['ca_id2'];
$arr['goodsCtg3'] = $_POST['ca_id3'];
$arr['name'] = $_POST['gname'];
$arr['explan'] = $_POST['explan'];
$arr['keywords'] = $_POST['keywords'];
$arr['isopen'] = $_POST['isopen'];
$arr['consumerPrice'] = $_POST['normal_price'];
$arr['goodsPrice'] = $_POST['goods_price'];
$arr['supplyPrice'] = get_supply_price($_POST['goods_price'],$seller['sl_pay_rate']);
$arr['goodsPriceAuto'] = "1";
$arr['maker'] = $_POST['maker'];
$arr['origin'] = $_POST['origin'];
$arr['makeYear'] = $_POST['make_year'];
$arr['makeDm'] = $_POST['make_dm'];
//$arr['season'] = $_POST['season'];
//$arr['sex'] = $_POST['sex'];
$arr['model'] = $_POST['model'];
//$arr['tax'] = $_POST['notax'];
$arr['tax'] = "1";
$arr['content'] = $_POST['memo'];
$arr['optSubject'] = $it_option_subject;
$arr['brand'] = $_POST['brand_nm'];
$arr['deliveryRegion'] = "1";
$arr['deliveryRegionMsg'] = $_POST['zone_msg'];
$arr['buyUseGrade'] = $_POST['buy_level'];
$arr['infoType'] = $_POST['info_gubun'];
$arr['infoValue'] = $it_info_value;;
$arr['stockQty'] = $_POST['stock_qty'];
$arr['qtyNoti'] = $_POST['zone_msg'];
$arr['memo'] = $_POST['admin_memo'];
$arr['simgType'] = "0";
$arr['simg1'] = $_FILES['simg1'];
$arr['simg2'] = $_FILES['simg2'];
$arr['simg3'] = $_FILES['simg3'];
$arr['simg4'] = $_FILES['simg4'];
$arr['simg5'] = $_FILES['simg5'];

$goodsModel =  new \application\models\GoodsModel();
sbnet_log("/mypage/seller_goods_form_update.php",array("test"=>"test2","arr"=>$arr,"gs_id"=>$gs_id));
if($_POST['w'] == "u") {
    $goodsResult = $goodsModel->set($arr,$gs_id);
}else{
    if( empty($arr['goodsCtg']) ) access("필수 정보 누락, 카테고리가 선택되지 않았습니다.");
    if( empty($arr['seller']) ) access("필수 정보 누락, 판매자가 입력되지 않았습니다.");
    if( empty($arr['name']) ) access("필수 정보 누락, 상품명이 입력되지 않았습니다.");
    if( empty($arr['isopen']) ) $arr['gs_isopen'] = 1;
    $goodsResult = $goodsModel->add($arr);
    $gs_id = $goodsModel->pdo->lastInsertId();
}

$optionModel = new \application\models\GoodsOptionModel();
if($option_count) {
    for($i=0; $i<$option_count; $i++) {
        $optArr = array();
        $optArr['name'] = $_POST['opt_id'][$i];
        //$optSupplyPrice = round(only_number($_POST['opt_price'][$i] + $arr['goodsPrice']) * $rate,-1);
        $optSupplyPrice = get_supply_price($_POST['opt_price'][$i] + $arr['goodsPrice'],$seller['sl_pay_rate']);
        $optArr['supplyPrice'] = $optSupplyPrice;
        $optArr['addPrice'] = $_POST['opt_price'][$i];
        $optArr['stockQty'] = $_POST['opt_stock_qty'][$i];
        $optArr['qtyNoti'] = $_POST['opt_noti_qty'][$i];
        $optArr['useYn'] = $_POST['opt_use'][$i]==1?"y":"n";
        $optArr['goodsId'] = $gs_id;

        $option = $optionModel->get("*",array("gs_id"=>$gs_id,"gs_opt_name"=>$optArr['name']));
        if( !empty($option['gs_opt_id']) ){
            $res = $optionModel->set($optArr,$option['gs_opt_id']);
        }else{
            $res = $optionModel->add($optArr);
        }
    }
}

if( $w == "u" ){
    $option = $optionModel->get("*",array("gs_id"=>$gs_id),true);
    foreach($option as $opt){
        $optArr = array();
        $optSupplyPrice = round(only_number($opt['gs_opt_add_price'] + $arr['goodsPrice']) * $rate,-1);
        $optArr['supplyPrice'] = $optSupplyPrice;
        $res = $optionModel->set($optArr,$opt['gs_opt_id']);
        
        if( !empty($option_count) ){
            if( !in_array($opt['gs_opt_name'],$_POST['opt_id']) ){
                sbnet_log("/mypage/seller_goods_form_update.php",array("삭제 필요 옵션"=>$opt['gs_opt_name'],"옵션 아이디"=>$opt['gs_opt_id']));
            }
        }
    }
}


sbnet_log("/mypage/seller_goods_form_update.php", array("result"=>$goodsResult));
if($w == "")
    goto_url("/mypage/page.php?code=seller_goods_form&w=u&gs_id=$gs_id");
else if($w == "u")
    goto_url("/mypage/page.php?code=seller_goods_form&w=u&gs_id={$gs_id}{$q1}&page={$page}&bak={$bak}");
?>

