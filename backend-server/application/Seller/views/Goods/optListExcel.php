<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '상품번호(ID)')
    ->setCellValue($pre++.'1', '상품명')
    ->setCellValue($pre++.'1', '진열')
    ->setCellValue($pre++.'1', '옵션번호(ID)')
    ->setCellValue($pre++.'1', '옵션바코드')
    ->setCellValue($pre++.'1', '옵션명')
    ->setCellValue($pre++.'1', '사용여부')
    ->setCellValue($pre++.'1', '재고')
    ->setCellValue($pre++.'1', '통보수량')
    ->setCellValue($pre++.'1', '등록일시')
    ->setCellValue($pre.'1', '수정일시');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->option->get($this->col,$this->search,true,$this->sql) as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_id'])
        ->setCellValue($char++.$i, $row['gs_name'] )
        ->setCellValue($char++.$i, $row['gs_isopen'] )
        ->setCellValue($char++.$i, $row['gs_opt_id'] )
        ->setCellValue($char++.$i, $row['gs_opt_code'] )
        ->setCellValue($char++.$i, $row['gs_opt_name'] )
        ->setCellValue($char++.$i, $row['gs_opt_use_yn'] )
        ->setCellValueExplicit($char++.$i ,$row['gs_opt_stock_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['gs_opt_stock_qty_noti'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['gs_opt_reg_dt'] )
        ->setCellValue($char.$i, $row['gs_opt_update_dt'] );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}
$excel->getStyle('H:J')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(85,'px'); 
$excel->getColumnDimension('B')->setWidth(100,'px'); 
$excel->getColumnDimension('C')->setWidth(100,'px'); 
$excel->getColumnDimension('D')->setWidth(150,'px'); 
$excel->getColumnDimension('E')->setWidth(150,'px'); 
$excel->getColumnDimension('F')->setWidth(80,'px'); 
$excel->getColumnDimension('G')->setWidth(80,'px'); 
$excel->getColumnDimension('H')->setWidth(80,'px'); 
$excel->getColumnDimension('I')->setWidth(80,'px'); 
$excel->getColumnDimension('J')->setWidth(80,'px'); 
$excel->getColumnDimension('K')->setWidth(80,'px'); 
$excel->getColumnDimension('L')->setWidth(150,'px'); 
$excel->getColumnDimension('M')->setWidth(150,'px'); 

$filename = '상품_옵션_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
