<?php
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '회원명')
      ->setCellValue($pre++.'1', '아이디')
      ->setCellValue($pre++.'1', '등급')
      ->setCellValue($pre++.'1', '가맹점')
      ->setCellValue($pre++.'1', '전화번호')
      ->setCellValue($pre++.'1', 'SMS 수신 여부')
      ->setCellValue($pre++.'1', '이메일')
      ->setCellValue($pre++.'1', '메일 수신 여부')
      ->setCellValue($pre++.'1', '우편번호')
      ->setCellValue($pre++.'1', '기본 주소')
      ->setCellValue($pre++.'1', '상세 주소')
      ->setCellValue($pre++.'1', '참고 항목')
      ->setCellValue($pre++.'1', '가입일시')
      ->setCellValue($pre++.'1', '마지막 로그인 일시')
      ->setCellValue($pre++.'1', '마지락 로그인 IP')
      ->setCellValue($pre++.'1', '로그인 횟수')
      ->setCellValue($pre++.'1', '구매 횟수')
      ->setCellValue($pre.'1', '포인트');

$i = 1;
foreach($this->member->getList($this->col,'excel' ) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['name'])
          ->setCellValue($char++.$i, $row['id'])
          ->setCellValue($char++.$i, $this->gr_li[$row['grade']] )
          ->setCellValue($char++.$i, $this->pt_li[$row['pt_id']] )
          ->setCellValueExplicit($char++.$i, $row['cellphone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValue($char++.$i, $row['smsser'])
          ->setCellValue($char++.$i, $row['email'])
          ->setCellValue($char++.$i, $row['emailser'])
          ->setCellValue($char++.$i, $row['zip'])
          ->setCellValue($char++.$i, $row['addr1'])
          ->setCellValue($char++.$i, $row['addr2'])
          ->setCellValue($char++.$i, $row['addr3'])
          ->setCellValue($char++.$i, $row['reg_date'])
          ->setCellValue($char++.$i, $row['last_login_date'])
          ->setCellValue($char++.$i, $row['last_login_ip'])
          ->setCellValue($char++.$i, $row['login_sum'])
          ->setCellValueExplicit($char++.$i, "0", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['point'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC );
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('P:R')->getNumberFormat()->setFormatCode('#,##0');
for($k='A'; $k != $char; $k++)
    $excel->getColumnDimension($k)->setAutoSize(true);

$filename = '회원_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
