<?php
namespace application\Admin\controllers;

class DefaultController extends Controller{
    public $col;
    public $cnt;

    public function init(){ 
        $this->col = "*";
    }

    public function information(){  
        $grade = new \application\models\PartnerGradeModel();
        $this->gr_li = $grade->getNameList();
        $this->row = $this->default;
        $this->row['shop_info_manager'] = unserialize($this->row['shop_info_manager']);
        $this->row['shop_customer_service_info'] = unserialize($this->row['shop_customer_service_info']);
    }

    public function policy(){  
        $this->row = $this->default;
    }

    public function pg(){  
        $this->row = $this->default;
    }

    public function design(){  
        $this->row = $this->default;
    }

    public function category(){  
        $this->category = new \application\models\CategoryModel();
        $this->row = $this->default;
        $this->row['shop_use_ctg'] = unserialize($this->row['shop_use_ctg']);
    }

    public function set(){  
        $this->head=false; $this->footer=false;
        $default = new \application\models\DefaultModel();
        $res = $default->set(array_merge($_POST,$_FILES));
        $msg = $res=="000" ? "기본 환경 설정이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function gnb(){
        $gnb = new \application\models\GnbMenuModel();
        $this->row = $this->default;
        $this->row['shop_default_menu'] = $gnb->get("*",array("pt_id"=>"admin"));
        $this->row['shop_default_menu_mode'] = "add";
        $this->row['shop_gnb'] = json_decode($this->row['shop_gnb'],true);
        $this->row['shop_main_layout'] = json_decode($this->row['shop_main_layout'],true);
    }

    public function setGnb(){
        $default = new \application\models\DefaultModel();
        $gnb = array();
        for($i=0;$i<count($_POST['gnbTitle']);$i++){
            $gnb[$i]['title']=$_POST['gnbTitle'][$i];
            $gnb[$i]['url']=$_POST['gnbUrl'][$i];
        }
        $res = $default->set(array("id="=>"admin","gnb"=>$gnb),"admin");
        $msg = $res=="000" ? "기본 레이아웃이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }

    public function layout(){
        $bannerGroup = new \application\models\BannerGroupModel();
        $this->gr_li = $bannerGroup->getNameList();
        $gnb = new \application\models\GnbMenuModel();
        $this->row = $this->default;
        $this->row['shop_default_menu'] = $gnb->get("*",array("pt_id"=>"admin"));
        $this->row['shop_default_menu_mode'] = "add";
        $this->row['shop_gnb'] = json_decode($this->row['shop_gnb'],true);
        $this->row['shop_main_layout'] = json_decode($this->row['shop_main_layout'],true);
    }

    function setLayout(){
        $default = new \application\models\DefaultModel();
        $mainLayout = array();
        for($i=0;$i<count($_POST['mainLayoutTitle']);$i++){
            $mainLayout[$i]['title']=$_POST['mainLayoutTitle'][$i];
            $mainLayout[$i]['url']=$_POST['mainLayoutUrl'][$i];
            $mainLayout[$i]['api']=$_POST['mainLayoutApiUrl'][$i];
            $mainLayout[$i]['apiCol']=$_POST['mainLayoutApiCol'][$i];
            $mainLayout[$i]['type']=$_POST['mainLayoutType'][$i];;
            $mainLayout[$i]['design']=$_POST['mainLayoutDesign'][$i];
            $mainLayout[$i]['cnt']=$_POST['mainLayoutCnt'][$i];
            $mainLayout[$i]['rpp']=$_POST['mainLayoutRpp'][$i];
            $mainLayout[$i]['mcnt']=$_POST['mainLayoutMCnt'][$i];
            $mainLayout[$i]['mrpp']=$_POST['mainLayoutMRpp'][$i];
        }
        $res = $default->set(array("id="=>"admin","mainLayout"=>$mainLayout),"admin");
        $msg = $res=="000" ? "기본 레이아웃이 수정되었습니다." : "실패\\n".$GLOBALS['res_code'][$res];
        access($msg , _PRE_URL);
    }  
}
?>
