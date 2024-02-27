<section class="contents">
    <h1 class="cont_title">상품 설정</h1>
    <div class="cont_wrap">
    <form method="GET" id="frmSearch" name="frmSearch">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w100">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                        <td>
                            <select name="srch" id="srch">
                                <?= get_frm_option('id', $_REQUEST['srch'], '상품번호(ID)'); ?>
                                <?= get_frm_option('code', $_REQUEST['srch'], '상품코드'); ?>
                                <?= get_frm_option('name', $_REQUEST['srch'], '상품명'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=!empty($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급사</th>
                        <td>
                            <select name="seller" class="w130">
                                <?= get_frm_option('',$_REQUEST['seller'],"전체"); ?>
                                <?php foreach( $this->sl_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,$_REQUEST['seller'],$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg" value="<?=isset($_REQUEST['ctg'])?$_REQUEST['ctg']:""?>">
                            <?=$this->category->printDepthList(1, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg1'); ?>
                            <?=$this->category->printDepthList(2, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg2'); ?>
                            <?=$this->category->printDepthList(3, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg3'); ?>
                            <?=$this->category->printDepthList(4, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg4'); ?>
                            <?=$this->category->printDepthList(5, isset($_REQUEST['ctg'])?$_REQUEST['ctg']:"", 'ctg5'); ?>
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
                                <?=get_frm_option('regDate',$_REQUEST['term'],'등록일')?>
                                <?=get_frm_option('updateDate',$_REQUEST['term'],'수정일')?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
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
                            <?=get_frm_radio("isopen","",isset($_REQUEST['isopen'])?$_REQUEST['isopen']:"","전체")?>
                            <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
                            <?=get_frm_radio("isopen",$key,isset($_REQUEST['isopen'])?$_REQUEST['isopen']:"",$value)?>
                            <?php } ?>
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
    <form>
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
                                <div class="h2">검색된 총 상품수 : <span class="cnt"><?= number_format( $this->goods->getCnt() ) ?></span> 개</div>
                            </span>

                            <span class="rpp_wrap">
                                <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                                    <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                                </select>
                            </span>
                            <span class="right_wrap padt4">
                                <button type="button"  class="btn_small btn_blue fr" onClick="add_goods()">추가</button>
                            </span>
                        </td> 
                        <td class="tal rect_wrap">
                            <span class="cnt_wrap">
                                <div class="h2">검색된 총 상품수 : <span class="cnt" id="cfCnt"><?=$this->gsCnt?></span> 개</div>
                            </span>
                            <span class="right_wrap padt4">
                                <button type="button"  class="btn_small btn_blue fr" onClick="put_goods_list()">변경 사항 적용</button>
                            </span>
                        </td> 
                    </tr>
                    <tr>
                        <td style="vertical-align:top">
                            <div class="chead01_wrap">
                                <table>
                                    <colgroup>
                                        <col class="w40">   <!-- 상품 번호 -->
                                        <col class="w80">   <!-- 상품 번호 -->
                                        <col class="w200">  <!-- 상품명  -->
                                        <col class="w60">   <!-- 재고 -->
                                        <col class="w60">   <!-- 재고 -->
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                            <?=get_sort_tag("id","상품번호(ID)")?>
                                            <th scope="col">상품명</th>
                                            <th scope="col">진열</th>
                                            <?=get_sort_tag("stockQty","재고")?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach($this->goods->getList($this->col) as $row) { ?>
                                        <tr data-idx="<?=$row['gs_id']?>">
                                            <td>
                                                <input type="hidden" name="idl[<?=$i?>]" value="<?=$row['gs_id']?>">
                                                <input type="checkbox" name="chk[]" value="<?=$i?>" <?=in_array($row['gs_id'],explode(",",$this->param['ident']))?"checked":""?>>
                                            </td>
                                            <td><input type="hidden" name="goodsList[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                                            <td class="tal dot"><?=$row['gs_name']?></td>
                                            <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                            <td><?=number_format($row['gs_stock_qty'])?></td>
                                        </tr>
                                        <?php  $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?= str_paging("10", $_REQUEST['page'], ceil($this->goods->getCnt()/$_REQUEST['rpp']), get_query('page') ); ?>
                        </td>
                        <td style="vertical-align:top">
                            <input type="hidden" name="goodsList" id="goodsList" value="<?=$this->param['ident']?>">
                            <table>
                                <colgroup>
                                    <col class="w60">   <!-- 상품 번호 -->
                                    <col class="w200">  <!-- 상품명  -->
                                    <col class="w50">   <!-- 진열 -->
                                    <col class="w50">   <!-- 재고 -->
                                    <col class="w40">   <!-- 삭제 -->
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
                                    <?php $i=0; foreach($this->gsList as $row) { ?>
                                    <tr data-idx="<?=$row['gs_id']?>">
                                        <td><input type="hidden" name="goodsList[]" value="<?=$row['gs_id']?>"><?=$row['gs_id']?></td>
                                        <td class="tal"><?=$row['gs_name']?></td>
                                        <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                        <td><?=number_format($row['gs_stock_qty'])?></td>
                                        <td><a href="javascript::" onclick="delete_goods('<?=$row['gs_id']?>')">X</a></td>
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

function delete_goods(idx){
    $(".sortable tr[data-idx='"+idx+"']").remove();

            str = "";
    $('.sortable tr').each(function(index){
        var idx = $(this).attr('data-idx');
        if(idx=='') return;
        if(str!="") str += ",";
        str += idx;
    })

            var url = location.href;
            var arr = url.split("?");
            var last = arr[0].lastIndexOf("/");
            var para = arr[1]?arr[1]:"";
            location.href = arr[0].substr(0,last)+"/"+str+"?"+arr[1];
    }

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

    function add_goods(){
        var chk_list = new Array();
        var $chk = $("input[name='chk[]']");

        $chk.each(function (index) {
            if ($(this).is(":checked")) {
                chk_list.push($("input[name='idl[" + index + "]']").val());
            }
        });

        if (chk_list.length > 0) {
            idl = chk_list.join();
        }
        if (idl == "") {
            alert("처리할 자료를 하나 이상 선택해 주십시오.");
            return false;
        } else {
            var url = location.href;
            var arr = url.split("?");
            location.href = "<?=_SCRIPT_URL?>,"+idl+"?"+arr[1];
        }
    }

    function put_goods_list(){
        var li = $("#goodsList").val();
        //$(window.opener.load_wrap).load("/Design/planModify?test=asd&goodsId="+li+" #load_wrap");
        $(window.opener.load_wrap).load(window.opener.location.pathname+"?col=field&goodsId="+li+" #load_wrap");
        //var of = window.opener.frmPlan;
        //of.goodsList.value = li;
        setTimeout(function(){
            window.close();
        },400);
    }
</script>
