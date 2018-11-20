<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w=="")
{
	if($is_dhtml_editor) $devMod = "p";
	else  $devMod = "m";
}
else if($w=="u")
{
	if($is_dhtml_editor && $write[wr_device] == "p") $devMod = "p";
	else  $devMod = "m";
}
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<!--페이지 CSS Include 영역-->
<style>
.btn-bottom{padding: 4px 8px;border: 1px solid #ccc;color: #333;background-color: #efefef;}
h1.board-title{font-size:14px;text-align: left;color: #799747;font-weight: normal;}
input.frm_input{width: 100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}
textarea.frm_textarea{border: 1px solid #ccc;padding: 10px;outline:none !important;}
#hiddeniframe{width:0;height:0;border:none;outline:none;font-size:0;visibility:hidden;}
@media (max-width:1199px){
	.news-v3 .news-v3-in-sm h2 {font-size: 18px;}
	.news-v3 p {font-size:12px;line-height:1.3;}
	.list-inline > li {font-size:12px;}
	#bo_vc {font-size:12px;}
	#bo_vc p {line-height: 1.3em;}
	#bo_vc textarea.form-control {font-size:12px;}
	.btn_bo_user li {padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;font-size:12px;}
}
@media (max-width:767px){
	ul.list-inline {margin-bottom:0;}
	.news-v3 .news-v3-in-sm .posted-info li {font-size: 9px;}
	.news-v3 .news-v3-in-sm h2 {font-size: 15px; margin: 0 0 5px;}
	.news-v3 p {font-size:10px;line-height:1.3;}
	.list-inline > li {font-size:10px;}
	#bo_vc {font-size:10px;}
	#bo_vc p {line-height: 1.3em;}
	#bo_vc textarea.form-control {font-size:10px;}
	.btn_bo_user li {padding: 2px 6px;border: 1px solid #ccc;margin: 0 1px;background-color: #f8f8f8;font-size:11px;}
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

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" target="writeupdate">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" id="dev_mod" name="dev_mod" value="<?php echo $devMod?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_html || $is_secret) 
	{
        $option = '';
        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= '';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }
    }

    echo $option_hidden;
    ?>

	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-20">
				<h2 class="pg-title"><?php echo $board['bo_subject'] ?></h2>
			</div>

			<table class="table table-bordered">
				<tbody>
					<?php if ($is_name) { ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="wr_name" class="lsh-label">작성자<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 이름을 입력하세요.</div>
							<div class="col-sm-4 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="wr_name" id="wr_name" value="<?php echo $name ?>" maxlength="20" class="frm_input required" placeholder="Your name" required />
                            </div>
						</td>
					</tr>
					<?php } ?>
					<?php if ($is_password) { ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="wr_password" class="lsh-label">비밀번호<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 비밀번호를 입력하세요.</div>
							<div class="col-sm-8 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="password" name="wr_password" id="wr_password"  maxlength="20"  class="frm_input <?php echo $password_required ?>" placeholder="Password" <?php echo $password_required ?>>
                            </div>
						</td>
					</tr>
					<?php } ?>
					<?php if ($is_email) { ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="wr_email" class="lsh-label">이메일</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 이메일을 입력하세요.</div>
							<div class="col-sm-6 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="wr_email" id="wr_email" value="<?php echo $email ?>" maxlength="100" class="frm_input email" placeholder="E-mail">
                            </div>
						</td>
					</tr>
					<?php } ?>
					<?php if ($is_homepage) { ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="wr_homepage" class="lsh-label">홈페이지</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 홈페이지를 입력하세요.</div>
							<div class="col-sm-6 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" name="wr_homepage" id="wr_homepage" value="<?php echo $homepage ?>" maxlength="255" class="frm_input" placeholder="Homepage">
                            </div>
						</td>
					</tr>
					<?php } ?>
					<?php if ($option) { ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">옵션</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 옵션을 선택하세요.</div>
							<div class="col-xxs-12 input-group lsh-form-nopadding lsh-option-inline">
								<?php echo $option ?>
                            </div>
						</td>
					</tr>
					<?php } ?>
					<?php if ($is_category) { ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="ca_name" class="lsh-label">분류<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 카테고리를 선택하세요.</div>
							<div class="col-sm-2 input-group lsh-form-nopadding">
									<select name="ca_name" id="ca_name" class="form-control" required>
										<option value="0">선택하세요</option>
										<?php echo $category_option ?>
									</select>
                            </div>
						</td>
					</tr>
					<?php } ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="wr_subject" class="lsh-label">제목<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 제목을 입력하세요.</div>
							<div class="col-xxs-12 input-group lsh-form-nopadding">
								<input type="text" name="wr_subject" id="wr_subject" value="<?php echo $subject ?>"   class="frm_input  " maxlength="255" placeholder="Subject">
                            </div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="wr_content" class="lsh-label">내용<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1 wr_content">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 내용을 작성하세요.</div>
							<?php if($devMod == "p") { ?>
							<div id="smeditor">
								<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
							</div>
							<div id="txteditor" class="col-xxs-12 input-group">
								<textarea rows="10" name="wr_content2" id="wr_content2"  maxlength="65536" class="frm_textarea" style="width:100%;resize:vertical;" placeholder="세부내용"><?php echo $content; ?></textarea>
							</div>
							<?php } else { ?>
							<div class="col-xxs-12 input-group">
								<textarea rows="16" name="wr_content" id="wr_content"  maxlength="65536" class="frm_textarea" style="width:100%;resize:vertical;" placeholder="세부내용"><?php echo $content; ?></textarea>
							</div>
							<?php } ?>
						</td>
					</tr>
					<?php if($w=="") { ?>
					<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
					<tr class="fileattatch">
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="" class="lsh-label"> 파일첨부 #<?php echo $i+1 ?><strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 파일첨부 #<?php echo $i+1 ?></div>
							<div class="col-xxs-12 input-group lsh-form-nopadding lsh-file-form">
								<label for="file" class="input input-file">
	                                <div class="button"><input type="file" name="bf_file[]"  title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" onchange="this.parentNode.nextSibling.value = this.value">Browse</div><input type="text" readonly>
								</label>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php } else if($w=="u" && $devMod == "m") { ?>
					<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
					<tr class="fileattatch">
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="" class="lsh-label">파일첨부<strong class="sound_only">필수</strong></label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 파일첨부 #1</div>
							<div class="col-xxs-12 input-group lsh-form-nopadding lsh-file-form">
								<label for="file" class="input input-file">
	                                <div class="button"><input type="file" name="bf_file[]"  title="파일첨부 1 : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" onchange="this.parentNode.nextSibling.value = this.value">Browse</div><input type="text" readonly>
								</label>
								<?php if($w == 'u' && $file[$i]['file']) { ?>
								<div><span class="ellipsis">파일명 : <?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?></span></div>
								<label for="bf_file_del<?php echo $i ?>">
									<input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i ?>]" value="1" style="height:12px;vertical-align:middle;"> ※ 체크시 삭제
								</label>
								<?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php } ?>
					<!--
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label  class="lsh-label">YouTube 동영상</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 동영상 주소</div>
							<div class="col-xxs-12 input-group lsh-form-nopadding">
								<span class="input-group-addon"><i class="fa fa-video-camera"></i></span>
								<input type="text" name="wr_yturl" id="wr_yturl" value="<?php echo get_text($write["wr_yturl"]); ?>"  class="frm_input" maxlength="255" placeholder="Youtube 영상의 URL을 입력하세요">
                            </div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label class="lsh-label">관련태그</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 태그를 입력하세요.</div>
							<div class="col-xxs-12 input-group lsh-form-nopadding">
								<input type="text" name="wr_tags" id="wr_tags" value="<?php echo $write[wr_tags]; ?>"  required class="frm_input " maxlength="255" placeholder="관련태그">
                            </div>
						</td>
					</tr>
					-->
					<?php if ($is_guest) { //자동등록방지  ?>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label class="lsh-label">자동등록방지</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 자동등록방지</div>
							<div class="col-xxs-12 input-group lsh-form-nopadding">
								<?php echo captcha_html(); ?>
                            </div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<div style="padding-bottom:40px;">
				<div class="lsh-write-btn-left">
					<a class="btn-bottom" href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table; ?>">목록</a>
				</div>
				<div class="lsh-write-btn-right">
					<input type="submit" class="btn-bottom"  id="btn_submit" accesskey="s" value="작성완료">
					<button type="button" class="btn-bottom" onclick="window.history.back();">취소</button>
				</div>
			</div>

		</div>
		<!-- Left Sidebar -->
		<!-- Right Sidebar -->
		<div class="col-md-3 magazine-page">
			<?php include_once("./sidebar.php"); ?>
		</div>
		<!-- End Right Sidebar -->
	</div>          

    </form>
</div><!--/container-->     
<iframe id="hiddeniframe" name="writeupdate"></iframe>

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php// include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->

<script>
<?php if($devMod == "p") { ?>
<?php if($w=="") { ?>
$(document).load($(window).bind("load resize", makeWriteResponsive));
function makeWriteResponsive(e) {
    if ($("#divwrap").outerWidth() < 751) {
        $("#smeditor").css("width", "0px").css("height", "0px").css("visibility", "hidden");
        $("#wr_content").attr("name", "wr_content2").hide();
        $("#wr_content2").attr("name", "wr_content").show();
        $("#txteditor").show();
        $(".fileattatch").show();
        $("#dev_mod").val("m")
    } else {
		 // 연관소스수정됨 -- /plugin/editor/smarteditor2/editor.lib.php -- 47라인 --높이값 지정함.
		 // 연관소스수정됨 -- /plugin/editor/smarteditor2/js/HuskyEZCreator.js -- 73라인
		 // 연관소스수정됨 -- /plugin/editor/smarteditor2/photo_uploader/plugin/hp_SE2M_AttachQuickPhoto.js -- 98라인 -- 이미지 반응형 코드추가
		 // 연관소스수정됨 -- /extend/smarteditor_upload_extend.php -- 이미지 크기 trim 코드
        $("#smeditor").css("width", "100%").css("height", "auto").css("visibility", "visible");
        $("#wr_content").attr("name", "wr_content").hide();
        $("#wr_content2").attr("name", "wr_content2").hide();
        $("#txteditor").hide();
        $(".fileattatch").hide();
        $("#dev_mod").val("p")
    }
}
<?php } else if($w=="u") {?>
$(document).load($(window).bind("load resize", makeWriteResponsive));
function makeWriteResponsive(e) {
    if ($("#divwrap").outerWidth() < 751) {
        $("#smeditor").css("width", "0px").css("height", "0px").css("visibility", "hidden");
        $("#wr_content").attr("name", "wr_content2").hide();
        $("#wr_content2").attr("name", "wr_content").show();
        $("#txteditor").show();
    } else {
		 // 연관소스수정됨 -- /plugin/editor/smarteditor2/editor.lib.php -- 47라인 --높이값 지정함.
		 // 연관소스수정됨 -- /plugin/editor/smarteditor2/js/HuskyEZCreator.js -- 73라인
		 // 연관소스수정됨 -- /plugin/editor/smarteditor2/photo_uploader/plugin/hp_SE2M_AttachQuickPhoto.js -- 98라인 -- 이미지 반응형 코드추가
		 // 연관소스수정됨 -- /extend/smarteditor_upload_extend.php -- 이미지 크기 trim 코드
        $("#smeditor").css("width", "100%").css("height", "auto").css("visibility", "visible");
        $("#wr_content").attr("name", "wr_content").hide();
        $("#wr_content2").attr("name", "wr_content2").hide();
        $("#txteditor").hide();
    }
}
<?php } ?>
<?php } ?>
</script>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});

<?php } ?>
function html_auto_br(obj)
{
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f)
{
	var devmode = $("#dev_mod").val();
	if(devmode == "p")
	{
		<?php echo $editor_js; ?>// 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함  
	}

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
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

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	//document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>

<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->