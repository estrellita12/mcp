<?php
namespace application\models;

use \PDO;
use \Exception;

class GoodsReviewModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_goods_review' );
        $this->colArr = array(
            "reviewId"=>"gs_rv_id",
            "goodsId"=>"gs_id",
            "odId"=>"od_id",
            "goodsName"=>"gs_rv_name",
            "goodsOptName"=>"gs_rv_opt_name",
            "reviewCnt"=>"gs_rv_cnt",
            "userId"=>"mb_id",
            "rating"=>"gs_rv_star_rating",
            "rating2"=>"gs_rv_star_rating2",
            "ratingAvg"=>"gs_rv_star_average",
            "reviewImg"=>"gs_rv_img",
            "reviewImg2"=>"gs_rv_img2",
            "reviewImg3"=>"gs_rv_img3",
            "content"=>"gs_rv_content",
            "likeCnt"=>"gs_rv_like_cnt",
            "seller"=>"gs_rv_sl_id",
            "partner"=>"gs_rv_pt_id",
            "regdate"=>"gs_rv_reg_dt",
            "reply"=>"gs_rv_reply",
            "replyRegdate"=>"gs_rv_reply_dt",
            "hiddenCheck"=>"gs_rv_hidden_yn",
        );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){
            $value['gs_rv_reg_dt'] = _DATE_YMDHIS; // 등록일시
        }

        if( !empty($arr['goodsId']) )       $value['gs_id'] = $arr['goodsId']; 
        if( !empty($arr['odId']) )          $value['od_id'] = $arr['odId']; 
        if( !empty($arr['goodsName']) )     $value['gs_rv_name'] = $arr['goodsName']; 
        if( !empty($arr['goodsOptName']) )  $value['gs_rv_opt_name'] = $arr['goodsOptName']; 
        if( !empty($arr['userId']) )        $value['mb_id'] = $arr['userId']; 
        if( !empty($arr['rating']) )        $value['gs_rv_star_rating'] = $arr['rating']; 
        if( !empty($arr['rating2']) )        $value['gs_rv_star_rating2'] = $arr['rating2']; 
        if( !empty($arr['ratingAvg']) )        $value['gs_rv_star_average'] = $arr['ratingAvg']; 
        if( !empty($arr['reviewImg']) )        $value['gs_rv_img'] = $arr['reviewImg']; 
        if( !empty($arr['reviewImg2']) )        $value['gs_rv_img2'] = $arr['reviewImg2']; 
        if( !empty($arr['reviewImg3']) )        $value['gs_rv_img3'] = $arr['reviewImg3']; 
        if( !empty($arr['content']) )       $value['gs_rv_content'] = $arr['content']; 
        if( !empty($arr['likeCnt']) )        $value['gs_rv_like_cnt'] = $arr['likeCnt']; 
        if( !empty($arr['seller']) )        $value['gs_rv_sl_id'] = $arr['seller']; 
        if( !empty($arr['partner']) )        $value['gs_rv_pt_id'] = $arr['partner']; 
        if( !empty($arr['shop']) )        $value['gs_rv_pt_id'] = $arr['shop']; 
        if( !empty($arr['reviewCnt']) )        $value['gs_rv_cnt'] = $arr['reviewCnt']; 
        //if( !empty($arr['reply']) )      $value['gs_rv_reply'] = $arr['reply']; 
        //$value['gs_rv_reply_dt'] = _DATE_YMDHIS;
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['goodsId']) )   $this->getParameter("gs_id",$_REQUEST['goodsId']);
        if( !empty($_REQUEST['odId']) )   $this->getParameter("od_id",$_REQUEST['odId']);
        if( !empty($_REQUEST['id']) )   $this->getParameter("gs_rv_id",$_REQUEST['id']);
        if( !empty($_REQUEST['userId']) )   $this->getParameter("mb_id",$_REQUEST['userId']);
        if( !empty($_REQUEST['reviewCnt']) )   $this->getParameter("gs_rv_cnt",$_REQUEST['reviewCnt']);
        if( !empty($_REQUEST['seller']) )   $this->getParameter("gs_rv_sl_id",$_REQUEST['seller']);
        if( !empty($_REQUEST['shop']) )   $this->getParameter("gs_rv_pt_id",$_REQUEST['shop']);
        if( !empty($_REQUEST['reviewTerm']) ){
            if( $_REQUEST['reviewTerm'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("gs_rv_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("gs_rv_reg_dt",$_REQUEST['end'],"le");
            }
        }        
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order) ) $this->sql_order = " order by gs_rv_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by gs_rv_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'star' ) $this->sql_order = " order by gs_rv_star_rating {$_REQUEST['colby']} ";
        }
    }

/*
    function get($id, $col='*'){
        if( empty($id) ) return "002";
        $sql_where = " and gs_rv_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/

    function getGoodsInfo($goodsId, $pt, $col='gs_rv_star_average'){
        if( empty($goodsId) || empty($col)) return "002";
        $col = "SUM($col) AS sum, COUNT($col) AS cnt, AVG($col) AS avg";
        $sql_where = " and gs_id = '{$goodsId}' and gs_rv_pt_id = '{$pt}' ";
        return $this->select( $col, $sql_where );
    }    

    function getSellerInfo($sellerId, $pt, $col='gs_rv_star_rating'){
        if( empty($sellerId) || empty($col)) return "002";
        $col = "SUM($col) AS sum, COUNT($col) AS cnt, AVG($col) AS avg";
        $sql_where = " and gs_rv_sl_id = '{$sellerId}' and gs_rv_pt_id = '{$pt}' ";
        return $this->select( $col, $sql_where );
    }        

    function set($arr,$id,$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        $preValue = $this->get("*", array("gs_rv_id"=>$id));

        if($type == "arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        
        $search = " and gs_rv_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type == "arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        $res = $this->insert($value);
        if($res == "000"){
            $orderModel = new \application\models\OrderModel();
            $orderModel->set(array("od_review_yn"=>"y"), $value['od_id'],"value");
        }
        return $res;
    }

    function reply($arr,$id){
        if( empty($arr['reply']) ) return "002";
        $value['gs_rv_reply'] = $arr['reply']; 
        $value['gs_rv_reply_dt'] = _DATE_YMDHIS;
        return $this->set($value,$id,"value");
    }

    function hidden($id){
        $value['gs_rv_hidden_yn'] = 'y';
        return $this->set($value,$id,"value");
    }

    function remove($id){
        if(empty($id)) return"002";
        $row = $this->get("od_id",array("gs_rv_id"=>$id));
        $search = " and gs_rv_id = '{$id}' ";
        $res = $this->delete($search);
        if($res == "000"){
            //$orderModel = new \application\models\OrderModel();
            //$orderModel->set(array("od_review_yn"=>"n"), $row['od_id'],"value");
        }
        return $res;
    }

    function removeMember($mb_id){
        if(empty($mb_id)) return"002";
        $search = " and mb_id = '{$mb_id}' ";
        $res = $this->delete($search);
        return $res;
    }            
}
?>
