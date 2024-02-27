<?php
namespace application\API\controllers;

use \Exception;

class orderNoController extends Controller{

    function init(){
        $this->temp();
        //$this->tokenCheck();
        $this->order = new \application\models\OrderModel();
        $this->orderNo = new \application\models\OrderNoModel();
    }

    function getList(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","cancelAmount","returnAmount","point","coupon",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );

        if($this->isAuth==1){
            if(empty($_SESSION['user_id'])) $this->result("002");
            $_REQUEST['userId'] = $_SESSION['user_id'];
        }else if($this->isAuth==2){
            $_REQUEST['shop'] = $this->userId;
        }else if($this->isAuth==3){
            $_REQUEST['seller'] = $this->userId;
        }
        $_REQUEST['rpp']=$_GET['rpp'];
        $row = $this->orderNo->getList($this->order->getCol($colArr));

        if(!is_array($row)) $this->result($row);

        if(empty($row)) $res = "001";
        $arr = array( "result"=>$res, "data"=>$row );
        echo json_encode($arr);
    }

    function get(){
        $res = "000";
        $colArr = array(
            "odId","odNo", "orderDate",
            "state","qty","goodsPrice","amount","deliveryCharge","cancelAmount","returnAmount",
            "point","coupon",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );

        if($this->isAuth==1){
            if(empty($_SESSION['user_id'])) $this->result("002");
            $_REQUEST['userId'] = $_SESSION['user_id'];
        }else if($this->isAuth==2){
            $_REQUEST['shop'] = $this->userId;
        }else if($this->isAuth==3){
            $_REQUEST['seller'] = $this->userId;
        }
        $row = $this->orderNo->get($this->param['ident'],$this->orderNo->getCol($colArr));
        if(!is_array($row)) $this->result($row);

        $arr = array( "result"=>$res, "data"=>$row );
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

        // 도서산간 지방 배송비 계산
        $deliveryChargeDosan = 0;    

        $goodsArr = json_decode($_PUT['goods'],true);
        $baesong = array();
        // 배송비 계산
        for($i=0;$i<count($goodsArr);$i++){
            $row = $this->join->get($goodsArr[$i]['optionId'],$this->join->getCol($colArr));
            $goodsArr[$i]['seller'] = $row['seller'];
            $goodsArr[$i]['deliveryType'] = $row['deliveryType'];
            $goodsArr[$i]['deliveryCharge'] = $row['deliveryCharge'];
            $goodsArr[$i]['supplyPrice'] = $row['supplyPrice'];
            if( $row['optionStockQty'] <= 0 ) $this->result("104");
            $goodsArr[$i]['goodsPrice'] = ($row['goodsPrice'] + $row['addPrice'])*$goodsArr[$i]['qty'];
            if($row['deliveryType']=="5"){
                if( !array_key_exists($row['seller'], $baesong) ){
                    // 무료 배송 기준, 배송비, 주문 금액
                    $baesong[$row['seller']] = array($row['deliveryFree'],$row['deliveryCharge'],0); 
                }
                if( $baesong[$row['seller']][0] > $row['deliveryFree'] ){ $baesong[$row['seller']][0] = $row['deliveryFree']; }
                if( $baesong[$row['seller']][1] < $row['deliveryCharge'] ){  $baesong[$row['seller']][1] = $row['deliveryCharge'] ; }
                $baesong[$row['seller']][2] += $goodsArr[$i]['goodsPrice'];
            }

            $goodsArr[$i]['deliveryChargeDosan'] = $deliveryChargeDosan;
            $goodsArr[$i]['goodsInfo'] = json_encode($row);
        }

        foreach($goodsArr as $gs){
            if(!empty($gs['cartId']))  $res = $this->cart->set(array("odNo"=>$_POST['no']), $gs['cartId']);
            $_POST['goodsId'] = $gs['goodsId'];
            $_POST['optionId'] = $gs['optionId'];
            $_POST['seller'] = $gs['seller'];
            $_POST['qty'] = $gs['qty'];
            $_POST['deliveryCharge'] = 0;
            $_POST['deliveryChargeDosan'] = $gs['deliveryChargeDosan'];
            if($gs['deliveryType']==5){
                if(array_key_exists($gs['seller'],$baesong)){ 
                    if( $baesong[$gs['seller']][0] > $baesong[$gs['seller']][2] ){
                        $_POST['deliveryCharge'] = $baesong[$gs['seller']][1];
                    }
                    unset($baesong[$gs['seller']]);  
                }
            }else if($gs['deliveryType']!=1){
                $_POST['deliveryCharge'] = $gs['deliveryCharge'];
            }

            $_POST['goodsPrice'] = $gs['goodsPrice'];
            $_POST['supplyPrice'] = $gs['supplyPrice'];
            $_POST['amount'] = $gs['goodsPrice']+$_POST['deliveryCharge']+$gs['deliveryChargeDosan'];
            $_POST['goodsInfo'] = $gs['goodsInfo'];
            $res = $this->order->add($_POST);
        }
        $arr = array("result"=>$res,"odNo"=>$_POST['no'],"data"=>$tmp,"baesong"=>$baesong);
        echo json_encode($arr);
    }

    function cancel(){
        $arr = array();
        if(empty($_POST)) $this->result("001");
        $arr['cancelReason'] = $_POST['cancelReason'];
        //$res = $this->orderNo->changeState42($odNo,$arr);
        $res = $this->orderNo->changeState("42",$this->param['ident'],$arr);
        $arr = array("result"=>$res);
        echo json_encode($arr);
    }

    function guest(){
        $res = "000";
        $colArr = array(
            "odId","odNo","state",
            "orderDate","goodsInfo","goodsPrice","qty","amount","point","coupon",
            "deliveryCharge","deliveryChargeDosan","deliveryCompany","deliveryNo",
            "userId","userName","userCellphone","userEmail",
            "receiverName","receiverEmail","receiverCellphone","receiverZip","receiverAddr1","receiverAddr2","receiverDeliveryMsg"
        );

        if( $this->isAuth != 1 ) $this->result("002");

        $row = $this->order->get($this->param['ident'],$this->order->getCol($colArr));
        if(!is_array($row)) $this->result($row);

        if($_POST['passwd'] != $row['passwd'])  $this->result("002");

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

}
