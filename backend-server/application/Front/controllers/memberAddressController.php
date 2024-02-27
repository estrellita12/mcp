<?php
namespace application\Front\controllers;

use \Exception;

class memberAddressController extends Controller{

    public function init(){
        $this->model = new \application\models\MemberAddressModel();
    }

    public function getList(){
        $search = array();
        $search['mb_id_then_ne'] = $this->userId;
        $row = $this->model->get("*",$search,true);
        if( empty($row) ) $this->response_json("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("list"=>$row));
    }

    public function get(){
        $search = array();
        $search['mbad_idx'] = $this->param['ident'];
        $row = $this->model->get("*",$search);
        if( empty($row) ) $this->response_json("001");
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000",array("data"=>$row));
    }
 
    public function add(){
        $request = array();
        if( !empty($this->request['put']) ) $request = $this->request['put'];

        $value = array();
        $value['memberId'] = $this->userId;
        if( !empty($request['mbad_postcode']) ) $value['postcode'] = $request['mbad_postcode'];
        if( !empty($request['mbad_addr1']) )    $value['address1'] = $request['mbad_addr1'];
        if( !empty($request['mbad_addr2']) )    $value['address2'] = $request['mbad_addr2'];
        if( !empty($request['mbad_recipient']) ) $value['recipient'] = $request['mbad_recipient'];
        if( !empty($request['mbad_tel']) )      $value['tel'] = $request['mbad_tel'];
        if( !empty($request['mbad_password']) ) $value['password'] = $request['mbad_password'];
        if( !empty($request['mbad_etc']) )      $value['extraInfo'] = $request['mbad_etc'];
        if( !empty($request['mbad_default']) )  $value['def'] = $request['mbad_default'];

        $row = $this->model->add($value);
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000");
    }

    public function set(){
        $request = array();
        if( !empty($this->request['post']) ) $request = $this->request['post'];

        $value = array();
        if( !empty($request['mbad_postcode']) ) $value['postcode'] = $request['mbad_postcode'];
        if( !empty($request['mbad_addr1']) )    $value['address1'] = $request['mbad_addr1'];
        if( !empty($request['mbad_addr2']) )    $value['address2'] = $request['mbad_addr2'];
        if( !empty($request['mbad_recipient']) ) $value['recipient'] = $request['mbad_recipient'];
        if( !empty($request['mbad_tel']) )      $value['tel'] = $request['mbad_tel'];
        if( !empty($request['mbad_password']) ) $value['password'] = $request['mbad_password'];
        if( !empty($request['mbad_etc']) )      $value['extraInfo'] = $request['mbad_etc'];
        if( !empty($request['mbad_default']) )  $value['def'] = $request['mbad_default'];

        $row = $this->model->set($value,$this->param['ident']);
        if( !is_array($row) ) $this->result($row);
        $this->response_json("000");
    }
    
}
?>
