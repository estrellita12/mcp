<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/setMedia/<?=$this->param['ident']?>" method="POST" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="media_id" value="<?=$this->row['media_id']?>">
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
                            <input type="hidden" name="ctg" id="ctg" value="<?=$this->row['ctg_id']?>">
                            <select id="ctg1" name="ctg1" required>
                                <option value="">=카테고리 선택=</option>
                                <?php foreach($this->categoryDepth1 as $row){ ?>
                                <?=get_frm_option($row['ctg_id'], substr($this->row['ctg_id'],0,3), $row['ctg_title']);?>
                                <?php } ?>
                            </select>
                            <?=$this->categoryModel->printDepthList(2, $this->row['ctg_id'], 'ctg2'); ?>
                            <script>
$(function() {
        $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">미디어 타입</th>
                        <td>
                            <select name="type">
                                <?php foreach( $GLOBALS['media_type'] as $id=>$name ){ ?>
                                <?= get_frm_option($id,$this->row['media_type'],$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">미디어명</th>
                        <td>
                            <input type="text" name="title" value="<?=$this->row['media_title']?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td>
                            <?=get_frm_chkbox("showYn","y",$this->row['media_show_yn'],"노출함")?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('beginDate', $this->row['media_begin_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('endDate', $this->row['media_end_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">동영상 링크</th>
                        <td>
                            <input type="text" name="videoUrl" value="<?=$this->row['media_video_url']?>" size="40">
                            <button type="button" class="btn_small btn_white" onClick="putIframeTag()">미리보기</button>
                            <div id="showIframe"></div>
                        </td>
                    </tr>   
                    <!--
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?= editor_html('content', get_text($this->row['media_content'],0)); ?></td>
                    </tr>
                    -->   
                    <tr>
                        <th scope="row">관련 상품 코드</th>
                        <td id="load_wrap" class="list_wrap">
                            <div class="rect_wrap">
                                <span class="cnt_wrap">
                                    검색된 상품 :<b class="cnt"><?=number_format($this->cnt) ?></b>개
                                </span>
                                <span class="right_wrap">
                                    <input type="hidden" name="goodsList" id="goodsList" value="<?=$_REQUEST['goodsId']?>">
                                    <a href="#" onclick="winOpen('/Design/goodsListPopup/<?=$_REQUEST['goodsId']?>','goodsList',screen.width,screen.height,'yes');" class="btn_small btn_blue">관련 상품 코드 변경</a>
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
                                    <?php foreach($this->selectedList as $row ) { ?>
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
                        <td>
                            <input type="hidden" name="oriListImgFile" id="oriListImgFile" value="<?=$this->row['media_list_img']?>">
                            <input type="file" name="listImgFile">
                            <input type="checkbox" name="listImgFileEel" value="<?=$this->row['media_list_img']?>" id="listImgFileEel">
                            <label for="listImgFileEel">삭제</label>
                            <div class="mart5">
                                <?=get_img(_MEDIA,$this->row['media_list_img'],"300px")?>
                            </div>
                        </td>
                    </tr>  
                    <tr>
                        <th scope="row">출처</th>
                        <td>
                            <input type="text" name="reference"  value="<?=$this->row['media_refer']?>">
                        </td>
                    </tr>  
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=!empty($_REQUEST['returnUrl'])?urldecode($_REQUEST['returnUrl']):"/Design/mediaList"?>" class="btn_large btn_white">목록</a>
                    <a href="/Design/removeMedia/<?=$this->param['ident']?>?returnUrl=<?=urlencode($_REQUEST['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 미디어를 삭제하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.')">삭제</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
function putIframeTag(){
    var url = $("input[name='videoUrl']").val();
    if( !!url ){
        var tag = "<br><iframe width=\"600\" height=\"360\" src='"+url+"'  frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\"></iframe>";
        $("#showIframe").html(tag);
    }
}
$(function(){
        putIframeTag();
        })

</script>
