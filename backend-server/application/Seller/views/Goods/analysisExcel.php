<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '상품번호');
$excel->setCellValue($pre++.'1', '상품이름');
$excel->setCellValue($pre++.'1', '주문건수');
$excel->setCellValue($pre.'1', '주문수량');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_id']);
    $excel->setCellValue($char++.$i, $row['gs_name']);
    $excel->setCellValue($char++.$i, $row['od_cnt']);
    $excel->setCellValue($char.$i, $row['sum_qty']);
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('c:D')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(100,"px");
$excel->getColumnDimension('B')->setWidth(200,"px");
$excel->getColumnDimension('C')->setWidth(100,"px");
$excel->getColumnDimension('D')->setWidth(100,"px");

$filename = '상품_판매_통계_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
