<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <form name="" method="post" action="/Mypage/setMenu/<?=$this->my['pt_id']?>">
            <input type="hidden" name="id" value="<?=$this->my['pt_id']?>">
            <input type="hidden" name="mode" value="<?=$this->my['shop_default_menu_mode']?>">
            <div class="rhead01_wrap">
                <div class="h2">쇼핑몰 메뉴 관리</div>
                <p class="info"><b>메뉴1,메뉴2</b>만 상품 리스트 변경이 가능하며, <b>메뉴3,메뉴4</b>는 해당 메뉴에 맞게 자동진열됩니다.</p>
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w150">
                        <col class="w200">
                        <col class="w200">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">메뉴</th>
                            <th scope="col">메뉴명</th>
                            <th scope="col">메뉴URL</th>
                            <th scope="col">상품 리스트</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for($i=1;$i<=9;$i++){ ?>
                    <tr>
                        <td>메뉴<?=$i?></td>
                        <td>
                            <input type="text" name="menu_<?=$i?>_title" value="<?=stripslashes($this->my['shop_default_menu']["menu_{$i}_title"])?>" size=20 placeholder="이름">
                        </td>
                        <td>
                            <input type="text" name="menu_<?=$i?>_url" value='<?=$this->my['shop_default_menu']["menu_{$i}_url"]?>' size=30 readonly class="readonly">
                        </td>
                        <td>
                            <?php if($this->my['shop_default_menu_mode']=="modify" && $i<=2){ ?>
                            <a href="/Mypage/menuGoodsListPopup/<?=$i?>/<?=$this->my['shop_default_menu']["menu_{$i}_goods_list"]?>" onclick="winOpen(this,'goodsListForm',screen.width,screen.height,'yes');return false;" >상품 리스트</a>
                            <?php }else if($i<=2){ ?>
                            본사 설정에 따라 진열
                            <?php }else{ ?>
                            자동 진열
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <?php if($this->my['shop_default_menu_mode']=="modify"){ ?>
                <a href="/Mypage/removeMenu/<?=$this->param['ident']?>" class="btn_large btn_gray">삭제(본사 설정 반영)</a>
                <?php } ?>
                <input type="submit" value="저장" class="btn_large btn_theme">
            </div>
        </form>
        <div class="help_wrap">
            <div class="h2">도움말</div>
            <div class="h3">쇼핑몰 메뉴는 무엇인가요?</h3>
            <ul>
                <li>쇼핑몰에서 사용할 메뉴들을 의미 합니다.</li>
            </ul>
            <div class="h3">본사 설정을 따라가고 싶다면 어떻게 하나요?</h3>
            <ul>
                <li>기본값이 본사 설정입니다.</li>
                <li>별도로 설정을 한 경우, 삭제 버튼을 클릭하시면 본사 설정을 따라가게 됩니다.</li>
            </ul>
        </div>
    </div>
</section>
