<?php
namespace application\Seller\controllers;

use \Exception;

abstract class Controller {
    public $param;

    public function __construct($params){
        try{
            if( !isset($_SESSION['is_seller']) || !isset($_SESSION['user_id']) ){
                access("접근이 거부 되었습니다.", _URL."/Login");
            }
            $this->header = 'aside'; $this->footer = 'footer'; $this->param = $params;

            $configModel = new \application\models\ConfigModel();
            $this->config = $configModel->get("*",array("cf_id"=>1));
            $this->config['cf_delivery_company'] = json_decode( $this->config['cf_delivery_company'],true );

            $this->sellerModel = new \application\models\SellerModel();
            $this->my = $this->sellerModel->get("*",array("sl_id"=>$_SESSION['user_id']));
            $this->my['sl_manager'] = unserialize($this->my['sl_manager']);
            $this->my['sl_manager2'] = unserialize($this->my['sl_manager2']);
            $this->my['sl_manager3'] = unserialize($this->my['sl_manager3']);
            $this->my['sl_manager4'] = unserialize($this->my['sl_manager4']);
            $_REQUEST['seller'] = $_SESSION['user_id'];

            unset($GLOBALS['od_stt'][21]['next']);
            unset($GLOBALS['od_stt'][31]['next']);

            $this->init();
            $method = isset($this->param['page']) ? $this->param['page'] : 'index';
            if(method_exists($this,$method)) $this->result = $this->$method();
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
            $this->gnbModel = new \application\models\SellerMenuModel();
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
