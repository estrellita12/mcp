<?php
namespace application\API\controllers;

use \Exception;

class goodsController extends Controller{

    function init(){
        $this->tokenCheck();
        $this->goods = new \application\models\GoodsModel();
        $this->goods->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
    }

    function getList(){
        $res = "000";
        $colArr = array(
            "goodsId","goodsCode","goodsName","ctg","brand","seller","isopen",
            "goodsPrice","consumerPrice","deliveryType",
            "simg1","simg2","simg3","simg4","simg5",
            "timg1","timg2","timg3","timg4","timg5"
        );

        if( $this->isAuth == 3 ){
            $_REQUEST['seller'] = $this->userId;
        }else{
            if($this->isAuth==1){
                $useCtg = $this->shopUseCtg;
                $shopId = $this->shopId;

                if(isset($_SESSION['user_grade'])){
                    $this->memberGrade = new \application\models\MemberGradeModel();
                    $mg = $this->memberGrade->get($_SESSION['user_grade'],$this->memberGrade->getCol());
                    if( $mg['mbGradeSaleUnit'] == "1" ) $price = "TRUNCATE( gs_price_{$this->shopGrade} * ( (100 - {$mg['mbGradeSale']})/100 ) , {$mg['mbGradeSaleCut']} )";
                    else $price = "gs_price_{$this->shopGrade} - {$mg['mbGradeSale']}";
                    $this->goods->colArr['goodsPrice'] = $price;
                    $_REQUEST['buyUseGrade'] = $_SESSION['user_grade'];
                }else{
                    $_REQUEST['buyUseGrade'] = "10";
                }
            }else if($this->isAuth==2){
                $partner = new \application\models\PartnerModel();
                $row = $partner->get($this->userId,$partner->getCol(array("useCtg")));
                $useCtg= unserialize($row['useCtg']);
                $shopId = $this->userId;
            }
            if( empty($shopId) ) $this->result("002","등록되지않은 사용자 입니다.");
            if( empty($useCtg) || !is_array($useCtg) ) $this->result("002","카테고리가 존재하지 않습니다.");
            $_REQUEST['shop'] = $shopId;
            $_REQUEST['useCtg'] = implode(",",$useCtg);
        }
        $_REQUEST['state'] = "2";
        $_REQUEST['term'] = empty($_GET['term'])?"salesDate":$_GET['term'];
        $_REQUEST['beg'] = empty($_GET['beg'])?_DATE_YMDHIS:$_GET['beg'];
        $_REQUEST['end'] = empty($_GET['end'])?_DATE_YMDHIS:$_GET['end'];
        //$_REQUEST['col'] = $_GET['col'];
        //$_REQUEST['ctg'] = $_GET['ctg'];
        //$_REQUEST['rpp'] = $_GET['rpp'];
        if(!empty($_REQUEST['type'])){
            $menu = new \application\models\GnbMenuModel();
            $row = $menu->get($shopId);
            $_REQUEST['goodsId'] = $row['menu_'.$_REQUEST['type'].'_goods_list'];
        }
        $row = $this->goods->getList($this->goods->getCol($colArr));
        if( !is_array($row) ) $this->result($row);
        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function get(){
        // 공급사의 경우, 데이터 추가 가능성 있음.
        $res = "000";
        $colArr = array(
            "goodsId","goodsCode","goodsName","ctg","state","onlyShopYn","onlyShop","buyUseGrade","brand","seller","isopen",
            "goodsPrice","consumerPrice","stockQty","salesBeginDate","salesEndDate",
            "deliveryType","deliveryCharge","deliveryFree","deliveryEachUse","deliveryRegion","deliveryRegionMsg",
            "simgType","simg1","simg2","simg3","simg4","simg5",
            "optSubject","detail"
        );
        if($this->isAuth==3){
            array_push($colArr,"supplyPrice");
        }
        $row = $this->goods->get($this->param['ident'],$col = $this->goods->getCol());
        if( !is_array($row) ) $this->result($row);
        if($this->isAuth==3){
            if($row['seller']!=$this->userId) $this->result("105","상품에 대한 접근 권한이 존재하지 않습니다. ");
        }
        $row['detail'] = stripslashes($row['detail']);
        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function cnt(){
        $res="000";
        if( $this->isAuth == 3 ){
            $_REQUEST['seller'] = $this->userId;
        }else{
            if($this->isAuth==1){
                $useCtg = $this->shopUseCtg;
                $shopId = $this->shopId;
                $_REQUEST['buyUseGrade'] = isset($_SESSION['user_grade'])?$_SESSION['user_grade']:"10";
            }else if($this->isAuth==2){
                $partner = new \application\models\PartnerModel();
                $row = $partner->get($this->userId,$partner->getCol(array("useCtg")));
                $useCtg= unserialize($row['useCtg']);
                $shopId = $this->userId;
            }
            if( empty($shopId) ) $this->result("002","등록되지않은 사용자 입니다.");
            if( empty($useCtg) || !is_array($useCtg) ) $this->result("002","카테고리가 존재하지 않습니다.");
            $_REQUEST['shop'] = $shopId;
            $_REQUEST['useCtg'] = implode(",",$useCtg);
        }
        $_REQUEST['state'] = "2";
        $_REQUEST['term'] = empty($_GET['term'])?"salesDate":$_GET['term'];
        $_REQUEST['beg'] = empty($_GET['beg'])?_DATE_YMDHIS:$_GET['beg'];
        $_REQUEST['end'] = empty($_GET['end'])?_DATE_YMDHIS:$_GET['end'];
        //$_REQUEST['col'] = $_GET['col'];
        //$_REQUEST['ctg'] = $_GET['ctg'];
        //$_REQUEST['rpp'] = $_GET['rpp'];
        if(!empty($_REQUEST['type'])){
            $menu = new \application\models\GnbMenuModel();
            $row = $menu->get($shopId);
            $_REQUEST['goodsId'] = $row['menu_'.$_REQUEST['type'].'_goods_list'];
        }

        $row = $this->goods->getCnt();
        $arr = array("result"=>$res,"cnt"=>$row);
        echo json_encode($arr);
    }
}

