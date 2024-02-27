<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '공급사명')
    ->setCellValue($pre++.'1', '아이디')
    ->setCellValue($pre++.'1', '등급')
    ->setCellValue($pre++.'1', '승인상태')
    ->setCellValue($pre++.'1', '가입일시')
    ->setCellValue($pre++.'1', '승인일시')
    ->setCellValue($pre++.'1', '수수료 이율')
    ->setCellValue($pre++.'1', '은행 이름')
    ->setCellValue($pre++.'1', '은행 계좌번호')
    ->setCellValue($pre++.'1', '은행 예금주')
    ->setCellValue($pre++.'1', '담당자 이름')
    ->setCellValue($pre++.'1', '담당자 전화번호')
    ->setCellValue($pre++.'1', '담당자 메일')
    ->setCellValue($pre.'1', '담당자 기타 정보');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->seller->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $row['sl_manager'] = unserialize($row['sl_manager']);
    $excel->setCellValue($char++.$i, $row['sl_name'])
        ->setCellValue($char++.$i, $row['sl_id'])
        ->setCellValue($char++.$i, $this->gr_li[$row['sl_grade']] )
        ->setCellValue($char++.$i, $GLOBALS['sl_stt'][$row['sl_stt']] )
        ->setCellValue($char++.$i, $row['sl_reg_dt'])
        ->setCellValue($char++.$i, $row['sl_app_dt'])
        ->setCellValueExplicit($char++.$i ,$row['sl_pay_rate'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['sl_bank_name'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sl_bank_account'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sl_bank_holder'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sl_manager'][0],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sl_manager'][1],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sl_manager'][2],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$row['sl_manager'][3],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('G')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(10); 
$excel->getColumnDimension('B')->setWidth(10); 
$excel->getColumnDimension('C')->setWidth(10); 
$excel->getColumnDimension('D')->setWidth(15); 
$excel->getColumnDimension('E')->setWidth(20); 
$excel->getColumnDimension('F')->setWidth(20); 
$excel->getColumnDimension('G')->setWidth(15); 
$excel->getColumnDimension('H')->setWidth(15); 
$excel->getColumnDimension('I')->setWidth(15); 
$excel->getColumnDimension('J')->setWidth(15); 
$excel->getColumnDimension('K')->setWidth(15); 
$excel->getColumnDimension('L')->setWidth(15); 
$excel->getColumnDimension('M')->setWidth(15); 
$excel->getColumnDimension('N')->setWidth(15); 
$excel->getColumnDimension('N')->setWidth(15); 

$filename = '공급사_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
