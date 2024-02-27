<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form action="/Member/setGrade" method="POST">
            <div class="chead02_wrap">
                <div class="h2">등급 설정</div>
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w120">
                        <col class="w140">
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">등급</th>
                        <th scope="col">등급 이름</th>
                        <th scope="col">할인율</th>
                        <th scope="col">절사</th>
                        <th scope="col">비고</th>
                    </tr>
                    <?php $i=0; foreach( $this->grade->getList($this->col) as $row ) {  ?>
                    <tr>
                        <td class="tac">
                            <input type="hidden" name="li[<?=$i?>][id]" value="<?=$row['mb_grade_id']?>">
                            <?=$row['mb_grade_id']?>
                        </td>
                        <td><input type="text" name="li[<?=$i?>][name]" value="<?=$row['mb_grade_name']?>" size=8></td>
                        <td>
                            <input type="text" name="li[<?=$i?>][sale]" value="<?=$row['mb_grade_price_sale']?>" size=3>
                            <select name="li[<?=$i?>][saleUnit]">
                                <?= get_frm_option("1", $row['mb_grade_sale_unit'], "%")  ?>
                                <?= get_frm_option("2",$row['mb_grade_sale_unit'], "원")  ?>
                            </select>
                        </td>
                        <td>
                            <select name="li[<?=$i?>][saleCut]">
                                <?= get_frm_option("0", $row['mb_grade_sale_cut'], "사용 안함")  ?>
                                <?= get_frm_option("-1",$row['mb_grade_sale_cut'], "십원 단위 절사")  ?>
                                <?= get_frm_option("-2",$row['mb_grade_sale_cut'], "백원 단위 절사")  ?>
                                <?= get_frm_option("-3",$row['mb_grade_sale_cut'], "천원 단위 절사")  ?>
                            </select>
                        </td>
                        <td><input type="text" name="li[<?=$i?>][memo]"  value="<?=$row['mb_grade_adm_memo']?>" size=40></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="수정" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                </div>
            </div>
        </form>
    </div>
</section>
