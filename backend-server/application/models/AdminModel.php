<?php
namespace application\models;

use \PDO;

class AdminModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_admin' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            if( empty($arr['id']) ) return;
            $value['adm_id'] = $arr['id']; // 관리자 아이디
            $value['adm_stt'] = "1";  // 상태
            $value['adm_reg_dt'] = _DATE_YMDHIS; // 가입일시
        }

        if( !empty($arr['name']) )      $value['adm_name'] = $arr['name'];  // 관리자 이름
        if( !empty($arr['grade']) )     $value['adm_grade'] = $arr['grade'];    // 등급
        if( !empty($arr['passwd']) )    $value['adm_passwd'] = $arr['passwd'];  // 비밀번호
        if( !empty($arr['email']) )     $value['adm_email'] = $arr['email']; 
        if( !empty($arr['cellphone']) ) $value['adm_cellphone'] = $arr['cellphone']; 
        if( !empty($arr['info']) )      $value['adm_info_other'] = $arr['info']; 
        if( !empty($arr['memo']) )      $value['adm_memo'] = $arr['memo'];  // 메모
        if( !empty($arr['auth1']) )     $value['adm_auth_1'] = $arr['auth1'];  // 권한
        if( !empty($arr['auth2']) )     $value['adm_auth_2'] = $arr['auth2'];  // 권한
        if( !empty($arr['auth3']) )     $value['adm_auth_3'] = $arr['auth3'];  // 권한
        if( !empty($arr['auth4']) )     $value['adm_auth_4'] = $arr['auth4'];  // 권한
        if( !empty($arr['auth5']) )     $value['adm_auth_5'] = $arr['auth5'];  // 권한
        if( !empty($arr['auth6']) )     $value['adm_auth_6'] = $arr['auth6'];  // 권한
        if( !empty($arr['auth7']) )     $value['adm_auth_7'] = $arr['auth7'];  // 권한
        if( !empty($arr['auth8']) )     $value['adm_auth_8'] = $arr['auth8'];  // 권한
        if( !empty($arr['auth9']) )     $value['adm_auth_9'] = $arr['auth9'];  // 권한
        //$value['adm_last_login_dt'] =  _DATE_YMDHIS;
        //$value['adm_last_login_ip'] =  ip정보;
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['grade']) && $_REQUEST['grade'] != "all")  $this->sql_where .= " and adm_grade = '{$_REQUEST['grade']}' ";
        return $this->sql_where;
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
        return $this->sql_order;
    }
/*
    function get($id, $col='*'){
        $sql_where = " and adm_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr, $id=''){
        if( empty($id) ) $id=$arr['id'];
        if( empty($id) ) return "002";
        $value = $this->getValue($arr,'set');
        $search = " and adm_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        if( in_array($value['adm_id'],$GLOBALS['deny_id']) ) return "004";
        if( !$this->overChk('adm_id', $value['adm_id']) ) return false;
        return $this->insert($value);
    }

    function login($id, $pw){
        $sql_where = " and adm_id = '{$id}' and adm_passwd=password('{$pw}') ";
        $row = $this->select( "count(adm_id) as cnt,adm_id,adm_passwd,adm_grade,adm_stt,adm_login_cnt", $sql_where );
        if( $row['cnt'] >= 1 && $row['adm_stt'] == 1 ){
            $value['adm_last_login_dt'] = _DATE_YMDHIS;
            $value['adm_last_login_ip'] = $_SERVER['REMOTE_ADDR'];
            $value['adm_login_cnt'] = $row['adm_login_cnt']+1;
            $search = " and adm_id = '{$id}' ";
            $res = $this->update($value,$search);
            if($res=="000"){
                set_session("is_admin","1");
                set_session("admID",$row['adm_id']);
                set_session("admGrade",$row['adm_grade']);
                return "000";
            }else{
                return "001";
            }
        }else{
            return false;
        }
    }
}
?>
