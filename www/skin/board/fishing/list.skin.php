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

	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-10">
				<h2 class="pg-title"><?php echo $board['bo_subject'] ?></h2>
			</div>
			<?php if ($is_checkbox) { ?>
			<div class="margin-bottom-10">
                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"> 전체선택
			</div>
			<?php } ?>
	        <?php for ($i=0; $i<count($list); $i++) {?>
			<?php 
				$left_class="col-sm-4";
				$right_class="col-sm-8";

				// 이미지 추출
				$imgsrc = "";
				if($list[$i][wr_device] == "p")
				{
					if($list[$i][wr_thumb]) $imgsrc = $list[$i][wr_thumb];
				}
				else if($list[$i][wr_device] == "m")
				{
					$imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table='{$bo_table}' and wr_id='{$list[$i]['wr_id']}' order by bf_no asc limit 1 ");
					if($imgsql[bf_file]) $imgsrc = G5_DATA_URL."/file/".$bo_table."/thumb/".$imgsql[bf_file];
				}
				if(!$imgsrc)
				{
					$left_class="";
					$right_class="col-sm-12";
				}

				$subj = utf8_strcut(get_text($list[$i]['wr_subject']),50,"...");// 제목
				$cont = utf8_strcut(strip_tags($list[$i]['wr_content']), 350, "...");// 내용
			?>
			<div class="row">
				<?php if ($is_checkbox) { ?>
				<div class="col-xxs-12">
					<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
				</div>
				<?php } ?>
				<a href="<?php echo $list[$i]['href'] ?>">			
				<?php if($imgsrc) { ?>
				<div class="<?php echo $left_class;?>" style="text-align:center;">
					<img class="img-responsive" style="display:inline-block;" src="<?php echo $imgsrc;?>" alt="">
				</div>
				<?php } ?>
				<div class="<?php echo $right_class;?>  news-v3">
					<div class="news-v3-in-sm no-padding">
						<ul class="list-inline posted-info">
							<li>작성일 : <?php echo $list[$i]['datetime'] ?></li>
							<li>조회수 : <?php echo $list[$i]['wr_hit'] ?></li>
						</ul>
						<h2><span class="ellipsis"><?php echo $subj ?></span></h2>
						<p><?php echo $cont;?></p>
					</div>
				</div>
				</a>
			</div>

			<div class="clearfix"><hr></div>
			<?php } ?>
			<?php if (count($list) == 0) { echo '<div class="row"><div class="col-xxs-12 empty_table">게시물이 없습니다.</div></div>'; } ?>
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