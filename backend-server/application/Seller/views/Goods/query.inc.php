<tr>
    <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
    <td>
        <select name="srch" id="srch" class="w130">
            <?= get_frm_option('gs_id', $_REQUEST['srch'], '상품번호(ID)'); ?>
            <?= get_frm_option('gs_code', $_REQUEST['srch'], '상품코드'); ?>
            <?= get_frm_option('gs_name', $_REQUEST['srch'], '상품명'); ?>
        </select>
        <input type="text" name="kwd" id="kwd" value="<?=get_request("kwd")?>" size="30">
    </td>
</tr>
<tr>
    <th scope="row">카테고리</th>
    <td>
        <input type="hidden" name="ctg" id="ctg" value="<?=get_request("ctg")?>">
        <?=$this->categoryModel->printDepthList(1, get_request("ctg"), 'ctg1'); ?>
        <?=$this->categoryModel->printDepthList(2, get_request("ctg"), 'ctg2'); ?>
        <?=$this->categoryModel->printDepthList(3, get_request("ctg"), 'ctg3'); ?>
        <?=$this->categoryModel->printDepthList(4, get_request("ctg"), 'ctg4'); ?>
        <?=$this->categoryModel->printDepthList(5, get_request("ctg"), 'ctg5'); ?>
<script>
$(function() {
    $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg3").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg4").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg5").ctg_select_box("#ctg",5,"","=카테고리선택=");
            });
        </script>
    </td>
</tr>
<tr>
    <th>기간 검색</th>
    <td>
        <div>
            <select name="term" class="w130">
                <?= get_frm_option('gs_reg_dt', get_request("term"), '상품등록일'); ?>
                <?= get_frm_option('gs_update_dt', get_request("term"), '상품수정일'); ?>
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
    <th scope="row">재고</th>
    <td>
        <input type="text" name="geQty" class="comma" value="<?=get_request("geQty","number")?>" size=10> 개 이상 ~ 
        <input type="text" name="leQty" class="comma" value="<?=get_request("leQty","number")?>" size=10> 개 이하
    </td>
</tr>
<tr>
    <th scope="row">판매가</th>
    <td>
        <input type="text" name="gePrice" class="comma" value="<?=get_request("gePrice","number")?>" size=10> 원 이상 ~
        <input type="text" name="lePrice" class="comma" value="<?=get_request("lePrice","number")?>" size=10> 원 이하
    </td>
</tr>
<tr>
    <th scope="row">진열 상태</th>
    <td>
        <?=get_frm_radio("isopen","",get_request("isopen"),"전체")?>
        <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
        <?=get_frm_radio("isopen",$key, get_request("isopen"),$value)?>
        <?php } ?>
    </td>
</tr>
