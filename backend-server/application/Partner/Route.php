<?php
namespace application\Partner;

use \Exception;

class Route{
    public function __construct(){
        try{
            $getUrl = '';
            if (isset($_GET['url'])) {
                $getUrl = $_GET['url'];
                $getUrl = rtrim($getUrl, '/');
                $getUrl = ltrim($getUrl, '/');
                $getUrl = filter_var($getUrl, FILTER_SANITIZE_URL);
            }
            $getParams = explode('/', $getUrl);
            $params['menu'] = isset($getParams[0]) && $getParams[0] != '' ? $getParams[0] : 'Main';
            $params['page'] = isset($getParams[1]) && $getParams[1] != '' ? $getParams[1] : 'index';
            $params['ident'] = isset($getParams[2]) && $getParams[2] != '' ? $getParams[2] : null;
            $params['action'] = isset($getParams[3]) && $getParams[3] != '' ? $getParams[3] : null;
            if (!file_exists(_CONTROLLER. $params['menu'] .'Controller.php')) {
                throw new Exception(_CONTROLLER.$params['menu'] ."해당 컨트롤러가 존재하지 않습니다.");
            }
            $controllerName = str_replace("/","\\",_CONTROLLER).$params['menu'].'Controller';
            new $controllerName($params);
        }catch(Exception $e){
            debug_log( static::class,"404",array("error"=>$e->getMessage()) );
            header("Location: /public/404.html"); 
            exit();
        }
    }

}

?>

