<?php
ini_set("memory_limit",-1);

require_once '/var/www/html/my-custom-platform/backend-server/application/libs/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '판매자ID')
      ->setCellValue($pre++.'1', '회원ID')
      ->setCellValue($pre++.'1', '주문번호')
      ->setCellValue($pre++.'1', '일련번호')
      ->setCellValue($pre++.'1', '상품코드')
      ->setCellValue($pre++.'1', '상품명')
      ->setCellValue($pre++.'1', '옵션')
      ->setCellValue($pre++.'1', '공급가')
      ->setCellValue($pre++.'1', '판매가')
      ->setCellValue($pre++.'1', '수량')
      ->setCellValue($pre++.'1', '쿠폰할인')
      ->setCellValue($pre++.'1', '포인트결제')
      ->setCellValue($pre++.'1', '배송비')
      ->setCellValue($pre++.'1', '실결제금액')
      ->setCellValue($pre++.'1', '총주문금액')
      ->setCellValue($pre++.'1', '결제방법')
      ->setCellValue($pre++.'1', '주문상태')
      ->setCellValue($pre++.'1', '주문채널')
      ->setCellValue($pre++.'1', '주문자명')
      ->setCellValue($pre++.'1', '수취인명')
      ->setCellValue($pre++.'1', '수취인전화번호')
      ->setCellValue($pre++.'1', '수취인핸드폰')
      ->setCellValue($pre++.'1', '수취인우편번호')
      ->setCellValue($pre++.'1', '수취인주소')
      ->setCellValue($pre++.'1', '주문시요청사항')
      ->setCellValue($pre++.'1', '배송회사')
      ->setCellValue($pre++.'1', '운송장번호')
      ->setCellValue($pre++.'1', '입금자명')
      ->setCellValue($pre++.'1', '입금일시')
      ->setCellValue($pre++.'1', '주문일시')
      ->setCellValue($pre++.'1', '거래증빙')
      ->setCellValue($pre++.'1', '세금계산서(상호명)')
      ->setCellValue($pre++.'1', '세금계산서(대표자)')
      ->setCellValue($pre++.'1', '세금계산서(사업자등록번호)')
      ->setCellValue($pre++.'1', '세금계산서(사업장주소)')
      ->setCellValue($pre++.'1', '세금계산서(업태)')
      ->setCellValue($pre++.'1', '세금계산서(종목)')
      ->setCellValue($pre++.'1', '현금영수증(사업자 지출증빙용)')
      ->setCellValue($pre++.'1', '현금영수증(개인 소득공제용)')
      ->setCellValue($pre.'1', '관리자메모');

$i = 1;
foreach($rowAll as $row) {
    $row['od_goods_info'] = json_decode($row['od_goods_info'],true);
    $addr = $row['receiver_addr1']." ".$row['receiver_addr2']." ". $row['receiver_addr3'];
    $i++;
    $char = 'A';
    $excel->setCellValueExplicit($char++.$i, $row['sl_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['mb_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_goods_info']['goodsCode'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_goods_info']['goodsName'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_goods_info']['optionName'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_supply_price'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_goods_price'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_qty'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_use_coupon'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_use_point'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_charge']+$row['od_delivery_charge_dosan'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_amount'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_amount'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
          ->setCellValueExplicit($char++.$i, $row['od_paymethod'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $GLOBALS['od_stt'][$row['od_stt']]['title'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "PC", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['orderer_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_cellphone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_cellphone'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_zip'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $addr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['receiver_delivery_msg'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_company'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_delivery_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['orderer_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_pay_approved_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['od_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, "", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValue($char.$i, $row['od_adm_memo'] );
}

$filename = '주문_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
