<?php
// ---------------------------------------------------------------------
function console($str){
    echo "<script>console.log(\"".$str."\");</script>";
}

function console_log($str){
    echo "<script>console.log(" . json_encode($str) . ");</script>";
}

function alert($str){
    echo "<script>alert(\"".$str."\");</script>";
}

function confirm($str){
    $res = "<script>document.write( confirm('{$str}') );</script>";
    return $res;
}

function move($url = false){
    $str = "<script>";

    if( $url == "close" ){
        $str .= "opener.parent.location.reload();window.close();";
    }else if( !empty($url) ){
        $str .= "document.location.replace('{$url}');";
    }else{
        $str .= "history.back();";
    }
    $str .= "</script>";
    echo $str;
}

function access($msg, $url = false){
    alert($msg);
    move($url);
    exit;
}

// ---------------------------------------------------------------------

function unset_session($name){
    unset($_SESSION[$name]);
}

function set_session($session_name, $value){
    $_SESSION["$session_name"] = $value;
}

function get_session($session_name){
    if( !empty($_SESSION[$session_name]) )
        return $_SESSION["$session_name"];
    else    
        return null;
}

function get_request($name,$type="str", $text=""){
    if( !empty($_REQUEST[$name]) ){
        $val = $_REQUEST[$name];
        switch($type){
        case "str":
            return $val;
        case "number":
            return number_format($val);
        default:
            return $val;
        }
    }
    else return $text;

}

function get_return_url($url){
    if( !empty($_REQUEST['returnUrl']) ){
        return urldecode($_REQUEST['returnUrl']);
    }
    return $url;
}

function get_gs_code(){
    return strtoupper(uniqid().mt_rand(1,9));
}

function get_supply_price($gs_price,$gs_rate){
    $gs_price = only_number($gs_price);
    $gs_rate = only_number($gs_rate);
    $rate = (100 - $gs_rate) / 100;
    //return round($gs_price * $rate, -1);
    return floor($gs_price * $rate);
}

//----------------------------------------------------------------------
function get_column($value, $arr=array(), $include=true){
    $str = "";
    foreach($value as $col){
        if($include){
            if( !in_array($col,$arr) ) continue;
        }else{
            if( in_array($col,$arr) ) continue;
        }
        if(!empty($str)) $str .= ",";
        $str .= $col;
    }
    return $str;
}

function get_column_as($value, $arr=array(), $include=true){
    $str = "";
    foreach($value as $k=>$v){
        if($include){
            if( !in_array($k,$arr) ) continue;
        }else{
            if( in_array($k,$arr) ) continue;
        }
        if(!empty($str)) $str .= ",";
        $str .= " {$v} as {$k} ";
    }
    return $str;
}



// ---------------------------------------------------------------------

function get_qstr($exc=""){
    $exc = explode(",",$exc);
    $url = "";
    $i=0;
    foreach($_REQUEST as $key=>$value){
        if( in_array($key, $exc )) continue;
        if( $key=='url') continue;
        if( !empty($value) ){
            if($i!=0){
                $url.= "&";
            }
            if(is_array($value)){
                foreach($value as $v){
                    $url.= $key.urlencode("[]")."=".urlencode(trim($v))."&";
                }
            }else{
                $url.= $key."=".urlencode(trim($value));
            }
        }
        $i++;
    }
    return $url;
}

function get_query($exc=""){
    return  _SCRIPT_URI."?".get_qstr($exc);
}

