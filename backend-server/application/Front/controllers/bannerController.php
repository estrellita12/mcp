<?php
namespace application\Front\controllers;

use \Exception;

class bannerController extends Controller{
    private $col;
    private $search;
    private $sql;

    public function init(){
        try{
            $this->categoryModel = new \application\models\CategoryModel();
            $this->bannerModel = new \application\models\BannerModel();
            $this->col = array(
                "bn_id"=>"bn_id",
                "ctg_id"=>"ctg_id",
                "bn_position"=>"bn_position",
                "bn_url"=>"bn_url",
                "bn_url_target"=>"bn_url_target",
                "bn_bg_color"=>"bn_bg_color",
                "bn_device"=>"bn_device",
                //"bn_show_yn"=>"bn_show_yn",
                //"bn_orderby"=>"bn_orderby",
                "bn_begin_dt"=>"bn_begin_dt",
                "bn_end_dt"=>"bn_end_dt", 
                "bn_img"=>"ifnull( if(bn_img !='',concat('"._BANNER."',bn_img),''), '' )", 
                "bn_m_img"=>"ifnull( if(!bn_m_img && bn_m_img !='',concat('"._BANNER."',bn_m_img),''), '' )"
            );
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function getSearch($request=array()){
        try{
            $this->sql = "";
            $this->search = array();
            $this->search['pt_id_in_'] = "admin,{$this->shopId}";
            $this->search['ctg_id_in_'] = implode(",",$this->shopUseCtg);
            $this->search['bn_show_yn'] = "y";
            $this->search['col'] = "bn_orderby";
            $this->search['bn_begin_dt_then_le'] = _DATE_YMDHIS; 
            $this->search['bn_end_dt_then_ge'] = _DATE_YMDHIS; 
            if( !empty($request['bn_position']) )   $this->search['bn_position'] = $request['bn_position'];
            if( !empty($request['bn_device']) )     $this->search['bn_device'] = $request['bn_device'];
            if( !empty($request['bn_beg_dt']) )     $this->search['bn_begin_dt_then_le'] = $request['bn_begin_dt']." 00:00:00";
            if( !empty($request['bn_end_dt']) )     $this->search['bn_end_dt_then_ge'] = $request['bn_end_dt']." 23:59:59";
            if( !empty($request['rpp']) )           $this->search['rpp'] = $request['rpp'];
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function getList(){
        try{
            $request = array();
            if( !empty($this->request['get']) ) $request = $this->request['get'];
            if( empty($request['bn_position']) ) $this->result("002");

            $this->getSearch($request);
            $col = get_column_as($this->col,array(),false);
            $list = $this->bannerModel->get($col,$this->search,true,$this->sql);
            if( empty($list) ) $this->result("001");
            if( !is_array($list) ) $this->result($list);
            $this->response_json("000",array("list"=>$list));
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }

    public function get(){
        try{
            if( empty($this->param['ident']) ) $this->result("002");

            $this->getSearch();
            $this->search['bn_id'] = $this->param['ident'];
            $col = get_column_as($this->col,array(),false);
            $data = $this->bannerModel->get($col,$this->search,false,$this->sql);
            if( empty($data) ) $this->result("001");
            if( !is_array($data) ) $this->result($data);
            $this->response_json("000",array("data"=>$data));
        }catch(Exception $e){
            $this->result("009",$e->getMessage());
        }
    }
}
?>
