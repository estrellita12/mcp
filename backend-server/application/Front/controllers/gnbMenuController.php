<?php
namespace application\Front\controllers;

class gnbMenuController extends Controller{
    private $col;
    private $sql;
    private $search;

    public function init(){
        $this->goodsModel = new \application\Front\models\GoodsModel($this->shopId,$this->shopGrade,$this->shopUseCtg);
    }

    public function goods(){
        $request = array();
        if( !empty($this->request['get']) ) $request = $this->request['get'];
        
        $gnbMenuModel = new \application\models\GnbMenuModel();
        $row = $gnbMenuModel->get("menu_{$this->param['ident']}_goods_list as goods_list",array("pt_id"=>$this->shopId));
        if( empty($row) ){
            $row = $gnbMenuModel->get("menu_{$this->param['ident']}_goods_list as goods_list",array("pt_id"=>"admin"));
        }
        if( !empty($row['goods_list']) ){
            $request['gs_id'] = $row['goods_list'];
        }

        $col = get_column_as($this->goodsModel->col,array(),false);
        $row = $this->goodsModel->get($col,$request,true);
    }
    

}
