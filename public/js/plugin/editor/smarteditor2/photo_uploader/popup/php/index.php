<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

 /*
include_once("./_common.php");
@include_once("./JSON.php");

if( !function_exists('json_encode') ) {
    function json_encode($data) {
        $json = new Services_JSON();
        return( $json->encode($data) );
    }
}

@ini_set('gd.jpeg_ignore_warning', 1);

$ym = date('ym', _SERVER_TIME);

$data_dir = _DATA.'/editor/'.$ym.'/';
$data_url = _DATA.'/editor/'.$ym.'/';
echo $data_dir;
@mkdir($data_dir, _DIR_PERMISSION);
@chmod($data_dir, _DIR_PERMISSION);
*/


$ym = date('ym', time());
$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
$data_dir = '../../../../../../../../public/data/editor/quick/'.$ym;
$data_url = $http.$_SERVER['HTTP_HOST'].'/public/data/editor/quick/'.$ym;

@mkdir($data_dir);
@chmod($data_dir, 0777);

require('UploadHandler.php');

$options = array(
    'upload_dir' => $data_dir,
    'upload_url' => $data_url,
    // This option will disable creating thumbnail images and will not create that extra folder.
    // However, due to this, the images preview will not be displayed after upload
    'image_versions' => array()
);

$upload_handler = new UploadHandler($options);
