<?php
namespace application\models;

use \PDO;

class AnalysisModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_dumy_calendar' );
    }
/*
    function getWhere(){
        parent::getWhere();
       if( !empty($_REQUEST['beg']) ) $this->getTerm("dc_dt",$_REQUEST['beg'],"ge");
        if( !empty($_REQUEST['end']) ) $this->getTerm("dc_dt",$_REQUEST['end'],"le");
    }

    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by dc_dt desc ";
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';
            if( $_REQUEST['col'] == 'dumyDate' ) $this->sql_order = " order by dc_dt {$_REQUEST['colby']} ";
        }
    }
*/

    function getAnalysis($col, $table, $targetDate, $search = array()){
        $this->sql_from = " web_dumy_calendar as a left join {$table} as b  on a.dc_dt = left(b.{$targetDate},10)";
        $this->sql_group = " group by dc_dt ";
        if(empty($search)){
            $search['dc_dt_then_ge'] = $_REQUEST['beg']." 00:00:00";
            $search['dc_dt_then_le'] = $_REQUEST['end']." 23:59:59";
        }
        return parent::get($col,$search,true);
    }
}
?>
