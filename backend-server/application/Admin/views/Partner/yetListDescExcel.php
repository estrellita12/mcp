<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$excel->mergeCells('A1:M1')->setCellValue('A1', $this->pt['pt_name']." 정산 상세 내역");
$excel->getStyle("A1:M1")->applyFromArray($hStyle);

$pre= 'A';
$excel->mergeCells('A2:M2')->setCellValue('A2', " 기간 : ".$_REQUEST['beg']." ~ ".$_REQUEST['end']);
$excel->getStyle("A2:M2")->applyFromArray($pStyle);

$pre= 'A';
$excel->setCellValue($pre++.'3', '가맹점명')
    ->setCellValue($pre++.'3', '아이디')
    ->setCellValue($pre++.'3', '주문일시')
    ->setCellValue($pre++.'3', '주문번호')
    ->setCellValue($pre++.'3', '상품별주문번호')
    ->setCellValue($pre++.'3', '상품명')
    ->setCellValue($pre++.'3', '주문 수량')
    ->setCellValue($pre++.'3', '총 상품 금액')
    ->setCellValue($pre++.'3', '수수료(%)')
    ->setCellValue($pre++.'3', '상품 정산 금액')
    ->setCellValue($pre++.'3', '포인트 금액(-)')
    ->setCellValue($pre++.'3', '쿠폰 금액(-)')
    ->setCellValue($pre++.'3', '실 정산 금액')
    ->setCellValue($pre++.'3', '주문 상태')
    ->setCellValue($pre++.'3', '배송비')
    ->setCellValue($pre++.'3', '실 결제 금액')
    ->setCellValue($pre++.'3', '결제 방법')
    ->setCellValue($pre++.'3', '최종 처리 일시')
    ->setCellValue($pre.'3', '정산 상태');
$excel->getStyle("A3:M3")->applyFromArray($thStyle);
$excel->getStyle("N3:".$pre."3")->applyFromArray($thGrayStyle);

$pay_price = 0;         // 매출 합계
$pay_commission = 0;    // 기본 정산 수수료 합계
$pay_point = 0;         // 포인트 합계
$pay_coupon = 0;        // 쿠폰 합계
$pay_cancel_commission = 0; // 차감 정산 수수료 합계

$i = 4;
foreach($this->cancelList as $row) 
{
    $gs = json_decode($row['od_goods_info'],true);
    $commission = (($row['od_goods_price']*$this->pt['pt_pay_rate'])/100);
    $partner_pay_commission = $commission - $row['od_use_point'] - $row['od_use_coupon'];
    $pay_cancel_commission += $partner_pay_commission;
    $char = 'A';
    $excel->setCellValue($char++.$i,$this->pt['pt_name'])
        ->setCellValue($char++.$i, $row['pt_id'] )
        ->setCellValueExplicit($char++.$i ,$row['od_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$gs['goodsName'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_goods_price'] * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$this->pt['pt_pay_rate'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$commission * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_point'] * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_coupon'] * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$partner_pay_commission * -1,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['od_stt'][$row['od_stt']]['title'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_delivery_charge']+$row['od_delivery_charge_dosan'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_amount'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['paymethod'][$row['od_paymethod']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_rcent_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$GLOBALS['pay_stt'][$row['partner_pay_stt']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($cancelStyle);
    $i++;
}


foreach($this->orderList as $row) 
{
    $gs = json_decode($row['od_goods_info'],true);
    $commission = (($row['od_goods_price']*$this->pt['pt_pay_rate'])/100);
    $pay_price += $row['od_goods_price'];
    $pay_point += $row['od_use_point'];
    $pay_coupon += $row['od_use_coupon'];
    $pay_commission += $commission;

    $char = 'A';
    $excel->setCellValue($char++.$i,$this->pt['pt_name'])
        ->setCellValue($char++.$i, $row['pt_id'] )
        ->setCellValueExplicit($char++.$i ,$row['od_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_no'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_id'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$gs['goodsName'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_qty'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_goods_price'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$this->pt['pt_pay_rate'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$commission,   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_point'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$commission + $row['od_use_point'] + $row['od_use_coupon'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['od_stt'][$row['od_stt']]['title'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_delivery_charge']+$row['od_delivery_charge_dosan'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$row['od_amount'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValueExplicit($char++.$i ,$GLOBALS['paymethod'][$row['od_paymethod']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char++.$i ,$row['od_rcent_dt'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
        ->setCellValueExplicit($char.$i ,$GLOBALS['pay_stt'][$row['partner_pay_stt']],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
    $i++;
}
$excel->getStyle('G:M')->getNumberFormat()->setFormatCode('#,##0');
$excel->getStyle('O:P')->getNumberFormat()->setFormatCode('#,##0');

$excel->getColumnDimension('A')->setWidth(10); 
$excel->getColumnDimension('B')->setWidth(10); 
$excel->getColumnDimension('C')->setWidth(15); 
$excel->getColumnDimension('D')->setWidth(17); 
$excel->getColumnDimension('E')->setWidth(17); 
$excel->getColumnDimension('F')->setWidth(15); 
$excel->getColumnDimension('G')->setWidth(10); 
$excel->getColumnDimension('H')->setWidth(13); 
$excel->getColumnDimension('I')->setWidth(13); 
$excel->getColumnDimension('J')->setWidth(13); 
$excel->getColumnDimension('K')->setWidth(13); 
$excel->getColumnDimension('L')->setWidth(10); 
$excel->getColumnDimension('M')->setWidth(13); 
$excel->getColumnDimension('N')->setWidth(13); 
$excel->getColumnDimension('O')->setWidth(10); 
$excel->getColumnDimension('P')->setWidth(15); 
$excel->getColumnDimension('Q')->setWidth(13); 
$excel->getColumnDimension('R')->setWidth(14); 
$excel->getColumnDimension('S')->setWidth(14); 
$excel->getColumnDimension('T')->setWidth(2); 
$excel->getColumnDimension('U')->setWidth(20); 
$excel->getColumnDimension('V')->setWidth(15); 

$excel->setCellValue('U3', "매출합계");
$excel->setCellValue('U4', "주문 정산 수수료");
$excel->setCellValue('U5', "(-) 포인트");
$excel->setCellValue('U6', "(-) 쿠폰");
$excel->setCellValue('U7', "(-) 차감 정산 수수료");
$excel->setCellValue('U8', "실 정산 지금액");
$excel->setCellValue('V3', $pay_price);
$excel->setCellValue('V4', $pay_commission);
$excel->setCellValue('V5', $pay_point);
$excel->setCellValue('V6', $pay_coupon);
$excel->setCellValue('V7', $pay_cancel_commission);
$excel->setCellValue('V8', $pay_commission-$pay_point-$pay_coupon-$pay_cancel_commission);
$excel->getStyle("U3:U8")->applyFromArray($thStyle);
$excel->getStyle("V3:V8")->applyFromArray($tdStyle);
$excel->getStyle('V')->getNumberFormat()->setFormatCode('#,##0');

$filename = $this->pt['pt_name'].'_정산_상세_내역_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
