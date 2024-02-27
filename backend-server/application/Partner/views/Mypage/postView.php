<section class="contents">
    <h1 class="cont_title"> <?=$this->tabPageInfo['name']?> </h1>
    <div class="cont_wrap">
        <div class="rhead01_wrap">
            <div class="h2">게시글 보기</div>
            <table>
                <colgroup>
                    <col class="w170">
                    <col>
                    <col class="w170">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">게시판</th>
                    <td colspan="2"><?=$this->bo_li[$_REQUEST['board']]?></td>
                    <td class="tar">
                        <?php if( $this->row['user_id']==$_SESSION['user_id'] ){ ?>
                        <a href="/Mypage/postModify/<?=$this->row['bopo_id']?>?board=<?=$_REQUEST['board']?>&returnUrl=<?=$this->returnUrl?>" class="btn_white btn_small">
                            <img src="/public/img/icon/edit.png">수정
                        </a>
                        <a href="/Mypage/removePost/<?=$this->row['bopo_id']?>?returnUrl=<?=$this->returnUrl?>" class="btn_small btn_white" onclick="return confirm('해당 게시글을 삭제 하시겠습니까?\n삭제 처리된  데이터는 복구 불가능합니다.')">
                            <img src="/public/img/icon/delete.png">삭제
                        </a>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">제목</th>
                    <td colspan="3"><?=$this->row['bopo_title']?></td>
                </tr>
                <tr>
                    <th scope="row">작성자</th>
                    <td><?=$this->row['user_name']?>(<?=$this->row['user_id']?>)</td>
                    <th scope="row">작성일시</th>
                    <td><?=$this->row['bopo_reg_dt']?></td>
                </tr>
                <tr>
                    <th scope="row">파일</th>
                    <td colspan="3">
                        <?=empty($this->row['bopo_file1'])?"":_BOARD.$this->row['bopo_file1']?><br>
                        <?=empty($this->row['bopo_file2'])?"":_BOARD.$this->row['bopo_file2']?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">내용</th>
                    <td colspan="3">
                        <iframe src="<?=_PUBLIC?>/iframe.html" id="content" frameborder="0" scrolling="no" style="width:100%"></iframe>
                        <textarea id="data" name="content" class="dn"><?=get_text($this->row['bopo_content'],0)?></textarea>
                    </td>
                </tr>
                <?php if($this->boardRow['bo_use_comment']=="y"){ ?>
                <tr>
                    <th scope="row">댓글</th>
                    <td colspan="3">
                        <div class="comment_wrap">
                            <ul class="comment_list_wrap">
                                <?php foreach($this->commentModel->getDepthList($this->row['bopo_id']) as $row){ ?>
                                <li class="comment_list marl<?=$row['boco_depth']*20?>">
                                <div class="comment_item_user"> <?=$row['user_name']?> (<?=$row['user_id']?>) </div>
                                <div class="comment_item_content"><?=$row['boco_comment']?></div>
                                <?php if($this->commentAllow){ ?>
                                <div class="comment_item_input tar"><span class="add_comment" >댓글</span></div>
                                <?php } ?>
                                </li>
                                <li class="comment_input_item marl<?=($row['boco_depth']+1)*20?> dn">
                                <form action="/Mypage/addComment" method="post">
                                    <input type="hidden" name="board" value="<?=$_REQUEST['board']?>">
                                    <input type="hidden" name="post" value="<?=$row['bopo_id']?>">
                                    <input type="hidden" name="pid" value="<?=$row['boco_id']?>">
                                    <input type="hidden" name="depth" value="<?=$row['boco_depth']+1?>">
                                    <div class="comment_item_user"><?=$_SESSION['user_name']?>(<?=$_SESSION['user_id']?>)</div>
                                    <div><textarea name="comment" placeholder="댓글을 입력해 주세요" required></textarea></div>
                                    <div class="tar"><input type="submit" value="등록" class="btn_small btn_white"></div>
                                </form>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php if($this->commentAllow){ ?>
                            <div class="comment_input_item mart20"> 
                                <form action="/Mypage/addComment" method="post">
                                    <input type="hidden" name="board" value="<?=$_REQUEST['board']?>">
                                    <input type="hidden" name="post" value="<?=$this->row['bopo_id']?>">
                                    <div class="comment_item_user"><?=$_SESSION['user_name']?>(<?=$_SESSION['user_id']?>)</div>
                                    <div><textarea name="comment" placeholder="댓글을 입력해 주세요" required></textarea></div>
                                    <div class="tar"><input type="submit" value="등록" class="btn_small btn_white"></div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="confirm_wrap">
            <?php if($this->replyAllow){ ?>
            <a href="/Mypage/postAnswer/<?=$this->row['bopo_id']?>?board=<?=$_REQUEST['board']?>&returnUrl=<?=$this->returnUrl?>" class="btn_gray btn_large">
                답글
            </a>
            <?php } ?>
            <a href="<?=urldecode($this->returnUrl)?>" class="btn_large btn_white" accesskey="s">목록</a>
        </div>
    </div>
</section>
<script>
$(function(){
        $("#content").on("load", function() {
                let data =  $("#data").val();
                let wrapper = $("#content").contents().find("#wrapper");
                $(wrapper).append(data);
                $("#content").css('height',$(wrapper).height()+100);
                });

        $(".add_comment").click(function(){
                //var $con = $(this).closest("ul").find(".dn");
                var $con = $(this).parent().parent().next();
                $con.slideDown("fast");
                });

        })
</script>
