<?php
namespace application\models;

use \PDO;

class AdministratorModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_administrator' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            if( empty($arr['id']) ) return;
            $value['adm_id'] = $arr['id'];
            $value['adm_stt'] = "1"; 
            $value['adm_grade'] = "9";
            $value['adm_reg_dt'] = _DATE_YMDHIS; 
        }

        if( !empty($arr['name']) )      $value['adm_name'] = $arr['name']; 
        if( !empty($arr['grade']) )     $value['adm_grade'] = $arr['grade'];
        if( !empty($arr['state']) )     $value['adm_stt'] = $arr['state']; 
        if( !empty($arr['blockYn']) )     $value['adm_block_yn'] = $arr['blockYn']; 
        if( !empty($arr['passwd']) )    $value['adm_passwd'] = password($arr['passwd']);
        if( !empty($arr['email']) )     $value['adm_email'] = $arr['email']; 
        if( !empty($arr['cellphone']) ) $value['adm_cellphone'] = $arr['cellphone']; 
        if( !empty($arr['info']) )      $value['adm_info_other'] = $arr['info']; 
        if( !empty($arr['memo']) )      $value['adm_memo'] = $arr['memo'];
        if( !empty($arr['authMember']) )     $value['adm_auth_member'] = $arr['authMember'];
        if( !empty($arr['authPartner']) )     $value['adm_auth_partner'] = $arr['authPartner']; 
        if( !empty($arr['authSeller']) )     $value['adm_auth_seller'] = $arr['authSeller']; 
        if( !empty($arr['authGoods']) )     $value['adm_auth_goods'] = $arr['authGoods']; 
        if( !empty($arr['authDesign']) )     $value['adm_auth_design'] = $arr['authDesign'];
        if( !empty($arr['authOrder']) )     $value['adm_auth_order'] = $arr['authOrder'];
        if( !empty($arr['authDefault']) )     $value['adm_auth_default'] = $arr['authDefault'];
        if( !empty($arr['authBoard']) )     $value['adm_auth_board'] = $arr['authBoard'];
        if( !empty($arr['authSetting']) )     $value['adm_auth_setting'] = $arr['authSetting'];
        //$value['adm_last_login_dt'] = _DATE_YMDHIS;
        //$value['adm_last_login_ip'] = "";
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("adm_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("adm_reg_dt",$_REQUEST['end'],"le");
            }
            if( $_REQUEST['term'] == "lastLoginDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("adm_last_login_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("adm_last_login_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order ))  $this->sql_order = " order by adm_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by adm_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'lastLoginDate' ) $this->sql_order = " order by adm_last_login_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'loginCnt' ) $this->sql_order = " order by adm_login_cnt {$_REQUEST['colby']} ";
        }
    }

    public function set($arr, $id=''){
        if( empty($arr) ) return "002";
        if( empty($id) ) $id=$arr['id'];
        if( empty($id) ) return "002";
        $this->preValue = $this->get("*", array("adm_id"=>$id));
        $value = $this->getValue($arr,'set');

        $search = " and adm_id = '{$id}' ";
        $res = $this->update($value,$search);

        if($res=="000"){
            $exclude = array('adm_update_dt');
            $data = $this->addLog($id,$value,$exclude,"수정");
        }
        return $res;

    }

    public function add($arr){
        if( empty($arr) ) return "002";
        $value = $this->getValue($arr,'add');
        if( in_array($value['adm_id'],$GLOBALS['deny_id']) ) return "004";

        //if( !$this->overChk('adm_id', $value['adm_id']) ) return "003";
        $user = new \application\models\UserModel();
        if( !$user->overChk('user_id', $value['adm_id']) ) return "003";
        $res = $user->add(array("id"=>$value['adm_id'],"type"=>"Administrator"));
        if($res != "000") return "003";

        $res = $this->insert($value);
        if($res=="000"){
            $data = $this->addLog($value['adm_id'],array(),array(),"등록");
        }
        return $res;
    }

    public function remove($id){
        if( empty($id) ) return "002";
        if( $id == "admin" ) return "002";
        $search = " and adm_id = '{$id}' ";
        $res = $this->delete($search);
        if($res=="000"){
            $data = $this->addLog($id,array(),array(),"삭제");
        }
        return $res;
    }

    function login($id, $pw){
        $row = $this->get("*,count(adm_id) as cnt", array("adm_id"=>$id));
        if( password_verify($pw, $row['adm_passwd']) ){
            if( $row['cnt'] >= 1 && $row['adm_stt'] == 1 ){
                $value['adm_last_login_dt'] = _DATE_YMDHIS;
                $value['adm_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
                $value['adm_login_cnt'] = $row['adm_login_cnt']+1;
                $search = " and adm_id = '{$id}' ";
                $res = $this->update($value,$search);
                if($res=="000"){
                    set_session("user_id",$row['adm_id']);
                    set_session("user_name","관리자");
                    set_session("user_type",'administrator');
                    set_session("user_grade",$row['adm_grade']);
                    set_session("is_administrator","1");

                    foreach($row as $key=>$value){
                        if( strpos($key,"adm_auth_") !== false ){
                            $auth = str_replace("adm_auth_","",$key);
                            set_session(ucwords($auth),"y");
                        }
                    }

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
