<?php
include_once('./_common.php');
$pgubun = "pagegallery";

$active_0 = $active_1 = $active_2 = $active_3 = $active_4 = "";
switch($ca_name)
{
	case("house") : $active_1 = "active"; break;
	case("business") : $active_2 = "active"; break;
	case("office") : $active_3 = "active"; break;
	case("etc") : $active_4 = "active"; break;
	default : $active_0 = "active"; break;
}

$ca_sql = "";
if($ca_name) $ca_sql = " and ca_name = '$ca_name' ";

$sql_tmp = " select wr_id from g5_write_gallery where wr_is_comment = 0 $ca_sql ";
$result_tmp = sql_query($sql_tmp);
$tot_cnt = sql_num_rows($result_tmp);

$pgcnt = 12;
$sqlg = " select * from g5_write_gallery where wr_is_comment = '0' $ca_sql order by wr_datetime desc limit {$pgcnt} ";
$resultg = sql_query($sqlg);

include_once(G5_PATH.'/head.php');

?>
<style>
.lsh-cube-ul>.active a {color:#e39799; font-weight:bolder;}
</style>


<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v2">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">조황정보</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<!--=== Content Part ===-->
<div class="container content">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-20">
				<h2 class="pg-title">조황정보</h2>
			</div>
			<!--=== Cube-Portfdlio ===-->
			<div class="cube-portfolio margin-bottom-20" style="max-width:1140px;">
				<div id="grid-container" class="cbp-l-grid-fullWidth">
					<? for ($i=0; $rowg=sql_fetch_array($resultg); $i++) { ?>
					<?php 
					// 이미지 추출
					$imgsrc = "";
					if($rowg[wr_device] == "p")
					{
						$matches = get_editor_image($rowg['wr_content'], false);
						for($i=0; $i<count($matches[1]); $i++)
						{
							// 이미지 path 구함
							$p = parse_url($matches[1][$i]);
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
					else if($rowg[wr_device] == "m")
					{
						$imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table='gallery' and wr_id='{$rowg['wr_id']}' order by bf_no asc limit 1 ");
						if($imgsql[bf_file]) $imgsrc = G5_DATA_URL."/file/gallery/thumb/".$imgsql[bf_file];

					}

					$subj = utf8_strcut(get_text($rowg['wr_subject']),30,"...");// 제목
					$cont = utf8_strcut(strip_tags($rowg['wr_content']), 150, "...");// 내용
					?>
					<div class="cbp-item <?php echo $rowg[ca_name]; ?>">
						<div class="cbp-caption">
							<div class="img-hover-v2 cbp-caption-defaultWrap">
								<img src="<?php echo $imgsrc;?>" alt="">
							</div>
							<div class="cbp-caption-activeWrap">
								<div class="cbp-l-caption-alignCenter">
									<div class="cbp-l-caption-body">
										<ul class="link-captions">
											<li>
												<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=gallery&wr_id=<?php echo $rowg[wr_id];?>"><i class="rounded-x fa fa-link"></i></a>
											</li>
											<li id="lsh-lightbox-wrap-<?php echo $rowg[wr_id];?>" class="lsh-lightbox-wrap">
												<a id="<?php echo $rowg[wr_id];?>" href="<?php echo $imgsrc; ?>" class="cbp-lightbox" data-title="<?php echo $fileinfo[bf_content];?>" data-wrid="<?php echo $rowg[wr_id];?>"><i class="rounded-x fa fa-search"></i></a>
											</li>
										</ul>
										<div class="cbp-l-grid-agency-title"><?php echo $subj;?></div>
										<div class="cbp-l-grid-agency-desc"><?php echo $rowg[ca_name];?></div>
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
		</div>
		<!-- End Left Sidebar -->
		<!-- Right Sidebar -->
		<div class="col-md-3 magazine-page">
			<div class="row">
				<?php include_once(G5_BBS_PATH."/sidebar_page.php"); ?>
			</div>
		</div>
		<!-- End Right Sidebar -->
	</div><!--/row-->
</div><!--/container-->
<!--=== End Content Part ===-->


<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->
<script>
$(document).ready(function() {

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