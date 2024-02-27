<?php
namespace application\models;

use \PDO;

class BoardModel extends Model
{
    function __construct( ){
        parent::__construct ( 'web_board' );
    }
    
    function getValue($arr,$mode="add"){
        if( empty($arr) ) return;

        if($mode=="add"){  
            $value['bo_reg_dt'] = _DATE_YMDHIS; // 게시판 등록 일시
        }

        if( !empty($arr['group']) )         $value['bogr_id'] = $arr['group']; // 게시판 그룹        
        if( !empty($arr['name']) )          $value['bo_name'] = $arr['name']; // 게시판 명
        if( !empty($arr['skin']) )          $value['bo_skin'] = $arr['skin']; // 게시판 스킨
        if( !empty($arr['category']) )      $value['bo_category'] = $arr['category']; // 분류
        if( !empty($arr['width']) )         $value['bo_width'] = $arr['width']; // 테이블 넓이
        if( !empty($arr['page']) )          $value['bo_page'] = $arr['page']; // 페이지당 목록 수
        if( !empty($arr['title_limit']) )   $value['bo_title_limit'] = $arr['title_limit']; // 제목 길이
        if( !empty($arr['list_perm']) )     $value['bo_list_perm'] = $arr['list_perm']; // 목록보기 권한
        if( !empty($arr['read_perm']) )     $value['bo_read_perm'] = $arr['read_perm']; // 글읽기 권한
        if( !empty($arr['write_perm']) )    $value['bo_write_perm'] = $arr['write_perm']; // 글쓰기 권한
        if( !empty($arr['reply_perm']) )    $value['bo_reply_perm'] = $arr['reply_perm']; // 글답변 권한
        if( !empty($arr['comment_perm']) )  $value['bo_comment_perm'] = $arr['comment_perm']; // 댓글쓰기 권한
        if( !empty($arr['use_secret']) )    $value['bo_use_secret'] = $arr['use_secret']; // 비밀글 사용여부
        if( !empty($arr['content_opt']) )   $value['bo_content_opt'] = $arr['content_opt']; // 글내용 옵션
        if( !empty($arr['t_file']) )        $value['bo_t_file'] = $arr['t_file']; // 상단파일 경로
        if( !empty($arr['d_file']) )        $value['bo_d_file'] = $arr['d_file']; // 하단파일 경로
        if( !empty($arr['t_content']) )     $value['bo_t_content'] = $arr['t_content']; // 상단 내용
        if( !empty($arr['d_content']) )     $value['bo_d_content'] = $arr['d_content']; // 하단 내용
        if( !empty($arr['default_text']) )  $value['bo_default_text'] = $arr['default_text']; // 글쓰기 기본 내용
        
        $value['bo_use_category'] = !empty($arr['use_category']) ? $arr['use_category'] : 'n'; // 분류 사용여부
        $value['bo_use_comment'] = !empty($arr['use_comment']) ? $arr['use_comment'] : 'n'; // 댓글쓰기 사용여부
        $value['bo_use_upload'] = !empty($arr['use_upload']) ? $arr['use_upload'] : 'n'; // 파일업로드 사용여부
        $value['bo_use_reply'] = !empty($arr['use_reply']) ? $arr['use_reply'] : 'n'; // 글답변 사용여부

        $upl = new \application\models\UploadImage(_ROOT._BOARD);
        if( !empty($_FILES['t_img']) && !empty($_FILES['t_img']['name']) ){
            $filename = $upl->upload($_FILES['t_img']);
            if(!empty($filename)) $value['bo_t_img'] = $filename;  // 상단이미지
            $value['bo_t_img_nm'] = $_FILES['t_img']['name'];  // 상단이미지 파일명
        }

        if( !empty($_FILES['d_img']) && !empty($_FILES['d_img']['name'])  ){
            $filename = $upl->upload($_FILES['d_img']);
            if(!empty($filename)) $value['bo_d_img'] = $filename; // 하단이미지
            $value['bo_d_img_nm'] = $_FILES['d_img']['name'];  // 하단이미지 파일명
        }

        if( !empty($arr['t_img_del']) ){
            $upl->del($arr['t_img_del']);
            $value['bo_t_img'] = null;
        }    
        if( !empty($arr['d_img_del']) ){
            $upl->del($arr['d_img_del']);
            $value['bo_d_img'] = null;
        }

        return $value;
    }

