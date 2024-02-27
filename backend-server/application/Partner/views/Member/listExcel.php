<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '회원명')
      ->setCellValue($pre++.'1', '아이디')
      ->setCellValue($pre++.'1', '승인여부')
      ->setCellValue($pre++.'1', '차단여부')
      ->setCellValue($pre++.'1', '등급')
      ->setCellValue($pre++.'1', '생년월일')
      ->setCellValue($pre++.'1', '성별')
      ->setCellValue($pre++.'1', '이메일')
      ->setCellValue($pre++.'1', '전화번호')
      ->setCellValue($pre++.'1', '메일 수신 여부')
      ->setCellValue($pre++.'1', 'SMS 수신 여부')
      ->setCellValue($pre++.'1', '우편번호')
      ->setCellValue($pre++.'1', '기본 주소')
      ->setCellValue($pre++.'1', '상세 주소')
      ->setCellValue($pre++.'1', '참고 항목')
      ->setCellValue($pre++.'1', '가입일시')
      ->setCellValue($pre++.'1', '마지막 로그인 일시')
      ->setCellValue($pre++.'1', '마지막 로그인 IP')
      ->setCellValue($pre++.'1', '로그인 횟수')
      ->setCellValue($pre++.'1', '포인트')
      ->setCellValue($pre.'1', '관리자 메모');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['mb_name'])
          ->setCellValue($char++.$i, $row['mb_id'])
          ->setCellValue($char++.$i, $GLOBALS['mb_stt'][$row['mb_stt']])
          ->setCellValue($char++.$i, $row['mb_block_yn'])
          ->setCellValue($char++.$i, $this->gr_li[$row['mb_grade']] )
          ->setCellValue($char++.$i, empty($row['mb_birth'])?"":$row['mb_birth'])
          ->setCellValue($char++.$i, empty($row['mb_gender'])?"":$row['mb_gender'])
          ->setCellValue($char++.$i, $row['mb_email'])
          ->setCellValueExplicit($char++.$i, $row['mb_cellphone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValue($char++.$i, $row['mb_emailser_yn'])
          ->setCellValue($char++.$i, $row['mb_smsser_yn'])
          ->setCellValue($char++.$i, $row['mb_zip'])
          ->setCellValue($char++.$i, $row['mb_addr1'])
          ->setCellValue($char++.$i, $row['mb_addr2'])
          ->setCellValue($char++.$i, $row['mb_addr3'])
          ->setCellValue($char++.$i, $row['mb_reg_dt'])
          ->setCellValue($char++.$i, $row['mb_last_login_dt'])
          ->setCellValue($char++.$i, $row['mb_last_login_ip'])
          ->setCellValueExplicit($char++.$i, $row['mb_login_cnt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['mb_point'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValue($char.$i, $row['mb_adm_memo']);
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('T:U')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(15);
$excel->getColumnDimension('B')->setWidth(20);
$excel->getColumnDimension('C')->setWidth(15);
$excel->getColumnDimension('D')->setWidth(10);
$excel->getColumnDimension('E')->setWidth(10);
$excel->getColumnDimension('F')->setWidth(10);
$excel->getColumnDimension('G')->setWidth(15);
$excel->getColumnDimension('H')->setWidth(10);
$excel->getColumnDimension('Q')->setWidth(20);
$excel->getColumnDimension('R')->setWidth(20);
$excel->getColumnDimension('S')->setWidth(20);
$excel->getColumnDimension('V')->setWidth(20);

$filename = '회원_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
