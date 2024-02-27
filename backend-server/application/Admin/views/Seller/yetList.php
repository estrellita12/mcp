<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name'];?> </h1>
    <div class="cont_info">
        최종처리일이 선택 기간에 포함되는 주문건들이 정산 대상 주문건들입니다.<br>
        주문 상태가 <b>
            <?php foreach( explode(",",$GLOBALS['od_stt_type']['정산']) as $type){
            echo $GLOBALS['od_stt'][$type]['title'].",";
            }
            ?>
        </b>주문건들은 기본 정산으로 진행하고,<br>
        정산 완료 처리된 <b>반품 완료</b>건만 차감 정산으로 진행합니다.
    </div>
    <div class="cont_wrap">
        <form action="" method="GET" name="frmSearch" id="frmSearch">
            <div class="search_wrap">
                <div class="h2">상세 검색</div>
                <table>
                    <colgroup>
                        <col class="w140">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term">
                                <?= get_frm_option('rcentDate', get_request("term"), '최종처리일'); ?>
                                <?= get_frm_option('orderDate', get_request("term"), '주문일'); ?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"",false)?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" class="btn_medium btn_theme">
                    <input type="reset" value="초기화" id="frmRest" class="btn_medium btn_white">
                </div>
            </div>
        </form>
        <form>
            <div class="list_wrap">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 공급사 :<b class="cnt"><?= $this->cnt ?></b>개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] ); ?>
                        </select>
                    </span>
                </div>
                <div class="chead01_wrap" id="reload_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w130">  <!-- 공급사명 -->
                            <col class="w130">  <!-- 공급사ID -->
                            <col class="w100">  <!-- 정산 시작일 -->
                            <col class="w100">  <!-- 정산 종료일 -->
                            <col class="w70">   <!-- 주문건수 -->
                            <col class="w120">  <!-- 주문 정산 금액 -->
                            <col class="w120">  <!-- 주문 정산 금액 -->
                            <col class="w120">  <!-- 차감 정산 금액 -->
                            <col class="w120">  <!-- 차감 정산 금액 -->
                            <col class="w80">  <!-- 주문 내역 -->
                            <col class="w80">  <!-- 상세 정보 -->
                            <col class="w100">   <!-- 다운로드 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">공급사 명</th>
                                <th scope="col">공급사 아이디</th>
                                <th scope="col">정산 시작일</th>
                                <th scope="col">정산 종료일</th>
                                <th scope="col">주문 건수</th>
                                <th scope="col">판매 금액</th>
                                <th scope="col" class="fc_blue">(+)총 공급가액</th>
                                <th scope="col" class="fc_red">(-)차감 정산 금액</th>
                                <th scope="col" class="fc_blue">(+)클레임 배송비</th>
                                <th scope="col">주문 내역</th>
                                <th scope="col">정산 정보</th>
                                <th scope="col">다운로드</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=0; 
                        foreach($this->row as $row) { 
                        $sl = $this->sellerModel->get("*",array("sl_id"=>$row['sl_id']));
                        ?>
                        <tr class="list<?=$i%2?>">
                            <td class="tac"><?=($i+1)+($_REQUEST['rpp']*($_REQUEST['page']-1))?></td>
                            <td><?=$sl['sl_name']?></td>
                            <td><?=sl_id($row['sl_id'])?></td>
                            <td><?=$_REQUEST['beg']?></td>
                            <td><?=$_REQUEST['end']?></td>
                            <td><?=number_format($row['od_cnt'])?>건</td>
                            <td><?=number_format($row['tot_goods_price'])?>원</td>
                            <td><?=number_format($row['tot_supply_price'])?>원</td>
                            <td><?=number_format($row['cancel_supply_price'])?>원</td>
                            <td><?=number_format($row['tot_claim_delivery_charge'])?>원</td>
                            <td><a href="#" onclick="winOpen('/Order/listPopup/<?=$row['od_idl']?>','SellerForm','900','600','yes');" >주문 내역</a></td>
                            <td>
                                <a href="#" onclick="winOpen('/Seller/yetPayInfoPopup/<?=$row['sl_id']?>?<?=get_qstr("rpp,page,sellerPay")?>','sellerForm','900','600','yes');">정산 처리</a>
                            </td>
                            <td><a href="/Seller/yetListDescExcel/<?=$row['sl_id']?>?<?=get_qstr("rpp,page,sellerPay")?>" class="btn_small btn_white">다운로드</a></td>
                        </tr>
                        <?php  $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>
            </div>
        </form>
        <div class="help_wrap">
            <div class="h2">도움말</div>
            <div class="h3">정산 대상 기준은 무엇입니까??</div>
            <ul>
                <li>
                    주문일이 검색 기간 내이고,
                    송장 입력 일이 검색 기간 내이며,
                    주문상태가 
                    <?php foreach( explode(",",$GLOBALS['od_stt_type']['정산']) as $type){ ?>
                        <?=$GLOBALS['od_stt'][$type]['title'].","?>
                    <?php }?>
                    인 주문건이 정산 대상입니다.
            </li>
 
            </ul>
        </div>
 
    </div>
</section>
