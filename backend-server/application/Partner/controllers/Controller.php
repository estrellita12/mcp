<?php
namespace application\Partner\controllers;

use \Exception;

abstract class Controller {
    protected $param;

    public function __construct($params){
        try{
            if( !isset($_SESSION['is_partner']) || !isset($_SESSION['user_id']) ){
                access("접근이 거부 되었습니다.", _URL."/Login");
            }
            $this->header = 'aside'; $this->footer = 'footer'; $this->param = $params;

            $configModel = new \application\models\ConfigModel();
            $this->config = $configModel->get("*",array("cf_id"=>1));
            $this->config['cf_delivery_company'] = json_decode( $this->config['cf_delivery_company'],true );

            $this->partnerModel = new \application\models\PartnerModel();
            $this->my = $this->partnerModel->get("*",array("pt_id"=>$_SESSION['user_id']));
            $this->my['pt_bank_info'] = unserialize($this->my['pt_bank_info']);
            $this->my['pt_manager'] = unserialize($this->my['pt_manager']);
            //$this->my['pt_manager2'] = unserialize($this->my['pt_manager2']);
            //$this->my['pt_manager3'] = unserialize($this->my['pt_manager3']);
            //$this->my['pt_manager4'] = unserialize($this->my['pt_manager4']);
            $_REQUEST['partner'] = $_SESSION['user_id'];
            $_REQUEST['shop'] = $_SESSION['user_id'];

            $this->init();
            $method = isset($this->param['page']) ? $this->param['page'] : 'index';
            if( method_exists($this,$method) ) $this->$method();
            $this->header();
            $this->content();
            $this->footer();
        }catch(Exception $e){
            $this->response_error("500", $e->getMessage());
            exit;
        }
    }

    protected function response_error($code,$msg){
        debug_log( static::class,__method__,$code,array( "error"=>$msg ) );
        header("Location: /public/{$code}.html"); 
        exit;
    }

    abstract function init();
    private function header(){
        if( !empty($this->header) ){
            $search = array();
            $this->gnbModel = new \application\models\PartnerMenuModel();
            $search["url"] = "/".$this->param['menu']."/".$this->param['page'];
            $search["code_length_eq"] = 6;
            $this->tabPageInfo = $this->gnbModel->get("tab,code,upper,name,url",$search);
            require_once(_VIEW."/".$this->header.".php");
        } 
    }

    private function content(){
        $path = _VIEW."/{$this->param['menu']}/{$this->param['page']}.php";
        if(file_exists($path)) require_once($path);
    }

    private function footer(){
        if(!empty($this->footer)){
            require_once(_VIEW."/".$this->footer.".php");
        }
    }
}
?>
