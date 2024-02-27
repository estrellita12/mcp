<section class="contents">
    <h1 class="cont_title">상품 정보</h1>
    <div class="cont_wrap">
        <?=!empty($this->tabs)?$this->tabs:""?>
        <form action="/Seller/setOnlyPartner/<?=$this->param['ident']?>" method="POST" onsubmit="return frmSubmit(this)">
            <input type="hidden" name="id" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <input type="hidden" name="id" value="<?=$this->row['sl_id']?>">
                <div class="h2">지정 가맹점 정보</div>
                <p class="info">가맹점을 지정하면, 해당 가맹점에서만 상품이 판매됩니다.</p>
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">가맹점 지정여부 </th>
                        <td>
                            <?=get_frm_radio("onlyPartnerYn","y",$this->row['sl_only_pt_yn'],"사용");?>
                            <?=get_frm_radio("onlyPartnerYn","n",$this->row['sl_only_pt_yn'],"미사용");?>
                        </td>
                        <th scope="row">지정 가맹점 </th>
                        <td>
                            <select name="onlyPartnerId" class="w130">
                                <option value="">지정안함</option>
                                <?php foreach($this->pt_li as $id=>$name){ ?>
                                <?= get_frm_option($id,$this->row['sl_only_pt_id'],$name); ?>
                                <?php } ?>
                            </select> 
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="chead02_wrap">
                <div class="h2">상품 정보 ( <b class="fc_red"><?= number_format($this->cnt) ?></b> 개 ) </div>
                <table>
                    <colgroup>
                        <col class="w100">
                        <col class="w100">
                        <col class="w130">
                        <col class="w50">
                        <col class="w80">
                        <col class="w70">
                        <col class="w70">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">상품번호(ID)</th>
                            <th scope="col">상품코드</th>
                            <th scope="col">상품명</th>
                            <th scope="col">진열</th>
                            <th scope="col">재고</th>
                            <th scope="col">가맹점 지정 여부</th>
                            <th scope="col">지정 가맹점</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->goods->getList($this->col) as $row){  ?>
                    <tr>
                        <td><?=$row['gs_id']?></td>
                        <td><?=$row['gs_code']?></td>
                        <td class="dot"><?=$row['gs_name']?></td>
                        <td><?=$GLOBALS['gs_stt'][$row['gs_stt']]?></td>
                        <td><?=$row['gs_stock_qty']?></td>
                        <td><?=img_yn($row['gs_only_pt_yn'],"y")?></td>
                        <td><?=empty($row['gs_only_pt_id'])?"없음":pt_id($row['gs_only_pt_id'], $this->pt_li[$row['gs_only_pt_id']])?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="수정" id="btn_submit" class="btn_medium btn_theme" accesskey="s">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </form>
    </div>
</section>
<script>
function frmSubmit(){
    var chk = $("input[name=onlyPartnerYn]:checked").val();
    if( chk == "y" && $("select[name=onlyPartnerId]").val() == "" ) {
        alert("가맹점이 선택되지 않았습니다.");
        return false;
    }
    return true;
}
</script>
