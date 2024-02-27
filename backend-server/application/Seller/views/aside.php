<?php 
if(!defined('_INNER')) exit;
require_once _VIEW."/header.php"; 

$activeDepth1=array();
$activeDepth2 = array();

$search = array();
$search['code_length_eq'] = 2;
$search['use_yn'] = "y";
$search['col'] = "orderby";
$depth1 = $this->gnbModel->get("*",$search,true);
?>
<div id="aside">
    <div class="snb_inner">
<?php 
foreach($depth1 as $d1 ){
    if( !empty($this->tabPageInfo['tab']) && $this->tabPageInfo['tab'] == $d1['tab'] ){
        $activeDepth1 = $d1;
    }
    $search = array();
    $search['tab'] = $d1['tab'];
    $search['code_length_eq'] = 4;
    $search['use_yn'] = "y";
    $search['col'] = "orderby";
    $depth2 = $this->gnbModel->get("*",$search,true);

    $search = array();
    $search['tab'] = $d1['tab'];
    $search['code_length_eq'] = 6;
    $search['use_yn'] = "y";
    $search['col'] = "orderby";

    foreach($depth2 as $d2 ){
        $active = false;
        if( !empty($this->tabPageInfo['upper']) && $d2['code'] == $this->tabPageInfo['upper'] ){
            $activeDepth2 = $d2;
            $active = true;
        }
        $search['upper'] = $d2["code"]; 
        $depth3 = $this->gnbModel->get("*",$search,true);
?>
        <div class="tab <?=$active?"active":""?>">
            <div class="subj"><?=$d2['name']?><span class="braket <?=$active?"active":""?>"></span></div>
            <div class="tab-menu <?=$active?"":"dn"?>">
                <?php  foreach( $depth3 as $m ){?>
                <div class="<?= $m['url']==$this->tabPageInfo['url']?'active':'' ?>">
                    <a href="<?=$m['url']?>"><?=$m['name']?></a> 
                </div>
                <?php } ?>
            </div>
        </div>
        <?php }} ?>
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
