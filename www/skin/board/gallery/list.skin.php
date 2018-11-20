<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "gallery";

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
	.cube-portfolio .cbp-l-grid-agency-title {font: 400 11px/13px "Open Sans", sans-serif;}
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
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"> <label for="chkall">전체선택</label>
			</div>
			<?php } ?>
			<div class="cube-portfolio margin-bottom-20">
				<div id="grid-container" class="cbp-l-grid-fullWidth">
				<?php for ($i=0; $i<count($list); $i++) {?>
				<?php 
					// 이미지 추출
					$imgsrc = "";
					if($list[$i][wr_device] == "p")
					{
						if($list[$i][wr_thumb]) $thumbsrc = $list[$i][wr_thumb];

						$matches = get_editor_image($list[$i]['wr_content'], false);
						for($j=0; $j<count($matches[1]); $j++)
						{
							// 이미지 path 구함
							$p = parse_url($matches[1][$j]);
							if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
								$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
							else
								$data_path = $p['path'];

							$srcfile = G5_PATH.$data_path;

							if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile) && is_file($srcfile)) {
								$size = @getimagesize($srcfile);
								if(empty($size)) continue;
								$imgsrc = $data_path;
								break;
							}
						}
					}
					else if($list[$i][wr_device] == "m")
					{
						$imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table='gallery' and wr_id='{$list[$i]['wr_id']}' order by bf_no asc limit 1 ");
						if($imgsql[bf_file]) 
						{
							$thumbsrc = G5_DATA_URL."/file/gallery/thumb/".$imgsql[bf_file];
							$imgsrc = G5_DATA_URL."/file/gallery/".$imgsql[bf_file];
						}
					}

					$subj = utf8_strcut(get_text($list[$i]['wr_subject']),30,"...");// 제목
					$cont = utf8_strcut(strip_tags($list[$i]['wr_content']), 150, "...");// 내용
				?>
				<div class="cbp-item <?php echo $list[$i][ca_name]; ?>">
					<?php if ($is_checkbox) { ?>
					<div>
						<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
					</div>
					<?php } ?>
					<div class="cbp-caption">
						<div class="img-hover-v2 cbp-caption-defaultWrap">
							<img src="<?php echo $thumbsrc;?>" alt="">
						</div>

						<div class="cbp-caption-activeWrap">
							<div class="cbp-l-caption-alignCenter">
								<div class="cbp-l-caption-body">
									<ul class="link-captions">
										<li>
											<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=gallery&wr_id=<?php echo $list[$i][wr_id];?>"><i class="rounded-x fa fa-link"></i></a>
										</li>
										<li id="lsh-lightbox-wrap-<?php echo $list[$i][wr_id];?>" class="lsh-lightbox-wrap">
											<a href="<?php echo $imgsrc; ?>" class="cbp-lightbox" data-title="<?php echo $fileinfo[bf_content];?>" data-wrid="<?php echo $list[$i][wr_id];?>"><i class="rounded-x fa fa-search"></i></a>
										</li>
									</ul>
									<div class="cbp-l-grid-agency-title"><?php echo $subj;?></div>
									<div class="cbp-l-grid-agency-desc"><?php echo $list[$i][ca_name];?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- 이부분이 해당글 이미지 불러오는 부분 ajax처리로 밀어넣어야 함. -->
				<div id="cbpitems" class="cbp-item">
				</div>
				<!-- 이부분이 해당글 이미지 불러오는 부분 ajax처리로 밀어넣어야 함. -->
				</div><!--/end Grid Container-->

				<?php if($tot_cnt>$pgcnt) { ?>	
				<div class="cbp-l-loadMore-button">
					<a href="<?php echo G5_SHIP_URL; ?>/loadmore.php?pgcnt=<?php echo $pgcnt; ?>&ca_name=<?php echo $ca_name; ?>" class="cbp-l-loadMore-button-link">LOAD MORE</a>
				</div>
				<?php } ?>
			</div>
			<!--=== End Cube-Portfdlio ===-->
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
			<?php include_once("./sidebar_page.php"); ?>
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

<script>
$(document).ready(function() {

	//$("#grid-container .cbp-wrapper").last().remove();
	// 이부분이 해당글 이미지 불러오게 처리하는 스크립트
	$(".cbp-lightbox").click(function(e) {
		e.preventDefault();
		var wrid = $(this).data("wrid");
		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_get_images.php",
			data: "wr_id="+wrid, 
			async: false,
			success: function(msg)
			{ 
				var msgarray = $.parseJSON(msg);
				if(msgarray.rslt == "error")
				{
					alert(msgarray.errcode); 
					if(msgarray.errurl)  document.location.replace(msgarray.errurl);
					else	document.location.reload();
				}
				else
				{
					$('#cbpitems').html(msgarray.cont); //첨부된 이미지를 보여줌.
				}
			}
		}); 


		$(".lsh-lightbox-wrap").each(function( index ) {
			$(this).find("a").removeClass("cbp-lightbox");
		});		
		$(this).addClass("cbp-lightbox");
	});
})
</script>

<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->