function get_sort_tag( $col="idx", $element='', $width="w100" ){
    $preCol =  isset($_REQUEST['col'])?$_REQUEST['col']:"";
    $colby =  isset($_REQUEST['colby'])?$_REQUEST['colby']:"";
    $url = "";
    if($colby=="desc" || $colby=="")  $url = get_query("col,colby")."&col=".$col."&colby=asc";
    if($colby=="asc")  $url = get_query("col,colby")."&col=".$col."&colby=desc";
    $class = $col==$preCol?$colby:"";
    $str = "<th scope=\"col\" class='{$width} sort ".$class."'><a href='#' onclick='reloadArea(\"$url\")' >";
    $str .= $element;
    $str .= "</a></th>";
    return $str;
}
/*
function str_paging_bak($cnt, $curpage, $totalpage, $url, $add=""){
    if($totalpage < 2) return "";
    $ss =  (((int)(($curpage - 1 ) / $cnt)) * $cnt) + 1;
    $se = $ss + $cnt - 1;
    if($se >= $totalpage) $se = $totalpage;

    $str = "<div class='pg_wrap'>";
    $str .= "<span class='pg'>";

    if($curpage==1) $str .= "<span class='img_btn pg_start'>처음</span>";
    else $str .= "<a href='{$url}&page=1' class='img_btn pg_start'>처음</a>";

    if($ss<=1) $str .= "<span class='img_btn pg_prev'>이전</span>";
    else $str .= "<a href='{$url}&page=".($ss-1)."' class='img_btn pg_prev'>이전</a>";

    for($i=$ss;$i<=$se;$i++){
        if($i == $curpage){
            $str .= '<span class="sound_only">열린</span><span class="pg_current">'.$i.'</span><span class="sound_only">페이지</span>';
        }else{
            $str .= "<a href='{$url}&page={$i}' class='pg_btn'  >".$i."<span class='sound_only'>페이지</span></a>";
        }
    }

    if($totalpage<=$se) $str .= "<span class='img_btn pg_next'>다음</span>";
    else $str .= "<a href='{$url}&page=".($se+1)."' class='img_btn pg_next'>맨 끝</a>";

    if($curpage==$totalpage) $str .= "<span class='img_btn pg_end'>맨 끝</span>";
    else $str .= "<a href='{$url}&page=".($totalpage)."' class='img_btn pg_end'>맨 끝</a>";

    $str .= "</span>";
    $str .= "</div>";
    return $str;
}
 */
function str_paging($cnt, $curpage, $totalpage, $url, $add=""){
    if($totalpage < 2) return "";
    $ss =  (((int)(($curpage - 1 ) / $cnt)) * $cnt) + 1;
    $se = $ss + $cnt - 1;
    if($se >= $totalpage) $se = $totalpage;

    $str = "<div class='pg_wrap'>";
    $str .= "<span class='pg'>";

    if($curpage==1) $str .= "<span class='img_btn pg_start'>처음</span>";
    else $str .= "<a href='javascript:;' onclick='reloadArea(\"$url&page=1\")' class='img_btn pg_start'>처음</a>";

    if($ss<=1) $str .= "<span class='img_btn pg_prev'>이전</span>";
    else $str .= "<a href='javascript:;' onclick='reloadArea(\"$url&page=".($ss-1)."\")' class='img_btn pg_prev'>이전</a>";

    for($i=$ss;$i<=$se;$i++){
        if($i == $curpage){
            $str .= '<span class="sound_only">열린</span><span class="pg_current">'.$i.'</span><span class="sound_only">페이지</span>';
        }else{
            $str .= "<a href='javascript:;' onclick='reloadArea(\"{$url}&page={$i}\")' class='pg_btn'  >".$i."<span class='sound_only'>페이지</span></a>";
        }
    }

    if($totalpage<=$se) $str .= "<span class='img_btn pg_next'>다음</span>";
    else $str .= "<a href='javascript:;' onclick='reloadArea(\"{$url}&page=".($se+1)."\")' class='img_btn pg_next'>맨 끝</a>";

    if($curpage==$totalpage) $str .= "<span class='img_btn pg_end'>맨 끝</span>";
    else $str .= "<a href='javascript:;' onclick='reloadArea(\"{$url}&page=".($totalpage)."\")' class='img_btn pg_end'>맨 끝</a>";

    $str .= "</span>";
    $str .= "</div>";
    return $str;
}

// ---------------------------------------------------------------------

function get_checked($field, $value){
    if( is_array($value) ){
        return in_array($field,$value)? ' checked="checked"' : '';
    }else{
        return ($field==$value) ? ' checked="checked"' : '';
    }
}

