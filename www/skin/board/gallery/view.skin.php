<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$ytID = youtube_id_from_url(get_text($view["wr_yturl"])); 
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo $board_skin_url;?>/style.css">
<style>
.news-v3 .news-v3-in {padding: 35px 0px;}
.cont-img{padding:5px 0;}
.responsive-video {height: auto;}
.news-v3 .posted-info li {font-style: normal;}
.news-v3 .news-v3-in-sm h2 {font-size:18px;line-height: 1.3em;font-weight:bold;margin-bottom:10px;}

.lsh-board-comment-list-wrap{padding-bottom:50px;}
#bo_vc p {line-height: 1.4em;}

.bo_v_nb {margin: 0;padding: 0;list-style: none;}

.btn_bo_user li,.bo_v_nb li {padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;}
a.btn_admin, a.btn_b01, a.btn_b02 {margin-right: 0px;padding: 0px;border: none;}
h1.board-title{font-size:14px;text-align: left;color: #799747;font-weight: normal;}
.responsive-video{padding-top:0px !important;}
.viewimg{text-align:center;}
.pImg {padding: 5px 0;}
@media (max-width:1199px){
	.news-v3 .news-v3-in-sm h2 {font-size: 18px;}
	.news-v3 p {font-size:12px;line-height:1.6;}

	.list-inline > li {font-size:12px;}

	#bo_vc {font-size:12px;}
	#bo_vc p {line-height: 1.6;}

	#bo_vc textarea.form-control {font-size:12px;}

	.btn_bo_user li,.bo_v_nb li  {padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;font-size:12px;}

}
@media (max-width:767px){
	ul.list-inline {margin-bottom:0;}
	.news-v3 .news-v3-in-sm .posted-info li {font-size: 9px;}
	.news-v3 .news-v3-in-sm h2 {font-size: 15px; margin: 0 0 5px;}

	.list-inline > li {font-size:10px;}
	.btn_bo_user li,.bo_v_nb li  {padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;font-size:11px;}
}
</style>
<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">커뮤니티</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<div class="container content lsh-toggle-fluid">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9" id="lsh-contents-section" >
			<div class="margin-bottom-30">
				<h2 class="pg-title"><?php echo $board['bo_subject'] ?></h2>
			</div>
			<div class="news-v3">
				<div class="news-v3-in-sm no-padding">
					<h2><?php echo $view['subject'] ?></h2>
				</div>
			</div>

			<div class="blog-post-tags" style="border-bottom:1px solid #d9d9d9;">
				<ul class="list-unstyled list-inline blog-info" style="margin-bottom:10px;">
					<li><i class="fa fa-pencil"></i> <?php echo $view['name'] ?></li>
					<li><i class="fa fa-comments"></i> <a href="#">댓글 <?php echo number_format($view['wr_comment']) ?> </a></li>
					<li><i class="glyphicon glyphicon-eye-open"></i> 조회 <?php echo number_format($view['wr_hit']) ?></li>
					<li><i class="fa fa-calendar"></i> <?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></li>
				</ul>                    
			</div>

			<div class="news-v3 bg-color-white margin-bottom-30">
				<div class="news-v3-in">
					<?php if($view[wr_device] == "p") { ?>
						<?php echo conv_content($view['wr_content'], 2);?>
						<?php
						// 파일 출력
						$v_img_count = count($view['file']);
						if($v_img_count) 
						{
							echo "<div class='viewimg'>";
							for ($i=0; $i<=count($view['file']); $i++) 
							{
								if ($view['file'][$i]['view']) { echo "<p class='pImg'>"; echo $view['file'][$i]['view']; echo "</p>"; }
							}
							echo "</div>\n";
						}
						?>
					<?php } else { ?>
						<?php
						// 파일 출력
						$v_img_count = count($view['file']);
						if($v_img_count) 
						{
							echo "<div class='viewimg'>";
							for ($i=0; $i<=count($view['file']); $i++) 
							{
								if ($view['file'][$i]['view']) { echo "<p class='pImg'>"; echo $view['file'][$i]['view']; echo "</p>"; }
							}
							echo "</div>\n";
						}
						?>
						<!-- 본문 내용 시작 { -->
						<div id="bo_v_con" style="padding-top:20px;"><?php echo get_view_thumbnail($view['content']); ?></div>
						<!-- } 본문 내용 끝 -->

					<?php } ?>

					<?php if($view[wr_yturl] != "") { ?>
					<iframe src="//www.youtube.com/embed/<?php echo $ytID;?>" frameborder="0" scrolling="no" allowfullscreen></iframe>
					<?php } ?> 
				</div>

				<div class="lsh-view-btn-wrap">
					<?php if ($prev_href || $next_href) { ?>
					<ul class="bo_v_nb">
						<?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01">이전글</a></li><?php } ?>
						<?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01">다음글</a></li><?php } ?>
					</ul>
					<?php } ?>
					<ul class="btn_bo_user">
						<?php if ($update_href) { ?>
						<li><a href="<?php echo $update_href ?>"  class="btn_b01">수정</a></li>
						<?php } ?>
						<?php if ($delete_href) { ?>
						<li><a href="<?php echo $delete_href ?>" class="btn_b01"  onclick="del(this.href); return false;">삭제</a></li>
						<?php } ?>
						<li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
						<?php if ($write_href) { ?>
						<li><a href="<?php echo $write_href ?>" class="btn_b01">글쓰기</a></li>
						<?php } ?>
					</ul>
				</div>

			</div>
			<hr>
			<?php
			// 코멘트 입출력
			include_once('./view_comment.php');
			include_once('./list2.php');
			 ?>
			<hr>
		</div>
		<!-- Left Sidebar -->
		<!-- Right Sidebar -->
		<div class="col-md-3 magazine-page">
			<?php include_once("./sidebar_page.php"); ?>
		</div>
		<!-- End Right Sidebar -->
	</div>
</div><!--/end container-->
<!--=== End Blog Posts ===-->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->
<?php if ($is_comment_write) { ?>
<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>

<script>
$("textarea#wr_content[maxlength]").live("keyup change", function() {
	var str = $(this).val()
	var mx = parseInt($(this).attr("maxlength"))
	if (str.length > mx) {
		$(this).val(str.substr(0, mx));
		return false;
	}
});
</script>

<script>
var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;
function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js();  ?>

	set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work)
{
    var el_id;
    // 댓글 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'bo_vc_w';

	if (save_before)
	{
		document.getElementById(save_before).style.display = 'none';
		document.getElementById(save_before).innerHTML = '';
	}

	document.getElementById(el_id).style.display = 'inline';
	//document.getElementById(el_id).innerHTML = save_html;
	$("#"+el_id).html(save_html);
	// 댓글 수정
	if (work == 'cu')
	{
		document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
		if (typeof char_count != 'undefined')
			check_byte('wr_content', 'char_count');
		if (document.getElementById('secret_comment_'+comment_id).value)
			document.getElementById('wr_secret').checked = true;
		else
			document.getElementById('wr_secret').checked = false;
	}

	if (comment_id)
	{
		var btnCancel = '<button type="button" style="color:red;" class="btn_b01" onclick="close_comt('+comment_id+');">취소</button>';
		$("#cancel-span").html(btnCancel).show();
		$(".cancel_work").hide();
		$("#cancel_work_"+comment_id).show();
	}    

	document.getElementById('comment_id').value = comment_id;
	document.getElementById('w').value = work;

	if(save_before) $("#captcha_reload").trigger("click");

	$(".bo_vc_act").show();
	$("#bo_vc_act_"+comment_id).hide();

	save_before = el_id;
}

function comment_delete()
{
    return confirm("이 댓글을 삭제하시겠습니까?");
}

function close_comt(comtid)
{
	$("#edit_"+comtid).html("").show();
	$("#reply_"+comtid).html("").show();
	$("#bo_vc_w").html(save_html).show();
	$(".bo_vc_act").show();
	//document.location.reload();
}

comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
// sns 등록
$(function() {
    $("#bo_vc_send_sns").load(
        "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>
</script>
<?php } ?>
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->