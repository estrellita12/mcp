<div id="contents">
    <div class="pg_header">
        <p class="pg_nav">홈<span class="rangle">＞</span><?=$preMenu['name'];?></p>
    </div>
    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$preMenu['name']?></h1>
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch">
                                <?= get_frm_option('title', $_REQUEST['srch'], '쿠폰 제목'); ?>
                                <?= get_frm_option('pt_id', $_REQUEST['srch'], '가맹점명'); ?>
                            </select>
                            <input type="text" name="kwd" value="<?php echo $_REQUEST['kwd']; ?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th>기간검색</th>
                        <td>
                            <select name="term">
                                <?= get_frm_option('reg_dt', $_REQUEST['term'], '등록일'); ?>
                            </select>
                            <?=get_search_date('beg','end',$_REQUEST['beg'],$_REQUEST['end'])?>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="검색" id="fsearch" class="btn_medium btn_black">
                    <input type="reset" value="초기화" id="freset" class="btn_medium btn_gray">
                </div>
            </div>
        </form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 쿠폰 : <b class="cnt"><?=$this->cnt ?></b> 개
                    </span>
                    <a href="/Design/couponForm" class="fr btn_small btn_red">쿠폰 추가</a>
                </div>
                <div class="btn_wrap">
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w80">   <!-- 번호 -->
                            <col class="w400">   <!-- 쿠폰명 -->
                            <col>   <!-- 시작 시간 -->
                            <col>   <!-- 종료 시간 -->
                            <col>   <!-- 사용여부 -->
                            <col>   <!-- 등록일 -->
                            <col class="w60">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">번호</th>
                                <th scope="col">쿠폰명</th>
                                <th scope="col">시작 시간</th>
                                <th scope="col">종료 시간</th>
                                <th scope="col">사용 여부</th>
                                <th scope="col">등록일</th>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i=0; foreach( $this->coupon->getList($this->column) as $row) {?>
                        <tr class="list<?=$i%2?>" data-idx="<?=$row['idx']?>">
                            <td>
                                <input type="hidden" name="idx[<?=$i?>]" value="<?=$row['idx']?>">
                                <input type="checkbox" name="chk[]">
                            </td>
                            <td><?=$row['idx']?></td>
                            <td class="padl10 tal"><?=$row['title'];?></td>
                            <td><?=check_time($row['begin_dt'])==true?substr($row['begin_date'],0,16):"제한 없음"?></td>
                            <td><?=check_time($row['end_dt'])==true?substr($row['end_date'],0,16):"제한 없음"?></td>
                            <td><?=img_visible($row['use_yn'],'y',20)?></td>
                            <td><?=$row['reg_dt']?></td>
                            <td><a href="/Design/couponForm/<?=$row['idx']?>" class="btn btn_white btn_small">수정</a></td>
                        </tr>
                        <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>



