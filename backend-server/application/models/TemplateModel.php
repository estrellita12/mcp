<?php
namespace application\models;

use \Exception;

class TemplateModel extends Model{

    function __construct( ){
        parent::__construct ( 'web_template' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        $value = array();
        if( $mode=="add" ){
            if( !empty($arr['type']) )   $value['tp_type'] = $arr['type']; 
            $value['tp_reg_dt'] = _DATE_YMDHIS; // 템플릿 등록 일시
        }
        if( !empty($arr['title']) )     $value['tp_title'] = $arr['title']; // 템플릿 제목
        if( !empty($arr['content']) )   $value['tp_content'] = $arr['content']; // 템플릿 내용
        if( !empty($arr['replaceMsg']) )   $value['tp_replace_msg'] = $arr['replaceMsg'];
        if( !empty($arr['code']) )   $value['tp_code'] = $arr['code'];
        if( !empty($arr['memo']) )      $value['tp_adm_memo'] = $arr['memo'];  // 템플릿에 대한 관리자 메모
        $value['tp_update_dt'] = _DATE_YMDHIS; // 템플릿 수정 일시
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "title" ) $this->getSearch("tp_title",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['type']) ) $this->getParameter("tp_type",$_REQUEST['type']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("tp_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("tp_reg_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "updateDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("tp_update_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("tp_update_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by tp_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by tp_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'sendDate' ) $this->sql_order = " order by tp_update_dt {$_REQUEST['colby']} ";
        }
    }

    function set($arr, $id, $type="arr"){
        if( empty($arr) ) return "001";
        if( empty($id) ) $id = $arr['tpId'];
        if( empty($id) ) return "002";

        $this->preValue = $this->get("*",array("tp_id"=>$id));
        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and tp_id = '{$id}' ";
        $res = $this->update($value,$search);
        if($res=="000"){
            $exclude = array('tp_update_dt');
            $this->addLog($id,$value,$exclude,"수정");
        }

        return $res;
    }

    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $res = $this->insert($value);
        if($res=="000"){
            $this->addLog($this->pdo->lastInsertId(),array(),array(),"등록");
        }
        return $res;
    }

    function sendMail($userId, $tpId, $other=array()){
        return $this->send($userId,$tpId,$other);
    }

