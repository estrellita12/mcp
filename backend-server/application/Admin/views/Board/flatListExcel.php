<?php

require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '페이지 제목')
      ->setCellValue($pre++.'1', '등록일시');

$i = 1;
foreach($this->flat->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['fl_title'])
          ->setCellValue($char++.$i, $row['fl_reg_dt']);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getColumnDimension('B')->setWidth(15);
$excel->getColumnDimension('C')->setWidth(20);
$excel->getColumnDimension('J')->setWidth(20);

$filename = '개별페이지_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
