<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name']?></h1>
    <div class="cont_wrap">
        <form name="frmPlan" action="/Design/setPlan/<?=$this->param['ident']?>" method="POST" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="preUrl" value="<?=$_REQUEST['returnUrl']?>">
            <input type="hidden" name="plan_id" value="<?=$this->row['plan_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">기획전 정보</div>
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
                                <option value="">=카테고리선택=</option>
                                <?php foreach($this->categoryDepth1 as $row){ ?>
                                <?=get_frm_option($row['ctg_id'], substr($this->row['ctg_id'],0,3), $row['ctg_title']);?>
                                <?php } ?>
                            </select>
                            <?=$this->categoryModel->printDepthList(2, $this->row['ctg_id'], 'ctg2', "required"); ?>
                            <script>
$(function() {
        $("#ctg1").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        $("#ctg2").ctg_select_box("#ctg",5,"/Category/getNext","=카테고리선택=");
        });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기획전명</th>
                        <td>
                            <input type="text" name="title" value="<?=$this->row['plan_title']?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td>
                            <?=get_frm_chkbox("showYn","y",$this->row['plan_show_yn'],"노출함")?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">링크 주소</th>
                        <td><input type="text" value="/plan/<?=$this->row['plan_id']?>" class="readonly" readonly size=50>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('beginDate', $this->row['plan_begin_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('endDate', $this->row['plan_end_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?= editor_html('content', get_text($this->row['plan_content'],0)); ?></td>
                    </tr>   
                    <tr>
                        <th scope="row">관련 상품 코드</th>
                        <td id="load_wrap">
<div class="list_wrap">
                            <div class="rect_wrap">
                                <span class="cnt_wrap">
                                    검색된 상품 :<b class="cnt"><?=!empty($_REQUEST['goodsId'])?number_format($this->cnt):"0" ?></b>개
                                </span>
                                <span class="right_wrap">
                                    <input type="hidden" name="goodsList" id="goodsList" value="<?=$_REQUEST['goodsId']?>">
                                    <a href="#" onclick="winOpen('/Design/goodsListPopup/<?=$_REQUEST['goodsId']?>','planGoodsList',screen.width,screen.height,'yes');" class="btn_small btn_blue">관련 상품 코드 변경</a>
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
                                            <th scope="col">재고</th>
                                            <th scope="col">시중가</th>
                                            <th scope="col">공급가</th>
                                            <th scope="col">판매가</th>
                                            <th scope="col">조회수</th>
                                            <th scope="col">판매수량</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($_REQUEST['goodsId'])) { ?>      
                                    <?php foreach($this->goodsModel->get($this->col,$this->search,true,$this->sql) as $row ) { ?>
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
                            </div>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">목록 이미지</th>
                        <td>
                            <input type="hidden" name="oriListImgFile" id="oriListImgFile" value="<?=$this->row['plan_list_img']?>">
                            <input type="file" name="listImgFile">
                            <input type="checkbox" name="listImgFileEel" value="<?=$this->row['plan_list_img']?>" id="listImgFileEel">
                            <label for="listImgFileEel">삭제</label>
                            <div class="mart5">
                                <?=get_img(_PLAN,$this->row['plan_list_img'],"300px")?>
                            </div>
                        </td>
                    </tr>  
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="수정" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=!empty($_REQUEST['returnUrl'])?urldecode($_REQUEST['returnUrl']):"/Design/planList"?>" class="btn_large btn_white">목록</a>
                    <a href="/Design/removePlan/<?=$this->param['ident']?>?returnUrl=<?=urlencode($_REQUEST['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 기획전을 삭제하시겠습니다?\n삭제 처리된  데이터는 복구 불가능합니다.')">삭제</a>
                </div>
            </div>
        </form>
    </div>
</section>
