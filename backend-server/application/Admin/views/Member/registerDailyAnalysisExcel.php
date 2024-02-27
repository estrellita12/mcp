<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '날짜');
foreach($this->pt_li as $key=>$value){
    $excel->setCellValue($pre++.'1', $value);
}
$excel->setCellValue($pre.'1', '기타');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['dc_dt']);
    foreach($this->pt_li as $key=>$value){
        $excel->setCellValue($char++.$i, $row[$key] );
    }
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('B:Z')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(20);

$filename = '일별_가입_통계__'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
