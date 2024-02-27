<?php
namespace application\API_F\controllers;

use \Exception;

class teamController extends Controller{

    function init(){
        $this->temp();
        $this->order = new \application\models\OrderModel();
        $this->member = new \application\models\MemberModel();
        $this->teamOrder = new \application\models\OrderTeamModel();
        $this->review = new \application\models\GoodsReviewModel();
        $this->goods = new \application\models\GoodsModel();
        $this->goods->colArr['goodsPrice'] = "gs_price_".$this->shopGrade;
    }

    function add(){
        $res = 'success';
        $teamId = null;
        try{
            if(empty($this->accessInfo)) {
                echo json_encode(null);
                exit;
            }
            //init
            $selfId = $this->accessInfo['index'];
            $postParams = $this->postData;
            $postInfo = $postParams['params'];
            $goods = $postInfo['order']['goods'];

            //order Team set (DEFAULT : MAX 2)
            $teamArr = array( 
                'teamHost' => $selfId, //for data log
                'teamMax' => 2,
                'goodsId' => $goods['goodsId'],
                'teamCnt' => 0,
                'teamTime' => _DATE_YMDHIS_TMR,
                'teamStatus' => 'ready',
                "teamLatest"=>_DATE_YMDHIS,
            );

            $teamRes = $this->teamOrder->add($teamArr);
            if($teamRes['res'] != '000' || empty($teamRes['lastId'])){
                $res = 'team made error';
            }else if(!empty($teamRes['lastId'])){
                $teamId = $teamRes['lastId'];
            } 
        }catch(Exception $e){
            $res = 'systemError';
        }
        echo json_encode(array('res'=>$res, 'teamId'=>$teamId));
    }

    function getList(){
        $res = 'success';
        try{       
            $selfId = !empty($this->accessInfo['index']) ? $this->accessInfo['index'] : null;
    
            //options
            if(!empty($_REQUEST['activateChk'])){
                $_REQUEST['term'] = "timeLimit";
                $_REQUEST['beg'] = _DATE_YMDHIS;
            }
            if(!empty($_REQUEST['exceptSelf'])) $_REQUEST['notTeamHost'] = $selfId;
    
            //team select
            $teamList = $this->teamOrder->getList($this->teamOrder->getCol());
    
            //request reset
            if(!empty($_REQUEST['rpp'])) unset($_REQUEST['rpp']);
            if(!empty($_REQUEST['page'])) unset($_REQUEST['page']);

            $arr = array();
            $selfArr = array();
            foreach($teamList as $tl){
                $each = array();
                //team
                $each['team'] = $tl;
                $each['team']['teamTimeLimit'] = strtotime($each['team']['teamTime'])-strtotime(_DATE_YMDHIS);
    
                //goods
                $goodsData = $this->goods->get($this->goods->getCol(array("timg1", "goodsName", "consumerPrice", "goodsPrice")), array("gs_id"=>$tl['goodsId']));
                $each['goods'] = $goodsData;
    
                //review
                $eachReview = $this->review->getGoodsInfo($tl['goodsId'], $this->shopId);
                $each['reviewAvg'] = !empty($eachReview['avg']) ? round($eachReview['avg'], 1) : 0;
                $each['reviewCnt'] = $eachReview['cnt'];           

                //orders
                $_REQUEST['teamId'] = $tl['teamId'];
                $_REQUEST['exceptState'] = 1;
                $orderData = $this->order->getList($this->order->getCol(array("userId", "orderDate")));
                $each['order'] = $orderData;
    
                //order Cnt
                $each['buyCnt'] = $this->order->getStateCnt($tl['goodsId'], 14);

                //member
                $memberArr = array();
                foreach($orderData as $od){
                    $memberData = $this->member->get( $this->member->getCol(array("name","img")), array("mb_id"=>$od['userId']));
                    array_push($memberArr,$memberData);
                }
                $each['member'] = $memberArr;
    
                if(!empty($selfId) && $selfId==$tl['teamHost']){ //divide by self chk
                    array_push($selfArr, $each);
                }else{
                    array_push($arr, $each);
                }
            }
        }catch(Exception $e){
            $res = 'systemErr';
        }


        echo json_encode(array('res' => $res, 'public' => $arr, 'private' => $selfArr));
    }

    function set(){
        $selfId = $this->accessInfo['index'];
        $res = 'success';
        $putParams = $this->putData['params'];
        $teamId = $putParams['teamId'];

        $teamInfo = $this->teamOrder->get( $this->teamOrder->getCol(array("teamCnt", "teamMax")), array("od_team_id"=>$teamId));
        $teamCnt = (int)$teamInfo['teamCnt'] + 1;

        $teamStatus = $teamCnt >= (int)$teamInfo['teamMax'] ? 'go' : 'set';

        if($teamStatus == 'go'){
            $_REQUEST['teamId'] = $teamId;
            $_REQUEST['state'] = 2; //only for state on 2
            $orderData = $this->order->getList($this->order->getCol(array("odId")));
            foreach($orderData as $od){
                $updateArr = array();
                $updateArr['id'] = $od['odId'];
                $updateArr['state'] = 3;
                $updateOrder = $this->order->set($updateArr,$od['odId']);
            } 
        }

        $updateArr = array(
            'teamHost' => $selfId, //for data log
            'teamId' => $teamId,
            'teamStatus' => $teamStatus,
            'teamCnt' => $teamCnt,
        );

        $teamRes = $this->teamOrder->set($updateArr, $teamId);
        if($teamRes != '000') $res = 'updateErr';

        echo json_encode($res);
    }

    function retry(){
        $res = 'success';
        try{
            $putParams = $this->putData['params'];
            $teamId = $putParams['teamId'];

            $updateArr = array(
                'teamId' => $teamId,
                'teamTime' => _DATE_YMDHIS_TMR
            );
    
            $teamRes = $this->teamOrder->set($updateArr, $teamId);
            if($teamRes != '000') $res = 'updateErr';
        }catch(Exception $e){
            $res = 'systemError';
        }
        
        echo json_encode(array('res' => $res, 'timeLimit' => 86400));
    }

    function break(){
        $res = 'success';
        try{
            $selfId = $this->accessInfo['index'];
            $putParams = $this->putData['params'];
            $teamId = $putParams['teamId'];
            $updateArr = array(
                'teamHost' => $selfId, //for data log
                'teamId' => $teamId,
                'teamStatus' => 'break'
            );
            $teamRes = $this->teamOrder->set($updateArr, $teamId);
            if($teamRes != '000' && $teamRes != '001') $res = 'updateErr';
        }catch(Exception $e){
            $res = 'systemError';
        }
        echo json_encode($res);
    }

    function ableChk(){
        $id = $this->param['ident'];
        $teamInfo = $this->teamOrder->get( $this->teamOrder->getCol(array("teamCnt", "teamMax", "teamStatus")), array("od_team_id"=>$id));
        $teamStatus = (int)$teamInfo['teamCnt'] < (int)$teamInfo['teamMax'] && $teamInfo['teamStatus'] != "break" ? 'able' : 'unable';
        echo json_encode($teamStatus);
    }
}
