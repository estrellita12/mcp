<?php
namespace application\Front;

class Route
{
    public $controller;
    public $action;
    public function __construct()
    {
        // URL값을 index.php에서 지정한 규칙에 맞게 필터링
        $getUrl = '';
        if (isset($_GET['url'])) {
            $getUrl = $_GET['url'];
            $getUrl = rtrim($getUrl, '/');
            $getUrl = ltrim($getUrl, '/');
            $getUrl = filter_var($getUrl, FILTER_SANITIZE_URL);
        }
        $getParams = explode('/', $getUrl);
        // collerction / ident / store / controller
        // goods
        // goods?field=name%3골프공,price%310000&offset=10&limie=5
        // goods/1
        // users/id/carts/2
        // users/id/cart/buyed??
        // users/id/cart/delete??
        //$params['document']         = isset($getParams[0]) && $getParams[0] != '' ? $getParams[0] : null;
        //$params['collection']       = isset($getParams[1]) && $getParams[1] != '' ? $getParams[1] : null;
        //$params['ident']            = isset($getParams[2]) && $getParams[2] != '' ? $getParams[2] : null;
        //$params['store']            = isset($getParams[3]) && $getParams[3] != '' ? $getParams[3] : null;
        //$params['controller']       = isset($getParams[4]) && $getParams[4] != '' ? $getParams[4] : null;
        $params['controller']       = isset($getParams[0]) && $getParams[0] != '' ? $getParams[0] : 'init';
        $params['ident']            = isset($getParams[1]) && $getParams[1] != '' ? $getParams[1] : null;
        $params['method']           = isset($getParams[2]) && $getParams[2] != '' ? $getParams[2] : null;
        $params['subident']         = isset($getParams[3]) && $getParams[3] != '' ? $getParams[3] : null;

        if (!file_exists(_CONTROLLER. $params['controller'] .'Controller.php')) {
            echo _CONTROLLER.$params['controller'] ."해당 컨트롤러가 존재하지 않습니다.";
            exit();
        }
        $controllerName = str_replace("/","\\",_CONTROLLER).$params['controller'].'Controller';
        new $controllerName($params);
    }

}

?>

