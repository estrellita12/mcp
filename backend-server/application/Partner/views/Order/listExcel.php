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
      ->setCellValue($pre++.'1', '공급사')
      ->setCellValue($pre++.'1', '상품번호')
      ->setCellValue($pre++.'1', '상품명')
      ->setCellValue($pre++.'1', '옵션번호')
      ->setCellValue($pre++.'1', '옵션명')
      ->setCellValue($pre++.'1', '주문수량')
      ->setCellValue($pre++.'1', '상품금액')
      ->setCellValue($pre++.'1', '배송비')
      ->setCellValue($pre++.'1', '도서산간지방배송비')
      ->setCellValue($pre++.'1', '포인트')
      ->setCellValue($pre++.'1', '쿠폰')
      ->setCellValue($pre++.'1', '실결제금액')
      ->setCellValue($pre++.'1', '주문상태')
      ->setCellValue($pre++.'1', '최종처리일시')
      ->setCellValue($pre++.'1', '결제/입금일시')
      ->setCellValue($pre++.'1', '취소완료일시')
      ->setCellValue($pre++.'1', '택배사')
      ->setCellValue($pre++.'1', '송장번호')
      ->setCellValue($pre++.'1', '배송일시')
      ->setCellValue($pre++.'1', '배송완료일시')
      ->setCellValue($pre++.'1', '교환완료일시')
      ->setCellValue($pre++.'1', '반품완료일시')
      ->setCellValue($pre++.'1', '구매확정여부')
      ->setCellValue($pre++.'1', '구매확정일시')
      ->setCellValue($pre.'1', '가맹점');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->order->getList($this->col) as $row) {
    $row['od_goods_info'] = unserialize($row['od_goods_info']);

    $i++;
    $char = 'A';
    $excel->setCellValueExplicit($char++.$i, $row['od_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $this->sl_li[$row['sl_id']], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['gs_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_goods_info']['gs_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['gs_opt_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_goods_info']['gs_opt_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_qty'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_goods_price'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_charge'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_charge_dosan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_use_point'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_use_coupon'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_amount'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $GLOBALS['od_stt'][$row['od_stt']]['title'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_rcent_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_pay_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_cancel_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_company'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_invoice_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_change_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_return_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_confirm_yn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_confirm_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValue($char.$i, $this->pt_li[$row['pt_id']] );
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}

$excel->getStyle('I:O')->getNumberFormat()->setFormatCode('#,##0');

$excel->getColumnDimension('A')->setWidth(130,'px');
$excel->getColumnDimension('B')->setWidth(130,'px');
$excel->getColumnDimension('C')->setWidth(130,'px');
$excel->getColumnDimension('D')->setWidth(130,'px');
$excel->getColumnDimension('E')->setWidth(130,'px');
$excel->getColumnDimension('F')->setWidth(130,'px');
$excel->getColumnDimension('G')->setWidth(130,'px');
$excel->getColumnDimension('H')->setWidth(80,'px');
$excel->getColumnDimension('I')->setWidth(80,'px');
$excel->getColumnDimension('J')->setWidth(80,'px');
$excel->getColumnDimension('K')->setWidth(80,'px');
$excel->getColumnDimension('L')->setWidth(80,'px');
$excel->getColumnDimension('M')->setWidth(80,'px');
$excel->getColumnDimension('N')->setWidth(80,'px');
$excel->getColumnDimension('O')->setWidth(80,'px');
$excel->getColumnDimension('P')->setWidth(100,'px');
$excel->getColumnDimension('Q')->setWidth(130,'px');

$filename = '주문_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
