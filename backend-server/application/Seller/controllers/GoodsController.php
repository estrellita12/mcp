<?php
namespace application\Seller\controllers;

class GoodsController extends Controller{
    public $col;
    public $search;
    public $sql;
    public $cnt;

    public function init(){ 
        $this->col = "*";
        $this->search = array();
        $this->sql = "";
        $this->cnt = 0;
    }

    private function getSearch(){
        $search = array();
        $search["sl_id"] = $_SESSION['user_id'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['geQty']) ) $search["gs_stock_qty_then_ge"] = $_REQUEST['geQty']; 
        if( !empty($_REQUEST['leQty']) ) $search["gs_stock_qty_then_le"] = $_REQUEST['leQty']; 
        if( !empty($_REQUEST['gePrice']) ) $search["gs_price_then_ge"] = $_REQUEST['gePrice']; 
        if( !empty($_REQUEST['lePrice']) ) $search["gs_price_then_le"] = $_REQUEST['lePrice']; 
        if( !empty($_REQUEST['isopen']) ) $search["gs_isopen"] = $_REQUEST['isopen']; 
        if( !empty($_REQUEST['rpp']) ) $search["rpp"] = $_REQUEST['rpp'];
        if( !empty($_REQUEST['page']) ) $search["page"] = $_REQUEST['page'];
        if( !empty($_REQUEST['col']) ) $search["col"] = $_REQUEST['col'];
        if( !empty($_REQUEST['colby']) ) $search["colby"] = $_REQUEST['colby'];
        return $search;
    }

    public function list(){
        $this->categoryModel = new \application\models\CategoryModel();
        $goodsModel = new \application\models\GoodsModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "gs_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";

        $this->search = $this->getSearch();
        $this->search["gs_stt"] = 2;
        if( !empty($_REQUEST['ctg']) ){
            $this->sql = " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }
        $cnt = $goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
        $this->row = $goodsModel->get($this->col,$this->search,true,$this->sql);
    }

    public function listExcel(){
        $this->header=false; $this->footer=false;
        $this->categoryModel = new \application\models\CategoryModel();
        $goodsModel = new \application\models\GoodsModel();
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "gs_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";

        $this->search = $this->getSearch();
        $this->search["gs_stt"] = 2;
        if( !empty($_REQUEST['ctg']) ){
            $this->sql = " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }
        $cnt = $goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
        $this->row = $goodsModel->get($this->col,$this->search,true,$this->sql);
    }

    public function modify(){
        $this->categoryModel = new \application\models\CategoryModel();
        $mbGradeModel = new \application\models\MemberGradeModel();
        $this->mb_gr_li = $mbGradeModel->getNameList();

        $goodsModel = new \application\models\GoodsModel();
        $this->row = $goodsModel->get("*",array("gs_id"=>$this->param['ident'],"sl_id"=>$this->my['sl_id']));
        if( empty($this->row) ){
            access("상품이 존재하지 않습니다.","/Goods/list");
        }
        if(!empty($this->row['gs_info_value'])) $this->row['gs_info_value'] = unserialize( $this->row['gs_info_value'] );
        else $this->row['gs_info_value'] = array();

        $optionModel = new \application\models\GoodsOptionModel();
        $this->opt = $optionModel->get("*",array("gs_id"=>$this->param['ident'],"gs_opt_type"=>1),true);
        $this->aopt = $optionModel->get("*",array("gs_id"=>$this->param['ident'],"gs_opt_type"=>2),true);
    }

    public function form(){
        $this->category = new \application\models\CategoryModel();
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
        $msg = $res=="000" ?"상품번호 : $gs_id \\n상품이 등록되었습니다.\\n등록 대기 상품으로서 관리자의 승인 이후 판매가 됩니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "/Goods/waitList");
    }

    public function set(){
        $this->header=false; $this->footer=false;
        $goodsModel = new \application\models\GoodsModel();
        $res = $goodsModel->set(array_merge($_POST,$_FILES),$this->param['ident']);
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
            $goodsData = $this->goods->get("sl_id",array("gs_id"=>$id));
            if( $goodsData['sl_id'] != $_SESSION['user_id'] ) continue;
            $res = $this->goods->duplication($id);
            if($res=="000"){
                $success++;
                $gs_id = $this->goods->pdo->lastInsertId();
                $optList = $this->option->get("gs_opt_id",array("gs_id"=>$id),true);
                foreach($optList as $opt){
                    $this->option->duplication($opt['gs_opt_id'],$gs_id);
                }
            }
        }
        $msg = $success > 0 ? $success."개의 상품을 복사 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
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
        $msg = $success > 0 ? $success."개의 상품을 삭제 요청 처리 하였습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function waitList(){
        $this->categoryModel = new \application\models\CategoryModel();
        $goodsModel = new \application\models\GoodsModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "gs_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $_REQUEST['state'] = "1";
        $this->search = $this->getSearch();
        $this->search["gs_stt"] = 1;
        if( !empty($_REQUEST['ctg']) ){
            $this->sql = " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }
        $cnt = $goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
        $this->row = $goodsModel->get($this->col,$this->search,true,$this->sql);
    }

    public function deferList(){
        $this->categoryModel = new \application\models\CategoryModel();
        $goodsModel = new \application\models\GoodsModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "gs_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $_REQUEST['state'] = "3";
        $this->search = $this->getSearch();
        $this->search["gs_stt"] = 3;
        if( !empty($_REQUEST['ctg']) ){
            $this->sql = " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }
        $cnt = $goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
        $this->row = $goodsModel->get($this->col,$this->search,true,$this->sql);
    }

    public function optList(){
        $optionModel = new \application\models\GoodsOptionModel();
        $optionModel->leftJoin("gs_id","web_goods","gs_id");

        $this->sql = "";
        $this->search = array();
        $this->search["sl_id"] = $_SESSION['user_id'];
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "2";
        if( !empty($_REQUEST['state']) )  $this->search['gs_stt'] = $_REQUEST['state'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['useYn']) ) $this->search['gs_opt_use_yn'] = $_REQUEST['useYn'];        
        if( !empty($_REQUEST['geQty']) ) $this->search['gs_opt_stock_qty_then_ge'] = $_REQUEST['geQty'];        
        if( !empty($_REQUEST['leQty']) ) $this->search['gs_opt_stock_qty_then_le'] = $_REQUEST['leQty'];        

        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( empty($_REQUEST['col']) )   $_REQUEST['col'] = "gs_opt_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "asc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $optionModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $optionModel->get($this->col,$this->search,true,$this->sql);
    }

    public function optListExcel(){
        $this->header = false; $this->footer = false;

        $this->goods = new \application\models\GoodsModel();
        $this->option = new \application\models\GoodsOptionModel();
        $this->option->leftJoin("gs_id","web_goods","gs_id");

        $this->sql = "";
        $this->search = array();
        $this->search["sl_id"] = $_SESSION['user_id'];
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "2";
        if( !empty($_REQUEST['state']) )  $this->search['gs_stt'] = $_REQUEST['state'];

        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['useYn']) )    $this->search['gs_opt_use_yn'] = $_REQUEST['useYn'];        
        if( !empty($_REQUEST['geQty']) )    $this->search['gs_opt_stock_qty_then_ge'] = $_REQUEST['geQty'];        
        if( !empty($_REQUEST['leQty']) )    $this->search['gs_opt_stock_qty_then_le'] = $_REQUEST['leQty'];        
        if(!empty($_REQUEST['col']))        $this->search["col"] = $_REQUEST['col'];
        if(!empty($_REQUEST['colby']))      $this->search["colby"] = $_REQUEST['colby'];
        $cnt = $this->option->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        if( $this->cnt < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    public function bulkAdd(){
    }

    public function addSampleExcel(){
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
        $goodsModel = new \application\models\GoodsModel();
        $optionModel = new \application\models\GoodsOptionModel();
        $categoryModel = new \application\models\CategoryModel();
        $bulk = new \application\models\BulkExcel();
        $rowAll = $bulk->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            $j = 0;
            if( $i < 3) continue;
            $arr = array();
            $arr['code'] = get_gs_code();
            $arr['seller'] = $row[$j++];
            $arr['seller'] = $this->my['sl_id'];
            $arr['onlyPartnerYn'] = $this->my['sl_only_pt_yn'];
            $arr['onlyPartnerId'] = $this->my['sl_only_pt_id'];
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
            $optListStr = $row[$j++];
            if( empty($optListStr) ) continue;
            $optList = explode(",",$optListStr);
            $stockQty = 0;
            foreach($optList as $optStr ){
                $opt = explode("^",$optStr);
                $stockQty += $opt[1];
            }

            //$arr['addOptSubject']= $row[$j++];
            //$addOptListStr = $j++;
            $arr['consumerPrice']= $row[$j++];
            $arr['supplyPrice']= $row[$j++];
            $arr['goodsPrice']= $row[$j++];
            $arr['goodsPriceAuto']= 1;
            $arr['orderMinQty']= $row[$j++];
            $arr['orderMaxQty']= $row[$j++];
            $arr['stockQty']= $row[$j++];
            $arr['stockQty']= $stockQty;
            $arr['qtyNoti']= $row[$j++];
            $arr['salesBeginDate']= $row[$j++];
            $arr['salesBeginDate']= !empty($arr['salesBeginDate'])?explode(" ",$arr['salesBeginDate']):"inif";
            $arr['salesEndDate']= $row[$j++];
            $arr['salesEndDate']= !empty($arr['salesEndDate'])?explode(" ",$arr['salesEndDate']):"inif";
            $arr['buyUseGrade']= $row[$j++];
            $arr['deliveryType']= $row[$j++];
            $arr['deliveryCharge']= $row[$j++];
            $arr['deliveryFree']= $row[$j++];
            $arr['claimDeliveryCharge']= $row[$j++];
            $arr['deliveryRegion']= $row[$j++];
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
            $res = $goodsModel->add($arr);
            if($res=="000"){
                $success++;
                $gs_id = $goodsModel->pdo->lastInsertId();
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
                    $res = $optionModel->add($value);
                }
            }
        }
        $msg = $success > 0 ? $success."개의 상품이 등록되었습니다." : $res."실패\\n다시 시도 해주세요.";
        //access($msg , _PRE_URL);
        access($msg , "/Goods/waitList");
    }

    public function bulkEdit(){
    }

    public function bulkEditExcel(){
        $this->categoryModel = new \application\models\CategoryModel();
        $goodsModel = new \application\models\GoodsModel();
        $this->header = false; $this->footer = false;

        $this->sql = "";
        $this->search = array();
        $this->search["sl_id"] = $_SESSION['user_id'];
        if( !empty($_REQUEST['state']) ){
            $this->search["gs_stt"] = $_REQUEST['state'];
        }else{
            $this->search["gs_stt"] = "2";
        }
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['ctg']) ){
            $this->sql = " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['geQty']) ) $this->search["gs_stock_qty_then_ge"] = $_REQUEST['geQty']; 
        if( !empty($_REQUEST['leQty']) ) $this->search["gs_stock_qty_then_le"] = $_REQUEST['leQty']; 
        if( !empty($_REQUEST['gePrice']) ) $this->search["gs_price_then_ge"] = $_REQUEST['gePrice']; 
        if( !empty($_REQUEST['lePrice']) ) $this->search["gs_price_then_le"] = $_REQUEST['lePrice']; 
        if( !empty($_REQUEST['isopen']) ) $this->search["gs_isopen"] = $_REQUEST['isopen']; 
        if(!empty($_REQUEST['col'])) $this->search["col"] = $_REQUEST['col'];
        if(!empty($_REQUEST['colby'])) $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
        if( $this->cnt < 1 ){ access("출력할 자료가 없습니다."); exit; } 
        $this->row = $goodsModel->get($this->col,$this->search,true,$this->sql);
    }

    public function setExcel(){
        require_once _LIB.'goodsinfo.lib.php';
        $this->header = false; $this->footer = false;
        $goodsModel = new \application\models\GoodsModel();

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
            if( empty($id) ) continue;
            $goods = $goodsModel->get("*",array("gs_id"=>$id));
            if( empty($goods) ) continue;

            $arr['code'] = $row[$j++];
            if( $goods['gs_code'] != $arr['code'] ) continue;

            $arr['seller'] = $row[$j++];
            if( $goods['sl_id'] != $arr['seller'] ) continue;
            if( $goods['sl_id'] != $this->my['sl_id'] ) continue;

            $priceChange = false;
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
            if( $goods['gs_consumer_price'] != $arr['consumerPrice'] ) $priceChange = true;
            $arr['supplyPrice']= $row[$j++];
            if( $goods['gs_supply_price'] != $arr['supplyPrice'] ) $priceChange = true;
            $arr['goodsPrice']= $row[$j++];
            if( $goods['gs_price'] != $arr['goodsPrice'] ) $priceChange = true;
            if( $priceChange ){
                $arr['goodsPriceAuto']= "1";
                $arr['state'] = 1;
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
            $arr['simg1']= $row[$j++];
            if( $arr["simg1"] == $goods["gs_simg1"] ) unset($arr["simg1"]);
            else $arr["simg1Del"] = $goods["gs_simg1"];
            $arr['simg2']= $row[$j++];
            if( $arr["simg2"] == $goods["gs_simg2"] ) unset($arr["simg2"]);
            else $arr["simg2Del"] = $goods["gs_simg2"];
            $arr['simg3']= $row[$j++];
            if( $arr["simg3"] == $goods["gs_simg3"] ) unset($arr["simg3"]);
            else $arr["simg3Del"] = $goods["gs_simg3"];
            $arr['simg4']= $row[$j++];
            if( $arr["simg4"] == $goods["gs_simg4"] ) unset($arr["simg4"]);
            else $arr["simg4Del"] = $goods["gs_simg4"];
            $arr['simg5']= $row[$j++];
            if( $arr["simg5"] == $goods["gs_simg5"] ) unset($arr["simg5"]);
            else $arr["simg5Del"] = $goods["gs_simg5"];

            $arr['content']= $row[$j++];
            $arr['infoType'] = $row[$j++];
            if( !empty($arr['infoType']) ){
                foreach( $item_info[$arr['infoType']]['article'] as $key=>$value ){
                    $arr['infoValue'][$key] = $row[$j++];
                }
            }
            $res = $goodsModel->set($arr,$id);
            if($res=="000") $success++;
        }
        $msg = $success > 0 ? $success."개의 상품이 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function optBulkEditExcel(){
        $this->header = false; $this->footer = false;

        $optionModel = new \application\models\GoodsOptionModel();
        $optionModel->leftJoin("gs_id","web_goods","gs_id");

        $this->sql = "";
        $this->search = array();
        $this->search["sl_id"] = $_SESSION['user_id'];
        if( empty($_REQUEST['state']) ) $_REQUEST['state'] = "2";
        if( !empty($_REQUEST['state']) ) $this->search['gs_stt'] = $_REQUEST['state'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['useYn']) ) $this->search['gs_opt_use_yn'] = $_REQUEST['useYn'];        
        if( !empty($_REQUEST['geQty']) ) $this->search['gs_opt_stock_qty_then_ge'] = $_REQUEST['geQty'];        
        if( !empty($_REQUEST['leQty']) ) $this->search['gs_opt_stock_qty_then_le'] = $_REQUEST['leQty'];        

        if(!empty($_REQUEST['col'])) $this->search["col"] = $_REQUEST['col'];
        if(!empty($_REQUEST['colby'])) $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $optionModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        if( $this->cnt < 1 ){ access("출력할 자료가 없습니다."); exit; } 
        $this->row = $optionModel->get($this->col,$this->search,true,$this->sql);
    }

    public function setOptExcel(){
        $this->header = false; $this->footer = false;
        $optionModel = new \application\models\GoodsOptionModel();
        $goodsModel = new \application\models\GoodsModel();
        $bulk = new \application\models\BulkExcel();
        $rowAll = $bulk->upload();
        $success = 0;
        $i = 0;
        foreach( $rowAll as $row ){
            $i++;
            if( $i < 3) continue;

            $arr = array();
            $j = 0;
            $goodsId = $row[$j++];          // 상품 번호
            $goodsName = $row[$j++];        // 상품명 
            $id = $row[$j++];               // 옵션 번호
            $arr['code'] = $row[$j++];      // 바코드
            $arr['name'] = $row[$j++];      // 옵션명
            if( empty($arr['name']) ) continue;
            $arr['useYn'] = $row[$j++];     // 사용 여부
            $arr['stockQty'] = $row[$j++];  // 재고 수량
            $arr['qtyNoti'] = $row[$j++];   // 통보 수량
            $arr['orderby'] = $row[$j++];   // 정렬 순서
            $arr['goodsId'] = $goodsId;

            $goods = $goodsModel->get("sl_id",array("gs_id"=>$goodsId));
            if( empty($goods['sl_id']) ) continue;
            if( $goods['sl_id'] != $this->my['sl_id'] ) continue;

            $option = $optionModel->get("gs_id",array("gs_opt_id"=>$id));
            if( empty($option) ){
                //$res = $optionModel->add($arr);
            }else{
                if( $option['gs_id'] != $goodsId ) continue;
                $res = $optionModel->set($arr,$id);
            }
            if($res == "000") $success++;
            $option = $optionModel->get("sum(gs_opt_stock_qty) as stockQty" ,array("gs_id"=>$goodsId));
            $goodsModel->set(array("gs_stock_qty"=>$option['stockQty'],"gs_update_dt"=>_DATE_YMDHIS),$goodsId,"value");
        }
        $msg = $success > 0 ? $success."개의 옵션이 수정되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , _PRE_URL);
    }

    public function qaList(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();

        $qaModel = new \application\models\GoodsQaModel();

        $this->search = array();
        $this->search['gs_qa_sl_id'] = $_SESSION['user_id'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['shop']) ) $this->search['pt_id'] = $_REQUEST['shop'];
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['answerYn']) ) $this->search['gs_qa_answer_yn'] = $_REQUEST['answerYn'];

        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( empty($_REQUEST['col']) )   $_REQUEST['col'] = "gs_qa_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "asc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $qaModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $qaModel->get($this->col,$this->search,true);
    }

    public function qaListExcel(){
        $this->header=false; $this->footer=false;
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();

        $qaModel = new \application\models\GoodsQaModel();
        $this->search = array();
        $this->search['gs_qa_sl_id'] = $_SESSION['user_id'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['shop']) ) $this->search['pt_id'] = $_REQUEST['shop'];
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['answerYn']) ) $this->search['gs_qa_answer_yn'] = $_REQUEST['answerYn'];

        if( empty($_REQUEST['col']) )   $_REQUEST['col'] = "gs_qa_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "asc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $qaModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        if( $this->cnt < 1 ){ access("출력할 자료가 없습니다."); exit; } 
        $this->row = $qaModel->get($this->col,$this->search,true);
    }

    public function qaDescPopup(){
        $this->header = "head"; $this->footer = false;
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();
        $goodsModel = new \application\models\GoodsModel();
        $qaModel = new \application\models\GoodsQaModel();
        $this->row  = $qaModel->get("*", array("gs_qa_id"=>$this->param['ident']));
        $this->gs = $goodsModel->get("*",array("gs_id"=>$this->row['gs_id']));
    }

    public function qaAnswer(){
        $qaModel = new \application\models\GoodsQaModel();
        $res = $qaModel->answer($_POST,$this->param['ident']);
        if($res=="000"){
            if($_POST['emailNoticeYn']=='y'){
                $templateModel = new \application\models\TemplateModel();
                $res = $templateModel->sendMail($_POST['userId'],"3");
            }
            if($_POST['cellphoneNoticeYn']=='y'){
                // 메일 및 문자 보내기 (추후 추가 필요)
            }
        }
        $msg = $res == "000" ? "상품 문의의 답변이 등록되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , "close");
    }

    public function qaHidden(){
        $qaModel = new \application\models\GoodsQaModel();
        $res = $qaModel->hidden($this->param['ident']);
        $msg = $res == "000" ? "상품 문의가 숨김 처리 되었습니다." : $res."실패\\n다시 시도 해주세요.";
        access($msg , "close");
    }

    public function reviewList(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList();
        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $reviewModel = new \application\models\GoodsReviewModel();
        $reviewModel->leftJoin("od_id","web_order","od_id");

        $this->search = array();
        $this->search['gs_rv_sl_id'] = $_SESSION['user_id'];
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['shop']) ) $this->search['pt_id'] = $_REQUEST['shop'];
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( empty($_REQUEST['col']) )   $_REQUEST['col'] = "gs_rv_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "asc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $reviewModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $reviewModel->get($this->col,$this->search,true);
    }

    public function reviewListExcel(){
        $this->header = false; $this->footer=false;
        $partner = new \application\models\PartnerModel();
        $this->pt_li = $partner->getNameList();
        $this->review = new \application\models\GoodsReviewModel();
        if( $this->review->getCnt() < 1 ){ access("출력할 자료가 없습니다."); exit; } 
    }

    function reviewDescPopup(){
        $this->header = "head"; $this->footer = false;
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

    public function analysis(){
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['sl_id'] = $this->my['sl_id'];
        $search['od_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
        $search['od_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        $search['od_stt_in_all'] = $GLOBALS['od_stt_type']['주문']; 
        $search['col'] = "sum_qty";
        $search['colby'] = "desc";
        $search['rpp'] = 100;
        $orderModel = new \application\models\OrderModel();
        $orderModel->leftJoin("gs_id","web_goods","gs_id");
        $sum = $orderModel->get("sum(od_qty) as sum_qty",$search);
        $this->sum = $sum['sum_qty'];
        $orderModel->sql_group = " group by gs_id  ";
        $this->row = $orderModel->get("gs_id, od_goods_info, sum(od_qty) as sum_qty, count(od_id) as od_cnt, sum(od_amount) as sum_amount",$search,true);
    }

    public function analysisExcel(){
        $this->header = false; $this->footer = false;
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        $search = array();
        $search['sl_id'] = $this->my['sl_id'];
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



}
?>
