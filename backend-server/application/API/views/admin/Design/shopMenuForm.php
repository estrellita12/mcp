<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name']?></h1>
        <form action="/Design/shopMenuFormUpdate" method="POST">
            <div class="chead01_wrap">
                <div class="info"><p>※ 메뉴 별 이름 및 상품 리스트 설정 페이지 > 순서에 대해서는 어떻게 할 것인지 고민 필요</p></div>
                <table>
                    <colgroup>
                        <col class="w80">
                        <col class="w70">
                        <col class="w200">
                        <col class="w300">
                        <col>
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">구분</th>
                            <th scope="col">노출 순서</th>
                            <th scope="col">메뉴 이름</th>
                            <th scope="col">메뉴 URL</th>
                            <th scope="col">상품 리스트</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="4">메뉴1</td>
                        <td rowspan="4"><input type="text" name="menu_1_order" value='<?=$this->row["menu_1_order"]?>' size=2 placeholder="순서"></td>
                        <td rowspan="4"><input type="text" name="menu_1_name" value='<?=$this->row["menu_1_name"]?>' size=20></td>
                        <td rowspan="4"><input type="text" name="menu_1_url" value='<?=$this->row["menu_1_url"]?>' size=30 class="readonly" readonly></td>
                        <td class="padl10 tal">
                            <input type="text" name="menu_1_goods_list[]" value="<?=$this->row['menu_1_goods_list'][0]['subj']?>" size=10>
                            <a href="/Design/bestMenuPopupForm/0" onclick="win_open(this,'win','1200','750','yes');return false;" >상품 리스트</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="padl10 tal">
                            <input type="text" name="menu_1_goods_list[]" value="<?=$this->row['menu_1_goods_list'][1]['subj']?>" size=10>
                            <a href="/Design/bestMenuPopupForm/1" onclick="win_open(this,'win','1200','750','yes');return false;" >상품 리스트</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="padl10 tal">
                            <input type="text" name="menu_1_goods_list[]" value="<?=$this->row['menu_1_goods_list'][2]['subj']?>" size=10>
                            <a href="/Design/bestMenuPopupForm/2" onclick="win_open(this,'win','1200','750','yes');return false;" >상품 리스트</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="padl10 tal">
                            <input type="text" name="menu_1_goods_list[]" value="<?=$this->row['menu_1_goods_list'][3]['subj']?>" size=10>
                            <a href="/Design/bestMenuPopupForm/3" onclick="win_open(this,'win','1200','750','yes');return false;" >상품 리스트</a>
                        </td>
                    </tr>

                    <?php for($i=2;$i<6;$i++){ ?>
                    <tr>
                        <td>메뉴<?=$i?></td>
                        <td><input type="text" name="menu_<?=$i?>_order" value='<?=$this->row["menu_{$i}_order"]?>' size=2 placeholder="순서"></td>
                        <td><input type="text" name="menu_<?=$i?>_name" value='<?=$this->row["menu_{$i}_name"]?>' size=20></td>
                        <td><input type="text" value='<?=$this->row["menu_{$i}_url"]?>' size=30 class="readonly" readonly></td>
                        <td class="padl10 tal">
                            <p><a href="/Design/menuPopupForm/<?=$i?>" onclick="win_open(this,'win','1200','750','yes');return false;" >상품 리스트</a></p>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php for($i=6;$i<=9;$i++){ ?>
                    <tr>
                        <td>메뉴<?=$i?></td>
                        <td><input type="text" name="menu_<?=$i?>_order" value='<?=$this->row["menu_{$i}_order"]?>' size=2 placeholder="순서"></td>
                        <td><input type="text" name="menu_<?=$i?>_name" value='<?=$this->row["menu_{$i}_name"]?>' size=20></td>
                        <td><input type="text" name="menu_<?=$i?>_url" value='<?=$this->row["menu_{$i}_url"]?>' size=30></td>
                        <td class="padl10 tal">
                            <p>개별 상품 설정 불가 페이지</p>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn btn_large btn_black" accesskey="s">
                </div>
            </div>
        </form>
    </section>
</div>
