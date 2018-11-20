<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

for($j=0;$j<5;$j++) {
	$_imgsql = "";
	$_imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$j}' ");

	$_imgsrc_alias = "img".$j;
	$$_imgsrc_alias = G5_DATA_URL."/file/m_ship/thumb2/".$_imgsql[bf_file];
	$_imgsrc2_alias = "bigimg".$j;
	$$_imgsrc2_alias = G5_DATA_URL."/file/m_ship/thumb/".$_imgsql[bf_file];

	$shipBigImgs .= "<div class='swiper-slide' style='background-image:url(".$$_imgsrc2_alias."'></div>";
	$shipSmallImgs .= "<div class='swiper-slide' style='background-image:url(".$$_imgsrc_alias."'></div>";
}

?>
<div class="gallery-top">
	<div class="swiper-wrapper">
		<?php echo $shipBigImgs;?>
	</div>
	<!-- Add Arrows -->
	<div class="swiper-button-next swiper-button-white"></div>
	<div class="swiper-button-prev swiper-button-white"></div>
</div>
<div class="gallery-thumbs">
	<div class="swiper-wrapper">
		<?php echo $shipSmallImgs;?>
	</div>
</div>