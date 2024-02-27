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
$excel->setCellValue($pre++.'1', '상품명');
$excel->setCellValue($pre++.'1', '판매갯수');
$excel->setCellValue($pre.'1', '주문건수');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_id']);
    $excel->setCellValue($char++.$i, $row['gs_name']);
    $excel->setCellValue($char++.$i, $row['sum_qty']);
    $excel->setCellValue($char++.$i, $row['od_cnt']);
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('C:E')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(75,"px");
$excel->getColumnDimension('B')->setWidth(385,"px");
$excel->getColumnDimension('C')->setWidth(75,"px");
$excel->getColumnDimension('D')->setWidth(75,"px");

$filename = '상품_통계__'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
