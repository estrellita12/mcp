<div id="popupContents">
    <section class="cont_inner">
        <p class="pg_tit" id="pg_tit">게시글 보기</p>
        <div class="tab_container">
            <div class="rhead01_wrap">
                <table>
                    <colgroup>
                        <col>
                        <col>
                        <col>
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>제목</th>
                            <td colpan="3"></td>
                        </tr>
                        <tr>
                            <th>작성자</th>
                            <td></td>
                            <th>등록시간</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>내용</th>
                            <td colspan="3">
                                <iframe src="<?=_PUBLIC?>/iframe.html" id="content" frameborder="0" scrolling="no" style="width:100%"></iframe>
                                <textarea id="data" name="content" class="dn"><?=get_text($this->row['bopo_content'],0)?></textarea>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="confirm_wrap">
                <button type="button" class="btn_medium btn_white" onclick="window.close();">닫기</button>
            </div>
        </div>
    </section>
</div>
<script>
    $(function(){
        $("#content").on("load", function() {
            let data =  $("#data").val();
            let wrapper = $("#content").contents().find("#wrapper");
            $(wrapper).append(data);
            $("#content").css('height',$(wrapper).height());
        });
    })
</script>
