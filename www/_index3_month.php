<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" type="text/css" href="<?php echo G5_URL;?>/assets/plugins/calendar/css/cal.css" />
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css">
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/swiper/css/swiper.min.css">
<style>
h4.slick-v2-title {font-weight:bolder;}
.slick-v2-info{padding:0 8px;}
.slick-slide {background:#fff; outline: 1px solid #efefef;border-bottom:1px solid #efefef;}
p.slick-v2-text{height:80px;}

.posts{border:1px solid #ccc;padding: 0 15px;max-height:380px;}
.blog-trending li {border-bottom: 1px dotted #ddd;}
.latest-title{font-size:14px;font-weight:bolder;line-height:17px;}
.news-v3 p {margin-top: 8px;}

.title-h3 {color:#e04f67;font-weight:bolder;}

.headline {display: block;margin: 10px 0 25px;border-bottom: 1px dotted #e4e9f0;}
.headline h2 {margin: 0 0 -2px;padding-bottom: 5px;display: inline-block;border-bottom: 2px solid #72c02c;}

.swiper-container {width: 100%;height: 300px;margin:0 auto;}
.swiper-slide {background-size: cover;background-position: center;}
.gallery-top {height: 80%;width: 100%;}
.gallery-thumbs {height: 20%;box-sizing: border-box;padding: 10px 0 0;}
.gallery-thumbs .swiper-slide {height: 100%;opacity: 0.4;}
.gallery-thumbs .swiper-slide-active {opacity: 1;}

.cal-container {min-height:800px;}
.fc-calendar{right:15px;}
.custom-calendar-full {top: 0px;}
.brand-item{margin:0px;border:none;outline: solid 1px #d9d9d9;background-color: #fff;}
.ship-kind{font-size:13px;}

.custom-header h3 {}

.fc-calendar .fc-row > div > div span.datedata{white-space: normal;}
.fc-calendar .fc-row > div > div span{ font-size: 13px; display: block;padding: 0px 5px;line-height: 19px;}

.fc-calendar .fc-row > div.on{background:#f99292;color:#fff;}
.fc-calendar .fc-row > div.on span{background:#f99292;color:#fff;}
.fc-calendar .fc-row > div.on > div span.lunartide{background:#f99292;color:#fff;}
.fc-calendar .fc-row > div.fc-past{background:#efefef;}
.notavail{background:rgba(224, 224, 224, 0.5);display: inline-block;width: 100%;height: 100%;position: absolute;top: 0;left: 0;line-height: 68px;}

/*Scrollbar*/
.mCustomScrollBox{max-height:380px;height:290px;padding:0;}
.mCS-autoHide > .mCustomScrollBox > .mCSB_scrollTools, .mCS-autoHide > .mCustomScrollBox ~ .mCSB_scrollTools {opacity: 0.2;}
.mCSB_container{padding: 0;}
.mCSB_outside + .mCS-minimal-dark.mCSB_scrollTools_vertical{right:-15px;}

.service .desc h4 {font-size: 20px;line-height: 24px;font-weight:bolder;}
.thumbnail h3 a, .thumbnail-style h3 a {font-weight:bolder;}
.thumbnail-style p.thumb-p{line-height:18px;}

.p-greeting{font-weight:bolder;font-size:14px;}
.img-ceo{width:180px;}

@media (max-width: 1199px) {
	.latest-title{font-size:12px;}
	.news-v3 p {font-size:11px;line-height:15px;}
	.thumbnail h3 a, .thumbnail-style h3 a {font-size: 16px;}
	.thumbnail-style p.thumb-p{line-height:17px;}
}
@media (max-width: 991px) {
	.lsh-col-gap-5{padding:5px 5px;}
	.latest-title{font-size:12px;}
	.fc-calendar .fc-row > div > div span{ font-size: 12px; line-height: 16px;}
	.news-v3 p {font-size:11px;line-height:15px;}
	.title-h3 {font-size:18px;}
	.div-merit{padding:0 10px;}
	.p-merit{font-size:12px;}
	.thumbnail h3 a, .thumbnail-style h3 a {font-size: 15px;}
	.thumbnail-style p.thumb-p{font-size:12px;line-height:16px;}
	.img-ceo{width:150px;}
	.greeting span{font-size:12px;}
	blockquote p{font-size:12px;line-height:16px;}
	.swiper-container {width: 100%;height: 450px;margin:0 auto;}
	.header-fixed .header-v6.header-fixed-shrink{position: fixed;width: 750px;background: rgba(255,255,255,1);box-shadow:0px 1px 10px -3px rgba(0, 0, 0, 0.31);}
	.boxed-layout.header-fixed .header-v6.header-sticky{width: 750px;}
}
@media (max-width: 881px) {
	.cal-container {min-height:400px;}
	#calReturn{border:1px solid #ccc;}
	.fc-calendar {height: 350px;overflow-y: auto;	}
	.fc-calendar .fc-row > div {padding: 2px 10px;}
	.custom-header{border-bottom:4px solid #777;}
	.fc-calendar .fc-row > div > div{max-width: 100%; display: block; padding-left: 20%;}
	.fc-calendar .fc-row > div > span.fc-weekday{font-size: 11px;float: left;padding-top: 2px;padding-left:0px;}
	.ymdselect{font-size:12px;letter-spacing:0px;}
	.divtide{padding-bottom:24px;}
	.p-merit{font-size:11px;}
}

@media (max-width: 767px) {
	.title-h3 {font-size:18px;line-height: 16px;}
	.p-merit{font-size:11px;}
	.br-merit{display:none;}
	i.icon-lg {width: 50px;height: 50px;font-size: 26px;line-height: 50px;margin-bottom: 10px;}
	.thumbnail h3 a, .thumbnail-style h3 a {font-size: 14px;}
	.p-greeting{font-size:13px;}
	.swiper-container {width: 100%;height: 400px;margin:0 auto;}
	.boxed-layout.header-fixed .header-v6.header-sticky{position: relative;width: 100%;}
}
@media (max-width: 560px) {
	i.icon-lg {width: 40px;height: 40px;font-size: 20px;line-height: 40px;margin-bottom: 10px;}
}
@media (max-width: 479px) {
	.br-merit{display:inline;}
	.swiper-container {width: 100%;height: 350px;margin:0 auto;}
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
				data-y="230"
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
				data-speed="1600"
				data-start="2800"
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
				data-y="230"
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
				data-speed="1600"
				data-start="2800"
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
				data-y="230"
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
				data-speed="1600"
				data-start="2800"
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

<!--=== Purchase Block ===-->
<!--
<div class="purchase">
	<div class="container">
		<div class="headline"><h2>선장님 소개</h2></div>
		<div class="row">
			<div style="padding:0 5%;">
			<div class="col-md-9 animated fadeInLeft">
				<span>푸른 바다와 낚시의 즐거움이 배가 되는 곳</span>
				<p>안녕하십니까? 에코피싱호 홈페이지를 방문해 주신 여러분을 진심으로 환영합니다. 저희 에코피싱호는 수많은 조사님들과 함께하고 보다 나은 고객 서비스를 위해
				      최선을 다하겠습니다.  최신 설비를 갗준 에코피싱호에서는 여러분의 짜릿한 손맛과 레저 생활의 즐거움을 더해 드릴 것입니다.
					  늘 한결 간은 마음으로 고객여러분을 섬기는데 만전을 기하겠습니다.</p>
			</div>
			<div class="col-md-3 btn-buy animated fadeInRight">
				<img class="img-responsive" src="<?php echo G5_URL;?>/assets/img/lsh/mados.jpg" style="width:150px;border-radius:50%;" alt="" />
			</div>
			</div>
		</div>
	</div>
</div>
-->
<!--/row-->
<!-- End Purchase Block -->

<section class="g-bg-gray--light g-pt-70">
	<div class="container lsh-toggle-fluid">
		<div class="text-center row">
			<div class="col-sm-4 col-xs-4 g-mb-30 div-merit">
				<i class="icon-custom icon-lg rounded-x icon-color-default">1</i>
				<h3 class="g-mb-15 title-h3"><?php echo $txt1_title;?></h3>
				<p class="p-merit"><?php echo $txt1_cont;?></p>
			</div>
			<div class="col-sm-4 col-xs-4 g-mb-30 div-merit">
				<i class="icon-custom icon-lg rounded-x icon-color-default">2</i>
				<h3 class="g-mb-15 title-h3"><?php echo $txt2_title;?></h3>
				<p class="p-merit"><?php echo $txt2_cont;?></p>
			</div>
			<div class="col-sm-4 col-xs-4 g-mb-30 div-merit">
				<i class="icon-custom icon-lg rounded-x icon-color-default">3</i>
				<h3 class="g-mb-15 title-h3"><?php echo $txt3_title;?></h3>
				<p class="p-merit"><?php echo $txt3_cont;?></p>
			</div>
		</div>
	</div>
</section>

<!--=== Content Part ===-->
<div class="container content" style="padding-top:20px;padding-bottom:10px;">
	<!-- Recent Works -->
	<div class="headline"><h2>출조 갤러리</h2></div>
	<div class="row margin-bottom-20 lsh-row-gap-10">
		<?php echo latest("gallery3", "gallery", 4, 40); ?>
	</div>
	<!-- End Recent Works -->

	<!-- Info Blokcs -->
	<div class="row margin-bottom-30">
		<!-- Welcome Block -->
		<div class="col-md-8 md-margin-bottom-40">
			<div class="headline"><h2>Welcome To Monakho</h2></div>
			<div class="row">
				<div class="col-sm-4 col-xs-4" style="text-align:center;">
					<img class="img-responsive margin-bottom-20 img-ceo" src="<?php echo G5_URL;?>/assets/img/lsh/mados.jpg" style="border-radius:50%;display:inline-block;" alt="" />
				</div>
				<div class="col-sm-8 col-xs-8 greeting">
					<p class="p-greeting">안녕하십니까?<br><?php echo get_text($comfig['com_name'],1);?> 홈페이지를 방문해 주신 여러분을 진심으로 환영합니다. </p>
					<ul class="list-unstyled margin-bottom-20">
						<li><i class="fa fa-check color-green"></i> <span>빠르고 안전한 포인트 진입</span></li>
						<li><i class="fa fa-check color-green"></i> <span>30년 경력의 베테랑 선장</span></li>
						<li><i class="fa fa-check color-green"></i> <span>낚시대, 전동릴 대여품 완비</span></li>
						<li><i class="fa fa-check color-green"></i> <span>출조시 무료 회 떠드림</span></li>
					</ul>
				</div>
			</div>

			<blockquote class="hero-unify">
				<p><?php echo get_text($comfig['com_cont'],1);?></p>
				<small><?php echo get_text($comfig['com_name'],1);?></small>
			</blockquote>
		</div><!--/col-md-8-->

		<!-- Latest Shots -->
		<div class="col-md-4">
			<div class="headline"><h2>선박소개</h2></div>
			<!-- Swiper -->
			<div style="border:1px solid #dadada;">
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
		</div><!--/col-md-4-->
	</div>
	<!-- End Info Blokcs -->

	<!-- Community -->
	<div class="headline"><h2>에코피싱호 커뮤니티</h2></div>
	<div class="row margin-bottom-20 lsh-row-gap-10">
		<div class="col-md-4 col-sm-4 col-xs-6 lsh-col-gap-5">
			<div class="posts">
				<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $row[bo_table];?>"><h2>공지사항</h2></a></div>
				<!-- Latest Links -->
				<?php echo latest("notice", "notice", 6, 40); ?>
				<!-- End Latest Links -->
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-6 lsh-col-gap-5">
			<div class="posts">
				<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $row[bo_table];?>"><h2>예약문의</h2></a></div>
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
<!-- End Community -->
</div><!--/container-->
<!-- End Content Part -->

<!-- Calendar -->
<div class="container lsh-toggle-fluid divtide">
	<div class="headline" style="margin:0;"><h2>물때 및 예약현황</h2></div>
</div>
<div class="container lsh-toggle-fluid cal-container">
	<div class="row">
		<div id="calReturn">

			<div class="custom-calendar-wrap custom-calendar-full">
				<div class="custom-header clearfix">
					<h3 class="custom-month-year">
						<div style="float:left;">
							<select class="ship-kind" style="height:32px;border:1px solid #ccc;">
								<?php echo $shipSelect;?>
							</select>
						</div>
						<div class="ymdselect" style="float:right;">
							<span id="custom-year" class="custom-year"></span>년
							<span id="custom-month" class="custom-month"></span>
							<nav>
								<span id="custom-prev" class="custom-prev"></span>
								<span id="custom-next" class="custom-next"></span>
								<span id="custom-current" class="custom-current" title="Go to current date"></span>
							</nav>
						</div>
					</h3>
				</div>
				<div id="calendar" class="fc-calendar-container"></div>
			</div>
		</div>
	</div>
</div>
<!-- End Calendar -->

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
<?php include_once(G5_SHIP_PATH.'/jsdata.php');?>
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
</script>
<script type="text/javascript" src="<?php echo G5_URL;?>/assets/plugins/calendar/js/jquery.calendario.js"></script>
<script>
var cal = $('#calendar').calendario({
	onDayClick : function( $el, $contentEl, dateProperties ) {
		// 날짜가공('0'붙임)
		if(dateProperties["month"] < 10) dateProperties["month"] ="0"+dateProperties["month"];
		if(dateProperties["day"] < 10) dateProperties["day"] ="0"+dateProperties["day"];
		// 이동할 년월일
		var gotodate = "";
		gotodate += dateProperties["year"];
		gotodate += dateProperties["month"];
		gotodate += dateProperties["day"];

		document.location.href=g5_url+"/ship/booking.php?ymd="+gotodate;
	},
	caldata : codropsEvents
}),
$month = $( '#custom-month' ).html(""),
$year = $( '#custom-year' ).html("");

// 다음달로 이동 - 이동날짜와 어선키값을 통해 해당어선의 해당년월 예약가능인원 불러옴.
$( '#custom-next' ).on( 'click', function() {
	var y = cal.getYear();
	var m = cal.getMonth();
	if(m<10) m="0"+m;
	var m_oMonth= new Date(y, m, 0)
	m_oMonth.setDate(1);
	m_oMonth.setMonth(m_oMonth.getMonth() + 1);

	var yearGet = m_oMonth.getFullYear(); //년을 구한다
	var monthGet = m_oMonth.getMonth()+1; //월을 구한다.
	if(monthGet<10) monthGet="0"+monthGet;

	// 어선키값을 통해 해당 어선 예약가능인원 추출
	var sidx = $("#s_idx").val();
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_jsdata.php",
		data: "cy="+yearGet+"&cm="+monthGet+"&s_idx="+sidx, 
		beforeSend: function(){
			//loadstart();
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
				cal.gotoNextMonth( updateMonthYear );
				cal.setData(msgarray.data_arr);
				$("#s_idx").val(sidx);
				$("#by").val(yearGet);
				$("#bm").val(monthGet);
			}
		},
		complete: function(){
			loadend();
		}
	});
});

// 이전달로 이동 - 이동날짜와 어선키값을 통해 해당어선의 해당년월 예약가능인원 불러옴.
$( '#custom-prev' ).on( 'click', function() {
	var y = cal.getYear();
	var m = cal.getMonth();
	if(m<10) m="0"+m;
	var m_oMonth= new Date(y, m, 0)
	m_oMonth.setDate(1);
	m_oMonth.setMonth(m_oMonth.getMonth() - 1);

	var yearGet = m_oMonth.getFullYear(); //년을 구한다
	var monthGet = m_oMonth.getMonth()+1; //월을 구한다.
	if(monthGet<10) monthGet="0"+monthGet;

	var sidx = $("#s_idx").val();
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_jsdata.php",
		data: "cy="+yearGet+"&cm="+monthGet+"&s_idx="+sidx, 
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
				cal.gotoPreviousMonth( updateMonthYear );
				cal.setData(msgarray.data_arr);
				$("#s_idx").val(sidx);
				$("#by").val(yearGet);
				$("#bm").val(monthGet);
			}
		},
		complete: function(){
			loadend();
		}
	});
});

// 현재달로 이동 - 이동날짜와 어선키값을 통해 해당어선의 해당년월 예약가능인원 불러옴.
$( '#custom-current' ).on( 'click', function() {
	var yearGet = "<?php echo date('Y');?>";
	var monthGet = "<?php echo date('m');?>";

	var sidx = $("#s_idx").val();
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_jsdata.php",
		data: "cy="+yearGet+"&cm="+monthGet+"&s_idx="+sidx,
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
				cal.gotoNow( updateMonthYear );
				cal.setData(msgarray.data_arr);

				$("#s_idx").val(sidx);
				$("#by").val(yearGet);
				$("#bm").val(monthGet);
			}
		},
		complete: function(){
			loadend();
		}
	});
});

// 달력재가공 업데이트
function updateMonthYear() {				
	$month.html( cal.getMonthName() );
	$year.html( cal.getYear() );
}

$(document).ready(function(){
	// 달력초기화
	var bmonth = $("#bm").val();
	var byear = $("#by").val();
	var sidx = $("#s_idx").val();

	if(bmonth !="" && byear !="")
	{
		var yearGet = byear; //년을 구한다
		var monthGet = parseInt(bmonth); //월을 구한다.
		if(monthGet<10) monthGet="0"+monthGet;

		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata.php",
			data: "s_idx="+sidx+"&cy="+yearGet+"&cm="+monthGet, 
			beforeSend: function(){
				loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);
				cal.gotoMonth( monthGet,yearGet,updateMonthYear );
				cal.setData(msgarray.data_arr);
			},
			complete: function(){
				loadend();
			}
		});
	}
	else
	{
		$month = $( '#custom-month' ).html( cal.getMonthName() ),
		$year = $( '#custom-year' ).html( cal.getYear() );
	}

	// 어선선택시 데이터 가져옴
	$(document).off("change",".ship-kind").on("change",".ship-kind",function(e){
		var sidx = $.trim($(this).val());
		var scy = $("#by").val();
		var scm = $("#bm").val();

		if(!sidx || sidx == "") {alert("어선키값 오류입니다."); return false;}
		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata.php",
			data: "s_idx="+sidx+"&cy="+scy+"&cm="+scm, 
			beforeSend: function(){
				loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);
				cal.gotoMonth(scm,scy,updateMonthYear);
				cal.setData(msgarray.data_arr);

				$("#s_idx").val(sidx);
				$("#by").val(scy);
				$("#bm").val(scm);
			},
			complete: function(){
				loadend();
			}
		});
	});

	initSwiper();
});
</script>
<!--페이지 스크립트 영역-->

