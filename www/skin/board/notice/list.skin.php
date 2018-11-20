<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<!--페이지 CSS Include 영역-->
<style>
.interactive-slider-v2 {height: 470px;}
.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}

@media (max-width: 767px) {
	.lsh-td-subj a{font-size:11px;}
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

<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="sw" value="">

<div class="container content lsh-toggle-fluid">
<!--
			<?php if ($write_href) { ?>
			<ul class="btn_bo_user btn_fa_ul">
				<?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_fa_list"><i class="fa fa-cog"></i></a></li><?php } ?>
				<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_fa_list"><i class="fa fa-pencil"></i></a></li><?php } ?>
			</ul>
			<?php } ?>
-->
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-20">
				<h2 class="pg-title"><?php echo $board['bo_subject'] ?></h2>
			</div>
			<div class="panel panel-default margin-bottom-20">
				<table class="table table-striped invoice-table">
					<thead>
						<tr>
							<th class="lsh-td-num">번호</th>
							<?php if ($is_checkbox) { ?>
							<th class="lsh-td-chk">
								<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
							</th>
							<?php } ?>
							<th class="lsh-td-subj">제목</th>
							<th class="lsh-td-name hidden-xxs hidden-xs">작성자</th>
							<th class="lsh-td-date hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>작성일</a></th>
							<th class="lsh-td-hit hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></th>
							<?php if ($is_good) { ?>
							<th class="lsh-td-good hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th>
							<?php } ?>
							<?php if ($is_nogood) { ?>
							<th class="lsh-td-nogood hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
					<?php for ($i=0; $i<count($list); $i++) { ?>
						<tr>
							<td class="lsh-td-num" style="width:60px;">
								<?php
								if ($list[$i]['is_notice']) // 공지사항
									echo '<strong>공지</strong>';
								else if ($wr_id == $list[$i]['wr_id'])
									echo "<span class=\"bo_current\">열람중</span>";
								else
									echo $list[$i]['num'];
								 ?>
							</td>
							<?php if ($is_checkbox) { ?>
							<td class="lsh-td-chk" style="width:40px;">
								<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
							</td>
							<?php } ?>
							<td class="lsh-td-subj">
								<span class="ellipsis">
								<?php
								echo $list[$i]['icon_reply'];
								if ($is_category && $list[$i]['ca_name']) { ?>
								<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link hidden-xxs hidden-xs"><?php echo $list[$i]['ca_name'] ?></a>
								<?php } ?>

								<a href="<?php echo $list[$i]['href'] ?>">
									<?php echo $list[$i]['subject'] ?>
									<?php if ($list[$i]['comment_cnt']) { ?><span style="color:red;">(<?php echo $list[$i]['comment_cnt']; ?>)</span><?php } ?>
								</a>
				
								<?php
								if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
								if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
								if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
								if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
								if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
								?>
								</span>
							</td>
							<td class="lsh-td-name hidden-xxs hidden-xs" style="width:100px;"><?php echo $list[$i]['name'];?></td>
							<td class="lsh-td-date hidden-xxs hidden-xs" style="width:120px;"><?php echo $list[$i]['datetime'];?></td>
							<td class="lsh-td-hit hidden-xxs hidden-xs" style="width:60px;"><?php echo $list[$i]['wr_hit'];?></td>
							<?php if ($is_good) { ?>
							<td class="lsh-td-good hidden-xxs hidden-xs"><?php echo $list[$i]['wr_good'] ?></td>
							<?php } ?>
							<?php if ($is_nogood) { ?>
							<td class="lsh-td-nogood hidden-xxs hidden-xs"><?php echo $list[$i]['wr_nogood'] ?></td>
							<?php } ?>
						</tr>
					<?php } ?>
					<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
					</tbody>
				</table>
			</div>

			<?php if ($is_checkbox || $write_href) { ?>
			<div class="bo_fx">
				<?php if ($is_checkbox) { ?>
					<div class="left-btn"><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></div>
				<?php } ?>
				<?php if ($write_href) { ?>
					<div class="right-btn"><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></div>
				<?php } ?>
			</div>
			<?php } ?>

			<?php echo $write_pages;  ?>
		</div>
		<!-- Left Sidebar -->
		<!-- Right Sidebar -->
		<div class="col-md-3 magazine-page">
			<?php include_once("./sidebar.php"); ?>
		</div>
		<!-- End Right Sidebar -->
	</div>
</div>

</form>

<!-- } 게시판 목록 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->
<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>

<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->