<?php
namespace application\Front\controllers;

class categoryController extends Controller{
    private $categoryModel;
    private $col;

    public function init(){
        $this->categoryModel = new \application\models\CategoryModel();
        $this->col = array(
            "ctg_id"=>"ctg_id",
            "ctg_upper_id"=>"ctg_upper_id",
            "ctg_title"=>"ifnull(ctg_title,'')",
            "ctg_top_banner"=>"if(ctg_top_banner != '', concat('"._BANNER."',ctg_top_banner), '' )",
            "ctg_m_top_banner"=>"if(ctg_m_top_banner != '', concat('"._BANNER."',ctg_m_top_banner), '' )",
            "ctg_top_banner_url"=>"ifnull(ctg_top_banner_url,'')",
        );
    }

    public function getList(){
        $col = get_column_as($this->col,array("ctg_id","ctg_title"),true);
        $depth1 = array();
        foreach($this->shopUseCtg as $ctg){
            $d1 = substr($ctg,0,3);
            if( in_array($d1,$depth1) ) continue;
            array_push($depth1,$d1);
        }

        $list = array();
        $search1 = array();
        $search1['col'] = "ctg_orderby";
        $search1['ctg_use_yn'] = "y";
        $search1['ctg_id_in_'] = implode(",",$depth1);
        $row = $this->categoryModel->get($col,$search1,true);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);

        $search2 = array();
        $search2['col'] = "ctg_orderby";
        $search2['ctg_use_yn'] = "y";
        $search2['ctg_id_in_'] = implode(",",$this->shopUseCtg);
        for($i=0;$i<count($row);$i++){
            $search2['ctg_upper_id'] = $row[$i]['ctg_id'];
            $row[$i]['next'] = $this->categoryModel->get($col,$search2,true);
            $search3 = array();
            $search3['col'] = "ctg_orderby";
            $search3['ctg_use_yn'] = "y";
            for($j=0;$j<count($row[$i]['next']);$j++){
                $search3['ctg_upper_id'] = $row[$i]['next'][$j]['ctg_id'];
                $row[$i]['next'][$j]['next'] = $this->categoryModel->get($col,$search3,true);
            }
        }
        $this->response_json("000",array("list"=>$row));
    }

    public function get(){
        if( empty($this->param['ident']) ) $this->result("002");

        $col = get_column_as($this->col,array(),false);
        $search = array();
        $search['ctg_id'] = $this->param['ident'];
        $search['ctg_use_yn'] = "y";
        $row = $this->categoryModel->get($col,$search);
        if( empty($row) ) $this->result("001");
        if( !is_array($row) ) $this->result($row);

        $search = array();
        $search['ctg_use_yn'] = "y";
        $search['ctg_upper_id'] = $this->param['ident'];
        $nextRow = $this->categoryModel->get($col,$search,true);
        $row['next'] = $nextRow;
        $this->response_json("000",array("data"=>$row));
    }
}
?>