function get_selected($field, $value){
    return ($field==$value) ? ' selected="selected"' : '';
}

function get_frm_radio($name,$value,$selected,$text='',$other=''){
    if(!$text) $text = $value;
    if($value == $selected)
        return "<label><input type=\"radio\" name=\"$name\" value=\"$value\" checked $other > $text</label>";
    else
        return "<label><input type=\"radio\" name=\"$name\" value=\"$value\" $other> $text</label>";
}

function get_frm_chkbox($name,$value,$selected,$text,$type='toggle'){
    $chk = "";
    if( $value==$selected ) $chk = "checked";
    if($type=='toggle'){
        $str = "<input type=\"hidden\"  name=\"$name\" id=\"$name\" value=\"$selected\">";
        $str .= "<label for=\"{$name}Chk\">";
        $str .= "<input type=\"checkbox\" name=\"{$name}Chk\" id=\"{$name}Chk\" value=\"$value\" onclick=\"chkData('$name')\" $chk>$text</label>";
    }else{
        $str = "<label for=\"{$name}\"><input type=\"checkbox\" name=\"{$name}\" id=\"{$name}\" value=\"$value\" $chk>$text</label>";
    }
    return $str;
}

function get_frm_option($value, $selected, $text=''){
    if(!$text) $text = $value;
    if($value == $selected)
        return "<option value=\"$value\" selected=\"selected\">$text</option>";
    else
        return "<option value=\"$value\">$text</option>";
}

function get_frm_rpp($selected){
    $str = "";
    $str .= get_frm_option('10', $selected, '10줄 정렬'); 
    $str .= get_frm_option('30', $selected, '30줄 정렬'); 
    $str .= get_frm_option('50', $selected, '50줄 정렬'); 
    $str .= get_frm_option('100', $selected, '100줄 정렬'); 
    return $str;
}

// ---------------------------------------------------------------------

function get_substr($txt,$num=20){
    $txt = trim($txt);
    if ( mb_strlen($txt) > $num ){
        return mb_substr($txt,0,$num)."...";
    }else{
        return $txt;
    }
}

function get_img2( $img , $w='auto', $class="" ){
    $imgFile = "https://killdeal.co.kr/img/noimage.gif";
    //if( substr($img,0,7)=="http://" || substr($img,0,8)=="https://" ) $imgFile = $img;
    if( is_file(_ROOT.$img) )  $imgFile = $img;
    return "<img src='{$imgFile}' width='{$w}' class='{$class}' >";
}

function get_img( $path, $img , $w='auto', $class="" ){
    $imgFile = "https://killdeal.co.kr/img/noimage.gif";
    if( substr($img,0,7)=="http://" || substr($img,0,8)=="https://" ) $imgFile = $img;
    else if( is_file(_ROOT.$path."/thumb/".$img) )  $imgFile = $path."/thumb/".$img;
    else if( is_file(_ROOT.$path."/".$img) )  $imgFile = $path."/".$img;
    return "<img src='{$imgFile}' width='{$w}' class='{$class}' >";
}

function get_img_url( $path, $img ){
    $imgFile = "https://killdeal.co.kr/img/noimage.gif";
    if( substr($img,0,7)=="http://" || substr($img,0,8)=="https://" ) $imgFile = $img;
    if( is_file(_ROOT.$path."/".$img) )  $imgFile = $path."/".$img;
    return $imgFile;
}


function img_visible($data, $check, $width="44"){
    if($data == $check)  return "<img src="._ICON."visible.png width={$width}>";
    else  return "<img src="._ICON."invisible.png width={$width}>";
}

function img_success($data, $check, $width="16"){
    if($data == $check) return "<img src="._ICON."success.png width={$width}>";
    else  return "<img src="._ICON."fail.png width={$width}>";
}

function img_yn($data, $check, $width="16"){
    if($data == $check) return "<img src="._ICON."yes.png width={$width}>";
    else  return "<img src="._ICON."no.png width={$width}>";
}

function img_rating($num){
    $str = "<img src='"._ICON."/rating_".$num.".png'>";
    return $str;
}

