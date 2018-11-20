<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
.cancel_work {display:none;}
.btn_b01{padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;font-size: 12px;}
#bo_vc p a.btn_b01{text-decoration:none;padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;font-size: 12px;}
#cancel-span{display:none;}
.bo_vc_act{margin:0;padding:0;}
</style>
<!-- 댓글 시작 { -->
<div id="comtlist"><i class="fa fa-comments"></i><h2 class="lsh-comt-title">Comment List</h2></div>
<section id="bo_vc" class="lsh-board lsh-board-comment-list-wrap">
    <?php
    $cmt_amt = count($list);
    for ($i=0; $i<$cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = ""; // 댓글단계
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 20;
        $comment = $list[$i]['content'];
        /*
        if (strstr($list[$i]['wr_option'], "secret")) {
            $str = $str;
        }
        */
        $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
        $cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
     ?>
    <article id="c_<?php echo $comment_id ?>" <?php if ($cmt_depth) { ?>style="margin-left:<?php echo $cmt_depth ?>px;border-top-color:#ccc"<?php } ?>>
        <header style="z-index:<?php echo $cmt_sv; ?>">
            <h1><?php echo get_text($list[$i]['wr_name']); ?>님의 댓글</h1>
            <?php echo $list[$i]['name'] ?>
            <?php if ($cmt_depth) { ?><img src="<?php echo $board_skin_url ?>/img/icon_reply.gif" class="icon_reply" alt="댓글의 댓글"><?php } ?>
            <?php if ($is_ip_view) { ?>
            <span class="bo_vc_hdinfo lsh-comt-ip">IP: <?php echo $list[$i]['ip']; ?></span>
            <?php } ?>
            <span class="bo_vc_hdinfo lsh-comt-date">Date: <time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['datetime'])) ?>"><?php echo $list[$i]['datetime'] ?></time></span>
            <?php
            include(G5_SNS_PATH.'/view_comment_list.sns.skin.php');
            ?>
        </header>

        <!-- 댓글 출력 -->
        <p style="word-break:break-all;">
            <?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?php echo $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글"><?php } ?>
            <?php echo $comment ?>
        </p>

        <span id="edit_<?php echo $comment_id ?>" class="comtbox"></span><!-- 수정 -->
        <span id="reply_<?php echo $comment_id ?>" class="comtbox"></span><!-- 답변 -->

        <input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
        <textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>

        <?php if($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) {
            $query_string = str_replace("&", "&amp;", $_SERVER['QUERY_STRING']);

            if($w == 'cu') {
                $sql = " select wr_id, wr_content from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
                $cmt = sql_fetch($sql);
                $c_wr_content = $cmt['wr_content'];
            }

            $c_reply_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
            $c_edit_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';
         ?>

        <footer>
            <ul id="bo_vc_act_<?php echo $comment_id ?>" class="bo_vc_act">
                <?php if ($list[$i]['is_reply']) { ?><li class="btn_b01"><a href="<?php echo $c_reply_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">답변</a></li><?php } ?>
                <?php if ($list[$i]['is_edit']) { ?><li class="btn_b01"><a href="<?php echo $c_edit_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', 'cu'); return false;">수정</a></li><?php } ?>
                <?php if ($list[$i]['is_del'])  { ?><li class="btn_b01"><a href="<?php echo $list[$i]['del_link'];  ?>" onclick="return comment_delete();">삭제</a></li><?php } ?>
            </ul>
        </footer>
        <?php } ?>
    </article>
    <?php } ?>
    <?php if ($i == 0) { //댓글이 없다면 ?><p id="bo_vc_empty">등록된 댓글이 없습니다.</p><?php } ?>
</section>
<!-- } 댓글 끝 -->

<?php if ($is_comment_write) { if($w == '') $w = 'c'; ?>
<!-- 댓글 쓰기 시작 { -->
<div id="comtwrite"><i class="fa fa-pencil"></i><h2 class="lsh-comt-title">Write Comment</h2></div>
<aside id="bo_vc_w" class="lsh-board lsh-board-comment-write-wrap">
    <form name="fviewcomment" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="is_good" value="">

	<!-- Comment Form -->
	<div class="tbl_frm01 tbl_wrap post-comment">

		<?php if ($is_guest) { ?>
		<div class="row margin-bottom-10">
			
			<div class="col-md-4 col-md-offset-0">
				<div class="note"><strong>※ 이름</strong>을 입력하세요.</div>
				<input type="text" class="form-control" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" placeholder="Your Name" required maxLength="20" >
			</div>                
		</div>
		
		<div class="row margin-bottom-10">
			<div class="col-md-7 col-md-offset-0">
				<div class="note"><strong>※ 비밀번호</strong>를 입력하세요.</div>
				<input type="text" class="form-control" name="wr_password" id="wr_password" placeholder="Password" required maxLength="20">
			</div>                
		</div>
		<?php } ?>
		<div class="row margin-bottom-10">
            <div class="col-md-7 col-md-offset-0">
				<input type="checkbox" name="wr_secret" value="secret" id="wr_secret" style="margin:0 10px 0 0;"> 비밀글사용시 체크
			</div>
		</div>

		<?php if ($is_guest) { ?>
		<label class="lsh-label">자동등록방지</label>
		<div class="row margin-bottom-20">
			<div class="col-md-7 col-md-offset-0 lsh-captcha-wrap">
				<?php echo $captcha_html ?>
			</div>
		</div>
		<?php } ?>

		<?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
		<div class="row margin-bottom-10">
			<div class="col-md-12 col-md-offset-0">
				<textarea id="wr_content" name="wr_content" maxlength="10000"  class="form-control" style="resize:vertical;" rows="3" title="내용" 
					<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>></textarea>
				<?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
			</div>                
		</div>
		
		<p style="margin:0;text-align:right;;">
			<input type="submit" id="btn_submit" class="btn_submit btn_b01" value="확인" style="">
			<span id="cancel-span"></span>
		</p>
	</div>
	<!-- End Comment Form -->
	</form>
</aside>

<?php } ?>
<!-- } 댓글 쓰기 끝 -->