<section class="contents">
    <h1 class="cont_title"><?=$this->tabPageInfo['name'];?></h1>
    <div class="cont_wrap">
        <form name="fForm" action="/Design/setPopup" method="POST" onsubmit="return feditorSubmit(document.frm);">
            <input type="hidden" name="id" value="<?=$this->row['pp_id']?>">
            <div class="rhead01_wrap">
                <div class="h2">팝업 정보</div>
                <table>
                    <colgroup>
                        <col class="w150">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row">팝업명</th>
                        <td><input type="text" name="title" value="<?=$this->row['pp_title']?>" size="40"></td>
                    </tr>
                    <tr>
                        <th scope="row">가맹점</th>
                        <td>
                            <select name="shop">
                                <?= get_frm_option("admin",$this->row['pt_id'],"전체"); ?>
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,$this->row['pt_id'],$name); ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">출력 여부</th>
                        <td>
                            <?=get_frm_chkbox("showYn","y",$this->row['pp_show_yn'],"노출함");?>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">상세설명</th>
                        <td><?=editor_html('content', get_text($this->row['pp_content'],0)); ?></td>
                    </tr>   
                    <tr>
                        <th scope="row">시작 시간</th>
                        <td> <?=get_frm_date('begin_date', $this->row['pp_begin_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">종료 시간</th>
                        <td> <?=get_frm_date('end_date', $this->row['pp_end_dt']);?> </td>
                    </tr>   
                    <tr>
                        <th scope="row">팝업 크기</th>
                        <td>
                            <input type="text" name="width"  value="<?=$this->row['pp_width']?>" size=5>
                            X <input type="text" name="height"  value="<?=$this->row['pp_height']?>" size=5>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">팝업 위치</th>
                        <td>
                            <input type="text" name="top"  value="<?=$this->row['pp_top']?>" size=5>
                            X <input type="text" name="left"  value="<?=$this->row['pp_left']?>" size=5>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">출력 기기</th>
                        <td>
                            <select name="device">
                                <?php foreach($GLOBALS['device'] as $dev){?>
                                <?=get_frm_option($dev,'')?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="confirm_wrap">
                    <input type="submit" value="저장" id="btn_submit" class="btn_large btn_theme" accesskey="s">
                    <a href="<?=!empty($_REQUEST['returnUrl'])?urldecode($_REQUEST['returnUrl']):"/Design/popupList"?>" class="btn_large btn_white">목록</a>
                    <a href="/Design/removePopup/<?=$this->param['ident']?>?returnUrl=<?=urlencode($_REQUEST['returnUrl'])?>" class="btn_large btn_red" onclick="return confirm('해당 팝업을 삭제하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.')">삭제</a>
                </div>
            </div>
        </form>
    </div>
</section>
