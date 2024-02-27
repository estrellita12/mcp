<?php

// 어떠한 클래스를 가지고 객체를 생성하려고 할때, 
// 해당 함수가 동작하여 객체를 생성하고자 하는 클래스를 찾아 include 한다.
spl_autoload_register(function ($path) {
    // 확인을 위한 출력문
    //echo "autoload : ".$path." # ";
    $path = str_replace('\\','/',$path);
    $paths = explode('/', $path);

    $loadpath = $path.".php";
    if (!file_exists($loadpath)) {
print_r($_SERVER);echo "asd";
        echo " --- autoload : file not found. ($loadpath) ";
        exit();
    }
    require_once $loadpath;
});

?>
