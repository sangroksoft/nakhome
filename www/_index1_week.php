<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css">
<style>
h4.slick-v2-title {font-weight:bolder;}
.slick-v2-info{padding:0 8px;}
.slick-slide {background:#fff; outline: 1px solid #efefef;border-bottom:1px solid #efefef;}
p.slick-v2-text{height:60px;}

.posts{border:1px solid #ccc;padding: 0 15px;max-height:380px;}
.blog-trending li {border-bottom: 1px dotted #ddd;}
.latest-title{font-size:14px;font-weight:bolder;line-height:17px;}
.news-v3 p {margin-top: 8px;}

.title-h3 {color:#e04f67;font-weight:bolder;}

.headline {display: block;margin: 10px 0 25px;border-bottom: 1px dotted #e4e9f0;}
.headline h2 {margin: 0 0 -2px;padding-bottom: 5px;display: inline-block;border-bottom: 2px solid #72c02c;}
.custom-header h3 {}

/*신규 일주일분 칼렌더*/
.wday-wrap ul, li{margin:0;padding:5px 0;list-style:none;font-size: 12px;line-height: 14px;}
.wday-wrap .table{margin-bottom:0px;}
/*.wday-wrap .table-condensed > tbody > tr > td {max-width: 200px;min-width: 180px;}*/
/*.wday-wrap .table > thead > tr > th{height: 40px;line-height: 40px; text-align: center;}*/
.wday-wrap .table > thead > tr > th{height: 40px;text-align: center;}
.wday-wrap .table > thead > tr > th:first-child{line-height: 40px;}
.wday-wrap .table-condensed > tbody > tr > td {max-width: 250px;min-width: 190px;}
.wday-wrap .table-responsive {width: 100%;margin-bottom: 0px;overflow-y: hidden;-ms-overflow-style: -ms-autohiding-scrollbar;border: 1px solid #ddd;}
.wday-wrap .table-responsive > .table > tbody > tr > td {white-space: normal;}
.wday-wrap .table-responsive > .table-bordered {border:0;}
.wday-wrap .table-responsive > .table-bordered > thead > tr > th:last-child {border-right:0;} 
.wday-wrap .table-responsive > .table-bordered > tbody > tr > td:last-child {border-right:0;} 
.wday-wrap .table-responsive > .table-bordered > thead > tr > th:first-child {border-left:0;} 
.wday-wrap .table-responsive > .table-bordered > tbody > tr > td:first-child {border-left:0;text-align:center;vertical-align: middle;max-width: 170px;}
.wday-wrap .table-responsive > .table-bordered > tbody > tr:last-child > td{border-bottom:0;}
.wday-wrap .table-responsive > .fixed-column {position: absolute;display: inline-block;width: auto;border-left:0;border-top:0;border-bottom:0;border-right:1px solid #a7a7a7;background: #fff;}

.ship-name-span{font-weight: bold;color: #000;min-height:100px;}
.sc-theme{font-weight: bold;color: #000;padding-bottom: 6px;display: inline-block;}

@media (max-width:767px){
	.wday-wrap .table-condensed > tbody > tr > td {max-width: 180px;min-width: 150px;}
	.wday-wrap .table-responsive > .table-bordered > tbody > tr > td:first-child {max-width: 100px;min-width: 100px;}
}

/*Scrollbar*/
.mCustomScrollBox{max-height:380px;height:290px;padding:0;}
.mCS-autoHide > .mCustomScrollBox > .mCSB_scrollTools, .mCS-autoHide > .mCustomScrollBox ~ .mCSB_scrollTools {opacity: 0.2;}
.mCSB_container{padding: 0;}
.mCSB_outside + .mCS-minimal-dark.mCSB_scrollTools_vertical{right:-15px;}
@media (max-width: 1199px) {
	.latest-title{font-size:12px;}
	.news-v3 p {font-size:11px;line-height:15px;}
}
@media (max-width: 991px) {
	.lsh-col-gap-5{padding:5px 5px;}
	.latest-title{font-size:12px;}
	.fc-calendar .fc-row > div > div span{ font-size: 12px; line-height: 16px;}
	.news-v3 p {font-size:11px;line-height:15px;}
	.title-h3 {font-size:18px;}

	.header-fixed .header-v6, .header-fixed .header-v6.header-fixed-shrink{position:fixed;width:100%;}
	.header-v6 .menu-container{background: rgba(0,0,0,.2);}
	.header-v6.header-white-transparent .navbar{background:none;}
	.header-fixed .header-v6.header-fixed-shrink{background: rgba(255,255,255,1);box-shadow:0px 1px 10px -3px rgba(0, 0, 0, 0.31);}

	.header-v6 .navbar-brand img.default-logo{display:inherit;}
	.header-v6 .navbar-brand img.shrink-logo{display:none;}

	.header-fixed .header-v6.header-fixed-shrink img.default-logo{display:none;}
	.header-fixed .header-v6.header-fixed-shrink img.shrink-logo{display:inherit;}
	.header-v6.header-fixed-shrink .menu-container{background: none;}

	.header-v6 .navbar-nav{margin: 0 -15px;background:rgba(36, 39, 47, 0.5);padding: 0 15px;}
	.header-v6 .navbar-nav > li a {border-top: 1px solid #929292;}
	.header-v6 .navbar-nav > li > a{color:#fff;}
	.header-v6 .navbar-collapse {border:none;}
	.header-v6.header-fixed-shrink .navbar-nav{margin: 0 -15px;background:rgba(255, 255, 255, 0.9);padding: 0 15px;}
	.header-v6.header-fixed-shrink .navbar-nav > li a {border-top: 1px solid #ccc;}
	.header-v6.header-fixed-shrink .navbar-nav > li > a{color:#000;}

	.header-v6 .navbar-toggle{background: none;}
	.header-v6 .navbar-toggle .icon-bar{background: #fff;}

	.header-v6 .navbar-toggle{background: none; margin: 29px 0 29px 15px;}
	.header-v6.header-fixed-shrink .navbar-toggle .icon-bar{background: #000;}
}
@media (max-width: 881px) {
	.cal-container {min-height:400px;}
	#calReturn{border:1px solid #ccc;}
	.fc-calendar {height: 350px;overflow-y: auto;	}
	.fc-calendar .fc-row > div {padding: 2px 10px;}
	.custom-header{border-bottom:4px solid #777;}
	.fc-calendar .fc-row > div > div{max-width: 100%; display: block; padding-left: 20%;}
	.fc-calendar .fc-row > div > div span{ font-size: 11px; line-height: 16px;}
	.fc-calendar .fc-row > div > span.fc-weekday{font-size: 11px;float: left;padding-top: 2px;padding-left:0px;}
	.ymdselect{font-size:12px;letter-spacing:0px;}
	.divtide{padding-bottom:24px;}
	.p-merit{font-size:11px;}
}

@media (max-width: 767px) {
	.title-h3 {font-size:18px;line-height: 18px;}
	.p-merit{font-size:11px;}
	.br-merit{display:none;}
}
@media (max-width: 560px) {
}
@media (max-width: 479px) {
	.br-merit{display:inline;}
}
</style>
<!--페이지 CSS Include 영역-->
<!--=== Slider ===-->
<div class="tp-banner-container">
	<div class="tp-banner" style="position:relative;background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('<?php echo $msimg0; ?>'); background-size: cover; background-position: left top; width: 100%; height: 100%; opacity: 1; visibility: inherit;">
		<ul>
			<!-- SLIDE -->
			<li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 1">
				<!-- MAIN IMAGE -->
				<img src="<?php echo $msimg0; ?>"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

				<div class="tp-caption revolution-ch1 sft start"
					data-x="center"
					data-hoffset="0"
					data-y="200"
					data-speed="1500"
					data-start="500"
					data-easing="Back.easeInOut"
					data-endeasing="Power1.easeIn"
					data-endspeed="300">
					<?php echo $msimgcont0;?>
				</div>

				<!-- LAYER -->
				<div class="tp-caption sft"
					data-x="center"
					data-hoffset="0"
					data-y="310"
					data-speed="1500"
					data-start="1000"
					data-easing="Power4.easeOut"
					data-endspeed="300"
					data-endeasing="Power1.easeIn"
					data-captionhidden="off"
					style="z-index: 6">
					<a href="<?php echo G5_SHIP_URL; ?>/introduce.php" class="btn-u btn-brd btn-brd-hover btn-u-light">선박보기</a>
					<a href="javascript:;" onclick="gotoBooking();" class="btn-u btn-brd btn-brd-hover btn-u-light">예약하기</a>
				</div>
			</li>
			<!-- END SLIDE -->
			<!-- SLIDE -->
			<li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 2">
				<!-- MAIN IMAGE -->
				<img src="<?php echo $msimg1; ?>"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

				<div class="tp-caption revolution-ch1 sft start"
					data-x="center"
					data-hoffset="0"
					data-y="200"
					data-speed="1500"
					data-start="500"
					data-easing="Back.easeInOut"
					data-endeasing="Power1.easeIn"
					data-endspeed="300">
					<?php echo $msimgcont1;?>
				</div>

				<!-- LAYER -->
				<div class="tp-caption sft"
					data-x="center"
					data-hoffset="0"
					data-y="310"
					data-speed="1500"
					data-start="1000"
					data-easing="Power4.easeOut"
					data-endspeed="300"
					data-endeasing="Power1.easeIn"
					data-captionhidden="off"
					style="z-index: 6">
					<a href="<?php echo G5_SHIP_URL; ?>/introduce.php" class="btn-u btn-brd btn-brd-hover btn-u-light">선박보기</a>
					<a href="javascript:;" onclick="gotoBooking();" class="btn-u btn-brd btn-brd-hover btn-u-light">예약하기</a>
				</div>
			</li>
			<!-- END SLIDE -->
			<!-- SLIDE -->
			<li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000" data-title="Slide 3">
				<!-- MAIN IMAGE -->
				<img src="<?php echo $msimg2; ?>"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
				<div class="tp-caption revolution-ch1 sft start"
					data-x="center"
					data-hoffset="0"
					data-y="200"
					data-speed="1500"
					data-start="500"
					data-easing="Back.easeInOut"
					data-endeasing="Power1.easeIn"
					data-endspeed="300">
					<?php echo $msimgcont2;?>
				</div>

				<!-- LAYER -->
				<div class="tp-caption sft"
					data-x="center"
					data-hoffset="0"
					data-y="310"
					data-speed="1500"
					data-start="1000"
					data-easing="Power4.easeOut"
					data-endspeed="300"
					data-endeasing="Power1.easeIn"
					data-captionhidden="off"
					style="z-index: 6">
					<a href="<?php echo G5_SHIP_URL; ?>/introduce.php" class="btn-u btn-brd btn-brd-hover btn-u-light">선박보기</a>
					<a href="javascript:;" onclick="gotoBooking();" class="btn-u btn-brd btn-brd-hover btn-u-light">예약하기</a>
				</div>
			</li>
			<!-- END SLIDE -->
		</ul>
		<div class="tp-bannertimer tp-bottom"></div>
	</div>
</div>
<!--=== End Slider ===-->


<!-- Accounting System Section -->
<section class="g-bg-gray--light g-pt-90 g-pb-60">
	<div class="container lsh-toggle-fluid">
		<div class="text-center row">
			<div class="col-sm-4 col-xs-4 g-mb-30">
				<i class="icon-custom icon-lg rounded-x icon-color-default">1</i>
				<h3 class="g-mb-15 title-h3"><?php echo $txt1_title;?></h3>
				<p class="p-merit"><?php echo $txt1_cont;?></p>
			</div>
			<div class="col-sm-4 col-xs-4 g-mb-30">
				<i class="icon-custom icon-lg rounded-x icon-color-default">2</i>
				<h3 class="g-mb-15 title-h3"><?php echo $txt2_title;?></h3>
				<p class="p-merit"><?php echo $txt2_cont;?></p>
			</div>
			<div class="col-sm-4 col-xs-4 g-mb-30">
				<i class="icon-custom icon-lg rounded-x icon-color-default">3</i>
				<h3 class="g-mb-15 title-h3"><?php echo $txt3_title;?></h3>
				<p class="p-merit"><?php echo $txt3_cont;?></p>
			</div>
		</div>
	</div>
</section>
<!-- End Accounting System Section -->


<!-- Slick v2 -->
<div class="container lsh-toggle-fluid">
	<div class="headline"><h2>출조 갤러리</h2></div>
</div>
<div class="slick-v2 g-mb-50">
	<?php echo latest("gallery", "gallery", 6, 40); ?>
</div>
<!-- End Slick v2 -->

<!-- Calendar -->
<div class="container lsh-toggle-fluid divtide">
	<div class="headline" style="margin:0;"><h2>예약현황</h2></div>
</div>

<div class="container lsh-toggle-fluid wday-wrap" style="padding-top:25px;">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-xs-12">

			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover table-condensed">
					<?php echo get_week_day();?>
					<tbody>
						<?php for($i=0;$srow=sql_fetch_array($result_ship);$i++) {?>
						<?php
							// 등록어선명
							$sname = get_text($srow[s_name]);
							$s_idx = $srow[s_idx];
						?>
						<tr>
							<td><span class="ship-name-span"><?php echo $sname;?></span></td>
							<?php echo get_week_schedule($s_idx);?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

		</div>          
	</div>          
</div>          
<!-- End Calendar -->

<!-- Community -->
<div class="container lsh-toggle-fluid" style="padding-top:30px;">
	<div class="headline"><h2>커뮤니티</h2></div>
	<div class="row margin-bottom-20 lsh-row-gap-10">
		<div class="col-md-4 col-sm-4 col-xs-6 lsh-col-gap-5">
			<div class="posts">
				<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=notice"><h2>공지사항</h2></a></div>
				<!-- Latest Links -->
				<?php echo latest("notice", "notice", 6, 40); ?>
				<!-- End Latest Links -->
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-6 lsh-col-gap-5">
			<div class="posts">
				<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=qna"><h2>예약문의</h2></a></div>
				<!-- Latest Links -->
				<?php echo latest("free", "free", 6, 40); ?>
				<!-- End Latest Links -->
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 lsh-col-gap-5">
			<div class="posts" style="padding-bottom:8px;">
				<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=gallery"><h2>최근 조행기</h2></a></div>
				<!-- Latest Links -->
				<?php echo latest("mfish", "fishing", 5, 40); ?>
				<!-- End Latest Links -->
			</div>
		</div>
	</div>
</div>
<!-- End Community -->

<!-- Brands Section -->
<section class="brands-section g-pt-30 g-pb-90">
	<div class="container lsh-toggle-fluid">
		<div class="row brands-list">
			<a href="https://monak.kr" target="_blank">
				<div class="col-md-2 col-sm-4 col-xs-4 col-xxs-6 brand-item">
					<img src="<?php echo G5_URL;?>/assets/img/banners/ban01.jpg" alt="모두의낚시" class="img-responsive">
				</div>
			</a>
			<a href="http://blog.naver.com/modoofishing" target="_blank">
				<div class="col-md-2 col-sm-4 col-xs-4 col-xxs-6 brand-item">
					<img src="<?php echo G5_URL;?>/assets/img/banners/ban02.jpg" alt="" class="img-responsive">
				</div>
			</a>
			<a href="http://www.naksinuri.kr" target="_blank">
				<div class="col-md-2 col-sm-4 col-xs-4 col-xxs-6 brand-item">
					<img src="<?php echo G5_URL;?>/assets/img/banners/ban03.jpg" alt="" class="img-responsive">
				</div>
			</a>
			<a href="http://www.kma.go.kr" target="_blank">
				<div class="col-md-2 col-sm-4 col-xs-4 col-xxs-6 brand-item">
					<img src="<?php echo G5_URL;?>/assets/img/banners/ban04.jpg" alt="" class="img-responsive">
				</div>
			</a>
			<a href="http://www.badatime.com" target="_blank">
				<div class="col-md-2 col-sm-4 col-xs-4 col-xxs-6 brand-item">
					<img src="<?php echo G5_URL;?>/assets/img/banners/ban05.jpg" alt="" class="img-responsive">
				</div>
			</a>
			<a href="http://nakhome.kr" target="_blank">
				<div class="col-md-2 col-sm-4 col-xs-4 col-xxs-6 brand-item">
					<img src="<?php echo G5_URL;?>/assets/img/banners/ban06.jpg" alt="" class="img-responsive">
				</div>
			</a>
		</div>
	</div>
</section>
<!-- End Brands Section -->

<input type="hidden" id="s_idx" name="s_idx" value="<?php echo $first_s_idx; ?>">
<input type="hidden" id="sc_ymd" name="sc_ymd" value="<?php echo date("Ymd"); ?>">
<input type="hidden" id="bm" value="<?php echo $bm;?>">
<input type="hidden" id="by" value="<?php echo $by;?>">
<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->
<script>
var $table = $('.table');
var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');
$fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();

$(document).load($(window).bind("load resize", listenTable));
function listenTable(e) {

	$fixedColumn.find('tr').each(function (i, elem) {
		$(this).height($table.find('tr:eq(' + i + ')').height());
		$(this).width($table.find('tr:eq(' + i + ')').width());
	});
}
</script>
<!--페이지 스크립트 영역-->
