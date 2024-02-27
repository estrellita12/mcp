<?php
namespace application\Admin\controllers;

class PopupController extends Controller{

    public function init(){
        $this->header = false; $this->footer = false;
    }

    public function history(){
        $this->header = "head";
        $model = "\\application\\models\\{$this->param['ident']}HistoryModel";
        $historyModel = new $model;
        $search = array();
        $search["tp_id"] = $this->param['action'] ;
        $search["adm_id"] = $this->param['action'] ;
        $search["sl_id"] = $this->param['action'] ;
        $search["gs_id"] = $this->param['action'] ;
        $search["od_id"] = $this->param['action'] ;
        $search["pt_id"] = $this->param['action'] ;
        $this->row = $historyModel->get("*",$search, true);
    }

    public function updateLog(){
        $this->header = "head";
        $LogModel = new \application\models\UpdateLogModel();
        $search = array();
        $search["log_target_table"] = $this->param['ident'];
        $search["log_target_id"] = $this->param['action'];
        $search['col'] = "log_reg_dt";
        $search['colby'] = "desc";
        $this->row = $LogModel->get("*",$search, true);
    }
}

?>
