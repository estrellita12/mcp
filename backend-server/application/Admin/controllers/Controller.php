<?php
namespace application\Admin\controllers;

use \Exception;

abstract class Controller {
    var $header;
    var $footer;

    var $param;                 // 전달된 파라미터  menu/page/ident/action
    var $url;

    //생성자
    function __construct($params){
        if( !isset($_SESSION['is_administrator']) ){
            access("접근이 거부 되었습니다.", _URL."/Login");
            die();
        }
        $this->header = 'aside'; $this->footer = 'footer'; $this->param = $params;

        $this->gnb = new \application\models\AdminMenuModel();
        $config = new \application\models\ConfigModel();
        $this->config = $config->get("*",array("cf_id"=>1));
        $this->config['cf_delivery_company'] = json_decode( $this->config['cf_delivery_company'],true );

        $default = new \application\models\DefaultModel();
        $this->default = $default->get("*",array("df_id"=>1));

        $this->init();
        $method = isset($this->param['page']) ? $this->param['page'] : 'index';
        if(method_exists($this,$method)) $this->result = $this->$method();
        $this->header();
        $this->content();
        $this->footer();
    }

    abstract function init();
    function header(){
        $search = array();
        $search["url"] = "/".$this->param['menu']."/".$this->param['page'];
        $search["code_length_eq"] = 6;
        $this->tabPageInfo = $this->gnb->get("tab,code,upper,name,url",$search);
        //$this->tabInfo = $this->gnb->get("tab,code,upper,name,url",$search);

        if( !empty($this->header) ){
           require_once(_VIEW."/".$this->header.".php");
        } 
    }

    function content(){
        $path = _VIEW."/{$this->param['menu']}/{$this->param['page']}.php";
        if(file_exists($path)) require_once($path);
    }

    function footer(){
        if(!empty($this->footer)){
            require_once(_VIEW."/".$this->footer.".php");
        }
    }
}
?>
