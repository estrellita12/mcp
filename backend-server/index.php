<?php
define('_APPDIR', 'application/Admin/');
require_once $_SERVER['DOCUMENT_ROOT'].'/common.php';
// 객체 생성 요청시 해당 클래스에 대한 내용을 위에 정의한 함수에 의해 찾아낸다
new application\Admin\Route();
?>
