<?php require_once _LIB.'goodsinfo.lib.php'; ?>
<script src="/public/js/goodsinfo.js"></script>
<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"><?=$preMenu['name'];?></h1>
        <form name="fForm" action="/Goods/set/<?=$this->param['ident']?>" method="POST" onsubmit="return fsubmit(document.frm);">
            <input type="hidden" name="idx" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <h2>카테고리 관리</h2>
                <p class="info">선택된 카테고리에 최상위 카테고리는 대표 카테고리로 자동설정되며, 최소 1개의 카테고리는 등록하셔야 합니다. </p>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">카테고리 추가</th>
                        <td>
                            <input type="hidden" id="ctg" value="<?=$_REQUEST['ctg']?>">
                            <div class="fixed-clear">
                                <div class="w20p fl"><?=$this->category->printDepthList(1, $_REQUEST['ctg'], 'ctg1', ' class="ctgmulti-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(2, $_REQUEST['ctg'], 'ctg2', ' class="ctgmulti-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(3, $_REQUEST['ctg'], 'ctg3', ' class="ctgmulti-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(4, $_REQUEST['ctg'], 'ctg4', ' class="ctgmulti-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(5, $_REQUEST['ctg'], 'ctg5', ' class="ctgmulti-select" multiple' ); ?></div>
                            </div>
                            <div class="tac padt10"><button type="button" class="btn_small btn_blue" id=ctg_add >카테고리 추가</button></div>
                        </td>
<script>
$(function() {
    $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg3").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg4").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
    $("#ctg5").ctg_select_box("#ctg",5,"","=카테고리선택=");
});
</script>
                    </tr>
                    <tr>
                        <th scope="row">추가된 카테고리</th>
                        <td>
                            <div>
                                <input type="hidden" name="ctg" value="<?=$this->row['ctg'];?>">
                                <input type="hidden" name="ctg2" value="<?=$this->row['ctg2'];?>">
                                <input type="hidden" name="ctg3" value="<?=$this->row['ctg3'];?>">
                                <select name="sel_ctg" id="sel_ctg" size="5" class="multiple-select" multiple >
                                    <?php if($ctg=$this->category->getCtgNav($this->row['ctg'])){ ?>
                                    <option value="<?=$this->row['ctg']?>"><?=$ctg?></option>
                                    <?php } ?>
                                    <?php if($ctg=$this->category->getCtgNav($this->row['ctg2'])){ ?>
                                    <option value="<?=$this->row['ctg2']?>"><?=$ctg?></option>
                                    <?php } ?>
                                    <?php if($ctg=$this->category->getCtgNav($this->row['ctg3'])){ ?>
                                    <option value="<?=$this->row['ctg3']?>"><?=$ctg?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="tac padt10">
                                <button class="btn_small btn_white">▲위로</button>
                                <button class="btn_small btn_white">▼아래로</button> 
                                <button class="btn_small btn_red">카테고리 삭제</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>기본 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">공급사</th>
                        <td>
                            <input type="text" name="sl_id" value="<?=get_data($this->row['sl_id'])?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">상품 번호</th>
                        <td>
                            <input type="text" name="idx" value="<?=get_data($this->row['idx'])?>" size="40" class="readonly" readonly >
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">상품 코드</th>
                        <td>
                            <input type="text" name="gcode" value="<?=get_data($this->row['gcode'])?>" size="40">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">상품명</th>
                        <td>
                            <input type="text" name="gname" value="<?=get_data($this->row['gname'])?>" size="100" class="required" required>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">짧은 설명</th>
                        <td>
                            <p class="info">상품 약어, 간략한 상품명으로써 택배송장 출력과 물류 담당자의 빠른 인식을 위하여 사용할 수 있습니다.</p>
                            <input type="text" name="explan" value="<?=get_data($this->row['explan'])?>" size="100">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">키워드</th>
                        <td>
                            <p class="info">단어와 단어 사이는 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑 </p>
                            <input type="text" name="keywords" value="<?=get_data($this->row['keywords'])?>" size="100">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">브랜드명</th>
                        <td>
                            <input type="text" name="brand" value="<?=get_data($this->row['brand'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">모델명</th>
                        <td>
                            <input type="text" name="model_nm" value="<?=get_data($this->row['model_nm'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">모델No</th>
                        <td>
                            <input type="text" name="model_no" value="<?=get_data($this->row['model_no'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">원산지(제조국)</th>
                        <td>
                            <input type="text" name="origin" value="<?=get_data($this->row['origin'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">제조사</th>
                        <td>
                            <input type="text" name="maker" value="<?=get_data($this->row['maker'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">생산연도</th>
                        <td>
                            <input type="text" name="make_year" value="<?=get_data($this->row['make_year'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">제조일자</th>
                        <td>
                            <input type="text" name="make_dm" value="<?=get_data($this->row['make_dm'])?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">시즌</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_season'] as $key=>$value ){ ?>
                            <?=get_frm_radio("season",$key,$this->row['season'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">남녀 구분</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_sex'] as $key=>$value ){ ?>
                            <?=get_frm_radio("sex",$key,$this->row['sex'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">과세설정</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_tax'] as $key=>$value ){ ?>
                            <?=get_frm_radio("tax",$key,$this->row['tax'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">판매여부</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
                            <?=get_frm_radio("isopen",$key,$this->row['isopen'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>옵션 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">상품 주문 옵션</th>
                        <td>
                            <p class="info">옵션은 반드시 1개 이상 존재해야 합니다.</p>
                            <table>
                                <colgroup>
                                    <col>
                                    <col class="w100">
                                    <col class="w80">
                                    <col class="w80">
                                    <col class="w100">
                                    <col class="w60">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col">옵션</th>
                                        <th scope="col">추가금액</th>
                                        <th scope="col">재고수량</th>
                                        <th scope="col">통보수량</th>
                                        <th scope="col">사용여부</th>
                                        <th scope="col">삭제</th>
                                    </tr>
                                </thead>
                                <tbody id="ropt">
                                <?php if(!empty($this->row['idx'])){  foreach($this->option->selectAll("*"," and gs_id = {$this->row['idx']} and type = 1 ") as $opt){?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="opt[idx][]" value="<?=$opt['idx']?>">
                                        <input type="text" name="opt[opt_name][]" value="<?=$opt['opt_name']?>" class="w100p opt_name">
                                    </td>
                                    <td><input type="text" name="opt[add_price][]" value="<?=$opt['add_price']?>" class="tar" size=5></td>
                                    <td><input type="text" name="opt[stock_qty][]" value="<?=$opt['stock_qty']?>" class="tar" size=3></td>
                                    <td><input type="text" name="opt[noti_qty][]" value="<?=$opt['noti_qty']?>" class="tar" size=3></td>
                                    <td>
                                        <select name="opt[use_yn][]">
                                            <?=get_frm_option('y',$opt['use_yn'],'사용')?>
                                            <?=get_frm_option('n',$opt['use_yn'],'미사용')?>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn_ssmall btn_gray delopt">삭제</button></td>
                                </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                            <div class="tac padt10"><button type="button" class="btn_small btn_red" id="ropt_add">옵션 추가</button></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>가격 및 재고</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">시중 가격</th>
                        <td>
                            <input type="text" name="normal_price" value="<?=get_data($this->row['normal_price'])?>" class="tar" size="15"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급 가격</th>
                        <td>
                            <input type="text" name="supply_price" value="<?=get_data($this->row['supply_price'])?>" class="tar" size="15"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">판매 가격</th>
                        <td>
                            <input type="text" name="goods_price" value="<?=get_data($this->row['goods_price'])?>" class="tar" size="15"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주문 한도</th>
                        <td>
                            최소 <input type="text" name="odr_max" value="<?=get_data($this->row['odr_max'])?>" class="tar" size="5"> 개,  
                            최대 <input type="text" name="odr_min" value="<?=get_data($this->row['odr_min'])?>" class="tar" size="5"> 개
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">판매 기간 설정</th>
                        <td>
                            <?=get_frm_date('begin_dt', $this->row['begin_dt']);?> ~ <?=get_frm_date('end_dt', $this->row['end_dt']);?> 
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">구매 가능 레벨</th>
                        <td>
                            <select name="buy_grade">
                                <?=get_frm_option("", $this->row['buy_grade'],"제한없음"); ?>
                                <?php foreach($this->query->getRowAll("web_member_grade","idx,name","and name!=''","order by idx desc") as $row){ ?>
                                <?=get_frm_option($row['idx'],$this->row['buy_grade'],"[".$row['idx']."] ".$row['name']); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>배송비</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">배송비 구분</th>
                        <td>
                            <?php foreach( $GLOBALS['dv_type'] as $key=>$value ){ ?>
                            <?=get_frm_radio("dv_type",$key,$this->row['dv_type'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">유료 배송비</th>
                        <td>
                            <input type="text" name="sc_cost" value="<?=get_data($this->row['dv_cost'])?>" size="10"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">최소 주문 금액</th>
                        <td>
                            <input type="text" name="sc_minimum" value="<?=get_data($this->row['dv_minimum'])?>" size="10"> 원
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">배송 가능 지역</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_zone'] as $key=>$value ){ ?>
                            <?=get_frm_radio("zone",$key,$this->row['zone'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>요약 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row" class="th_bg">상품군 선택</th>
                        <td>
                            <select name="info_type" id="info_type"></select>
                        </td>
                    </tr>
                    </tbody>
                    <tbody id="info_value">
                    <?php foreach($this->row['info_value'] as $key=>$val){ ?>
                    <tr>
                        <th><?=$item_info[$this->row['info_type']]['article'][$key][0] ?></th>
                        <td><input type="text" name="info[]" value="<?=$val?>" size="40"></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>인증 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">인증번호</th>
                        <td>
                            <p class="info">전기용품, 유아 안전용품 등 안전검사를 거쳐야 하는 상품의 경우 해당기관에서 부여한 인증번호를 입력합니다.</p>
                            <input type="text" name="certno" value="<?=get_data($this->row['certno'])?>" id="" class="frm_input">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">인증유효 시작일</th>
                        <td><input type="text" name="avlst_dm" value="<?=get_data($this->row['avlst_dm'])?>" id="" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">인증유효 마지막일</th>
                        <td><input type="text" name="avled_dm" value="<?=get_data($this->row['avled_dm'])?>" id="" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">발급일자</th>
                        <td><input type="text" name="issuedate" value="<?=get_data($this->row['issuedate'])?>" id="" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">인증일자</th>
                        <td><input type="text" name="certdate" value="<?=get_data($this->row['certdate'])?>" id="" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">인증기관</th>
                        <td><input type="text" name="cert_agency" value="<?=get_data($this->row['cert_agency'])?>" id="" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">인증분야</th>
                        <td><input type="text" name="certfield" value="<?=get_data($this->row['certfield'])?>" id="" class="frm_input"></td>
                    </tr>
                    <tr>
                        <th scope="row">식품재료/원산지</th>
                        <td><input type="text" name="material" value="<?=get_data($this->row['material'])?>" id="" class="frm_input"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <h2>상세 정보</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">이미지1 (640*640)</th>
                        <td>
                            <input type="hidden" name="ori_limg_file" id="limg_file" value="<?=$this->row['limg_file']?>">
                            <input type="file" name="limg_file">
                            <input type="checkbox" name="limg_file_del" value="<?=$this->row['limg_file']?>" id="limg_file_del"> <label for="limg_file_del">삭제</label>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">이미지2(640*640)</th>
                        <td>
                            <input type="hidden" name="ori_limg_file" id="limg_file" value="<?=$this->row['limg_file']?>">
                            <input type="file" name="limg_file">
                            <input type="checkbox" name="limg_file_del" value="<?=$this->row['limg_file']?>" id="limg_file_del"> <label for="limg_file_del">삭제</label>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">이미지3(640*640)</th>
                        <td>
                            <input type="hidden" name="ori_limg_file" id="limg_file" value="<?=$this->row['limg_file']?>">
                            <input type="file" name="limg_file">
                            <input type="checkbox" name="limg_file_del" value="<?=$this->row['limg_file']?>" id="limg_file_del"> <label for="limg_file_del">삭제</label>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?=editor_html('detail', get_text($this->row['detail'],0)); ?></td>
                    </tr>   
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td><textarea name="memo"><?=isset($this->row['memo'])?$this->row['memo']:""?></textarea></td>
                    </tr>   
                    </tbody>
                </table>
            </div>
            <div class="chead01_wrap">
                <h2>상품 변경 내역</h2>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                        <col>
                    </colgroup>
                    <thead>
                        <th scope="col">수정 일시</th>
                        <th scope="col">변경항목</th>
                        <th scope="col">변경전</th>
                        <th scope="col">변경후</th>
                        <th scope="col">내용</th>
                        <th scope="col">처리자</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
$(function(){
    $('#ctg_add').click(function(){
        var is_option_check = function()
        {
            var chk = true;
            $("select[name^=ctg] option:selected").each(function() {
                chk = false;
                return false;
            });

            if(chk)
                alert('카테고리를 하나이상 선택하세요.');

            return chk;
        }

        if(is_option_check())
            return;

        var sel_count = $("select#sel_ctg option").length;
        if(sel_count >= 3) {
            alert('카테고리는 최대 3개까지만 등록 가능합니다.');
            return;
        }

        var sel_text = "";
        var sel_value = "";
        var gubun = "";
        for(var i=1; i<=5; i++)
        {
            $this = $("select#ctg"+i+" option:selected");
            if($this.val()) {
                sel_text += gubun + $this.text();
                sel_value = $this.val();
                gubun = " > ";
            }
        }

        if(sel_value) {
            // 동일 카테고리가 있는지
            var same_option_check = function(val)
            {
                var chk = false;
                $("select#sel_ctg option").each(function() {
                    if(val == $(this).val()) {
                        chk = true;
                        return false;
                    }
                });

                if(chk)
                    alert('이미 선택하신 카테고리 입니다.');

                return chk;
            }

            if(same_option_check(sel_value))
                return;

            $("select#sel_ctg").append("<option value=\""+sel_value+"\">"+sel_text+"</option>");
        }

    });

    $("#ropt_add").click(function(){
        var str = ""; 
        str += "<tr>";
        str += "<td><input type='hidden' name='opt[idx][]' value=''><input type='text' name='opt[opt_name][]' value='' class='w100p opt_name'></td>";
        str += "<td><input type='text' name='opt[add_price][]' value='' class='tar' size=5></td>";
        str += "<td><input type='text' name='opt[stock_qty][]' value='' class='tar' size=5></td>";
        str += "<td><input type='text' name='opt[noti_qty][]' value='' class='tar' size=5></td>";
        str += "<td><select name='opt[use_yn][]'><option value='y'>사용</option><option value='n'>미사용</option></select></td>";
        str += "<td><button type='button' class='btn btn_ssmall btn_gray delopt'>삭제</button></td>";
        str += "</tr>";
        $("#ropt").append(str);
    });

    $(".delopt").click(function(){
        $(this).closest('tr').find('.opt_name').val('삭제');
        $(this).closest('tr').css('display','none');

    });
    
});

function fsubmit(){
    var multi_caid = new Array();
    var new_caid = "";

    $("select#sel_ctg option").each(function() {
        new_caid = $(this).val();
        if(new_caid == "")
            return true;
        multi_caid.push(new_caid);
    });

    if(multi_caid.length > 0) {
        $("input[name=ca_id]").val(multi_caid[0]);
        $("input[name=ca_id2]").val(multi_caid[1]);
        $("input[name=ca_id3]").val(multi_caid[2]);
    }

    if(!f.ca_id.value) {
        alert("카테고리를 하나이상 선택하세요.");
        return false;
    }

    var sel_count = $("select#sel_ca_id option").size();
    if(sel_count > 3) {
        alert('카테고리는 최대 3개까지만 등록 가능합니다.');
        return false;
    }

    <?php echo get_editor_js('memo'); ?>
    return true;
}
</script>
