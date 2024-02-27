<?php
namespace application\models;

require_once _LIB.'/vendor/autoload.php';

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BulkExcel
{
    var $upl_dir;
    var $max_file_size;

    function __construct( ){

    }

    function upload( ){
        try{
            $inputFileName = $_FILES['bulkExcel']['tmp_name'];
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($inputFileName);
            $sheetData = $spreadsheet-> getActiveSheet()->toArray();
            return $sheetData;
        }catch(Exception $e){
            debug_log( static::class,"005",array("res"=>"엑셀 업로드 실패")); 
            exit;
        }

    }

}
