<tr>
    <th scope="row">검색어</th>
    <td>
        <select name="srch" id="srch" class="w130">
            <?= get_frm_option('no', get_request("srch"), '주문번호'); ?>
            <?= get_frm_option('id', get_request("srch"), '주문일련번호'); ?>
            <?= get_frm_option('goodsId', get_request("srch"), '상품번호'); ?>
            <?= get_frm_option('userId', get_request("srch"), '주문자 아이디'); ?>
            <?= get_frm_option('userName', get_request("srch"), '주문자 이름'); ?>
            <?= get_frm_option('userCellphone', get_request("srch"), '주문자 전화번호'); ?>
        </select>
        <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
    </td>
</tr>
<tr>
    <th scope="row">가맹점</th>
    <td>
        <select name="shop" class="w250 select2">
            <?= get_frm_option("", "", "전체"); ?>
            <?php foreach($this->pt_li as $id=>$name){ ?>
            <?= get_frm_option($id, get_request("shop"), $name); ?>
            <?php } ?>
        </select>
    </td>
</tr>
<tr>
    <th scope="row">공급사</th>
    <td>
        <select name="seller" class="w250 select2">
            <?= get_frm_option("", "", "전체"); ?>
            <?php foreach($this->sl_li as $id=>$name){ ?>
            <?= get_frm_option($id, get_request("seller"), $name); ?>
            <?php } ?>
        </select>
    </td>
</tr>
<tr>
    <th>기간검색</th>
    <td>
        <select name="term" class="w130">
            <?= get_frm_option('orderDate', get_request("term"), '주문일'); ?>
            <?= get_frm_option('rcentDate', get_request("term"), '최종처리일'); ?>
        </select>
        <?=get_search_date('beg','end',get_request("beg"),get_request("end"))?>
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

