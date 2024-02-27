<?php
require_once _LIB.'/vendor/autoload.php';

foreach($this->admin->sqlFetchAll("web_member","*",$this->sqlSearch, $this->sqlOrder, $this->sqlLimit) as $row) {
    print_r($row);
}

exit;

$datas = array(
    array('name' => '김정호', 'tel' => '010-1234-1234', 'bank' => '국민은행'),
    array('name' => '홍길동', 'tel' => '010-5678-5678', 'bank' => '한국은행')
);

$cells = array(
    'A' => array(15, 'name', '신청자명'),
    'B' => array(20, 'tel',  '전화번호'),
    'C' => array(20, 'bank', '은행명')
);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

foreach ($cells as $key => $val) {
    $cellName = $key.'1';

    $sheet->getColumnDimension($key)->setWidth($val[0]);
    $sheet->getRowDimension('1')->setRowHeight(25);
    $sheet->setCellValue($cellName, $val[2]);
    $sheet->getStyle($cellName)->getFont()->setBold(true);
    $sheet->getStyle($cellName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($cellName)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
}
for ($i = 2; $row = array_shift($datas); $i++) {
    foreach ($cells as $key => $val) {
        $sheet->setCellValue($key.$i, $row[$val[1]]);
    }
}

$filename = 'excel';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
ob_get_clean();

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

die;
?>
