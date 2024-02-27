<?php
namespace application\Seller\controllers;

class CategoryController extends Controller{
    function init(){ 
        $this->col = "*";
    }

    function getNext(){
        $this->category = new \application\models\CategoryModel();
        $this->header=false; $this->footer=false;
        $depth = $_POST['depth'];
        $upper = $_POST['upper'];
        $length = 3 * $depth;
        $data = array();
        if(!empty($depth)) {
            $res = $this->category->getDepthList($depth, $upper, 'a');
            if(empty($res)) return;
            $i=0;
            foreach( $res as $row) {
                $data[$i]['optionValue'] = $row['ctg_id'];
                $data[$i]['optionText']  = $row['ctg_title'];
                $i++;
            }
        }
        print_r(json_encode($data));
    }

}
