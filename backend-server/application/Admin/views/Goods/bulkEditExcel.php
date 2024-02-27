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
      ->setCellValue($pre++.'1', '상품코드(수정불가)')
      ->setCellValue($pre++.'1', '판매자(수정불가)')
      ->setCellValue($pre++.'1', '대표 카테고리(필수)')
      ->setCellValue($pre++.'1', '추가 카테고리')
      ->setCellValue($pre++.'1', '추가 카테고리')
      ->setCellValue($pre++.'1', '상품명(필수)')
      ->setCellValue($pre++.'1', '짧은설명')
      ->setCellValue($pre++.'1', '키워드')
      ->setCellValue($pre++.'1', '브랜드명')
      ->setCellValue($pre++.'1', '모델명')
      ->setCellValue($pre++.'1', '원산지(제조국)')
      ->setCellValue($pre++.'1', '제조사')
      ->setCellValue($pre++.'1', '생산연도')
      ->setCellValue($pre++.'1', '제조일자')
      ->setCellValue($pre++.'1', '시즌')
      ->setCellValue($pre++.'1', '남녀구분')
      ->setCellValue($pre++.'1', '과세설정')
      ->setCellValue($pre++.'1', '진열상태(필수)')
      ->setCellValue($pre++.'1', '필수옵션제목(필수)')
      ->setCellValue($pre++.'1', '소비자가(TAG가)(필수)')
      ->setCellValue($pre++.'1', '공급가')
      ->setCellValue($pre++.'1', '판매가(필수)')
      ->setCellValue($pre++.'1', '세부 판매가 설정(필수)');
foreach($this->pt_gr_li as $idk=>$grade){
    $excel->setCellValue($pre++.'1', $grade);
}
$excel->setCellValue($pre++.'1', '최소주문수량')
      ->setCellValue($pre++.'1', '최대주문수량')
      ->setCellValue($pre++.'1', '재고수량')
      ->setCellValue($pre++.'1', '통보수량')
      ->setCellValue($pre++.'1', '판매 기간 시작일')
      ->setCellValue($pre++.'1', '판매 기간 종료일')
      ->setCellValue($pre++.'1', '구매가능등급')
      ->setCellValue($pre++.'1', '배송비 유형(필수)')
      ->setCellValue($pre++.'1', '기본 배송비')
      ->setCellValue($pre++.'1', '조건부 무료 주문 금액')
      ->setCellValue($pre++.'1', '교환/반품 배송비')
      ->setCellValue($pre++.'1', '배송 가능 지역')
      ->setCellValue($pre++.'2', "이미지저장타입")
      ->setCellValue($pre++.'1', '이미지1(필수)')
      ->setCellValue($pre++.'1', '이미지2')
      ->setCellValue($pre++.'1', '이미지3')
      ->setCellValue($pre++.'1', '이미지4')
      ->setCellValue($pre++.'1', '이미지5')
      ->setCellValue($pre++.'1', '상세설명(필수)')
      ->setCellValue($pre++.'1', '속성 분류 코드(필수)')
      ->setCellValue($pre++.'1', '속성값1')
      ->setCellValue($pre++.'1', '속성값2')
      ->setCellValue($pre++.'1', '속성값3')
      ->setCellValue($pre++.'1', '속성값4')
      ->setCellValue($pre++.'1', '속성값5')
      ->setCellValue($pre++.'1', '속성값6')
      ->setCellValue($pre++.'1', '속성값7')
      ->setCellValue($pre++.'1', '속성값8')
      ->setCellValue($pre++.'1', '속성값9')
      ->setCellValue($pre++.'1', '속성값10')
      ->setCellValue($pre++.'1', '속성값11')
      ->setCellValue($pre++.'1', '속성값12')
      ->setCellValue($pre++.'1', '속성값13')
      ->setCellValue($pre++.'1', '속성값14')
      ->setCellValue($pre++.'1', '속성값15')
      ->setCellValue($pre++.'1', '속성값16')
      ->setCellValue($pre++.'1', '속성값17')
      ->setCellValue($pre++.'1', '속성값18')
      ->setCellValue($pre++.'1', '속성값19')
      ->setCellValue($pre++.'1', '속성값20')
      ->setCellValue($pre++.'1', '속성값21')
      ->setCellValue($pre++.'1', '속성값22')
      ->setCellValue($pre++.'1', '속성값23')
      ->setCellValue($pre++.'1', '속성값24')
      ->setCellValue($pre++.'1', '속성값25')
      ->setCellValue($pre++.'1', '속성값26')
      ->setCellValue($pre++.'1', '속성값27')
      ->setCellValue($pre++.'1', '속성값28')
      ->setCellValue($pre++.'1', '속성값29')
      ->setCellValue($pre++.'1', '속성값30')
      ->setCellValue($pre++.'1', '속성값31')
      ->setCellValue($pre++.'1', '속성값32')
      ->setCellValue($pre++.'1', '속성값33')
      ->setCellValue($pre++.'1', '속성값34')
      ->setCellValue($pre.'1', '속성값35');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$pre = 'A';
