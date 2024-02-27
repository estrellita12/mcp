    <section class="cont_inner">
        <h1 class="pg_tit"> <?=$this->tabInfo['name']?> </h1>
        <form action="" method="GET">
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
                                <?= get_frm_option('id', $_REQUEST['scCol'], '아이디'); ?>
                                <?= get_frm_option('name', $_REQUEST['scCol'], '게시판 제목'); ?>
                                <?= get_frm_option('group', $_REQUEST['scCol'], '그룹'); ?>                                
                            </select>
                            <input type="text" name="kwd" id="kwd" value="<?=isset($_REQUEST['kwd'])?$_REQUEST['kwd']:""?>" size="30">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">그룹</th>
                        <td>
                            <select name="group" class="w130">
                                <?php foreach($this->bogr_li as $key=>$value){ ?>
                                <?= get_frm_option($key, null, $value); ?>
                                <?php } ?>
                            </select>
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
                        <a href="#" id="fexcel" class="btn_excel" data-file="/Board/listExcel">선택항목 엑셀저장</a>
                        <a href="/Board/listExcel?<?=get_qstr("rpp,page")?>" class="btn_excel">검색결과 엑셀저장</a>
                        <a href="/Board/form" class="fr btn_small btn_red">게시판 추가</a>
                    </div>
                    <div class="chead01_wrap">
                        <table>
                            <colgroup>
                                <col class="w40">   <!-- 체크박스 -->
                                <col class="w80">   <!-- 아이디 -->
                                <col class="w250">   <!-- 게시판 제목 -->
                                <col class="w250">   <!-- 그룹 -->
                                <col class="w100">   <!-- 스킨 -->
                                <col class="w70">   <!-- 목록 -->
                                <col class="w70">   <!-- 읽기 -->
                                <col class="w70">   <!-- 쓰기 -->
                                <col class="w70">   <!-- 답글 -->
                                <col class="w70">   <!-- 코멘트 -->
                                <col class="w180">   <!-- 등록일시 -->
                                <col class="w60">   <!-- 관리 -->
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                                    <?=get_sort_tag("id","게시판번호(ID)")?>
                                    <?=get_sort_tag("name","게시판 제목")?>
                                    <th scope="col">그룹</th>
                                    <th scope="col">스킨</th>
                                    <th scope="col">목록</th>
                                    <th scope="col">읽기</th>
                                    <th scope="col">쓰기</th>
                                    <th scope="col">답글</th>
                                    <th scope="col">코멘트</th>
                                    <?=get_sort_tag("regDate","등록일시")?>
                                    <th scope="col">관리</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach( $this->board->getList($this->col) as $row) {?>
                            <tr class="list<?=$i%2?>">
                                <td>
                                    <input type="hidden" name="idxl[<?=$i;?>]" value="<?=$row['idx']?>">
                                    <input type="checkbox" name="chk[]" value="<?=$row['idx']?>">
                                </td>
                                <td><?=$row['idx']?></td>
                                <td><?=$row['bo_name']?></td>
                                <td>                                    
                                    <select id="bogr_list" name="bogr_list[<?=$row['idx']?>]">
                                        <?php foreach($this->bogr_li as $idx=>$name){ ?>
                                        <?= get_frm_option( $idx, $row['bogr_id'], $name) ;?>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><?=$row['bo_skin']?></td>
                                <td><?=$this->gr_li[$row['bo_list_perm']] ? : "권한없음"?></td>
                                <td><?=$this->gr_li[$row['bo_read_perm']] ? : "권한없음"?></td>
                                <td><?=$this->gr_li[$row['bo_write_perm']] ? : "권한없음"?></td>
                                <td><?=$this->gr_li[$row['bo_reply_perm']] ? : "권한없음"?></td>
                                <td><?=$this->gr_li[$row['bo_comment_perm']] ? : "권한없음"?></td>
                                <td><?=$row['bo_reg_dt']?></td>
                                <td><a href="/Board/modify/<?=$row['idx']?>" class="btn_white btn_small">수정</a></td>
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
        respond_alert('게시판 정보', 'list');
    })

    async function multiple_chk(val){
        let form = document.getElementById('form');
        form.action = '/Board/multiple';
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
