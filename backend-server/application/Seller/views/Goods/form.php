<script src="/public/js/goodsinfo.js"></script>
<script src="/public/js/goods.js"></script>
<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Goods/add" method="POST" enctype="MULTIPART/FORM-DATA"  onsubmit="return frmGoodsSubmit(document.frm);">
            <input type="hidden" name="goodsPriceAuto" value="1">
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
                                <input type="hidden" name="goodsCtg">
                                <input type="hidden" name="goodsCtg2">
                                <input type="hidden" name="goodsCtg3">
                                <select name="selectCtg" id="selectCtg" size="5" class="multiple-select" multiple >
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
                        <td><input type="hidden" name="seller" value="<?=$this->my['sl_id']?>"><?=$this->my['sl_id']?> (<?=$this->my['sl_name']?>)</td>
                    </tr>
                    <tr>
                        <th scope="row">상품 번호</th>
                        <td>등록 완료시 부여</td>
                    </tr>   
                    <tr>
                        <th scope="row">상품 코드</th>
                        <td><input type="text" name="code" value="<?=get_gs_code()?>"></td>
                    </tr>   
                    <tr>
                        <th scope="row">상품명</th>
                        <td><input type="text" name="name" size="100" class="required" required></td>
                    </tr>   
                    <tr>
                        <th scope="row">짧은 설명</th>
                        <td>
                            <p class="info">상품 약어, 간략한 상품명으로써 택배송장 출력과 물류 담당자의 빠른 인식을 위하여 사용할 수 있습니다.</p>
                            <input type="text" name="explan" size="100">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">키워드</th>
                        <td>
                            <p class="info">단어와 단어 사이는 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑 </p>
                            <input type="text" name="keywords" size="100">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">브랜드명</th>
                        <td>
                            <input type="text" name="brand" class="w50p">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">모델명</th>
                        <td>
                            <input type="text" name="model" class="w50p">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">원산지(제조국)</th>
                        <td>
                            <input type="text" name="origin" class="w50p" placeholder="대한민국">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">제조사</th>
                        <td>
                            <input type="text" name="maker" class="w50p" placeholder="메이커">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">생산연도</th>
                        <td>
                            <input type="text" name="makeYear" class="w50p" maxlength="4" placeholder="2022">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">제조일자</th>
                        <td>
                            <input type="text" name="makeDm" class="w50p" maxlength="8" placeholder="20220517">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">시즌</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_season'] as $key=>$value ){ ?>
                            <?=get_frm_radio("season",$key,"7",$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">남녀 구분</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_sex'] as $key=>$value ){ ?>
                            <?=get_frm_radio("sex",$key,"4",$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">과세설정</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_tax'] as $key=>$value ){ ?>
                            <?=get_frm_radio("tax",$key,"1",$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">진열상태</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_isopen'] as $key=>$value ){ ?>
                            <?=get_frm_radio("isopen",$key,"1",$value)?>
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
                            옵션 제목 : <input type="text" name="optSubject" placeholder="선택" class="required" required>
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
                                        <th scope="col"></th>
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
                                </tbody>
                            </table>
                            <div class="tac padt10"><button type="button" class="btn_small btn_red" onclick="roptAdd()">필수 옵션 추가</button></div>
                        </td>
                    </tr>
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
                            <input type="text" name="consumerPrice"  class="tar comma w200" required> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">판매가</th>
                        <td>
                            <input type="text" name="goodsPrice" id="goodsPrice" class="tar comma w200" required> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">수수료</th>
                        <td>
                            <input type="text" name="payRate" id="payRate" value="<?=number_format($this->my['sl_pay_rate'])?>" class="tar comma w200" required readonly> %
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">공급가</th>
                        <td>
                            <input type="text" name="supplyPrice" id="supplyPrice" class="tar comma w200" required readonly> 원
                            <button type="button" class="btn_small btn_theme marl10" onClick="getSupplyPrice()">계산하기</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">주문 한도</th>
                        <td>
                            최소 <input type="text" name="orderMinQty" class="tar comma w100"> 개,  
                            최대 <input type="text" name="orderMaxQty" class="tar comma w100"> 개
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><span class="tooltip">재고 수량<span class="tooltiptext">재고 수량은 옵션 재고의 총합으로 자동 계산됩니다.</span></span></th>
                        <td><input type="text" name="stockQty" class="tar comma w100" readonly required> 개</td>
                    </tr>
                    <tr>
                        <th scope="row">재고 통보 수량</th>
                        <td>
                            <input type="text" name="stockNotiQty" class="tar comma w100" value="10" required> 개
                            <p class="info">상품 재고가 통보 수량 이하로 떨어지면 안내 메일을 발송합니다.</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row" rowspan="2">판매 기간 설정</th>
                        <td>시작 일시 : <?=get_frm_date('salesBeginDate', "");?></td>
                    </tr>
                    <tr>
                        <td>종료 일시 : <?=get_frm_date('salesEndDate', "");?> </td>
                    </tr>
                    <tr>
                        <th scope="row">구매 가능 등급</th>
                        <td>
                            <select name="buyUseGrade" class="w150">
                                <?=get_frm_option("10","","[10] 비회원"); ?>
                                <?php foreach($this->mb_gr_li as $id=>$name){ ?>
                                <?=get_frm_option($id,"","[".$id."] ".$name); ?>
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
                                    <td><?=get_frm_radio('deliveryType',$key,$this->my['sl_delivery_type'], $value[0],"required" );?></td>
                                    <td><?=$value[1]?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                    <tr class="delivery_charge dn">
                        <th scope="row">기본 배송비</th>
                        <td>
                            <input type="text" name="deliveryCharge" value="<?=number_format($this->my['sl_delivery_charge'])?>" class="tar comma w100"> 원
                        </td>
                    </tr>
                    <tr class="delivery_free dn">
                        <th scope="row">조건부 무료<br>주문 금액</th>
                        <td>
                            <input type="text" name="deliveryFree" value="<?=number_format($this->my['sl_delivery_free'])?>" class="tar comma w100"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">교환/반품 배송비</th>
                        <td>
                            <input type="text" name="claimDeliveryCharge" value="<?=number_format($this->my['sl_delivery_charge']<=0?6000:$this->my['sl_delivery_charge']*2)?>" size="10" class="tar comma w100"> 원
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">배송 가능 지역</th>
                        <td>
                            <?php foreach( $GLOBALS['gs_region'] as $key=>$value ){ ?>
                            <?=get_frm_radio("deliveryRegion",$key,"1",$value)?>
                            <?php } ?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">추가 설명</th>
                        <td><input type="text" name="deliveryRegionMsg" class="w50p" placeholder="도서 산간 지역 배송 불가"></td>
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
                            <input type="hidden" id="infoTypePre">
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
                            <?=get_frm_radio("simgType","0","0","파일 저장")?>
                            <?=get_frm_radio("simgType","1","0","URL 저장")?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">대표이미지(<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="file" name="simg1" class="simg w300" required>
                            <p class="info">대표이미지는 반드시 등록해야 합니다. 등록시 사이즈에 유의하여주시기 바랍니다.</p>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지2 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="file" name="simg2" class="simg w300">
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지3 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="file" name="simg3" class="simg w300">
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지4 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="file" name="simg4" class="simg w300">
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">추가이미지5 (<?=$this->config['cf_simg_size_w']?>*<?=$this->config['cf_simg_size_h']?>)</th>
                        <td>
                            <input type="file" name="simg5" class="simg w300">
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">동영상 URL</th>
                        <td>
                            <input type="text" name="svideo" placeholder="http://youtube.co.kr/assasdas" class="w50p">
                            <p class="info">상황에 따라 동작하지 않을 수도 있습니다.</p>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?=editor_html('content', ""); ?></td>
                    </tr>   
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <input type="submit" value="등록" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                <a href="<?=empty($_REQUEST['returnUrl'])?"/Goods/list":urldecode($_REQUEST['returnUrl'])?>" class="btn_large btn_white" accesskey="s">목록</a>
            </div>
        </form>
    </div>
</section>
<script>
$(function(){
        deliveryChange("1");
        });
</script>
