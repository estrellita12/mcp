<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name']?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?> </h1>
        <form action="/Setting/setConfig" method="POST" onsubmit="fSubmit(this);">
            <div class="rhead01_wrap">
                <h2>정보 노출 설정</h2>
                <p class="info">아마도 고정값으로 진행<p>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">구매 후기</th>
                        <td>
                            <?=get_frm_radio("review_wr_use","1",$this->row['review_wr_use'],"해당 가맹점몰에서만 노출");?>
                            <?=get_frm_radio("review_wr_use","2",$this->row['review_wr_use'],"모든 가맹점에서 노출");?>
                        </td>
                        <th scope="col">게시판 게시글</th>
                        <td>
                            <?=get_frm_radio("board_wr_use","1",$this->row['board_wr_use'],"해당 가맹점몰에서만 노출");?>
                            <?=get_frm_radio("board_wr_use","2",$this->row['board_wr_use'],"모든 가맹점에서 노출");?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>정책 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">장바구니 보관일수</th>
                        <td><input type="text" name="keep_cart_term" class="frm_input w80 tar" maxlength="3"  value="<?=$this->row['keep_cart_term']?>" onkeyup="inputOnlyNumberFormat(this)">일</td>
                        <th scope="col">찜 보관일수</th>
                        <td><input type="text" name="keep_wish_term" class="frm_input w80 tar" maxlength="3"  value="<?=$this->row['keep_wish_term']?>" onkeyup="inputOnlyNumberFormat(this)">일</td>
                    </tr>
                    <tr>
                        <th scope="col">구매확정 강제 승인</th>
                        <td><input type="text" name="keep_final_term" class="frm_input w80 tar" maxlength="3"  value="<?=$this->row['keep_final_term']?>" onkeyup="inputOnlyNumberFormat(this)">일</td>
                        <th scope="col">미입금 주문 내역</th>
                        <td><input type="text" name="keep_misu_term" class="frm_input w80 tar" maxlength="3"  value="<?=$this->row['keep_misu_term']?>" onkeyup="inputOnlyNumberFormat(this)">일</td>
                    </tr>
                    <tr>
                        <th scope="col">페이지 표시수</th>
                        <td><input type="text" name="paging_cnt" class="frm_input w80 tar" maxlength="3"  value="<?=$this->row['paging_cnt']?>" onkeyup="inputOnlyNumberFormat(this)">개</td>
                        <th scope="col">모바일 페이지 표시수</th>
                        <td><input type="text" name="mpaging_cnt" class="frm_input w80 tar" maxlength="3"  value="<?=$this->row['mpaging_cnt']?>" onkeyup="inputOnlyNumberFormat(this)">개</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>CS 운영 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col">상담가능시간</th>
                        <td><input type="text" name="cs_hours" class="frm_input"  value="<?=$this->row['cs_hours']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">점심시간</th>
                        <td><input type="text" name="cs_lunch" class="frm_input"  value="<?=$this->row['cs_lunch']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">휴무일</th>
                        <td><input type="text" name="cs_close" class="frm_input"  value="<?=$this->row['cs_close']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">문의 전화</th>
                        <td><input type="text" name="cs_tel" class="frm_input"  value="<?=$this->row['cs_tel']?>" size=60 ></td>
                    </tr>
                    <tr>
                        <th scope="col">문의 메일</th>
                        <td><input type="text" name="cs_email" class="frm_input"  value="<?=$this->row['cs_email']?>" size=60 ></td>
                    </tr>
                    </tbody>
                </table>
            </div>
 
            <div class="confirm_wrap">
                <input type="submit" value="저장" id="btn_submit" class="btn_large btn_black" accesskey="s">
            </div>
        </form>
    </section>
</div>
<script>
    function fSubmit(obj){
        var min = uncomma( obj['point_use_min'].value );
        obj['point_use_min'].value = min;;
        var max = uncomma( obj['point_use_max'].value );
        obj['point_use_max'].value = max;
    }   
</script>
