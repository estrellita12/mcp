<?php if(!defined('_INNER')) exit; ?>

<!DOCTYPE html>
<html lang="ko">
<head>
<title>관리자 페이지</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no,user-scalable=no,viewport-fit=cover">
<?php if( defined('_MWO') ){ ?>
<style>
    #hd{
        background-color:#5100ff !important;
    }
</style>
<?php } ?>
<link rel="stylesheet" type="text/css" href="/public/css/admin.css" />
<link rel="stylesheet" type="text/css" href="/public/css/select2.min.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="/public/js/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="/public/js/colResizable-1.6.js"></script>
<script src="/public/js/multi-select.js"></script>
<script src="/public/js/common.js"></script>
<script src="/public/js/script.js"></script>
<script src="/public/js/dragtable.js"></script>
<script src="/public/js/select2.min.js"></script>
<style>
    .message{
        background-color:#fafafa; 
        padding:15px 10px; 
        border-color:#dfdfdf; 
        border-style:dotted; 
        border-width:2px; 
        border-radius: 10px 10px 0px 10px;
    }
</style>
</head>
<body>


