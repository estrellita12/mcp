<section class="contents">
    <h1 class="cont_title">쇼핑몰 메뉴</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form name="" method="post" action="/Partner/setMenu/<?=$this->param['ident']?>">
            <input type="hidden" name="mode" value="<?=$this->row['shop_default_menu_mode']?>">
            <input type="hidden" name="id" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <div class="h2">쇼핑몰 메뉴 관리</div>
                <div class="info">메뉴를 별도로 설정하지 않으면 본사 설정을 따라가게 됩니다.<br>수정버튼을 클릭하면 <b>별도의 메뉴</b>가 생성되고, 삭제버튼을 클릭하면 <b>별도의 메뉴</b>가 삭제됩니다.<br>생성된 메뉴를 사용하여 쇼핑몰 레이아웃을 설정 할 수 있으며 각 메뉴에 설정된 상품 리스트는 <b>별도의 메뉴</b>가 존재하는 경우에만 설정이 가능합니다.<br></div>
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
                        <td><input type="text" name="menu_<?=$i?>_title" value="<?=stripslashes($this->row['shop_default_menu']["menu_{$i}_title"])?>" class="w100p" placeholder="이름"></td>
                        <td><input type="text" name="menu_<?=$i?>_url" value='<?=$this->row['shop_default_menu']["menu_{$i}_url"]?>' class="w100p" readonly class="readonly"></td>
                        <td>
                            <?php if($this->row['shop_default_menu_mode']=="modify" && $i<=2){ ?>
                            <a href="/Partner/menuGoodsListPopup/<?=$this->param['ident']?>/<?=$i?>/<?=$this->row['shop_default_menu']["menu_{$i}_goods_list"]?>" onclick="winOpen(this,'goodsListForm','1200','750','yes');return false;" >상품 리스트</a>
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
                <?php if($this->row['shop_default_menu_mode']=="modify"){ ?>
                <a href="/Partner/removeMenu/<?=$this->param['ident']?>" class="btn_medium btn_gray">삭제(본사 설정 반영)</a>
                <?php } ?>
                <input type="submit" value="수정" class="btn_medium btn_theme">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
