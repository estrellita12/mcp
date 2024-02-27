<?php
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '가맹점명')
    ->setCellValue($pre++.'1', '아이디')
    ->setCellValue($pre++.'1', '기간')
    ->setCellValue($pre++.'1', '주문건수')
    ->setCellValue($pre++.'1', '주문수량')
    ->setCellValue($pre++.'1', '판매가격')
    ->setCellValue($pre++.'1', '배송비')
    ->setCellValue($pre++.'1', '포인트')
    ->setCellValue($pre++.'1', '쿠폰')
    ->setCellValue($pre++.'1', '매출')
    ->setCellValue($pre.'1', '실결제액');

$i = 2;
foreach($this->rowAll as $row) 
{
    $char = 'A';
    $excel->setCellValue($char++.$i, $this->partner->getName($row['pt_id']))
        ->setCellValue($char++.$i, $row['pt_id'] )
        ->setCellValue($char++.$i, $row['date_msg'] )
        ->setCellValueExplicit($char++.$i ,$row['od_cnt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['sum_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['baesong_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_point'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,($row['goods_price']+$row['baesong_price']),   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC );
    $i++;
}

$excel->setCellValue("A".$i, "총계");
for($k='D'; $k != $char; $k++)
{
    $excel->setCellValueExplicit($k.$i, "=SUM(".$k."2:".$k.($i-1).")", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('D:K')->getNumberFormat()->setFormatCode('#,##0');
for($k='A'; $k != $char; $k++)
    $excel->getColumnDimension($k)->setAutoSize(true);
    //$excel->getColumnDimension('A')->setWidth(10);

$pt_name = $this->partner->getName($_REQUEST['scPT']);
$filename = $pt_name.'_매출_상세_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
