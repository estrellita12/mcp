<?php
namespace application\Partner\controllers;

class MypageController extends Controller{
    public $col;
    public $search;
    public $sql;
    
    public function init(){ 
        $this->col= "*";
        $this->search = array();
        $this->sql = "";
    }

    public function info(){
        $gradeModel = new \application\models\PartnerGradeModel();
        $this->gr_li = $gradeModel->getNameList();
    }

    public function set(){
        $res = $this->partnerModel->set(array_merge($_POST,$_FILES),$_SESSION['user_id']);
        $msg = $res == "000" ? "정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function shop(){
        $configModel = new \application\models\ConfigModel();
        $this->config = $configModel->get("*",array("cf_id"=>1));
    }

    public function policy(){
        //echo 
    }


    public function category(){
        $this->categoryModel = new \application\models\CategoryModel();
        $defaultModel = new \application\models\DefaultModel();
        $default = $defaultModel->get("shop_use_ctg",array("pt_id"=>"admin"));
        $this->changeMode = "modify";
        if(empty($this->my['shop_use_ctg'])){
            $this->my['shop_use_ctg'] = $default['shop_use_ctg'];
            $this->changeMode = "add";
        }
        $this->my['shop_use_ctg'] = unserialize($this->my['shop_use_ctg']);
    }

    public function removeCategory(){
        $partnerModel = new \application\models\PartnerModel();
        $arr = array('shop_use_ctg'=>'');
        $res = $partnerModel->set($arr,$_SESSION['user_id'],"value");
        $msg = $res == "000" ? "가맹점 카테고리 정보가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function menu(){
        $gnbModel = new \application\models\GnbMenuModel();
        $this->my['shop_default_menu'] = $gnbModel->get("*", array("pt_id"=>$_SESSION['user_id']));
        $this->my['shop_default_menu_mode'] = "modify";
        if(empty($this->my['shop_default_menu'])){
            $this->my['shop_default_menu'] = $gnbModel->get("*", array("pt_id"=>"admin"));
            $this->my['shop_default_menu_mode'] = "add";
        }
    }

