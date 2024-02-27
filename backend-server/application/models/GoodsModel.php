<?php
namespace application\models;

use \Exception;

class GoodsModel extends Model{
    var $colArr;
    var $preValue;
    function __construct( ){
        parent::__construct ( 'web_goods' );
        $this->colArr = array(
            "goodsId"=>"gs_id",
            "goodsCode"=>"gs_code",
            "goodsName"=>"gs_name",
            "ctg"=>"gs_ctg",
            "state"=>"gs_stt",
            "onlyShopYn"=>"gs_only_pt_yn",
            "onlyShop"=>"gs_only_pt_id",
            "buyUseGrade"=>"gs_buy_use_grade",
            "brand"=>"gs_brand",
            "seller"=>"sl_id",
            "isopen"=>"gs_isopen",
            "goodsPrice"=>"gs_price_9",
            "supplyPrice"=>"gs_supply_price",
            "consumerPrice"=>"gs_consumer_price",
            "stockQty"=>"gs_stock_qty",
            "salesBeginDate"=>"gs_sales_begin_dt",
            "salesEndDate"=>"gs_sales_end_dt",
            "deliveryType"=>"gs_delivery_type",
            "deliveryCharge"=>"gs_delivery_charge",
            "deliveryFree"=>"gs_delivery_free",
            "deliveryEachUse"=>"gs_delivery_each_use",
            "deliveryRegion"=>"gs_delivery_region",
            "deliveryResionMsg"=>"gs_delivery_region_msg",
            "simgType"=>"gs_simg_type",
            "simg1"=>"if(gs_simg1 != '', concat('"._GOODS."',gs_code,'/',gs_simg1), '')",
            "simg2"=>"if(gs_simg2 != '', concat('"._GOODS."',gs_code,'/',gs_simg2), '')",
            "simg3"=>"if(gs_simg3 != '', concat('"._GOODS."',gs_code,'/',gs_simg3), '')",
            "simg4"=>"if(gs_simg4 != '', concat('"._GOODS."',gs_code,'/',gs_simg4), '')",
            "simg5"=>"if(gs_simg5 != '', concat('"._GOODS."',gs_code,'/',gs_simg5), '')",
            "timg1"=>"if(gs_simg1 != '', concat('"._GOODS."',gs_code,'/',gs_simg1), '')",
            "timg2"=>"if(gs_simg2 != '', concat('"._GOODS."',gs_code,'/',gs_simg2), '')",
            "timg3"=>"if(gs_simg3 != '', concat('"._GOODS."',gs_code,'/',gs_simg3), '')",
            "timg4"=>"if(gs_simg4 != '', concat('"._GOODS."',gs_code,'/',gs_simg4), '')",
            "timg5"=>"if(gs_simg5 != '', concat('"._GOODS."',gs_code,'/',gs_simg5), '')",
            /*
            "timg1"=>"if(gs_simg1 != '', concat('"._GOODS."',gs_code,'/thumb/', gs_simg1), '')",
            "timg2"=>"if(gs_simg2 != '', concat('"._GOODS."',gs_code,'/thumb/', gs_simg2), '')",
            "timg3"=>"if(gs_simg3 != '', concat('"._GOODS."',gs_code,'/thumb/', gs_simg3), '')",
            "timg4"=>"if(gs_simg4 != '', concat('"._GOODS."',gs_code,'/thumb/', gs_simg4), '')",
            "timg5"=>"if(gs_simg5 != '', concat('"._GOODS."',gs_code,'/thumb/', gs_simg5), '')",
            */
            "svideo"=>"gs_svideo_url",
            "detail"=>"gs_detail_content",
            "optSubject"=>"gs_opt_subject",
            "addOptSubject"=>"gs_add_opt_subject",
            "orderQty"=>"gs_order_qty",
            "viewCnt"=>"gs_view_cnt",
            "regDate"=>"gs_reg_dt",
            "orderMaxQty"=>"gs_order_max_qty",
            "orderMinQty"=>"gs_order_min_qty",
        );



    }

