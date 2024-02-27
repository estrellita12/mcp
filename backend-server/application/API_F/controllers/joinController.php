<?php
namespace application\API_F\controllers;

class joinController extends Controller 
{
    function init(){ 
        $this->temp();
        $this->member = new \application\models\MemberModel();
        $this->col = "*";
        $this->timeSet = 300;
        $this->jwt = new \application\models\JWT();
    }

    function makeDigit(){ //DUPLICATE CHK for phone number or email & PUBLISH 6 digit
        $template = new \application\models\TemplateModel();
        $kwdData = !empty($_REQUEST['kwd']) ? $_REQUEST['kwd'] : null;
        $resultArray = array();

        $certNum = "";

        if(!empty($_REQUEST['srch'])){
            $_REQUEST['shop'] = $this->shopId;
            $memberChk = $this->member->getList();
            $resultArray['memberId'] = count($memberChk) ? $memberChk[0]['mb_id'] : null;
        }
        
        //phone
        if(empty($_REQUEST['type']) || $_REQUEST['type'] == 'phone'){
            $randomSix = (string)sprintf('%06d',rand(000000,999999));
            $res = $template->send(0,13,array("certNum" => $randomSix, "userCellphone" => $kwdData));
            if($res=="000"){
                $certNum = $randomSix;
            }else{
                echo json_encode($res);
                exit;
            }            
        }

        //email 
        if(empty($resultArray['memberId']) && !empty($_REQUEST['type']) && $_REQUEST['type'] == 'mail'){
            try{
                if(!empty($this->accessInfo)){
                    $userId = $this->accessInfo['index'];
                }else{
                    $_REQUEST['srch'] = 'email';
                    $_REQUEST['kwd'] = $kwdData;
                    $emailChk = $this->member->getList($this->member->getCol(array('id')));
                    $resultArray['member'] = $emailChk;
                    if(!count($emailChk)){
                        echo json_encode('identifyErr');                
                        exit;
                    }else{
                        $userId = $emailChk[0]['id'];
                        $resultArray['tempMember'] = $this->jwt->hashing(array("userId" => $userId, "exp" => time()+$this->timeSet));
                    }
                }

                $email = $kwdData;
                $randomSix = (string)sprintf('%06d',rand(000000,999999));
                $res = $template->send($userId,8,array("certNum" => $randomSix, "userEmail" => $email));
                $kwdData = null;
                if($res=="000"){
                    $certNum = $randomSix;
                }else{
                    echo json_encode($res);
                    exit;
                }
            }catch(Exception $e){
                echo json_encode("System Error");
                exit;
            }
        }
        $resultArray['c'] = $this->jwt->hashing(array("cNumber" => $certNum, "exp" => time()+$this->timeSet, "kwdData" => $kwdData));
        $resultArray['exp'] = $this->timeSet;
        echo json_encode($resultArray);
    }

    function digitChk(){ //MATCH hashed token data with data
        $cData = $this->param['ident'];
        $certNumber = $_REQUEST['data'];
        $dehashedData = $this->jwt->dehashing($cData);
        
        $result = array();
        $result["res"] = 'MATCH';
        if($dehashedData == 'EXPIRED'){
            $result["res"] = 'EXPIRED';
        }else if($dehashedData['cNumber'] != $certNumber && $certNumber != "999999" && $certNumber != "000000"/* superpass for test */){
            $result["res"] = 'MISMATCH';
        }
        $result['kwdData'] = !empty($dehashedData['kwdData']) ? $dehashedData['kwdData'] : null;
        echo json_encode($result);
    }

    function add(){
        $data = $this->postData['params'];
        $uniqueId = uniqid();
        $uniquePw = uniqid();
        $idChk = $this->member->get("*", array("mb_id"=>$uniqueId));

        if(!empty($data['snsid2'])){
            $dehashedId = $this->jwt->dehashing($data['snsid2']);
            $data['snsid2'] = base64_decode($dehashedId['sub']);
            $data['appleRefresh'] = base64_decode($dehashedId['refresh']);            
        }

        if(empty($idChk)){
            $data['id'] = $uniqueId;
            $data['passwd'] = $uniquePw;
            $data['shop'] = $this->shopId;
            $result = array('res' => 'FAILED');
            if($this->member->add($data) == '000'){
                $result['res'] = 'SUCCESS';
                $result['id'] = $data['id'];
            } 
            echo json_encode($result);
        }
    }
}