$excel->setCellValue($pre++.'2', "▶ 수정 불가 항목입니다. \n▶ 수정시 다른 항목에 영향을 끼칠 수 있습니다.")
      ->setCellValue($pre++.'2', "▶ 수정 불가 항목입니다. \n▶ 수정시 다른 항목에 영향을 끼칠 수 있습니다.")
      ->setCellValue($pre++.'2', "▶ 수정 불가 항목입니다. \n▶ 수정시 다른 항목에 영향을 끼칠 수 있습니다.")
      ->setCellValue($pre++.'2', "▶ 카테고리 코드를 정확하게 입력합니다.\n▶ 공백없이 콤마(,)로 구분하여 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 카테고리 코드를 정확하게 입력합니다.\n▶ 공백없이 콤마(,)로 구분하여 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 카테고리 코드를 정확하게 입력합니다.\n▶ 공백없이 콤마(,)로 구분하여 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 최대 200까지 입력 가능합니다.\n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 상품의 빠른 인식을 위해 상품명 대신 이용합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 쇼핑몰 검색시 사용되는 키워드 입니다. \n▶ 공백없이 콤마(,)로 구분하여 입력합니다. 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 최대 60자까지 입력 가능합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 최대 60자까지 입력 가능합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 최대 60자까지 입력 가능합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 최대 60자까지 입력 가능합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 생산연도를 숫자로 입력합니다. \n▶ 생산연도 4자리만 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 제조일자를 숫자로 입력합니다. \n▶ 숫자 외 다른 문자는 입력하지 마십시오. 연월일 순으로 8자리를 모두 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 시즌을 숫자로 입력합니다. \n봄 : 1 \n여름 : 2 \n가을 : 3 \n겨울 : 4 \nFW(가을겨울) : 5 \nSS(봄여름) : 6 \n기타 : 7 \nSF : 8")
      ->setCellValue($pre++.'2', "▶ 남녀구분을 숫자로 입력합니다. \n남성용 : 1 \n여성용 : 2 \n공용 : 3 \n자료없음 : 4")
      ->setCellValue($pre++.'2', "▶ 과세 설정을 숫자로 입력합니다. \n과세 : 1 \n면세 : 2 \n자료없음 : 3 \n비과세 : 4")
      ->setCellValue($pre++.'2', "▶ 진열상태를 숫자로 입력합니다. \n진열 : 1 \n품절 : 2 \n단종 : 3 \n중지 : 4")
      ->setCellValue($pre++.'2', "▶ 최대 60자까지 입력 가능합니다. \n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 세부판매가 설정 여부를 숫자로 입력합니다. \n 자동반영 : 1 \n수동 반영 : 2");

foreach($this->pt_gr_li as $idk=>$grade){
    $excel->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.");
}

