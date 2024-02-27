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
    ->setCellValue($pre++.'1', '순매출')
    ->setCellValue($pre.'1', '실결제액');

$i = 2;
foreach($this->rowAll as $row) 
{
    $char = 'A';
    $date = empty($_REQUEST['scDT_S']) && empty($_REQUEST['scDT_E']) ?"전체":$_REQUEST['scDT_S']." ~ ".$_REQUEST['scDT_E'];
    $excel->setCellValue($char++.$i, $this->partner->getName($row['pt_id']))
        ->setCellValue($char++.$i, $row['pt_id'] )
        ->setCellValueExplicit($char++.$i ,$date,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_cnt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['sum_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['use_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC );
    $i++;
}

$excel->setCellValue("A".$i, "총계");
for($k='D'; $k != 'H'; $k++)
{
    $excel->setCellValueExplicit($k.$i, "=SUM(".$k."2:".$k.($i-1).")", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('D:G')->getNumberFormat()->setFormatCode('#,##0');
for($k='A'; $k != $char; $k++)
    $excel->getColumnDimension($k)->setAutoSize(true);
    //$excel->getColumnDimension('A')->setWidth(10);

$filename = '가맹점_매출_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
