<?php
namespace application\models;

use \PDO;
use \Exception;

class Model{
    public $pdo;
    public $tb_nm;

    public $sql_from;
    public $parameter;
    public $sql_where;
    public $sql_order;
    public $sql_group;
    public $sql_limit;

    public $pre_value;
    public $preValue;

    public function __construct( $tb_nm = '' ){
        try{
            $this->tb_nm = $tb_nm;
            $this->sql_from = $this->tb_nm;
            $dsn = _DBTYPE . ':host=' ._DBHOST. ';dbname=' . _DBNAME . ';charset=' . _CHARSET;
            $this->pdo = new PDO($dsn, _DBUSER, _DBPASSWORD,  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] );
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->parameter = array();
            $this->sql_where = "";
            $this->sql_order = "";
            $this->sql_group = "";
            $this->sql_limit = "";
            $this->col_nm = $this->getColName($tb_nm);
        } catch (Exception $e) {
            debug_log( static::class,__method__ ,"010", array("error"=>$e->getMessage()));
            return "010";
        }
    }

    public function getColName($tb_nm){
        try{
            $sql = "SELECT column_name, column_comment FROM information_schema.columns WHERE table_schema = '"._DBNAME."' AND table_name = '{$tb_nm}' ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $fetchAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $col_nm = array();
            foreach($fetchAll as $row){
                $col_nm[$row['column_name']] = $row['column_comment'];
            }
            return $col_nm;
        }catch (Exception $e) {
            debug_log( static::class,__mehotd__, "009", array("sql"=>$sql,"error"=>$e->getMessage()));
            return "009";
        }
    }

    private function setOrder($col,$colby){
        if( !empty($colby) ) {
            $this->sql_order = " order by {$col} {$colby} ";
        }else{
            $this->sql_order = " order by {$col} asc ";
        }
    }

    private  function setLimit($rpp,$page){
        if( !empty($page) ) {
            $sl = ($page - 1) * $rpp;
            $this->sql_limit = " limit $sl, $rpp ";
        }else{
            $this->sql_limit = " limit $rpp ";
        }
    }

    private function  setWhereIn($col, $then, $value){
        switch($then){
        case "not" : $op = " not in "; break;
        default : $op = " in ";
        }

        $value = explode(",",$value);
        $value = array_diff($value,array("",null));
        if(empty($value)) return;        
        $this->sql_where .= " and {$col} {$op} ( ";
        for($i=0;$i<count($value);$i++){
            if( $i!=0 ) $this->sql_where .= " , "; 
            $this->sql_where .= " :search_{$col}_in_{$i} ";
            $this->parameter["search_{$col}_in_{$i}"] = $value[$i];
        }
        $this->sql_where .= " ) "; 
    }

    private function  setWhereThen($col, $then, $value){
        switch($then){
        case "ge" : $op = ">="; break;
        case "gt" : $op = ">"; break;
        case "le" : $op = "<="; break;
        case "lt" : $op = "<"; break;
        case "ne" : $op = "!="; break;
        default : $op = "=";
        }
        $search_col = preg_replace("/[^a-zA-Z]/", "", $col);
        $this->sql_where .= " and {$col} {$op} :search_{$search_col}_{$then} ";
        $this->parameter["search_{$search_col}_{$then}"] = $value;
    }

    private function setWhereLike($col, $then, $value){
        switch($then){
        case "left" : $value = "%{$value}"; break;
        case "right" : $value = "{$value}%"; break;
        default : $value = "%{$value}%";
        }
        $this->sql_where .= " and {$col} like :search_{$col}_like ";
        $this->parameter["search_{$col}_like"] = $value;
    }

    public function get( $col="*", $search, $fetchAll=false, $sql_where="",$parameter=array()){
        try{
            $this->sql_where = $sql_where;
            $this->parameter = $parameter;
            $col_array = array_keys($this->col_nm);
            foreach($search as $k=>$v){
                if( $k=="col" ){
                    $this->setOrder($v,!empty($search['colby'])?$search['colby']:"asc");
                }else if($k=="rpp"){
                    $this->setLimit($v,!empty($search['page'])?$search['page']:"1");
                }else if(strpos($k,"_then_")){
                    $arr = explode("_then_",$k);
                    if( !in_array($arr[0],$col_array) ) continue;
                    $this->setWhereThen($arr[0],$arr[1],trim($v));
                }else if(strpos($k,"_length_")){
                    $arr = explode("_length_",$k);
                    if( !in_array($arr[0],$col_array) ) continue;
                    $this->setWhereThen("length({$arr[0]})",$arr[1],trim($v));
                }else if( strpos($k,"_like_") ){
                    $arr = explode("_like_",$k);
                    if( !in_array($arr[0],$col_array) ) continue;
                    $this->setWhereLike($arr[0],$arr[1],trim($v));
                }else if( strpos($k,"_in_") ){
                    $arr = explode("_in_",$k);
                    if( !in_array($arr[0],$col_array) ) continue;
                    $this->setWhereIn($arr[0],$arr[1],trim($v));
                }else{
                    if( !in_array($k,$col_array) ) continue;
                    $this->sql_where .= " and {$k} = :search_{$k} ";
                    $this->parameter["search_{$k}"] = $v;
                }
            }

            if( empty($this->sql_where) || empty($this->parameter) ){
                //debug_log( static::class,__method__, "002", array("message"=>"넘겨받은 배열 없음"));
                return "002";
            }

            if($fetchAll){
                $sql = "SELECT {$col} FROM {$this->sql_from} where 1 = 1 {$this->sql_where} {$this->sql_group} {$this->sql_order} {$this->sql_limit}";
                $this->sql_group = ""; $this->sql_order = ""; $this->sql_limit = ""; 
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($this->parameter);
                result_log( static::class,__method__,"000",array("sql"=>$sql,"parameter"=>$this->parameter)); 
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $sql = "SELECT {$col} FROM {$this->sql_from} where 1 = 1 {$this->sql_where} {$this->sql_group}";
                $this->sql_group = ""; $this->sql_order = ""; $this->sql_limit = ""; 
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($this->parameter);
                //result_log( static::class,__method__,"000",array("sql"=>$sql,"parameter"=>$this->parameter)); 
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }catch (Exception $e) {
            debug_log( static::class,__method__, "009", array("sql"=>$sql,"parameter"=>$this->parameter,"error"=>$e->getMessage()) );
            return "009";
        }
    }

    //--------------------------------------------------------------------------------------------
    function getCol($arr = array(), $include=true){ // 올딜 전용
        $col = "";
        foreach($this->colArr as $key=>$value){
            if( !empty($arr) ){
                if( $include ){
                    if( !in_array($key,$arr) ) continue;
                }else{
                    if( in_array($key,$arr) ) continue;
                }
            }
            if($col != "") $col .=", ";
            $col .= $value." as ".$key;
        }
        return $col;
    }

    function getSearch($var,$data,$type="all"){
        if( preg_match("/,/",$data) ){
            $this->getParameter($var,$data);
        }else{
            $sql = ":".$var;
            if($type=="left") $this->parameter[$var] = "%".$data;
            else if($type=="right") $this->parameter[$var] = $data."%";
            else $this->parameter[$var] = "%".$data."%";
            $this->sql_where .= " and {$var} like {$sql}";
        }
    }

    function getParameter($var,$data,$type='pro'){
        if( !is_array($data) ) $data = explode(",",$data);
        //$data = array_filter($data);
        $data = array_diff($data,array("",null));
        if(empty($data)) return;        

        switch ($type){
        case 'pro' : $kwdType = 'in'; break;
        case 'cons': $kwdType = 'not in'; break;
        }

        $sql = "";
        $arr = array();

        foreach($data as $key=>$value){
            if(!empty($sql)) $sql .= ", ";
            $sql .= ":".$var.$key;
            $this->parameter[$var.$key] = $value;
        }
        $this->sql_where .= " and {$var} {$kwdType} ({$sql}) ";
    }

    function getTerm($term,$value='',$then='ge'){
        $if = "=";
        switch($then){
        case "ge" : $if = ">="; break;
        case "gt" : $if = ">"; break;
        case "le" : $if = "<="; break;
        case "lt" : $if = "<"; break;
        default : $if = "=";
        }
        $this->parameter[$term."_".$then] = $value;
        $this->sql_where .= " and left({$term},10) {$if} :{$term}_{$then} ";
    }

    function getInterval($term,$value='',$then='ge'){
        $if = "=";
        switch($then){
        case "ge" : $if = ">="; break;
        case "gt" : $if = ">"; break;
        case "le" : $if = "<="; break;
        case "lt" : $if = "<"; break;
        default : $if = "=";
        }
        $this->parameter[$term."_".$then] = $value;
        $this->sql_where .= " and {$term} {$if} :{$term}_{$then} ";
    }

    function getWhere(){
        $this->sql_where = "";
        $this->parameter = array();
    }

    function getOrder(){
        $this->sql_order = "";
    }

    function getLimit(){
        if(!empty($_REQUEST['rpp'])){
            if( !empty($_REQUEST['page']) ) {
                $sl = ($_REQUEST['page'] - 1) * $_REQUEST['rpp'];
                $this->sql_limit = " limit $sl, $_REQUEST[rpp] ";
            }else{
                $this->sql_limit = " limit $_REQUEST[rpp] ";
            }
        }
    } 

    function getCnt(){
        $this->getWhere(); 
        if( !empty($this->sql_group) ){
            $sql = "select count(a.cnt) from ( SELECT count(*) as cnt FROM ".$this->sql_from." where 1 = 1 $this->sql_where $this->sql_group  ) as a ";
        }else{
            $sql = "SELECT count(*) FROM ".$this->sql_from." where 1 = 1 $this->sql_where ";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->parameter);
        $row = $stmt->fetchColumn();
        return $row;
    }

    function getList( $col='*' ){
        try{
            $this->getWhere();  $this->getOrder(); $this->getLimit();
            $sql = "SELECT $col FROM ".$this->sql_from." where 1 = 1 $this->sql_where $this->sql_group $this->sql_order $this->sql_limit ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->parameter);
            //result_log( static::class,__method__,"000",array("sql"=>$sql,"parameter"=>$this->parameter)); 
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e) {
            debug_log( static::class,__method__,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    function getSum( $col='*' ){
        $this->getWhere();  $this->getOrder(); $this->getLimit();
        $sql = "SELECT $col FROM ".$this->tb_nm." where 1 = 1 $this->sql_where $this->sql_group $this->sql_order $this->sql_limit ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->parameter);
        //result_log( static::class,__method__,"000",array("sql"=>$sql,"arr"=>$this->parameter)); 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function overChk($col, $ident){
        if( $ident == 'admin' ) return false;
        $sql = "SELECT count($col) as cnt FROM ".$this->tb_nm." where $col='{$ident}' ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchColumn();
        return $row == 0 ? true : false;
    }
    //--------------------------------------------------------------------------------------------

    public function select( $col='*', $sql_where = '' ){
        try{
            $sql = "SELECT $col FROM ".$this->tb_nm." where 1 = 1 $sql_where ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            debug_log( static::class,__method__ ,"009", array("sql"=>$sql,"error"=>$e->getMessage()));
            return "009";
        }
    }

    public function selectAll( $col='*', $sql_where = '' , $sql_order = '', $sql_limit = '' ){
        try{
            $sql = "SELECT $col FROM ".$this->tb_nm." where 1 = 1 $sql_where $sql_order $sql_limit ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            debug_log( static::class,__method__ ,"009", array("sql"=>$sql,"error"=>$e->getMessage()));
            return "009";
        }
    }

    public function selectAuto(){
        try{
            $sql = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = '{$this->tb_nm}' AND table_schema = DATABASE()";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return array_key_exists('AUTO_INCREMENT',$result) ? $result['AUTO_INCREMENT'] : null;
        }catch(Exception $e){
            debug_log( static::class,__method__ ,"009", array("sql"=>$sql,"error"=>$e->getMessage()));
            return "009";
        }
    }    


    public function insert( $arr ){
        try{
            $col_array = array_keys($this->col_nm);
            $parameter = array();
            $field = "";
            $value = "";
            foreach($arr as $k=>$v){
                if( !in_array($k,$col_array) ) continue;
                if(!empty($field)){
                    $field .= " , ";
                    $value .= " , ";
                }
                $field .= $k;  
                $value .= ":".$k;
                $parameter[$k] = $v;
            }

            if( empty($parameter) ){
                return "002"; 
            }

            $sql = "insert into ".$this->tb_nm." ($field) VALUES ($value)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameter);
            if($stmt->rowCount() > 0){
                return "000";
            }else{
                return "001";
            }
        }catch (Exception $e) {
            debug_log( static::class,__method__,"009",array("sql"=>$sql,"parameter"=>$parameter,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function update( $arr,  $sql_search = "" ){
        try{
            $sql_common = "where 1 = 1  ";
            if( $sql_search != null && $sql_search != "" )  $sql_common .= $sql_search;

            $str = "";
            $col_array = array_keys($this->col_nm);
            $parameter = array();
            foreach($arr as $k=>$v){
                if( !in_array($k,$col_array) ) continue;
                $parameter[$k] = $v;
                if(!empty($str)) $str .= " , ";
                $str .= $k." = :".$k;  
            }

            if( empty($parameter) ){
                return "002"; 
            }

            $sql = "update ".$this->tb_nm." SET $str $sql_common";  // 실제 쿼리 생성
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameter);
            if($stmt->rowCount() > 0){
                return "000";
            }else{
                return "001";
            }
        }catch (Exception $e) {
            debug_log( static::class,__method__,"009",array("sql"=>$sql,"parameter"=>$parameter,"error"=>$e->getMessage())); 
            return "009";
        }

    }

    public function delete( $sql_where ){
        try{
            $sql = "delete FROM ".$this->tb_nm." where 1 = 1 $sql_where ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return "000";
            }else{
                return "001";
            }
        }catch (Exception $e) {
            debug_log( static::class,__method__,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function execute( $sql, $param = array() ){
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
            if($stmt->rowCount() > 0){
                return "000";
            }else{
                return "001";
            }
        }catch (Exception $e) {
            debug_log( static::class,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function leftJoin($key1,$table, $key2, $delete=""){
        try{
            $col_nm = array_merge( $this->col_nm , $this->getColName($table) );
            $col = "";      
            foreach($col_nm as $k=>$v){
                if( !empty($col ) ) $col .= ",";
                if(array_key_exists($k,$this->col_nm)){
                    $col .= "a.$k as $k";
                }else{
                    $col .= "b.$k as $k";
                }
            }
            $this->sql_from = "( select $col from {$this->tb_nm} a left join {$table} b on a.{$key1} = b.{$key2}  ) c  ";
            $this->col_nm = $col_nm;

        }catch (Exception $e) {
            debug_log( static::class,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function init(){
        $this->sql_from = $this->tb_nm;
        $this->exec_parameter = array();
        $this->sql_where = "";
        $this->sql_group = "";
        $this->sql_order = "";
        $this->sql_limit = "";
        $this->col_nm = $this->getColName($this->tb_nm);
    }

    public function addLog($id,$value=array(),$exclude=array(), $type="수정"){
        try{
            $data = array();
            if( !empty($this->preValue) ){ // 수정 데이터
                $column = $this->col_nm;
                foreach($this->preValue as $k=>$v){
                    if( in_array($k,$exclude) ) continue;
                    if( isset($value[$k]) && strcmp($value[$k],$v)!=0 ){
                        $arr = array(
                            "col_name"=>$k,
                            "comment"=>$column[$k],
                            "pre_value"=>$v,
                            "change_value"=>$value[$k],
                        );
                        array_push($data,$arr);
                    }
                }
            }
            if( $type != "수정" ){
                $arr = array(
                    "col_name"=>"",
                    "comment"=>"",
                    "pre_value"=>"",
                    "change_value"=>"",
                );
                array_push($data,$arr);
            }

            if( empty($data) ) return;

            $log =  new \application\models\UpdateLogModel();   
            $arr = array(
                "targetTable"=>$this->tb_nm,
                "targetId"=>$id,
                "data"=>json_encode($data),
                "memo"=>$type
            );
            if( !empty($_SESSION['user_id']) ) $arr['byId'] = $_SESSION['user_id'];
            if( !empty($_SESSION['user_type']) ) $arr['byType'] = $_SESSION['user_type'];
            $log->add($arr);
            return $data;
        }catch (Exception $e) {
            debug_log( static::class,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

    public function getChangeData($value=array(),$exclude=array()){
        try{
            $data = array();
            if( !empty($this->preValue) ){
                $column = $this->col_nm;
                foreach($this->preValue as $k=>$v){
                    if( in_array($k,$exclude) ) continue;
                    if( isset($value[$k]) && strcmp($value[$k],$v)!=0 ){
                        $arr = array(
                            "col_name"=>$k,
                            "comment"=>$column[$k],
                            "pre_value"=>$v,
                            "change_value"=>$value[$k],
                        );
                        array_push($data,$arr);
                    }
                }
            }else{
                $arr = array(
                    "col_name"=>"",
                    "comment"=>"",
                    "pre_value"=>"",
                    "change_value"=>"",
                );
                array_push($data,$arr);
            }
            return $data;

        }catch (Exception $e) {
            debug_log( static::class,"009",array("sql"=>$sql,"error"=>$e->getMessage())); 
            return "009";
        }
    }

}
?>
