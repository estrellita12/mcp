<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '카테고리 코드')
      ->setCellValue($pre++.'1', '카테고리')
      ->setCellValue($pre.'1', '카테고리명');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->rowAll as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValueExplicit($char++.$i, $row['ctg_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $this->category->getNavStr($row['ctg_id']), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char.$i, $row['ctg_title'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );

    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$excel->getColumnDimension('A')->setWidth(150,'px');
$excel->getColumnDimension('B')->setWidth(300,'px');
$excel->getColumnDimension('C')->setWidth(150,'px');

$filename = '카테고리_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
