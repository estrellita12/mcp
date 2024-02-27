<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++."1", "검색 시작 일자");
$excel->setCellValue($pre++."1", "검색 종료 일자");
$excel->setCellValue($pre++."1", "가맹점"); 
$excel->setCellValue($pre++."1", "주문 건수"); 
$excel->setCellValue($pre++."1", "주문 갯수"); 
$excel->setCellValue($pre++."1", "상품 총액"); 
$excel->setCellValue($pre++."1", "포인트 총액"); 
$excel->setCellValue($pre++."1", "쿠폰 총액"); 
$excel->setCellValue($pre."1", "판매 총액"); 
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $_REQUEST['beg']);
    $excel->setCellValue($char++.$i, $_REQUEST['end']);
    $excel->setCellValue($char++.$i, $this->pt_li[row["pt_id"]] );
    $excel->setCellValue($char++.$i, $row["cnt"] );
    $excel->setCellValue($char++.$i, $row["sum_qty"] );
    $excel->setCellValue($char++.$i, $row["sum_goods_price"] );
    $excel->setCellValue($char++.$i, $row["sum_point"] );
    $excel->setCellValue($char++.$i, $row["sum_coupon"] );
    $excel->setCellValue($char++.$i, $row["sum_amount"] );
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('D:I')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(15);
$excel->getColumnDimension('B')->setWidth(15);
$excel->getColumnDimension('C')->setWidth(15);
$excel->getColumnDimension('D')->setWidth(15);
$excel->getColumnDimension('E')->setWidth(15);
$excel->getColumnDimension('F')->setWidth(15);
$excel->getColumnDimension('G')->setWidth(15);
$excel->getColumnDimension('H')->setWidth(15);
$excel->getColumnDimension('I')->setWidth(15);

$filename = '기간_주문_통계_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