    public function setMenu(){
        $gnbModel = new \application\models\GnbMenuModel();
        $res = $gnbModel->set($_POST,$_SESSION['user_id']);
        $msg = $res == "000" ? "가맹점 메뉴 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function removeMenu(){
        $gnbModel = new \application\models\GnbMenuModel();
        $res = $gnbModel->remove($_SESSION['user_id']);
        $msg = $res == "000" ? "가맹점 메뉴 정보가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function menuGoodsListPopup(){
        $this->header = "head"; $this->footer=false;
        $this->categoryModel = new \application\models\CategoryModel();
        if( empty($this->my['shop_use_ctg']) ){
            $defaultModel = new \application\models\DefaultModel();
            $default = $defaultModel->get("shop_use_ctg",array("pt_id"=>"admin"));
            $this->my['shop_use_ctg'] = $default['shop_use_ctg'];
        }
        $this->my['shop_use_ctg'] = unserialize($this->my['shop_use_ctg']);
        $sql = "";
        foreach($this->my['shop_use_ctg'] as $ctg){
            if( !empty($sql) ) $sql .= " or ";
            $sql .= " ( gs_ctg like '{$ctg}%' or  gs_ctg2 like '{$ctg}%' or  gs_ctg3 like '{$ctg}%' ) ";
        }
        $this->sql = " and ( {$sql} ) ";

        $this->goodsModel = new \application\models\GoodsModel();
        $this->selected = array();
        if( !empty($this->param['action']) ){
            $search = array();
            $search['gs_id_in_all'] = $this->param['action'];
            $search['col'] = "  field (gs_id,{$this->param['action']}) ";
            $this->selected = $this->goodsModel->get("*", $search, true,$this->sql );
        }
        $this->selectedCnt = count($this->selected);
        $this->search['gs_stt'] = "2";
        if( !empty($_REQUEST['ctg']) ){
            $this->sql .= " and ( gs_ctg like '{$_REQUEST['ctg']}%' or gs_ctg2 like '{$_REQUEST['ctg']}%' or gs_ctg3 like '{$_REQUEST['ctg']}%' )";
        }

        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if(strpos($_REQUEST['kwd'],",")) $this->search["{$_REQUEST['srch']}_in_all"] = $_REQUEST['kwd'];
            else $this->search["{$_REQUEST['srch']}_like_all"] = $_REQUEST['kwd'];
        }
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( !empty($_REQUEST['geQty']) ) $this->search["gs_stock_qty_then_ge"] = $_REQUEST['geQty']; 
        if( !empty($_REQUEST['leQty']) ) $this->search["gs_stock_qty_then_le"] = $_REQUEST['leQty']; 
        if( !empty($_REQUEST['gePrice']) ) $this->search["gs_price_then_ge"] = $_REQUEST['gePrice']; 
        if( !empty($_REQUEST['lePrice']) ) $this->search["gs_price_then_le"] = $_REQUEST['lePrice']; 

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "gs_update_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        $cnt = $this->goodsModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
    }

    public function setGoodsList(){
        $gnbModel = new \application\models\GnbMenuModel();
        $res = $gnbModel->set($_POST,$_SESSION['user_id']);
        $msg = $res == "000" ? "가맹점 메뉴 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , "close");
    }
    
    public function gnb(){
        $this->my['shop_gnb_mode'] = "modify";
        if( empty($this->my['shop_gnb']) ){
            $defaultModel = new \application\models\DefaultModel();
            $default = $defaultModel->get("shop_gnb",array("pt_id"=>"admin"));
            $this->my['shop_gnb'] = $default['shop_gnb'];
            $this->my['shop_gnb_mode'] = "add";
        }
        $this->my['shop_gnb'] = json_decode($this->my['shop_gnb'],true);
    }
    
    public function setGnb(){
        $partnerModel = new \application\models\PartnerModel();
        $gnb = array();
        for($i=0;$i<count($_POST['gnbTitle']);$i++){
            $gnb[$i]['title']=$_POST['gnbTitle'][$i];
            $gnb[$i]['url']=$_POST['gnbUrl'][$i];
        }
        $res = $partnerModel->set(array("gnb"=>$gnb,"id"=>$_SESSION['user_id']),$_SESSION['user_id']);
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function removeGnb(){
        $partnerModel = new \application\models\PartnerModel();
        $res = $partnerModel->set(array("shop_gnb"=>"","pt_id"=>$_SESSION['user_id']),$_SESSION['user_id'],"value");
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function mainLayout(){
        $this->my['shop_main_layout_mode'] = "modify";
        if( empty($this->my['shop_main_layout']) ){
            $defaultModel = new \application\models\DefaultModel();
            $default = $defaultModel->get("shop_main_layout",array("pt_id"=>"admin"));
            $this->my['shop_main_layout'] = $default['shop_main_layout'];
            $this->my['shop_main_layout_mode'] = "add";
        }
        $this->my['shop_main_layout'] = json_decode($this->my['shop_main_layout'],true);
    }

    public function removeMainLayout(){
        $partnerModel = new \application\models\PartnerModel();
        $res = $partnerModel->set(array("shop_main_layout"=>"","pt_id"=>$_SESSION['user_id']),$_SESSION['user_id'],"value");
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function setLayout(){
        $this->header=false; $this->footer=false;
        $partnerModel = new \application\models\PartnerModel();
        $mainLayout = array();
        for($i=0;$i<count($_POST['mainLayoutTitle']);$i++){
            $mainLayout[$i]['title']=$_POST['mainLayoutTitle'][$i];
            $mainLayout[$i]['url']=$_POST['mainLayoutUrl'][$i];
            $mainLayout[$i]['api']=$_POST['mainLayoutApiUrl'][$i];
            $mainLayout[$i]['apiCol']=$_POST['mainLayoutApiCol'][$i];
            $mainLayout[$i]['type']=$_POST['mainLayoutType'][$i];;
            $mainLayout[$i]['design']=$_POST['mainLayoutDesign'][$i];
            $mainLayout[$i]['cnt']=$_POST['mainLayoutCnt'][$i];
            $mainLayout[$i]['rpp']=$_POST['mainLayoutRpp'][$i];
            $mainLayout[$i]['mcnt']=$_POST['mainLayoutMCnt'][$i];
            $mainLayout[$i]['mrpp']=$_POST['mainLayoutMRpp'][$i];
        }

        $res = $partnerModel->set(array("id="=>$_SESSION['user_id'],"mainLayout"=>$mainLayout),$_SESSION['user_id']);
        $msg = $res == "000" ? "가맹점 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function yetList(){
        $orderModel = new \application\models\OrderModel();

        $this->sql = "";
        $this->search = array();
        $this->search["pt_id"] = $_SESSION['user_id'];
        $order = " ( od_stt in ({$GLOBALS['od_stt_type']['정산']}) and partner_pay_stt = '1' ) ";
        $cancel = " ( od_stt = '36' and ( partner_pay_stt = '3') ) ";
        $delivery = " ( ( od_stt = '29' and partner_pay_stt = '3' ) or ( od_stt = '36' and partner_pay_stt = '1' ) ) ";
        $this->sql = " and ( {$order} or {$cancel} or {$delivery} ) ";
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "od_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];

        $cnt = $orderModel->get("count(gs_id) as cnt",$this->search, false, $this->sql);
        $this->cnt = $cnt['cnt'];   
        $this->row = $orderModel->get($this->col,$this->search,true,$this->sql);
    }

    public function yetListExcel(){
        $this->header = false; $this->footer = false;

        $sellerModel = new \application\models\SellerModel();
        $this->sl_li = $sellerModel->getNameList();

        $orderModel = new \application\models\OrderModel();
        $this->col = " sl_id, od_id, od_no, od_goods_info, od_dt, od_rcent_dt, partner_pay_stt, od_paymethod, od_stt, od_goods_price, od_use_point, od_use_coupon  ";
        $this->sql = "";
        $this->search = array();
        $this->search["pt_id"] = $_SESSION['user_id'];
        if( empty($_REQUEST['beg']) ) $_REQUEST['beg'] = _DATE_YMD_OD;
        if( empty($_REQUEST['end']) ) $_REQUEST['end'] = _DATE_YMD;
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "od_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];

        $order = " ( od_stt in ({$GLOBALS['od_stt_type']['정산']}) and partner_pay_stt = '1' ) ";
        $this->orderList = $orderModel->get($this->col,$this->search,true," and {$order}");
        $cancel = " ( od_stt = '36' and ( partner_pay_stt = '3') ) ";
        $this->cancelList = $orderModel->get($this->col,$this->search,true," and {$cancel}");
    }

    public function payList(){
        $payModel = new \application\models\PartnerPayModel();
        $this->sql = "";
        $this->search = array();
        $this->search["pt_id"] = $_SESSION['user_id'];
        $this->search["ppay_cancel_yn"] = "n";
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "ppay_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];

        $cnt = $payModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $payModel->get($this->col,$this->search,true,$this->sql);
    }

    public function orderListPopup(){
        $this->header = "head"; $this->footer = false;
        $this->orderModel = new \application\models\OrderModel();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search = array();
        $this->search['pt_id'] = $_SESSION['user_id'];
        $this->search['od_id_in_'] = $this->param['ident'];
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        $cnt = $this->orderModel->get("count(od_id) as cnt",$this->search, false);
        $this->cnt = $cnt['cnt'];   
    }

    public function payInfoPopup(){
        $this->header="head"; $this->footer=false;
        $payModel = new \application\models\PartnerPayModel();
        $this->row = $payModel->get("*",array("ppay_id"=>$this->param['ident']));
    }

    public function board(){
        $boardModel = new \application\models\BoardModel();
        $rowAll = $boardModel->get("bo_id,bo_name",array("bogr_id"=>"partner_board"),true);
        $this->bo_li = array();
        foreach($rowAll as $row){
            $this->bo_li[$row['bo_id']] = $row['bo_name'];
        } 
        if( empty($_REQUEST['board']) ) $_REQUEST['board'] = $rowAll[0]['bo_id'];
        $this->board = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));;
        $this->replyAllow = false;
        if( $this->board['bo_use_reply'] == "y" ){
            if( $this->board['bo_reply_perm']=="partner" || $this->board['bo_reply_perm']=="guest" ){
                $this->replyAllow = true;
            }
        }

        $this->postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->search = array();
        $this->search['bopo_depth'] = "0";
        $this->sql = " and ( bopo_secret_yn = 'n' or user_id = '{$_SESSION['user_id']}' ) ";
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "bopo_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];

        $cnt = $this->postModel->get("count(*) as cnt",$this->search,false,$this->sql);
        $this->cnt = $cnt['cnt'];
        $this->row = $this->postModel->get($this->col,$this->search,true,$this->sql);
    }

    public function postForm(){
        $boardModel = new \application\models\BoardModel();
        $this->bo_li = $boardModel->getNameList("partner_board");
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urlencode($_REQUEST['returnUrl']);
    }

    public function addPost(){
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $this->header=""; $this->footer="";
        $postModel = new \application\models\PostModel($_POST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $postModel->add($_POST);
        $msg = $res == "000" ? "페이지가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function postView(){
        $boardModel = new \application\models\BoardModel();
        $this->bo_li = $boardModel->getNameList();
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->replyAllow = false;
        if( $this->boardRow['bo_use_reply'] == "y" ){
            if( $this->boardRow['bo_reply_perm']=="partner" || $this->boardRow['bo_reply_perm']=="guest" ){
                $this->replyAllow = true;
            }
        }
        $this->commentAllow = false;
        if( $this->boardRow['bo_use_comment'] == "y" ){
            if( $this->boardRow['bo_comment_perm']=="partner" || $this->boardRow['bo_comment_perm']=="guest" ){
                $this->commentAllow = true;
            }
        }

        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $postModel->view($this->param['ident']); // 조회수 증가
        $this->row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        $this->commentModel = new \application\models\PostCommentModel($_REQUEST['board']);
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urlencode($_REQUEST['returnUrl']);
    }

    public function postAnswer(){
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $board = new \application\models\BoardModel();
        $this->boardRow = $board->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->post = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $this->post->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Mypage/board");
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urlencode($_REQUEST['returnUrl']);
    }

    public function postModify(){
        $board = new \application\models\BoardModel();
        $this->bo_li = $board->getNameList();
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $this->post = new \application\models\PostModel($_REQUEST['board']);
        $this->boardRow = $board->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->row = $this->post->get("*",array("bopo_id"=>$this->param['ident']));
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urlencode($_REQUEST['returnUrl']);
    }

    public function setPost(){
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $postModel = new \application\models\PostModel($_POST['board']);
        $res = $postModel->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "페이지가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function removePost(){
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $postModel = new \application\models\PostModel($_POST['board']);
        $res = $postModel->remove($this->param['ident']);
        $msg = $res == "000" ? "페이지가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];

        $returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function addComment(){
        $this->header=false; $this->footer=false;
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $commentModel = new \application\models\PostCommentModel($_POST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $commentModel->add($_POST);
        $msg = $res == "000" ? "댓글이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg, _PRE_URL);
    }



}

?>
