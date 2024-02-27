<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '상품 문의 번호')
    ->setCellValue($pre++.'1', '상품 번호(ID)')
    ->setCellValue($pre++.'1', '공급사')
    ->setCellValue($pre++.'1', '작성자')
    ->setCellValue($pre++.'1', '이메일')
    ->setCellValue($pre++.'1', '이메일 회신 여부')
    ->setCellValue($pre++.'1', '전화번호')
    ->setCellValue($pre++.'1', '전화번호 회신 여부')
    ->setCellValue($pre++.'1', '문의 유형')
    ->setCellValue($pre++.'1', '제목')
    ->setCellValue($pre++.'1', '내용')
    ->setCellValue($pre++.'1', '비밀글 여부')
    ->setCellValue($pre++.'1', '답변')
    ->setCellValue($pre++.'1', '답변 여부')
    ->setCellValue($pre++.'1', '숨김 여부')
    ->setCellValue($pre++.'1', '가맹점')
    ->setCellValue($pre++.'1', '작성 일시')
    ->setCellValue($pre.'1', '답변 일시');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->qa->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_qa_id'])
        ->setCellValue($char++.$i, $row['gs_id'] )
        ->setCellValue($char++.$i, $this->sl_li[$row['gs_qa_sl_id']] )
        ->setCellValue($char++.$i, $row['mb_id'] )
        ->setCellValue($char++.$i, $row['gs_qa_writer_email'] )
        ->setCellValue($char++.$i, $row['gs_qa_email_notice_yn'] )
        ->setCellValue($char++.$i, $row['gs_qa_writer_cellphone'] )
        ->setCellValue($char++.$i, $row['gs_qa_email_cellphone_yn'] )
        ->setCellValue($char++.$i, $GLOBALS['qa_type'][$row['gs_qa_type']] )
        ->setCellValue($char++.$i, $row['gs_qa_title'] )
        ->setCellValue($char++.$i, $row['gs_qa_content'] )
        ->setCellValue($char++.$i, $row['gs_qa_secret_yn'] )
        ->setCellValue($char++.$i, $row['gs_qa_answer'] )
        ->setCellValue($char++.$i, $row['gs_qa_answer_yn'] )
        ->setCellValue($char++.$i, $row['gs_qa_hidden_yn'] )
        ->setCellValue($char++.$i, $this->pt_li[$row['gs_qa_pt_id']] )
        ->setCellValue($char++.$i, $row['gs_qa_reg_dt'] )
        ->setCellValue($char.$i, $row['gs_qa_answer_dt'] );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$excel->getColumnDimension('A')->setWidth(100,'px'); 
$excel->getColumnDimension('B')->setWidth(100,'px'); 
$excel->getColumnDimension('C')->setWidth(100,'px'); 
$excel->getColumnDimension('D')->setWidth(80,'px'); 
$excel->getColumnDimension('E')->setWidth(100,'px'); 
$excel->getColumnDimension('F')->setWidth(80,'px'); 
$excel->getColumnDimension('G')->setWidth(100,'px'); 
$excel->getColumnDimension('H')->setWidth(80,'px'); 
$excel->getColumnDimension('I')->setWidth(100,'px'); 
$excel->getColumnDimension('J')->setWidth(200,'px'); 
$excel->getColumnDimension('K')->setWidth(200,'px'); 
$excel->getColumnDimension('L')->setWidth(100,'px'); 
$excel->getColumnDimension('M')->setWidth(100,'px'); 
$excel->getColumnDimension('N')->setWidth(80,'px'); 
$excel->getColumnDimension('O')->setWidth(80,'px'); 
$excel->getColumnDimension('P')->setWidth(100,'px'); 
$excel->getColumnDimension('Q')->setWidth(130,'px'); 
$excel->getColumnDimension('R')->setWidth(130,'px'); 

$filename = '상품_문의_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
