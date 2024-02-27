<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$excel->mergeCells('A1:L1')->setCellValue('A1', $this->my['pt_name']." 정산 상세 내역");
$excel->getStyle("A1:L1")->applyFromArray($hStyle);

$pre= 'A';
$excel->mergeCells('A2:L2')->setCellValue('A2', " 기간 : ".$_REQUEST['beg']." ~ ".$_REQUEST['end']);
$excel->getStyle("A2:L2")->applyFromArray($pStyle);

$pre= 'A';
$excel->setCellValue($pre++.'3', '가맹점')
    ->setCellValue($pre++.'3', '공급사')
    ->setCellValue($pre++.'3', '주문일시')
    ->setCellValue($pre++.'3', '주문번호')
    ->setCellValue($pre++.'3', '주문일련번호')
    ->setCellValue($pre++.'3', '상품명')
    ->setCellValue($pre++.'3', '총 상품 금액')
    ->setCellValue($pre++.'3', '포인트 금액(-)')
    ->setCellValue($pre++.'3', '쿠폰 금액(-)')
    ->setCellValue($pre++.'3', '실 정산 금액')
    ->setCellValue($pre++.'3', '최종 처리 일시')
    ->setCellValue($pre.'3', '정산 상태');
$excel->getStyle("A3:".$pre."3")->applyFromArray($thStyle);

$pay_price = 0;         // 매출 합계
$pay_commission = 0;    // 기본 정산 수수료 합계
$pay_cancel_commission = 0; // 차감 정산 수수료 합계

$i = 4;
foreach($this->cancelList as $row) {
    $gs = json_decode($row['od_goods_info'],true);
    $cancel_commission = (($row['od_goods_price'] * $this->my['pt_pay_rate']) / 100) - $row['od_use_point'] - $row['od_use_coupon'];
    $cancel_commission *= -1;
    $pay_cancel_commission += $cancel_commission;

    $char = 'A';
    $excel->setCellValue($char++.$i,$this->my['pt_name'])
        ->setCellValue($char++.$i, $this->sl_li[$row['sl_id']] )
        ->setCellValueExplicit($char++.$i ,$row['od_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$gs['goodsName'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_goods_price'] * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_point'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$cancel_commission,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_rcent_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$GLOBALS['pay_stt'][$row['partner_pay_stt']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($cancelStyle);
    $i++;
}

foreach($this->orderList as $row) {
    $gs = json_decode($row['od_goods_info'],true);
    $commission = (($row['od_goods_price'] * $this->my['pt_pay_rate']) / 100) - $row['od_use_point'] - $row['od_use_coupon'];
    $pay_commission += $commission;

    $char = 'A';
    $excel->setCellValue($char++.$i,$this->my['pt_name'])
        ->setCellValue($char++.$i, $this->sl_li[$row['sl_id']] )
        ->setCellValueExplicit($char++.$i ,$row['od_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$gs['goodsName'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_point'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$commission,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_rcent_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$GLOBALS['pay_stt'][$row['partner_pay_stt']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
    $i++;
}

$excel->getStyle('G:J')->getNumberFormat()->setFormatCode('#,##0');

$excel->getColumnDimension('A')->setWidth(100,'px'); 
$excel->getColumnDimension('B')->setWidth(100,'px'); 
$excel->getColumnDimension('C')->setWidth(140,'px'); 
$excel->getColumnDimension('D')->setWidth(18); 
$excel->getColumnDimension('E')->setWidth(15); 
$excel->getColumnDimension('F')->setWidth(15); 
$excel->getColumnDimension('G')->setWidth(13); 
$excel->getColumnDimension('H')->setWidth(13); 
$excel->getColumnDimension('I')->setWidth(13); 
$excel->getColumnDimension('J')->setWidth(13); 
$excel->getColumnDimension('K')->setWidth(20); 
$excel->getColumnDimension('L')->setWidth(15); 
$excel->getColumnDimension('M')->setWidth(5); 
$excel->getColumnDimension('N')->setWidth(20); 
$excel->getColumnDimension('O')->setWidth(15); 

$excel->setCellValue('N3', "(+)수수료 총액");
$excel->setCellValue('N4', "(-)차감 정산 금액");
$excel->setCellValue('N5', "지불 예정 수수료");
$excel->setCellValue('O3', $pay_commission);
$excel->setCellValue('O4', $pay_cancel_commission);
$excel->setCellValue('O5', $pay_commission-$pay_cancel_commission+$pay_delivery);
$excel->getStyle("N3:N5")->applyFromArray($thStyle);
$excel->getStyle("O3:O5")->applyFromArray($tdStyle);
$excel->getStyle('O')->getNumberFormat()->setFormatCode('#,##0');

$filename = $this->my['pt_name'].'_정산_상세_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
