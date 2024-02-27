<?php
namespace application\Admin\controllers;

class DebugController{
    function __construct($params){
        if( !isset($_SESSION['is_administrator']) ){
            access("접근이 거부 되었습니다.", _URL."/Login");
            die();
        }
        $this->param = $params;
        $method = isset($this->param['page']) ? $this->param['page'] : 'index';
        if(method_exists($this,$method)) $this->result = $this->$method();
    }

    function get(){
        $fileName = "/var/www/html/mcp/log/debug_2022-12-30.txt";
        if(file_exists($fileName)){
            $fp = fopen($fileName, 'r');
            if($fp){
                $fr = fread($fp, filesize($fileName));
                if($fr){
                    echo $fr;
                    fclose($fp);
                } else { 
                    echo "파일 읽기에 실패하였습니다.";
                }
            } else { 
                echo "파일 열기에 실패하였습니다."; 
            }
        } else { 
            echo "파일이 존재하지 않습니다."; 
        }
    }
}
