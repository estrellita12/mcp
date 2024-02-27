<?php
require_once('../common.php');

session_unset();
session_destroy();
access("로그아웃 되었습니다.", _URL."/index.php");
die();

?>
