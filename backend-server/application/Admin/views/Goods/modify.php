<script src="/public/js/goodsinfo.js"></script>
<script src="/public/js/goods.js"></script>
<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Goods/set/<?=$this->param['ident']?>" method="POST" enctype="MULTIPART/FORM-DATA" onsubmit="return frmGoodsSubmit(document.frm);">
            <input type="hidden" name="id" value="<?=$this->param['ident']?>">
            <div class="rhead01_wrap">
                <div class="h2">카테고리 관리</div>
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
                            <input type="hidden" id="ctg">
                            <div class="fixed-clear">
                                <div class="w20p fl"><?=$this->category->printDepthList(1, "", 'ctg1', ' class="multiple-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(2, "", 'ctg2', ' class="multiple-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(3, "", 'ctg3', ' class="multiple-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(4, "", 'ctg4', ' class="multiple-select" multiple' ); ?></div>
                                <div class="w20p fl"><?=$this->category->printDepthList(5, "", 'ctg5', ' class="multiple-select" multiple' ); ?></div>
                            </div>
                            <div class="tac padt10"><button type="button" class="btn_small btn_blue" onclick="ctgAdd()" >카테고리 추가</button></div>
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
                                <input type="hidden" name="goodsCtg" value="<?=$this->row['gs_ctg'];?>">
                                <input type="hidden" name="goodsCtg2" value="<?=$this->row['gs_ctg2'];?>">
                                <input type="hidden" name="goodsCtg3" value="<?=$this->row['gs_ctg3'];?>">
                                <select name="selectCtg" id="selectCtg" size="5" class="multiple-select" multiple >
                                    <?php if($ctg=$this->category->getNavStr($this->row['gs_ctg'])){ ?>
                                    <option value="<?=$this->row['gs_ctg']?>"><?=$ctg?></option>
                                    <?php } ?>
                                    <?php if($ctg=$this->category->getNavStr($this->row['gs_ctg2'])){ ?>
                                    <option value="<?=$this->row['gs_ctg2']?>"><?=$ctg?></option>
                                    <?php } ?>
                                    <?php if($ctg=$this->category->getNavStr($this->row['gs_ctg3'])){ ?>
                                    <option value="<?=$this->row['gs_ctg3']?>"><?=$ctg?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="tac padt10">
                                <button type="button" class="btn_small btn_white" onclick="ctgMove('prev')">▲위로</button>
                                <button type="button" class="btn_small btn_white" onclick="ctgMove('next')">▼아래로</button> 
                                <button type="button" class="btn_small btn_red" onclick="ctgRemove()">카테고리 삭제</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">기본 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">공급사</th>
                        <td><?=$this->sl_li[$this->row['sl_id']]?> (<?=$this->row['sl_id']?>)</td>
                    </tr>
                    <tr>
                        <th scope="row">상품 번호</th>
                        <td><?=$this->row['gs_id']?></td>
                    </tr>   
                    <tr>
                        <th scope="row">상품 코드</th>
                        <td><input type="hidden" name="code" value="<?=$this->row['gs_code']?>"><?=$this->row['gs_code']?></td>
                    </tr>   
                    <tr>
                        <th scope="row">상품명</th>
                        <td>
                            <input type="text" name="name" value="<?=$this->row['gs_name']?>" class="w100p" required>
                            <p class="info">상품명은 어퍼스트러피(\')와 같은 특수문자는 이용 할 수 없습니다. </p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">짧은 설명</th>
                        <td>
                            <input type="text" name="explan" value="<?=$this->row['gs_explan']?>" class="w100p">
                            <p class="info">상품 약어, 간략한 상품명으로써 택배송장 출력과 물류 담당자의 빠른 인식을 위하여 사용할 수 있습니다.</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">키워드</th>
                        <td>
                            <input type="text" name="keywords" value="<?=$this->row['gs_keywords']?>" class="w100p">
                            <p class="info">단어와 단어 사이는 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑 </p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">브랜드명</th>
                        <td>
                            <input type="text" name="brand" value="<?=$this->row['gs_brand']?>" class="w50p">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">모델명</th>
                        <td>
                            <input type="text" name="model" value="<?=$this->row['gs_model_nm']?>" class="w50p" placeholder="GS1234">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">원산지(제조국)</th>
                        <td>
                            <input type="text" name="origin" value="<?=$this->row['gs_origin']?>" class="w50p" placeholder="대한민국">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">제조사</th>
                        <td>
                            <input type="text" name="maker" value="<?=$this->row['gs_maker']?>" class="w50p" placeholder="메이커">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">생산연도</th>
                        <td>
                            <input type="text" name="makeYear" value="<?=$this->row['gs_make_year']?>" class="w50p" maxlength="4" placeholder="2022">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">제조일자</th>
                        <td>
                            <input type="text" name="makeDm" value="<?=$this->row['gs_make_dm']?>" class="w50p" maxlength="8" placeholder="20220517">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">시즌</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_season'] as $key=>$value ){ ?>
                            <?=get_frm_radio("season",$key,$this->row['gs_season'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">남녀 구분</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_sex'] as $key=>$value ){ ?>
                            <?=get_frm_radio("sex",$key,$this->row['gs_sex'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">과세설정</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_tax'] as $key=>$value ){ ?>
                            <?=get_frm_radio("tax",$key,$this->row['gs_tax'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">진열상태</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
                            <?=get_frm_radio("isopen",$key,$this->row['gs_isopen'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">옵션 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">상품 필수 옵션</th>
                        <td class="chead02_wrap">
                            옵션 제목 : <input type="text" name="optSubject" value="<?=$this->row['gs_opt_subject']?>" placeholder="선택" class="required" required>
                            <p class="info">필수 옵션은 반드시 1개 이상 존재해야 합니다.</p>
                            <table>
                                <colgroup>
                                    <col class="w100">
                                    <col class="w100">
                                    <col>
                                    <col class="w100">
                                    <col class="w100">
                                    <col class="w100">
                                    <col class="w100">
                                    <col class="w60">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col">옵션번호(ID)</th>
                                        <th scope="col">바코드</th>
                                        <th scope="col">옵션명</th>
                                        <th scope="col">공급가</th>
                                        <th scope="col">추가금액</th>
                                        <th scope="col">재고수량</th>
                                        <th scope="col">사용여부</th>
                                        <th scope="col">삭제</th>
                                    </tr>
                                </thead>
                                <tbody id="ropt" class="sortable">
                                <?php foreach($this->opt as $opt){?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="opt[id][]" value="<?=$opt['gs_opt_id']?>">
                                        <?=$opt['gs_opt_id']?><?=id_log($opt['gs_opt_id'],"web_goods_option")?>
                                    </td>
                                    <td>
                                        <input type="text" name="opt[code][]" value="<?=$opt['gs_opt_code']?>" class="tar w100p">
                                        <input type="hidden" name="opt[type][]" value="<?=$opt['gs_opt_type']?>">
                                        <input type="hidden" name="opt[orderby][]" value="<?=$opt['gs_opt_orderby']?>" class="orderby">
                                    </td>
                                    <td>
                                        <input type="text" name="opt[name][]" value="<?=$opt['gs_opt_name']?>" class="w100p opt_name" required onkeyup="stockCnt()">
                                    </td>
                                    <td><input type="text" name="opt[supplyPrice][]" value="<?=number_format($opt['gs_opt_supply_price'])?>" class="tar supply_price comma w100p" readonly></td>
                                    <td><input type="text" name="opt[addPrice][]" value="<?=number_format($opt['gs_opt_add_price'])?>" class="tar add_price comma w100p" onkeyup="getSupplyPrice()"></td>
                                    <td><input type="text" name="opt[stockQty][]" value="<?=number_format($opt['gs_opt_stock_qty'])?>" class="tar stock_qty comma w100p" maxlength=3 onkeyup="stockCnt()"></td>
                                    <td>
                                        <select name="opt[useYn][]" class="use_yn">
                                            <?=get_frm_option('y',$opt['gs_opt_use_yn'],'사용')?>
                                            <?=get_frm_option('n',$opt['gs_opt_use_yn'],'미사용')?>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn_ssmall btn_gray" onclick="optDel(this)">삭제</button></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="tac padt10"><button type="button" class="btn_small btn_red" onclick="roptAdd()">필수 옵션 추가</button></div>
                        </td>
                    </tr>
                    <!--
                    <tr>
                        <th scope="row">상품 추가 옵션</th>
                        <td class="chead02_wrap">
                            옵션 제목 : <input type="text" name="addOptSubject" value="<?=$this->row['gs_add_opt_subject']?>" placeholder="선물 포장">
                            <p class="info"></p>
                            <table>
                                <colgroup>
                                    <col class="w100">
                                    <col class="w100">
                                    <col>
                                    <col class="w100">
                                    <col class="w100">
                                    <col class="w100">
                                    <col class="w60">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th scope="col">옵션번호</th>
                                        <th scope="col">옵션바코드</th>
                                        <th scope="col">옵션명</th>
                                        <th scope="col">추가금액</th>
                                        <th scope="col">재고수량</th>
                                        <th scope="col">사용여부</th>
                                        <th scope="col">삭제</th>
                                    </tr>
                                </thead>
                                <tbody id="aopt">
                                    <?php foreach($this->aopt as $opt){?>
                                    <tr>
                                        <td><?=$opt['gs_opt_id']?></td>
                                        <td><input type="text" name="aopt[code][]" value="<?=$opt['gs_opt_code']?>" class="tar" size=5></td>
                                        <td>
                                            <input type="hidden" name="aopt[id][]" value="<?=$opt['gs_opt_id']?>">
                                            <input type="hidden" name="aopt[type][]" value="<?=$opt['gs_opt_type']?>">
                                            <input type="hidden" name="aopt[orderby][]" value="<?=$opt['gs_opt_orderby']?>">
                                            <input type="text" name="aopt[name][]" value="<?=$opt['gs_opt_name']?>" class="w100p opt_name">
                                        </td>
                                        <td><input type="text" name="aopt[addPrice][]" value="<?=$opt['gs_opt_add_price']?>" class="tar" size=5></td>
                                        <td><input type="text" name="aopt[stockQty][]" value="<?=$opt['gs_opt_stock_qty']?>" class="tar" size=3></td>
                                        <td>
                                            <select name="aopt[useYn][]">
                                                <?=get_frm_option('y',$opt['gs_opt_use_yn'],'사용')?>
                                                <?=get_frm_option('n',$opt['gs_opt_use_yn'],'미사용')?>
                                            </select>
                                        </td>
                                        <td><button type="button" class="btn btn_ssmall btn_gray" onclick="optDel(this)">삭제</button></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="tac padt10"><button type="button" class="btn_small btn_red" onclick="aoptAdd()">추가 옵션 추가</button></div>
                        </td>
                    </tr>
                    -->
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">가격 및 재고</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">소비자가(TAG가)</th>
                        <td>
                            <input type="text" name="consumerPrice" value="<?=number_format($this->row['gs_consumer_price'])?>" class="tar comma w200" required> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">판매가</th>
                        <td><input type="text" name="goodsPrice" id="goodsPrice" value="<?=number_format($this->row['gs_price'])?>" class="tar comma w200" required> 원</td>
                    </tr>
                    <tr>
                        <th scope="row">수수료</th>
                        <td>
                            <input type="text" name="payRate" id="payRate" value="<?=number_format($this->row['gs_rate'])?>" class="tar comma w200" required>
                            <span class="marr10"> %</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급가</th>
                        <td>
                            <input type="text" name="supplyPrice" id="supplyPrice" value="<?=number_format($this->row['gs_supply_price'])?>" class="tar comma w200" required readonly> 원
                            <button type="button" class="btn_small btn_theme marl10" onClick="getSupplyPrice()">계산하기</button>
                        </td>
                    </tr>
                    <?php if(!empty($this->pt_gr_li)) { ?>
                    <tr>
                        <th scope="row">세부 판매가 설정</th>
                        <td>
                            <?=get_frm_radio("goodsPriceAuto","1",$this->row['gs_price_auto'], " 자동반영")?>
                            <?=get_frm_radio("goodsPriceAuto","2",$this->row['gs_price_auto'], " 수동반영")?>
                        </td>
                    </tr>
                    <?php foreach($this->pt_gr_li as $idx=>$grade){ ?>
                    <tr class="detail_price">
                        <th scope="row"><?=$grade?></th>
                        <td><input type="text" name="goodsPrice<?=$idx?>" value="<?=number_format($this->row["gs_price_{$idx}"])?>" class="tar comma" size="15"> 원</td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <tr>
                        <th scope="row">주문 한도</th>
                        <td>
                            최소 <input type="text" name="orderMinQty" value="<?=$this->row['gs_order_min_qty']?>" class="tar comma w100"> 개
                            최대 <input type="text" name="orderMaxQty" value="<?=$this->row['gs_order_max_qty']?>" class="tar comma w100"> 개,  
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><span class="tooltip">재고 수량<span class="tooltiptext">재고 수량은 옵션 재고의 총합으로 자동 계산됩니다.</span></span></th>
                        <td><input type="text" name="stockQty" value="<?=$this->row['gs_stock_qty']?>" class="tar comma w100" readonly> 개</td>
                    </tr>
                    <tr>
                        <th scope="row">재고 통보 수량</th>
                        <td>
                            <input type="text" name="qtyNoti" value="<?=$this->row['gs_stock_qty_noti']?>" class="tar comma w100" required> 개
                            <p class="info">상품 재고가 통보 수량 이하로 떨어지면 안내 메일을 발송합니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" rowspan="2">판매 기간 설정</th>
                        <td>시작 일시 : <?=get_frm_date('salesBeginDate', $this->row['gs_sales_begin_dt']);?></td>
                    </tr>
                    <tr>
                        <td>종료 일시 : <?=get_frm_date('salesEndDate', $this->row['gs_sales_end_dt']);?> </td>
                    </tr>
                    <tr>
                        <th scope="row">구매 가능 등급</th>
                        <td>
                            <select name="buyUseGrade" class="w150">
                                <?=get_frm_option("10",$this->row['gs_buy_use_grade'],"[10] 비회원"); ?>
                                <?php foreach($this->mb_gr_li as $id=>$name){ ?>
                                <?=get_frm_option($id,$this->row['gs_buy_use_grade'],"[".$id."] ".$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">배송비</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">배송비 구분</th>
                        <td>
                            <table>
                                <colgroup>
                                    <col class="w130">
                                    <col>
                                </colgroup>
                                <?php foreach($GLOBALS['dv_type'] as $key=>$value){ ?>
                                <tr>
                                    <td><?=get_frm_radio('deliveryType',$key,$this->row['gs_delivery_type'], $value[0],"required" );?></td>
                                    <td><?=$value[1]?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr class="delivery_charge dn">
                        <th scope="row">기본 배송비</th>
                        <td>
                            <input type="text" name="deliveryCharge" value="<?=number_format($this->row['gs_delivery_charge'])?>" class="tar comma w100"> 원
                        </td>
                    </tr>
                    <tr class="delivery_free dn">
                        <th scope="row">조건부 무료<br>주문 금액</th>
                        <td>
                            <input type="text" name="deliveryFree" value="<?=number_format($this->row['gs_delivery_free'])?>" class="tar comma w100"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">교환/반품 배송비</th>
                        <td>
                            <input type="text" name="claimDeliveryCharge" value="<?=number_format($this->row['gs_claim_delivery_charge'])?>" class="tar comma w100"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">배송 가능 지역</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_region'] as $key=>$value ){ ?>
                            <?=get_frm_radio("deliveryRegion",$key,$this->row['gs_delivery_region'],$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">추가 설명</th>
                        <td><input type="text" name="deliveryRegionMsg" value="<?=$this->row['gs_delivery_region_msg']?>" class="w50p" placeholder="도서 산간 지역 배송 불가"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">요약 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row" class="th_bg">상품군 선택</th>
                        <td>
                            <input type="hidden" id="infoTypePre" value="<?=$this->row['gs_info_type']?>">
                            <select name="infoType" id="infoType" required></select>
                        </td>
                    </tr>
                    </tbody>
                    <tbody id="infoValue">
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">상세 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">이미지 저장 방식</th>
                        <td>
                            <?=get_frm_radio("simgType","0",$this->row['gs_simg_type'],"파일 저장")?>
                            <?=get_frm_radio("simgType","1",$this->row['gs_simg_type'],"URL 저장")?>
                        </td>
                    </tr>
                    <?php $type = $this->row['gs_simg_type']==0?"file":"text"; ?>
                    <tr>
                        <th scope="row">대표이미지 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="<?=$type?>" name="simg1" class="simg w300" value="<?=$this->row['gs_simg1']?>">
                            <?php if( !empty($this->row['gs_simg1']) ){?>
                            <a href="<?=get_img_url(_GOODS.$this->row['gs_code'],$this->row['gs_simg1'])?>" target="_blank" class="marr10 btn_white btn_small">미리보기</a>  
                            <input type="checkbox" name="simg1Del" value="<?=$this->row['gs_simg1']?>" id="simg1Del"> <label for="simg1Del">삭제</label>
                            <?php } ?>
                            <p class="info">대표이미지는 반드시 등록해야 합니다. 등록시 사이즈에 유의하여주시기 바랍니다.</p>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지2 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="<?=$type?>" name="simg2" class="simg w300" value="<?=$this->row['gs_simg2']?>">
                            <?php if( !empty($this->row['gs_simg2']) ){?>
                            <a href="<?=_GOODS.$this->row['gs_code']?>/<?=$this->row['gs_simg2']?>" target="_blank" class="marr10 btn_white btn_small">미리보기</a>  
                            <input type="checkbox" name="simg2Del" value="<?=$this->row['gs_simg2']?>" id="simg2Del"> <label for="simg2Del">삭제</label>
                            <?php } ?>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지3 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="<?=$type?>" name="simg3" class="simg w300" value="<?=$this->row['gs_simg3']?>">
                            <?php if( !empty($this->row['gs_simg3']) ){?>
                            <a href="<?=_GOODS.$this->row['gs_code']?>/<?=$this->row['gs_simg3']?>" target="_blank" class="marr10 btn_white btn_small">미리보기</a>  
                            <input type="checkbox" name="simg3Del" value="<?=$this->row['gs_simg3']?>" id="simg3Del"> <label for="simg3Del">삭제</label>
                            <?php } ?>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지4 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="<?=$type?>" name="simg4" class="simg w300" value="<?=$this->row['gs_simg4']?>">
                            <?php if( !empty($this->row['gs_simg4']) ){?>
                            <a href="<?=_GOODS.$this->row['gs_code']?>/<?=$this->row['gs_simg4']?>" target="_blank" class="marr10 btn_white btn_small">미리보기</a>  
                            <input type="checkbox" name="simg4Del" value="<?=$this->row['gs_simg4']?>" id="simg4Del"> <label for="simg4Del">삭제</label>
                            <?php } ?>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지5 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="<?=$type?>" name="simg5" class="simg w300" value="<?=$this->row['gs_simg5']?>">
                            <?php if( !empty($this->row['gs_simg5']) ){?>
                            <a href="<?=_GOODS.$this->row['gs_code']?>/<?=$this->row['gs_simg5']?>" target="_blank" class="marr10 btn_white btn_small">미리보기</a>  
                            <input type="checkbox" name="simg5Del" value="<?=$this->row['gs_simg5']?>" id="simg5Del"> <label for="simg5Del">삭제</label>
                            <?php } ?>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">동영상 URL</th>
                        <td>
                            <input type="text" name="svideo" placeholder="http://youtube.co.kr/assasdas" value="<?=$this->row['gs_svideo_url']?>" size="40">
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?=editor_html('content', get_text($this->row['gs_detail_content'],0)); ?></td>
                    </tr>   
                    <tr>
                        <th scope="row">승인 상태 :  <?=$GLOBALS['gs_stt'][$this->row['gs_stt']]?></th>
                        <td>
                            <?php if( $this->row['gs_stt'] != "3" ){ ?>
                            <a href="/Goods/defer/<?=$this->row['gs_id']?>" class="btn_small btn_red">해당 상품 보류처리</a>
                            <?php } ?>
                            <?php if($this->row['gs_stt'] != "2"){ ?>
                            <a href="/Goods/approval/<?=$this->row['gs_id']?>" class="btn_small btn_blue">해당 상품 승인처리</a>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">상태 변경 사유</th>
                        <td>
                            <textarea name="memo"><?=$this->row['gs_stt_reason']?></textarea>
                            <p class="info">해당 내용은 공급사에 노출됩니다.</p>
                        </td>
                    </tr> 
                    <tr>
                        <th scope="row">관리자 메모</th>
                        <td>
                            <textarea name="memo"><?=$this->row['gs_adm_memo']?></textarea>
                            <p class="info">해당 메모는 공급사에 노출되지 않습니다.</p>
                        </td>
                    </tr>   
                    </tbody>
                </table>
            </div>
            <div>
                <div class="chead02_wrap" id="reload_wrap">
                    <div class="h2">상품 변경 내역</div>
                    <p class="info">현재는 상품 상세 내용을 제외한 모든 변경내역이 모두 출력되며, 추후 표시 항목 제한 및 이름 변경 예정입니다.</p>
                    <table>
                        <colgroup>
                            <col class="w150">
                            <col>
                            <col class="w150">
                        </colgroup>
                        <thead>
                            <th scope="col">처리자</th>
                            <th scope="col">내용</th>
                            <th scope="col">수정 일시</th>
                        </thead>
                        <tbody>
                        <?php foreach($this->log as $log){ $data = json_decode($log['log_change_data'],true); ?>
                        <tr>
                            <td><?=$log['log_by_id']?>(<?=$log['log_by_id_type']?>)</td>
                            <td class="tal">
                                <ul>
                                    <?php foreach($data as $d){?>
                                    <li class="padb2 fs_12"><mark><?=$d['comment']?>[<?=$d['col_name']?>]</mark> <?=$d['pre_value']?> <b class="fc_blue">></b> <?=$d['change_value']?></li>
                                    <?php } ?>
                                </ul>
                            </td>
                            <td><?=$log['log_reg_dt']?></td>
                        </tr>
                        <?php } ?>  
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="수정" id="btn_submit" class="btn_large btn_black" accesskey="s">
                <a href="<?=urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
                <a href="/Goods/remove/<?=$this->row['gs_id']?>?returnUrl=<?=urlencode($_GET['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 상품을 삭제하시겠습니다?\n삭제 처리된  데이터는 복구 불가능합니다.')">삭제요청</a>
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
        <?php foreach($this->row['gs_info_value'] as $key=>$value){ ?>
        $("input[name='infoValue[<?=$key?>]']").val('<?=$value?>');    
        <?php } ?>

        detailPriceAuto("<?=$this->row['gs_price_auto']?>");
        deliveryChange("<?=$this->row['gs_delivery_type']?>");
        });
</script>