// ---------------------------------------------------------------------

function get_search_date($fr_date, $to_date, $fr_val, $to_val, $is_last=true){
    $input_end = ' class="frm_input w80" maxlength="10">'.PHP_EOL;
    $js = " onclick=\"searchDate('{$fr_date}','{$to_date}',this.value);\"";

    $frm = array();
    $frm[] = '<label for="'.$fr_date.'" class="sound_only">시작일</label>'.PHP_EOL;
    $frm[] = '<input type="date" name="'.$fr_date.'" value="'.$fr_val.'" id="'.$fr_date.'" size="6">';
    $frm[] = '<label for="'.$to_date.'" class="sound_only">종료일</label>'.PHP_EOL;
    $frm[] = '<input type="date" name="'.$to_date.'" value="'.$to_val.'" id="'.$to_date.'" size="6">';
    $frm[] = '<span class="date_group">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="오늘">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="일주일">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="지난달">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="이번달">';
    if($is_last) $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="전체">';
    $frm[] = '</span>';

    return implode('', $frm);
}


function get_date_group($fr_date, $to_date, $is_last=true){
    $js = " onclick=\"searchDate('{$fr_date}','{$to_date}',this.value);\"";
    $frm = array();
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="오늘">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="일주일">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="지난달">';
    $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="이번달">';
    if($is_last) $frm[] = '<input type="button"'.$js.' class="btn_small btn_white" value="전체">';
    return implode('', $frm);
}



function check_time( $t ){
    $time = date('Y-m-d', strtotime($t));
    $stamp = date('Y-m-d', strtotime(_BEGIN_DATE));
    $future = date('Y-m-d', strtotime(_END_DATE));
    if( $time<=$stamp || $time>=$future ) return false;
    else return true;
}

function get_frm_date($name, $value, $type="time",$other=''){
    if( $type=="time" ){
        $str = ""; 
        $date = ""; $time = ""; $checked = "checked";
        if( !empty($value) && check_time($value) ){
            $tmp = explode(" ",$value);
            $date = $tmp[0]; $time = $tmp[1];
            $checked = "";
        }
        $str .= "<input type=\"date\" name=\"{$name}[]\" value=\"$date\" >\n";
        $str .= "<input type=\"time\" name=\"{$name}[]\" value=\"$time\" class=\"marl5\" >\n";
        $str .= "<input type=\"checkbox\" name=\"{$name}\" value=\"inif\" id=\"{$name}\" $checked> <label for=\"{$name}\">무제한</label>";
        return $str;
    }else{
        return "<input type=\"date\" name=\"{$name}\" value=\"{$value}\" id=\"{$name}\" size=\"6\">";
    }
}

// ---------------------------------------------------------------------

/*
function editor_html_bak($id, $content, $is_dhtml_editor=true){
    static $js = true;

    $editor_url = _JS.'plugin/smarteditor2-2.8.2.3';

    $html = "";
    $html .= "<span class=\"sound_only\">웹에디터 시작</span>";
    if($is_dhtml_editor && $js) {
        $html .= "\n".'<script src="'.$editor_url.'/js/HuskyEZCreator.js"></script>';
        $html .= "\n".'<script>var tw_editor_url = "'.$editor_url.'", oEditors = [];</script>';
        $html .= "\n".'<script src="'.$editor_url.'/config.js"></script>';
        $js = false;
    }

    $smarteditor_class = $is_dhtml_editor ? "smarteditor2" : "";
    $html .= "\n<textarea id=\"$id\" name=\"$id\" class=\"$smarteditor_class\" maxlength=\"65536\" style=\"width:100%\">$content</textarea>";
    $html .= "\n<span class=\"sound_only\">웹 에디터 끝</span>";
    return $html;
}
 */