    function uploadImg($path, &$value){
        try{
            if (!file_exists($path)) {
                $res =  mkdir($path, 0777, true);
            }
            $upl = new \application\models\UploadImage($path);
            for($i=1;$i<=5;$i++){
                if( !empty($value["gs_simg{$i}_del"]) ){
                    $upl->del($value["gs_simg{$i}_del"]);
                    unset($value["gs_simg{$i}_del"]);
                    $value["gs_simg{$i}"] = "";
                    continue;
                }

                if( $value['gs_simg_type'] == "1" ){
                    continue;
                }

                if( isset($this->preValue["gs_simg{$i}"]) && $value["gs_simg{$i}"] == $this->preValue["gs_simg{$i}"] ){
                    unset($value["gs_simg{$i}"]);
                    continue;
                }
                if( is_array($value["gs_simg{$i}"]) ){
                    if( empty($value["gs_simg{$i}"]['tmp_name']) || $value["gs_simg{$i}"]['error'] != 0  ){
                        unset($value["gs_simg{$i}"]);
                        continue;
                    }
                    $filename = $upl->upload($value["gs_simg{$i}"]);
                }else{
                    if( substr($value["gs_simg{$i}"],0,7) != "http://" && substr($value["gs_simg{$i}"],0,8)!="https://" ){
                        unset($value["gs_simg{$i}"]);
                        continue;
                    }
                    try{
                        $filename = $upl->uploadUrl($value["gs_simg{$i}"]);         
                    }catch(Exception $e){ $filename = ""; }
                }
                if( empty($filename) ){
                    unset($value["gs_simg{$i}"]);
                    continue;
                }    

                if( isset($this->preValue["gs_simg{$i}"]) ) {
                    try{
                        $upl->del($this->preValue["gs_simg{$i}"]);
                    }catch(Exception $e){}
                }

                $value["gs_simg{$i}"] = $filename; 
                //create thumbnail start ----------
                $name_arr = explode(".", $filename);
                $thumb_path = $path."/thumb";
                if (!file_exists($thumb_path)) {
                    mkdir($thumb_path, 0777, true);
                }
                make_thumb($path.'/'.$filename, $thumb_path."/".$filename, 300);
                //create thumbnail end ------------
            }
            return "000";
        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['code']) || empty($arr['name']) || empty($arr['seller']) || empty($arr['goodsCtg']) || strlen($arr['goodsCtg']) <= 3 ) return;
            $value['gs_code'] = $arr['code']; // 상품 코드
            $value['sl_id'] = $arr['seller']; // 판매자 아이디 (공급사)
            $value['gs_ctg'] = $arr['goodsCtg']; // 대표 카테고리
            $value['gs_reg_dt'] = _DATE_YMDHIS; // 등록일시
        }

        $value['gs_update_dt'] = _DATE_YMDHIS; //수정 일시
        if( !empty($arr['goodsCtg']) && strlen($arr['goodsCtg']) > 3 )  $value['gs_ctg'] = $arr['goodsCtg']; // 대표 카테고리
        if( isset($arr['goodsCtg2']) )  $value['gs_ctg2'] = $arr['goodsCtg2']; // 추가 카테고리 2
        if( isset($arr['goodsCtg3']) )  $value['gs_ctg3'] = $arr['goodsCtg3']; // 추가 카테고리 3
        if( !empty($arr['name']) )      $value['gs_name'] = $arr['name']; // 상품명
        if( !empty($arr['explan']) )    $value['gs_explan'] = $arr['explan'];  // 짧은 설명
        if( isset($arr['keywords']) )   $value['gs_keywords'] = $arr['keywords']; // 키워드
        if( !empty($arr['state']) )     $value['gs_stt'] = $arr['state']; // 승인 상태
        if( !empty($arr['isopen']) )    $value['gs_isopen'] = $arr['isopen']; // 진열 상태

        if( !empty($arr['consumerPrice']) ) $value['gs_consumer_price'] = only_number($arr['consumerPrice']);
        if( !empty($arr['goodsPrice']) )    $value['gs_price'] = only_number($arr['goodsPrice']);
        if( !empty($arr['supplyPrice']) )   $value['gs_supply_price'] = only_number($arr['supplyPrice']);
        $gs_consumer_price = !empty($value['gs_consumer_price'])?$value['gs_consumer_price']:$this->preValue['gs_consumer_price'];
        $gs_price = !empty($value['gs_price'])?$value['gs_price']:$this->preValue['gs_price'];
        $gs_supply_price = !empty($value['gs_supply_price'])?$value['gs_supply_price']:$this->preValue['gs_supply_price'];
        if( empty($gs_price) || empty($gs_supply_price) || empty($gs_consumer_price) ) return;

        if( isset($arr['payRate']) )        $value['gs_rate'] = only_number($arr['payRate']); 
        if( isset($this->preValue['gs_rate']) ) $rate = $value['gs_rate'];
        if( isset($value['gs_rate']) ) $rate = $value['gs_rate'];
        if( !isset($rate) || empty($rate) ){
            if( empty($gs_price) || empty($gs_supply_price) ) return;
            $value['gs_rate'] = round( (( $gs_price - $gs_supply_price) / $gs_price) * 100 );
        }

        if( !empty($arr['goodsPriceAuto']) ) $value['gs_price_auto'] = $arr['goodsPriceAuto'];
        $flag = false;
        if( isset($value['gs_price']) && isset($this->preValue['gs_price']) && ($value['gs_price'] != $this->preValue['gs_price']) ) $flag = true;
        if( isset($value['gs_supply_price']) && isset($this->preValue['gs_supply_price']) && ($value['gs_supply_price'] != $this->preValue['gs_supply_price']) ) $flag = true;
        if( $flag ){
            $value['gs_price_auto'] = "1";
            $value['gs_stt'] = "1";
        }
        if( $mode=="add" ) $value['gs_price_auto'] ="1";

        if( !empty($value['gs_price_auto']) ){
            if( $value['gs_price_auto'] == 1 ){ // 자동설정
                $rateList = array(0.8,0.85,0.9,0.95,1,1.05,1.1,1.15,1.2);
                for($i=1;$i<10;$i++){
                    $price = round($gs_price*$rateList[$i-1],-1);
                    if($price < $gs_supply_price) $price = $gs_supply_price;
                    if($price > $gs_consumer_price) $price = $gs_consumer_price;
                    $value["gs_price_{$i}"] = $price;
                }
            }else{ // 수동 설정
                for($i=1;$i<10;$i++){
                    if( !empty($arr["goodsPrice{$i}"]) )       $value["gs_price_{$i}"] = $arr["goodsPrice{$i}"]; // 상품 가격
                }
            }
        }

        if( isset($arr['maker']) )     $value['gs_maker'] = $arr['maker']; // 제조사
        if( isset($arr['origin']) )    $value['gs_origin'] = $arr['origin']; // 원산지
        if( isset($arr['makeYear']) )  $value['gs_make_year'] = $arr['makeYear']; // 생산연도
        if( isset($arr['makeDm']) )    $value['gs_make_dm'] = $arr['makeDm']; // 제조일자
        if( !empty($arr['season']) )    $value['gs_season'] = $arr['season']; // 시즌
        if( !empty($arr['sex']) )       $value['gs_sex'] = $arr['sex']; // 남여 구분
        if( isset($arr['model']) )     $value['gs_model_nm'] = $arr['model']; // 모델명 
        if( !empty($arr['tax']) )       $value['gs_tax'] = $arr['tax']; // 과세 유무
        if( !empty($arr['content']) )   $value['gs_detail_content'] = $arr['content']; // 상세 설명
        if( !empty($arr['viewCnt']) )   $value['gs_view_cnt'] = $arr['viewCnt']; // 조회수
        if( !empty($arr['orderQty']) )  $value['gs_order_qty'] = $arr['orderQty']; // 주문된 수량 합계
        if( !empty($arr['optSubject']) )        $value['gs_opt_subject'] = $arr['optSubject']; // 기본 옵션 제목
        if( !empty($arr['addOptSubject']) )     $value['gs_add_opt_subject'] = $arr['addOptSubject']; // 추가 옵션 제목
        if( !empty($arr['brand']) )             $value['gs_brand'] = $arr['brand']; // 브랜드
        if( !empty($arr['deliveryType']) )      $value['gs_delivery_type'] = $arr['deliveryType']; // 배송비 유형
        if( !empty($arr['deliveryCharge']) )    $value['gs_delivery_charge'] = $arr['deliveryCharge']; // 기본 배송비
        if( !empty($arr['deliveryFree']) )      $value['gs_delivery_free'] = $arr['deliveryFree']; // 무료 배송을 위한 최소 주문금액
        if( !empty($arr['claimDeliveryCharge']) )    $value['gs_claim_delivery_charge'] = $arr['claimDeliveryCharge']; // 교환/반품 배송비
        if( !empty($arr['deliveryEachUse']) )   $value['gs_delivery_each_use'] = $arr['deliveryEachUse']; // 묶음 배송 가능 여부
        if( !empty($arr['deliveryRegion']) )    $value['gs_delivery_region'] = $arr['deliveryRegion']; // 배송 가능 지역
        if( !empty($arr['deliveryRegionMsg']) ) $value['gs_delivery_region_msg'] = $arr['deliveryRegionMsg']; // 배송가능 지역 추가설명
        if( !empty($arr['buyUseGrade']) )       $value['gs_buy_use_grade'] = $arr['buyUseGrade']; // 구매 가능 등급
        if( !empty($arr['orderMaxQty']) )       $value['gs_order_max_qty'] = $arr['orderMaxQty']; // 최대 주문 한도
        if( !empty($arr['orderMinQty']) )       $value['gs_order_min_qty'] = $arr['orderMinQty']; // 최소 주문 한도
        if( !empty($arr['infoType']) )          $value['gs_info_type'] = $arr['infoType']; // 정보고시 타입
        if( !empty($arr['infoValue']) )         $value['gs_info_value'] = serialize($arr['infoValue']); // 정보고시 값
        if( !empty($arr['onlyPartnerYn']) )     $value['gs_only_pt_yn'] = $arr['onlyPartnerYn'];
        if( !empty($arr['onlyPartnerId']) )     $value['gs_only_pt_id'] = $arr['onlyPartnerId'];
        if( !empty($arr['stockType']) )     $value['gs_stock_type'] = $arr['stockType'];
        if( isset($arr['stockQty']) )      $value['gs_stock_qty'] = $arr['stockQty'];
        if( !empty($arr['qtyNoti']) )       $value['gs_stock_qty_noti'] = $arr['qtyNoti'];
        if( !empty($arr['memo']) )          $value['gs_adm_memo'] = $arr['memo']; // 상품 관련 관리자 메모
        if( !empty($arr['salesBeginDate']) ){
            if(is_array($arr['salesBeginDate'])) $value['gs_sales_begin_dt'] = implode(" ",$arr['salesBeginDate']); // 판매기간 시작일
            else $value['gs_sales_begin_dt'] = _BEGIN_DATE;
        }
        if( !empty($arr['salesEndDate']) ){
            if(is_array($arr['salesEndDate'])) $value['gs_sales_end_dt'] = implode(" ",$arr['salesEndDate']); // 판매기간 시작일
            else $value['gs_sales_end_dt'] = _END_DATE;
        }

        if( !empty($arr['svideo']) )    $value['gs_svideo_url'] = $arr['svideo'];
        if( isset($arr['simgType']) )   $value['gs_simg_type'] = $arr['simgType']; // 썸네일 이미지 등록 방식

