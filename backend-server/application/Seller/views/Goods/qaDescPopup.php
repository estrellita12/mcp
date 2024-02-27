<section class="contents">
    <h1 class="cont_title">상품 문의</h1>
    <div class="cont_wrap">
    <form action="/Goods/qaHidden/<?=$this->param['ident']?>" method="post">
        <div class="rhead01_wrap">
            <div class="h2">상품 문의</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <td>작성일시</td>
                        <td><?=$this->row['gs_qa_reg_dt']?></td>
                    </tr>
                    <tr>
                        <td>상품번호(ID)</td>
                        <td><?=gs_id($this->row['gs_id'])?></td>
                    </tr>
                    <tr>
                        <td>상품명</td>
                        <td><?=gs_name($this->row['gs_id'],$this->gs['gs_name'])?></td>
                    </tr>
                    <tr>
                        <td>문의 유형</td>
                        <td><?=$GLOBALS['qa_type'][$this->row['gs_qa_type']]?></td>
                    </tr>
                    <tr>
                        <td>작성자</td>
                        <td><?=$this->row['mb_id']?></td>
                    </tr>
                    <tr>
                        <td>이메일 주소</td>
                        <td><?=$this->row['gs_qa_writer_email']?></td>
                    </tr>
                    <tr>
                        <td>전화번호</td>
                        <td><?=$this->row['gs_qa_writer_cellphone']?></td>
                    </tr>
                    <tr>
                        <td>가맹점</td>
                        <td><?=$this->pt_li[$this->row['gs_qa_pt_id']]?></td>
                    </tr>
                    <tr>
                        <td>문의 제목</td>
                        <td><?=$this->row['gs_qa_title']?></td>
                    </tr>
                    <tr>
                        <td>문의 내용</td>
                        <td><?=$this->row['gs_qa_content']?></td>
                    </tr>
                    <?php if($this->row['gs_qa_hidden_yn']=='y'){ ?>
                    <tr>
                        <td>숨김 처리 여부</td>
                        <td>해당 문의 글은 적합하지 않은 내용을 포함하고 있어 숨김처리 되었습니다.</td>
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
                        <td>답변 일시</td>
                        <td><?=$this->row['gs_qa_answer_dt']?></td>
                    </tr>
                    <tr>    
                        <td>답변 내용</td>
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