function editor_html($id, $content, $is_dhtml_editor=true){
    static $js = true;

    $editor_url = _JS.'plugin/editor/smarteditor2';

    $html = "";
    $html .= "<span class=\"sound_only\">웹에디터 시작</span>";
    if($is_dhtml_editor && $js) {
        $html .= "\n".'<script src="'.$editor_url.'/js/HuskyEZCreator.js"></script>';
        $js = false;
    }

    $smarteditor_class = $is_dhtml_editor ? "s_editor" : "";
    $html .= "\n<textarea id=\"$id\" name=\"$id\" class=\"$smarteditor_class\" maxlength=\"65536\" style=\"width:100%\">$content</textarea>";
    $html .= "\n<span class=\"sound_only\">웹 에디터 끝</span>";
    return $html;    
}

function get_text($str, $html=0, $restore=false){
    $source[] = "<";
    $target[] = "&lt;";

    $source[] = ">";
    $target[] = "&gt;";

    $source[] = '\"';
    $target[] = "&#034;";

    $source[] = "\'";
    $target[] = "&#039;";

    if($restore)
        $str = str_replace($target, $source, $str);

    if($html) {
        $source[] = "\n";
        $target[] = "<br/>";
    }

    return str_replace($source, $target, $str);
}

function get_editor_js($id, $is_dhtml_editor=true){
    if($is_dhtml_editor) {
        return "var {$id}_editor_data = oEditors.getById['{$id}'].getIR();\noEditors.getById['{$id}'].exec('UPDATE_CONTENTS_FIELD', []);\nif(jQuery.inArray(document.getElementById('{$id}').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<div><br></div>','<p></p>','<br>','']) != -1){document.getElementById('{$id}').value='';}\n";
    } else {
        return "var {$id}_editor = document.getElementById('{$id}');\n";
    }
}

/*
function contentReplace($mb,$pt,$content,$cert=''){
    $content = str_replace("{아이디}",$mb['id'],$content);
    $content = str_replace("{이름}",$mb['name'],$content);
    $content = str_replace("{쇼핑몰}",$pt['pt_name'],$content);
    $content = str_replace("{도메인}","http://".$pt['shop_url'],$content);
    $content = str_replace("{로고}","http://".$pt['shop_url']._LOGO.$pt['shop_pc_logo'],$content);
    $content = str_replace("{인증번호}",$cert,$content);
    return $content;
}
 */

function contentReplace($arr,$content=''){
    $content = $arr['content'];
    if( !empty($arr['userId']) ) $content = str_replace("{아이디}",$arr['userId'],$content);
    if( !empty($arr['userName']) ) $content = str_replace("{이름}",$arr['userName'],$content);
    if( !empty($arr['senderName']) ) $content = str_replace("{쇼핑몰}",$arr['senderName'],$content);
    if( !empty($arr['shopUrl']) ) $content = str_replace("{도메인}","http://".$arr['shopUrl'],$content);
    if( !empty($arr['shopLogo']) ) $content = str_replace("{로고}","http://".$arr['shopUrl']._LOGO.$arr['shopLogo'],$content);
    if( !empty($arr['certNum']) ) $content = str_replace("{인증번호}",$arr['certNum'],$content);
    if( !empty($arr['goodsName']) ) $content = str_replace("{상품이름}",$arr['goodsName'],$content);
    return $content;
}
//--------------------------------------------------------
function make_thumb($file, $thumb, $t_width){
    $type=getimagesize($file);

    if( $type['mime']=="image/webp" ){
        copy($file,$thumb);
        return true;
    }

    $prod_img = file_get_contents($file);
    $source_image = imagecreatefromstring($prod_img);
    $width = imagesx($source_image);
    $height = imagesy($source_image);
    $t_width = ($width*($t_width/$width));
    $t_height = ($height*($t_width/$width));

    $virtual_image = imagecreatetruecolor($t_width, $t_height); //가상 이미지 만들기
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $t_width, $t_height, $width, $height); //사이즈 변경하여 복사

    if( $type['mime']=="image/gif" ){
        //$output = shell_exec("convert {$file} -resize {$t_width} {$thumb}");
        $output = shell_exec("gifsicle {$file} --resize {$t_width}x{$t_height} > {$thumb}");
        return true;
    }

    if(imagepng($virtual_image, $thumb)){
        return true;
    }else {
        return false;
    }
}

