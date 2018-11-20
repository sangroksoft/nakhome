<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "introduce";

//===================== 어선정보가져옴 ========================
$sql_ship = " select * from m_ship where s_expose = 'y' ";
$result_ship = sql_query($sql_ship);

$ships = "";
$shipSelect = "";
$shipBigImgs = "";
$shipSmallImgs = "";

for($i=0;$srow=sql_fetch_array($result_ship);$i++) {

	// 첫번째 어선이미지
	if($i==0)
	{
		$shipName = get_text($srow[s_name]);
		$shipDesc = get_text($srow[s_cont],1);
		for($j=0;$j<5;$j++) {
			$_imgsql = "";
			$_imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table = 'm_ship' and wr_id = '1' and bf_no = '{$j}' ");

			$_imgsrc_alias = "img".$j;
			$$_imgsrc_alias = G5_DATA_URL."/file/m_ship/thumb2/".$_imgsql[bf_file];
			$_imgsrc2_alias = "bigimg".$j;
			$$_imgsrc2_alias = G5_DATA_URL."/file/m_ship/thumb/".$_imgsql[bf_file];

			$shipBigImgs .= "<div class='swiper-slide' style='background-image:url(".$$_imgsrc2_alias."'></div>";
			$shipSmallImgs .= "<div class='swiper-slide' style='background-image:url(".$$_imgsrc_alias."'></div>";
		}

		$svcdivstr = '';
		$k=0; 
		while($k < count($_menu_arr)) { 
			$m_subj = $_menu_arr[$k][0];
			$m_key = $_menu_arr[$k][1];
			
			$chkstr = "";
			if(in_array($m_key, array_map("trim", explode('|', $srow[s_service])))) $chkstr = "checked='checked' ";
			$k++; 
			
			$svcdivstr .= '<div class="col-xxs-6 col-xs-4 col-sm-3">';
			$svcdivstr .= '<input type="checkbox" id="svc_'.$m_key.'" '.$chkstr.' onclick="return false;" />';
			$svcdivstr .= '<label for="svc_'.$m_key.'" style="padding-left:4px;">'.$m_subj.'</label>';
			$svcdivstr .= '</div>';
		}

		$first_s_idx = $srow[s_idx];
		$is_selected = " on";
	}
	else
	{
		$is_selected = "";
	}

	// 등록어선명
	$ships .= "<li class='ship-li'><span class='ship-name".$is_selected."' data-sidx='".$srow[s_idx]."'>".get_text($srow[s_name])."</span></li>";

	// 셀렉트박스
	$shipSelect .= "<option value='".$srow[s_idx]."'>".get_text($srow[s_name])."</option>";
}
//===================== 어선정보가져옴 ========================

include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/swiper/css/swiper.min.css">

<style>
.interactive-slider-v2 {height: 470px;}
.swiper-container {width: 100%;height: 640px;margin:0 auto;}
.swiper-slide {background-size: cover;background-position: center;}
.gallery-top {height: 80%;width: 100%;}
.gallery-thumbs {height: 20%;box-sizing: border-box;padding: 10px 0 0;}
.gallery-thumbs .swiper-slide {height: 100%;opacity: 0.4;}
.gallery-thumbs .swiper-slide-active {opacity: 1;}

div.ship-wrap{margin-top:40px;padding-bottom:10px;}
ul.ship-ul{margin:0;padding:0;}
li.ship-li{margin:0;padding:0;float:left;list-style:none;padding-right:5px;padding-bottom:5px;}
li.ship-li span{display:inline-block;padding:0 8px; border:none; background:#efefef; border-radius:15px;height:28px;line-height:28px;cursor:pointer;}
li.ship-li span.on{background:#f99292;color:#fff;}
.ship-kind{float:right;margin-top: 5px;height: 34px;border: 1px solid #dadada;border-radius: 10px;outline: none !important;}
span.ship-detail, span.ship-hide{position: absolute;right: 15px;border: 1px solid #dadada;padding: 4px 6px;cursor:pointer;}

.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;margin-bottom: 5px;}
.table-title{border-bottom: 1px dotted #ccc;margin-bottom: 30px;}

.shipdesc {padding-top:20px;}
.ship-desc p{font-size:14px;}
@media (max-width: 991px) {
	.swiper-container {height: 760px;}
}
@media (max-width: 850px) {
	.swiper-container {height: 440px;}
}
@media (max-width: 768px) {
	.shipdesc {font-size: 11px;}
	.ship-desc label{font-size:11px;margin-bottom:0px;}
}
</style>

<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v1">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">선박소개</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<!--=== Content Part ===-->
<div class="container content">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-20">
				<h2 class="pg-title">선박소개</h2>
			</div>
			<!--Blog Post-->
			<div class="blog margin-bottom-40">
				<ul id="rtn_ships" style="margin:0;padding:0;">
					<?php echo $ships;?>
				</ul>
				<div id="ship_detail" class="row">
					<div class="col-xxs-12" style="padding-top:10px;">
						<!-- Swiper -->
						<div style="padding:10px;border:1px solid #dadada;">
							<div id="shipImgs" class="swiper-container">
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
							</div>
						</div>

						<p id="shipdesc" class="shipdesc"><?php echo $shipDesc;?></p>
					</div>
				</div>
			</div>
			<!--End Blog Post-->
			<div class="table-title col-xxs-12">
				<span class="item-fa"><i class="fa fa-anchor"></span></i>
				<h3 class="item-title"><span id="shipName"><?php echo $shipName;?></span> 제공 서비스</h3>
			</div>
			<div id="shipsvc" class="ship-desc row">
				<?php echo $svcdivstr; ?>
			</div>
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
<script src="<?php echo G5_URL;?>/assets/plugins/swiper/js/swiper.js"></script>
<script>
	// 스와이퍼 초기화
	function initSwiper() {
		var galleryTop = new Swiper('.gallery-top', {
			nextButton: '.swiper-button-next',
			prevButton: '.swiper-button-prev',
			spaceBetween: 10,
			loop:true,
			loopedSlides: 5, //looped slides should be the same     
		});
		var galleryThumbs = new Swiper('.gallery-thumbs', {
			spaceBetween: 10,
			slidesPerView: 4,
			touchRatio: 0.2,
			loop:true,
			loopedSlides: 5, //looped slides should be the same
			slideToClickedSlide: true
		});
		galleryTop.params.control = galleryThumbs;
		galleryThumbs.params.control = galleryTop;
	}

	// 어선자세히 보기
	$(document).off("click",".ship-name").on("click",".ship-name",function(e){
			var sidx= $(this).data("sidx");
			var _this = $(this);
			$.ajax({ 
				type: "GET",
				url: "./ajax_get_shipinfo.php",
				data: "s_idx="+sidx, 
				beforeSend: function(){
					loadstart();
				},
				success: function(msg){ 
					var msgarray = $.parseJSON(msg);
					if(msgarray.rslt == "error")
					{
						alert(msgarray.errcode); 
						if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
						else {	loadend(); return false;}
					}
					else
					{
						$(".ship-name").removeClass("on");
						$("#shipImgs").html(msgarray.cont);
						$("#shipName").html(msgarray.shipName);
						$("#shipsvc").html(msgarray.shipsvc);
						$("#shipdesc").html(msgarray.shipdesc);
						_this.addClass("on");
					}
				},
				complete: function(){
					initSwiper();
					loadend();
				}
			});
	});

$(document).ready(function(){
	initSwiper();
});

</script>

<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->