<?php
namespace application\API\controllers;

use \Exception;

class orderController extends Controller{

    function init(){
        $this->temp();
        //$this->tokenCheck();
        $this->order = new \application\models\OrderModel();
    }

    function getList(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state","seller",
            "orderDate","goodsInfo","amount","qty","goodsPrice","point","coupon",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo"
        );
        if($this->isAuth==1){
            if(empty($_SESSION['user_id'])) $this->result("002");
            $_REQUEST['userId'] = $_SESSION['user_id'];
        }else if($this->isAuth==2){
            $_REQUEST['shop'] = $this->userId;
        }else if($this->isAuth==3){
            $_REQUEST['seller'] = $this->userId;
        }
        //$_REQUEST['state'] = $_REQUEST['state'];
        //$_REQUEST['odNo'] = $_REQUEST['odNo'];
        //$_REQUEST['term'] = $_REQUEST['term'];
        //$_REQUEST['beg'] = $_REQUEST['beg'];
        //$_REQUEST['end'] = $_REQUEST['end'];
        $row = $this->order->getList($this->order->getCol($colArr));
        if(!is_array($row)) $this->result($row);

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function get(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","point","coupon","seller",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );

        $row = $this->order->get($this->param['ident'],$this->order->getCol($colArr));
        if(!is_array($row)) $this->result($row);

        if($this->isAuth==1){
            if(empty($_SESSION['user_id'])) $this->result("002");
            $_REQUEST['userId'] = $_SESSION['user_id'];
        }else if($this->isAuth==2){
            $_REQUEST['shop'] = $this->userId;
        }else if($this->isAuth==3){
            $_REQUEST['seller'] = $this->userId;
        }
 

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function add(){
        parse_str(file_get_contents("php://input"), $_PUT);
        $this->join = new \application\models\GoodsOptionJoinModel();
        $this->join->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
        $this->join->colArr['supplyPrice'] = "gs_supply_price";
        $this->join->colArr['claimDeliveryCharge'] = "gs_claim_delivery_charge";
        $colArr = array(
            "simg1","goodsId","goodsCode","brand","seller","goodsName",
            "consumerPrice","goodsPrice","supplyPrice","claimDeliveryCharge",
            "deliveryType","deliveryCharge","deliveryFree","deliveryEachUse",
            "optionId","optionName","optionStockQty","addPrice"
        );
        $this->cart = new \application\models\CartModel();

        $_POST = $_PUT;
        $_POST['shop'] =  $this->shopId;
        $_POST['state'] = "0";
        $_POST['no'] = _ORDER_NO.mt_rand(100, 999);
        $goodsArr = json_decode($_PUT['goods'],true);
        foreach($goodsArr as $gs){
            if(!empty($gs['cartId'])) 
                $res = $this->cart->set(array("odNo"=>$_POST['no']), $gs['cartId']);
            $_POST['goodsId'] = $gs['goodsId'];
            $_POST['optionId'] = $gs['optionId'];
            $_POST['qty'] = $gs['qty'];
            $_POST['deliveryCharge'] = $gs['deliveryCharge'];
            $_POST['goodsPrice'] = $gs['goodsPrice']+$gs['addPrice'];
            $_POST['amount'] = $gs['amount'];
            $row = $this->join->get($gs['optionId'],$this->join->getCol($colArr));
            $_POST['supplyPrice'] = $row['supplyPrice'];
            $_POST['seller'] = $row['seller'];
            if($row['optionStockQty'] <= 0 ){
                $this->result("104");
            }
            $_POST['goodsInfo'] = json_encode($row);
            $res = $this->order->add($_POST);
        }
        $arr = array("result"=>$res,"odNo"=>$_POST['no']);
        echo json_encode($arr);
    }

    function cancel(){
        $odNo = $this->param['ident'];
        $cancelReason = $_POST['cancelReason'];
        $payments = '';
        $_REQUEST['odNo'] = $odNo;
        $_REQUEST['odId'] = $_POST['orderList'];
        $amount = 0;
        foreach($this->order->getList() as $row){
            // 배송비 관련 기타 처리
            // 묶음 배송일 경우 배송비 부분에 대한 처리를 다른 주문건으로 넘기는 등..
            if(empty($paymentsId)) $paymentsId = $row['od_payment_id'];
            $amount += $row['od_amount'];
            $arr = array();
            $arr['cancelReason'] = $cancelReason;
            $arr['cancelAmount'] = $row['od_amount'];
            $res = $this->order->changeState42($row['od_id'],$arr);
        }
        $arr = array("result"=>$res,"data"=>$response);
        echo json_encode($arr);
    }

    /*
    function list(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","cancelAmount","returnAmount","point","coupon",
            "maxState","totAmount","totDeliveryCharge","totCancelAmount","totReturnAmount",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );
        $this->order->colArr['maxState'] = "max(od_stt)";
        $this->order->colArr['totAmount'] = "sum(od_amount)";
        $this->order->colArr['totDeliveryCharge'] = "sum(od_delivery_charge)";
        $this->order->colArr['totCancelAmount'] = "sum(od_cancel_amount)";
        $this->order->colArr['totReturnAmount'] = "sum(od_return_amount)";
        if($this->isAuth==1){
            if(empty($_SESSION['user_id'])) $this->result("002");
            $_REQUEST['userId'] = $_SESSION['user_id'];
        }else if($this->isAuth==2){
            $_REQUEST['shop'] = $this->userId;
        }else if($this->isAuth==3){
            $_REQUEST['seller'] = $this->userId;
        }
        $_REQUEST['rpp']=$_GET['rpp'];
        $this->order->sql_group = " group by od_no ";
        $row = $this->order->getList($this->order->getCol($colArr));

        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","cancelAmount","returnAmount","point","coupon",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
        );
        for($i=0;$i<count($row);$i++){
            $this->order->sql_group = "";
            $_REQUEST['no'] = $row[$i]['odNo'];
            $row[$i]['orderList'] = $this->order->getList($this->order->getCol($colArr));
        }
        if(!is_array($row)) $this->result($row);
        $arr = array( "result"=>$res, "data"=>$row );
        echo json_encode($arr);
    }

    function desc(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","cancelAmount","returnAmount","point","coupon",
            "maxState","totAmount","totDeliveryCharge","totCancelAmount","totReturnAmount",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );
        $this->order->colArr['maxState'] = "max(od_stt)";
        $this->order->colArr['totAmount'] = "sum(od_amount)";
        $this->order->colArr['totDeliveryCharge'] = "sum(od_delivery_charge)";
        $this->order->colArr['totCancelAmount'] = "sum(od_cancel_amount)";
        $this->order->colArr['totReturnAmount'] = "sum(od_return_amount)";
        if($this->isAuth==1){
            if(empty($_SESSION['user_id'])) $this->result("002");
            $_REQUEST['userId'] = $_SESSION['user_id'];
        }else if($this->isAuth==2){
            $_REQUEST['shop'] = $this->userId;
        }else if($this->isAuth==3){
            $_REQUEST['seller'] = $this->userId;
        }
        $_REQUEST['odNo']=$this->param['ident'];
        $row = $this->order->getSum($this->order->getCol($colArr));

        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","cancelAmount","returnAmount","point","coupon",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
        );
            
        $row['orderList'] = $this->order->getList($this->order->getCol($colArr));

        if(!is_array($row)) $this->result($row);
        $arr = array( "result"=>$res, "data"=>$row );
        echo json_encode($arr);
    }
    */
    function guest(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","point","coupon",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );

        if($this->isAuth!=1) $this->result("002");

        $row = $this->order->get($this->param['ident'],$this->order->getCol($colArr));
        if(!is_array($row)) $this->result($row);
        
        if($_POST['passwd'] != $row['passwd'])  $this->result("002");
        

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }



}
