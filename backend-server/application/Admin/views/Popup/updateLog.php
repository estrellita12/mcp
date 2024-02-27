<section class="contents">
    <h1 class="cont_title">변경 기록</h1>
    <div class="cont_wrap">
        <div class="list_wrap">
            <div class="chead02_wrap">
                <table>
                    <colgroup>
                        <col class="w60">
                        <col class="w80">
                        <col>
                        <col class="w70">
                        <col class="w150">
                    </colgroup>
                    <thead>
                        <th>번호</th>
                        <th>아이디</th>
                        <th>변경내용</th>
                        <th>유형</th>
                        <th>일시</th>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach( $this->row as $row) { $row['log_change_data'] = json_decode($row['log_change_data'],true); ?>
                    <tr class="list<?=$i%2?>">
                        <td><?=$row['log_id']?></td>
                        <td><?=$row['log_target_id']?></td>
                        <td class="tal">
                            <ul>
                                <?php foreach($row['log_change_data'] as $col){?>
                                <li>[(<?=$col['col_name']?>) <?=$col['comment']?>] <span class="fc_gray tx_lt"><?=$col['pre_value']?></span>  ▶  <?=$col['change_value']?></li>
                                <?php } ?>
                            </ul>
                        </td>
                        <td><?=$row['log_memo']?></td>
                        <td><?=$row['log_reg_dt']?></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

