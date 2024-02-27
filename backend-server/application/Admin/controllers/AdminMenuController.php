<?php
namespace application\Admin\controllers;

class AdminMenuController extends Controller{
public function init(){}
    public function update(){  
        for($i=0; $i<count($_POST['chk']); $i++)
        {
            // 실제 번호를 넘김
            $k = $_POST['chk'][$i];
            $sql = "update admin_menu set 
                        tab='{$_POST['tab'][$k]}', 
                        code='{$_POST['code'][$k]}', 
                        upper='{$_POST['upper'][$k]}', 
                        name='{$_POST['name'][$k]}', 
                        url='{$_POST['url'][$k]}' 
                    where idx='{$_POST['idx'][$k]}' ";
            echo $this->menu->sql_update($sql);
        }

        access('수정 완료',_PRE_URL);

    }

}

?>
