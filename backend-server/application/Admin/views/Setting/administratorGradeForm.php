<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form action="/Administrator/setGrade" method="POST">
            <div class="chead02_wrap">
                <div class="h2">등급 설정</div>
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w200">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">등급</th>
                        <th scope="col">등급 이름</th>
                        <!--
                        <th scope="col">할인율</th>
                        <th scope="col">절사</th>
                        -->
                        <th scope="col">비고</th>
                    </tr>
                    <?php $i=0; foreach( $this->grade->getList($this->col) as $row ) {  ?>
                    <tr>
                        <td class="tac">
                            <input type="hidden" name="li[<?=$i?>][id]" value="<?=$row['adm_grade_id']?>">
                            <?=$row['adm_grade_id']?>
                        </td>
                        <td><input type="text" name="li[<?=$i?>][name]" value="<?=$row['adm_grade_name']?>" class="w100p"></td>
                        <!--
                        <td>
                            <input type="text" name="sale[<?=$i?>]" value="<?=$row['adm_grade_price_sale']?>" size=3>
                            <select name="saleUnit[<?=$i?>]">
                                <?= get_frm_option("1", $row['adm_grade_sale_unit'], "%")  ?>
                                <?= get_frm_option("2",$row['adm_grade_sale_unit'], "원")  ?>
                            </select>
                        </td>
                        <td>
                            <select name="saleCut[<?=$i?>]">
                                <?= get_frm_option("0", $row['adm_grade_sale_cut'], "사용 안함")  ?>
                                <?= get_frm_option("10",$row['adm_grade_sale_cut'], "십원 단위 절사")  ?>
                                <?= get_frm_option("100",$row['adm_grade_sale_cut'], "백원 단위 절사")  ?>
                                <?= get_frm_option("1000",$row['adm_grade_sale_cut'], "천원 단위 절사")  ?>
                            </select>
                        </td>
                        -->
                        <td><input type="text" name="li[<?=$i?>][memo]"  value="<?=$row['adm_grade_adm_memo']?>" class="w100p"></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                </div>
            </form>
        </div>
        <div class="help_wrap">
            <div class="h2">도움말</div>
            <div class="h3">등급에 따라 어떤 것이 다르게 동작하나요?</div>
            <ul>
                <li>등급에 따라 관리자페이지 각 탭 및 페이지에 대한 접근 권한이 달리 설정됩니다.</li>
                <li>접근 권한은 <a href="/Setting/adminMenuList">환경설정 > 관리자 메뉴 > 최고 관리자</a> 에서 설정 할 수 있습니다.</li>
            </ul>
        </div>
    </div>
</section>
