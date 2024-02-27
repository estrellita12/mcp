<?php
if(!function_exists('session_start_samesite')) {
    function session_start_samesite($options = array())
    {
        $res = @session_start($options);

        // IE 브라우저 또는 엣지브라우저 일때는 secure; SameSite=None 을 설정하지 않습니다.
        if( preg_match('/Edge/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(; Touch)?; rv:11.0~',$_SERVER['HTTP_USER_AGENT']) ){
            return $res;
        }

        $headers = headers_list();
        krsort($headers);
        foreach ($headers as $header) {
            if (!preg_match('~^Set-Cookie: PHPSESSID=~', $header)) continue;
            $header = preg_replace('~; secure(; HttpOnly)?$~', '', $header) . '; secure; SameSite=None';
            header($header, false);
            break;
        }
        return $res;
    }
}

session_start_samesite();

function array_map_deep($fn, $array)
{
    if(is_array($array)) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $array[$key] = array_map_deep($fn, $value);
            } else {
                $array[$key] = call_user_func($fn, $value);
            }
        }
    } else {
        $array = call_user_func($fn, $array);
    }

    return $array;
}


// SQL Injection 대응 문자열 필터링
function sql_escape_string($str)
{
    if(defined('TB_ESCAPE_PATTERN') && defined('TB_ESCAPE_REPLACE')) {
        $pattern = TB_ESCAPE_PATTERN;
        $replace = TB_ESCAPE_REPLACE;

        if($pattern)
            $str = preg_replace($pattern, $replace, $str);
    }

    $str = call_user_func('addslashes', $str);

    return $str;
}

/*
// magic_quotes_gpc 에 의한 backslashes 제거
if(get_magic_quotes_gpc()) {
    $_POST    = array_map_deep('stripslashes',  $_POST);
    $_GET     = array_map_deep('stripslashes',  $_GET);
    $_COOKIE  = array_map_deep('stripslashes',  $_COOKIE);
    $_REQUEST = array_map_deep('stripslashes',  $_REQUEST);
}
*/
// sql_escape_string 적용
$_POST    = array_map_deep('sql_escape_string',  $_POST);
$_GET     = array_map_deep('sql_escape_string',  $_GET);
$_COOKIE  = array_map_deep('sql_escape_string',  $_COOKIE);
$_REQUEST = array_map_deep('sql_escape_string',  $_REQUEST);

//-----------------------------------------------------------
// 세션 선언 부분
//session_set_cookie_params(0, '/');
@session_name('mysession');
@ini_set("session.cookie_domain", ".majorworld.shop");
@session_start();

if( !isset($_SESSION['LogSessKey']) ){
    $_SESSION['LogSessKey'] = time()."_".rand(100,999);
}
//echo $_SESSION[LogSessKey];
//session_start();

//-----------------------------------------------------------
require_once 'application/libs/config.php';
require_once _LIB.'shop.extend.php';
require_once _LIB.'autoload.php';
require_once _LIB.'common.lib.php';

?>
