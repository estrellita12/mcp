<?php
namespace application\API_F\controllers;

class baseController extends Controller 
{
    function init(){ 
        $this->temp();
        $this->partner = new \application\models\PartnerModel();
        $this->category = new \application\models\CategoryModel();
        $this->config = new \application\models\ConfigModel();
    }

    function get(){
        $pt = $this->partner->get( $this->partner->getCol(), array("pt_id"=>$this->shopId));
        $config = $this->config->get($this->config->getCol(array('delivery')), array("cf_id"=>"1"));

        
        $arr = Array();
        $arr['all']['data'] = Array();
        
        foreach($this->shopUseCtg as $ctg){
            $d1 = substr($ctg,0,3);
            $d2 = $ctg;

            array_push($arr['all']['data'],$d2);

            $_REQUEST['useYn'] = 'y';
            $_REQUEST['ctgId'] = $d1;
            $data1 = $this->category->getList($this->category->getCol());
            if(empty($arr[$d1]['info']) && !empty($data1)){
                $arr[$d1]['info'] = $data1[0];
            }
            
            $_REQUEST['ctgId'] = $d2;
            if(empty($arr[$d1]['data']) && !empty($arr[$d1]['info'])) $arr[$d1]['data'] = array();
            $data2 = $this->category->getList($this->category->getCol());
            if(!empty($arr[$d1]['info']) && !empty($data2)) array_push($arr[$d1]['data'], ($data2)[0]['ctgId']);
            if(empty($arr[$d1]['data'])) unset($arr[$d1]);
            
        }
        $pt['useCtg'] = $arr;
        $pt['delivery'] = json_decode($config['delivery'],true);
        $pt['default'] = $this->shopDefault;
        
        echo json_encode($pt);
    }
}
