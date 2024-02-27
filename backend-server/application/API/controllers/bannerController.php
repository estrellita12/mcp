<?php
namespace application\API\controllers;

use \Exception;

class bannerController extends Controller{

    function init(){
        $this->tokenCheck();
        $this->category = new \application\models\CategoryModel();
        $this->banner = new \application\models\BannerModel();
    }

    function getList(){
        $res = "000";
        $colArr = array("bannerId","url","target","backgroundColor","position","img","mimg");
        if($this->isAuth != 3){
            if($this->isAuth==1){
                $useCtg = $this->shopUseCtg;
                $shopId = $this->shopId;
            }else if($this->isAuth==2){
                $partner = new \application\models\PartnerModel();
                $row = $partner->get($this->userId,$partner->getCol(array("useCtg")));
                $useCtg= unserialize($row['useCtg']);
                $shopId = $this->userId;
            }
            if( empty($shopId) ) $this->result("002","등록되지않은 사용자 입니다.");
            if( empty($useCtg) || !is_array($useCtg) ) $this->result("002","카테고리가 존재하지 않습니다.");
            $_REQUEST['shop'] = "admin,".$shopId;
            $_REQUEST['ctg'] = implode(",",$useCtg);
        }
        $_REQUEST['term'] = empty($_GET['term'])?"showDate":$_GET['term'];
        $_REQUEST['beg'] = empty($_GET['beg'])?_DATE_YMDHIS:$_GET['beg'];
        $_REQUEST['end'] = empty($_GET['end'])?_DATE_YMDHIS:$_GET['end'];
        $_REQUEST['showYn'] = "y";
        //$_REQUEST['position'] = $_GET['position'];
        //$_REQUEST['device'] = $_GET['device'];
        $row = $this->banner->getList($this->banner->getCol($colArr));
        if( !is_array($row) ) $this->result($row);

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

    function get(){
        $res = "000";
        $colArr = array("bannerId","url","target","backgroundColor","position","img","mimg","shop","ctg","device","showYn","orderby","beginDate","endDate");
        $row = $this->banner->get($this->param['ident'], $this->banner->getCol($colArr));
        if( !is_array($row) ) $this->result($row);

        $arr = array("result"=>$res,"data"=>$row);
        echo json_encode($arr);
    }

}
?>
