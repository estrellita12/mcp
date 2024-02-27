<?php
namespace application\API\controllers;

use \Exception;

class cartController extends Controller{

    function init(){
        $this->tokenCheck();
        if( $this->isAuth != 1 )  $this->result("403","접근이 불가한 경로입니다.");
        $this->cart = new \application\models\CartModel();
    }

    function getList(){
        $res = "000";
        $this->join = new \application\models\CartGoodsJoinModel();
        $this->join->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
        $colArr = array(
            "goodsId","goodsCode","goodsName","ctg","brand","seller","isopen","goodsPrice","consumerPrice","stockQty",
            "deliveryType","deliveryCharge","deliveryFree","deliveryEachUse","deliveryRegion","deliveryRegionMsg","simg1",
            "optionId","optionName","addPrice","optionStockQty",
            "cartId","qty"
        );

        if( isset($_SESSION['user_id']) ) $_REQUEST['userId'] = $_SESSION['user_id'];
        else if( isset($_COOKIE['direct']) ) $_REQUEST['direct'] = $_COOKIE['direct'];
        else $this->result("002","장바구니 키값이 존재하지 않습니다.");

        $_REQUEST['useCtg'] = implode(",",$this->shopUseCtg);
        $_REQUEST['state'] = "2";
        $_REQUEST['shop'] = $this->shopId;
        $_REQUEST['useYn'] = 'y';
        $_REQUEST['buyUseGrade'] = isset($_SESSION['user_grade'])?$_SESSION['user_grade']:"10";
        $_REQUEST['term'] = empty($_GET['term'])?"salesDate":$_GET['term'];
        $_REQUEST['beg'] = !empty($_GET['beg'])?$_GET['beg']:_DATE_YMDHIS;
        $_REQUEST['end'] = !empty($_GET['end'])?$_GET['end']:_DATE_YMDHIS;
        //$_REQUEST['col'] = $_GET['col'];
        //$_REQUEST['ctg'] = $_GET['ctg'];
        $row = $this->join->getList( $this->join->getCol($colArr) );
        if(!is_array($row)) $this->result($row);

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function add(){
        parse_str(file_get_contents("php://input"), $_PUT);

        if( isset($_SESSION['user_id']) && $_PUT['userId'] = $_SESSION['user_id'] ) $_REQUEST['userId'] = $_PUT['userId'];
        else if( isset($_COOKIE['direct']) && $_PUT['direct'] = $_COOKIE['direct'] ) $_REQUEST['direct'] = $_COOKIE['direct'];
        else $this->result("002","장바구니 키값이 존재하지 않습니다.");

        $_REQUEST['optionId'] = $_PUT['optionId'];
        $cnt = $this->cart->getCnt();
        if($cnt > 0) $this->result("003",$cnt."이미 장바구니에 등록된 상품입니다.");
        $res = $this->cart->add($_PUT);
        $arr = array("result"=>$res);
        echo json_encode($arr);
    }

    function set(){
        $colArr = array("userId","direct");
        $row = $this->cart->get($this->param['ident'],$this->cart->getCol($colArr));

        if( $_SESSION['user_id']!=$row['userId'] && $_COOKIE['direct'] != $row['direct'] ){
            $this->result("002","장바구니 키값이 존재하지 않습니다.");
        }
        $res = $this->cart->set($_POST,$this->param['ident']);
        $arr = array("result"=>$res);
        echo json_encode($arr);
    }

    function remove(){
        $colArr = array("userId","direct");
        $row = $this->cart->get($this->param['ident'],$this->cart->getCol($colArr));

        if( $_SESSION['user_id'] != $row['userId'] && $_COOKIE['direct'] != $row['direct'] ){
            $this->result("002","장바구니 키값이 존재하지 않습니다.");
        }
        $res = $this->cart->remove($this->param['ident']);
        $arr = array("result"=>$res);
        echo json_encode($arr);
    }

}
