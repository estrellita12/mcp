<section class="cont_inner">
    <p class="pg_tit"><?=isset($this->tabInfo['name'])?$this->tabInfo['name']:"SMS 템플릿";?></p>
    <form action="/Member/sendSms/<?=$this->param['ident']?>" method="post">
        <input type="hidden" name="idl" value="<?=$this->param['ident']?>">
        <div class="layout_inner">
            <div class="rect_wrap">
                <span class="cnt_wrap">
                    검색된 SMS : <b class="cnt"><?=$this->cnt ?></b> 개
                </span>
                <!-- <button type="submit"  class="fr btn_small btn_red">변경 사항 적용</button> -->
            </div>
            <div class="chead02_wrap">
                <table>
                    <colgroup>
                        <col class="w40">   <!-- 아이디 -->
                        <col>   <!-- 제목 -->
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">선택</th>
                            <th scope="col">제목</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach( $this->template->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>">
                            <td><input type="radio" name="tpId" value="<?=$row['tp_id']?>"></td>
                            <td class="tal dot">
                                <a href="#" onclick="winOpen('/Template/smsPopup/<?=$row['tp_id']?>','edmPopup','900','600','yes');">
                                    <?=$row['tp_title']?>
                                </a>
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <button type="submit" class="btn_medium btn_red">발송</button>
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </div>
    </form>
</section>

