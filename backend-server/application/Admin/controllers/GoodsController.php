<?php
namespace application\Admin\controllers;

class GoodsController extends Controller{
    public $cnt;
    public $col;

    public function init(){ 
        $this->col = "*";
    }

    public function list(){
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;

        $_REQUEST['state'] = "2";
        $this->cnt = $this->goods->getCnt();   
    }

    public function listExcel(){
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        $this->header = false; $this->footer = false;
        if( $this->goods->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    public function modify(){
        $mbGradeModel = new \application\models\MemberGradeModel();
        $this->mb_gr_li = $mbGradeModel->getNameList();

        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $ptGradeModel = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGradeModel->getNameList();

        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();

        $this->row = $this->goods->get("*",array("gs_id"=>$this->param['ident']));
        if(!empty($this->row['gs_info_value'])) $this->row['gs_info_value'] = unserialize( $this->row['gs_info_value'] );
        else $this->row['gs_info_value'] = array();

        $_REQUEST['goodsId'] = $this->param['ident'];
        $_REQUEST['type'] = "1";
        $this->opt = $this->option->getList($this->col);
        $_REQUEST['type'] = "2";
        $this->aopt = $this->option->getList($this->col);
        unset($_REQUEST['type']);

        //$logModel = new \application\models\GoodsHistoryModel();
        $logModel = new \application\models\UpdateLogModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 5;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $search = array();
        $search['rpp'] = $_REQUEST['rpp'];
        $search['page'] = $_REQUEST['page'];
        $search['log_target_table'] = "web_goods";
        $search['log_target_id'] = $this->param['ident'];
        $search['col'] = "log_reg_dt";
        $search['colby'] = "desc";
        $cnt = $logModel->get("count(gsh_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];
        $this->log = $logModel->get("*",$search,true);
    }

    public function form(){
        $this->category = new \application\models\CategoryModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList("a");
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();
        $mbGrade = new \application\models\MemberGradeModel();
        $this->mb_gr_li = $mbGrade->getNameList();
    }

    public function setOption($opt,$gs_id){
        $this->option = new \application\models\GoodsOptionModel();
        for($i=0;$i<count($opt['id']);$i++){
            $arr = array(
                "id"=>$opt['id'][$i],
                "code"=>$opt['code'][$i],
                "goodsId"=>$gs_id,
                "orderby"=>$i+1,
                "type"=>$opt['type'][$i],
                "name"=>$opt['name'][$i],
                "supplyPrice"=>$opt['supplyPrice'][$i],
                "addPrice"=>$opt['addPrice'][$i],
                "stockQty"=>$opt['stockQty'][$i],
                "qtyNoti"=>empty($opt['qtyNoti'][$i])?"":$opt['qtyNoti'][$i],
                "useYn"=>$opt['useYn'][$i]
            );
            if( empty($arr['id']) ) $res = $this->option->add($arr);
            else if( empty($arr['name']) ) $res = $this->option->remove($arr['id']);
            else $res = $this->option->set($arr,$arr['id']);
        }   
        return $res;
    }

    public function add(){
        $this->goods = new \application\models\GoodsModel();
        $res = $this->goods->add(array_merge($_POST,$_FILES));
        if($res=="000"){
            $gs_id = $this->goods->pdo->lastInsertId();
            if( !empty($_POST['opt']) && is_array($_POST['opt']) ){
                $this->setOption($_POST['opt'], $gs_id); 
            }
            if( !empty($_POST['aopt']) && is_array($_POST['aopt']) ){
                $this->setOption($_POST['aopt'], $gs_id ); 
            }
        }
        $msg = $res=="000" ?"상품번호 : $gs_id \\n상품이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Goods/waitList");
    }

    public function set(){
        $this->header=false; $this->footer=false;
        $this->goods = new \application\models\GoodsModel();
        $res = $this->goods->set(array_merge($_POST,$_FILES),$this->param['ident']);
        if( !empty($_POST['opt']) && is_array($_POST['opt']) ){
            $this->setOption($_POST['opt'], $this->param['ident']); 
        }
        if( !empty($_POST['aopt']) && is_array($_POST['aopt']) ){
            $this->setOption($_POST['aopt'], $this->param['ident'] ); 
        }

        $msg = $res=="000" ? "상품 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function copy(){
        $this->header=false; $this->footer=false;
        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->goods->duplication($id);
            $_REQUEST['goodsId'] = $id;
            if($res=="000"){
                $success++;
                $gs_id = $this->goods->pdo->lastInsertId();
                $optList = $this->option->getList("gs_opt_id");
                foreach($optList as $opt){
                    $this->option->duplication($opt['gs_opt_id'],$gs_id);
                }
            }
        }
        $msg = $success > 0 ? $success."개의 상품을 복사 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function defer(){
        $this->header=false; $this->footer=false;
        $this->goods = new \application\models\GoodsModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->goods->defer($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 상품을 보류 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function approval(){
        $this->header=false; $this->footer=false;
        $this->goods = new \application\models\GoodsModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->goods->approval($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 상품을 승인 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function remove(){
        $this->header=false; $this->footer=false;
        $this->goods = new \application\models\GoodsModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->goods->remove_request($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 상품을 삭제 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , get_return_url("/Goods/list"));
    }

    public function removeReal(){
        $this->header=false; $this->footer=false;
        $this->goods = new \application\models\GoodsModel();
        $idl = explode(",",$this->param['ident']);
        $success = 0;
        foreach($idl as $id){
            $res = $this->goods->remove($id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 상품을 삭제 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function waitList(){
        $this->goods = new \application\models\GoodsModel();
        $this->category = new \application\models\CategoryModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "1";
        $this->cnt = $this->goods->getCnt();   
    }

    public function deferList(){
        $this->goods = new \application\models\GoodsModel();
        $this->category = new \application\models\CategoryModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "3";
        $this->cnt = $this->goods->getCnt();   
    }

    public function deleteList(){
        $this->goods = new \application\models\GoodsModel();
        $this->category = new \application\models\CategoryModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = "4";
        $this->cnt = $this->goods->getCnt();   
    }



    public function stock(){
        $this->goods = new \application\models\GoodsModel();
        $this->category = new \application\models\CategoryModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['isopen']) ) $_REQUEST['isopen'] = 1;
        $_REQUEST['state'] = 2;
        $_REQUEST['qtyNoti'] = 1;
        $this->cnt = $this->goods->getCnt();   
    }

    public function optList(){
        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $_REQUEST['state'] = 2;

        $this->option->leftJoin("gs_id","web_goods","gs_id");
        $this->cnt = $this->option->getCnt();   
        $this->col = "*";
    }

    public function optListExcel(){
        $this->header = false; $this->footer = false;

        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $this->category = new \application\models\CategoryModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        $_REQUEST['state'] = 2;
        $this->option->leftJoin("gs_id","web_goods","gs_id");
        if( $this->option->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }
    public function bulkAdd(){
    }
    public function addSampleExcel(){
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();
        $this->header = false; $this->footer = false;
    }

    public function infoNoticeExcel(){
        $this->header = false; $this->footer = false;
    }

    public function categoryListExcel(){
        $this->header = false; $this->footer = false;
        $this->category = new \application\models\CategoryModel();
        $this->rowAll = $this->category->get("*",array("ctg_use_yn"=>"y", "col"=>"ctg_id"),true);
    }

    public function addExcel(){
        require_once _LIB.'goodsinfo.lib.php';
        $this->header = false; $this->footer = false;
        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $this->category = new \application\models\CategoryModel();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();
        $seller = new \application\models\SellerModel();
        $bulk = new \application\models\BulkExcel();
        $rowAll = $bulk->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            $j = 0;
            if( $i < 3) continue;
            $arr = array();
            $arr['code'] = $row[$j++];
            $arr['code'] = get_gs_code();

            $arr['seller'] = $row[$j++];
            if( empty($arr['seller']) ) continue;

            $res = $seller->get("sl_only_pt_yn, sl_only_pt_id", array("sl_id"=>$arr['seller']));
            if( empty($res) ) continue;
            $arr['onlyPartnerYn'] = $res['sl_only_pt_yn'];
            $arr['onlyPartnerId'] = $res['sl_only_pt_id'];

            $arr['goodsCtg'] = $row[$j++];
            if( empty($arr['goodsCtg']) ) continue;
            
            $arr['goodsCtg2'] = $row[$j++];
            $arr['goodsCtg3'] = $row[$j++];

            $arr['name'] = $row[$j++];
            if( empty($arr['name']) ) continue;

            $arr['explan'] = $row[$j++];
            $arr['keywords'] = $row[$j++];
            $arr['brand'] = $row[$j++];
            $arr['model']= $row[$j++];
            $arr['origin']= $row[$j++];
            $arr['maker']= $row[$j++];
            $arr['makeYear']= $row[$j++];
            $arr['makeDm']= $row[$j++];
            $arr['season']= $row[$j++];
            $arr['sex']= $row[$j++];
            $arr['tax']= $row[$j++];
            $arr['isopen']= $row[$j++];
            $arr['optSubject']= $row[$j++];
            $optListStr = $j++;
            //$arr['addOptSubject']= $row[$j++];
            //$addOptListStr = $j++;
            $arr['consumerPrice']= $row[$j++];
            $arr['supplyPrice'] = $row[$j++];
            $arr['goodsPrice'] = $row[$j++];
            $arr['payRate'] = ((($arr['goodsPrice'] - $arr['supplyPrice'])/$arr['goodsPrice'])*100);
            $arr['goodsPriceAuto']= $row[$j++];
            foreach($this->pt_gr_li as $idx=>$grade){
                $arr["goodsPrice{$idx}"]= $row[$j++];
            }
            $arr['orderMinQty']= $row[$j++];
            $arr['orderMaxQty']= $row[$j++];
            $arr['stockQty']= $row[$j++];
            $arr['qtyNoti']= $row[$j++];
            $arr['salesBeginDate']= !empty($row[$j])?explode(" ",$row[$j++]):"inif";
            $arr['salesEndDate']= !empty($row[$j])?explode(" ",$row[$j++]):"inif";
            $arr['buyUseGrade']= $row[$j++];
            $arr['deliveryType']= $row[$j++];
            $arr['deliveryCharge']= $row[$j++];
            $arr['deliveryFree']= $row[$j++];
            $arr['claimDeliveryCharge']= $row[$j++];
            $arr['deliveryRegion']= $row[$j++];
            $arr['simgType']= $row[$j++];
            $arr['simg1']= $row[$j++];
            $arr['simg2']= $row[$j++];
            $arr['simg3']= $row[$j++];
            $arr['simg4']= $row[$j++];
            $arr['simg5']= $row[$j++];
            $arr['content']= $row[$j++];
            $arr['infoType'] = $row[$j++];
            if( !empty($arr['infoType']) ){
                foreach( $item_info[$arr['infoType']]['article'] as $key=>$value ){
                    $arr['infoValue'][$key] = $row[$j++];
                }
            }
            print_r($arr);
            $res = $this->goods->add($arr);
            if($res=="000"){
                $success++;
                $gs_id = $this->goods->pdo->lastInsertId();
                if(!empty($row[$optListStr])){
                    $optList = explode(",",$row[$optListStr]);
                    $j=0;
                    foreach($optList as $optStr ){
                        $opt = explode("^",$optStr);
                        $value = array(
                            "code"=>"",
                            "goodsId"=>$gs_id,
                            "orderby"=>$i+1,
                            "type"=>1,
                            "name"=>$opt[0],
                            "addPrice"=>$opt[3],
                            "stockQty"=>$opt[1],
                            "qtyNoti"=>$opt[2],
                            "useYn"=>$opt[4]
                        );
                        $optSupplyPrice = get_supply_price($arr['goodsPrice'] + $value['addPrice'], $arr['payRate']);
        
                        $res = $this->option->add($value);
                        $j++;
                    }
                }
                /*
                if(!empty($row[$addOptListStr])){
                    $addOptList = explode(",",$row[$addOptListStr]);
                    $j=0;
                    foreach($addOptList as $optStr ){
                        $opt = explode("^",$optStr);
                        $value = array(
                            "code"=>"",
                            "goodsId"=>$gs_id,
                            "orderby"=>$i+1,
                            "type"=>2,
                            "name"=>$opt[0],
                            "addPrice"=>$opt[3],
                            "stockQty"=>$opt[1],
                            "qtyNoti"=>$opt[2],
                            "useYn"=>$opt[4]
                        );
                        $res = $this->option->add($value);
                        $j++;
                    }
                }
                */
            }
        }
        $msg = $success > 0 ? $success."개의 상품이 등록되었습니다." : $res."실패\\n다시 시도 해주세요.";
        //access($msg , _PRE_URL);
    }

    public function bulkEdit(){
        $this->category = new \application\models\CategoryModel();
        $this->goods = new \application\models\GoodsModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;

        $_REQUEST['state'] = "2";
        $this->cnt = $this->goods->getCnt();   
    }

    public function bulkEditExcel(){
        $this->header = false; $this->footer = false;
        $this->goods = new \application\models\GoodsModel();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();
        if( $this->goods->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    public function setExcel(){
        require_once _LIB.'goodsinfo.lib.php';
        $this->header = false; $this->footer = false;
        $this->goods = new \application\models\GoodsModel();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();
 
        $bulk = new \application\models\BulkExcel();
        $rowAll = $bulk->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            if( $i < 3) continue;

            $arr = array(); 
            $j = 0;

            $id = $row[$j++];
            if(empty($id)) continue;

            $arr['code'] = $row[$j++];
            if(empty($arr['code'])) continue;

            $arr['seller'] = $row[$j++];
            if(empty($arr['seller'])) continue;

            $res = $this->goods->get("gs_id,gs_code,sl_id,gs_simg1,gs_simg2,gs_simg3,gs_simg4,gs_simg5",array("gs_id"=>$id));
            if( $res['gs_code'] != $arr['code'] ) continue;
            if( $res['sl_id'] != $arr['seller'] ) continue;

            $arr['goodsCtg'] = $row[$j++];
            $arr['goodsCtg2'] = $row[$j++];
            $arr['goodsCtg3'] = $row[$j++];
            $arr['name'] = $row[$j++];
            $arr['explan'] = $row[$j++];
            $arr['keywords'] = $row[$j++];
            $arr['brand'] = $row[$j++];
            $arr['model']= $row[$j++];
            $arr['origin']= $row[$j++];
            $arr['maker']= $row[$j++];
            $arr['makeYear']= $row[$j++];
            $arr['makeDm']= $row[$j++];
            $arr['season']= $row[$j++];
            $arr['sex']= $row[$j++];
            $arr['tax']= $row[$j++];
            $arr['isopen']= $row[$j++];
            $arr['optSubject']= $row[$j++];
            $arr['consumerPrice']= $row[$j++];
            $arr['supplyPrice']= $row[$j++];
            $arr['goodsPrice']= $row[$j++];
            $arr['goodsPriceAuto']= $row[$j++];
            foreach($this->pt_gr_li as $idx=>$grade){
                $arr["goodsPrice{$idx}"]= $row[$j++];
            }
            $arr['orderMinQty']= $row[$j++];
            $arr['orderMaxQty']= $row[$j++];
            $arr['stockQty']= $row[$j++];
            $arr['qtyNoti']= $row[$j++];
            $saleBeginDateIdx = $j++;
            $arr['salesBeginDate']= check_time($row[$saleBeginDateIdx])?explode(" ",$row[$saleBeginDateIdx]):"inif";
            $saleEndDateIdx = $j++;
            $arr['salesEndDate']= check_time($row[$saleEndDateIdx])?explode(" ",$row[$saleEndDateIdx]):"inif";
            $arr['buyUseGrade']= $row[$j++];
            $arr['deliveryType']= $row[$j++];
            $arr['deliveryCharge']= $row[$j++];
            $arr['deliveryFree']= $row[$j++];
            $arr['clainDeliveryCharge']= $row[$j++];
            $arr['deliveryRegion']= $row[$j++];
            $arr['simgType']= $row[$j++];
            $arr['simg1']= $row[$j++];
            if( $arr["simg1"] == $res["gs_simg1"] ) unset($arr["simg1"]);
            $arr['simg2']= $row[$j++];
            if( $arr["simg2"] == $res["gs_simg2"] ) unset($arr["simg2"]);
            $arr['simg3']= $row[$j++];
            if( $arr["simg3"] == $res["gs_simg3"] ) unset($arr["simg3"]);
            $arr['simg4']= $row[$j++];
            if( $arr["simg4"] == $res["gs_simg4"] ) unset($arr["simg4"]);
            $arr['simg5']= $row[$j++];
            if( $arr["simg5"] == $res["gs_simg5"] ) unset($arr["simg5"]);

            $arr['content']= $row[$j++];
            $arr['infoType'] = $row[$j++];
            if( !empty($arr['infoType']) ){
                foreach( $item_info[$arr['infoType']]['article'] as $key=>$value ){
                    $arr['infoValue'][$key] = $row[$j++];
                }
            }
            $res = $this->goods->set($arr,$id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 상품이 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function optBulkEditExcel(){
        $this->header = false; $this->footer = false;

        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $ptGrade = new \application\models\PartnerGradeModel();
        $this->pt_gr_li = $ptGrade->getNameList();

        $this->option->leftJoin("gs_id","web_goods","gs_id");
        if( $this->option->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    public function setOptExcel(){
        $this->header = false; $this->footer = false;
        $this->option = new \application\models\GoodsOptionModel();
        $bulk = new \application\models\BulkExcel();
        $rowAll = $bulk->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            if( $i < 3) continue;

            $arr = array();
            $j = 0;
            $arr['goodsId'] = $row[$j++]; $j++;
            $id = $row[$j++];
            $arr['code'] = $row[$j++];
            $arr['name'] = $row[$j++];
            $arr['stockQty'] = $row[$j++];
            $arr['qtyNoti'] = $row[$j++];
            $arr['addPrice'] = $row[$j++];
            $arr['type'] = $row[$j++];
            $arr['orderby'] = $row[$j++];
            $arr['useYn'] = $row[$j++];
            if(empty($id)){
                $res = $this->option->add($arr);
            }else{
                $res = $this->option->set($arr,$id);
            }
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 옵션이 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function categoryList(){
        $this->category = new \application\models\CategoryModel();
        $this->cnt = $this->category->getCnt();
    }

    public function getCategory(){
        $this->header=false; $this->footer=false;
        $this->category = new \application\models\CategoryModel();
        $row = $this->category->get('ctg_id as ctg,ctg_title as title,ctg_use_yn as useYn,ctg_top_banner as topBanner', array("ctg_id"=>$this->param['ident'])) ;
        echo json_encode( $row );
    }

    public function setCategory(){
        $this->category = new \application\models\CategoryModel();
        $res = $this->category->set(array_merge($_POST,$_FILES),$this->param['ident']);
        $msg = $res == "000" ? "카테고리 정보가 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        //access($msg , _PRE_URL."?ctg=".$this->param['ident']);
        access($msg , "/Goods/categoryList?ctg=".$this->param['ident']);
    }

    public function addCategory(){
        $this->category = new \application\models\CategoryModel();
        $res = $this->category->create( $this->param['ident'] );
        $msg = $res == "000" ? "카테고리가 등록되었습니다." : $res. "실패\\n다시 시도 해주세요.";
        access($msg , "/Goods/categoryList?ctg=".$this->param['ident']);
    }

    public function removeCategory(){
        $this->category = new \application\models\CategoryModel();
        $res = $this->category->remove($this->param['ident']);
        $msg = $res=="000" ? "카테고리 정보가 삭제되었습니다." : $res."실패\\n다시 시도 해주세요.";
        $upper = substr($this->param['ident'],0,-3);
        access($msg , "/Goods/categoryList?ctg=".$upper);
    }

    public function sortableCategory(){
        $this->category = new \application\models\CategoryModel();
        $this->header = false;  $this->footer = false;
        $sortList = explode(",", $_REQUEST['orderby']);
        $sortList = array_filter($sortList);
        $upper = substr($sortList[0],0,-3);
        $success = 0;
        for($i=1;$i<=count($sortList);$i++){
            $arr['id']= $sortList[$i-1];
            $arr['orderby']= $i;
            $res = $this->category->move($arr,$arr['id']);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? "카테고리 순서가 변경되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Goods/categoryList?ctg=".$upper);
    }

    public function categoryBulkEditExcel(){
        $this->category = new \application\models\CategoryModel();
        $this->header = false; $this->footer = false;
        $_REQUEST['col'] = "id";
        $_REQUEST['colby'] = "asc";
    }

    public function setCategoryExcel(){
        $this->header = false; $this->footer = false;
        $categoryModel = new \application\models\CategoryModel();
        $bulk = new \application\models\BulkExcel();
        $res = $bulk->upload();
        $i = 0;
        $success = 0;
        foreach( $res as $row ){
            $i++;
            if($i < 3) continue;    
            $id = $row[1].$row[2].$row[3].$row[4];
            $arr['id'] = $id;
            if( empty($arr['id']) ) continue;
            $arr['upper'] = substr($id,0,(strlen($id)-3)); 
            $arr['title'] = $row[6];
            if( empty($arr['title']) ) continue;
            $arr['orderby'] = $i;
            $arr['useYn'] = !empty($row[7])?$row[7]:"n";

            $row = $categoryModel->get("*",array("ctg_id"=>$id));
            if( !empty($row) ){
                $res = $categoryModel->set($arr,$id);
            }else{
                $res = $categoryModel->add($arr);
            }
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 카테고리 정보가 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }



    public function qaList(){
        $this->qa = new \application\models\GoodsQaModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();

        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->qa->getCnt();   
    }

    public function qaListExcel(){
        $this->header=false; $this->footer=false;
        $this->qa = new \application\models\GoodsQaModel();
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();
        if( $this->qa->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    public function qaDescPopup(){
        $this->header = "head"; $this->footer = false;
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();
        $this->goods = new \application\models\GoodsModel();
        $this->qa = new \application\models\GoodsQaModel();
        $this->row  = $this->qa->get("*", array("gs_qa_id"=>$this->param['ident']));
        $this->gs = $this->goods->get("*",array("gs_id"=>$this->row['gs_id']));
    }

    public function qaAnswer(){
        $this->qa = new \application\models\GoodsQaModel();
        $res = $this->qa->answer($_POST,$this->param['ident']);
        if($res=="000"){
            if($_POST['emailNoticeYn']=='y'){
                $template = new \application\models\TemplateModel();
                $res = $template->sendMail($_POST['userId'],"3");
            }
            if($_POST['cellphoneNoticeYn']=='y'){
                // 메일 및 문자 보내기 (추후 추가 필요)
            }
        }
        $msg = $res == "000" ? "상품 문의의 답변이 등록되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function qaHidden(){
        $this->qa = new \application\models\GoodsQaModel();
        $res = $this->qa->hidden($this->param['ident']);
        $msg = $res == "000" ? "상품 문의가 숨김 처리 되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function reviewList(){
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();
 
        $this->review = new \application\models\GoodsReviewModel();
        $_REQUEST['rpp'] = 10;
        $_REQUEST['page'] = 1;
        $this->cnt = $this->review->getCnt();   
    }

    public function reviewListExcel(){
        $this->header = false; $this->footer=false;
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();
        $this->review = new \application\models\GoodsReviewModel();
        if( $this->review->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    function reviewDescPopup(){
        $this->header = "head"; $this->footer = false;
        $seller = new \application\models\SellerModel();
        $this->sl_li = $seller->getNameList();
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();
     
        $this->review = new \application\models\GoodsReviewModel();
        $this->member = new \application\models\MemberModel();
        $this->row  = $this->review->get("*",array("gs_rv_id"=>$this->param['ident']));
        $this->mb = $this->member->get("*",array("mb_id"=>$this->row['mb_id']));
    }

    function reviewReply(){
        $this->review = new \application\models\GoodsReviewModel();
        $res = $this->review->reply($_POST,$this->param['ident']);
        $msg = $res == "000" ? "상품 후기의 댓글이 등록되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    function reviewHidden(){
        $res = $this->review->hidden($this->param['ident']);
        $msg = $res == "000" ? "상품 후기가 숨김 처리 되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function salesAnalysis(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $orderModel = new \application\models\OrderModel();
        $search = array();
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문']; 
        $search['col'] = "sum_qty";
        $search['colby'] = "desc";
        $orderModel->sql_group = " group by gs_id  ";
        $max = $orderModel->get("sum(od_qty) as sum_qty",$search,true);
        $this->max = empty($max)?0:$max[0]['sum_qty'];

        $search['rpp'] = $_REQUEST['rpp'];
        $search['page'] = $_REQUEST['page'];
        $orderModel->leftJoin("gs_id","web_goods","gs_id");
        $orderModel->sql_group = " group by gs_id  ";
        $this->row = $orderModel->get("gs_id, sum(od_qty) as sum_qty, count(od_id) as od_cnt, gs_name",$search,true);
        $cnt = $orderModel->get("count(gs_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];
        
    }

    public function salesAnalysisExcel(){
        $this->header = false; $this->footer = false;

        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문']; 
        $search['col'] = "sum_qty";
        $search['colby'] = "desc";
        $orderModel = new \application\models\OrderModel();
        $orderModel->leftJoin("gs_id","web_goods","gs_id");
        $sum = $orderModel->get("sum(od_qty) as sum_qty",$search);
        $this->sum = $sum['sum_qty'];
        $orderModel->sql_group = " group by gs_id  ";
        $this->row = $orderModel->get("gs_id, sum(od_qty) as sum_qty, count(od_id) as od_cnt, gs_name",$search,true);
    }

    public function keywordList(){
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;

        $keywordModel = new \application\models\KeywordModel();
        $search = array();
        $search['keyword_id_then_ge'] = 0;
        if( !empty($_REQUEST['beg']) ) $search['keyword_update_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        if( !empty($_REQUEST['end']) ) $search['keyword_update_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['col'] = "keyword_cnt desc,keyword_update_dt";
        $search['colby'] = "desc";
        $max = $keywordModel->get("max(keyword_cnt) as cnt",$search);
        $this->max = $max['cnt'];
        $search['rpp'] = $_REQUEST['rpp'];
        $search['page'] = $_REQUEST['page'];
        $this->row = $keywordModel->get("*",$search,true);
        $cnt = $keywordModel->get("count(keyword_id) as cnt",$search);
        $this->cnt = $cnt['cnt'];
    }

    public function removeKeyword(){
        $keywordModel = new \application\models\KeywordModel();
        $res = $keywordModel->remove($this->param['ident']);
        $msg = $res=="000" ? "검색어가 삭제되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

}
?>
