<?php

// 어떠한 클래스를 가지고 객체를 생성하려고 할때, 
// 해당 함수가 동작하여 객체를 생성하고자 하는 클래스를 찾아 include 한다.
spl_autoload_register(function ($path) {
    // 확인을 위한 출력문
    //echo "autoload : ".$path." # ";
    $path = str_replace('\\','/',$path);
    $paths = explode('/', $path);

    // 확인을 위한 출력문
    //print_r($paths); echo "<br>";

    /*
    if (preg_match('/model/', strtolower($paths[1]))) {
        $classType = 'models';
    } else if (preg_match('/controller/',strtolower($paths[1]))) {
        $classType = 'controllers';
        if (preg_match('/admin/', strtolower($paths[2]))) {
            $classType = 'controllers/admin';
            $paths[2] = $paths[3];
        }
    } else {
        $classType = 'libs';
    }
    $className = $paths[2];
    $loadpath =  $paths[0].'/'.$classType.'/'.$className.'.php';
    */

    $loadpath = $path.".php";
    if (!file_exists($loadpath)) {
print_r($_SERVER);echo "asd";
        echo " --- autoload : file not found. ($loadpath) ";
        exit();
    }
    require_once $loadpath;
});

?>
