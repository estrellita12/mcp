<?php
namespace application\Seller;

class Route{
    public $controller;
    public $action;
    public function __construct(){
        // URL값을 index.php에서 지정한 규칙에 맞게 필터링
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
            echo _CONTROLLER.$params['menu'] ."해당 컨트롤러가 존재하지 않습니다.";
            exit();
        }
        $controllerName = str_replace("/","\\",_CONTROLLER).$params['menu'].'Controller';
        //new $controllerName($params['menu'], $params['action'], $params['category'], $params['idx'], $params['pageNum'], $params['searchKey']);
        new $controllerName($params);
    }
}

?>

