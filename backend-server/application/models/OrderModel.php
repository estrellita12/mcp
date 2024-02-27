<?php
namespace application\models;

use \Exception;

class OrderModel extends Model{ 

    var $colArr;

    public function __construct( ){
        try{
            parent::__construct ( 'web_order' );
            $this->colArr = array(
                "odId"=>"od_id",
                "odNo"=>"od_no",
                "state"=>"od_stt",
                "orderDate"=>"od_dt",
                "cancelDate"=>"od_cancel_dt",
                "returnDate"=>"od_return_dt",
                "invoiceDate"=>"od_invoice_dt",
                "goodsId"=>"gs_id",
                "goodsInfo"=>"od_goods_info",
                "goodsPrice"=>"od_goods_price",
                "qty"=>"od_qty",
                "amount"=>"od_amount",
                "cancelAmount"=>"od_cancel_amount",
                "returnAmount"=>"od_return_amount",
                "point"=>"od_use_point",
                "coupon"=>"od_use_coupon",
                "seller"=>"sl_id",
                "deliveryCharge"=>"od_delivery_charge",
                "deliveryChargeDosan"=>"od_delivery_charge_dosan",
                "deliveryCompany"=>"od_delivery_company",
                "deliveryNo"=>"od_delivery_no",
                "userId" =>"mb_id",
                "userName" => "orderer_name",
                "userEmail" => "orderer_email",
                "userCellphone" => "orderer_cellphone",
                "receiverName" => "receiver_name",
                "receiverEmail" => "receiver_email",
                "receiverCellphone" => "receiver_cellphone",
                "receiverZip" => "receiver_zip",
                "receiverAddr1" => "receiver_addr1",
                "receiverAddr2" => "receiver_addr2",
                "receiverDeliveryMsg" => "receiver_delivery_msg",
                "paymentsId"=>"od_payment_id",
                "paymethod"=>"od_paymethod",
                "cancelReason"=>"od_cancel_reason",
                "returnReason"=>"od_return_reason",
                "teamId"=>"od_team_id",
                "review"=>"od_review_yn",
                "rcentDate"=>"od_rcent_dt",
            );
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }

    public function getGoodsInfo($opt_id){
        try{
            $goods = new \application\models\GoodsModel();
            $goods->leftJoin("gs_id","web_goods_option","gs_id");
            $col = " gs_simg_type as simgType";
            $col .= ", if(gs_simg1 != '', concat('"._GOODS."',gs_code,'/',gs_simg1), '') as simg1";
            $col .= ", if(gs_simg1 != '', concat('"._GOODS."',gs_code,'/thumb/',gs_simg1), '') as timg1";
            $col .= ", gs_id as goodsId";
            $col .= ", gs_code as goodsCode";
            $col .= ", gs_brand as brand";
            $col .= ", sl_id as seller";
            $col .= ", gs_name as goodsName";
            $col .= ", gs_consumer_price as consumerPrice";
            $col .= ", gs_claim_delivery_charge as claimDeliveryCharge";
            $col .= ", gs_delivery_type as deliveryType";
            $col .= ", gs_delivery_charge as deliveryCharge";
            $col .= ", gs_delivery_free as deliveryFree";
            $col .= ", gs_delivery_each_use as deliveryEachUse";
            $col .= ", gs_opt_name as optionName";
            $col .= ", gs_opt_stock_qty as optionStockQty";
            $col .= ", gs_opt_add_price as addPrice";
            //$col .= ", b.gs_opt_supply_price as optionSupplyPrice";
            $col .= ", gs_opt_supply_price as supplyPrice";
            //$col .= ", gs_opt_id as gs_opt_id"; // 검색을 위한 키
            return $goods->get($col,array("gs_opt_id"=>$opt_id));
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }

    public function getValue($arr,$mode="add"){
        try{
            if( empty($arr) ) return;

            if($mode=="add"){
                //$value['od_id'] = $arr['id']; // 주문 일련번호
                $value['od_no'] = $arr['no']; // 주문 번호
                $value['od_dt'] = _DATE_YMDHIS; // 주문 일시
                if( !empty($arr['goodsId']) )           $value['gs_id'] = $arr['goodsId']; 
                if( !empty($arr['optionId']) )          $value['gs_opt_id'] = $arr['optionId'];
                $od_goods_info = $this->getGoodsInfo($arr['optionId']);
                $value['od_goods_info'] = json_encode($od_goods_info);
                $value['od_supply_price'] = $od_goods_info['supplyPrice'] * $arr['qty'];
                $value['sl_id'] = $od_goods_info['seller'];
                //if( !empty($arr['seller']) )            $value['sl_id'] = $arr['seller'];
                if( !empty($arr['paymethod']) )         $value['od_paymethod'] = $arr['paymethod']; 
                if( !empty($arr['shop']) )              $value['pt_id'] = $arr['shop'];
                if( !empty($arr['passwd']) )            $value['od_passwd'] = $arr['passwd'];
                if( !empty($arr['teamId']) )            $value['od_team_id'] = $arr['teamId'];
                if( isset($arr['state']) )              $value['od_stt'] = $arr['state'];
                $value['od_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['od_device'] = $_SERVER["HTTP_USER_AGENT"]; 
            }

            if( !empty($arr['userId']) )            $value['mb_id'] = $arr['userId']; // 주문자 아이디
            if( !empty($arr['userName']) )          $value['orderer_name'] = $arr['userName']; // 주문자 아이디
            if( !empty($arr['userEmail']) )         $value['orderer_email'] = $arr['userEmail']; 
            if( !empty($arr['userCellphone']) )     $value['orderer_cellphone'] = $arr['userCellphone']; 
            if( !empty($arr['userZip']) )           $value['orderer_zip'] = $arr['userZip']; 
            if( !empty($arr['userAddr1']) )         $value['orderer_addr1'] = $arr['userAddr1']; 
            if( !empty($arr['userAddr2']) )         $value['orderer_addr2'] = $arr['userAddr2']; 
            if( !empty($arr['userAddr3']) )         $value['orderer_addr3'] = $arr['userAddr3']; 
            if( !empty($arr['receiverName']) )      $value['receiver_name'] = $arr['receiverName']; 
            if( !empty($arr['receiverEmail']) )     $value['receiver_email'] = $arr['receiverEmail']; 
            if( !empty($arr['receiverCellphone']) ) $value['receiver_cellphone'] = $arr['receiverCellphone']; 
            if( !empty($arr['receiverZip']) )       $value['receiver_zip'] = $arr['receiverZip']; 
            if( !empty($arr['receiverAddr1']) )     $value['receiver_addr1'] = $arr['receiverAddr1']; 
            if( !empty($arr['receiverAddr2']) )     $value['receiver_addr2'] = $arr['receiverAddr2']; 
            if( !empty($arr['receiverAddr3']) )     $value['receiver_addr3'] = $arr['receiverAddr3']; 
            if( !empty($arr['receiverDeliveryMsg']) )   $value['receiver_delivery_msg'] = $arr['receiverDeliveryMsg']; 
            //if( !empty($arr['sellerPayState']) )    $value['seller_pay_stt'] = $arr['sellerPayState'];
            //if( !empty($arr['partnerPayState']) )   $value['partner_pay_stt'] = $arr['partnerPayState'];
            if( !empty($arr['getPoint']) )          $value['od_get_point'] = $arr['getPoint']; 
            if( !empty($arr['qty']) )               $value['od_qty'] = $arr['qty']; 
            if( !empty($arr['goodsPrice']) )        $value['od_goods_price'] = $arr['goodsPrice'];
            if( !empty($arr['supplyPrice']) )       $value['od_supply_price'] = $arr['supplyPrice'];
            if( !empty($arr['point']) )             $value['od_use_point'] = $arr['point'];
            if( !empty($arr['pointIn']) )             $value['od_use_point_in'] = $arr['pointIn'];
            if( !empty($arr['pointOut']) )             $value['od_use_point_out'] = $arr['pointOut'];
            if( !empty($arr['coupon']) )            $value['od_use_coupon'] = $arr['coupon'];
            if( !empty($arr['couponId']) )          $value['cp_id'] = $arr['couponId'];
            if( !empty($arr['deliveryType']) )      $value['od_delivery_type'] = $arr['deliveryType']; // 배송비 유형
            if( !empty($arr['deliveryCharge']) )     $value['od_delivery_charge'] = $arr['deliveryCharge']; 
            if( !empty($arr['deliveryChargeDosan']) )     $value['od_delivery_charge_dosan'] = $arr['deliveryChargeDosan']; 
            if( !empty($arr['amount']) )            $value['od_amount'] = $arr['amount'];
            if( !empty($arr['cancelAmount']) )      $value['od_cancel_amount'] = $arr['cancelAmount'];
            if( !empty($arr['returnAmount']) )      $value['od_return_amount'] = $arr['returnAmount'];
            if( !empty($arr['vbank']) )             $value['od_vbank'] = $arr['vbank'];
            if( !empty($arr['vbankDeposit']) )      $value['od_vbank_deposit'] = $arr['vbankDeposit'];
            //if( !empty($arr['payDate']) )           $value['od_pay_dt'] = $arr['payDate'];
            if( !empty($arr['deliveryCompany']) )     $value['od_delivery_company'] = $arr['deliveryCompany']; 
            if( !empty($arr['deliveryNo']) )     $value['od_delivery_no'] = $arr['deliveryNo']; 
            if( !empty($arr['deliveryCompany2']) )     $value['od_delivery_company2'] = $arr['deliveryCompany2']; 
            if( !empty($arr['deliveryNo2']) )     $value['od_delivery_no2'] = $arr['deliveryNo2']; 
            if( !empty($arr['deliveryCompany3']) )     $value['od_delivery_company3'] = $arr['deliveryCompany3']; 
            if( !empty($arr['deliveryNo3']) )     $value['od_delivery_no3'] = $arr['deliveryNo3']; 
            if( !empty($arr['deliveryCompany4']) )     $value['od_delivery_company4'] = $arr['deliveryCompany4']; 
            if( !empty($arr['deliveryNo4']) )     $value['od_delivery_no4'] = $arr['deliveryNo4']; 
            //if( !empty($arr['deliveryDate']) )           $value['od_delivery_dt'] = $arr['deliveryDate'];
            //if( !empty($arr['invoiceDate']) )           $value['od_invoice_dt'] = $arr['invoiceDate'];
            //if( !empty($arr['cancelDate']) )           $value['od_cancel_dt'] = $arr['cancelDate'];
            //if( !empty($arr['returnDate']) )           $value['od_return_dt'] = $arr['returnDate'];
            //if( !empty($arr['changeDate']) )           $value['od_change_dt'] = $arr['changeDate'];
            if( !empty($arr['claimDeliveryCharge']) )           $value['od_claim_delivery_charge'] = $arr['claimDeliveryCharge'];
            if( !empty($arr['changeDeliveryCharge']) )           $value['od_claim_delivery_charge'] = $arr['changeDeliveryCharge'];
            if( !empty($arr['returnDeliveryCharge']) )           $value['od_claim_delivery_charge'] = $arr['returnDeliveryCharge'];
            if( !empty($arr['cancelReason']) )           $value['od_cancel_reason'] = $arr['cancelReason'];
            if( !empty($arr['returnReason']) )           $value['od_return_reason'] = $arr['returnReason'];
            if( !empty($arr['changeOptId']) )           $value['od_change_opt_id'] = $arr['changeOptId'];
            if( !empty($arr['changeMessage']) )           $value['od_change_msg'] = $arr['changeMessage'];
            if( !empty($arr['confirm']) )           $value['od_confirm_yn'] = $arr['confirm']; 
            if( !empty($arr['review']) )           $value['od_review_yn'] = $arr['review']; 
            //if( !empty($arr['confirmDate']) )           $value['od_confirm_dt'] = $arr['confirmDate'];

            if( !empty($arr['test']) )              $value['od_test'] = $arr['test']; 
            if( !empty($arr['pgMid']) )             $value['od_pg_mid'] = $arr['pgMid']; 
            if( !empty($arr['pgCompany']) )         $value['od_pg_company'] = $arr['pgCompany']; 
            if( !empty($arr['paymentId']) )         $value['od_payment_id'] = $arr['paymentId']; 
            if( !empty($arr['escrowYn']) )         $value['od_escrow_yn'] = $arr['escrowYn']; 
            if( !empty($arr['taxFlag']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['taxMoney']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['vatMoney']) )         $value['od_tax_flag'] = $arr['taxFlag']; 
            if( !empty($arr['freeMoney']) )         $value['od_tax_flag'] = $arr['taxFlag']; 

            if( !empty($arr['taxInvoice']) )           $value['od_tax_invoice'] = $arr['taxInvoice'];
            if( !empty($arr['taxSaveInfo']) )           $value['od_taxsave_info'] = $arr['taxSaveInfo'];
            if( !empty($arr['taxBillInfo']) )           $value['od_taxbill_info'] = $arr['taxBillInfo'];
            if( !empty($arr['cashYn']) )         $value['od_cash_yn'] = $arr['cashYn']; 
            if( !empty($arr['cashNo']) )         $value['od_cash_no'] = $arr['cashNo']; 
            if( !empty($arr['cashInfo']) )         $value['od_cash_info'] = $arr['cashInfo']; 
            if( !empty($arr['state']) )         $value['od_stt'] = $arr['state']; 
            if( !empty($arr['memo']) )              $value['od_adm_memo'] = $arr['memo'];  
            if( !empty($arr['rcentDate']) )              $value['od_rcent_dt'] = $arr['rcentDate'];  
            return $value;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }

    function getWhere(){
        parent::getWhere();
        $this->sql_where .= " and od_stt != '0' ";            
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd'])){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("od_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "no" ) $this->getSearch("od_no",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "goodsId" ) $this->getSearch("gs_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "userId" ) $this->getSearch("mb_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "userName" ) $this->getSearch("orderer_name",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "userCellphone" ) $this->getSearch("orderer_cellphone",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['id']) ) $this->getParameter("od_id",$_REQUEST['id']);
        if( !empty($_REQUEST['no']) ) $this->getParameter("od_no",$_REQUEST['no']);
        if( !empty($_REQUEST['odId']) ) $this->getParameter("od_id",$_REQUEST['odId']);
        if( !empty($_REQUEST['odNo']) ) $this->getParameter("od_no",$_REQUEST['odNo']);
        if( !empty($_REQUEST['userId']) ) $this->getParameter("mb_id",$_REQUEST['userId']);
        if( !empty($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['seller']) ) $this->getParameter("sl_id",$_REQUEST['seller']);
        if( !empty($_REQUEST['paymethod']) ) $this->getParameter("od_paymethod",$_REQUEST['paymethod']);
        if( !empty($_REQUEST['state']) ) $this->getParameter("od_stt",$_REQUEST['state']);
        if( !empty($_REQUEST['confirm']) ) $this->getParameter("od_confirm_yn",$_REQUEST['confirm']);
        if( !empty($_REQUEST['review']) ) $this->getParameter("od_review_yn",$_REQUEST['review']);
        if( !empty($_REQUEST['teamId']) ) $this->getParameter("od_team_id",$_REQUEST['teamId']);
        if( !empty($_REQUEST['partnerPay']) ) {
            $order = " ( od_stt in ({$GLOBALS['od_stt_type']['정산']}) and partner_pay_stt = '1' )  ";
            $cancel = " ( od_stt = '37' and partner_pay_stt = '3' ) ";
            if($_REQUEST['partnerPay'] == 'list'){
                $this->sql_where .= " and ( {$order} or {$cancel} )";
            }else if($_REQUEST['partnerPay'] == 'order'){
                $this->sql_where .= " and {$order} ";
            }else if($_REQUEST['partnerPay'] == 'cancel'){
                $this->sql_where .= " and {$cancel} ";
            }
        }
        if( !empty($_REQUEST['sellerPay']) ) {
            $order = " ( od_stt in ({$GLOBALS['od_stt_type']['정산']}) and seller_pay_stt = '1' ) ";
            $cancel = " ( od_stt = '37' and ( seller_pay_stt = '3') ) ";
            $delivery = " ( ( od_stt = '29' and seller_pay_stt = '3' ) or ( od_stt = '37' and seller_pay_stt = '1' ) ) ";
            if($_REQUEST['sellerPay'] == 'list'){
                $this->sql_where .= " and ( {$order} or {$cancel} or {$delivery} )";
            }else if($_REQUEST['sellerPay'] == 'order'){
                $this->sql_where .= " and {$order} ";
            }else if($_REQUEST['sellerPay'] == 'cancel'){
                $this->sql_where .= " and {$cancel} ";
            }else if($_REQUEST['sellerPay'] == 'delivery'){
                $this->sql_where .= " and {$delivery} ";
            }
        }

        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "orderDate" ){
                if( !empty($_REQUEST['beg']) ) $this->getTerm("od_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("od_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "rcentDate" ) {
                if( !empty($_REQUEST['beg']) ) $this->getTerm("od_rcent_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("od_rcent_dt",$_REQUEST['end'],"le");
            }
        }

        //not in
        if( !empty($_REQUEST['exceptList']) )  $this->getParameter("od_id",$_REQUEST['exceptList'], 'cons');
        if( !empty($_REQUEST['exceptState']) )  $this->getParameter("od_stt",$_REQUEST['exceptState'], 'cons');
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by od_dt desc,gs_id,gs_opt_id ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'desc';
            if( $_REQUEST['col'] == 'orderDate' ) $this->sql_order = " order by od_dt {$_REQUEST['colby']} ";
            if( $_REQUEST['col'] == 'rcentDate' ) $this->sql_order = " order by od_rcent_dt {$_REQUEST['colby']} ";
        }
    }

    public function set($arr,$id,$type="arr"){
        try{
            if( empty($arr) ) return "002";
            if( empty($id) ) $id = $arr['id'];
            if( empty($id) ) return "002";
            $this->preValue = $this->get("*",array("od_id"=>$id));
            if($type=="arr") $value = $this->getValue($arr,'set');
            else $value = $arr;

            $search = " and od_id = '{$id}' ";
            $res = $this->update($value,$search);

            if( $res == "000" ){
                $exclude = array();
                $data = $this->addLog($id,$value,$exclude,"수정");
            }
            return $res;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }

    public function add($arr, $type="arr"){
        try{
            if($type=="arr") $value = $this->getValue($arr,'add');
            else $value = $arr;

            $res = $this->insert($value);
            if($res=="000"){
                $this->addLog($this->pdo->lastInsertId(),array(),array(),"등록");
            }
            return $res;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }
    }
/*
    function getNoList($no, $col="*"){
        if( empty($id) ) return "002";
        $sql_where = " and od_id = '{$id}' ";
        $row = $this->selectAll( $col, $sql_where );
        return $row;
    }

    function setNo($arr,$no,$type='arr'){
        if(empty($no)) $no=$arr['no'];
        if(empty($no)) return "002";

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and od_no = '{$no}' ";
        $res = $this->update($value,$search);
        return $res;
    }
 */
    public function calcUnion($beg,$end, $type="partner"){
        try{
            $pay_col = "partner_pay_stt";
            if($type == "seller"){
                $pay_col = "seller_pay_stt";
            }
            //$basicCol = "sl_id, pt_id, od_id, od_stt, od_qty, od_goods_info, {$pay_col}, od_goods_price, od_use_point, od_use_coupon, od_cancel_amount, od_return_amount, od_supply_price, od_claim_delivery_charge";
            $orderCol = "'order' as type, sl_id, pt_id, od_id, od_stt, od_qty, od_goods_info, {$pay_col}";
            $orderCol .= ", od_goods_price, od_supply_price, od_use_point, od_use_coupon";
            $orderCol .= ", od_amount";
            $orderCol .= ", 0 as od_cancel_price";
            $orderCol .= ", od_delivery_charge, od_delivery_charge_dosan";
            $orderCol .= ", if(od_stt = 29,od_claim_delivery_charge,0) as od_claim_delivery_charge";
            $orderSql = " select {$orderCol} from {$this->tb_nm} where ";
            $orderSql .= " od_stt in ({$GLOBALS['od_stt_type']['정산']}) ";
            $orderSql .= " and {$pay_col} = 1 ";
            $orderSql .= " and od_dt >= '{$beg} 00:00:00' ";
            $orderSql .= " and od_dt <= '{$end} 23:59:59' ";
            $orderSql .= " and od_delivery_dt >= '{$beg} 00:00:00' ";
            $orderSql .= " and od_delivery_dt <= '{$end} 23:59:59' ";

            $cancelCol = "'cancel' as type, sl_id, pt_id, od_id, od_stt, od_qty, od_goods_info, {$pay_col}";
            $cancelCol .= ", od_goods_price * -1 as od_goods_price";
            $cancelCol .= ", od_supply_price * -1 as od_supply_price";
            $cancelCol .= ", od_use_point * -1 as od_use_point";
            $cancelCol .= ", od_use_coupon * -1 as od_use_coupon";
            $cancelCol .= ", od_use_coupon * -1 as od_amount";
            $cancelCol .= ", (od_cancel_amount + od_return_amount) as od_cancel_price ";
            $cancelCol .= ", 0 as od_delivery_charge, 0 as od_delivery_charge_dosan";
            $cancelCol .= ", od_claim_delivery_charge";
            $cancelSql = " select {$cancelCol} from {$this->tb_nm} where ";
            $cancelSql .= " od_stt = 37 ";
            $cancelSql .= " and {$pay_col} = 3 ";
            $cancelSql .= " and od_dt < '{$beg} 00:00:00' ";
            $cancelSql .= " and od_return_dt >= '{$beg} 00:00:00' ";
            $cancelSql .= " and od_return_dt <= '{$end} 23:59:59' ";

            $deliveryCol = "'delivery' as type, sl_id, pt_id, od_id, od_stt, od_qty, od_goods_info, {$pay_col}";
            $deliveryCol .= ", 0 as od_goods_price";
            $deliveryCol .= ", 0 as od_supply_price";
            $deliveryCol .= ", 0 as od_use_point";
            $deliveryCol .= ", 0 as od_use_coupon";
            $deliveryCol .= ", 0 as od_amount";
            $deliveryCol .= ", 0 as od_cancel_price";
            $deliveryCol .= ", 0 as od_delivery_charge, 0 as od_delivery_charge_dosan";
            $deliveryCol .= ", od_claim_delivery_charge";
            $deliverySql = " select {$deliveryCol} from {$this->tb_nm} where ";
            $deliverySql .= " od_stt = 29 ";
            $deliverySql .= " and {$pay_col} = 3 ";
            $deliverySql .= " and od_dt < '{$beg} 00:00:00' ";
            $deliverySql .= " and od_change_dt >= '{$beg} 00:00:00' ";
            $deliverySql .= " and od_change_dt <= '{$end} 23:59:59'";

            $this->sql_from = " ( {$orderSql} union {$cancelSql} union {$deliverySql} ) as c ";
            $this->col_nm = array(
                "type"=>"",
                "sl_id"=>"공급사아이디",
                "pt_id"=>"",
                "od_id"=>"주문아이디",
                "od_stt"=>"",
                "od_qty"=>"",
                "od_goods_info"=>"",
                "od_goods_price"=>"상품가격",
                "od_supply_price"=>"",
                "od_use_point"=>"",
                "od_use_coupon"=>"",
                "od_amount"=>"",
                "od_cancel_amount"=>"",
                "od_return_amount"=>"",
                "od_delivery_charge"=>"",
                "od_delivery_charge_dosan"=>"",
                "od_claim_delivery_charge"=>"",
            );
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function partnerCalculate($id, $type="calc"){
        try{
            if($type=="calc"){
                $res1 = $this->execute(" update {$this->tb_nm} set partner_pay_stt = 2 where partner_pay_stt = 1 and od_id in ($id) ");
                $res2 = $this->execute(" update {$this->tb_nm} set partner_pay_stt = 4 where partner_pay_stt = 3 and od_id in ($id) ");
            }else if($type == "cancel"){
                $res1 = $this->execute(" update {$this->tb_nm} set partner_pay_stt = 1 where partner_pay_stt = 2 and od_id in ($id) ");
                $res2 = $this->execute(" update {$this->tb_nm} set partner_pay_stt = 3 where partner_pay_stt = 4 and od_id in ($id) ");
            }
            return $res1;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    /*
    function sellerCalculate($id, $type="calc"){
        $row = $this->get("seller_pay_stt", array("od_id"=>$id));
        $stt = $row['seller_pay_stt'];
        if($type=="calc"){
            if( $stt == 1 ) $value['seller_pay_stt'] = 2;
            else if( $stt == 3 ) $value['seller_pay_stt'] = 4;
            else return "004";
        }else if($type == "cancel"){
            if( $stt == 2 ) $value['seller_pay_stt'] = 1;
            else if( $stt == 4 ) $value['seller_pay_stt'] = 3;
            else return "004";
        }
        return $this->set($value,$id,"sql");
    }
     */

    public function sellerCalculate($id, $type="calc"){
        try{
            if($type=="calc"){
                $res1 = $this->execute(" update {$this->tb_nm} set seller_pay_stt = 2 where seller_pay_stt = 1 and od_id in ($id) ");
                $res2 = $this->execute(" update {$this->tb_nm} set seller_pay_stt = 4 where seller_pay_stt = 3 and od_id in ($id) ");
            }else if($type == "cancel"){
                $res1 = $this->execute(" update {$this->tb_nm} set seller_pay_stt = 1 where seller_pay_stt = 2 and od_id in ($id) ");
                $res2 = $this->execute(" update {$this->tb_nm} set seller_pay_stt = 3 where seller_pay_stt = 4 and od_id in ($id) ");
            }
            return $res1;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function changeState($stt, $id, $arr='', $by=''){
        try{
            $this->preOrder = $this->get("*", array("od_id"=>$id));
            $csValue['odId'] = $this->preOrder['od_id'];
            $csValue['odNo'] = $this->preOrder['od_no'];
            $csValue['userId'] = $this->preOrder['mb_id'];
            $csValue['statePre'] = $this->preOrder['od_stt'];
            $csValue['state'] = $stt;
            $csValue['type'] = empty($arr['type'])?"SYSTEM":$arr['type'];
            $csValue['message'] = $arr['message'];
            $csValue['byId'] = $_SESSION['user_id'];
            $csValue['byIdType'] = "";

            $method = "changeState".$stt;
            if(method_exists($this,$method)){
                $res = $this->$method($id,$arr);
            }else{
                $value = array();
                $value['od_stt'] = $stt;
                $value['od_rcent_dt'] = _DATE_YMDHIS;
                $res = $this->set($value,$id,"state");
            }

            if($res == "000"){
                $cs  = new \application\models\CustomerServiceModel(); 
                $cs->add( $csValue, $by );
            }
            return $res;

        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }

    }

    function getStateCnt($goodsId,$state,$memberId=null){
        if( empty($goodsId) || empty($state) ) return "002";
        $col = "COUNT(*) AS cnt";
        $sql_where = " and gs_id = '{$goodsId}' and od_stt = '{$state}' ";
        if($memberId) $sql_where .= " and mb_id = '{$memberId}' ";
        $result = $this->select( $col, $sql_where );        
        $cnt = !empty($result['cnt']) ? $result['cnt'] : null;
        return $cnt;        
    }

    function changeState1($id,$arr=''){
        $value['od_stt'] = "1";
        //$value['od_pay_dt'] = '';
        $value['od_id'] = $id;
        return $this->set($value,$id,"state");
    }

    function changeState2($id,$arr=''){
        $value['od_stt'] = "2";
        if( !empty($arr['requestDate']) )  $value['od_pay_request_dt'] = $arr['requestDate'];
        $value['od_pay_approved_dt'] = $arr['approvedDate'];
        $value['od_id'] = $id;
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        $value['od_pg_mid'] = $arr['pgMid'];
        $value['od_pg_company'] = $arr['pgCompany'];
        $value['od_payment_id'] = $arr['paymentId'];
        $value['od_escrow_yn'] = $arr['escrowYn'];
        $value['od_response_msg'] = $arr['responseMsg'];

        $row = $this->get("od_qty,gs_id,gs_opt_id",array("od_id"=>$id));
        $goodsModel = new \application\models\GoodsModel();
        $goodsModel->order($row['gs_id'],$row['gs_opt_id'],$row['od_qty'],true);
        return $this->set($value,$id,"state");
    }

    function changeState3($id,$arr=''){
        //team update (ALLDEAL ONLY)
        if($this->preOrder['pt_id'] == 'alldeal'){
            $teamId = $this->preOrder['od_team_id'];
            $team = new \application\models\OrderTeamModel();
            $teamRes = $team->set(array("teamStatus" => 'go'), $teamId);
            if($teamRes != "000") return $teamRes;
        };

        //order update
        $value['od_stt'] = "3";
        $value['od_id'] = $id;
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }    

    function changeState13($id,$arr=''){
        $value['od_stt'] = "13";
        $value['od_delivery_company'] = $arr['deliveryCompany'];
        $value['od_delivery_no'] = $arr['deliveryNo'];
        $value['od_delivery_dt'] = _DATE_YMDHIS;
        $value['od_id'] = $id;
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState14($id,$arr=''){
        $value['od_stt'] = "14";
        $value['od_invoice_dt'] = _DATE_YMDHIS;
        $value['od_id'] = $id;
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState21($id,$arr=''){
        if(!empty($arr['changeOptId'])) $value['od_change_opt_id'] = $arr['changeOptId'];
        $value['od_return_request_dt'] = _DATE_YMDHIS;
        $value['od_change_msg'] = $arr['changeMessage'];
        $value['od_stt'] = "21";
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState22($id,$arr=''){
        // 배송비 결제 > 성공시 아래 코드 동작
        $value['od_claim_delivery_charge'] = $arr['changeDeliveryCharge'];
        $value['od_stt'] = "22";
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"value");
    }

    function changeState23($id,$arr=''){
        $value['od_stt'] = "23";
        $value['od_delivery_company2'] = $arr['deliveryCompany2'];
        $value['od_delivery_no2'] = $arr['deliveryNo2'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState27($id,$arr=''){
        $value['od_stt'] = "27";
        $value['od_delivery_company3'] = $arr['deliveryCompany3'];
        $value['od_delivery_no3'] = $arr['deliveryNo3'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState29($id,$arr=''){
        $value['od_stt'] = "29";
        $value['od_change_dt'] = _DATE_YMDHIS;
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState31($id,$arr=''){
        $value['od_stt'] = "31";
        $value['od_return_request_dt'] = _DATE_YMDHIS;
        $value['od_return_reason'] = empty($arr['returnReason'])?"미입력":$arr['returnReason'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState33($id,$arr=''){
        $value['od_stt'] = "33";
        $value['od_delivery_company4'] = $arr['deliveryCompany4'];
        $value['od_delivery_no4'] = $arr['deliveryNo4'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"state");
    }

    function changeState37($id,$arr=''){
        $value['od_stt'] = "37";
        $value['od_return_dt'] = _DATE_YMDHIS;
        $value['od_rcent_dt'] = _DATE_YMDHIS;

        if($this->preOrder['seller_pay_stt']=="2")      $value['seller_pay_stt'] = 3;
        if($this->preOrder['partner_pay_stt']=="2")     $value['partner_pay_stt'] = 3;

        $res = $this->set($value,$id,"state");
        if($res=="000"){
            $this->cancel($id,$arr,"return");
            $row = $this->get("od_qty,gs_id,gs_opt_id",array("od_id"=>$id));
            $goodsModel = new \application\models\GoodsModel();
            //$goodsModel->orderQty($row['gs_id'],$row['gs_opt_id'],$row['od_qty'],false);
            $goodsModel->stockCnt($row['gs_id'],$row['gs_opt_id'],$row['od_qty'],false);
        }

        return $res;
    }

    function changeState41($id,$arr=''){ // 상품준비중 상태에서 바로 취소 신청 가능
        $value['od_stt'] = "41";
        $value['od_cancel_request_dt'] = _DATE_YMDHIS;
        $value['od_cancel_reason'] = empty($arr['cancelReason'])?"미입력":$arr['cancelReason'];
        $value['od_rcent_dt'] = _DATE_YMDHIS;
        $res = $this->set($value,$id,"state");
        return $res;
    }

    public function changeState42($id,$arr=''){ // 입금대기,결제 완료 상태로 바로 취소 가능
        try{
            $this->pdo->beginTransaction();
            $value['od_stt'] = "42";
            $value['od_cancel_dt'] = _DATE_YMDHIS;
            $value['od_cancel_reason'] = empty($arr['cancelReason'])?"미입력":$arr['cancelReason'];
            $value['od_rcent_dt'] = _DATE_YMDHIS;
            $res = $this->set($value,$id,"state");
            if($res != "000"){
                $this->pdo->rollBack();
                return $res;

            }
            $row = $this->get("od_no,od_qty,gs_id,gs_opt_id,od_use_point,od_use_point_in,od_use_point_out,mb_id,od_team_id,pt_id",array("od_id"=>$id));
            $memberModel = new \application\models\MemberModel();
            $memberModel->pdo = $this->pdo;
            if( $row['od_use_point'] > 0 ){
                if($row['od_use_point_in'] > 0){
                    $res = $memberModel->savePoint($row['mb_id'],$row['od_use_point_in'],"주문 취소",$row['od_no']);
                    if($res !="000"){
                        $this->pdo->rollBack();
                        return $res;
                    }
                }
                if( $row['od_use_point_out'] > 0 ){
                    if($row['pt_id']=="alldeal"){
                        $mb = $memberModel->get("mb_sns_id_3",array("mb_id"=>$row['mb_id']));   
                        $url = "http://vnoti.kr/api/point/{$mb['mb_sns_id_3']}/cancelOrder?od_id={$row['od_no']}";
                        $response = vnoti($url,$mb['mb_sns_id_3']);
                        $res = $response["result"];
                        if( $res != "000" ){
                            $this->pdo->rollBack();
                            return $res;
                        }
                        $res = $response["result"];
                        if( $res != "000" ){
                            $this->pdo->rollBack();
                            return $res;
                        }
                    }
                }
            }
            $res = $this->cancel($id,$arr);
            if($res != "000") {}

            $this->pdo->commit();

            $goodsModel = new \application\models\GoodsModel();
            $goodsModel->stockCnt($row['gs_id'],$row['gs_opt_id'],$row['od_qty'],false);

            //order case : alldeal -> change team status from 'set' to 'break' ---- START --------
            if(!empty($row['od_team_id'])){
                $teamId = $row['od_team_id'];
                $teamModel = new \application\models\OrderTeamModel();
                $teamStatus = $teamModel->get("od_team_status",array("od_team_id"=>$teamId));
                if($teamStatus["od_team_status"] == "set"){
                    $updateArr = array(
                        'teamHost' => 'admin', //for data log
                        'teamId' => $teamId,
                        'teamStatus' => 'break'
                    );
                    $res = $teamModel->set($updateArr, $teamId);
                }
            }
            //order case : alldeal -> change team status from 'set' to 'break' ---- END -----------
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
        }

    }

    public function cancel($id, $arr=array(), $type="cancel"){ //부분 취소
        try{
            $row = $this->get("pt_id, od_no, od_pg_company, od_pg_mid, od_payment_id, od_amount, od_return_reason, od_cancel_reason", array("od_id"=>$id));
            $amount = $row['od_amount'];

            $partnerModel = new \application\models\PartnerModel();
            $pg = $partnerModel->get("pt_own_pg_yn,shop_pg_service,shop_pg_test_yn,shop_pg_key1,shop_pg_key2",array("shop_pg_mid"=>$row['od_pg_mid']));
            if( empty($pg) || empty($pg['shop_pg_key2']) ){
                $defaultModel = new \application\models\DefaultModel();
                $pg = $defaultModel->get("shop_pg_service,shop_pg_test_yn,shop_pg_key1,shop_pg_key2",array("shop_pg_mid"=>$row['od_pg_mid']));
            }
            if( empty($pg) ) return "113";

            if( $row['od_pg_company'] == "toss" ){
                $tossModel = new \application\models\TossPayments();
                $res = $tossModel->cancel($row['od_no'], $row['od_payment_id'],$pg['shop_pg_key2'],$amount,$row['od_cancel_reason']);
            }else if( $row['od_pg_company'] == "inicis" ){
                $res = "000";
            }else if( $row['od_pg_company'] == "kcp" ){
                $res = "000";
            }else{
                return "114";
            }

            if( $res=="000" ){
                $value = array();
                $value['od_cancel_amount'] = $amount;
                $this->set($value,$id,"value");

                //$orderNoModel = new \application\models\OrderNoModel();
                //$orderNoModel->set($value,$row['od_no'],"value");
            }
            return $res;
        }catch(Exception $e){
            debug_log( static::class,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    function resetTeam($mb_id){
        if(empty($mb_id)) return"002";
        $updateArr = array('od_team_id' => 0);
        $search = " and mb_id = '{$mb_id}' ";
        $res = $this->update($updateArr, $search);
        return $res;
    }            


}
?>
