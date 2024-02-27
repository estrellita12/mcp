<?php
namespace application\models;

use \PDO;

class GnbMenuModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_gnb_menu' );
    }

    function getValue($arr){
        if(!empty( $arr['id']) )         $value['pt_id'] = $arr['id'];

        if(!empty( $arr['menu_1_title']) )         $value['menu_1_title'] = $arr['menu_1_title'];
        if(!empty( $arr['menu_2_title']) )         $value['menu_2_title'] = $arr['menu_2_title'];
        if(!empty( $arr['menu_3_title']) )         $value['menu_3_title'] = $arr['menu_3_title'];
        if(!empty( $arr['menu_4_title']) )         $value['menu_4_title'] = $arr['menu_4_title'];
        if(!empty( $arr['menu_5_title']) )         $value['menu_5_title'] = $arr['menu_5_title'];
        if(!empty( $arr['menu_6_title']) )         $value['menu_6_title'] = $arr['menu_6_title'];
        if(!empty( $arr['menu_7_title']) )         $value['menu_7_title'] = $arr['menu_7_title'];
        if(!empty( $arr['menu_8_title']) )         $value['menu_8_title'] = $arr['menu_8_title'];
        if(!empty( $arr['menu_9_title']) )         $value['menu_9_title'] = $arr['menu_9_title'];

        if(!empty( $arr['menu_1_url']) )         $value['menu_1_url'] = $arr['menu_1_url'];
        if(!empty( $arr['menu_2_url']) )         $value['menu_2_url'] = $arr['menu_2_url'];
        if(!empty( $arr['menu_3_url']) )         $value['menu_3_url'] = $arr['menu_3_url'];
        if(!empty( $arr['menu_4_url']) )         $value['menu_4_url'] = $arr['menu_4_url'];
        if(!empty( $arr['menu_5_url']) )         $value['menu_5_url'] = $arr['menu_5_url'];
        if(!empty( $arr['menu_6_url']) )         $value['menu_6_url'] = $arr['menu_6_url'];
        if(!empty( $arr['menu_7_url']) )         $value['menu_7_url'] = $arr['menu_7_url'];
        if(!empty( $arr['menu_8_url']) )         $value['menu_8_url'] = $arr['menu_8_url'];
        if(!empty( $arr['menu_9_url']) )         $value['menu_9_url'] = $arr['menu_9_url'];
        /*
        if(!empty( $arr['goodsList1']) )         $value['menu_1_goods_list'] = implode(",",$arr['goodsList1']);
        if(!empty( $arr['goodsList2']) )         $value['menu_2_goods_list'] = implode(",",$arr['goodsList2']);
        if(!empty( $arr['goodsList3']) )         $value['menu_3_goods_list'] = implode(",",$arr['goodsList3']);
        if(!empty( $arr['goodsList4']) )         $value['menu_4_goods_list'] = implode(",",$arr['goodsList4']);
        if(!empty( $arr['goodsList5']) )         $value['menu_5_goods_list'] = implode(",",$arr['goodsList5']);
        if(!empty( $arr['goodsList6']) )         $value['menu_6_goods_list'] = implode(",",$arr['goodsList6']);
        if(!empty( $arr['goodsList7']) )         $value['menu_7_goods_list'] = implode(",",$arr['goodsList7']);
        if(!empty( $arr['goodsList8']) )         $value['menu_8_goods_list'] = implode(",",$arr['goodsList8']);
        if(!empty( $arr['goodsList9']) )         $value['menu_9_goods_list'] = implode(",",$arr['goodsList9']);
         */
        if(isset( $arr['goodsList1']) )         $value['menu_1_goods_list'] = $arr['goodsList1'];
        if(isset( $arr['goodsList2']) )         $value['menu_2_goods_list'] = $arr['goodsList2'];

        return $value;
    }
/*
    function get($id, $col='*'){
        $search = " and pt_id = '{$id}' ";
        return $this->select( $col, $search );
    }
 */
    function set($arr, $id=''){
        if(empty($id)) $id = $arr['id'];
        if(empty($id)) return "002";
        if($arr['mode']=="add"){
            $value = $this->getValue($arr,'add');
            return $this->insert($value);
        }else{
            $value = $this->getValue($arr,'set');
            $search = " and pt_id = '{$id}' ";
            return $this->update($value,$search);
        }
    }

    function remove($id){
        $search = " and pt_id = '{$id}' ";
        return $this->delete($search);
    }

/*
    function getMenu($type, $col){
        $pt_id = _PT_ID;

        $sql = "SELECT menu_{$type}_{$col} from web_shop_menu where pt_id='{$pt_id}' ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $default = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT menu_{$type}_{$col} from web_shop_menu where pt_id='admin' ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        foreach($admin as $key => $val){
            if($default[$key] == null || $default[$key] == "" )  $default[$key] = $admin[$key];
        }
        return $default[ "menu_{$type}_{$col}" ];
    }

    function getMenuList(){
        $pt_id = _PT_ID;
        //$sql = "SELECT * from web_shop_menu where pt_id='{$pt_id}'";
        $sql = "SELECT * from web_shop_menu where pt_id='admin'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
 */
}
?>