/*
$value['upload_path'] = empty($this->preValue['gs_code'])?$value['gs_code']:$this->preValue['gs_code'];
if( $value['gs_simg_type'] == "1" )     unset($value['upload_path']);
 */

        for($i=1;$i<=5;$i++){
            if( isset($arr["simg{$i}Del"]) )   $value["gs_simg{$i}_del"] = $arr["simg{$i}Del"];
            if( isset($arr["simg{$i}"]) )      $value["gs_simg{$i}"] = $arr["simg{$i}"];
        }

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" )     $this->getSearch("gs_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "code" )   $this->getSearch("gs_code",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" )   $this->getSearch("gs_name",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "all" ){
                $this->sql_where .= " and  ( ";
                $this->sql_where .= " ( gs_id like :kwd0 ) or (gs_code like :kwd1) or ( gs_name like :kwd2) or (gs_brand like :kwd3) ";
                $this->sql_where .= " ) ";
                $this->parameter['kwd0'] = "%".$_REQUEST['kwd']."%";
                $this->parameter['kwd1'] = "%".$_REQUEST['kwd']."%";
                $this->parameter['kwd2'] = "%".$_REQUEST['kwd']."%";
                $this->parameter['kwd3'] = "%".$_REQUEST['kwd']."%";
            }
        }

        if( !empty($_REQUEST['goodsId']) )  $this->getParameter("gs_id",$_REQUEST['goodsId']);
        if( !empty($_REQUEST['id']) )       $this->getParameter("gs_id",$_REQUEST['id']);
        if( !empty($_REQUEST['seller']) )   $this->getParameter("sl_id",$_REQUEST['seller']);
        if( !empty($_REQUEST['state']) )    $this->getParameter("gs_stt",$_REQUEST['state']);
        if( !empty($_REQUEST['isopen']) )   $this->getParameter("gs_isopen",$_REQUEST['isopen']);
        if( !empty($_REQUEST['ptOnly']) )   $this->getParameter("gs_pt_only",$_REQUEST['ptOnly']);
        if( !empty($_REQUEST['shop']) ){
            $this->sql_where .= " and ( gs_only_pt_yn = 'n' or ( gs_only_pt_yn = 'y' and gs_only_pt_id = :shop ) ) ";
            $this->parameter['shop'] = $_REQUEST['shop'];
        }
        if( !empty($_REQUEST['leQty']) )    $this->getInterval("gs_stock_qty",$_REQUEST['leQty'],"le");
        if( !empty($_REQUEST['geQty']) )   $this->getInterval("gs_stock_qty",$_REQUEST['geQty'],"ge");
        if( !empty($_REQUEST['gePrice']) )  $this->getInterval("gs_price",$_REQUEST['gePrice'],"ge");
        if( !empty($_REQUEST['lePrice']) )  $this->getInterval("gs_price",$_REQUEST['lePrice'],"le");

        if( !empty($_REQUEST['geViewCnt']) )  $this->getInterval("gs_view_cnt",$_REQUEST['geViewCnt'],"ge");
        if( !empty($_REQUEST['leViewCnt']) )  $this->getInterval("gs_view_cnt",$_REQUEST['leViewCnt'],"le");

        if( !empty($_REQUEST['geOrderQty']) )  $this->getInterval("gs_order_qty",$_REQUEST['geOrderQty'],"ge");
        if( !empty($_REQUEST['leOrderQty']) )  $this->getInterval("gs_order_qty",$_REQUEST['leOrderQty'],"le");        

        if( !empty($_REQUEST['buyUseGrade']) )    $this->getInterval("gs_buy_use_grade",$_REQUEST['buyUseGrade'],"ge");
        if( !empty($_REQUEST['useCtg']) ) {
            $this->sql_where .= " and ( ";
            $ctgList = explode(",",$_REQUEST['useCtg']);
            for($i=0;$i<count($ctgList);$i++){
                if($i!=0) $this->sql_where .= " or ";
                $this->sql_where .= "   gs_ctg like :useCtg1_$i or gs_ctg2 like :useCtg2_$i or gs_ctg3 like :useCtg3_$i  ";
                $this->parameter["useCtg1_".$i] = $ctgList[$i]."%";
                $this->parameter["useCtg2_".$i] = $ctgList[$i]."%";
                $this->parameter["useCtg3_".$i] = $ctgList[$i]."%";
            }
            $this->sql_where .= " ) ";
        }
        if( !empty($_REQUEST['ctg']) ) {
            $this->sql_where .= " and ( ";
            $this->sql_where .= "  gs_ctg like :ctg1 or gs_ctg2 like :ctg2 or gs_ctg3 like :ctg3  ";
            $this->parameter["ctg1"] = $_REQUEST['ctg']."%";
            $this->parameter["ctg2"] = $_REQUEST['ctg']."%";
            $this->parameter["ctg3"] = $_REQUEST['ctg']."%";
            $this->sql_where .= " ) ";
        }

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "salesDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getInterval("gs_sales_begin_dt",$_REQUEST['beg'],"le");
                if( !empty($_REQUEST['end']) ) $this->getInterval("gs_sales_end_dt",$_REQUEST['end'],"ge");
            }
            else if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("gs_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("gs_reg_dt",$_REQUEST['end'],"le");
            }
            else if( $_REQUEST['term'] == "updateDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("gs_update_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("gs_update_dt",$_REQUEST['end'],"le");
            }

        }
        if( !empty($_REQUEST['qtyNoti']) ){
            $this->sql_where .= " and ( gs_stock_qty <= gs_stock_qty_noti ) ";
        }

        //not in
        if( !empty($_REQUEST['notGoodsId']) )  $this->getParameter("gs_id",$_REQUEST['notGoodsId'], 'cons');
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by gs_update_dt desc ";    // 기본 정렬 방식 설정

        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'id' ) $this->sql_order = " order by gs_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'code' ) $this->sql_order = " order by gs_code {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'seller' ) $this->sql_order = " order by sl_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'stockQty' ) $this->sql_order = " order by gs_stock_qty {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'qtyNoti' ) $this->sql_order = " order by gs_stock_qty_noti {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'isopen' ) $this->sql_order = " order by gs_isopen {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'consumerPrice' ) $this->sql_order = " order by gs_consumer_price {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'supplyPrice' ) $this->sql_order = " order by gs_supply_price {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice' ) $this->sql_order = " order by gs_price {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice9' ) $this->sql_order = " order by gs_price_9 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice8' ) $this->sql_order = " order by gs_price_8 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice7' ) $this->sql_order = " order by gs_price_7 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice6' ) $this->sql_order = " order by gs_price_6 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice5' ) $this->sql_order = " order by gs_price_5 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice4' ) $this->sql_order = " order by gs_price_4 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice3' ) $this->sql_order = " order by gs_price_3 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice2' ) $this->sql_order = " order by gs_price_2 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'goodsPrice1' ) $this->sql_order = " order by gs_price_1 {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'viewCnt' ) $this->sql_order = " order by gs_view_cnt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'orderQty' ) $this->sql_order = " order by gs_order_qty {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by gs_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'updateDate' ) $this->sql_order = " order by gs_update_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'best' ) $this->sql_order = " order by gs_order_qty desc ";
            else if( $_REQUEST['col'] == 'new' ) $this->sql_order = " order by gs_reg_dt desc ";
            else if( $_REQUEST['col'] == 'field' && !empty($_REQUEST['goodsId']) ) $this->sql_order = " order by field(gs_id,{$_REQUEST['goodsId']}) ";
        }
        return $this->sql_order;
    }

    function getImg( $simg , $w='', $h='' ){
        $Qt = "https://killdeal.co.kr/data/goods/{$simg}";
        return "<img src='".$Qt."' width=".$w." class='gs_img'>";
    }    

    public function set($arr,$id,$type="arr"){
        if( empty($arr) ) return "002";
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $this->preValue = $this->get("*", array("gs_id"=>$id));
        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $upload_path = empty($this->preValue['gs_code'])?$value['gs_code']:$this->preValue['gs_code'];
        if( !empty($upload_path) ) $res = $this->uploadImg(_ROOT._GOODS.$upload_path,$value);

        $search = " and gs_id = '{$id}' ";
        $res = $this->update($value,$search);
        if( $res == "000" ){
            $exclude = array('gs_detail_content','gs_update_dt','gs_sales_begin_dt','gs_sales_end_dt','gs_info_value');
            $data = $this->addLog($id,$value,$exclude,"수정");
        }
        return $res;
    }

    public function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $sellerModel = new \application\models\SellerModel();
        $seller = $sellerModel->get("sl_only_pt_yn,sl_only_pt_id",array("sl_id"=>$value['sl_id']));
        $value['gs_only_pt_yn'] = $seller['sl_only_pt_yn'];
        $value['gs_only_pt_id'] = $seller['sl_only_pt_id'];

        $upload_path = $value['gs_code'];
        if( !empty($upload_path) ) $res = $this->uploadImg(_ROOT._GOODS.$upload_path,$value);

        $res = $this->insert($value);
        if($res=="000"){
            $data = $this->addLog($this->pdo->lastInsertId(),array(),array(),"등록");
        }
        return $res;
    }

    function remove($id){
        if( empty($id) ) return "002";

        $row = $this->get("gs_code", array("gs_id"=>$id));
        $upl = new \application\models\UploadImage(_ROOT._GOODS);
        //$upl->set_rename($row["gs_code"]);
        $upl->del($row["gs_code"]);
        $search = " and gs_id = '{$id}' ";
        $res = $this->delete($search);
        if( $res == "000" ){
            $data = $this->addLog($id,array(),array(),"삭제");
        }
        return $res;
    }

    function remove_request($id){
        $value['gs_stt'] = "4";
        return $this->set($value, $id, "value");
    }

    function defer($id){
        $value['gs_stt'] = "3";
        return $this->set($value, $id, "value");
    }

    function approval($id){
        $value['gs_stt'] = "2";
        $value['gs_update_dt'] = _DATE_YMDHIS; //수정 일시
        return $this->set($value, $id, "value");
    }

    function wait($id){
        $value['gs_stt'] = "1";
        return $this->set($value, $id, "value");
    }

    function duplication($id){
        $exclude = array('gs_id','gs_stt','gs_reg_dt','gs_update_dt');
        $col = get_column(array_keys($this->col_nm),$exclude,false);
        $value = $this->get($col, array("gs_id"=>$id) );
        if( $value['gs_simg_type'] == 0 ){
            $value['gs_simg1'] = !empty($value['gs_simg1'])?_URL._GOODS.$value['gs_code']."/".$value['gs_simg1']:"";
            $value['gs_simg2'] = !empty($value['gs_simg2'])?_URL._GOODS.$value['gs_code']."/".$value['gs_simg2']:"";
            $value['gs_simg3'] = !empty($value['gs_simg3'])?_URL._GOODS.$value['gs_code']."/".$value['gs_simg3']:"";
            $value['gs_simg4'] = !empty($value['gs_simg4'])?_URL._GOODS.$value['gs_code']."/".$value['gs_simg4']:"";
            $value['gs_simg5'] = !empty($value['gs_simg5'])?_URL._GOODS.$value['gs_code']."/".$value['gs_simg5']:"";
        }else{
            $value['gs_simg1'] = !empty($value['gs_simg1'])?$value['gs_simg1']:"";
            $value['gs_simg2'] = !empty($value['gs_simg2'])?$value['gs_simg2']:"";
            $value['gs_simg3'] = !empty($value['gs_simg3'])?$value['gs_simg3']:"";
            $value['gs_simg4'] = !empty($value['gs_simg4'])?$value['gs_simg4']:"";
            $value['gs_simg5'] = !empty($value['gs_simg5'])?$value['gs_simg5']:"";
        }
        $value['gs_code'] = get_gs_code();
        $value['upload_path'] = $value['gs_code'];
        $value['gs_reg_dt'] = _DATE_YMDHIS;
        $value['gs_update_dt'] = _DATE_YMDHIS;
        $res = $this->add($value,"value");
        return $res;
    }

    function onlyPartner($seller, $yn, $pt_id){
        if(empty($seller)) return "002";
        try{
            $sql = "update ".$this->tb_nm." SET gs_only_pt_yn = :gs_only_pt_yn, gs_only_pt_id = :gs_only_pt_id where sl_id='{$seller}'";
            $arr = array("gs_only_pt_yn"=>$yn,"gs_only_pt_id"=>$yn=="y"?$pt_id:"");
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($arr);
            if($stmt->rowCount() > 0){
                debug_log( static::class,"000",array("sql"=>$sql,"arr"=>$arr)); 
                return "000";
            }else{
                debug_log( static::class,"001",array("sql"=>$sql,"arr"=>$arr)); 
                return "001";
            }
        }catch (PDOException $e) {
            debug_log( static::class,"009",array("sql"=>$sql,"res"=>$arr,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    function viewCnt($id){
        $sql = "update ".$this->tb_nm." set gs_view_cnt = gs_view_cnt + 1 where gs_id = '".$id."' ";
        return $this->execute( $sql );
    }

    function orderQty($id,$optId, $qty, $order=true){
        if($order){
            $sql = "update ".$this->tb_nm." set gs_order_qty = gs_order_qty + {$qty} where gs_id = '".$id."' ";
        }else{
            // 아직 적용하지 않음
            $sql = "update ".$this->tb_nm." set gs_order_qty = gs_order_qty - {$qty} where gs_id = '".$id."' ";
        }
        return $this->execute( $sql );
    }

    function stockCnt($id,$optId,$qty,$order=true){
        $optionModel = new \application\models\GoodsOptionModel();
        $optionModel->order($optId,$qty,$order);
        if($order){
            $sql = "update ".$this->tb_nm." set gs_stock_qty = gs_stock_qty - $qty where gs_id = '".$id."' ";
            $res = $this->execute( $sql );

            $row = $this->get("gs_stock_qty,gs_stock_qty_noti,gs_id,sl_id,gs_name",array("gs_id"=>$id));
            if( $row['gs_stock_qty'] < $row['gs_stock_qty_noti'] ){
                $templateModel = new \application\models\TemplateModel();
                $goodsName = "[{$row['gs_id']}] {$row['gs_name']}";
                //$templateModel->sendMail($row['sl_id'],10,array("goodsName"=>$goodsName));
            }
            return $res;
        }else{
            $sql = "update ".$this->tb_nm." set gs_stock_qty = gs_stock_qty + $qty where gs_id = '".$id."' ";
            return $this->execute( $sql );
        }
    }

    function order($id,$optId, $qty, $order=true){
        $this->orderQty($id,$optId, $qty, $order);
        $this->stockCnt($id,$optId, $qty, $order);
        return;
    }

}
?>
