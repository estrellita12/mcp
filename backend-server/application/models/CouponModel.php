<?php
namespace application\models;

use \Exception;

class CouponModel extends Model{
    public function __construct( ){
        parent::__construct ( 'web_coupon' );
    }

    public function getValue($arr,$mode="add"){
        if( empty($arr) ) return;
        if($mode == "add"){
            $value['cp_reg_dt'] =  _DATE_YMDHIS; // 등록일시
        }
        $value['cp_update_dt'] =  _DATE_YMDHIS; // 수정 일시

        if( !empty($arr['shop']) )     $value['pt_id'] = $arr['shop']; 
        if( !empty($arr['title']) )     $value['cp_title'] = $arr['title']; 
        if( !empty($arr['explan']) )    $value['cp_explan'] = $arr['explan']; 
        if( !empty($arr['orderby']) )    $value['cp_orderby'] = $arr['orderby']; 
        if( !empty($arr['type']) )      $value['cp_type'] = $arr['type']; 
        if( !empty($arr['saleUnit']) )  $value['cp_sale_unit'] = $arr['saleUnit']; 
        if( !empty($arr['unitCut']) )   $value['cp_unit_cut'] = $arr['unitCut']; 
        if( !empty($arr['salePercent']) )   $value['cp_sale_percent'] = $arr['salePercent']; 
        if( !empty($arr['salePrice']) )     $value['cp_sale_price'] = $arr['salePrice']; 
        if( !empty($arr['useYn']) )     $value['cp_use_yn'] = $arr['useYn']; 
        if( !empty($arr['beginDate']) ) $value['cp_begin_dt'] = implode(" ",$arr['beginDate']); // 배너 출력 시작 일시
        if( !empty($arr['endDate']) )   $value['cp_end_dt'] = implode(" ",$arr['endDate']); // 배너 출력 종료 일시

        try{
            $upl = new \application\models\UploadImage(_ROOT._COUPON);
            if( !empty($arr['listImgDel']) )    $upl->del($arr['oriListImgFile']);
            if( !empty($_FILES['listImgFile']) && !empty($_FILES['listImgFile']['name'])  ){
                $filename = $upl->upload($_FILES['listImgFile']);
                if(!empty($filename)) $value['cp_list_img'] = $filename;
            }
        }catch(Exception $e){
            debug_log( static::class,__method__ ,"005", array("error"=>$e->getMessage()));
        }

        return $value;
    }

    public function set($arr, $id='',$type="arr"){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "002"; 

        if($type=="arr"){
            $value = $this->getValue($arr,'add');
        }else{
            $value = $arr;
        }

        $search = " and cp_id = '{$id}' ";
        return $this->update($value,$search);
    }

    public function add($arr,$type="arr"){
        if($type=="arr"){
            $value = $this->getValue($arr,'add');
        }else{
            $value = $arr;
        }
        return $this->insert($value);
    }

    function remove( $id='' ){
        if(empty($id)) return;
        $search = " and bn_id = '{$id}' ";
        return $this->delete($search);
    }
}
?>
