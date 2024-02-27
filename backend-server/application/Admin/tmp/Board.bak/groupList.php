<section class="cont_inner">
    <h1 class="pg_tit"> <?=$this->tabPageInfo['name']?> </h1>
    <form action="" method="GET" id="frmSearch" name="frmSearch">
        <div class="search_wrap">
            <table>
                <colgroup>
                    <col class="w120">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row"><span class="tooltip">검색어<span class="tooltiptext">검색어 입력시 포함 검색, (쉼표)를 입력시 구분검색</span></span></th>
                        <td>
                            <select name="srch" id="srch" class="w130">
                                <?= get_frm_option('id', $_REQUEST['srch'], '그룹아이디'); ?>
                                <?= get_frm_option('name', $_REQUEST['srch'], '그룹명'); ?>
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
    <form>
        <div class="layout01_wrap">
            <div class="layout_inner">
                <div class="rect_wrap">
                    <span class="cnt_wrap">
                        검색된 그룹 : <b class="cnt"><?=number_format($this->cnt) ?></b> 개
                    </span>
                    <span class="rpp_wrap">
                        <select id="rpp" onchange="location='<?=get_query("rpp,page")."&rpp="?>'+this.value;" >
                            <?= get_frm_rpp( $_REQUEST['rpp'] );?>
                        </select>
                    </span>
                    <span class="right_wrap">
                        <a href="/Board/groupListExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">엑셀저장</a>
                    </span>
                </div>
                <div class="btn_wrap">
                    <!--
                    <button href="#" class="btn_small btn_white" value="선택수정" onclick="multiple_chk(this.value)">선택수정</button>
                    <button href="#" class="btn_small btn_white" value="선택삭제" onclick="multiple_chk(this.value)">선택삭제</button>
                    -->
                    <a href="/Board/groupForm" class="btn_small btn_white">+ 그룹 추가</a>
                </div>
                <div class="chead01_wrap">
                    <table>
                        <colgroup>
                            <col class="w40">   <!-- 체크박스 -->
                            <col class="w200">   <!-- 그룹아이디 -->
                            <col>   <!-- 그룹명 -->
                            <col class="w200">   <!-- 등록일 -->
                            <col class="w80">   <!-- 관리 -->
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="checkAll(this.form);"></th>
                                <th scope="col">그룹아이디</th>
                                <th scope="col">그룹명</th>
                                <?=get_sort_tag("regDate","등록일시")?>
                                <th scope="col">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; foreach($this->boardGroup->getList($this->col) as $row) {?>
                            <tr class="list<?=$i%2?>">
                                <td>
                                    <input type="hidden" name="idxl[<?=$i?>]" value="<?=$row['bogr_id']?>">
                                    <input type="checkbox" name="chk[]" value="<?=$row['bogr_id']?>">
                                </td>
                                <td><?=$row['bogr_id']?></td>
                                <td><input name="bogr_name[<?=$row['bogr_id']?>]" type="text" class="w100p" value="<?=$row['bogr_name']?>"></td>
                                <td><?=$row['bogr_reg_dt']?></td>
                                <td>
                                    <a href="/Board/groupModify/<?=$row['bogr_id']?>" class="btn_white btn_small">수정</a>
                                </td>
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
        respond_alert('게시판 그룹 정보', 'groupList');
    })

    async function multiple_chk(val){
        let form = document.getElementById('form');
        form.action = '/Board/groupMultiple';
        form.method = 'POST';
        let chk_selected = 0;

        $("input[name='chk[]']").each(function(){
            if ($(this).is(":checked")) {
                chk_selected = 1;
            }
        });
        if(!chk_selected) return d_msg('알람', `${val} 하실 항목을 하나 이상 선택하세요.`, 'alert');

        if(val == "선택삭제"){
            let confirm_res = await d_msg("알람","선택한 자료를 정말 삭제하시겠습니까?");
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
