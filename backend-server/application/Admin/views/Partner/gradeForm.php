<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form action="/Partner/setGrade" method="POST">
            <div class="chead02_wrap">
                <div class="h2">등급 설정</div>
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w120">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">등급</th>
                        <th scope="col">등급 이름</th>
                        <th scope="col">비고</th>
                    </tr>
                    <?php $i=0; foreach( $this->grade->getList($this->col) as $row ) {  ?>
                    <tr>
                        <td class="tac">
                            <input type="hidden" name="li[<?=$i?>][id]" value="<?=$row['pt_grade_id']?>">
                            <?=$row['pt_grade_id']?>
                        </td>
                        <td><input type="text" name="li[<?=$i?>][name]" value="<?=$row['pt_grade_name']?>" class="w100p"></td>
                        <!--
                        <td>
                            <input type="text" name="li[<?=$i?>][sale]" value="<?=$row['pt_grade_price_sale']?>" size=3>
                            <select name="li[<?=$i?>][saleUnit]">
                                <?= get_frm_option("0", $row['pt_grade_sale_unit'], "%")  ?>
                                <?= get_frm_option("1",$row['pt_grade_sale_unit'], "원")  ?>
                            </select>
                        </td>
                        <td>
                            <select name="li[<?=$i?>][saleCut]">
                                <?= get_frm_option("0", $row['pt_grade_sale_cut'], "사용 안함")  ?>
                                <?= get_frm_option("10",$row['pt_grade_sale_cut'], "십원 단위 절사")  ?>
                                <?= get_frm_option("100",$row['pt_grade_sale_cut'], "백원 단위 절사")  ?>
                                <?= get_frm_option("1000",$row['pt_grade_sale_cut'], "천원 단위 절사")  ?>
                            </select>
                        </td>
                        -->
                        <td><input type="text" name="li[<?=$i?>][memo]"  value="<?=$row['pt_grade_adm_memo']?>" class="w100p"></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                </div>
            </div>
        </form>
    </div>
</section>
