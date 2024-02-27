<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$this->menu->getName( _SCRIPT_URL );?> </p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->menu->getName( _SCRIPT_URL );?> </h1>
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w100">
                        <col>
                    </colgroup>
                    <tbody>
                    <!--
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="scCol">
                                <?= get_frm_option('id', $_REQUEST['scCol'], '아이디'); ?>
                                <?= get_frm_option('name', $_REQUEST['scCol'], '회원명'); ?>
                                <?= get_frm_option('cellphone', $_REQUEST['scCol'], '전화번호'); ?>
                                <?= get_frm_option('email', $_REQUEST['scCol'], '이메일'); ?>
                                <?= get_frm_option('addr', $_REQUEST['scCol'], '주소'); ?>
                            </select>
                            <input type="text" name="scV" value="<?php echo $_REQUEST['scV']; ?>" size="30">
                        </td>
                    </tr>
                    -->
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="scDT">
                                <?= get_frm_option('reg_date', $_REQUEST['scDT'], '가입일'); ?>
                                <?= get_frm_option('app_date', $_REQUEST['scDT'], '승인일'); ?>
                            </select>
                            <?=get_search_date('scDT_S','scDT_E',$_REQUEST['scDT_S'],$_REQUEST['scDT_E'])?>
                        </td>
                    </tr>
                    <tr>
                        <th>등급</th>
                        <td>
                            <?=get_frm_radio("scG","all",$_REQUEST['scG'],"전체" );?>
                            <?php foreach($this->query->getRowAll("web_seller_grade","idx,name","and name!=''","order by idx desc") as $row){ ?>
                            <?=get_frm_radio("scG",$row['idx'], $_REQUEST['scG'], $row['name']); ?>
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
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 공급사 :<b class="cnt"><?= $this->totCnt ?></b>개
                    </span>
                    <span>
                        <select id="showCnt" onchange="location='<?=get_query("showCnt,page")."showCnt="?>'+this.value;" >
                            <?= get_frm_option('30', $_REQUEST['showCnt'], '30줄 정렬'); ?>
                            <?= get_frm_option('50', $_REQUEST['showCnt'], '50줄 정렬'); ?>
                            <?= get_frm_option('100', $_REQUEST['showCnt'], '100줄 정렬'); ?>
                        </select>
                    </span>
                </div>
                <div class="btn_wrap">
                    <a href="#" id="frmExcel" class="btn_small btn_white" data-file="/Seller/sellerListExcel"><img src="<?=_ICON?>excel_download.png" width=15> 선택항목 엑셀저장</a>
                    <a href="/Seller/sellerListExcel?<?=get_qstr()?>" class="btn_small btn_white"><img src="<?=_ICON?>excel_download.png" width=15> 검색결과 엑셀저장</a>
                    <a href="/Seller/registerForm" class="fr btn_small btn_red"><i class="ionicons ion-android-add"></i> 공급사추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col>   <!-- 공급사명 -->
                            <col>   <!-- 공급사ID -->
                            <col>   <!-- 등급 -->
                            <col>   <!-- 가입일시 -->
                            <col>   <!-- 승인일시 -->
                            <col>   <!-- 수수료집계 > 총적립액 -->
                            <col>   <!-- 수수료집계 > 총차감액 -->
                            <col>   <!-- 수수료집계 > 현재잔액 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("name",$_REQUEST['colBy'])?>">공급사명</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("id",$_REQUEST['colBy'])?>">아이디</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("grade",$_REQUEST['colBy'])?>">등급</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("reg_date",$_REQUEST['colBy'])?>">가입일시</a></th>
                                <th scope="col" rowspan="2"><a href="<?=get_sort_url("app_date",$_REQUEST['colBy'])?>">승인일시</a></th>
                                <th scope="col" colspan="3" class="th_bg">수수료집계</th>
                                <th scope="col" rowspan="2">관리</th>
                            </tr>
                            <tr>
                                <th scope="col" class="th_bg">총적립액</th>
                                <th scope="col" class="th_bg">총차감액</th>
                                <th scope="col" class="th_bg">현재잔액</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach($this->rowAll as $row) { ?>
                        <tr>
                            <td>
                                <input type="hidden" name="idx[<?=$i++;?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]" value="">
                            </td>
                            <td><?=$row['name']?></td>
                            <td><a href="#" onclick="win_open('/Seller/popupForm/<?=$row['id']?>','sellerForm','1200','600','yes');" ><?=$row['id']?></a></td>
                            <td><?=$this->grade->getName("seller",$row['grade'])?></td>
                            <td><?=$row['reg_date']?></td>
                            <td><?=$row['app_date']?></td>
                            <td class="tar">0 원</td>
                            <td class="tar">0 원</td>
                            <td class="tar">0 원</td>
                            <td><a href="/Seller/expire/<?=$row['idx']?>" class="btn_white btn_small">만료</a></td>
                        </tr>
                        <?php  } ?>
                        </tbody>
                    </table>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->totCnt/$_REQUEST['showCnt']), get_query('page') ); ?>
                </div>
            </div>
        </div>
    </section>
</div>
