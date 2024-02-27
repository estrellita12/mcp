<tr>
    <th scope="row">검색어</th>
    <td>
        <select name="srch" id="srch" class="w130">
            <?= get_frm_option('od_no', get_request("srch"), '주문번호'); ?>
            <?= get_frm_option('od_id', get_request("srch"), '주문일련번호'); ?>
            <?= get_frm_option('gs_id', get_request("srch"), '상품번호'); ?>
            <?= get_frm_option('mb_id', get_request("srch"), '주문자 아이디'); ?>
            <?= get_frm_option('orderer_name', get_request("srch"), '주문자 이름'); ?>
            <?= get_frm_option('orderer_cellphone', get_request("srch"), '주문자 전화번호'); ?>
        </select>
        <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
    </td>
</tr>
<tr>
    <th scope="row">가맹점</th>
    <td>
        <select name="shop" class="w200 select2">
            <?= get_frm_option("", "", "전체"); ?>
            <?php foreach($this->pt_li as $id=>$name){ ?>
            <?= get_frm_option($id, get_request("shop"), $name); ?>
            <?php } ?>
        </select>
    </td>
</tr>
<tr>
    <th>기간검색</th>
    <td>
        <div>
            <select name="term" class="w130">
                <?= get_frm_option('od_dt',get_request("term"), '주문일'); ?>
                <?= get_frm_option('od_rcent_dt', get_request("term"), '최종처리일'); ?>
            </select>
            <?=get_date_group('beg','end',false)?>
        </div>
        <div class="mart5">
            <?=get_frm_date('beg',get_request("beg"),"date")?>
            <?=get_frm_date('end',get_request("end"),"date")?>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">결제방법</th>
    <td>
        <label>
            <input type="checkbox" id="paymethod" name="paymethod[]" value="all" <?=get_checked("all",get_request("paymethod"))?> onclick="chkListClick(this)">
            전체
        </label>
        <?php foreach( $GLOBALS['paymethod'] as $key=>$value ){ ?>
        <label>
            <input type="checkbox" name="paymethod[]" value="<?=$key?>" <?=get_checked($key,get_request("paymethod"))?> onclick="chkListClick(this)">
            <?=$value?>
        </label>
        <?php } ?>
    </td>
</tr>
