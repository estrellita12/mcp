<?php
namespace application\API\controllers;

use \Exception;

class categoryController extends Controller{

    function init(){
        //$this->temp();
        $this->tokenCheck();
        $this->category = new \application\models\CategoryModel();
    }

    function getList(){
        $res = "000";
        $colArr = array("ctgId","title");
        $_REQUEST['useYn'] = 'y';
        $d1Arr = array();
        if($this->isAuth != 3 ){
            if($this->isAuth==1){
                $useCtg = $this->shopUseCtg;
            }else if($this->isAuth==2){
                $partner = new \application\models\PartnerModel();
                $row = $partner->get($this->userId,$partner->getCol(array("useCtg")));
                $useCtg= unserialize($row['useCtg']);
            }
            foreach($useCtg as $ctg){
                $d1 = substr($ctg,0,3);
                if( in_array($d1,$d1Arr) ) continue;
                array_push($d1Arr,$d1);
            }
            if( empty($d1Arr) || !is_array($d1Arr) ) $this->result("002","카테고리가 존재하지 않습니다.");
            $_REQUEST['ctgId'] = implode(",",$d1Arr);
        }

        $_REQUEST['depth'] = "3";
        $col = $this->category->getCol($colArr);
        $row = $this->category->getList($col);
        unset($_REQUEST['depth']);

        for($i=0;$i<count($row);$i++){
            $_REQUEST['upper'] = $row[$i]['ctgId'];
            $_REQUEST['ctgId'] = implode(",",$useCtg);
            $row[$i]['next'] = $this->category->getList($col);
            for($j=0;$j<count($row[$i]['next']);$j++){
                $_REQUEST['upper'] = $row[$i]['next'][$j]['ctgId'];
                $_REQUEST['ctgId'] = '';
                $row[$i]['next'][$j]['next'] = $this->category->getList($col);
            }
        }
        if( !is_array($row) ) $this->result($row);

        $arr = array("result"=>$res, "data"=>$row);
        echo json_encode($arr);
    }

    function get(){
        $res = "000";
        $colArr = array("ctgId","title","upper","topBanner","mTopBanner","useYn");
        $row = $this->category->get($this->param['ident'],$this->category->getCol());
        if( !is_array($row) ) $this->result($row);
        $arr = array("result"=>$res, "data"=>$row);
        echo json_encode($arr);
    }

}
?>
