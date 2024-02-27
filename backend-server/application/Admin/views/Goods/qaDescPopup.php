<section class="contents">
    <p class="cont_title">상품 문의</p>
    <div class="cont_wrap">
        <form action="/Goods/qaHidden/<?=$this->param['ident']?>" method="post">
            <div class="rhead01_wrap">
                <div class="h2">상품 문의</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>문의 제목</th>
                        <td><?=$this->row['gs_qa_title']?></td>
                        <th>문의 유형</th>
                        <td><?=$GLOBALS['qa_type'][$this->row['gs_qa_type']]?></td>
                    </tr>
                    <tr>
                        <th>작성자</th>
                        <td><?=mb_id($this->row['mb_id'])?></td>
                        <th scope="row">작성일시</th>
                        <td><?=$this->row['gs_qa_reg_dt']?></td>
                    </tr>
                    <tr>
                        <th scope="row">상품번호(ID)</th>
                        <td><?=gs_id($this->row['gs_id'])?></td>
                        <th>상품명</th>
                        <td><?=gs_name($this->row['gs_id'],$this->gs['gs_name'])?></td>
                    </tr>
                    <tr>
                        <th>판매자</th>
                        <td><?=sl_id($this->gs['sl_id'], $this->sl_li[$this->gs['sl_id']])?></td>
                        <th>가맹점</th>
                        <td><?=pt_id($this->row['gs_qa_pt_id'], $this->pt_li[$this->row['gs_qa_pt_id']])?></td>
                    </tr>
                    <tr>
                        <th>이메일 주소</th>
                        <td><?=$this->row['gs_qa_writer_email']?></td>
                        <th>전화번호</th>
                        <td><?=$this->row['gs_qa_writer_cellphone']?></td>
                    </tr>
                    <tr>
                        <th>문의 내용</th>
                        <td colspan="3">
                            <div class="message">
                                <?=$this->row['gs_qa_content']?>
                            </div>
                        </td>
                    </tr>
                    <?php if($this->row['gs_qa_hidden_yn']=='y'){ ?>
                    <tr>
                        <th>숨김 처리 여부</th>
                        <td colspan="3">해당 문의 글은 적합하지 않은 내용을 포함하고 있어 숨김처리 되었습니다.</td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="btn_wrap tar">
                    <?php if($this->row['gs_qa_hidden_yn']=='y'){ ?>
                    <?php } else { ?>
                    <input type="submit" class="btn_small btn_red" name="actButton" value="숨김 처리">
                    <?php } ?>
                </div>
            </div>
        </form>
        <form action="/Goods/qaAnswer/<?=$this->param['ident']?>" method="post">
            <input type="hidden" name="userId" value="<?=$this->row['mb_id']?>">
            <input type="hidden" name="emailNoticeYn" value="<?=$this->row['gs_qa_email_notice_yn']?>">
            <input type="hidden" name="writerEmail" value="<?=$this->row['gs_qa_writer_email']?>">
            <input type="hidden" name="cellphoneNoticeYn" value="<?=$this->row['gs_qa_cellphone_notice_yn']?>">
            <input type="hidden" name="writerCellphone" value="<?=$this->row['gs_qa_writer_cellphone']?>">
            <div class="rhead01_wrap">
                <div class="h2">상품 문의 답변</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>답변 일시</th>
                        <td><?=$this->row['gs_qa_answer_dt']?></td>
                    </tr>
                    <tr>    
                        <th>답변 내용</th>
                        <td><textarea name="answer"><?=$this->row['gs_qa_answer']?></textarea></td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn_wrap tar">
                    <input type="submit" class="btn_small btn_blue" name="actButton" value="답변 저장">
                </div>
            </div>
            <div class="confirm_wrap">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
