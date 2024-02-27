<?php
namespace application\models;

use \Exception;
use \PDO;

class KeywordRelationModel extends Model{
    public function __construct(){
        parent::__construct ( 'web_keyword_relation' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){  
            $value['kw_relation_reg_dt'] = _DATE_YMDHIS;
        }
        if( !empty($arr['pre']) )       $value['kw_relation_pre'] = get_list($arr['pre']," ");
        if( !empty($arr['next']) )      $value['kw_relation_next'] = get_list($arr['next']," ");
        return $value;
    }

    public function set($id, $arr=array(), $type="arr"){
        if( empty($id) ) return "002";

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and kw_relation_id = '{$id}' ";
        return $this->update($value,$search);
    }

    public function add($arr, $type='arr'){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    public function remove($id){
        try{
            if( empty($id) ) return "002";
            $search = " and kw_relation_id = '{$id}' ";
            return $this->delete($search);
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function search($col="*",$keyword){
        try{
            $col1 = "kw_relation_next as keyword_title, count(kw_relation_next) as keyword_cnt";
            $sql = " ( select {$col1} from {$this->tb_nm} where kw_relation_pre = :keyword1 group by kw_relation_next ) ";
            $sql .= " union all ";
            $col2 = "kw_relation_pre as keyword_title, count(kw_relation_pre) as keyword_cnt";
            $sql .= " ( select {$col2} from {$this->tb_nm} where kw_relation_next = :keyword2 group by kw_relation_pre )";
            $this->sql_from = "( ".$sql." ) as c ";
            $this->col_nm = array("keyword_title"=>"키워드","keyword_cnt"=>"갯수");
            $parameter = array("keyword1"=>$keyword,"keyword2"=>$keyword);
            $search = array();
            $search['keyword_cnt_then_ge'] = 0;
            $search['col'] = "keyword_cnt";
            $search['colby'] = "desc";
            return $this->get($col,$search,true,"",$parameter);
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }
    }

}
?>
