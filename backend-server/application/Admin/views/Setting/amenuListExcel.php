<?php
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '번호')
      ->setCellValue($pre++.'1', '최상단 메뉴')
      ->setCellValue($pre++.'1', '상위 메뉴')
      ->setCellValue($pre++.'1', '메뉴 아이디')
      ->setCellValue($pre++.'1', '메뉴 이름')
      ->setCellValue($pre++.'1', '메뉴 URL')
      ->setCellValue($pre++.'1', '메뉴 등급')
      ->setCellValue($pre++.'1', '사용 여부')
      ->setCellValue($pre.'1', '순서');

$i = 1;
foreach($this->amenu->getList($this->col) as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValueExplicit($char++.$i, $row['idx'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['tab'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['upper'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['code'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['url'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['show_grade'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['use_yn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['orderby'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC );
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getColumnDimension('A')->setWidth(10);
$excel->getColumnDimension('B')->setWidth(15);
$excel->getColumnDimension('C')->setWidth(15);
$excel->getColumnDimension('D')->setWidth(10);
$excel->getColumnDimension('E')->setWidth(30);
$excel->getColumnDimension('F')->setWidth(30);
$excel->getColumnDimension('G')->setWidth(10);
$excel->getColumnDimension('H')->setWidth(10);
$excel->getColumnDimension('I')->setWidth(10);

$filename = '관리자_메뉴_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
