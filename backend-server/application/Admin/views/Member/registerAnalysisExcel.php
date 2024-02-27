<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '검색 시작 일자');
$excel->setCellValue($pre++.'1', '검색 종료 일자');
$excel->setCellValue($pre++.'1', '가맹점');
$excel->setCellValue($pre++.'1', '소셜 로그인');
$excel->setCellValue($pre++.'1', '일반 회원가입');
$excel->setCellValue($pre.'1', '총 가입자수');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $_REQUEST['beg']);
    $excel->setCellValue($char++.$i, $_REQUEST['end']);
    $excel->setCellValue($char++.$i, $this->pt_li[$row['pt_id']] );
    $excel->setCellValue($char++.$i, $row['sns_reg_cnt'] );
    $excel->setCellValue($char++.$i, ($row['reg_cnt']-$row['sns_reg_cnt']) );
    $excel->setCellValue($char.$i, $row['reg_cnt'] );
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('E:F')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(20);
$excel->getColumnDimension('B')->setWidth(20);
$excel->getColumnDimension('C')->setWidth(20);
$excel->getColumnDimension('D')->setWidth(20);
$excel->getColumnDimension('E')->setWidth(20);
$excel->getColumnDimension('F')->setWidth(20);

$filename = '기간_가입_통계__'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
