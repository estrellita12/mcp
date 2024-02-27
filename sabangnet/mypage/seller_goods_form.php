<?php 
sbnet_log("/mypage/seller_goods_form.php",$_REQUEST);
$goodsModel = new \application\models\GoodsModel();
if( !empty($_REQUEST['gs_id']) ){
    //$row = $goodsModel->get("*",array("sl_id"=>$_SESSION['user_id'], "gs_id"=>$_REQUEST['gs_id']),true);
    $row = $goodsModel->get("*",array("gs_id"=>$_REQUEST['gs_id']));
}
$code = !empty($row['gs_code'])?$row['gs_code']:get_gs_code();
?>
<section class="contents">
    <h1 class="cont_title">상품 등록</h1>
    <div class="cont_wrap">
        <form name="fregform" method="post" action="./seller_goods_form_update.php" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="w" value="<?=$_REQUEST['w']?>">
            <input type="hidden" name="id" value="<?=$_REQUEST['gs_id']?>">
            <input type="hidden" name="gs_id" value="<?=$_REQUEST['gs_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">카테고리</div>
                <input type="text" name="ca_id" value="<?=$row['gs_ctg']?>">
                <input type="text" name="ca_id2" value="<?=$row['gs_ctg2']?>">
                <input type="text" name="ca_id3" value="<?=$row['gs_ctg3']?>">
            </div>
            <div class="rhead01_wrap">
                <div class="h2">기본정보</div>
                <table>
                    <colgroup>
                        <col class="w180">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">업체코드</th>
                            <td>
                                <input type="text" name="mb_id" value="<?=$_SESSION['user_id']?>" id="mb_id" required class="required frm_input">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">상품코드</th>
                            <td>
                                <input type="text" name="gcode" value="<?=$code?>" required="" itemname="상품코드" class="required frm_input">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">상품명</th>
                            <td><input type="text" name="gname" value="<?=$row['gs_name']?>" required="" itemname="상품명" class="required frm_input" size="80"></td>
                        </tr>
                        <tr>
                            <th scope="row">짧은설명</th>
                            <td><input type="text" name="explan" value="<?=$row['gs_explan']?>" class="frm_input" size="80"></td>
                        </tr>
                        <tr>
                            <th scope="row">검색키워드</th>
                            <td>
                                <input type="text" name="keywords" value="<?=$row['gs_keyword']?>" class="frm_input wfull">
                                <span class="frm_info fc_125">단어와 단어 사이는 콤마 ( , ) 로 구분하여 여러개를 입력할 수 있습니다. 예시) 빨강, 노랑, 파랑</span>      </td>
                        </tr>
                        <tr>
                            <th scope="row">브랜드</th>
                            <td><input type="text" name="brand_nm" value="<?=$row['gs_brand']?>" class="frm_input"></td>
                        </tr>
                        <tr>
                            <th scope="row">모델명</th>
                            <td><input type="text" name="model" value="<?=$row['gs_model_nm']?>" class="frm_input"></td>
                        </tr>
                        <tr>
                            <th scope="row">생산국(원산지)</th>
                            <td><input type="text" name="origin" value="<?=$row['gs_origin']?>" class="frm_input"></td>
                        </tr>
                        <tr>
                            <th scope="row">제조사</th>
                            <td><input type="text" name="maker" value="<?=$row['gs_maker']?>" class="frm_input"></td>
                        </tr>
                        <tr>
                            <th scope="row">생산 연도</th>
                            <td><input type="text" name="make_year" value="<?=$row['gs_make_year']?>" class="frm_input"></td>
                        </tr>
                        <tr>
                            <th scope="row">제조 일자</th>
                            <td><input type="text" name="make_dm" value="<?=$row['gs_make_dm']?>" class="frm_input"></td>
                        </tr>
                        <tr>
                            <th scope="row">과세설정</th>
                            <td class="td_label">
                                <?=get_frm_radio("notax","1",$row['gs_tax'], "과세")?>
                                <?=get_frm_radio("notax","0",$row['gs_tax'], "면세")?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">판매여부</th>
                            <td class="td_label">
                                <?=get_frm_radio("isopen",1,$row['gs_isopen'], "진열")?>
                                <?=get_frm_radio("isopen",2,$row['gs_isopen'], "품절")?>
                                <?=get_frm_radio("isopen",3,$row['gs_isopen'], "단종")?>
                                <?=get_frm_radio("isopen",4,$row['gs_isopen'], "중지")?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">가격 및 재고</div>
                <table>
                    <colgroup>
                        <col class="w180">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">시중가격</th>
                            <td>
                                <input type="text" name="normal_price" value="<?=$row['gs_consumer_price']?>" class="frm_input w80"> 원
                                <span class="fc_197 marl5">시중에 판매되는 가격 (판매가보다 크지않으면 시중가 표시안함)</span>
                                <span class="fc_125 marl5">(사방넷 출시가, 사방넷 TAG가)</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">공급가격</th>
                            <td>
                                <input type="text" name="supply_price" value="<?=$row['gs_supply_price']?>" class="frm_input w80"> 원
                                <span class="fc_197 marl5">공급사 정신시에 사용되는 가격</span>
                                <span class="fc_197 marl5">본사에 공급하실 가격</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">판매가격</th>
                            <td>
                                <input type="text" name="goods_price" value="<?=$row['gs_price']?>" class="frm_input w80"> 원
                                <span class="fc_197 marl5">실제 판매가 입력 (대표가격으로 사용)</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">포인트</th>
                            <td>
                                <input type="text" name="gpoint" value="0" class="frm_input w80">
                                <input type="text" name="marper" class="frm_input w50"> %
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">가격 대체문구</th>
                            <td>
                                <input type="text" name="price_msg" value="" class="frm_input">
                                <span class="fc_197 marl5">가격대신 보여질 문구를 노출할 때 입력, 주문불가</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">수량</th>
                            <td>
                                <input type="text" name="stock_qty" value="<?=$row['gs_stock_qty']?>" class="frm_input w80" disabled="disabled"> 개,
                                <b class="marl10">재고 통보수량</b> <input type="text" name="noti_qty" value="999" class="frm_input w80" onkeyup="addComma(this);" disabled="disabled"> 개
                                <p class="fc_197 mart7">상품의 재고가 통보수량보다 작을 때 상품 재고관리에 표시됩니다.<br>옵션이 있는 상품은 개별 옵션의 통보수량이 적용됩니다. 설정이 무제한이면 재고관리에 표시되지 않습니다.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">배송비</div>
                <table>
                    <colgroup>
                        <col class="w180">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">배송정보</th>
                            <td>
                                <select name="sc_type" onchange="chk_sc_type(this.value);">
                                    <?=get_frm_option("0",$row['gs_delivery_type'],"공통설정"); ?>
                                    <?=get_frm_option("1",$row['gs_delivery_type'],"무료배송"); ?>
                                    <?=get_frm_option("2",$row['gs_delivery_type'],"조건부무료배송"); ?>
                                    <?=get_frm_option("3",$row['gs_delivery_type'],"유료배송"); ?>
                                </select>
                                <div id="sc_method" class="mart7">
                                    배송비결제
                                    <select name="sc_method" class="marl10">
                                        <option value="0" selected="selected">선불</option>
                                        <option value="1">착불</option>
                                        <option value="2">사용자선택</option>
                                    </select>
                                </div>
                                <div id="sc_amt" class="padt5" style="display: none;">
                                    기본배송비 <input type="text" name="sc_amt" value="0" class="frm_input w80 marl10" onkeyup="addComma(this);" disabled="disabled"> 원
                                    <label class="marl10"><input type="checkbox" name="sc_each_use" value="1"> 묶음배송불가</label>
                                </div>
                                <div id="sc_minimum" class="padt5" style="display: none;">
                                    조건배송비 <input type="text" name="sc_minimum" value="0" class="frm_input w80 marl10" onkeyup="addComma(this);" disabled="disabled"> 원 이상이면 무료배송
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">배송가능 지역</th>
                            <td>
                                <select name="zone">
                                    <option value="전국" selected="selected">전국</option>
                                    <option value="강원도">강원도</option>
                                    <option value="경기도">경기도</option>
                                    <option value="경상도">경상도</option>
                                    <option value="서울/경기도">서울/경기도</option>
                                    <option value="서울특별시">서울특별시</option>
                                    <option value="전라도">전라도</option>
                                    <option value="제주도">제주도</option>
                                    <option value="충청도">충청도</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">추가설명</th>
                            <td><input type="text" name="zone_msg" value="" class="frm_input" size="50" placeholder="예 : 제주 (도서지역 제외)"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="rhead01_wrap">
                <div class="h2">상품이미지 및 상세정보</div>
                <table>
                    <colgroup>
                        <col class="w180">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">이미지 등록방식</th>
                            <td class="td_label">
                                <input type="radio" name="simg_type" id="simg_type_1" value="0" checked="checked" onclick="chk_simg_type(0);">
                                <label for="simg_type_1">직접 업로드</label>
                                <!--
                                <input type="radio" name="simg_type" id="simg_type_2" value="1" onclick="chk_simg_type(1);">
                                <label for="simg_type_2">URL 입력</label>
                                -->
                            </td>
                        </tr>
                        <tr class="item_img_fld">
                            <th scope="row">이미지1 <span class="fc_197">(600 * 600)</span> <strong class="fc_red">[필수]</strong></th>
                            <td>
                                <div class="item_file_fld">
                                    <input type="file" name="simg1">
                                </div>
                                <div class="item_url_fld" style="display: none;">
                                    <input type="text" name="simg1" value="" class="frm_input" size="80" placeholder="http://">
                                </div>
                            </td>
                        </tr>
                        <tr class="item_img_fld">
                            <th scope="row">이미지2 <span class="fc_197">(600 * 600)</span> <strong class="fc_red">[필수]</strong></th>
                            <td>
                                <div class="item_file_fld">
                                    <input type="file" name="simg2">
                                </div>
                                <div class="item_url_fld" style="display: none;">
                                    <input type="text" name="simg2" value="" class="frm_input" size="80" placeholder="http://">
                                </div>
                            </td>
                        </tr>
                        <tr class="item_img_fld">
                            <th scope="row">이미지3 <span class="fc_197">(600 * 600)</span></th>
                            <td>
                                <div class="item_file_fld">
                                    <input type="file" name="simg3">
                                </div>
                                <div class="item_url_fld" style="display: none;">
                                    <input type="text" name="simg3" value="" class="frm_input" size="80" placeholder="http://">
                                </div>
                            </td>
                        </tr>
                        <tr class="item_img_fld">
                            <th scope="row">이미지4 <span class="fc_197">(600 * 600)</span></th>
                            <td>
                                <div class="item_file_fld">
                                    <input type="file" name="simg4">
                                </div>
                                <div class="item_url_fld" style="display: none;">
                                    <input type="text" name="simg4" value="" class="frm_input" size="80" placeholder="http://">
                                </div>
                            </td>
                        </tr>
                        <tr class="item_img_fld">
                            <th scope="row">이미지5 <span class="fc_197">(600 * 600)</span></th>
                            <td>
                                <div class="item_file_fld">
                                    <input type="file" name="simg5">
                                </div>
                                <div class="item_url_fld" style="display: none;">
                                    <input type="text" name="simg5" value="" class="frm_input" size="80" placeholder="http://">
                                </div>
                            </td>
                        </tr>
                        <tr class="item_img_fld">
                            <th scope="row">이미지6 <span class="fc_197">(600 * 600)</span></th>
                            <td>
                                <div class="item_file_fld">
                                    <input type="file" name="simg6">
                                </div>
                                <div class="item_url_fld" style="display: none;">
                                    <input type="text" name="simg6" value="" class="frm_input" size="80" placeholder="http://">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">상세설명</th>
                            <td>
                                <span class="sound_only">웹에디터 시작</span>
                                <textarea id="memo" name="memo" class="smarteditor2" maxlength="65536" style="width: 100%;"></textarea>
                            </tr>
                            <tr>
                                <th scope="row">관리자메모</th>
                                <td><textarea name="admin_memo" class="frm_textbox"></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" class="btn_large btn_theme" accesskey="s">
                </div>
            </form>
        </div>
    </div>
</section>
