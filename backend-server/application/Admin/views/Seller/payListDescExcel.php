<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$excel->mergeCells('A1:L1')->setCellValue('A1', $this->row['sl_name']." 정산 상세 내역");
$excel->getStyle("A1:L1")->applyFromArray($hStyle);

$pre= 'A';
$excel->mergeCells('A2:L2')->setCellValue('A2', " 기간 : ".$this->row['beg']." ~ ".$this->row['end']);
$excel->getStyle("A2:L2")->applyFromArray($pStyle);

$pre= 'A';
$excel->setCellValue($pre++.'3', '공급사명')
    ->setCellValue($pre++.'3', '아이디')
    ->setCellValue($pre++.'3', '주문일시')
    ->setCellValue($pre++.'3', '주문번호')
    ->setCellValue($pre++.'3', '주문일련번호')
    ->setCellValue($pre++.'3', '상품명')
    ->setCellValue($pre++.'3', '공급가액')
    ->setCellValue($pre++.'3', '교환/반품 배송비')
    ->setCellValue($pre++.'3', '결제 방법')
    ->setCellValue($pre++.'3', '주문 상태')
    ->setCellValue($pre++.'3', '최종 처리 일시')
    ->setCellValue($pre.'3', '정산 상태');
$excel->getStyle("A3:".$pre."3")->applyFromArray($thStyle);

$pay_price = 0;         // 매출 합계
$pay_commission = 0;    // 기본 정산 수수료 합계
$pay_delivery = 0;    // 교환/반품 배송비 합계
$pay_cancel_commission = 0; // 차감 정산 수수료 합계

$i = 4;
foreach($this->cancelList as $row) {
    $gs = json_decode($row['od_goods_info'],true);
    $pay_cancel_commission += $row['od_supply_price'];
    $pay_delivery += $row['od_change_delivery_charge'];
    $pay_delivery += $row['od_return_delivery_charge'];

    $char = 'A';
    $excel->setCellValue($char++.$i,$this->row['sl_name'])
        ->setCellValue($char++.$i, $row['sl_id'] )
        ->setCellValueExplicit($char++.$i ,$row['od_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$gs['goodsName'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_supply_price'] * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_change_delivery_charge']+$row['od_return_delivery_charge'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['paymethod'][$row['od_paymethod']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['od_stt'][$row['od_stt']]['title'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_rcent_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$GLOBALS['pay_stt'][$row['seller_pay_stt']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($cancelStyle);
    $i++;
}

foreach($this->deliveryList as $row) 
{
    $gs = json_decode($row['od_goods_info'],true);
    $pay_delivery += $row['od_change_delivery_charge'];
    $pay_delivery += $row['od_return_delivery_charge'];

    $char = 'A';
    $excel->setCellValue($char++.$i,$this->row['sl_name'])
        ->setCellValue($char++.$i, $row['sl_id'] )
        ->setCellValueExplicit($char++.$i, $row['od_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i, $row['od_no'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i, $row['od_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i, $gs['goodsName'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i, 0, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i, $row['od_change_delivery_charge']+$row['od_return_delivery_charge'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['paymethod'][$row['od_paymethod']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i, $GLOBALS['od_stt'][$row['od_stt']]['title'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i, $row['od_rcent_dt'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i, $GLOBALS['pay_stt'][$row['seller_pay_stt']], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($cancelStyle);
    $i++;
}

foreach($this->orderList as $row) {
    $gs = json_decode($row['od_goods_info'],true);
    $pay_commission += $row['od_supply_price'];
    $pay_delivery += $row['od_change_delivery_charge'];
    $pay_delivery += $row['od_return_delivery_charge'];

    $char = 'A';
    $excel->setCellValue($char++.$i,$this->row['sl_name'])
        ->setCellValue($char++.$i, $row['sl_id'] )
        ->setCellValueExplicit($char++.$i ,$row['od_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$gs['goodsName'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_supply_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_change_delivery_charge']+$row['od_return_delivery_charge'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['paymethod'][$row['od_paymethod']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['od_stt'][$row['od_stt']]['title'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_rcent_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$GLOBALS['pay_stt'][$row['seller_pay_stt']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
    $i++;
}

$excel->getStyle('G:I')->getNumberFormat()->setFormatCode('#,##0');

$excel->getColumnDimension('A')->setWidth(10); 
$excel->getColumnDimension('B')->setWidth(10); 
$excel->getColumnDimension('C')->setWidth(17); 
$excel->getColumnDimension('D')->setWidth(18); 
$excel->getColumnDimension('E')->setWidth(15); 
$excel->getColumnDimension('F')->setWidth(15); 
$excel->getColumnDimension('G')->setWidth(13); 
$excel->getColumnDimension('H')->setWidth(13); 
$excel->getColumnDimension('I')->setWidth(17); 
$excel->getColumnDimension('J')->setWidth(13); 
$excel->getColumnDimension('K')->setWidth(13); 
$excel->getColumnDimension('L')->setWidth(17); 
$excel->getColumnDimension('M')->setWidth(5); 
$excel->getColumnDimension('N')->setWidth(20); 
$excel->getColumnDimension('O')->setWidth(15); 

$excel->setCellValue('N3', "(+)공급가 총액");
$excel->setCellValue('N4', "(-)차감 정산 금액");
$excel->setCellValue('N5', "(+)교환 반품 배송비");
$excel->setCellValue('N6', "지불 예정 수수료");
$excel->setCellValue('O3', $pay_commission);
$excel->setCellValue('O4', $pay_cancel_commission);
$excel->setCellValue('O5', $pay_delivery);
$excel->setCellValue('O6', $pay_commission-$pay_cancel_commission+$pay_delivery);
$excel->getStyle("N3:N6")->applyFromArray($thStyle);
$excel->getStyle("O3:O6")->applyFromArray($tdStyle);
$excel->getStyle('O')->getNumberFormat()->setFormatCode('#,##0');

$filename = $this->row['sl_name'].'_정산_상세_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
