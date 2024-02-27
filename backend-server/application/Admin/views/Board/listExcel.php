<?php

require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '아이디')
      ->setCellValue($pre++.'1', '게시판 제목')
      ->setCellValue($pre++.'1', '그룹')
      ->setCellValue($pre++.'1', '스킨')
      ->setCellValue($pre++.'1', '목록')
      ->setCellValue($pre++.'1', '읽기')
      ->setCellValue($pre++.'1', '쓰기')
      ->setCellValue($pre++.'1', '답글')
      ->setCellValue($pre++.'1', '코멘트')
      ->setCellValue($pre.'1', '등록일시');

$i = 1;
foreach($this->board->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['idx'])
          ->setCellValue($char++.$i, $row['bo_name'])
          ->setCellValue($char++.$i, $this->bogr_li[$row['bogr_id']])
          ->setCellValue($char++.$i, $row['bo_skin'])
          ->setCellValue($char++.$i, $this->gr_li[$row['bo_list_perm']] ? : '권한없음')
          ->setCellValue($char++.$i, $this->gr_li[$row['bo_read_perm']] ? : '권한없음')
          ->setCellValue($char++.$i, $this->gr_li[$row['bo_write_perm']] ? : '권한없음')
          ->setCellValue($char++.$i, $this->gr_li[$row['bo_reply_perm']] ? : '권한없음')
          ->setCellValue($char++.$i, $this->gr_li[$row['bo_comment_perm']] ? : '권한없음')
          ->setCellValue($char++.$i, $row['bo_reg_dt']);
}

require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getColumnDimension('B')->setWidth(15);
$excel->getColumnDimension('C')->setWidth(20);
$excel->getColumnDimension('J')->setWidth(20);

$filename = '게시판_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
