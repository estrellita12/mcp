<?php
namespace application\models;

use \Exception;

class SellerModel extends Model{

    function __construct( ){
        parent::__construct ( 'web_seller' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            if( empty($arr['id']) ) return ;
            $value['sl_id'] = $arr['id']; // 공급사 이름
            $value['sl_stt'] = "1"; // 공급사 상태
            $value['sl_grade'] = "9"; // 공급사 등급
            $value['sl_pay_rate'] = "25"; // 공급사 수수료
            $value['sl_reg_dt'] = _DATE_YMDHIS; // 공급사 가입 일시
        }
        if( !empty($arr['name']) )          $value['sl_name'] = $arr['name']; // 공급사 이름
        if( !empty($arr['passwd']) )        $value['sl_passwd'] = password($arr['passwd']); // 비밀번호
        if( !empty($arr['grade']) )         $value['sl_grade'] = $arr['grade']; // 등급
        if( !empty($arr['state']) )         $value['sl_stt'] = $arr['state']; // 공급사 상태
        if( !empty($arr['rate']) )          $value['sl_pay_rate'] = $arr['rate']; // 공급사 수수료
        if( !empty($arr['bankName']) )      $value['sl_bank_name'] = $arr['bankName']; // 정산 은행 정보
        if( !empty($arr['bankAccount']) )      $value['sl_bank_account'] = $arr['bankAccount']; // 정산 은행 정보
        if( !empty($arr['bankHolder']) )      $value['sl_bank_holder'] = $arr['bankHolder']; // 정산 은행 정보
        if( !empty($arr['bankFile']) )      $value['sl_bank_file'] = $arr['bankFile']; // 정산 은행 통장 사본
        if( !empty($arr['manager']) )       $value['sl_manager'] = serialize($arr['manager']); // 담당자 이름
        if( !empty($arr['manager2']) )       $value['sl_manager2'] = serialize($arr['manager2']); // 담당자 이름
        if( !empty($arr['manager3']) )       $value['sl_manager3'] = serialize($arr['manager3']); // 담당자 이름
        if( !empty($arr['manager4']) )       $value['sl_manager4'] = serialize($arr['manager4']); // 담당자 이름
        if( !empty($arr['companyType']) )   $value['sl_company_type'] = $arr['companyType']; // 사업자 유형(1,2,3)
        if( !empty($arr['companyName']) )   $value['sl_company_name'] = $arr['companyName']; // 회사 이름
        if( !empty($arr['owner']) )         $value['sl_company_owner'] = $arr['owner']; // 대표자 이름
        if( !empty($arr['saupjaNo']) )      $value['sl_company_saupja_no'] = $arr['saupjaNo']; // 사업자 등록 번호
        if( !empty($arr['tolsinNo']) )      $value['sl_company_tolsin_no'] = $arr['tolsinNo'];
        if( !empty($arr['companyItem']) )   $value['sl_company_item'] = $arr['companyItem'];
        if( !empty($arr['companyService']) )    $value['sl_company_service'] = $arr['companyService'];
        if( !empty($arr['companyTel']) )    $value['sl_company_tel'] = $arr['companyTel']; // 회사 전화 번호
        if( !empty($arr['companyFax']) )    $value['sl_company_fax'] = $arr['companyFax']; // 회사 팩스 번호
        if( !empty($arr['companyEmail']) )  $value['sl_company_email'] = $arr['companyEmail']; // 회사 메일 주소
        if( !empty($arr['companyAddr']) )   $value['sl_company_addr'] = $arr['companyAddr']; // 회사 주소
        if( !empty($arr['deliveryInfo']) )        $value['sl_delivery_information'] = $arr['deliveryInfo']; // 배송/교환/반품 정책
        if( !empty($arr['deliveryType']) )        $value['sl_delivery_type'] = $arr['deliveryType']; // 배송비 부과 정책
        if( !empty($arr['deliveryCharge']) )      $value['sl_delivery_charge'] = $arr['deliveryCharge']; // 유료 배송비
        if( !empty($arr['deliveryFree']) )        $value['sl_delivery_free'] = $arr['deliveryFree']; // 무료 배송을 위한 최소 주문 금액
        if( !empty($arr['onlyPartnerYn']) ) {
            if($arr['onlyPartnerYn']=="y"){
                $value['sl_only_pt_yn'] = $arr['onlyPartnerYn']; 
                if( !empty($arr['onlyPartnerId']) )        $value['sl_only_pt_id'] = $arr['onlyPartnerId']; 
            }else{
                $value['sl_only_pt_yn'] = $arr['onlyPartnerYn']; 
                $value['sl_only_pt_id'] = ""; 
            }
        }

        try{
            $upl = new \application\models\UploadFile(_ROOT._FILE);
            if( !empty($_FILES['saupjaFile']) && !empty($_FILES['saupjaFile']['name'])  ){
                $filename = $upl->upload($_FILES['saupjaFile']);
                if(!empty($filename)) $value['sl_company_saupja_file'] = $filename;
            }
            if( !empty($_FILES['tolsinFile']) && !empty($_FILES['tolsinFile']['name'])  ){
                $filename = $upl->upload($_FILES['tolsinFile']);
                if(!empty($filename)) $value['sl_company_tolsin_file'] = $filename;
            }
        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("sl_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" ) $this->getSearch("sl_name",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['state']) ) $this->getParameter("sl_stt",$_REQUEST['state']);
        if( !empty($_REQUEST['grade']) && $_REQUEST['grade'] != "all")  $this->getParameter("sl_grade",$_REQUEST['grade']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("sl_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("sl_reg_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "appDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("sl_app_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("sl_app_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "expDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("sl_exp_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("sl_exp_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by sl_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            else if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by sl_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'appDate' ) $this->sql_order = " order by sl_app_dt {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

    function getNameList($partner="a", $state="y"){
        $search = array();
        if( $partner =="y" || $partner=="n" ){
            $search['sl_only_pt_yn'] = $sso_yn;
        }
        if( $state == "y" ){
            $search['sl_stt'] = "2";
        }else{
            $search['sl_stt_then_ge'] = "2";
        }
        $search['col'] = "sl_app_dt";
        $search['colby'] = "asc";
        $rowAll = $this->get("sl_id,sl_name",$search,true);
        $sl_li = array();
        foreach($rowAll as $row){
            $sl_li[$row['sl_id']] = $row['sl_name'];
        }
        return $sl_li;
    }   

    function set($arr,$id='',$type="arr"){
        if(empty($arr)) return "002";
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $this->preValue = $this->get("*", array("sl_id"=>$id));

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and sl_id = '{$id}' ";
        $res = $this->update($value,$search);

        if($res=="000"){
            $exclude = array('sl_idx,sl_passwd');
            $data = $this->addLog($id,$value,$exclude,"수정");
        }
        return $res;
    }


    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $user = new \application\models\UserModel();
        if( !$user->overChk('user_id', $value['sl_id']) ) return "003";
        $res = $user->add(array("id"=>$value['sl_id'],"type"=>"Seller"));
        if($res != "000") return "003";

        $res = $this->insert($value);
        if( $res == "000" ){
            $data = $this->addLog($value['sl_id'],array(),array(),"등록");
        }
        return $res;
    }

    function remove($id){
        if( empty($id) ) return "002";
        $search = " and sl_id = '{$id}' ";
        $res = $this->delete($search);
        if( $res == "000" ){
            $data = $this->addLog($id,array(),array(),"삭제");
        }
        return $res;
    }

    function expire($id){
        if( empty($id) ) return "002";
        $arr['sl_stt'] = '3';
        $arr['sl_exp_dt'] = _DATE_YMDHIS;
        $res = $this->set($arr,$id,"value");
        if($res=="000"){
            $goods = new \application\models\GoodsModel();
            //$goods->execute("update ".$goods->tb_nm." SET gs_stt = 4 where sl_id='{$id}'");
            $goods->delete(" and sl_id='{$id}'");
        }
        return $res;
    }

    function approval($id){
        if( empty($id) ) return "002";
        $arr['sl_stt'] = '2';
        $arr['sl_app_dt'] = _DATE_YMDHIS;
        return $this->set($arr,$id,"value");
    }
    function login($id, $pw){
        $row = $this->get("sl_id,sl_name,sl_stt,sl_passwd,sl_grade,sl_login_cnt,count(sl_id) as cnt", array("sl_id"=>$id));
        if( password_verify($pw, $row['sl_passwd']) ){
            if( $row['cnt'] >= 1 && $row['sl_stt'] == 2 ){
                $value['sl_last_login_dt'] = _DATE_YMDHIS;
                $value['sl_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['sl_login_cnt'] = $row['sl_login_cnt']+1;
                $search = " and sl_id = '{$id}' ";
                $res = $this->update($value,$search);
                if($res=="000"){
                    set_session("is_seller","1");
                    set_session("user_id",$row['sl_id']);
                    set_session("user_name",$row['sl_name']);
                    set_session("user_type",'seller');
                    set_session("user_grade",$row['sl_grade']);
                    return "000";
                }else{
                    return "001";
                }
            }
        }else{
            return false;
        }
    }

}
?>
