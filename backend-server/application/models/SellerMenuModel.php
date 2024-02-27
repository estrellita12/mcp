<?php
namespace application\models;

use \PDO;

class SellerMenuModel extends Model{

    function __construct( ){
        parent::__construct ( 'web_seller_menu' );
    }

    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if( !empty($arr['tab']) )       $value['tab']       = $arr['tab'];      // 최상단 메뉴
        if( !empty($arr['code']) )      $value['code']      = $arr['code'];     // 메뉴 코드
        if( !empty($arr['upper']) )     $value['upper']     = $arr['upper'];    // 상위 메뉴 
        if( !empty($arr['name']) )      $value['name']      = $arr['name'];     // 메뉴 이름
        if( !empty($arr['url']) )       $value['url']       = $arr['url'];      // 메뉴 URL
        if( !empty($arr['use']) )       $value['use_yn']    = $arr['use'];   // 메뉴 사용 여부
        if( !empty($arr['orderby']) )   $value['orderby']   = $arr['orderby'];  // 메뉴 순서

        return $value;
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order ))   $this->sql_order = " order by orderby ";    // 기본 정렬 방식 설정
        return $this->sql_order;
    }

/*
    function get($id, $col="*"){
        $sql_where = " and code = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/

    function set($arr, $id='', $mode="add"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002";
        if($mode=='move') $value['orderby'] = $arr['orderby'];
        else $value = $this->getValue($arr,'set');
        $search = " and code = '{$id}' ";
        return $this->update($value,$search);
    }

    function add( $arr ){
        $upper = $arr['id'];
        $row = $this->select("MAX(code) as code, MAX(orderby) as orderby, tab "," and upper='{$upper}' ");       
        if( empty($row) || empty($row['code']) ){
            $row2 = $this->get("tab", array("code"=>$upper));  
            $tab = $row2['tab'];
            $code = $upper."01";
        }else{
            $tab = $row['tab'];
            $code  = $row['code'] + 1;
            $length = strlen($upper) + 2;
            if(strlen($code) < $length) $code = "0".$code;
            if(strlen($code) < $length) $code = "0".$code;
            if(strlen($code) < $length) $code = "0".$code;
            $order                  = $row['orderby'] + 1;
        }
        $value['tab']          = $tab;
        $value['code']          = $code;
        $value['upper']         = $upper;
        $value['name']         = '새로운카테고리';
        $value['orderby']       = $order;
        $value['use_yn']       = 'n';
        return $this->insert($value);
    }

    function remove( $code='' ){
        if(empty($code)) return;
        $search = " and code = '{$code}' ";
        return $this->delete($search);
    }

    function getTab($url){
        $sql = "select a.tab as tab, b.name as tab_name, b.code as tab_code, a.name as name, a.code as code, upper, url, a.use_yn as use_yn  from ";
        $sql .= " (select tab,name,code,upper,url,use_yn from ".$this->tb_nm." where url = '".$url."' and length(code)>2) a ";
        $sql .= " join ";
        $sql .= " (select tab,name,code,use_yn from ".$this->tb_nm." where tab in ((select tab from ".$this->tb_nm." where url = '".$url."')) and length(code)=2 ) b ";
        $sql .= " on a.tab = b.tab  ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return empty($row)?false:$row;
    }

    function getDepthList( $depth, $upper='', $use='y'){
        $length = $depth * 2;
        $sql_where = " and length(code) = '$length' and upper = '$upper' ";
        if( empty($upper) ) $sql_where .= " and upper = '$upper' ";
        if($use=='y' || $use=='n') $sql_where.= " and use_yn = '$use' ";
        return $this->selectAll( 'tab,code,name,url', $sql_where, "order by orderby" );
    }

    function printDepthList($depth, $menu, $name, $event='', $use='a'){
        $length = $depth*2;
        $upper = substr($menu,0,$length-2);
        $pre = substr($menu,0,$length);
        $str = "<select id=\"{$name}\" name=\"{$name}\"{$event}>\n";
        $str.= "<option value=\"\">==메뉴 선택==</option>\n";
        $res = $this->getDepthList($depth, $upper,$use);
        if( !empty($menu) || $depth==1){
            $res = $this->getDepthList($depth,$upper,$use);
            foreach($res as $row) {
                $str.= get_frm_option($row['code'], $pre, $row['name']);
            }
        }
        $str.= "</select>\n";
        return $str;
    }
}


?>
