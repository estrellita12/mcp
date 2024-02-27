<?php
global $pt_state;
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre= 'A';
$excel->setCellValue($pre++.'1', '가맹점명')
    ->setCellValue($pre++.'1', '아이디')
    ->setCellValue($pre++.'1', '처리 시간')
    ->setCellValue($pre++.'1', '주문상태')
    ->setCellValue($pre++.'1', '주문번호')
    ->setCellValue($pre++.'1', '일련번호')
    ->setCellValue($pre++.'1', '상품금액')
    ->setCellValue($pre++.'1', '포인트금액')
    ->setCellValue($pre++.'1', '쿠폰금액')
    ->setCellValue($pre++.'1', '실결제금액')
    ->setCellValue($pre++.'1', '수수료')
    ->setCellValue($pre.'1', '수수료 내용');

$i = 2;
foreach($this->pay->getList($this->col,"excel") as $row) 
{
    $char = 'A';
    $excel->setCellValue($char++.$i,$this->pt_li[$row['pt_id']])
        ->setCellValue($char++.$i, $row['pt_id'] )
        ->setCellValue($char++.$i, $row['pay_time'])
        ->setCellValue($char++.$i, $pt_state[$row['status']])
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_point'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['commission'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['memo']);
    $i++;
}

$excel->setCellValue("A".$i, "총계");
for($k='G'; $k != 'L'; $k++)
{
    $excel->setCellValueExplicit($k.$i, "=SUM(".$k."2:".$k.($i-1).")", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('G:K')->getNumberFormat()->setFormatCode('#,##0');
for($k='A'; $k != $char; $k++)
    $excel->getColumnDimension($k)->setAutoSize(true);
    //$excel->getColumnDimension('A')->setWidth(10); 

$pt_name = $this->pt_li[$_REQUEST['shp']];
$filename = $pt_name.'_수수료_상세_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
