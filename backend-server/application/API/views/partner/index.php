<?php if(!defined('_CHECK')) exit; ?>
<!-- 메인 슬라이드배너 시작 { -->
<div id="mbn_wrap" class="full-width">
    <?php foreach($this->banner->bnList('1') as $item){  ?>
    <div class="mbn_img" style="background-color:<?=$item['bg_color']?>; background-image: url('<?=_BANNER.$item['img_file'] ?>'); background-repeat: no-repeat; background-position: top center;">
        <a href="<?=$item['link_url'] ?>" target="<?=$item['bn_target'] ?>"></a>
    </div>
    <?php } ?>
</div>
<script>
$(document).on('ready', function() {
    $('#mbn_wrap').slick({
        autoplay: true,
        autoplaySpeed: 4000,
        dots: true,
        fade: true
    });
});
</script>
<!-- } 메인 슬라이드배너 끝 -->

<div id="contents" class="main-bg">
    <!-- 베스트상품 시작 { -->
    <div class="cont_wrap marb20">
        <h2 class="mtit">
            <span><?=$this->menuGoods->getMenu(1,'name');?> </span>
            <a id="best_more" href="<?=$this->menuGoods->getMenu(1,'url'); ?>?CateNo=1">더보기 ></a>
        </h2>
        <ul class="bestca_tab">
            <?php $i=0; foreach( unserialize($this->menuGoods->getMenu(1,'goods_list')) as $arr ){ $i++; ?>
            <li class="gradient" onclick="change_href('best_more','<?=$this->menuGoods->getMenu(1,'url'); ?>?CateNo=<?=$i?>')" data-tab="<?='bstab_c'.$i?>" ><span><?=trim($arr['subj']) ?></span></li>
            <?php } ?>
        </ul>
        <div class="bestca pr_desc wli5 mart5">
            <?php $i=0; foreach( unserialize($this->menuGoods->getMenu(1,'goods_list')) as $arr ){ $i++; ?>
            <ul id="bstab_c<?php echo $i?>">
                <?= $this->goods->strList( $this->goods->codeSearch( $arr['code'] ) , 5 ,10) ;?>
            </ul>
            <?php } ?>
        </div>
    </div>
    <script>
    $(document).ready(function(){
        $(".bestca_tab > li:eq(0)").addClass('active');
        $("#bstab_c1").show();

        $(".bestca_tab > li").click(function() {
                var activeTab = $(this).attr('data-tab');
                $(".bestca_tab > li").removeClass('active');
                $(".bestca ul").hide();

                $(this).addClass('active');
                $("#"+activeTab).fadeIn(250);
                });
        });

    function change_href(id_name, href_url){
        $('#'+id_name).attr("href", href_url);   
    }
    </script>
    <!-- } 베스트 상품 끝 -->

    <!-- 강력 추천 상품 시작 { -->
    <div class="cont_wrap marb20">
        <h2 class="mtit"><span><?=$this->menuGoods->getMenu(2,'name'); ?></span><a id="best_more" href="<?=$this->menuGoods->getMenu(2,'url'); ?>">더보기 ></a></h2>
        <div class="pr_desc wli5 mart5">
            <?php $code = unserialize(($this->menuGoods->getMenu(2,'goods_list')) )['code']; ?>
            <?= $this->goods->strList( $this->goods->codeSearch( $code ) , 5 ,10) ;?>
        </div>
    </div>
    <!-- }  강력 추천 상품 끝 -->

    <!-- 신상품 시작 { -->
    <div class="cont_wrap marb20">
        <h2 class="mtit"><span><?=$this->menuGoods->getMenu(5,'name'); ?></span><a id="best_more" href="<?=$this->menuGoods->getMenu(5,'url'); ?>">더보기 ></a></h2>
        <div class="pr_desc wli5 mart5">
            <?php $code = unserialize(($this->menuGoods->getMenu(5,'goods_list')) )['code']; ?>
            <?= $this->goods->strList( $this->goods->codeSearch( $code ) , 5 ,10) ;?>
        </div>
    </div>
    <!-- }  신상품 끝 -->

    <!-- 하단 배너 시작 { -->
    <div id="mb_b_wrap" class="full-width">
        <?php foreach($this->banner->bnList('2') as $item){ echo $item['link_url'];?>
        <div class="mbn_img" style="background-color:<?=$item['bg_color']?>; background-image: url('<?=_BANNER.$item['img_file'] ?>'); background-repeat: no-repeat; background-position: top center;">
            <a href="<?=$item['bn_link'] ?>" target="<?=$item['bn_target'] ?>"></a>
        </div>
        <?php } ?>
    </div>

    <script>
    $(document).on('ready', function() {
        $('#mb_b_wrap').slick({
            autoplay: true,
            autoplaySpeed: 4000,
            dots: false,
            fade: false
        });
    });
    </script>
    <!-- } 하단 배너 끝 -->

    <div id="ft_cs">
        <dl class="cswrap">
            <dt class="tit">고객센터</dt>
            <dd class="tel"><?= $GLOBALS['default']['company_tel']; ?></dd>
            <dd>상담 : <?= $GLOBALS['default']['company_hours']; ?> </dd>
            <dd>점심 : <?= $GLOBALS['default']['company_lunch']; ?></dd>
            <dd>(<?= $GLOBALS['default']['company_close']; ?>)</dd>
        </dl>
        <dl class="bkwrap">
            <dt class="tit">메일주소</dt>
            <dd style="height:35px; font-size:18px; line-height: 1em; color: #222; margin:40px 0 0 0;"><?php echo $GlOBALS['default']['email']; ?></dd>
        </dl>
        <dl class="notice">
            <dt class="tit">
            <a href="/Board/notice" class="bt_more">공지사항</a>
            </dt>
            <dd><a href="https://killdeal.co.kr/bbs/read.php?boardid=13&amp;index_no=14">2021년 추석 연휴 배송 일정 및 고객센터 안내</a><span class="day">2021-09-10</span></dd>
            <dd><a href="https://killdeal.co.kr/bbs/read.php?boardid=13&amp;index_no=13">2021년 설 연휴 배송 일정 및 고객센터 안내</a><span class="day">2021-02-02</span></dd>
            <dd><a href="https://killdeal.co.kr/bbs/read.php?boardid=13&amp;index_no=11">추석 연휴 배송 일정 및 고객센터 안내</a><span class="day">2020-09-16</span></dd>
            <dd><a href="https://killdeal.co.kr/bbs/read.php?boardid=13&amp;index_no=10">8월 14일 고객센터 휴무안내 및 연휴 배송 일정</a><span class="day">2020-08-06</span></dd>
        </dl>
    </div>
</div>