$excel->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 판매 시작일을 YYYY-MM-DD hh:mm:ss 형식으로 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 판매 종료일을 YYYY-MM-DD hh:mm:ss 형식으로 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 구매 가능 등급을 숫자로 입력합니다. \n▶ 비회원 구매 가능 : 10")
      ->setCellValue($pre++.'2', "▶ 배송비 유형을 숫자로 입력합니다. \n무료 : 1 \n착불 : 2 \n선결제 : 3 \n착불/선결제 : 4 \n조건부 무료 : 5")
      ->setCellValue($pre++.'2', "▶ 무료 배송이 아닐 경우 반드시 입력해야 합니다. \n▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 조건부 무료 배송인 경우 반드시 입력해야 합니다. \n▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.")
      ->setCellValue($pre++.'2', "▶ 배송 가능 지역을 숫자로 입력합니다. \n 전국 : 1 \n전국(도서제외) : 2 \n수도권 : 3 \n기타 : 4")
      ->setCellValue($pre++.'2', "▶ 숫자만 입력 가능합니다.\n파일 저장 : 0 \nURL 저장 : 1\n")
      ->setCellValue($pre++.'2', "▶ 이미지 절대 경로를 입력합니다. \n ▶ 이미지 절대 경로에 한글을 입력하지 않습니다. \n▶ 이미지 용량은 2MB 이하로 제한합니다.  \n▶ 이미지 권장 사이즈는 ".$this->config['cf_simg_size_w']."px x ".$this->config['cf_simg_size_h']."px 입니다 ")
      ->setCellValue($pre++.'2', "▶ 이미지 절대 경로를 입력합니다. \n ▶ 이미지 절대 경로에 한글을 입력하지 않습니다. \n▶ 이미지 용량은 2MB 이하로 제한합니다.  \n▶ 이미지 권장 사이즈는 ".$this->config['cf_simg_size_w']."px x ".$this->config['cf_simg_size_h']."px 입니다 ")
      ->setCellValue($pre++.'2', "▶ 이미지 절대 경로를 입력합니다. \n ▶ 이미지 절대 경로에 한글을 입력하지 않습니다. \n▶ 이미지 용량은 2MB 이하로 제한합니다.  \n▶ 이미지 권장 사이즈는 ".$this->config['cf_simg_size_w']."px x ".$this->config['cf_simg_size_h']."px 입니다 ")
      ->setCellValue($pre++.'2', "▶ 이미지 절대 경로를 입력합니다. \n ▶ 이미지 절대 경로에 한글을 입력하지 않습니다. \n▶ 이미지 용량은 2MB 이하로 제한합니다.  \n▶ 이미지 권장 사이즈는 ".$this->config['cf_simg_size_w']."px x ".$this->config['cf_simg_size_h']."px 입니다 ")
      ->setCellValue($pre++.'2', "▶ 이미지 절대 경로를 입력합니다. \n ▶ 이미지 절대 경로에 한글을 입력하지 않습니다. \n▶ 이미지 용량은 2MB 이하로 제한합니다.  \n▶ 이미지 권장 사이즈는 ".$this->config['cf_simg_size_w']."px x ".$this->config['cf_simg_size_h']."px 입니다 ")
      ->setCellValue($pre++.'2', "▶ HTML 태그 또는 문자로 입력합니다.")
      ->setCellValue($pre++.'2', "▶ 속성정보분류를 코드로 입력합니다. \n ▶ 속성정보분류에 대한 코드 값은 정보고시 파일에서 확인 할 수 있습니다.")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre++.'2', "")
      ->setCellValue($pre.'2', "");
$excel->getStyle("A2:".$pre."2")->applyFromArray($infoStyle);
$excel->getStyle("A2:".$pre."2")->getAlignment()->setWrapText(true);

