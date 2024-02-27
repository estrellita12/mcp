<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '상품번호(수정불가)')
      ->setCellValue($pre++.'1', '상품명(수정불가)')
      ->setCellValue($pre++.'1', '옵션번호(수정불가)')
      ->setCellValue($pre++.'1', '옵션바코드')
      ->setCellValue($pre++.'1', '옵션항목명')
      ->setCellValue($pre++.'1', '재고수량')
      ->setCellValue($pre++.'1', '통보수량')
      ->setCellValue($pre++.'1', '추가금액')
      ->setCellValue($pre++.'1', '옵션유형')
      ->setCellValue($pre++.'1', '정렬순서')
      ->setCellValue($pre.'1', '사용여부');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$pre = 'A';
$excel->setCellValue($pre++.'2', "▶ 수정 불가 항목입니다. \n▶ 수정시 다른 항목에 영향을 끼칠 수 있습니다.")
      ->setCellValue($pre++.'2', "▶ 수정 불가 항목입니다. \n▶ 수정시 다른 항목에 영향을 끼칠 수 있습니다.")
      ->setCellValue($pre++.'2', "▶ 수정 불가 항목입니다. \n▶ 수정시 다른 항목에 영향을 끼칠 수 있습니다.")
      ->setCellValue($pre++.'2', "▶ 영문자,숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 최대 60자까지 입력 가능합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 옵션 유형을 숫자로 입력합니다. \n필수옵션 : 1 \n추가옵션 : 2")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre.'2', "▶ 사용여부를 문자로 입력합니다. \n사용 : y \n미사용 : n");
$excel->getStyle("A2:".$pre."2")->applyFromArray($infoStyle);
$excel->getStyle("A2:".$pre."2")->getAlignment()->setWrapText(true);

$i = 2;
foreach($this->option->getList($this->col) as $row) {
    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['gs_id'])
          ->setCellValue($char++.$i, $row['gs_name'] )
          ->setCellValue($char++.$i, $row['gs_opt_id'] )
          ->setCellValue($char++.$i, $row['gs_opt_code'] )
          ->setCellValue($char++.$i, $row['gs_opt_name'] )
          ->setCellValue($char++.$i, $row['gs_opt_stock_qty'] )
          ->setCellValue($char++.$i, $row['gs_opt_stock_qty_noti'] )
          ->setCellValue($char++.$i, $row['gs_opt_add_price'] )
          ->setCellValue($char++.$i, $row['gs_opt_type'] )
          ->setCellValue($char++.$i, $row['gs_opt_orderby'] )
          ->setCellValue($char.$i, $row['gs_opt_use_yn'] );
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}
for($k='A'; $k != 'K'; $k++){
    $excel->getColumnDimension($k)->setWidth(150,'px'); 
}
$filename = '옵션_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
