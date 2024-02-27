<?php 
if(!defined('_INNER')) exit;
require_once _VIEW."/header.php"; 

$activeDepth2 = array();
$search = array();
$search['tab'] = $this->tabPageInfo['tab'];
$search['code_length_eq'] = 4;
$search['use_yn'] = "y";
$search['col'] = "orderby";
$search['show_grade_then_ge'] = $_SESSION['user_grade'];
$depth2 = $this->gnb->get("*",$search,true);

$search = array();
$search['tab'] = $this->tabPageInfo['tab'];
$search['code_length_eq'] = 6;
$search['use_yn'] = "y";
$search['col'] = "orderby";
$search['show_grade_then_ge'] = $_SESSION['user_grade'];
?>
<div id="aside">
    <div class="snb_inner">
        <?php 
        foreach($depth2 as $item ){
        $active = false;
        if( $item['code'] == $this->tabPageInfo['upper'] ){
        $activeDepth2 = $item;
        $active = true;
        }
        $search['upper'] = $item["code"]; 
        $depth3 = $this->gnb->get("*",$search,true);
        ?>
        <div class="tab <?=$active?"active":""?>">
            <div class="subj"><?=$item['name']?><span class="braket <?=$active?"active":""?>"></span></div>
            <div class="tab-menu <?=$active?"":"dn"?>">
                <?php  foreach( $depth3 as $m ){?>
                <div class="<?= $m['url']==$this->tabPageInfo['url']?'active':'' ?>">
                    <a href="<?=$m['url']?>"><?=$m['name']?></a> 
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <script>
$(function(){
        $(".subj").click(function(){
                if($(this).children(".braket").hasClass("active")){
                $(this).children(".braket").removeClass("active");
                }else{
                $(this).children(".braket").addClass("active");
                }
                $(this).next(".tab-menu").slideToggle(200);
                });
        });
    </script>
</div>
<div id="aside_right">
