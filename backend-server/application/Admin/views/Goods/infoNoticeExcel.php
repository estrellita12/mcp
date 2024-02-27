<?php
require_once _LIB.'goodsinfo.lib.php';

require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '분류코드')
    ->setCellValue($pre++.'1', '분류명')
    ->setCellValue($pre++.'1', '속성값1')
    ->setCellValue($pre++.'1', '속성값2')
    ->setCellValue($pre++.'1', '속성값3')
    ->setCellValue($pre++.'1', '속성값4')
    ->setCellValue($pre++.'1', '속성값5')
    ->setCellValue($pre++.'1', '속성값6')
    ->setCellValue($pre++.'1', '속성값7')
    ->setCellValue($pre++.'1', '속성값8')
    ->setCellValue($pre++.'1', '속성값9')
    ->setCellValue($pre++.'1', '속성값10')
    ->setCellValue($pre++.'1', '속성값11')
    ->setCellValue($pre++.'1', '속성값12')
    ->setCellValue($pre++.'1', '속성값13')
    ->setCellValue($pre++.'1', '속성값14')
    ->setCellValue($pre++.'1', '속성값15')
    ->setCellValue($pre++.'1', '속성값16')
    ->setCellValue($pre++.'1', '속성값17')
    ->setCellValue($pre++.'1', '속성값18')
    ->setCellValue($pre++.'1', '속성값19')
    ->setCellValue($pre++.'1', '속성값20')
    ->setCellValue($pre++.'1', '속성값21')
    ->setCellValue($pre++.'1', '속성값22')
    ->setCellValue($pre++.'1', '속성값23')
    ->setCellValue($pre++.'1', '속성값24')
    ->setCellValue($pre++.'1', '속성값25')
    ->setCellValue($pre++.'1', '속성값26')
    ->setCellValue($pre++.'1', '속성값27')
    ->setCellValue($pre++.'1', '속성값28')
    ->setCellValue($pre++.'1', '속성값29')
    ->setCellValue($pre++.'1', '속성값30')
    ->setCellValue($pre++.'1', '속성값31')
    ->setCellValue($pre++.'1', '속성값32')
    ->setCellValue($pre++.'1', '속성값33')
    ->setCellValue($pre++.'1', '속성값34')
    ->setCellValue($pre.'1', '속성값35');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($item_info as $type=>$row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $type);
    $excel->setCellValue($char++.$i, $row['title'] );
    foreach($row['article'] as $li){
        $excel->setCellValue($char++.$i, $li[0] );
    }
        
    $excel->setCellValue($char.$i, "" );
    $excel->getStyle("A$i:AK$i")->applyFromArray($tdStyle);
}

for($k='A'; $k != $pre; $k++){
    $excel->getColumnDimension($k)->setWidth(100,'px'); 
}

$filename = '정보고시표_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
