<?php
namespace application\API\controllers;

class mediaController extends Controller{
    function init(){
        //$this->tokenCheck();
        $this->temp();
        $this->media = new \application\models\MediaModel();
    }

    function getList(){
        $res = "000";
        $col = "media_id as id,media_title as title, media_goods_list as goodsList, concat('"._MEDIA."',media_list_img) as mainImg, media_refer as refer,media_content as content ";
        $_REQUEST['useCtg'] = implode(",",$this->shopUseCtg);
        $_REQUEST['shop'] = "admin,".$this->shopId;
        $_REQUEST['showYn'] = "y";
        //$row['content'] =  base64_encode($row['content']);
        $row = $this->media->getList($col);
        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function get(){
        $col = "gs_id as id,gs_code as code, gs_ctg as ctg , gs_brand as brand, gs_name as name, gs_price as goodsPrice, gs_consumer_price as consumerPrice, gs_delivery_type as dvType, gs_delivery_charge as deliveryCharge, gs_delivery_free as deliveryFree, gs_delivery_each_use as eachUse, sl_id as seller,gs_delivery_region as dvRegion, gs_delivery_region_msg as dvResionMsg,gs_buy_use_grade as useGrade, gs_simg1 as simg1, gs_simg2 as simg2, gs_detail_content as detail, gs_opt_subject as optSubject";
        $goods = new \application\models\GoodsModel();
        $row = $goods->get($this->param['ident'],$col);
        $row['detail'] = stripslashes($row['detail']);
        $arr = array("result"=>"000","client"=>$this->partnerId,"data"=>$row);
        echo json_encode($arr);
    }

}

