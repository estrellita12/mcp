<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '가맹점명')
    ->setCellValue($pre++.'1', '아이디')
    ->setCellValue($pre++.'1', 'SSO여부')
    ->setCellValue($pre++.'1', '가격정책등급')
    ->setCellValue($pre++.'1', '상태')
    ->setCellValue($pre++.'1', '가입 일시')
    ->setCellValue($pre++.'1', '승인 일시')
    ->setCellValue($pre++.'1', '수수료')
    ->setCellValue($pre++.'1', '정산 계좌 은행')
    ->setCellValue($pre++.'1', '정산 계좌 번호')
    ->setCellValue($pre++.'1', '정산 계좌 예금주')
    ->setCellValue($pre++.'1', '담당자 이름')
    ->setCellValue($pre++.'1', '담당자 전화번호')
    ->setCellValue($pre++.'1', '담당자 메일주소')
    ->setCellValue($pre++.'1', '담당자 기타정보')
    ->setCellValue($pre++.'1', '쇼핑몰 도메인')
    ->setCellValue($pre++.'1', '브라우저타이틀')
    ->setCellValue($pre++.'1', '사업자유형')
    ->setCellValue($pre++.'1', '회사이름')
    ->setCellValue($pre++.'1', '대표자이름')
    ->setCellValue($pre++.'1', '사업자 등록 번호')
    ->setCellValue($pre++.'1', '통신 판매업 신고 번호')
    ->setCellValue($pre++.'1', '업태')
    ->setCellValue($pre++.'1', '종목')
    ->setCellValue($pre++.'1', '회사 전화 번호')
    ->setCellValue($pre++.'1', '회사 팩스 번호')
    ->setCellValue($pre++.'1', '회사 메일 주소')
    ->setCellValue($pre++.'1', '정보 책임자 이름')
    ->setCellValue($pre++.'1', '정보 책임자 메일')
   ->setCellValue($pre++.'1', '마지막 로그인 일자')
    ->setCellValue($pre++.'1', '마지막 로그인 IP')
    ->setCellValue($pre.'1', '관리자 메모');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$i = 1;
foreach($this->partner->getList($this->col) as $row) 
{
    $row['pt_bank_info'] = unserialize($row['pt_bank_info']);
    $row['pt_manager'] = unserialize($row['pt_manager']);
    $row['shop_info_manager'] = unserialize($row['shop_info_manager']);
    $row['shop_customer_service_info'] = unserialize($row['shop_customer_service_info']);

    $i++;
    $char = 'A';
    $excel->setCellValue($char++.$i, $row['pt_name'])
        ->setCellValue($char++.$i, $row['pt_id'])
        ->setCellValue($char++.$i, $row['pt_sso_yn'])
        ->setCellValue($char++.$i, $this->gr_li[$row['pt_grade']] )
        ->setCellValue($char++.$i, $GLOBALS['pt_stt'][$row['pt_stt']] )
        ->setCellValue($char++.$i, $row['pt_reg_dt'])
        ->setCellValue($char++.$i, $row['pt_app_dt'])
        ->setCellValueExplicit($char++.$i ,$row['pt_pay_rate'],   \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC )
        ->setCellValue($char++.$i, $row['pt_bank_info'][0])
        ->setCellValue($char++.$i, $row['pt_bank_info'][1])
        ->setCellValue($char++.$i, $row['pt_bank_info'][2])
        ->setCellValue($char++.$i, $row['pt_manager'][0])
        ->setCellValue($char++.$i, $row['pt_manager'][1])
        ->setCellValue($char++.$i, $row['pt_manager'][2])
        ->setCellValue($char++.$i, $row['pt_manager'][3])
        ->setCellValue($char++.$i, $row['shop_url'])
        ->setCellValue($char++.$i, $row['shop_title'])
        ->setCellValue($char++.$i, $GLOBALS['company_type'][$row['shop_company_type']])
        ->setCellValue($char++.$i, $row['shop_company_name'])
        ->setCellValue($char++.$i, $row['shop_company_owner'])
        ->setCellValue($char++.$i, $row['shop_company_saupja_no'])
        ->setCellValue($char++.$i, $row['shop_company_tolsin_no'])
        ->setCellValue($char++.$i, $row['shop_company_item'])
        ->setCellValue($char++.$i, $row['shop_company_service'])
        ->setCellValue($char++.$i, $row['shop_company_tel'])
        ->setCellValue($char++.$i, $row['shop_company_fax'])
        ->setCellValue($char++.$i, $row['shop_company_email'])
        ->setCellValue($char++.$i, $row['shop_info_manager'][0])
        ->setCellValue($char++.$i, $row['shop_info_manager'][1])
       ->setCellValue($char++.$i, $row['pt_last_login_dt'])
        ->setCellValue($char++.$i, $row['pt_last_login_ip'])
        ->setCellValue($char.$i ,$row['pt_adm_memo']);
    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$filename = '가맹점_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
