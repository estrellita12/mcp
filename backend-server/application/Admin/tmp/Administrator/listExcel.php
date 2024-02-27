<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '관리자명')
      ->setCellValue($pre++.'1', '아이디')
      ->setCellValue($pre++.'1', '등급')
      ->setCellValue($pre++.'1', '이메일')
      ->setCellValue($pre++.'1', '전화번호')
      ->setCellValue($pre++.'1', '기타정보')
      ->setCellValue($pre++.'1', '상태')
      ->setCellValue($pre++.'1', '로그인횟수')
      ->setCellValue($pre++.'1', '가입일시')
      ->setCellValue($pre++.'1', '마지막 로그인 일시')
      ->setCellValue($pre.'1', '마지막 로그인 IP');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->administrator->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['adm_name'])
          ->setCellValue($char++.$i, $row['adm_id'])
          ->setCellValue($char++.$i, $this->gr_li[$row['adm_grade']] )
          ->setCellValue($char++.$i, $row['adm_email'])
          ->setCellValueExplicit($char++.$i, $row['adm_cellphone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValue($char++.$i, $row['adm_other_info'])
          ->setCellValue($char++.$i, $GLOBALS['adm_stt'][$row['adm_stt']])
          ->setCellValueExplicit($char++.$i, $row['adm_login_cnt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValue($char++.$i, $row['adm_reg_dt'])
          ->setCellValue($char++.$i, $row['adm_last_login_dt'])
          ->setCellValue($char.$i, $row['adm_last_login_ip']);
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('H:H')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(15);
$excel->getColumnDimension('B')->setWidth(20);
$excel->getColumnDimension('C')->setWidth(15);
$excel->getColumnDimension('D')->setWidth(20);
$excel->getColumnDimension('E')->setWidth(20);
$excel->getColumnDimension('F')->setWidth(20);
$excel->getColumnDimension('G')->setWidth(20);
$excel->getColumnDimension('H')->setWidth(20);
$excel->getColumnDimension('I')->setWidth(20);
$excel->getColumnDimension('J')->setWidth(20);
$excel->getColumnDimension('K')->setWidth(20);

$filename = '관리자_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
die;
?>
