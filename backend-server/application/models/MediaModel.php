<?php
namespace application\models;

use \PDO;

class MediaModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_media' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode == "add"){
            $value['media_reg_dt'] = _DATE_YMDHIS; // 등록 일시
            if( !empty($arr['orderby']) )       $value['media_orderby'] = 1;  
        }
        $value['media_update_dt'] =  _DATE_YMDHIS; // 수정 일시
        if( !empty($arr['shop']) )          $value['pt_id'] = $arr['shop']; // 가맹점
        if( !empty($arr['ctg']) )           $value['ctg_id'] = $arr['ctg']; // 카테고리 아이디
        if( !empty($arr['title']) )         $value['media_title'] = $arr['title']; // 기획전명
        if( !empty($arr['videoUrl']) )         $value['media_video_url'] = $arr['videoUrl'];
        if( !empty($arr['content']) )       $value['media_content'] = $arr['content'];  
        //if( !empty($arr['goodsList']) )     $value['media_goods_list'] = implode(",",$arr['goodsList']);  
        if( !empty($arr['goodsList']) )     $value['media_goods_list'] = $arr['goodsList'];  
        if( !empty($arr['showYn']) )          $value['media_show_yn'] = $arr['showYn'];  
        if( !empty($arr['type']) )        $value['media_type'] = $arr['type'];  
        if( !empty($arr['orderby']) )       $value['media_orderby'] = $arr['orderby'];  
        if( !empty($arr['reference']) )       $value['media_refer'] = $arr['reference'];  

        if( !empty($arr['beginDate']) ){
            if(is_array($arr['beginDate'])) $value['media_begin_dt'] = implode(" ",$arr['beginDate']);
            else $value['media_begin_dt'] = _BEGIN_DATE;
        }
        if( !empty($arr['endDate']) ){
            if(is_array($arr['endDate']))  $value['media_end_dt'] = implode(" ",$arr['endDate']);
            else $value['media_end_dt'] = _END_DATE;
        }

        if( !empty($arr['updateDate']) )    $value['media_update_dt'] = $arr['regDate'];  
        try{
            $upl = new \application\models\UploadImage(_ROOT._MEDIA);
            if( !empty($arr['listImgDel']) )    $upl->del($arr['oriListImgFile']);
            if( !empty($arr['topImgDel']) )    $upl->del($arr['oriTopImgFile']);
            if( !empty($_FILES['listImgFile']) && !empty($_FILES['listImgFile']['name'])  ){
                $filename = $upl->upload($_FILES['listImgFile']);
                if(!empty($filename)) $value['media_list_img'] = $filename;
            }
            if( !empty($_FILES['topImgFile']) && !empty($_FILES['topImgFile']['name'])  ){
                $filename = $upl->upload($_FILES['topImgFile']);
                if(!empty($filename)) $value['media_top_img'] = $filename;
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
            if( $_REQUEST['srch'] == "title" ) $this->getSearch("media_title",$_REQUEST['kwd']);
        }
        if( !empty($_REQUEST['shop']) )   $this->getParameter("pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['useCtg']) )   $this->getParameter("ctg_id",$_REQUEST['useCtg']);
        if( !empty($_REQUEST['ctg']) ) $this->getSearch("ctg_id",$_REQUEST['ctg'],"right");
        if( !empty($_REQUEST['showYn']) )   $this->getParameter("media_show_yn",$_REQUEST['showYn']);
        if( !empty($_REQUEST['type']) )   $this->getParameter("media_type",$_REQUEST['type']);
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("media_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("media_reg_dt",$_REQUEST['end'],"le");
            }else if( $_REQUEST['term'] == "showDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("media_begin_dt",$_REQUEST['beg'],"le");
                if( !empty($_REQUEST['end']) ) $this->getTerm("media_end_dt",$_REQUEST['end'],"ge");
            }else  if( $_REQUEST['term'] == "beginDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("media_begin_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("media_begin_dt",$_REQUEST['end'],"le");
            }else if( $_REQUEST['term'] == "endDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("media_end_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("media_end_dt",$_REQUEST['end'],"le");
            }
        }
        return $this->sql_where;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order ))   $this->sql_order = " order by media_orderby asc ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $search = " and media_id = '{$id}' ";
        return $this->select( $col, $search );
    }
*/

    function set($arr, $id, $type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";;

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and media_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr ){
        $value = $this->getValue($arr,'add');
        return $this->insert($value);
    }

    function remove( $id ){
        if(empty($id)) return "002";
        $search = " and media_id = '{$id}' ";
        return $this->delete($search);
    }

    function move($arr,$id){
        $value['media_orderby'] = $arr['orderby'];
        return $this->set($value,$id,"value");
    }
}
?>
