<?php
define('_INNER',"mirae");
date_default_timezone_set('Asia/Seoul');
$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
define('_HOST',$_SERVER['HTTP_HOST']);              // 도메인 naver.com
define('_URL',$http.$_SERVER['HTTP_HOST']);         // 도메인 http://naver.com
define('_SCRIPT_URI', $_SERVER['SCRIPT_URI']);      // 도메인을 제외한 URI
define('_SCRIPT_URL', $_SERVER['SCRIPT_URL']);      // 도메인을 포함한 URL
define('_SELF', $_SERVER['PHP_SELF']);              // 도메인과 넘겨지는 값 제외한 URL
define('_REQUEST_URI', $_SERVER['REQUEST_URI']);    // 도메인 제외한 URL
define('_PRE_URL', isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"");       // 이전 페이지 주소값
define('_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('_GUEST', $_SERVER['REMOTE_ADDR']);          // 사용자 IP

if( _HOST == "admin.mwo.co.kr" ||  _HOST == "seller.mwo.co.kr" ){
    define('_MWO',"mwo");
}

define('_APP', 'application/');
define('_MODEL', 'application/models/');
define('_LIB', 'application/libs/');
define('_CONTROLLER', _APPDIR.'controllers/');
define('_VIEW', _APPDIR.'views/');

define('_PUBLIC','/public/');
define('_IMG',_PUBLIC.'img/');
define('_ICON',_PUBLIC.'img/icon/');
define('_CSS',_PUBLIC.'css/');
define('_JS',_PUBLIC.'js/');
if( defined('_MWO') ){
    define('_DATA','/public/mwo/data/');
}else{
    define('_DATA',_PUBLIC.'data/');
}
define('_BANNER',_DATA.'banner/');
define('_PLAN',_DATA.'plan/');
define('_COUPON',_DATA.'coupon/');
define('_MEDIA',_DATA.'media/');
define('_LOGO',_DATA.'logo/');
define('_GOODS',_DATA.'goods/');
define('_MEMBER',_DATA.'member/');
define('_BOARD',_DATA.'board/');
define('_POST',_DATA.'post/');
define('_FILE',_DATA.'file/');

define('_LOG',_ROOT.'/log/');
define('_DATA_PERMOSSION','755');
define('_UPLOAD_PERMISSION','707');

define('_THEME',"/public/views/theme/");

define('_DBTYPE', 'mysql');
define('_DBHOST', 'localhost');
if( defined('_MWO') ){
    define('_DBNAME', 'mwo');
    define('_DBUSER', 'mwo');
    define('_DBPASSWORD', 'major0131!!');
}else{
    define('_DBNAME', 'custom');
    define('_DBUSER', 'custom');
    define('_DBPASSWORD', 'major0102!!');
}
define('_CHARSET', 'utf8');

define('_SERVER_TIME',    time());
define('_ORDER_NO',    date("ymdHis", _SERVER_TIME));
define('_DATE_YMD', date("Y-m-d", _SERVER_TIME) );
define('_DATE_YMD_OD', date("Y-m-d", strtotime("-14 day")) );
define('_DATE_YMDHIS', date("Y-m-d H:i:s", _SERVER_TIME) );
define('_DATE_YMDHIS_TMR', date("Y-m-d H:i:s", strtotime("+1 days")) );

define('_BEGIN_DATE', "1970-01-01 00:00:00");
define('_END_DATE', "3000-01-01 00:00:00");

?>