$i = 2;
foreach($this->goods->getList($this->col) as $row) {
    $i++;
    $char = 'A';
    $row['gs_info_value'] = unserialize($row['gs_info_value']);
    $excel->setCellValue($char++.$i, $row['gs_id'])
          ->setCellValue($char++.$i, $row['gs_code'] )
          ->setCellValue($char++.$i, $row['sl_id'] )
          ->setCellValue($char++.$i, $row['gs_ctg'] )
          ->setCellValue($char++.$i, $row['gs_ctg2'] )
          ->setCellValue($char++.$i, $row['gs_ctg3'] )
          ->setCellValue($char++.$i, $row['gs_name'] )
          ->setCellValue($char++.$i, $row['gs_explan'] )
          ->setCellValue($char++.$i, $row['gs_keywords'] )
          ->setCellValue($char++.$i, $row['gs_brand'] )
          ->setCellValue($char++.$i, $row['gs_model_nm'] )
          ->setCellValue($char++.$i, $row['gs_origin'] )
          ->setCellValue($char++.$i, $row['gs_maker'] )
          ->setCellValue($char++.$i, $row['gs_make_year'] )
          ->setCellValue($char++.$i, $row['gs_make_dm'] )
          ->setCellValue($char++.$i, $row['gs_season'] )
          ->setCellValue($char++.$i, $row['gs_sex'] )
          ->setCellValue($char++.$i, $row['gs_tax'] )
          ->setCellValue($char++.$i, $row['gs_isopen'] )
          ->setCellValue($char++.$i, $row['gs_opt_subject'] )
          ->setCellValue($char++.$i, $row['gs_consumer_price'] )
          ->setCellValue($char++.$i, $row['gs_supply_price'] )
          ->setCellValue($char++.$i, $row['gs_price'] )
          ->setCellValue($char++.$i, $row['gs_price_auto'] );
foreach($this->pt_gr_li as $idx=>$grade){
    $excel->setCellValue($char++.$i, $row["gs_price_{$idx}"] );
}
$excel->setCellValue($char++.$i, $row['gs_order_min_qty'] )
          ->setCellValue($char++.$i, $row['gs_order_max_qty'] )
          ->setCellValue($char++.$i, $row['gs_stock_qty'] )
          ->setCellValue($char++.$i, $row['gs_stock_qty_noti'] )
          ->setCellValue($char++.$i, check_time($row['gs_sales_begin_dt'])?$row['gs_sales_begin_dt']:"" )
          ->setCellValue($char++.$i, check_time($row['gs_sales_end_dt'])?$row['gs_sales_end_dt']:"" )
          ->setCellValue($char++.$i, $row['gs_buy_use_grade'] )
          ->setCellValue($char++.$i, $row['gs_delivery_type'] )
          ->setCellValue($char++.$i, $row['gs_delivery_charge'] )
          ->setCellValue($char++.$i, $row['gs_delivery_free'] )
          ->setCellValue($char++.$i, $row['gs_claim_delivery_charge'] )
          ->setCellValue($char++.$i, $row['gs_delivery_region_msg'] )
          ->setCellValue($char++.$i, $row['gs_simg_type'] )
          ->setCellValue($char++.$i, $row['gs_simg1'] )
          ->setCellValue($char++.$i, $row['gs_simg2'] )
          ->setCellValue($char++.$i, $row['gs_simg3'] )
          ->setCellValue($char++.$i, $row['gs_simg4'] )
          ->setCellValue($char++.$i, $row['gs_simg5'] )
          ->setCellValue($char++.$i, $row['gs_detail_content'] )
          ->setCellValue($char++.$i, $row['gs_info_type'] );
    foreach($row['gs_info_value'] as $info){
        $excel->setCellValue($char++.$i, $info );
    }
    $excel->getStyle("A$i:".$pre.$i)->applyFromArray($tdStyle);
}
for($k='A'; $k != $pre; $k++){
    $excel->getColumnDimension($k)->setWidth(150,'px'); 
}
$filename = '일괄_상품_수정_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
