<section class="cont_inner">
    <p class="pg_tit"><?=isset($this->tabInfo['name'])?$this->tabInfo['name']:"메일 템플릿";?></p>
    <form action="/Member/sendMail/<?=$this->param['ident']?>" method="post">
        <input type="hidden" name="idl" value="<?=$this->param['ident']?>">
        <div class="layout_inner">
            <div class="rect_wrap">
                <span class="cnt_wrap">
                    검색된 메일 : <b class="cnt"><?=$this->cnt ?></b> 개
                </span>
            </div>
            <div class="chead02_wrap">
                <table>
                    <colgroup>
                        <col> 
                        <col class="w100">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">제목</th>
                            <th scope="col">미리보기</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach( $this->template->getList($this->col) as $row) {?>
                        <tr class="list<?=$i%2?>">
                            <td class="tal dot">
                                <label><input type="radio" name="tpId" value="<?=$row['tp_id']?>" required><span class="marl5"><?=$row['tp_title']?></span></label>
                            </td>
                            <td>
                                <a href="#" onclick="winOpen('/Template/mailPreviewPopup/<?=$row['tp_id']?>','edmPopup','900','600','yes');">Example</a>
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

