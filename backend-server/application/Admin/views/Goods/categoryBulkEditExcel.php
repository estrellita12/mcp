<?php
require_once _LIB.'/vendor/autoload.php';
require_once _LIB.'/excel.style.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->setActiveSheetIndex(0);
$excel = $spreadsheet->getActiveSheet();

$pre = 'A';
$excel->setCellValue($pre++.'1', '카테고리 코드')
      ->setCellValue($pre++.'1', '대분류')
      ->setCellValue($pre++.'1', '중분류')
      ->setCellValue($pre++.'1', '소분류')
      ->setCellValue($pre++.'1', '세분류')
      ->setCellValue($pre++.'1', '카테고리')
      ->setCellValue($pre++.'1', '카테고리명')
      ->setCellValue($pre.'1', '사용 여부');
$excel->getStyle("A1:".$pre."1")->applyFromArray($thStyle);

$pre = 'A';
$excel->setCellValue($pre++.'2', "▶ 설정 불가 항목입니다. \n")
      ->setCellValue($pre++.'2', "▶ 카테고리 대분류를 입력합니다.\n▶ 숫자 이외의 문자는 사용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 카테고리 중분류를 입력합니다.\n▶ 숫자 이외의 문자는 사용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 카테고리 소분류를 입력합니다.\n▶ 숫자 이외의 문자는 사용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 카테고리 세분류를 입력합니다.\n▶ 숫자 이외의 문자는 사용 할 수 없습니다.")
      ->setCellValue($pre++.'2', "▶ 설정 불가 항목입니다.")
      ->setCellValue($pre++.'2', "▶ 최대 200까지 입력 가능합니다.\n▶ 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다.")
      ->setCellValue($pre.'2', "▶ 사용 여부를 문자로 입력합니다. \ny : 사용\n n : 미사용");
$excel->getStyle("A2:".$pre."2")->applyFromArray($infoStyle);
$excel->getStyle("A2:".$pre."2")->getAlignment()->setWrapText(true);

$i = 2;
foreach($this->category->getList($this->col) as $row) 
{
    $i++;
    $char = 'A';
    $code = $row['ctg_id'];
    $depth1 = strlen($row['ctg_id'])>=3?substr($row['ctg_id'],0,3):"";
    $depth2 = strlen($row['ctg_id'])>=6?substr($row['ctg_id'],3,3):"";
    $depth3 = strlen($row['ctg_id'])>=9?substr($row['ctg_id'],6,3):"";
    $depth4 = strlen($row['ctg_id'])>=12?substr($row['ctg_id'],9,3):"";
    $ctgNav = "";
    $upperList = $this->category->getUpperList($row['ctg_id']);
    $j = 0;
    foreach($upperList as $ctg){
        if($j!=0)$ctgNav .= " > ";
        $ctgNav .= $ctg['title'];
        $ctgNav .= " ";
        $j++;
    }
    $excel->setCellValueExplicit($char++.$i, $row['ctg_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $depth1, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $depth2, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $depth3, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $depth4, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $ctgNav, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char++.$i, $row['ctg_title'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING )
          ->setCellValueExplicit($char.$i, $row['ctg_use_yn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING );

    $excel->getStyle("A$i:".$char.$i)->applyFromArray($tdStyle);
}

$excel->getColumnDimension('A')->setWidth(150,'px');
$excel->getColumnDimension('B')->setWidth(150,'px');
$excel->getColumnDimension('C')->setWidth(150,'px');
$excel->getColumnDimension('D')->setWidth(150,'px');
$excel->getColumnDimension('E')->setWidth(150,'px');
$excel->getColumnDimension('F')->setWidth(300,'px');
$excel->getColumnDimension('G')->setWidth(200,'px');
$excel->getColumnDimension('H')->setWidth(150,'px');
$excel->getColumnDimension('I')->setWidth(150,'px');

$filename = '카테고리_목록_'.date("Ymd", _SERVER_TIME) ;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
