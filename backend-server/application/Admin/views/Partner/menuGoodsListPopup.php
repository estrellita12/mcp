<section class="contents">
    <h1 class="cont_title">진열 상품 설정</h1>
    <div class="cont_wrap">
        <form action="" method="GET" id="frmSearch" name="frmSearch" onsubmit="return frmCommaSubmit()">
            <div class="search_wrap" id="search_wrap">
                <table>
                    <colgroup>
                        <col class="w100">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch">
                                <?= get_frm_option('gs_id', get_request("srch"), '상품번호'); ?>
                                <?= get_frm_option('gs_name', get_request("srch"), '상품명'); ?>
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
                            <select name="term" class="w130">
                                <?=get_frm_option('gs_reg_dt',get_request("term"),'등록일')?>
                                <?=get_frm_option('gs_update_dt',get_request("term"),'수정일')?>
                            </select>
                            <?=get_search_date('beg','end',get_request("beg"),get_request("end"))?>
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
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_black">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_gray">
                </div>
            </div>
        </form>
        <form action="/Partner/setMenu" method="post" id="selectedGoods">
            <div class="chead02_wrap">
                <table>
                    <colgroup>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <td class="tal rect_wrap">
                            <span class="cnt_wrap">
                                <div class="h2">검색된 총 상품수 : <span class="cnt"><?= number_format( $this->cnt ) ?></span> 개</div>
                            </span>
                            <span class="rpp_wrap">
                                <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                                    <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                                </select>
                            </span>
                            <span class="right_wrap padt4">
                                <button type="button"  class="btn_small btn_blue" onClick="add_goods()">추가</button>
                            </span>
                        </td> 
                        <td class="tal rect_wrap">
                            <span class="cnt_wrap">
                                <div class="h2">선택된 총 상품수 : <span class="cnt" id="selectedCnt"><?=$this->selectedCnt?></span> 개</div>
                            </span>
                            <span class="right_wrap padt4">
                                <button type="button"  class="btn_small btn_blue" onClick="put_goods_list()">변경 사항 적용</button>
                            </span>
                        </td> 
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <div class="chead01_wrap">
                                <table>
                                    <colgroup>
                                        <col class="w40">   <!-- 체크박스 -->
                                        <col class="w80">   <!-- 상품 번호 -->
                                        <col class="w200">  <!-- 상품명  -->
                                        <col class="w60">   <!-- 재고 -->
                                        <col class="w60">   <!-- 재고 -->
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                            <?=get_sort_tag("gs_id","상품번호(ID)")?>
                                            <th scope="col">상품명</th>
                                            <th scope="col">진열</th>
                                            <?=get_sort_tag("gs_stock_qty","재고")?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; foreach($this->goodsModel->get($this->col,$this->search,true,$this->sql) as $row) { ?>
                                    <tr data-idx="<?=$row['gs_id']?>">
                                        <td>
                                            <input type="hidden" name="idl[<?=$i?>]" value="<?=$row['gs_id']?>" disabled>
                                            <input type="checkbox" name="chk[]" value="<?=$i?>" <?=in_array($row['gs_id'],explode(",",$this->param['action']))?"checked":""?>>
                                        </td>
                                        <td><?=$row['gs_id']?></td>
                                        <td class="tal dot"><?=$row['gs_name']?></td>
                                        <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                        <td><?=number_format($row['gs_stock_qty'])?></td>
                                    </tr>
                                    <?php  $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
                        </td>
                        <td style="vertical-align:top">
                            <input type="hidden" name="goodsList<?=$this->param['ident']?>" id="goodsList" value="<?=$this->param['action']?>">
                            <table>
                                <colgroup>
                                    <col class="w60">   <!-- 상품 번호 -->
                                    <col class="w200">  <!-- 상품명  -->
                                    <col class="w50">   <!-- 진열 -->
                                    <col class="w50">   <!-- 재고 -->
                                    <col class="w50">   <!-- 재고 -->
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col">상품 번호</th>
                                        <th scope="col">상품명</th>
                                        <th scope="col">진열</th>
                                        <th scope="col">재고</th>
                                        <th scope="col">삭제</th>
                                    </tr>
                                </thead>
                                <tbody class="sortable" style="height:30px">
                                <?php $i=0; foreach($this->selected as $row) { ?>
                                <tr data-idx="<?=$row['gs_id']?>">
                                    <td><?=$row['gs_id']?></td>
                                    <td class="tal"><?=$row['gs_name']?></td>
                                    <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                    <td><?=number_format($row['gs_stock_qty'])?></td>
                                    <td><button type="button" class="btn_small btn_red" onclick="delete_goods('<?=$row['gs_id']?>')">삭제</button></td>
                                </tr>
                                <?php  $i++; } ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</section>
<script>
function ready(){
    $(".sortable").sortable({
update:function(index){
str = "";
$('.sortable tr').each(function(index){
        var idx = $(this).attr('data-idx');
        if(idx=='') return;
        if(str!="") str += ",";
        str += idx;
        })
$("#goodsList").val(str);
}
})
}

$(function() {
        ready();
        });

function delete_goods(idx){
    $(".sortable tr[data-idx='"+idx+"']").remove();
    idl = "";
    $('.sortable tr').each(function(index){
            var idx = $(this).attr('data-idx');
            if(idx=='') return;
            if(idl!="") idl += ",";
            idl += idx;
            })

    var url = location.href;
    var url_split = url.split("?");
    var last = url_split[0]?.lastIndexOf("/");
    var basic_url = url_split[0].substr(0,last);
    var parameter = url_split[1]?url_split[1]:"";
    location.href = basic_url+"/"+idl+"?"+parameter;
    //location.href = "/Mypage/menuGoodsListPopup/<?=$this->param['ident']?>/"+idl;
}

function add_goods(){
    var $chk = $("input[name='chk[]']");
    var idl="";
    var goods_str = $("#goodsList").val();
    var chk_list =  goods_str.split(",");

    $chk.each(function (index) {
            if ($(this).is(":checked")) {
            var data = $("input[name='idl[" + index + "]']").val();
            if( !(chk_list.includes(data)) ){
            chk_list.push(data);
            }
            }
            });
    chk_list = chk_list.filter(function(item) {
            return item !== null && item !== undefined && item !== '';
            });
    if (chk_list.length > 0) {
        idl = chk_list.join();
    }

    var url = location.href;
    var url_split = url.split("?");
    var last = url_split[0]?.lastIndexOf("/");
    var basic_url = url_split[0].substr(0,last);
    var parameter = url_split[1]?url_split[1]:"";
    location.href = basic_url+"/"+idl+"?"+parameter;
    //location.href = "/Mypage/menuGoodsListPopup/<?=$this->param['ident']?>/"+idl;
}

function put_goods_list(){
    $( "#selectedGoods" ).submit();
    var li = $("#goodsList").val();
    console.log(li);
    /*
    //$(window.opener.load_wrap).load("/Design/planModify?test=asd&goodsId="+li+" #load_wrap");
    $(window.opener.load_wrap).load(window.opener.location.pathname+"?col=field&goodsId="+li+" #load_wrap");
    //var of = window.opener.frmPlan;
    //of.goodsList.value = li;
    setTimeout(function(){
    window.close();
    },400);
     */
}
</script>

