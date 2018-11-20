<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "map";

$mapsql = sql_fetch(" select bf_file from g5_board_file where bo_table='m_map' and bf_no='0' ");
$mapimg = G5_DATA_URL."/file/m_map/".$mapsql[bf_file];

include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<style>
.interactive-slider-v2 {height: 470px;}
#map {width: 100%;height: 600px;}

@media (max-width: 640px) {
	#map {height: 350px;max-height: 350px;}
}

</style>

<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v4">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">오시는 길</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<!--=== Content Part ===-->
<div class="container content">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<!-- Begin Content -->
			<div class="margin-bottom-20">
				<h2 class="pg-title">오시는 길</h2>
			</div>
			<?php if($comfig[smap] == "0") { ?>
			<div id="map"></div>
			<?php } else { ?>
			<div style="text-align:center;"><img src='<?php echo $mapimg;?>' class='img-responsive' style="display:inline-block;"></div>
			<?php } ?>
			<!-- End Content -->
		</div>
		<!-- End Left Sidebar -->

		<!-- Right Sidebar -->
		<div class="col-md-3 magazine-page">
			<?php include_once(G5_BBS_PATH."/sidebar_page.php"); ?>
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
<?php if($comfig[smap] == "0") { ?>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=Dv_8nUFfgEq19d9vRIwk&submodules=geocoder"></script>
<!--페이지 스크립트 영역-->
<script>

var map = new naver.maps.Map('map', {
    center: new naver.maps.LatLng(34.925107, 128.077084),
    zoom: 10
});

var marker = new naver.maps.Marker({
    position: new naver.maps.LatLng(34.925107, 128.077084),
    map: map
});


var map = new naver.maps.Map('map', mapOptions);
</script>
<?php } ?>
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->