    function getWhere(){
        parent::getWhere();
        if( !empty($_REQUEST['group']) && $_REQUEST['group'] != "all")  $this->sql_where .= " and bogr_id = '{$_REQUEST['group']}' ";
        if( !empty($_REQUEST['srch']) && !empty($_REQUEST['kwd']) ){
            if( $_REQUEST['srch'] == "id" ) $this->getSearch("bo_id",$_REQUEST['kwd']);
            if( $_REQUEST['srch'] == "name" ) $this->getSearch("bo_name",$_REQUEST['kwd']);
        }
 
        // 기간 검색
        if( !empty($_REQUEST['term']) ){
            if( $_REQUEST['term'] == "regDate" ){ 
                if( !empty($_REQUEST['beg']) ) $this->getTerm("bo_reg_dt",$_REQUEST['beg'],"ge");
                if( !empty($_REQUEST['end']) ) $this->getTerm("bo_reg_dt",$_REQUEST['end'],"le");
            }
        }

        return $this->sql_where;
    } 
    
    function getOrder(){
        parent::getOrder();
        if( empty($this->sql_order )) $this->sql_order = " order by bo_reg_dt desc ";    // 기본 정렬 방식 설정
        if( !empty($_REQUEST['col']) ){
            if( empty($_REQUEST['colby']) )  $_REQUEST['colby'] = 'asc';

            if( $_REQUEST['col'] == 'regDate' ) $this->sql_order = " order by bo_reg_dt {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'id' ) $this->sql_order = " order by bo_id {$_REQUEST['colby']} ";
            else if( $_REQUEST['col'] == 'name' ) $this->sql_order = " order by bo_name {$_REQUEST['colby']} ";
        }
        return $this->sql_order;
    }    

/*
    function get($id, $col='*'){
        $sql_where = " and idx = '{$id}' ";
        return $this->select( $col, $sql_where );
    }
*/
    function set($arr,$id=''){
        if( empty($id) ) $id = $arr['id'];
        if( empty($id) ) return "003";
        $value = $this->getValue($arr,'set');
        $search = " and bo_id = '{$id}' ";
        return $this->update($value,$search);
    }

    function add($arr){
        $value = $this->getValue($arr,'add');
        $res = $this->insert($value);
        if($res == '000'){
            $ai = $this->selectAuto();
            $res_ai = $ai-1;
            $post_tb_nm = "web_board{$res_ai}_post";
            $comment_tb_nm = "web_board{$res_ai}_comment";
            //$post_sql = $this->create_post_table($post_tb_nm);
            //$comment_sql = $this->create_comment_table($comment_tb_nm);
            $post_sql = $this->create_post_table("web_board{$res_ai}");
            $comment_sql = $this->create_comment_table("web_board{$res_ai}");
            $this->execute($post_sql);
            $this->execute($comment_sql);
            $post_tb_chk = $this->tbExistChk($post_tb_nm);
            $comment_tb_chk = $this->tbExistChk($comment_tb_nm);
            $res = ($post_tb_chk && $comment_tb_chk) ? "000" : "001";
        }
        return $res;
    }    

