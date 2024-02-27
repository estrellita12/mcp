<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '상품 후기 번호')
    ->setCellValue($pre++.'1', '상품 번호(ID)')
    ->setCellValue($pre++.'1', '공급사')
    ->setCellValue($pre++.'1', '작성자')
    ->setCellValue($pre++.'1', '별점')
    ->setCellValue($pre++.'1', '후기 내용')
    ->setCellValue($pre++.'1', '후기 댓글')
    ->setCellValue($pre++.'1', '가맹점')
    ->setCellValue($pre.'1', '등록 일시');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->review->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_rv_id'])
        ->setCellValue($char++.$i, $row['gs_id'] )
        ->setCellValue($char++.$i, $this->sl_li[$row['gs_rv_sl_id']] )
        ->setCellValue($char++.$i, $row['mb_id'] )
        ->setCellValue($char++.$i, $row['gs_rv_star_rating'] )
        ->setCellValue($char++.$i, $row['gs_rv_content'] )
        ->setCellValue($char++.$i, $row['gs_rv_reply'] )
        ->setCellValue($char++.$i, $this->pt_li[$row['gs_rv_pt_id']] )
        ->setCellValue($char.$i, $row['gs_rv_reg_dt'] );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$excel->getColumnDimension('A')->setWidth(100,'px'); 
$excel->getColumnDimension('B')->setWidth(100,'px'); 
$excel->getColumnDimension('C')->setWidth(100,'px'); 
$excel->getColumnDimension('D')->setWidth(100,'px'); 
$excel->getColumnDimension('E')->setWidth(80,'px'); 
$excel->getColumnDimension('F')->setWidth(200,'px'); 
$excel->getColumnDimension('G')->setWidth(100,'px'); 
$excel->getColumnDimension('H')->setWidth(100,'px'); 
$excel->getColumnDimension('I')->setWidth(130,'px'); 

$filename = '상품_후기_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