    function send($userId, $tpId, $other=array()){
        $tp = $this->get("*", array("tp_id"=>$tpId));

        $senderName="";$senderEmail="";$senderTel="";
        $userName="";$userEmail="";$userCellphone="";
        $shopUrl = ""; $shopLogo="";

        if( !empty($userId) ){
            $typeModel = new \application\models\UserModel();
            $type = $typeModel->get("user_type",array("user_id"=>$userId));
            switch($type['user_type']){
            case "Administrator":case "administrator":
                $userModel = new \application\models\AdministratorModel();
                $user = $userModel->get("adm_id,adm_name,adm_email,adm_cellphone", array("adm_id"=>$userId));
                $userName = $user['adm_name'];
                $userEmail = $user['adm_email'];
                $userCellphone = $user['adm_cellphone'];
                $shopModel = new \application\models\DefaultModel();
                $shop = $shopModel->get("pt_name,shop_customer_service_email,shop_customer_service_tel,shop_url,shop_pc_logo", array("pt_id"=>"admin"));
                $senderName=$shop['pt_name'];
                $senderEmail=$shop['shop_customer_service_email'];
                $senderTel=$shop['shop_customer_service_tel'];
                $shopUrl=$shop['shop_url'];
                $shopLogo=$shop['shop_pc_logo'];
                break;
            case "Member":case "member":
                $userModel = new \application\models\MemberModel();
                $user = $userModel->get("mb_id,pt_id,mb_name,mb_cellphone,mb_email", array("mb_id"=>$userId));
                if( empty($user) ) break;
                $userName = $user['mb_name'];
                $userEmail = $user['mb_email'];
                $userCellphone = $user['mb_cellphone'];
                $shopModel = new \application\models\PartnerModel();
                $shop = $shopModel->get("pt_name,shop_customer_service_email,shop_customer_service_tel,shop_url,shop_pc_logo", array("pt_id"=>$user['pt_id']));
                $senderName=$shop['pt_name'];
                $senderEmail=$shop['shop_customer_service_email'];
                $senderTel=$shop['shop_customer_service_tel'];
                $shopUrl=$shop['shop_url'];
                $shopLogo=$shop['shop_pc_logo'];
                break;
            case "Seller":case "seller":
                $userModel = new \application\models\SellerModel();
                $user = $userModel->get("sl_id,sl_name,sl_manager", array("sl_id"=>$userId));
                if( empty($user) ) return;
                $user['sl_manager'] = unserialize($user['sl_manager']);
                $userName = $user['sl_name'];
                $userEmail = $user['sl_manager'][2];
                $userCellphone = $user['sl_manager'][1];
                $shopModel = new \application\models\DefaultModel();
                $shop = $shopModel->get("pt_name,shop_customer_service_email,shop_customer_service_tel,shop_url,shop_pc_logo", array("pt_id"=>"admin"));
                $senderName=$shop['pt_name'];
                $senderEmail=$shop['shop_customer_service_email'];
                $senderTel=$shop['shop_customer_service_tel'];
                $shopUrl=$shop['shop_url'];
                $shopLogo=$shop['shop_pc_logo'];
                break;
            case "Partner":case "partner":
                $userModel = new \application\models\PartnerModel();
                $user = $userModel->get("pt_id,pt_name,pt_manager", array("pt_id"=>$userId));
                if( empty($user) ) return;
                $user['sl_manager'] = unserialize($user['pt_manager']);
                $userName = $user['pt_name'];
                $userEmail = $user['pt_manager'][2];
                $userCellphone = $user['pt_manager'][1];
                $shopModel = new \application\models\DefaultModel();
                $shop = $shopModel->get("pt_name,shop_customer_service_email,shop_customer_service_tel,shop_url,shop_pc_logo", array("pt_id"=>"admin"));
                $senderName=$shop['pt_name'];
                $senderEmail=$shop['shop_customer_service_email'];
                $senderTel=$shop['shop_customer_service_tel'];
                $shopUrl=$shop['shop_url'];
                $shopLogo=$shop['shop_pc_logo'];
                break;
            }
        }
        $arr = array(
            "tpId"=>$tp['tp_id'],
            "senderName"=>$senderName,
            "senderEmail"=>$senderEmail,
            "senderTel"=>$senderTel,
            "userId"=>$userId,
            "userName"=>$userName,
            "userEmail"=>$userEmail,
            "userCellphone"=>$userCellphone,
            "shopUrl"=>$shopUrl,
            "shopLogo"=>$shopLogo,
            "title"=>$tp['tp_title'],
            "content"=> stripslashes($tp['tp_content']),
            "replaceMsg"=> stripslashes($tp['tp_replace_msg']),
            "code"=>$tp['tp_code'],
        );
        if( !empty($other['userEmail']) ) $arr['userEmail'] = $other['userEmail'];
        if( !empty($other['userCellphone']) ) $arr['userCellphone'] = $other['userCellphone'];
        if( !empty($other['certNum']) ) $arr['certNum'] = $other['certNum'];
        if( !empty($other['goodsName']) ) $arr['goodsName'] = $other['goodsName'];
        $arr['content'] = contentReplace($arr);
        $arr['replaceMsg'] = contentReplace($arr);

        if($tp['tp_type']=="1"){
            $mailer = new \application\models\Mailer();
            $res = $mailer->send($arr);
        }else{
            $sms = new \application\models\SMS();
            $res = $sms->send($arr);
        }

        $arr['resultCode'] = $res['code'];
        $arr['resultMessage'] = $res['message'];
        $log = new \application\models\TemplateSendLogModel();
        $log->add($arr);
        return $res['code'];
    }

}
?>