function make_thumb_bak($file, $thumb, $t_width){
    $prod_img = file_get_contents($file);
    $source_image = imagecreatefromstring($prod_img);

    $width = imagesx($source_image);
    $height = imagesy($source_image);
    $t_width = ($width*($t_width/$width));
    $t_height = ($height*($t_width/$width));

    $virtual_image = imagecreatetruecolor($t_width, $t_height); //가상 이미지 만들기
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $t_width, $t_height, $width, $height); //사이즈 변경하여 복사
    if(imagepng($virtual_image, $thumb)){
        return true;
    }else {
        return false;
    }
}






// ---------------------------------------------------------------------

function only_number($str){
    return preg_replace("/[^0-9]*/s", "", $str);
}

// ---------------------------------------------------------------------

function password($passwd){
    return password_hash($passwd,PASSWORD_DEFAULT); 
}

// ---------------------------------------------------------------------

function gs_id($id){
    $str = "<a href=\"/Goods/modify/".$id."?returnUrl=".urlencode(_REQUEST_URI)."\" target='parent'>".$id."</a>";
    return $str;
}

function gs_name($id,$name){
    //$str = "<a href='http://www.customdx.kr/view/{$id}' target='_blank'>";
    $str = "<a href='http://alldeal.kr/Description?id={$id}' target='_blank'>";
    $str .= $name;
    $str .= "</a>";
    return $str;
}

function mb_id($id='', $name=""){
    if(empty($id)) return "<span>비회원</span>";
    $str = "<a href=\"#\" onclick=\"winOpen('/Member/infoPopup/".$id."','memberForm','1200','800','yes');\" >";
    $str .= empty($name)?$id:$name;
    $str .= "</a>";
    return $str;
}

function pt_id($id, $name=""){
    $str = "<a href=\"#\" onclick=\"winOpen('/Partner/infoPopup/".$id."','partnerForm','1200','800','yes');\" >";
    $str .= empty($name)?$id:$name;
    $str .= "</a>";
    return $str;
}

function sl_id($id, $name=""){
    $str = "<a href=\"#\" onclick=\"winOpen('/Seller/infoPopup/".$id."','sellerForm','1200','800','yes');\" >";
    $str .= empty($name)?$id:$name;
    $str .= "</a>";
    return $str;
}

function adm_id($id, $name=""){
    $str = "<a href=\"#\" onclick=\"winOpen('/Setting/administratorInfoPopup/".$id."','AdministratorForm','1200','800','yes');\" >";
    $str .= empty($name)?$id:$name;
    $str .= "</a>";
    return $str;
}


function od_id($id){
    $str = "<a href=\"#\" onclick=\"winOpen('/Order/descPopup/".$id."','descOrderForm','1000','600','yes');\" >";
    $str .= $id;
    $str .= "</a>";
    return $str;
}

function od_no($no){
    $str = "<a href=\"#\" onclick=\"winOpen('/Order/descListPopup/".$no."','orderNoForm','1000','600','yes');\" >";
    $str .= $no;
    $str .= "</a>";
    return $str;
}

function id_history($id,$model){
    if( $_SESSION['user_id']!="admin" ) return "";
    $str = "<a href=\"#\" onclick=\"winOpen('/Popup/history/{$model}/{$id}','historyPopup','1000','600','yes');\" >";
    $str .= "<img src='/public/img/icon/history.png' class='padl5'>";
    $str .= "</a>";
    return $str;
}

function id_log($id,$table){
    if( $_SESSION['user_id']!="admin" ) return "";
    $str = "<a href=\"#\" onclick=\"winOpen('/Popup/updateLog/{$table}/{$id}','historyPopup','1000','600','yes');\" >";
    $str .= "<img src='/public/img/icon/history.png' class='padl5'>";
    $str .= "</a>";
    return $str;
}



