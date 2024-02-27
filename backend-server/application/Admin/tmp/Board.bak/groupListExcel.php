<?php

require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '그룹아이디')
      ->setCellValue($pre++.'1', '그룹명')
      ->setCellValue($pre.'1', '등록일시');

$i = 1;
foreach($this->board_group->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['bogr_id'])
          ->setCellValue($char++.$i, $row['bogr_name'])
          ->setCellValue($char++.$i, $row['bogr_reg_dt']);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getColumnDimension('A')->setWidth(15);
$excel->getColumnDimension('B')->setWidth(15);
$excel->getColumnDimension('C')->setWidth(20);

$filename = '게시판_그룹_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
