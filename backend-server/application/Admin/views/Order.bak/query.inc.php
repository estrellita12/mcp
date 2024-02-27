<tr>
    <th scope="row">검색어</th>
    <td>
        <select name="srch" id="srch" class="w130">
            <?= get_frm_option('no', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문번호'); ?>
            <?= get_frm_option('id', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문일련번호'); ?>
            <?= get_frm_option('goodsId', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '상품번호'); ?>
            <?= get_frm_option('userId', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문자 아이디'); ?>
            <?= get_frm_option('userName', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문자 이름'); ?>
            <?= get_frm_option('userCellphone', isset($_REQUEST['srch'])?$_REQUEST['srch']:"", '주문자 전화번호'); ?>
        </select>
        <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
    </td>
</tr>
<tr>
    <th scope="row">가맹점</th>
    <td>
        <select name="shop" class="w200 select2">
            <?= get_frm_option("", "", "전체"); ?>
            <?php foreach($this->pt_li as $id=>$name){ ?>
            <?= get_frm_option($id, isset($_REQUEST['shop'])?$_REQUEST['shop']:"", $name); ?>
            <?php } ?>
        </select>
    </td>
</tr>
<tr>
    <th>기간검색</th>
    <td>
        <select name="term" class="w130">
            <?= get_frm_option('orderDate', $_REQUEST['term'], '주문일'); ?>
            <?= get_frm_option('rcentDate', $_REQUEST['term'], '최종처리일'); ?>
        </select>
        <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
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

