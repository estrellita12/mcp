<?php
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre= 'A';
$excel->setCellValue($pre++.'1', '가맹점명')
    ->setCellValue($pre++.'1', '아이디')
    ->setCellValue($pre++.'1', '판매상품금액')
    ->setCellValue($pre++.'1', '사용된 포인트 금액')
    ->setCellValue($pre++.'1', '사용된 쿠폰 금액')
    ->setCellValue($pre.'1', '수수료 금액');

$i = 1;
foreach($this->pay->getList($this->col,"excel") as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $this->pt_li[$row['pt_id']])
        ->setCellValue($char++.$i, $row['pt_id'])
        ->setCellValueExplicit($char++.$i ,$row['goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_point'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['commission'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC );
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('C:F')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(10); 
for($k='A'; $k != $char; $k++) 
    $excel->getColumnDimension($k)->setAutoSize(true);


$filename = '가맹점_수수료_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
