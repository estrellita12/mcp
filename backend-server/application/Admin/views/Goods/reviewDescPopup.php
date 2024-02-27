<section class="cont_inner">
    <p class="pg_tit"><?=isset($this->tabInfo['name'])?$this->tabInfo['name']:"상품 후기";?></p>
    <form action="/Goods/reviewHidden/<?=$this->param['ident']?>" method="post">
        <div class="rhead01_wrap">
            <div class="h2">상품 후기</div>
            <table>
                <colgroup>
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <td>[상품명] <?=$this->row['gs_rv_name']?></td>
                    </tr>
                    <tr>
                        <td>[옵션] <?=$this->row['gs_rv_opt_name']?></td>
                    </tr>
                    <tr>
                        <td class="review">
                            <div>
                                <img src="<?=$this->mb['mb_img']?>" class="profile_img">
                                <span class="writer"><?=$this->mb['mb_name']?> (<?=$this->mb['mb_id']?>)</span>
                            </div>
                            <div>
                                <?=img_rating($this->row['gs_rv_star_rating'])?> <span class="date"><?=substr($this->row['gs_rv_reg_dt'],0,10)?></span>
                            </div>
                            <div class="content">   
                                <?=$this->row['gs_rv_content']?>
                            </div>
                            <!--
                            <div class="padt10 padb10">
                                <span class="like_cnt"><?=$this->row['gs_rv_like_cnt']?></span>
                            </div>
                            -->
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="btn_wrap tar">
                <input type="submit" class="btn_small btn_red" name="actButton" value="숨김 처리">
            </div>
        </div>
    </form>
    <form action="/Goods/reviewReply/<?=$this->param['ident']?>" method="post">
        <div class="rhead01_wrap">
            <div class="h2">상품 후기 댓글</div>
            <table>
                <colgroup>
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <td><textarea name="reply"><?=$this->row['gs_rv_reply']?></textarea></td>
                    </tr>
                </tbody>
            </table>
            <div class="btn_wrap tar">
                <input type="submit" class="btn_small btn_blue" name="actButton" value="댓글 저장">
            </div>
        </div>
        <div class="confirm_wrap">
            <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
        </div>
    </form>
</section>
