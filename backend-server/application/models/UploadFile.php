<?php
namespace application\models;

class UploadFile{
    var $upl_dir;
    var $max_file_size;

    function __construct( $dir, $size='' ){
        $this->upl_dir = $dir;
        $this->max_file_size = $size;
    }

    function get_extension($filename){
        $array = explode(".", $filename);
        return strtolower($array[sizeof($array)-1]);
    }

    function create_new_filename($filename, $is_srand=true){
        $pattern = "/[#\&\+\-%@=\/\\:;,'\"\^`~\|\!\?\*\$#<>\(\)\[\]\{\}]/";
        $filename = preg_replace("/\s+/", "", $filename);
        $filename = preg_replace($pattern, "", $filename);
        $filename = preg_replace_callback(
            "/[가-힣]+/",
            function($matches){return base64_encode($matches[0]);},
                $filename);
        $filename = preg_replace($pattern, "", $filename);
        $prepend = '';

        if($is_srand) {
            $ext = $this->get_extension($filename);
            $new_filename = $this->new_chars_id().'.'.$ext;

            // 동일한 이름의 파일이 있으면 파일명 변경
            if(is_file($this->upl_dir.'/'.$new_filename)) {
                for($i=0; $i<20; $i++) {
                    $prepend = str_replace('.', '_', microtime(true)).'_';

                    if(is_file($this->upl_dir.'/'.$prepend.$new_filename)) {
                        usleep(mt_rand(100, 10000));
                        continue;
                    } else {
                        break;
                    }
                }
            }

            $new_filename = $prepend.$new_filename;

        } else {
            $new_filename = $filename;
        }

        return $new_filename;
    }

    function upload(&$file){
        if( is_array($file) ){
            if( !empty($file['name']) ){
                $ext = $this->get_extension($file['name']);
                if( !$this->set_file_array($ext, 'file') ) $this->set_error('허용되지 않은 파일입니다.');
                if(!is_dir($this->upl_dir)) $this->set_error('업로드 디렉터리가 존재하지 않습니다.');
                $filename = $this->create_new_filename($file['name'], true);
                if(move_uploaded_file($file['tmp_name'], $this->upl_dir.'/'.$filename)) {
                    @chmod($this->upl_dir.'/'.$filename, TB_FILE_PERMISSION);
                    @unlink($file['tmp_name']);
                    return $filename;
                } else {
                    @unlink($file['tmp_name']);
                    $this->set_error($file['tmp_name']." ".$this->upl_dir.'/'.$filename." 파일 업로드에 실패했습니다.");
                }
            }
        }else{
            return;
        }
    }

    function uploadUrl($url){
        $file = parse_url($url);
        $ext = $this->get_extension($file['path']);
        if( !$this->set_file_array($ext) ) $this->set_error('허용되지 않은 파일입니다.');
        if(!is_dir($this->upl_dir)) $this->set_error('업로드 디렉터리가 존재하지 않습니다.');
        $filename = $this->create_new_filename($file['path'], true);
        $res = file_put_contents($this->upl_dir.'/'.$filename,file_get_contents($url));
        if(!$res){
            debug_log( static::class,"005",$url." URL 업로드에 실패했습니다.");
            $this->set_error($url." URL 업로드에 실패했습니다.");
        }
        return $filename;
    }

    function new_chars_id(){
        $len = 30;
        $chars = "abcdefghjklmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789";

        srand((double)microtime()*1000000);

        $i = 0;
        $str = '';

        while($i < $len) {
            $num = rand() % strlen($chars);
            $tmp = substr($chars, $num, 1);
            $str .= $tmp;
            $i++;
        }

        return $str;
    }

    // 업로드 허용가능한 파일 검사
    function set_file_array($ext, $gubun='img')
    {
        /*
        if($gubun == 'img') $arr_ext = array('gif','jpg','jpeg','png','ico');
        else $arr_ext = array('php','cgi','php3','ph3','ph','pl','html','htm','jsp','asp','js','ht');
         */
        //$arr = array('gif','jpg','jpeg','png','ico','pdf');
        $arr = array('gif','jpg','jpeg','png','ico','pdf','xlsx','xls');

        return in_array($ext, $arr);
    }

    // 파일삭제
    function del($filename){
        if(!preg_match("/^(http[s]?:\/\/)/", $filename)){
            if(is_file($this->upl_dir.'/'.$filename) && $filename) {
                @unlink($this->upl_dir.'/'.$filename);
            }
        }
    }

    // 파일이름변경
    function set_rename($filename){
        rename($this->upl_dir.'/'.$filename,$this->upl_dir.'/'.$filename."_del");
    }

    // Error Message
    function set_error($message){
        echo "<meta charset='utf-8'>";
        echo "<script>alert('".$message."');history.go(-1);</script>";
        debug_log( static::class,"005",array("message"=>$message)); 
        exit;
    }

}
