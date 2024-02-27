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
    ->setCellValue($pre++.'1', '상품코드')
    ->setCellValue($pre++.'1', '판매자')
    ->setCellValue($pre++.'1', '대표카테고리')
    ->setCellValue($pre++.'1', '추가카테고리')
    ->setCellValue($pre++.'1', '추가카테고리')
    ->setCellValue($pre++.'1', '상품명')
    ->setCellValue($pre++.'1', '상품설명')
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
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->row as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_id'])
        ->setCellValue($char++.$i, $row['gs_code'] )
        ->setCellValue($char++.$i, $this->my['sl_name'] )
        ->setCellValue($char++.$i, $this->categoryModel->getNavStr(isset($row['gs_ctg'])?$row['gs_ctg']:"") )
        ->setCellValue($char++.$i, $this->categoryModel->getNavStr(isset($row['gs_ctg2'])?$row['gs_ctg2']:"") )
        ->setCellValue($char++.$i, $this->categoryModel->getNavStr(isset($row['gs_ctg3'])?$row['gs_ctg3']:"") )
        ->setCellValue($char++.$i, $row['gs_name'] )
        ->setCellValue($char++.$i, $row['gs_explan'] )
        ->setCellValue($char++.$i, $row['gs_keywords'] )
        ->setCellValue($char++.$i, $row['gs_model_nm'] )
        ->setCellValue($char++.$i, $row['gs_brand'] )
        ->setCellValue($char++.$i, $GLOBALS['gs_tax'][$row['gs_tax']] )
        ->setCellValue($char++.$i, $row['gs_origin'] )
        ->setCellValue($char++.$i, $row['gs_maker'] )
        ->setCellValue($char++.$i, $GLOBALS['gs_isopen'][$row['gs_isopen']] )
        ->setCellValueExplicit($char++.$i ,$row['gs_stock_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['gs_consumer_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['gs_supply_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['gs_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['gs_view_cnt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['gs_order_max_qty'] )
        ->setCellValue($char++.$i, $row['gs_order_min_qty'] )
        ->setCellValue($char++.$i, check_time($row['gs_sales_begin_dt'])?$row['gs_sales_begin_dt']:"" )
        ->setCellValue($char++.$i, check_time($row['gs_sales_end_dt'])?$row['gs_sales_end_dt']:"" )
        ->setCellValueExplicit($char++.$i ,$row['gs_buy_use_grade'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, '' )
        ->setCellValue($char++.$i, '' )
        ->setCellValue($char++.$i, '' )
        ->setCellValue($char++.$i, '' )
        ->setCellValue($char++.$i, $row['gs_simg1'] )
        ->setCellValue($char++.$i, $row['gs_simg2'] )
        ->setCellValue($char++.$i, $row['gs_simg3'] )
        ->setCellValueExplicit($char++.$i ,$row['gs_detail_content'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValue($char.$i, $row['gs_adm_memo'] );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}
$excel->getStyle('L:P')->getNumberFormat()->setFormatCode('#,##0');
$excel->getColumnDimension('A')->setWidth(85,'px'); 
$excel->getColumnDimension('B')->setWidth(100,'px'); 
$excel->getColumnDimension('C')->setWidth(100,'px'); 
$excel->getColumnDimension('D')->setWidth(100,'px'); 
$excel->getColumnDimension('E')->setWidth(100,'px'); 
$excel->getColumnDimension('F')->setWidth(100,'px'); 
$excel->getColumnDimension('G')->setWidth(300,'px'); 
$excel->getColumnDimension('H')->setWidth(200,'px'); 
$excel->getColumnDimension('I')->setWidth(150,'px'); 
$excel->getColumnDimension('J')->setWidth(100,'px'); 
$excel->getColumnDimension('K')->setWidth(100,'px'); 
$excel->getColumnDimension('L')->setWidth(100,'px'); 
$excel->getColumnDimension('M')->setWidth(100,'px'); 
$excel->getColumnDimension('N')->setWidth(100,'px'); 
$excel->getColumnDimension('O')->setWidth(100,'px'); 
$excel->getColumnDimension('P')->setWidth(100,'px'); 
$excel->getColumnDimension('Q')->setWidth(100,'px'); 
$excel->getColumnDimension('R')->setWidth(100,'px'); 
$excel->getColumnDimension('S')->setWidth(100,'px'); 
$excel->getColumnDimension('T')->setWidth(100,'px'); 
$excel->getColumnDimension('U')->setWidth(150,'px'); 
$excel->getColumnDimension('V')->setWidth(150,'px'); 
$excel->getColumnDimension('W')->setWidth(150,'px'); 
$excel->getColumnDimension('X')->setWidth(150,'px'); 
$excel->getColumnDimension('Y')->setWidth(100,'px'); 
$excel->getColumnDimension('Z')->setWidth(150,'px'); 
$excel->getColumnDimension('AA')->setWidth(150,'px'); 
$excel->getColumnDimension('AB')->setWidth(150,'px'); 
$excel->getColumnDimension('AC')->setWidth(150,'px'); 
$excel->getColumnDimension('AD')->setWidth(150,'px'); 
$excel->getColumnDimension('AE')->setWidth(150,'px'); 
$excel->getColumnDimension('AF')->setWidth(150,'px'); 
$excel->getColumnDimension('AG')->setWidth(150,'px'); 
$excel->getColumnDimension('AH')->setWidth(150,'px'); 

/*
for($k='A'; $k != $char; $k++)
    $excel->getColumnDimension($k)->setAutoSize(true);
*/
$filename = '상품_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
