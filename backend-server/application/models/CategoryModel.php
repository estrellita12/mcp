<?php
namespace application\models;

use \Exception;

class CategoryModel extends Model{
    public $colArr;

    function __construct( ){
        parent::__construct ( 'web_category' );
        $this->colArr = array(
            "ctgId"=>"ctg_id",
            "title"=>"ctg_title",
            "upper"=>"ctg_upper_id",
            "topBanner"=>"if(ctg_top_banner!='',concat('"._BANNER."',ctg_top_banner),'')",
            "mTopBanner"=>"if(ctg_m_top_banner!='',concat('"._BANNER."',ctg_m_top_banner),'')",
            "useYn"=>"ctg_use_yn",
        );
 
    }

    function uploadImg($path, &$value){
        try{
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $upl = new \application\models\UploadImage($path);
            if( !empty($value['ctg_top_banner_del']) ){
                $upl->del($value['ctg_top_banner_del']);
                $value['ctg_top_banner'] = ''; 
            }

            if( is_array($value['ctg_top_banner']) && !empty($value['ctg_top_banner']['tmp_name']) ){
                $upl->del($value['ctg_top_banner_ori']);
                $filename = $upl->upload($value['ctg_top_banner']);
                if ( !empty($filename) ) $value['ctg_top_banner'] = $filename; 
                else unset($value['ctg_top_banner']);
            }else{
                unset($value['ctg_top_banner']);
            }
            unset($value['ctg_top_banner_del']);
            unset($value['ctg_top_banner_ori']);
            return "000";
        }catch(Exception $e){
            debug_log( static::class,"005",$e);
            return "005";
        }
    }



    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){
            if( empty($arr['id']) ) return;
            $value['ctg_id'] = $arr['id'];
        }

        if( !empty($arr['upper']) )     $value['ctg_upper_id'] = $arr['upper']; 
        if( !empty($arr['title']) )     $value['ctg_title'] = $arr['title']; 
        if( !empty($arr['topBanner']) )     $value['ctg_top_banner'] = $arr['topBanner']; 
        if( !empty($arr['mTopBanner']) )    $value['ctg_m_top_banner'] = $arr['mTopBanner']; 
        if( !empty($arr['orderby']) )   $value['ctg_orderby'] = $arr['orderby']; 
        if( !empty($arr['useYn']) )     $value['ctg_use_yn'] = $arr['useYn'];
        if( !empty($arr['topBanner']) )     $value['ctg_top_banner'] = $arr['topBanner'];
        if( !empty($arr['topBannerDel']) )     $value['ctg_top_banner_del'] = $arr['topBannerDel'];
        if( !empty($arr['topBannerOri']) )     $value['ctg_top_banner_ori'] = $arr['topBannerOri'];
        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['ctgId']) ) $this->getParameter("ctg_id",$_REQUEST['ctgId']);
        if( !empty($_REQUEST['upper']) ) $this->getParameter("ctg_upper_id",$_REQUEST['upper']);
        if( !empty($_REQUEST['useYn']) ) $this->getParameter("ctg_use_yn",$_REQUEST['useYn']);
        if( !empty($_REQUEST['depth']) ){
            $this->sql_where .= " and length(ctg_id) = :depth ";
            $this->parameter["depth"] = $_REQUEST['depth'];
        }
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order ))   $this->sql_order = " order by ctg_orderby asc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'id' ) $this->sql_order = " order by ctg_id {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }

/*
    function get($id , $col='*'){
        if(empty($id)) return "002";
        $sql_where = " and ctg_id = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/

    function set($arr, $id, $type="arr" ){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;
        $search = " and ctg_id = '{$id}' ";
        $this->uploadImg(_ROOT._BANNER,$value);
        return $this->update($value,$search);
    }

    function add($arr, $type="arr"){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        if( !$this->overChk('ctg_id', $value['ctg_id']) ) return "003";
        $this->uploadImg(_ROOT._BANNER,$value);
        return $this->insert($value);
    }

    function remove( $id ){
        if(empty($id)) return "002";
        $search = " and ctg_id = '{$id}' ";
        return $this->delete($search);
    }

    function create( $upper='' ){
        $row = $this->select("MAX(ctg_id) as code, MAX(ctg_orderby) as orderby "," and ctg_upper_id='{$upper}' ");       
        if( empty($row) || empty($row['code']) ){
            $code = $upper."001";
            $orderby = 1;
        }else{
            $code  = $row['code'] + 1;
            $orderby = $row['orderby'] + 1;
            $length = strlen($upper) + 3;
            if(strlen($code) < $length) $code = "0".$code;
            if(strlen($code) < $length) $code = "0".$code;
            if(strlen($code) < $length) $code = "0".$code;
        }
        $value['ctg_id'] = $code;
        $value['ctg_upper_id'] = $upper;
        $value['ctg_title'] = '새로운카테고리';
        $value['ctg_orderby'] = $orderby;
        $value['ctg_use_yn'] = 'n';
        return $this->add($value, "value");
    }

    function getCode($depth, $title){
        return $this->get("*",array("ctg_title"=>$title,"ctg_id_length_eq"=>($depth*3) ));
    }

    /*
    function getNameList($depth='2'){
        $arr = array();
        $length = $depth * 3;
        $search = " and length(ctg_id) = $length ";
        $row = $this->selectAll("ctg_id,ctg_title", $search, "order by ctg_orderby");
        for($i=0;$i<count($row);$i++ ){
            $arr[$row[$i]['ctg_id']] = $row[$i]['ctg_title'];
        }
        return $arr;
    }
    */

    function getUpperList($ctgId){
        $depth = strlen($ctgId)/3;
        $arr = array();
        for($i=1;$i<=$depth;$i++){
            $cutId = substr($ctgId,0,($i*3));
            $row = $this->get("ctg_title", array("ctg_id"=>$cutId));
            if( empty($row) ) break;
            array_push($arr , array('id'=>$cutId,'title'=>$row['ctg_title']));
        }
        return $arr;
    }

    function getNavStr($ctgId){
        $arr = $this->getUpperList($ctgId);
        $i = 0;
        $str = "";
        foreach($arr as $ctg ){
            if( $i!=0 ) $str .= " > ";
            $str .= $ctg['title'];
            $i++;
        }
        return $str;
    }

    function getDepthList($depth,$upper,$use='y',$col="*"){
        if( $depth!=1 && empty($upper) ) return;
        if( empty($upper) ) $sql_where = " ";
        else $sql_where = " and ctg_upper_id = '$upper' ";
        
        $length = $depth*3;
        $sql_where .= " and length(ctg_id)='$length' ";
        if($use=='y' || $use=='n') $sql_where.= " and ctg_use_yn = '$use' ";
        return $this->selectAll( $col, $sql_where." order by ctg_orderby " );
    }

    function printDepthList($depth, $ctg, $name, $event='', $use='y'){
        $length = $depth*3;
        $upper = substr($ctg,0,$length-3);
        $pre = substr($ctg,0,$length);
        $str = "<select id=\"{$name}\" name=\"{$name}\"{$event}>\n";
        $str.= "<option value=\"\">=카테고리선택=</option>\n";
        if( !empty($ctg) || $depth==1){
            $res = $this->getDepthList($depth,$upper,$use);
            foreach($res as $row) {
                $str.= get_frm_option($row['ctg_id'], $pre, $row['ctg_title']);
            }
        }
        $str.= "</select>\n";
        return $str;
    }

    function move($arr,$id){
        $value['ctg_orderby'] = $arr['orderby'];
        return $this->set($value,$id,"value");
    }
}
?>
