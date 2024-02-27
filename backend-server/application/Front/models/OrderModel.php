<?php
namespace application\Front\models;

use \Exception;

class OrderModel extends \application\models\OrderModel{
    public $col;
    public $sql;
    public $search;
    public $shopId;
    public function __construct( $shopId, $shopGrade="", $shopUseCtg="" ){
        parent::__construct ();
        $this->leftJoin("od_id","web_goods_review","od_id");

        $this->shopId = $shopId;
        $this->shopGrade = $shopGrade;
        $this->shopUseCtg = $shopUseCtg;
        $this->col = array(
            "od_id"=>"od_id",
            "od_no"=>"od_no",
            "od_stt"=>"od_stt",
            "mb_id"=>"mb_id",
            "sl_id"=>"sl_id",
            //"pt_id"=>"pt_id",
            "od_dt"=>"od_dt",
            "od_goods_info"=>"od_goods_info",
            "od_amount"=>"od_amount",
            "od_qty"=>"od_qty",
            "od_goods_price"=>"od_goods_price",
            "od_use_point"=>"od_use_point",
            "od_use_coupon"=>"od_use_coupon",
            "od_delivery_charge"=>"od_delivery_charge",
            "od_delivery_charge_dosan"=>"od_delivery_charge_dosan",
            "od_delivery_company"=>"od_delivery_company",
            "od_delivery_no"=>"od_delivery_no",
            "od_paymethod"=>"od_paymethod",
            "orderer_name"=>"orderer_name",
            "orderer_cellphone"=>"orderer_cellphone",
            "orderer_email"=>"orderer_email",
            "orderer_zip"=>"orderer_zip",
            "orderer_addr1"=>"orderer_addr1",
            "orderer_addr2"=>"orderer_addr2",
            "orderer_addr3"=>"orderer_addr3",
            "orderer_addr_jibeon"=>"orderer_addr_jibeon",
            "receiver_name"=>"receiver_name",
            "receiver_cellphone"=>"receiver_cellphone",
            "receiver_email"=>"receiver_email",
            "receiver_zip"=>"receiver_zip",
            "receiver_addr1"=>"receiver_addr1",
            "receiver_addr2"=>"receiver_addr2",
            "receiver_addr3"=>"receiver_addr3",
            "receiver_addr_jibeon"=>"receiver_addr_jibeon",
            "receiver_delivery_msg"=>"receiver_delivery_msg",
            "od_vbank"=>"od_vbank",
            "od_vbank_deposit"=>"od_vbank_deposit",
            "od_passwd"=>"od_passwd",
            "od_review_yn"=>"od_review_yn", 
            "od_confirm_yn"=>"od_confirm_yn", 
            "gs_rv_id"=>"ifnull(gs_rv_id,'')", 
        );


    }

    public function get( $col="*", $request, $fetchAll=false, $sql_where="",$parameter=array()){
        $sql = $this->sql;
        $search = $this->search;

        $search['pt_id'] = $this->shopId;
        $search['od_stt_then_ge'] = "1";
        $required = false;
        
        if( !empty($request['mb_id']) ){
            $search['mb_id'] = $request['mb_id'];
            $required = true;
        }

        if( !empty($request['orderer_cellphone']) ){
            $search['orderer_cellphone'] = $request['orderer_cellphone'];
            $required = true;
        }
        if( !$required ) return "002";
        if( !empty($request['od_no']) ) $search['od_no'] = trim($request['od_no']);
        if( !empty($request['od_id']) ) $search['od_id'] = trim($request['od_id']);
        if( !empty($request['od_stt']) ) $search['od_stt_in_all'] = trim($request['od_stt']);
        if( !empty($request['od_dt_beg']) ) $search['od_dt_then_ge'] = trim($request['od_dt_beg'])." 00:00:00";
        if( !empty($request['od_dt_end']) ) $search['od_dt_then_le'] = trim($request['od_dt_end'])." 23:59:59";
        if( !empty($request['rpp']) ) $search['rpp'] = trim($request['rpp']);
        if( !empty($request['page']) ) $search['page'] = trim($request['page']);
        $search['col'] = "od_dt";
        $search['colby'] = "desc";
        return parent::get($col, $search, $fetchAll, $sql, $parameter);
    }
}
