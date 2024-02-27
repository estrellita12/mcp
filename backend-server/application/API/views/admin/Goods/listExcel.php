<?php
require_once _LIB.'/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '상품번호')
    ->setCellValue($pre++.'1', '판매자')
    ->setCellValue($pre++.'1', '카테고리')
    ->setCellValue($pre++.'1', '상품명')
    ->setCellValue($pre++.'1', '검색키워드')
    ->setCellValue($pre++.'1', '모델명')
    ->setCellValue($pre++.'1', '브랜드')
    ->setCellValue($pre++.'1', '과세설정')
    ->setCellValue($pre++.'1', '원산지')
    ->setCellValue($pre++.'1', '제조사')
    ->setCellValue($pre++.'1', '진열상태')
    ->setCellValue($pre++.'1', '재고')
    ->setCellValue($pre++.'1', '시중가')
    ->setCellValue($pre++.'1', '공급가')
    ->setCellValue($pre++.'1', '판매가')
    ->setCellValue($pre++.'1', '조회수')
    ->setCellValue($pre++.'1', '최소주문수량')
    ->setCellValue($pre++.'1', '최대주문수량')
    ->setCellValue($pre++.'1', '판매기간 시작일')
    ->setCellValue($pre++.'1', '판매기간 종료일')
    ->setCellValue($pre++.'1', '구매가능등급')
    ->setCellValue($pre++.'1', '배송비유형')
    ->setCellValue($pre++.'1', '배송비결제')
    ->setCellValue($pre++.'1', '기본배송비')
    ->setCellValue($pre++.'1', '조건배송비')
    ->setCellValue($pre++.'1', '이미지1')
    ->setCellValue($pre++.'1', '이미지2')
    ->setCellValue($pre++.'1', '이미지3')
    ->setCellValue($pre++.'1', '상세설명')
    ->setCellValue($pre.'1', '메모');

$i = 1;
foreach($this->goods->getList($this->column,"excel") as $row) 
{
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['idx'])
        ->setCellValue($char++.$i, $this->sl_li[$row['sl_id']] )
        ->setCellValue($char++.$i, $row['ca_id'] )
        ->setCellValue($char++.$i, $row['gname'] )
        ->setCellValue($char++.$i, $row['keywords'] )
        ->setCellValue($char++.$i, $row['model'] )
        ->setCellValue($char++.$i, $row['brand_nm'] )
        ->setCellValue($char++.$i, $row['notax'] )
        ->setCellValue($char++.$i, $row['origin'] )
        ->setCellValue($char++.$i, $row['maker'] )
        ->setCellValue($char++.$i, $GLOBALS['gs_isopen'][$row['isopen']] )
        ->setCellValueExplicit($char++.$i ,$row['stock_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['normal_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['supply_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['readcount'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['odr_min'] )
        ->setCellValue($char++.$i, $row['odr_max'] )
        ->setCellValue($char++.$i, $row['sb_date'] )
        ->setCellValue($char++.$i, $row['eb_date'] )
        ->setCellValueExplicit($char++.$i ,$row['buy_level'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['sc_type'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sc_method'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sc_amt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['sc_minimum'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['simg1'] )
        ->setCellValue($char++.$i, $row['simg2'] )
        ->setCellValue($char++.$i, $row['simg3'] )
        ->setCellValueExplicit($char++.$i ,$row['memo'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValue($char++.$i, $row['admin_memo'] );
}
require_once _LIB.'/excel.style.php';
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);
$excel->getStyle('L:P')->getNumberFormat()->setFormatCode('#,##0');
for($k='A'; $k != $char; $k++)
    if($k=='AC'){$excel->getColumnDimension('AC')->setWidth(30);continue;}
    $excel->getColumnDimension($k)->setAutoSize(true);

$filename = '상품_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
