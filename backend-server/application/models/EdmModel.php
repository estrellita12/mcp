<?php
namespace application\models;

use \PDO;

class EdmModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_edm' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        $value = array();
        if( $mode=="add" ){
            $value['edm_reg_dt'] = _DATE_YMDHIS; // 메일 등록 일시
            $value['edm_stt'] = '1'; // 메일 발송 승인 여부
            $value['edm_send_yn'] = 'n'; // 메일 발송 여부
        }
        if( !empty($arr['state']) )     $value['edm_stt'] = $arr['state']; // 메일 발송 승인 여부
        if( !empty($arr['title']) )     $value['edm_title'] = $arr['title']; // 메일 제목
        if( !empty($arr['shop']) )      $value['pt_id'] = $arr['shop']; // 메일 타겟 가맹점
        if( !empty($arr['opt']) )       $value['edm_send_option'] = $arr['opt']; // 메일 발송 옵션
        if( !empty($arr['content']) )   $value['edm_content'] = $arr['content']; // 메일 내용
        if( !empty($arr['sendDate']) )  $value['edm_send_dt'] = implode(" ",$arr['sendDate']);  // 메일 발송 시간
        if( !empty($arr['memo']) )      $value['edm_adm_memo'] = $arr['memo'];  // 메일에 대한 관리자 메모
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "title" ) $this->getSearch("edm_title",$_REQUEST['kwd']);
        }

        if( !empty($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['state']) ) $this->getParameter("edm_stt",$_REQUEST['state']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("edm_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("edm_reg_dt",$_REQUEST['end'],"le");
            }
            else if( $_REQUEST['term'] == "sendDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("edm_send_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("edm_send_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by edm_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by edm_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'sendDate' ) $this->sql_order = " order by edm_send_dt {$_REQUEST['colby']} ";
        }
    }

/*
    function get( $id, $col='*'){
        $search = " and edm_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/

    function set($arr, $id){
        if( empty($id) ) $id = $arr['edm_id'];
        if( empty($id) ) return "002";
        $value = $this->getValue($arr,'set');
        $search = " and edm_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and edm_id = '{$id}' ";
        return $this->delete($search);
    }

    function testSend($arr){
        $mailer = new \application\models\Mailer();
        $res = $mailer->send($arr);
        if($res == "000"){
            $arr['resultCode'] = $res;
            $arr['resultMessage'] = "발송 성공";
            $log = new \application\models\EdmLogModel();
            $log->add($arr);
        }
        return $res;
    }

    function send($id){
        $mailer = new \application\models\Mailer();
        $edm = $this->get("*", array("edm_id"=>$id));
        $partner = new \application\models\PartnerModel();
        $pt = $partner->get("*",array("pt_id"=>$edm['pt_id']));
        $member = new \application\models\MemberModel();
        $search = " and pt_id='$edm[pt_id]' and mb_stt=2 and mb_email!='' and mb_emailser_yn='y' ";
        $mbList = $member->selectAll("mb_id,pt_id,mb_name,mb_cellphone,mb_email", $search);
        $flag = true;
        $cnt = 0;
        $success = 0;
        foreach($mbList as $mb){
            $arr = array(
                "edmId"=>$edm['edm_id'],
                "senderName"=>$pt['pt_name'],
                "senderEmail"=>$pt['shop_customer_service_email'],
                "userId"=>$mb['mb_id'],
                "userName"=>$mb['mb_name'],
                "userEmail"=>$mb['mb_email'],
                "title"=>$edm['edm_title'],
                "content"=> stripslashes( $edm['edm_content'] ) 
            );
            $arr['content'] = contentReplace(array("id"=>$mb['mb_id'],"name"=>$mb['mb_name']),$pt,$arr['content']);

            $res = $mailer->send($arr);
            if($res=="000"){ 
                $arr['resultCode'] = $res;
                $arr['resultMessage'] = "발송 성공";
                $success++;
            }else{
                $arr['resultCode'] = $res;
                $arr['resultMessage'] = "발송 실패";
            }
            $cnt++;
            $log = new \application\models\EdmLogModel();
            $log->add($arr);
        }
        $value['edm_send_res'] = "전체:".$cnt." | 성공:".$success;
        $value['edm_send_yn'] = "y";
        $search = " and edm_id = '{$id}' ";
        $this->update($value,$search);

        if($success==$cnt) return "000";
        else return "006";
    }

    function retry($logId){
        $mailer = new \application\models\Mailer();
        $log = new \application\models\EdmLogModel();
        $row = $log->get("*", array("edml_id"=>$logId));

        $arr = array(
            "edmId"=>$row['edm_id'],
            "senderName"=>$row['edml_sender_shop'],
            "senderEmail"=>$pt['edml_sender_email'],
            "userId"=>$row['mb_id'],
            "userName"=>$row['edml_receiver_name'],
            "userEmail"=>$row['edml_receiver_email'],
            "title"=>$row['edml_send_title'],
            "content"=> $row['edml_send_content'] 
        );
        $res = $mailer->send($arr);
        if($res=="000") $arr['result'] = "success";
        else $arr['result'] = "fail";
        if($res=="000"){ 
            $arr['resultCode'] = $res;
            $arr['resultMessage'] = "발송 성공";
        }else{
            $arr['resultCode'] = $res;
            $arr['resultMessage'] = "발송 실패";
        }

        $log->set($arr,$logId);
        return $res;
    }

}
?>
