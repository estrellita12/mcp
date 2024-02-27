<?php
namespace application\models;

use \Exception;

class KeywordModel extends Model{
    public function __construct(){
        parent::__construct ( 'web_keyword' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode=="add"){  
            $value['keyword_reg_dt'] = _DATE_YMDHIS;
        }
        if( !empty($arr['title']) )     $value['keyword_title'] = get_list($arr['title']," ");
        if( !empty($arr['cnt']) )       $value['keyword_cnt'] = $arr['cnt'];
        $value['keyword_update_dt'] = _DATE_YMDHIS;
        return $value;
    }

    public function set($id, $arr=array(), $type="arr"){
        if( empty($id) ) $id = $id['title'];
        if( empty($id) ) return "002";

        if($type=="arr") $value = $this->getValue($arr,'set');
        else $value = $arr;

        $search = " and keyword_id = '{$id}' ";
        return $this->update($value,$search);
    }

    public function add($arr, $type='arr'){
        if($type=="arr") $value = $this->getValue($arr,'add');
        else $value = $arr;
        return $this->insert($value);
    }

    public function search($title){
        $title = get_list($title," ");
        $row = $this->get("keyword_id,keyword_cnt",array("keyword_title"=>$title));
        if( empty($row) ){
            $res = $this->add(array("title"=>$title));
        }
        //$res = $this->set($row['keyword_id'], array("title"=>$title,"cnt"=>$row['keyword_cnt']+1));
        $titleArr = explode(" ",$title);
        $list = "";
        for($i=0;$i<count($titleArr);$i++){
            if(!empty($list)) $list .= " , ";
            $name= "key".$i;
            $parameter[$name] = $titleArr[$i];
            $list .= " :{$name}";  
        }
        $sql = "update {$this->tb_nm} set keyword_cnt = keyword_cnt+1 where keyword_title in ($list) ";
        $res = $this->execute($sql,$parameter);
        return $res;
    }

    public function remove($id){
        try{
            if( empty($id) ) return "002";
            $search = " and keyword_id = '{$id}' ";
            return $this->delete($search);
        }catch(Exception $e){
            debug_log( static::class,"009",array("error"=>$e->getMessage())); 
            return "009";
        }

    }

}
?>
