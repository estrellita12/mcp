<section class="cont_inner">
    <h1 class="pg_tit"><?=$this->tabInfo['name'];?></h1>  
    <form name="fForm" action="/Marketing/setEdm/<?=$this->param['ident']?>" method="POST">
        <div class="rhead01_wrap">
            <div class="h2">EDM 세부 정보</div>
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">치환코드</th>
                        <td>
                            <p>{이름} {아이디}</p>
                            <p class="info">위 제공하는 치환코드를 EDM내용에 입력하시면 자동으로 변환되어 EDM에 적용 됩니다.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">EDM 제목</th>
                        <td>
                            <input type="text" name="title" class="required" value="<?=$this->row['edm_title']?>" placeholder="제목없음" size="50" required>
                            <p class="info">Example) 최대 10,000포인트 득템찬스!! 이벤트에 참여하세요!</p>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">EDM 타겟 가맹점</th>
                        <td>
                            <select name="shop" id="shop" class="w130">
                                <?php foreach( $this->pt_li as $id=>$name ){ ?>
                                <?= get_frm_option($id,$this->row['pt_id'],$name); ?>
                                <?php } ?>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row">EDM 내용</th>
                        <td> <?= editor_html('content', get_text($this->row['edm_content'],0)) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">발송 옵션</th>
                        <td>
                            <input type="text" name="opt" value="<?=$this->row['edm_send_option']?>">
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">발송 일시</th>
                        <td>
                            <?php if( isset($this->row['edm_send_dt']) ) $send_dt = explode(" ",$this->row['edm_send_dt'])  ?>
                            <input type="date" name="sendDate[]" class="required" value="<?=isset($send_dt)?$send_dt[0]:""?>" required>
                            <input type="time" name="sendDate[]" class="required" value="<?=isset($send_dt)?$send_dt[1]:""?>" required>
                        </td>
                    </tr>   
                    <tr>
                        <th scope="row">승인 여부</th>
                        <td>
                            <?php foreach( $GLOBALS['edm_stt'] as $idx=>$name ){?>
                            <?=get_frm_radio("state", $idx, $this->row['edm_stt'], $name); ?>
                            <?php } ?>
                        </td>
                    </tr>   
                </tbody>
            </table>
            <div class="confirm_wrap">
                <input type="submit" value="수정" id="btn_submit" class="btn_large btn_black" accesskey="s">
                <a href="/Marketing/removeEdm/<?=$this->row['edm_id']?>" class="btn_large btn_red" onclick="return confirm('해당 EDM을 삭제 하시겠습니까?\n삭제된 EDM은 복구가 불가능합니다.')">삭제</a>
                <a href="/Marketing/edmList" class="btn_large btn_white">목록</a>
            </div>
        </div>
    </form>
</section>
