<?php
namespace application\Admin\controllers;

class BoardController extends Controller{
    public $col;
    public $cnt;

    public function init(){ 
        $this->col = "*";
        $this->cnt = 0;
    }

    public function groupList(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->boardGroup->getCnt();                
    }

    public function groupListExcel(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $this->header = false; $this->footer = false;
        if( $this->boardGroup->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }

    public function addGroup(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $res = $this->boardGroup->add($_POST);
        $msg = $res == "000" ? "게시판 그룹이 추가 되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Board/groupList");
        access($msg , $_POST['preUrl']);
    }

    public function groupOverChk(){ 
        $this->boardGroup = new \application\models\BoardGroupModel();
        $this->header=false; $this->footer=false;
        $res = $this->boardGroup->overChk("bogr_id",$_GET['id']);
        echo json_encode(array('res'=>$res));
    }

    public function groupModify(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $this->row = $this->boardGroup->get("*",array("bogr_id"=>$this->param['ident']));
    }
    
    public function setGroup(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $res = $this->boardGroup->set(($_POST),$this->param['ident']);
        $msg = $res == "000" ? "게시판 그룹 정보가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Board/groupList");
        access($msg , $_POST['preUrl']);
    }
 
    public function removeGroup(){
        $this->boardGroup = new \application\models\BoardGroupModel();
        $res = $this->boardGroup->remove($this->param['ident']);
        $msg = $res == "000" ? "게시판 그룹이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Board/groupList");
        access($msg , urldecode($_GET['preUrl']));
    }
 
    public function list(){
        $this->board = new \application\models\BoardModel();
        $boardGroup = new \application\models\BoardGroupModel();
        $this->bogr_li = $boardGroup->getNameList();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->board->getCnt();
        unset(($this->bogr_li)['']);
    }

    public function listExcel(){
        $this->board = new \application\models\BoardModel();
        $this->header = false; $this->footer = false;
        if( !empty( $this->param['ident'] ) ){
            $_REQUEST['idxl'] = $this->param['ident'];
            $_REQUEST['col'] = " FIELD ( idx, {$this->param['ident']} ) ";
        }
        if( $this->board->getCnt() < 1 ) access("출력할 자료가 없습니다.");
    }    
   
    public function form(){
        $this->board = new \application\models\BoardModel();
        $boardGroup = new \application\models\BoardGroupModel();
        $this->bogr_li = $boardGroup->getNameList();
        $this->last_idx = $this->board->selectAuto();
    }
    
    public function add(){
        $this->header = false; $this->footer = false;
        $this->board = new \application\models\BoardModel();
        $res = $this->board->add($_POST);
        $msg = $res == "000" ? "게시판이 추가되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Board/list");
        access($msg , $_POST['preUrl']);
    }
    
    public function modify(){
        $this->board = new \application\models\BoardModel();
        $boardGroup = new \application\models\BoardGroupModel();
        $this->bogr_li = $boardGroup->getNameList();
        $this->row = $this->board->get("*", array("bo_id"=>$this->param['ident']));
    }    

    public function set(){
        $this->header = false; $this->footer = false;
        $this->board = new \application\models\BoardModel();
        $res = $this->board->set(($_POST),$this->param['ident']);
        $msg = $res == "000" ? "게시판이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Board/list");
        access($msg , $_POST['preUrl']);
    }

    public function remove(){
        $this->header = false; $this->footer = false;
        $this->board = new \application\models\BoardModel();
        $res = $this->board->remove($this->param['ident']);
        $msg = $res == "000" ? "게시판이 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        //access($msg , "/Board/list");
        access($msg , urldecode($_GET['preUrl']));
    }

    public function postList(){
        $partnerModel = new \application\models\PartnerModel();
        $this->pt_li = $partnerModel->getNameList("a");
        $boardModel = new \application\models\BoardModel();
        $this->bo_li = $boardModel->getNameList();
        if( empty($this->bo_li) ) access("게시판이 존재하지 않습니다.","/Board/list");
        if( empty($_REQUEST['board']) ) $_REQUEST['board'] = array_key_first($this->bo_li);
        $this->boardRow = $boardModel->get("*",array("bo_id"=>$_REQUEST['board']));

        $this->postModel = new \application\models\PostModel($_REQUEST['board']);
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->search = array();
        $this->search['bopo_depth'] = "0";
        $this->search['rpp'] = $_REQUEST['rpp'];
        $this->search['page'] = $_REQUEST['page'];
        if( !empty($_REQUEST['col']) ){
            $this->search['col'] = $_REQUEST['col'];
            if( !empty($_REQUEST['colby']) ){
                $this->search['colby'] = $_REQUEST['colby'];
            }
        }
        $cnt = $this->postModel->get("count(bopo_id) as cnt",$this->search);
        $this->cnt = $cnt['cnt'];
        $this->row = $this->postModel->get($this->col,$this->search,true);
        $this->userModel = new \application\models\UserModel();
    }

    public function postForm(){
        $board = new \application\models\BoardModel();
        $this->bo_li = $board->getNameList();
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Board/postList");
        $this->boardRow = $board->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":$_REQUEST['returnUrl'];
    }

    public function postAnswer(){
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $board = new \application\models\BoardModel();
        $this->boardRow = $board->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->post = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $this->post->get("*",array("bopo_id"=>$this->param['ident']));
        if(empty($this->row)) access("선택 게시글이 존재하지 않습니다.","/Board/postList");
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":$_REQUEST['returnUrl'];
    }

    public function addPost(){
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $this->post = new \application\models\PostModel($_POST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $this->post->add($_POST);
        $msg = $res == "000" ? "페이지가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function postModify(){
        $board = new \application\models\BoardModel();
        $this->bo_li = $board->getNameList();
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $this->post = new \application\models\PostModel($_REQUEST['board']);
        $this->boardRow = $board->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->row = $this->post->get("*",array("bopo_id"=>$this->param['ident']));
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":$_REQUEST['returnUrl'];
    }

    public function postView(){
        $board = new \application\models\BoardModel();
        $this->bo_li = $board->getNameList();
        if( empty($_REQUEST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $this->boardRow = $board->get("*",array("bo_id"=>$_REQUEST['board']));
        $this->post = new \application\models\PostModel($_REQUEST['board']);
        $this->row = $this->post->get("*",array("bopo_id"=>$this->param['ident']));
        $this->comment = new \application\models\PostCommentModel($_REQUEST['board']);
        $this->commentRow = $this->comment->get("*",array("bopo_id"=>$this->param['ident']),true);
        $this->returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":$_REQUEST['returnUrl'];
    }

    public function setPost(){
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $this->post = new \application\models\PostModel($_POST['board']);
        $res = $this->post->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "페이지가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function removePost(){
        if( empty($_GET['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $this->post = new \application\models\PostModel($_GET['board']);
        $res = $this->post->remove($this->param['ident']);
        $msg = $res == "000" ? "페이지가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        $returnUrl = empty($_REQUEST['returnUrl'])?"/Board/postList":urldecode($_REQUEST['returnUrl']);
        access($msg , $returnUrl);
    }

    public function addComment(){
        $this->header=false; $this->footer=false;
        if( empty($_POST['board']) ) access("게시판이 존재하지 않습니다.","/Board/list");
        $this->comment = new \application\models\PostCommentModel($_POST['board']);
        $_POST['userId'] = $_SESSION['user_id'];
        $_POST['userName'] = $_SESSION['user_name'];
        $res = $this->comment->add($_POST);
        $msg = $res == "000" ? "댓글이 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg, _PRE_URL);
    }

    //---------------------------------------------------------------------------
    public function flatList(){
        $this->flat = new \application\models\FlatModel();
        if( empty($_REQUEST['rpp']) ) $_REQUEST['rpp'] = 10;
        if( empty($_REQUEST['page']) ) $_REQUEST['page'] = 1;
        $this->cnt = $this->flat->getCnt();                
    } 

    public function addFlat(){
        $this->flat = new \application\models\FlatModel();
        $res = $this->flat->add($_POST);
        $msg = $res == "000" ? "페이지가 등록되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }

    public function flatModify(){
        $this->flat = new \application\models\FlatModel();
        $this->row = $this->flat->get("*", array("fl_id"=>$this->param['ident']) );
    }

    public function setFlat(){
        $this->flat = new \application\models\FlatModel();
        $res = $this->flat->set($_POST,$this->param['ident']);
        $msg = $res == "000" ? "페이지가 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_POST['preUrl']);
    }
    public function removeFlat(){
        $this->header = false; $this->footer= false;
        $this->flat = new \application\models\FlatModel();
        $res = $this->flat->remove($this->param['ident']);
        $msg = $res == "000" ? "페이지가 삭제되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , $_GET['preUrl']);
    }


}

?>
