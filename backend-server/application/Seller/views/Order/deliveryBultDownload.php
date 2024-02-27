<?php
ini_set("memory_limit",-1);

require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '주문일시')
      ->setCellValue($pre++.'1', '주문번호')
      ->setCellValue($pre++.'1', '주문일련번호')
      ->setCellValue($pre++.'1', '상품코드')
      ->setCellValue($pre++.'1', '주문상품명')
      ->setCellValue($pre++.'1', '옵션코드')
      ->setCellValue($pre++.'1', '주문옵션명')
      ->setCellValue($pre++.'1', '수량')
      ->setCellValue($pre++.'1', '상품공급가')
      ->setCellValue($pre++.'1', '수령자')
      ->setCellValue($pre++.'1', '수령자 전화번호')
      ->setCellValue($pre++.'1', '수령자 우편번호')
      ->setCellValue($pre++.'1', '수령자 주소')
      ->setCellValue($pre++.'1', '수령자 배송메세지')
      ->setCellValue($pre++.'1', '택배사'.chr(10).'택배사 코드 ')
      ->setCellValue($pre.'1', '송장번호');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$pre = 'A';
$delivery = "▶ 택배사코드\n";
foreach($this->config['cf_delivery_company'] as $key=>$dv){
    $delivery .= "[".$key."] ";
    $delivery .= $dv['company'];
    $delivery .= "\n";
}

$excel->setCellValue($pre++.'2', '▶ 주문일시(수정불가)')
      ->setCellValue($pre++.'2', '▶ 주문번호(수정불가)')
      ->setCellValue($pre++.'2', '▶ 주문일련번호(수정불가)')
      ->setCellValue($pre++.'2', '▶ 상품코드(수정불가)')
      ->setCellValue($pre++.'2', '▶ 주문상품명(수정불가)')
      ->setCellValue($pre++.'2', '▶ 옵션코드(수정불가)')
      ->setCellValue($pre++.'2', '▶ 주문옵션명(수정불가)')
      ->setCellValue($pre++.'2', '▶ 수량(수정불가)')
      ->setCellValue($pre++.'2', '▶ 상품공급가(수정불가)')
      ->setCellValue($pre++.'2', '▶ 수령자(수정불가)')
      ->setCellValue($pre++.'2', '▶ 수령자 전화번호(수정불가)')
      ->setCellValue($pre++.'2', '▶ 수령자 우편번호(수정불가)')
      ->setCellValue($pre++.'2', '▶ 수령자 주소(수정불가)')
      ->setCellValue($pre++.'2', '▶ 수령자 배송메세지(수정불가)')
      ->setCellValue($pre++.'2', $delivery)
      ->setCellValue($pre.'2', '▶ 송장번호');
$excel->getStyle("A2:".$pre."2")->applyFromArray($infoStyle);
$excel->getStyle("A2:".$pre."2")->getAlignment()->setWrapText(true); // 줄바꿈 허용

$i = 2;
foreach($this->row as $row) {
    $gs = json_decode($row['od_goods_info'],true);
    $i++;
    $char = 'A';
    $addr = $row['receiver_addr1']." ".$row['receiver_addr2']." ".$row['receiver_addr3'];
    $excel->setCellValueExplicit($char++.$i, $row['od_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['gs_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $gs['goodsName'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['gs_opt_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $gs['optionName'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_qty'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_supply_price'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['receiver_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_cellphone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_zip'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $addr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_delivery_msg'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_company'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char.$i, $row['od_delivery_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('H:I')->getNumberFormat()->setFormatCode('#,##0');

$excel->getColumnDimension('A')->setWidth(25);
$excel->getColumnDimension('B')->setWidth(25);
$excel->getColumnDimension('C')->setWidth(25);
$excel->getColumnDimension('D')->setWidth(15);
$excel->getColumnDimension('E')->setWidth(25);
$excel->getColumnDimension('F')->setWidth(15);
$excel->getColumnDimension('G')->setWidth(25);
$excel->getColumnDimension('H')->setWidth(15);
$excel->getColumnDimension('I')->setWidth(15);
$excel->getColumnDimension('J')->setWidth(15);
$excel->getColumnDimension('K')->setWidth(25);
$excel->getColumnDimension('L')->setWidth(15);
$excel->getColumnDimension('M')->setWidth(25);
$excel->getColumnDimension('N')->setWidth(20);
$excel->getColumnDimension('O')->setWidth(20);
$excel->getColumnDimension('P')->setWidth(30);

$filename = '송장_일괄_등록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
