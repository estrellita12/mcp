<?php
namespace application\Seller\controllers;

class MypageController extends Controller{
    public $col;
    public $search;
    public $sql;
    public $cnt;

    public function init(){ 
        $this->col= "*";
        $this->search = array();
        $this->sql = "";
        $this->cnt = 0;
    }

    public function info(){
        $gradeModel = new \application\models\SellerGradeModel();
        $this->gr_li = $gradeModel->getNameList();
    }

    public function delivery(){

    }

    public function set(){
        $this->header = false; $this->footer = false;
        $res = $this->sellerModel->set($_POST,$_SESSION['user_id']);
        $msg = $res == "000" ? "정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/info":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function yetList(){
        $orderModel = new \application\models\OrderModel();

        $this->sql = "";
        $this->search = array();
        $this->search["sl_id"] = $_SESSION['user_id'];
        $order = " ( od_stt in ({$GLOBALS['od_stt_type']['정산']}) and seller_pay_stt = '1' ) ";
        $cancel = " ( od_stt = '36' and ( seller_pay_stt = '3') ) ";
        $delivery = " ( ( od_stt = '29' and seller_pay_stt = '3' ) or ( od_stt = '36' and seller_pay_stt = '1' ) ) ";
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
        $this->sql = "";
        $this->search = array();
        $this->header = false; $this->footer = false;
        $this->col = " sl_id, od_id, od_no, od_goods_info, od_dt, od_rcent_dt, seller_pay_stt, od_paymethod, od_stt, od_goods_price, od_supply_price  ";
        $this->col .= " , if(od_stt = '29',od_claim_delivery_charge,0) as od_change_delivery_charge  ";
        $this->col .= " , if(od_stt = '36',od_claim_delivery_charge,0) as od_return_delivery_charge  ";
        $orderModel = new \application\models\OrderModel();
        $this->search["sl_id"] = $_SESSION['user_id'];
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

        $this->sql = " and ( od_stt in ({$GLOBALS['od_stt_type']['정산']}) and seller_pay_stt = '1' ) ";
        $this->orderList = $orderModel->get($this->col,$this->search,true,$this->sql);

        $this->sql = " and ( od_stt = '36' and ( seller_pay_stt = '3') ) ";
        $this->cancelList = $orderModel->get($this->col,$this->search,true,$this->sql);

        $this->sql = " and ( ( od_stt = '29' and seller_pay_stt = '3' ) or ( od_stt = '36' and seller_pay_stt = '1' ) ) ";
        $this->deliveryList = $orderModel->get($this->col,$this->search,true,$this->sql);
    }

    public function payList(){
        $this->sql = "";
        $this->search = array();
        $payModel = new \application\models\SellerPayModel();
        $this->search["sl_id"] = $_SESSION['user_id'];
        $this->search["spay_cancel_yn"] = "n";
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "spay_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];

        $cnt = $payModel->get("count(*) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $payModel->get($this->col,$this->search,true);
    }

    public function payInfoPopup(){
        $this->header="head"; $this->footer=false;
        $this->pay = new \application\models\SellerPayModel();
        $this->row = $this->pay->get("*",array("spay_id"=>$this->param['ident']));
    }

    public function orderListPopup(){
        $this->header = "head"; $this->footer = false;
        $orderModel = new \application\models\OrderModel();

        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search = array();
        $this->search['sl_id'] = $_SESSION['user_id'];
        $this->search['od_id_in_'] = $this->param['ident'];
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        $cnt = $orderModel->get("count(od_id) as cnt",$this->search, false);
        $this->cnt = $cnt['cnt'];   
        $this->row = $orderModel->get($this->col,$this->search,true,$this->sql);
    }

    public function board(){
        $boardModel = new \application\models\BoardModel();
        $rowAll = $boardModel->get("bo_id,bo_name",array("bogr_id"=>"seller_board"),true);
        $this->bo_li = array();
        foreach($rowAll as $row){
            $this->bo_li[$row['bo_id']] = $row['bo_name'];
        } 
        if( empty($_REQUEST['board']) ) $_REQUEST['board'] = $rowAll[0]['bo_id'];
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));;
        $this->replyAllow = false;
        if( $this->boardRow['bo_use_reply'] == "y" ){
            if( $this->boardRow['bo_reply_perm']=="seller" || $this->boardRow['bo_reply_perm']=="guest" ){
                $this->replyAllow = true;
            }
        }

        $this->postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->search = array();
        $this->search['bopo_depth'] = "0";
        $this->sql = " and ( bopo_secret_yn = 'n' or ( bopo_secret_yn = 'y' and user_id = '{$_SESSION['user_id']}') ) ";
        if( empty($_REQUEST['col']) ) $_REQUEST['col'] = "bopo_reg_dt";
        if( empty($_REQUEST['colby']) ) $_REQUEST['colby'] = "desc";
        $this->search["col"] = $_REQUEST['col'];
        $this->search["colby"] = $_REQUEST['colby'];
        if( empty($_REQUEST['rpp']) )   $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) )  $_REQUEST['page'] = 1;
        $this->search["rpp"] = $_REQUEST['rpp'];
        $this->search["page"] = $_REQUEST['page'];
        if( !empty($_REQUEST['term']) ){
            if( !empty($_REQUEST['beg']) ) $this->search["{$_REQUEST['term']}_then_ge"] = "{$_REQUEST['beg']} 00:00:00";
            if( !empty($_REQUEST['end']) ) $this->search["{$_REQUEST['term']}_then_le"] = "{$_REQUEST['end']} 23:59:59";
        }

        $cnt = $this->postModel->get("count(*) as cnt",$this->search,false,$this->sql);
        $this->cnt = $cnt['cnt'];
        $this->row = $this->postModel->get($this->col,$this->search,true,$this->sql);
    }

    public function postForm(){
        $boardModel = new \application\models\BoardModel();
        $this->bo_li = $boardModel->getNameList("seller_board");
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":$_REQUEST['returnUrl'];
    }

    public function addPost(){
        $this->header=false; $this->footer=false;
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($boardRow['bo_write_perm']!="seller") access($msg,"/Mypage/board");

        $postModel = new \application\models\PostModel($_POST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $postModel->add($_POST);
        $msg = $res == "000" ? "게시글이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_POST['returnUrl'])?"/Mypage/board":urldecode($_POST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function postView(){
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($this->boardRow['bo_read_perm']!="seller") access($msg,"/Mypage/board");
        $this->replyAllow = false;
        if( $this->boardRow['bo_use_reply'] == "y" ){
            if( $this->boardRow['bo_reply_perm']=="seller" || $this->boardRow['bo_reply_perm']=="guest" ){
                $this->replyAllow = true;
            }
        }
        $this->commentAllow = false;
        if( $this->boardRow['bo_use_comment'] == "y" ){
            if( $this->boardRow['bo_comment_perm']=="seller" || $this->boardRow['bo_comment_perm']=="guest" ){
                $this->commentAllow = true;
            }
        }

        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $postModel->view($this->param['ident']); // 조회수 증가
        $this->row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Mypage/board");

        $this->commentModel = new \application\models\PostCommentModel($_REQUEST['board']);
        $this->commentRow = $this->commentModel->get("*",array("bopo_id"=>$this->param['ident']),true);

        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":$_REQUEST['returnUrl'];
    }

    public function addComment(){
        $this->header=false; $this->footer=false;
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $boardRow = $boardModel->get("bo_comment_perm",array("bo_id"=>$_REQUEST['board']));
        if($boardRow['bo_comment_perm']!="seller") access($msg,"/Mypage/board");
 
        $commentModel = new \application\models\PostCommentModel($_REQUEST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $commentModel->add($_POST);
        $msg = $res == "000" ? "댓글이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg, _PRE_URL);
    }

    public function postModify(){
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($this->boardRow['bo_write_perm']!="seller") access($msg,"/Mypage/board");

        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Mypage/board");
        if($this->row['user_id'] != $_SESSION['user_id']) access($msg,"/Mypage/board");
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":$_REQUEST['returnUrl'];
    }

    public function setPost(){
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($boardRow['bo_write_perm']!="seller") access($msg,"/Mypage/board");
        
        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if($row['user_id'] != $_SESSION['user_id']) access($msg,"/Mypage/board");
        
        $res = $postModel->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "게시글이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_POST['returnUrl'])?"/Mypage/board":urldecode($_POST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function removePost(){
        if( empty($_GET['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($boardRow['bo_write_perm']!="seller") access($msg,"/Mypage/board");
        
        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if($row['user_id'] != $_SESSION['user_id']) access($msg,"/Mypage/board");

        $res = $postModel->remove($this->param['ident']);
        $msg = $res == "000" ? "게시글이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        
        $returnUrl = empty($_POST['returnUrl'])?"/Mypage/board":urldecode($_POST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function postAnswer(){
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Mypage/board");
        $msg = "접근 권한이 존재하지 않습니다.";
        $boardModel = new \application\models\BoardModel();
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));
        if($this->boardRow['bo_reply_perm']!="seller") access($msg,"/Mypage/board");
        
        $postModel = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $postModel->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Mypage/board");

        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Mypage/board":$_REQUEST['returnUrl'];
    }

}

?>
