<?php if(!defined('_INNER')) exit; ?>

<?php require_once _VIEW."/header.php"; ?>

<div id="aside">
    <div class="snb_header">
        <h2><?= $preTab['name'] ?></h2>
    </div>
    <div class="snb_inner">
        <?php  foreach($this->gnb->getDepthList( 2, $preTab['code'] ) as $item ){ ?>
        <div class="tab">
            <div class="subj"><?=$item['name']?></div>
            <div class="tab-menu" >
                <?php  foreach($this->gnb->getDepthList( 3, $item['code'] ) as $m ){?>
                <div class="<?= $m['url']==_SCRIPT_URL?'active':'' ?>"><a href="<?=$m['url']?>"><?=$m['name']?></a></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<script>
$(function(){
        $(".tab").click(function(){
                $(this).children(".tab-menu").slideToggle(200);
                });
        });
</script>

