<?php
namespace application\Admin\controllers;

class AjaxController extends Controller{
    function init(){
        $this->header = false; $this->footer = false;
    }

    // 카테고리 select 에서 다음 탭의 카테고리 정보를 불러오는 메소드
    function getNextCtg(){
        $ca_id = $_POST['ca_id'];
        $mod_type = $_POST['mod_type'];

        switch($mod_type):
        case "2": $len = 6;  break;
        case "3": $len = 9;  break;
        case "4": $len = 12; break;
        case "5": $len = 15; break;
        endswitch;

        $data = array();
        if(!empty($ca_id)) {
            $res = $this->query->getRowAll("web_category","code, title"," and length(code) = '$len' and code like '{$ca_id}%' ");
            $i=0;
            foreach( $res as $row) {
                $data[$i]['optionValue'] = $row['code'];
                $data[$i]['optionText']  = $row['title'];
                $i++;
            }
        }
        print_r(json_encode($data));
    }

    // 카테고리 코드를 전달받아, 해당 카테고리의 정보를 리턴하는 메소드
    function getCtg(){
        $row = $this->query->getRow("web_category","title,show_yn","and code='{$_POST['code']}'");
        echo json_encode($row);
    }

    function sortableUpdate(){
        $this->header = false;  $this->footer = false;
        $table = $_POST['table'];
        $idx_list = $_POST['idx_list'];
        $arr = explode(",",$idx_list);
        for($i=1;$i<count($arr);$i++){
            unset($value);
            $value['orderby']= "$i";
            $res = $this->query->update($table,$value," and idx={$arr[$i-1]} ");
            echo $res;
        }
    }


    /*
    function menuUpdate(){
        $this->aside = false;
        $this->footer = false;
        $str = "";
        foreach($this->query->getRowAll("admin_menu","*","and upper='{$_POST['code']}'","order by orderby") as $row){
            $str .=  get_frm_option($row['code'],"","[".$row['orderby']."] ".$row['name']);
        }
        echo $str;
    }

    function getMenu(){
        $this->aside = false;
        $this->footer = false;
        $row = $this->query->getRow("admin_menu","*","and code='{$_POST['code']}'");
        echo json_encode($row);
    }




    function menuGoodsAdd(){
        $this->aside = false;
        $this->footer = false;

        $this->check();
        $idx = $_POST['idx'];
        $type = $_POST['type'];
        $row = $this->query->getRow("web_menu_goods","menu_{$type}_goods_list as list","and pt_id='admin'");
        if($type==1){
            $list = unserialize($row['list']);
            $list = $list[0]['code'];
        }else{
            $list = unserialize($row['list']);
            $list = trim($list['code']);
            if( $list != "" ) $list .= ",";
            $list .= $idx;

            $tmp['code'] = $list;
            $arr["menu_{$type}_goods_list"] = serialize($tmp);
            $res = $this->query->update("web_menu_goods",$arr," and pt_id='admin' ");
        }
    }

    function menuGoodsDelete(){
        $this->check();
        $idx = $_POST['idx'];
        $type = $_POST['type'];
        $row = $this->query->getRow("web_menu_goods","menu_{$type}_goods_list as list","and pt_id='admin'");

        if($type==1){
            $list = unserialize($row['list']);
            $list = $list[0]['code'];
        }else{
            $list = unserialize($row['list']);
            $list = trim($list['code']);
            $list = explode(",",$list);
            $key = array_search($idx,$list);
            if($key=="") return;

            array_splice($list,$key,1);
            $list = implode(",",$list); 
            $tmp['code'] = $list;
            $arr["menu_{$type}_goods_list"] = serialize($tmp);
            $res = $this->query->update("web_menu_goods",$arr," and pt_id='admin' ");
        }
    }




    function menuGoodsUpdate(){
        $this->aside = false;
        $this->footer = false;
        $this->check();
        $type = $_POST['type'];
        $list = $_POST['list'];
        if($type==1){
            $list = unserialize($row['list']);
            $list = $list[0]['code'];
        }else{
            $list = conv_code($list);
            $tmp['code'] = $list;
            $arr["menu_{$type}_goods_list"] = serialize($tmp);
            $res = $this->query->update("web_menu_goods",$arr," and pt_id='admin' ");
        }
    }

    function bestMenuGsAdd(){
        $this->aside = false;
        $this->footer = false;

        $this->check();
        $idx = $_POST['idx'];
        $type = $_POST['type'];
        $row = $this->query->getRow("web_menu_goods","menu_1_goods_list as list","and pt_id='admin'");
        $list = unserialize($row['list']);
        $list = $list[$type]['code'];
        if( $list != "" ) $list .= ",";
        $list .= $idx;

        $tmp['code'] = $list;
        $arr["menu_1_goods_list"] = serialize($tmp);
        $res = $this->query->update("web_menu_goods",$arr," and pt_id='admin' ");
    }

    function bestMenuGsDelete(){
        $this->check();
        $idx = $_POST['idx'];
        $type = $_POST['type'];
        $row = $this->query->getRow("web_menu_goods","menu_1_goods_list as list","and pt_id='admin'");

        $list = unserialize($row['list']);
        $list = $list[$type]['code'];
        $list = trim($list['code']);
        $list = explode(",",$list);
        $key = array_search($idx,$list);
        if($key=="") return;

        array_splice($list,$key,1);
        $list = implode(",",$list); 
        $tmp['code'] = $list;
        $arr["menu_1_goods_list"] = serialize($tmp);
        $res = $this->query->update("web_menu_goods",$arr," and pt_id='admin' ");
    }



    function bestMenuGsUpdate(){
        $this->check();
        $type = $_POST['type'];
        $list = $_POST['list'];
        $list = unserialize($row['list']);
        $list = $list[$type]['code'];

        $list = conv_code($list);
        $tmp['code'] = $list;
        $arr["menu_1_goods_list"] = serialize($tmp);
        $res = $this->query->update("web_menu_goods",$arr," and pt_id='admin' ");
    }



    function sortableUpdate(){
        $this->aside = false;
        $this->footer = false;
        $this->check();
        $table = $_POST['table'];
        $idx_list = $_POST['idx_list'];
        $arr = explode(",",$idx_list);
        for($i=1;$i<count($arr);$i++){
            unset($value);
            $value['orderby']= "$i";
            $res = $this->query->update($table,$value," and idx={$arr[$i-1]} ");
            echo $res;
        }
    }
    */

}

?>
