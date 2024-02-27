<?php
namespace application\Partner\controllers;

class CategoryController extends Controller{
    public function init(){ 
        $this->col = "*";
    }

    public function getNext(){
        $this->category = new \application\models\CategoryModel();
        $this->header=false; $this->footer=false;
        $depth = empty($_POST['depth'])?"":$_POST['depth'];
        $upper = empty($_POST['upper'])?"":$_POST['upper'];
        $length = 3 * $depth;
        $data = array();

        if(empty($this->my['shop_use_ctg'])){
            $defaultModel = new \application\models\DefaultModel();
            $default = $defaultModel->get("shop_use_ctg",array("pt_id"=>"admin"));
            $this->my['shop_use_ctg'] = $default['shop_use_ctg'];
        }
        $this->my['shop_use_ctg'] = unserialize($this->my['shop_use_ctg']);

        if(!empty($depth)) {
            $res = $this->category->getDepthList($depth, $upper, 'a');
            if(empty($res)) return;
            $i=0;
            foreach( $res as $row) {
                if( $depth == "2" ){
                    if(!in_array($row['ctg_id'],$this->my['shop_use_ctg'])) continue;
                }
                $data[$i]['optionValue'] = $row['ctg_id'];
                $data[$i]['optionText']  = $row['ctg_title'];
                $i++;
            }
        }
        print_r(json_encode($data));
    }

}
