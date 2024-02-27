<?php
namespace application\models;

use \PDO;

class BannerModel extends Model{
    var $colArr;

    function __construct( ){
        parent::__construct ( 'web_banner' );

        $this->colArr = array(
            "bannerId"=>"bn_id",
            "url"=>"bn_url",
            "target"=>"bn_url_target",
            "backgroundColor"=>"bn_bg_color",
            "position"=>"bn_position",
            "img"=>"concat('"._BANNER."',bn_img)",
            "mimg"=>"concat('"._BANNER."',bn_m_img)",
            "shop"=>"pt_id",
            "ctg"=>"ctg_id",
            "device"=>"bn_device",
            "showYn"=>"bn_show_yn",
            "orderby"=>"bn_orderby",
            "beginDate"=>"bn_begin_dt",
            "endDate"=>"bn_end_dt",
        );
    }

    function uploadImg($path, &$value){
        try{
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $upl = new \application\models\UploadImage($path);
            if( !empty($value['bn_img_del']) ){
                $upl->del($value['bn_img_del']);
                $value['bn_img'] = ''; 
            }

            if( !empty($value['bn_img']) && is_array($value['bn_img']) && !empty($value['bn_img']['tmp_name']) ){
                $upl->del($value['bn_ori_img']);
                $filename = $upl->upload($value['bn_img']);
                if ( !empty($filename) ) $value['bn_img'] = $filename; 
                else unset($value['bn_img']);
            }else{
                unset($value['bn_img']);
            }
            unset($value['bn_img_del']);
            unset($value['bn_ori_img']);
            return "000";
        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode == "add"){
            $value['bn_reg_dt'] =  _DATE_YMDHIS; // 등록일시
            if( !empty($arr['orderby']) )       $value['bn_orderby'] = 1; 
        }
        $value['bn_update_dt'] =  _DATE_YMDHIS; // 수정 일시
        if( !empty($arr['shop']) )          $value['pt_id'] = $arr['shop']; // 가맹점
        if( !empty($arr['ctg']) )           $value['ctg_id'] = $arr['ctg']; // 카테고리
        if( !empty($arr['position']) )      $value['bn_position'] = $arr['position']; //코드
        if( !empty($arr['url']) )           $value['bn_url'] = $arr['url']; //링크 주소
        if( !empty($arr['target']) )        $value['bn_target'] = $arr['target']; //타겟
        if( !empty($arr['backgroundColor']) )   $value['bn_bg_color'] = $arr['backgroundColor']; //배경 색상
        if( !empty($arr['device']) )        $value['bn_device'] = $arr['device']; //디바이스 
        if( !empty($arr['showYn']) )        $value['bn_show_yn'] = $arr['showYn']; //노출 유무
        if( !empty($arr['orderby']) )       $value['bn_orderby'] = $arr['orderby']; //순서
        if( !empty($arr['beginDate']) ){
            if(is_array($arr['beginDate'])) $value['bn_begin_dt'] = implode(" ",$arr['beginDate']); // 배너 출력 시작 일시
            else $value['bn_begin_dt'] = _BEGIN_DATE;
        }
        if( !empty($arr['endDate']) ){
            if(is_array($arr['endDate']))  $value['bn_end_dt'] = implode(" ",$arr['endDate']); // 배너 출력 종료 일시
            else $value['bn_end_dt'] = _END_DATE;
        }

        if( !empty($arr['imgFileDel']) )    $value['bn_img_del'] = $arr['imgFileDel'];
        if( !empty($arr['oriImgFile']) )    $value['bn_ori_img'] = $arr['oriImgFile'];
        if( !empty($arr['imgFile']) )       $value['bn_img'] = $arr['imgFile'];

        if( !empty($arr['mImgFileDel']) )   $value['bn_m_img_del'] = $arr['mImgFileDel'];
        if( !empty($arr['mOriImgFile']) )   $value['bn_m_ori_img'] = $arr['mOriImgFile'];
        if( !empty($arr['mImgFile']) )      $value['bn_m_img'] = $arr['mImgFile'];

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['shop']) ) $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['position']) ) $this->getParameter("bn_position",$_REQUEST['position']);
        if( !empty($_REQUEST['showYn']) ) $this->getParameter("bn_show_yn",$_REQUEST['showYn']);
        if( !empty($_REQUEST['device']) ) $this->getParameter("bn_device",$_REQUEST['device']);
        if( !empty($_REQUEST['useCtg']) )   $this->getParameter("ctg_id",$_REQUEST['useCtg']);
        if( !empty($_REQUEST['ctg']) ) $this->getSearch("ctg_id",$_REQUEST['ctg'],"right");
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "showDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("bn_begin_dt",$_REQUEST['beg'],"le");
                if( !empty($_REQUEST['end']) ) $this->getTerm("bn_end_dt",$_REQUEST['end'],"ge");
            }else  if( $_REQUEST['term'] == "beginDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("bn_begin_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("bn_begin_dt",$_REQUEST['end'],"le");
            }else if( $_REQUEST['term'] == "endDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("bn_end_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("bn_end_dt",$_REQUEST['end'],"le");
            }
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by pt_id desc , bn_orderby asc "; // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by bn_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'lastLoginDate' ) $this->sql_order = " order by mb_last_login_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'loginCnt' ) $this->sql_order = " order by mb_login_cnt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'point' ) $this->sql_order = " order by mb_point {$_REQUEST['colby']} ";
        }

        return $this->sql_order;
    }

/*
    function get($id, $col='*'){
        if(empty($id)) return "002";
        $sql_where = " and bn_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/

    function set($arr, $id='',$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002"; 

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $this->uploadImg(_ROOT._BANNER,$value);
        $search = " and bn_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;

        $this->uploadImg(_ROOT._BANNER,$value);

        return $this->insert($value);
    }

    function remove( $id ){
        if(empty($id)) return "002";
        $search = " and bn_id = '{$id}' ";
        return $this->delete($search);
    }

    function move($arr,$id){
        $value['bn_orderby'] = $arr['orderby'];
        return $this->set($value,$id,"value");
    }
}
?>
