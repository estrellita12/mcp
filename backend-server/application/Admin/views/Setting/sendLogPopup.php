<section class="contents">
    <h1 class="cont_title">발송 결과</h1>
    <div class="cont_wrap">
        <div class="list_wrap">
            <div class="rect_wrap">
                <span class="cnt_wrap">
                    검색된 기록 : <b class="cnt"><?=$this->cnt ?></b> 개
                </span>
            </div>
            <div class="chead02_wrap">
                <table>
                    <colgroup>
                        <col class="w40">
                        <col class="w120">
                        <col class="w150">
                        <col>
                        <col class="w100">
                        <col class="w100">
                        <col class="w160">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">번호</th>
                            <th scope="col">가맹점</th>
                            <th scope="col">발신인</th>
                            <th scope="col">제목</th>
                            <th scope="col">결과 코드</th>
                            <th scope="col">결과 메세지</th>
                            <th scope="col">발신일시</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=0; foreach( $this->row as $row) {?>
                    <tr class="list<?=$i%2?>">
                        <td><?=$i+1?></td>
                        <td><?=$row['tpsl_sender_shop']?></td>
                        <td><?=$row['mb_id']?>(<?=$row['tpsl_receiver_name']?>)</td>
                        <td class="tal dot"><?=$row['tpsl_send_title']?></td>
                        <td><?=$row['tpsl_send_res_code']?></td>
                        <td><?=$row['tpsl_send_res_msg']?></td>
                        <td><?=$row['tpsl_reg_dt']?></td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

