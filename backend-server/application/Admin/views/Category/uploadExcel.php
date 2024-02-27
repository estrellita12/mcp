<?php
/*
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
try{
    //$inputFileName = $_FILES['bulkExcel']['name'];
    $inputFileName = $_FILES['bulkExcel']['tmp_name'];
    $reader = new Xlsx();
    $spreadsheet = $reader->load($inputFileName);
    $sheetData = $spreadsheet-> getActiveSheet()->toArray();
    //$sheetData = $spreadsheet->getSheet(0)->toArray(null, true, true, true);
    foreach($sheetData as $data){
        print_r($data);
        echo "<br>";
    }
}catch(Exception $e){
    echo "실패";
    var_dump($e);exit; //데이터값 출력 확인
}
*/
?>
