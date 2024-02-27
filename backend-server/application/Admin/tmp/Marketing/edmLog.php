    <section class="cont_inner">
        <p class="pg_tit" id="pg_tit"><?=isset($this->tabInfo['name'])?$this->tabInfo['name']:"EDM 발송 기록";?></p>
        <form>
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        EDM 발송 기록 : <b class="cnt"><?=$this->cnt ?></b> 건
                    </span>
                    <!-- <button type="submit"  class="fr btn_small btn_red">변경 사항 적용</button> -->
                </div>
                <div class="chead02_wrap">
                    <table>
                        <colgroup>
                            <col class="w100">   <!-- 아이디 -->
                            <col class="w150">   <!-- 이메일 -->
                            <col class="w200">   <!-- 제목 -->
                            <col class="w70">   <!-- 발송 결과 -->
                            <col class="w70">   <!-- 발송 결과 -->
                            <col class="w150">   <!-- 발송 일시 -->
                            <col class="w70">   <!-- 재전송 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">아이디</th>
                                <th scope="col">이메일</th>
                                <th scope="col">제목</th>
                                <th scope="col" colspan="2">발송 결과</th>
                                <th scope="col">발송 일시</th>
                                <th scope="col">재전송</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach( $this->log->getList($this->col) as $row) {?>
                            <tr class="list<?=$i%2?>">
                                <td><?=$row['mb_id']?></td>
                                <td><?=$row['edml_receiver_email']?></td>
                                <td class="tal dot"><?=$row['edml_send_title']?></td>
                                <td><?=$row['edml_send_res_code']?></td>
                                <td><?=$row['edml_send_res_msg']?></td>
                                <td><?=$row['edml_reg_dt']?></td>
                                <td>
                                    <a href="/Marketing/retryEdm/<?=$row['edml_id']?>" class="btn_small btn_white">재전송</a>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </section>
</div>