    function create_post_table($tb_nm){
        return "CREATE TABLE IF NOT EXISTS `{$tb_nm}_post` (
          `bopo_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유번호',
          `bopo_pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '부모 고유번호',
          `bopo_depth` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '답글 깊이',
          `bopo_type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '형식',
          `bopo_order_no` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '등록 순서',
          `bopo_category` varchar(255) NOT NULL DEFAULT '0' COMMENT '분류',
          `bopo_secret_yn` char(1) NOT NULL DEFAULT 'n' COMMENT '비밀글',
          `bopo_use_html` char(1) NOT NULL COMMENT 'HTML 사용여부',
          `user_id` varchar(255) COMMENT '사용자아이디',
          `user_name` varchar(50)  COMMENT '작성자명',
          `bopo_title` varchar(255) NOT NULL COMMENT '글제목',
          `bopo_content` text NOT NULL COMMENT '글내용',
          `bopo_file1` varchar(255) COMMENT '파일첨부1',
          `bopo_file2` varchar(255) COMMENT '파일첨부2',
          `bopo_view_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '조회수',
          `bopo_comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '댓글수',
          `bopo_reg_dt` datetime  COMMENT '등록일시',
          `bopo_update_dt` datetime  COMMENT '등록일시',
          `bopo_ip` varchar(20) COMMENT '작성자IP',
          `bopo_passwd` varchar(20) COMMENT '비밀번호',
          `pt_id` varchar(20) NOT NULL COMMENT '가맹점ID',
          `bopo_main_display` tinyint(4) NOT NULL default 0 COMMENT '메인노출',
          `bopo_main_display_order` int(11) NOT NULL default 0 COMMENT '메인노출순서',
          PRIMARY KEY (`bopo_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='게시판' AUTO_INCREMENT=1;";
    }

    function create_comment_table($tb_nm){
        return "CREATE TABLE IF NOT EXISTS `{$tb_nm}_comment` (
          `boco_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유번호',
          `boco_pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '부모 고유번호',
          `bopo_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '게시글 고유번호',
          `user_id` varchar(255) COMMENT '사용자아이디',
          `user_name` varchar(64) COMMENT '작성자명',
          `boco_comment` text NOT NULL COMMENT '글내용',
          `boco_order_no` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '등록 순서',
          `boco_depth` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '댓글 깊이',
          `boco_reg_dt` DATETIME COMMENT '등록일시',
          `boco_ip` varchar(20) NOT NULL COMMENT '작성자IP',
          `boco_passwd` varchar(20) NOT NULL COMMENT '패스워드',
          PRIMARY KEY (`boco_id`),
             FOREIGN KEY (`bopo_id`) REFERENCES {$tb_nm}_post(bopo_id) ON DELETE CASCADE
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    }

    function remove($id){
        if(empty($id)) return "002";
        $search = " and bo_id = '{$id}' ";
        $res = $this->delete($search);
        if($res == "000"){
            $post_tb = "web_board{$id}_post";
            $comment_tb = "web_board{$id}_comment";            
            $this->execute("DROP TABLE IF EXISTS {$comment_tb}");            
            $this->execute("DROP TABLE IF EXISTS {$post_tb}");            
            $post_chk = $this->tbExistChk($post_tb);
            $comment_chk = $this->tbExistChk($comment_tb);
            $res = ($post_chk!="000" && $comment_chk!="000") ? "000" : "001";
        }
        return $res;
    }

    function tbExistchk($tb_nm){
        $sql = "SELECT 1 FROM Information_schema.tables WHERE table_schema = '"._DBNAME."' AND table_name = '".$tb_nm."'";
        $res = $this->execute($sql);
        return $res;
    }

    function getNameList($bogrId=""){
        $search = array("bo_id_then_ne"=>"1");
        if( !empty($bogrId) ){
            $search['bogr_id'] = $bogrId;
        }
        $row = $this->get("bo_id, bo_name, bogr_id",$search, true);
        $bo_li = array();
        for($i=0;$i<count($row);$i++ ){
            $bo_li[$row[$i]['bo_id']] = "{$row[$i]['bo_name']} ({$row[$i]['bogr_id']})";
        }
        return $bo_li;
    }


}
?>
