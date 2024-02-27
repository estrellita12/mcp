    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
        <form action="" method="GET">
            <div class="search_wrap">
                <table>
                    <colgroup>
                        <col class="w130">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">검색어</th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('title', $_REQUEST['scCol'], '페이지 제목'); ?>
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">기간검색</th>
                        <td>
                            <select name="term" class="w130">
                                <?= get_frm_option('regDate', $_REQUEST['term'], '등록일시'); ?>
                            </select>
                            <?=get_search_date('beg','end',isset($_REQUEST['beg'])?$_REQUEST['beg']:"",isset($_REQUEST['end'])?$_REQUEST['end']:"")?>
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
        <form id="form" action="" method="POST" onsubmit="return false">
            <div class="layout01_wrap">
                <div class="layout_inner">
                    <div class="rect_wrap">
                        <span class="cnt_wrap">
                            검색된 게시판: <b class="cnt"><?=number_format($this->cnt) ?></b> 개
                        </span>
                        <span class="rpp_wrap">
                            <select id="rpp" onchange="location='<?=get_query("rpp,page")."rpp="?>'+this.value;" >
                                <?= get_frm_option('30', $_REQUEST['rpp'], '30줄 정렬'); ?>
                                <?= get_frm_option('50', $_REQUEST['rpp'], '50줄 정렬'); ?>
                                <?= get_frm_option('100', $_REQUEST['rpp'], '100줄 정렬'); ?>
                            </select>
                        </span>
                    </div>
                    <div class="btn_wrap">
                        <button href="#" class="btn_small btn_white" value="선택수정" onclick="multiple_chk(this.value)">선택수정</button>
                        <button href="#" class="btn_small btn_white" value="선택삭제" onclick="multiple_chk(this.value)">선택삭제</button>
                        <a href="#" id="fexcel" class="btn_excel" data-file="/Flat/listExcel">선택항목 엑셀저장</a>
                        <a href="/Flat/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">검색결과 엑셀저장</a>
                        <a href="/Flat/form" class="fr btn_small btn_red">개별페이지 추가</a>
                    </div>
                    <div class="chead01_wrap">
                        <table>
                            <colgroup>
                                <col class="w40">   <!-- 체크박스 -->
                                <col>   <!-- 페이지 제목 -->
                                <col class="w250">   <!-- 등록일시 -->
                                <col class="w60">   <!-- 관리 -->
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                    <?=get_sort_tag("title","페이지 제목")?>
                                    <?=get_sort_tag("regDate","등록일시")?>
                                    <th scope="col">관리</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach( $this->flat->getList($this->col) as $row) {?>
                            <tr class="list<?=$i%2?>">
                                <td>
                                    <input type="hidden" name="idxl[<?=$i;?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]" value="<?=$row['idx']?>">
                                </td>
                                <td><input name="fl_title[<?=$row['idx']?>]" type="text" class="w100p" value="<?=$row['fl_title']?>"></td>
                                <td><?=$row['fl_reg_dt']?></td>
                                <td><a href="/Flat/modify/<?=$row['idx']?>" class="btn_white btn_small">수정</a></td>
                            </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <?= str_paging("10", $_REQUEST['page'], ceil($this->cnt/$_REQUEST['rpp']), get_query('page') ); ?>                    
                </div>
            </div>
        </form>        
    </section>

<script>
    $(() => {
        respond_alert('개별페이지 정보', 'list');
    })

    async function multiple_chk(val){
        let form = document.getElementById('form');
        form.action = '/Flat/multiple';
        form.method = 'POST';
        let chk_selected = 0;

        $("input[name='chk[]']").each(function(){
            if ($(this).is(":checked")) {
                chk_selected = 1;
            }
        });
        if(!chk_selected) return d_msg('알람', `${val} 하실 항목을 하나 이상 선택하세요.`, mod='alert');
            
        if(val == "선택삭제"){
            let confirm_res = await d_msg("알람","선택한 자료를 정말 삭제하시겠습니까?",mod='confirm');
            if (!confirm_res) return false;
        }

        let name_input = document.createElement('input');
        name_input.name='btn_nm';
        name_input.type='hidden';
        name_input.value=val;
        form.appendChild(name_input);   
        form.submit();             
    }
</script>