// ---------------------------------------------------------------------
function result_log($class,$method,$res,$msg=''){
    $file = _LOG."result_"._DATE_YMD.".txt";
    $arr['DATE'] = _DATE_YMDHIS;
    $arr['ClassName'] = $class;
    $arr['MethodName'] = $method;
    $arr['ResultCode'] = $res;
    $arr['Message'] = $msg;
    error_log(print_r($arr,true) ,3, $file);
}

function debug_log($class,$method,$res,$e=''){
    $file = _LOG."debug_"._DATE_YMD.".txt";
    $arr['DATE'] = _DATE_YMDHIS;
    $arr['ClassName'] = $class;
    $arr['MethodName'] = $method;
    $arr['ErrorCode'] = $res;
    $arr['Exception'] = $e;
    error_log(print_r($arr,true) ,3, $file);
}

function get_list($str,$sep = ","){
    $arr = explode($sep,$str);  
    $arr = array_filter($arr);
    return implode($sep,$arr);
}

function get_lower_price($gs){
    $tag = "";
    $query = $gs['gs_name'];
    $query = str_replace("/"," ",$query);
    $query = str_replace("[핫딜]","",$query);
    $query = str_replace("[MWO]","",$query);
    $query = preg_replace("![0-9]매입!is","",$query);
    $query = preg_replace("![0-9]세트!is","",$query);
    $query = preg_replace("![0-9]개!is","",$query);

    //if( !empty($gs['gs_model_nm']) && !strpos($query, $gs['gs_model_nm']) ) $query .= " \"{$gs['gs_model_nm']}\" ";
    //if( !empty($row['gs_model_nm']) ) $query .= ' "'.$row['gs_model_nm'].'"';
    //if( !empty($gs['gs_brand']) && !strpos($query, $gs['gs_brand']) ) $query .= " \"{$gs['gs_brand']}\" ";
    if( !empty($gs['gs_brand']) ) $query .= " \"{$gs['gs_brand']}\" ";
    $query = urlencode($query);

    $tag = "<a target='_blank' href='https://search.shopping.naver.com/search/all?fo=true&pagingIndex=1&pagingSize=40&productSet=total&query={$query}&sort=price_asc&timestamp=&viewType=list'>N 가격비교</a>";
    return $tag;

    $searchUrl = "https://openapi.naver.com/v1/search/shop.json?query={$query}&display=1&start=1&sort=asc";
    $curlHandle = curl_init($searchUrl);
    curl_setopt_array($curlHandle, [
        CURLOPT_POST => FALSE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => [
            'X-Naver-Client-Id: rwDswBecUOhBvLHQamCR',
            'X-Naver-Client-Secret: 8YIN_AmKiT',
            'Content-Type: application/json'
        ],
    ]);
    $response = curl_exec($curlHandle);
    $itemList = json_decode($response,true);
    $lowerItemLink = "";
    if( !empty($itemList['items']) ){
        $lowerItem = $itemList['items'][0];
        $lowerItemLink = "<div class='mart5'>";
        $lowerItemLink .= "<a target='_blank' href='{$lowerItem['link']}'>";
        $lowerItemLink .= "<img src='{$lowerItem['image']}' width=20px class='marr2'>";
        $lowerItemLink .= number_format($lowerItem['lprice']);
        $lowerItemLink .= "원</a>";
        $lowerItemLink .= "</div>";
    }
    return $tag.$lowerItemLink;
}

// --------------------------------------------------------------------- 2023-05-10 TO GENERATE APPLE SECRET KEY
function encode($data) {	
    $encoded = strtr(base64_encode($data), '+/', '-_');
    return rtrim($encoded, '=');
}

function decode($ori){
    $returnArr = Array();
    $codeArr = explode('.', $ori);
    foreach($codeArr as $code) array_push($returnArr, json_decode(base64_decode($code)));
    return $returnArr;
}

