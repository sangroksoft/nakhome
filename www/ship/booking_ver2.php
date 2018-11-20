<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/css/swiper.min.css">
<style>
.interactive-slider-v2 {height: 470px;}
.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}
.notespan{font-size: 1.3em;display: inline-block;border-bottom: 1px dotted #333;padding: 3px 6px;margin-bottom: 10px;}
.lsh-td1 .input-group p{margin-bottom: 6px;}
.txtcont{line-height:24px;}

.table-bordered > tbody > tr > td {border: 1px solid #a0a0a0;}
.table-bordered > tbody > tr > td.bd-btm {border-bottom:2px solid #777;}
.table-responsive > .table > tbody > tr > td.td-day {width:120px;min-width:70px;text-align:center;}
.table-responsive > .table > tbody > tr > td.td-ship {width:200px;min-width:80px;height:1px;}
.table-responsive > .table > tbody > tr > td.td-ship .div-ship-bk {display:table;position:relative;width:100%;height:100%;}
.table-responsive > .table > tbody > tr > td.td-bkcont {min-width:290px;}
.table-responsive > .table > tbody > tr > td.td-off{background:#efefef;}

#calWrap{position:relative;}
.vdiv{height:118px;}
#mini_calendar.cal-po-rel{position:absolute;width:100%;top: 0px;left:0px;background: #fff;box-shadow: none;}
#mini_calendar.cal-po-fix{position:fixed;top: 90px;left:inherit;width:inherit;height:auto;background: #fff;box-shadow: none;z-index:1000;}
#mini_calendar .cal-cont{border-top: 2px solid #999;border-bottom: 2px solid #999;margin-left:-15px;margin-right:-15px;}
#top3{padding-bottom:0px;}
#top3.pbon{padding-bottom:0px;}

.mini-calendar {margin-bottom:20px;}
.ym-wrap-h3 {text-align:center;}

.swiper-slide{display: table;border:1px solid #ccc;border-right:none;text-align:center;height: 50px;cursor:pointer;}
.swiper-slide:first-child{border-left:none;}
.swiper-slide:last-child{border-right:none;}
.swiper-slide.active{background: #7989ff;color: #ffffff;font-weight: bolder;}

.day-wt-wrap {display: table-cell;width:100%;vertical-align: middle;}
.day-wt-wrap .day-name {display:block;text-align:center;vertical-align:middle; border-bottom: 1px dotted #d9d9d9;}
.day-wt-wrap .day-name.span-sunday {color:red;}
.day-wt-wrap .day-name.span-saturday {color:blue;}
.day-wt-wrap .wt-name {display:block;text-align:center;vertical-align:middle;}
.day-wt-wrap .wt-name.span-sunday {color:red;}
.day-wt-wrap .wt-name.span-saturday {color:blue;}
.swiper-slide.active .span-sunday{color: #ffffff;}
.swiper-slide.active .span-saturday{color: #ffffff;}


.daily-ship-title {font-weight:bolder;}
.daily-ship-theme {font-weight:bolder;}
.daily-ship-notice {}
.daily-ship-bkok {color:blue;font-weight:bolder;}
.daily-ship-bkwait {color:green;font-weight:bolder;}
.daily-ship-avail {color:red;font-weight:bolder;}
.availcnt.off{opacity:0;}

.bkok-div {border-top: 1px dotted #ccc;border-bottom: 1px dotted #ccc;margin-bottom: 5px;}
.bkok-div span{font-weight:bolder;color:blue;}
.bkwait-div {border-top: 1px dotted #ccc;border-bottom: 1px dotted #ccc;margin-bottom: 5px;}
.bkwait-div span{font-weight:bolder;color:gray;}
.mb-bkok {display: inline-block;background: #74abff;padding: 0px 5px;border-radius: 30px;color: #fff;margin:2px;}
.mb-bkwait {display: inline-block;background: #bdbdbd;padding: 0px 5px;border-radius: 30px;color: #fff;margin:2px;}

.d-flex{padding-bottom: 10px;text-align: center;}
.d-flex .ship-name{font-weight:bolder;}
span.bk-status {display:block;border:1px solid #ccc; padding:3px;}
span.bk-status.ok {color:blue;}
span.bk-status.end {color:gray;}

.daywd {font-weight:bolder;}
.bk_btn {position: absolute;bottom: 5px;left: 0;width: 100%;text-align: center;}
.bk_btn a{display:inline-block;background: #ff7272;border: none;padding: 5px;color: #ffffff;}
.bk_btn button{background: #ff7272;border:none;padding: 5px;color: #ffffff;}

.bd-btm {border-bottom:2px solid #777;}

@media (max-width:1199px){
	.table-responsive > .table > tbody > tr > td.td-day {width:100px;}
	.table-responsive > .table > tbody > tr > td.td-ship {width:170px;}
}
@media (max-width:991px){
	.table-responsive > .table > tbody > tr > td.td-day {width:90px;}
	.table-responsive > .table > tbody > tr > td.td-ship {width:150px;}

	#calWrap{min-height:50000px;}
	.txtcont{font-size:12px; line-height:20px;}

	#mini_calendar.cal-po-fix{position:fixed;top: 0px;}
	.swiper-slide{font-size:12px;}
}
@media (max-width:767px){
	.table-responsive > .table > tbody > tr > td.td-day {width:auto;}
	.table-responsive > .table > tbody > tr > td.td-ship {width:auto;}
	#calWrap{min-height:50000px;}
	.interactive-slider-v2 {height: 360px;}
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:12px;}

	.table-responsive > .table > tbody > tr > td {white-space: normal;}
	#mini_calendar.cal-po-fix { width: 100%;left:0px;}
	#mini_calendar .cal-cont{margin-left:auto;margin-right:auto;padding-left: 0;padding-right: 0;}

	.swiper-slide{font-size:11px;}
}
@media (max-width:479px){
	#calWrap{min-height:50000px;}
	.interactive-slider-v2 {height: 250px;}
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:11px;}
	.txtcont{font-size:11px; line-height:18px;}

}
</style>

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v5">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">예약하기</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->


<div class="container lsh-toggle-fluid">
    <div class="row">
        <div class="col-xs-12"">

			<div class="shortcode-html"> <!--Basic Table-->
	        
				<div id="top3" class="bk-guide">
					<div class="margin-bottom-20">
						<h2 class="pg-title">예약안내</h2>
					</div>
					<div class="table-title"><span class="item-fa"><i class="fa fa-pencil-square-o"></span></i><h3 class="item-title">예약필독사항</h3></div>
					<table class="table table-bordered">
						<tbody>
							<tr>
								<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
									<label for="ca_name" class="lsh-label">단체예약</label>
								</th>
								<td class="lsh-td1">
									<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 단체예약</span></div>
									<div class="input-group lsh-form-nopadding txtcont">
										<?php echo get_text($comfig['book_group'],1); ?>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
									<label for="ca_name" class="lsh-label">단체이용료</label>
								</th>
								<td class="lsh-td1">
									<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 단체이용료</span></div>
									<div class="input-group lsh-form-nopadding txtcont">
										<?php echo get_text($comfig['book_group_fee'],1); ?>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
									<label for="ca_name" class="lsh-label">독선예약</label>
								</th>
								<td class="lsh-td1">
									<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 독선예약</span></div>
									<div class="input-group lsh-form-nopadding txtcont">
										<?php echo get_text($comfig['book_solo'],1); ?>
									</div>
								</td>
							</tr>
							<tr>
								<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
									<label for="ca_name" class="lsh-label">독선이용료</label>
								</th>
								<td class="lsh-td1">
									<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 독선이용료</span></div>
									<div class="input-group lsh-form-nopadding txtcont">
										<?php echo get_text($comfig['book_solo_fee'],1); ?>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div id="calWrap">
					<div class="vdiv"></div>
				</div> 


			</div> 
		</div> 
	</div> 
</div> 

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script>
<script>
    // 스와이퍼 초기화
    function initSwiper(idx) {
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 15,
            spaceBetween: 0,
			freeMode:true,
			freeModeMomentum:true,
			onTouchStart: function (s) { s.setWrapperTransition(0); s.setWrapperTranslate(s.getWrapperTranslate());},
            breakpoints: {
                380: { slidesPerView: 5 },
                480: { slidesPerView: 7 },
				640: { slidesPerView: 9 },
                767: { slidesPerView: 11 },
                991: { slidesPerView: 13 },
                1279: { slidesPerView: 15 }
            },
			on: {
				init: function () {
					var slideIdx = parseInt(idx);
					if(slideIdx > -1 && slideIdx !="") {
						initMove(this, slideIdx);
					} else {
						initMove(this, slideIdx);
					}
				},
			},
        });
    }
	function initMove(sw,idx) {
		sw.slideTo(idx,400,"");
		$(".swiper-slide").removeClass("active");
		$("#slide_"+idx).addClass("active");
	}
    // 스크롤 초기화
	function initScroll() {
		$(window).scroll(setPosition);
	}
    // 쿠키 초기화
	function initCookie(ymd,fymd) {
		Cookies.remove('bkymd');
		Cookies.remove('fymd');
		Cookies.set('bkymd', ymd);
		Cookies.set('fymd', fymd);
	}
    // 미니칼렌더 css포지션설정
	function setPosition() {
		var headerHeight = "";
		if($("#divwrap").outerWidth() < 991) headerHeight = 0;
		else headerHeight = $(".header-v6").height();

		var eloffset = $(".vdiv").offset();
		var eloffsettop = eloffset.top-headerHeight;

		if($(window).scrollTop()>eloffsettop)	{
			$("#mini_calendar").removeClass("cal-po-rel");
			$("#mini_calendar").addClass("cal-po-fix");
			$("#top3").addClass("pbon");

			var scrollBottom = $("body").height() - $(window).height() - $(window).scrollTop(); //스크롤바텀값
			var footerHeight = $(".footer").height()-350;
			if(scrollBottom < footerHeight) {
				$("#mini_calendar").removeClass("cal-po-fix");
				$("#mini_calendar").addClass("cal-po-rel");
			}
		} else	{
			$("#mini_calendar").removeClass("cal-po-fix");
			$("#mini_calendar").addClass("cal-po-rel");
			$("#top3").removeClass("pbon");
		}
	}
    // 엘리먼트로 이동 animation
	function gotoElement(fymd){
		var headerHeight = "";
		var calendarHeight = $("#mini_calendar").height();
		var topVal = "";

		if($("#divwrap").outerWidth() < 991) headerHeight = 0;
		else headerHeight = $(".header-v6").height();
		
		topVal = headerHeight+calendarHeight + 5; // 포커스 상단에 약간의 여유를 주기위해 5 추가함.
		$('html, body').stop().animate({
			scrollTop: $(fymd).offset().top-topVal
		}, 400, function(){
			//window.location.hash = hash;
		});
	}
    // 월간 스케쥴 가져오기
	function get_monthly_schedule(ymd,fymd,cinit,isload){
		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_get_bk_diary.php",
			data: "ymd="+ymd+"&fymd="+fymd, 
			beforeSend: function(){
				loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);
				if(msgarray.rslt == "error")	{
					alert(msgarray.errcode); 
					if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
					else {	loadend(); return false;}
				} else {
					$("#calWrap").html(msgarray.cont);
					var tblbkHeight = $('.table-bk').outerHeight()+"px";
					$('#calWrap').css("min-height", tblbkHeight);   
				}
			},
			complete: function(msg2) {
				var msgarray2 = $.parseJSON(msg2.responseText);
				initSwiper(msgarray2.slideidx);
				setPosition();

				if(msgarray2.rslt=="ok") {
					if(cinit) {
						initCookie(msgarray2.ymd,msgarray2.fymd);
					}
					if(!isload || isload=="") {
						gotoElement("#tr_"+msgarray2.fymd);
					}
				}
				Cookies.remove('isload');
				loadend();
				$('#calWrap').css("min-height", "auto");   
			}
		});
	}
    // 날짜클릭시
	$(document).off("click",".swiper-slide").on("click",".swiper-slide", function(event) {
		event.preventDefault();

		$(".swiper-slide").removeClass("active");
		$(this).addClass("active");

		var hash = $(this).data("hash");
		if(!hash || hash=="") {
			return false;
		} else {
			var ymd = $(this).data("ymd");
			var fymd = $(this).data("fymd");
			initCookie(ymd,fymd);
			gotoElement(hash);
		}
	});
	// 월 이동시
	$(document).off("click",".cal-arrow").on("click",".cal-arrow",function(e){
		var ymd = $(this).data("ymd");
		var fymd = $(this).data("fymd");
		get_monthly_schedule(ymd,fymd,1,"");
	});
	// 예약버튼클릭시
	$(document).off("click",".btn-bk-link").on("click",".btn-bk-link",function(e){
		var sidx = $(this).data("sidx");
		var ymd = $(this).data("ymd");
		var fymd = $(this).data("fymd");

		initCookie(ymd,fymd);
		document.location.href="./bk_process.php?sidx="+sidx+"&ymd="+ymd;
	});
	// 예약가능인원 깜빡임
	function blinker() {
		if($('.availcnt').hasClass("off")) {
			$('.availcnt').removeClass("off");
		} else {
			$('.availcnt').addClass("off");
		}
	}

	$(document).ready(function(){
		var isload = Cookies.get('isload');
		if(!isload || isload=="" || isload==false || isload=="undefined") isload = "";

		var ymdhist = Cookies.get('bkymd');
		var fymdhist = Cookies.get('fymd');
		if(!fymdhist || fymdhist=="" || fymdhist==false || fymdhist=="undefined") fymdhist = "";

		if(ymdhist) {
			get_monthly_schedule(ymdhist,fymdhist,"",isload);
		} else {
			get_monthly_schedule("","","",isload);
		}

        initSwiper();
		initScroll();
		setInterval(blinker, 600);

		var resizeTimer;
		$(window).on('resize', function(e) {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(setPosition, 0);
		});
    });
</script>

<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->
