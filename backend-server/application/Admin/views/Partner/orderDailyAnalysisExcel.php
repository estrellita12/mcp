<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->mergeCells('A1:A2')->setCellValue('A1', '날짜');

$pre = 'B';
foreach($this->pt_li as $id=>$name){
    $first = $pre++;
    $second = $pre++;
    $third = $pre++;
    $excel->mergeCells($first.'1:'.$third.'1')->setCellValue($first.'1', $name);
    $excel->setCellValue($first."2", "주문건");
    $excel->setCellValue($second."2", "주문수량");
    $excel->setCellValue($third."2", "매출");
}
$pre = $third;
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle("B2:".$pre."2")->applyFromArray($thGrayStyle);

$i = 3;
foreach($this->rowAll as $row) {
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['dc_dt']);
    foreach($this->pt_li as $id=>$name){
        $excel->setCellValue($char++.$i, $row[$id."_count"] );
        $excel->setCellValue($char++.$i, $row[$id."_qty"] );
        $excel->setCellValue($char++.$i, $row[$id."_amount"] );
    }
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
    $i++;
}

$excel->getStyle('B:Z')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(23);

$char = "A";
$excel->setCellValue($char++.$i, $_REQUEST['beg']." ~ ".$_REQUEST['end']);
while(1){
    $excel->setCellValue($char.$i, "=SUM(".$char."3:".$char.$i.")" );
    if($char == $pre) break;
    $char++;
}

$excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);


$filename = '일별_주문_통계_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