function generateJWT($kid, $iss, $sub, $privKey) {
	$header = [
		'alg' => 'ES256',
		'kid' => $kid
	];
	$body = [
		'iss' => $iss,
		'iat' => time(),
		'exp' => time() + 3600,
		'aud' => 'https://appleid.apple.com',
		'sub' => $sub
	];

	//$privKey = openssl_pkey_get_private(file_get_contents('./key/AuthKey_WMFMCMAH85.pem'));
		
	if (!$privKey){
        echo "no file";
        return false;
	}

	$payload = encode(json_encode($header)).'.'.encode(json_encode($body));

	$signature = '';
	$success = openssl_sign($payload, $signature, $privKey, OPENSSL_ALGO_SHA256);
	if (!$success){
        echo "fail";
        return false;
    } 

	$raw_signature = fromDER($signature, 64);

	return $payload.'.'.encode($raw_signature);
}

 /**
 * @param string $der
 * @param int    $partLength
 *
 * @return string
 */
function fromDER(string $der, int $partLength){
	$hex = unpack('H*', $der)[1];
	if ('30' !== mb_substr($hex, 0, 2, '8bit')) { // SEQUENCE
		throw new \RuntimeException();
	}
	if ('81' === mb_substr($hex, 2, 2, '8bit')) { // LENGTH > 128
		$hex = mb_substr($hex, 6, null, '8bit');
	} else {
		$hex = mb_substr($hex, 4, null, '8bit');
	}
	if ('02' !== mb_substr($hex, 0, 2, '8bit')) { // INTEGER
		throw new \RuntimeException();
	}
	$Rl = hexdec(mb_substr($hex, 2, 2, '8bit'));
	$R = retrievePositiveInteger(mb_substr($hex, 4, $Rl * 2, '8bit'));
	$R = str_pad($R, $partLength, '0', STR_PAD_LEFT);
	$hex = mb_substr($hex, 4 + $Rl * 2, null, '8bit');
	if ('02' !== mb_substr($hex, 0, 2, '8bit')) { // INTEGER
		throw new \RuntimeException();
	}
	$Sl = hexdec(mb_substr($hex, 2, 2, '8bit'));
	$S = retrievePositiveInteger(mb_substr($hex, 4, $Sl * 2, '8bit'));
	$S = str_pad($S, $partLength, '0', STR_PAD_LEFT);
	return pack('H*', $R.$S);
}
/**
 * @param string $data
 *
 * @return string
 */
function preparePositiveInteger(string $data){
	if (mb_substr($data, 0, 2, '8bit') > '7f') {
		return '00'.$data;
	}
	while ('00' === mb_substr($data, 0, 2, '8bit') && mb_substr($data, 2, 2, '8bit') <= '7f') {
		$data = mb_substr($data, 2, null, '8bit');
	}
	return $data;
}
/**
 * @param string $data
 *
 * @return string
 */
function retrievePositiveInteger(string $data){
	while ('00' === mb_substr($data, 0, 2, '8bit') && mb_substr($data, 2, 2, '8bit') > '7f') {
		$data = mb_substr($data, 2, null, '8bit');
	}
	return $data;
}

// ---------------------------------------------------------------------

// 2023-07-03
function encryptAes256($key,$data){
    $payload = json_encode($data);
    $enc = openssl_encrypt($payload, 'aes-256-cbc', $key, true, str_repeat(chr(0), 16));
    return base64_encode($enc);
}

function vnoti($url,$mb_id,$param=[]){
    //$url = "http://vnoti.co.kr/api/point/{$mb['mb_sns_id_3']}/order?od_id={$row['od_no']}&use_point={$row['od_use_point_out']}&type=10";
    //$token = "aJmkfoZdbdJBxFKFom2NLIAycnUS5Xabqo0hJdqgqU/8aZCC5tu6wWD+a8AOIG8tIoMQvvpL0uAVZr+2HBmPOkoGLvJYbBWb2KSCz2aiqMNjIOjIQ/toYGIuLa8F0Yde";
    $token = encryptAes256("20220923",["mb_id"=>$mb_id]);
    $curlHandle = curl_init($url);
    curl_setopt_array($curlHandle, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => false,
        CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $token,
        ),
    ]);
    $response = json_decode(curl_exec($curlHandle),true);
    $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
    curl_close($curlHandle);
    return $response;
}


?>
