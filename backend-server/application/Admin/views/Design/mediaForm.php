<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/addMedia" method="POST" enctype="MULTIPART/FORM-DATA">
            <div class="rhead01_wrap">
                <div class="h2">컨텐츠 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">카테고리</th>
                        <td>
                            <input type="hidden" name="ctg" id="ctg">
                            <?=$this->category->printDepthList(1, '', 'ctg1'); ?>
                            <?=$this->category->printDepthList(2, '', 'ctg2'); ?>
                            <script>
$(function() {
        $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop">
                                <?= get_frm_option("admin","","전체"); ?>
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,"",$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">미디어 타입</th>
                        <td>
                            <select name="type">
                                <?php foreach( $GLOBALS['media_type'] as $id=>$name ){ ?>
                                <?= get_frm_option($id,"",$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">미디어명</th>
                        <td><input type="text" name="title" size="40"></td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td><input type="checkbox" name="showYn" value="y" id="showYn"><label for="showYn"> 노출함</label></td>
                    </tr>   
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('beginDate', '');?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('endDate', '' );?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">동영상 링크</th>
                        <td>
                            <input type="text" name="videoUrl" size="40">
                            <button type="button" class="btn_small btn_white" onClick="putIframeTag()">미리보기</button>
                            <div id="showIframe"></div>
                        </td>
                    </tr>   
                    <!--
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?=editor_html('content', ""); ?></td>
                    </tr>
                    -->   
                    <tr>
                        <th scope="row">관련 상품 코드</th>
                        <td id="load_wrap">
                            <div class="rect_wrap">
                                <span class="cnt_wrap">
                                    검색된 상품 :<b class="cnt"><?=!empty($_REQUEST['goodsId'])?number_format($this->goods->getCnt()):"0" ?></b>개
                                </span>
                                <span class="right_wrap">
                                    <input type="hidden" name="goodsList" id="goodsList" value="<?=$_REQUEST['goodsId']?>">
                                    <a href="#" onclick="winOpen('/Design/goodsListPopup/<?=$_REQUEST['goodsId']?>','goodsList','900','700','yes');" class="btn_small btn_blue">관련 상품 코드 변경</a>
                                </span>
                            </div>
                            <div class="chead02_wrap" id="dataBox">
                                <table id="sort_table">
                                    <colgroup>
                                        <col class="w100">   <!-- 상품 번호 -->
                                        <col class="w200">  <!-- 상품명 -->
                                        <col class="60">  <!-- 진열 -->
                                        <col class="60">  <!-- 재고 -->
                                        <col class="60">  <!-- 시중가 -->
                                        <col class="60">  <!-- 공급가 -->
                                        <col class="60">  <!-- 판매가 -->
                                        <col class="60">  <!-- 조회수 -->
                                        <col class="60">  <!-- 판매수량 -->
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th scope="col">상품번호</th>
                                            <th scope="col">상품명</th>
                                            <th scope="col">진열</th>
                                            <th scope="col" class="nsort">재고</th>
                                            <th scope="col" class="nsort">시중가</th>
                                            <th scope="col" class="nsort">공급가</th>
                                            <th scope="col" class="nsort">판매가</th>
                                            <th scope="col" class="nsort">조회수</th>
                                            <th scope="col" class="nsort">판매수량</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($_REQUEST['goodsId'])) { ?>
                                    <?php foreach($this->goods->getList() as $row ) { ?>
                                    <tr>
                                        <td><?=$row['gs_id']?></td>
                                        <td class="tal"><?=$row['gs_name']?></td>
                                        <td><?=$GLOBALS['gs_isopen'][$row['gs_isopen']]?></td>
                                        <td><?=number_format($row['gs_stock_qty'])?></td>
                                        <td><?=number_format($row['gs_consumer_price'])?></td>
                                        <td><?=number_format($row['gs_supply_price'])?></td>
                                        <td><?=number_format($row['gs_price'])?></td>
                                        <td><?=number_format($row['gs_view_cnt'])?></td>
                                        <td><?=number_format($row['gs_order_qty'])?></td>
                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>   


                    <tr>
                        <th scope="row">목록 이미지</th>
                        <td><input type="file" name="listImgFile"></td>
                    </tr>  
                    <tr>
                        <th scope="row">출처</th>
                        <td><input type="text" name="reference"></td>
                    </tr>  
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=!empty($_REQUEST['returnUrl'])?urldecode($_REQUEST['returnUrl']):"/Design/mediaList"?>" class="btn_large btn_white">목록</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
function putIframeTag(){
    var url = $("input[name='videoUrl']").val();
    var tag = "<br><iframe width=\"600\" height=\"360\" src='"+url+"'  frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"></iframe>";
    $("#showIframe").html(tag);
}

</script>
