<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name'];?></h1>
        <form action="/Partner/gradeFormUpdate" method="POST">
            <div class="chead01_wrap">
                <h2>등급 설정</h2>
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
                    <?php $i=0; foreach( $this->query->getRowAll("web_seller_grade","*","","order by idx desc") as $row ) {  ?>
                    <tr>
                        <td class="tac">
                            <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                            <?=$row['idx']?>
                        </td>
                        <td><input type="text" name="name[<?=$i?>]" value="<?=$row['name']?>" size=8></td>
                        <td>
                            <input type="text" name="sale[<?=$i?>]" value="<?=$row['sale']?>" size=3>
                            <select name="sale_unit[<?=$i?>]">
                                <?= get_frm_option("0", $row['sale_unit'], "%")  ?>
                                <?= get_frm_option("1",$row['sale_unit'], "원")  ?>
                            </select>
                        </td>
                        <td>
                            <select name="sale_cut[<?=$i?>]">
                                <?= get_frm_option("0", $row['sale_cut'], "사용 안함")  ?>
                                <?= get_frm_option("10",$row['sale_cut'], "십원 단위 절사")  ?>
                                <?= get_frm_option("100",$row['sale_cut'], "백원 단위 절사")  ?>
                                <?= get_frm_option("1000",$row['sale_cut'], "천원 단위 절사")  ?>
                            </select>
                        </td>
                        <td><input type="text" name="memo[<?=$i?>]"  value="<?=$row['memo']?>" size=40></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
                </div>
            </form>
        </div>
    </section>
</div>
