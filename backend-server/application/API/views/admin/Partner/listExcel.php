<?php
global $pt_state;

require_once _LIB.'/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '가맹점명')
    ->setCellValue($pre++.'1', '아이디')
    ->setCellValue($pre++.'1', '가맹점 도메인')
    ->setCellValue($pre++.'1', '등급')
    ->setCellValue($pre++.'1', '가입일시')
    ->setCellValue($pre++.'1', '승인일시')
    ->setCellValue($pre++.'1', '승인상태')
    ->setCellValue($pre++.'1', '수수료 이율')
    ->setCellValue($pre++.'1', '은행 이름')
    ->setCellValue($pre++.'1', '은행 계좌번호')
    ->setCellValue($pre++.'1', '은행 예금주')
    ->setCellValue($pre++.'1', '담당자 이름')
    ->setCellValue($pre++.'1', '담당자 전화번호')
    ->setCellValue($pre.'1', '담당자 이메일');

$i = 1;
foreach($this->partner->getList("*","excel") as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['name'])
        ->setCellValue($char++.$i, $row['id'])
        ->setCellValue($char++.$i, $row['shop_url'])
        ->setCellValue($char++.$i, $this->gr_li[$row['grade']] )
        ->setCellValue($char++.$i, $row['reg_date'])
        ->setCellValue($char++.$i, $row['app_date'])
        ->setCellValue($char++.$i, $pt_state[$row['state']] )
        ->setCellValueExplicit($char++.$i ,$row['pay_rate'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['bank_name'])
        ->setCellValueExplicit($char++.$i ,$row['bank_account'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValue($char++.$i, $row['bank_holder'])
        ->setCellValue($char++.$i, $row['manager_name'])
        ->setCellValueExplicit($char++.$i ,$row['manager_cellphone'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValue($char++.$i, $row['manager_email']);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('H')->getNumberFormat()->setFormatCode('#,##0');
for($k='A'; $k != $char; $k++)
    $excel->getColumnDimension($k)->setAutoSize(true);
    //$excel->getColumnDimension('A')->setWidth(10); 

$filename = '가맹점_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
