<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//===================== 달력정보가져옴 ========================
$ymd = trim($_REQUEST[ymd]);
$ymd = (int)preg_replace('/[^0-9]/', '', $ymd);
if(!$ymd || $ymd < 20000101 || $ymd > 20501231) $ymd = "";

//날짜자리수체크
if (strlen($ymd) != 8) $ymd = "";

if($ymd=="") $ymd=date(Ymd);
// 개별날짜 추출
$by = substr($ymd,0,4);
$bm = substr($ymd,4,2);
$bd = substr($ymd,6,2);
//===================== 달력정보가져옴 ========================

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
			
			$svcdivstr .= '<div class="col-xxs-6 col-xs-4 col-sm-4">';
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
	$ships .= "<li class='ship-li'><span id='shipLi_".$srow[s_idx]."' class='ship-name".$is_selected."' data-sidx='".$srow[s_idx]."'>".get_text($srow[s_name])."</span></li>";

	// 셀렉트박스
	$shipSelect .= "<option value='".$srow[s_idx]."'>".get_text($srow[s_name])."</option>";
}
//===================== 어선정보가져옴 ========================
include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" type="text/css" href="<?php echo G5_URL;?>/assets/plugins/calendar/css/cal2.css" />
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/swiper/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css">

<!-- Demo styles -->
<style>
.fc-calendar .fc-row > div.on{background:#f99292;color:#fff;}
.fc-calendar .fc-row > div.on span{background:#f99292;color:#fff;}
.fc-calendar .fc-row > div > div span.lunartide {color:#333;}
.fc-calendar .fc-row > div.on > div span.lunartide{background:#f99292;color:#fff;}
.fc-calendar .fc-row > div.fc-past{background:#efefef;}
.notavail{background:rgba(224, 224, 224, 0.5);display: inline-block;width: 100%;height: 100%;position: absolute;top: 0;left: 0;line-height: 68px;}

.interactive-slider-v2 {height: 470px;}
.table > tbody > tr > td.no-border{border-top:none;border-bottom:none;border-left:none;border-right:none;padding:4px 0;}
.swiper-container {width: 100%;height: 350px;margin:0 auto;}
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
.input-group {margin:5px 0;}
.input-lsh{height: 34px;width: 100%;border: 1px solid #dadada;border-radius:20px;padding: 6px 12px;outline: none !important;}
.txtarea-lsh{width: 100%;border: 1px solid #dadada;border-radius:10px;padding: 6px 12px;outline: none !important;}
.ship-kind{float:right;max-width:250px;margin-top: 5px;height: 34px;border: 1px solid #dadada;border-radius: 10px;outline: none !important;}
.book-title{width:25%;}
.book-input{width:75%;}
.book-title2{width:20%;}
.book-input2{width:30%;}
.book-title i{font-size: 30px;line-height: 30px;float: left;height: 30px;color: #61e05a;}
.book-title span{font-size: 14px;height: 30px;line-height: 30px;display: inline-block;padding-top: 2px;padding-left: 10px;}
.book-title-row {padding-bottom:10px;}
#book_theme{font-weight:bolder;display:inline-block;height:34px;padding-top: 8px;}
#book_members{display:inline-block;height:34px;padding-top: 8px;}

/*Scrollbar*/
<?php if($comfig[usebooking]=="0") {?>
.mCustomScrollBox{height:950px;padding:0 15px;border: 1px solid #dadada;}
<?php } else if($comfig[usebooking]=="1") {?>
.mCustomScrollBox{height:550px;padding:0 15px;border: 1px solid #dadada;}
<?php } ?> 
.mCS-autoHide > .mCustomScrollBox > .mCSB_scrollTools, .mCS-autoHide > .mCustomScrollBox ~ .mCSB_scrollTools {opacity: 0.2;}
.mCSB_container{padding: 15px 0;}

.btn-u{width: 320px;border-radius: 20px;height: 40px;font-size: 16px;background:#f99292;}
.headline-center-v2{padding-top:30px;}
.headline-center-v2 span.bordered-icon{margin-bottom:15px;}
ul.book-result{margin:0;padding:0;list-style:none;}
ul.book-result li.ready{color:red;font-weight:bolder;padding-top: 6px;}

span.ship-detail, span.ship-hide{position: absolute;right: 15px;border: 1px solid #dadada;padding: 4px 6px;cursor:pointer;}
div#ship_detail{display:none;padding-bottom:10px;}

.lists-v1 li {margin-bottom: 2px;}
.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}
.notespan{font-size: 1.3em;display: inline-block;border-bottom: 1px dotted #333;padding: 3px 6px;margin-bottom: 10px;}
.lsh-td1 .input-group p{margin-bottom: 6px;}
.ship-desc{padding-top:20px;}
.ship-desc div{padding:0px;}
.ship-desc label{font-weight:normal;margin-bottom:0px;}

.fcstWrap{height:40px;margin-bottom: 3px;border-bottom: 1px dotted #f99292;border-top: 1px dotted #f99292;padding: 0;color: #f99292;font-size: 11px;}
.fcstWrap2{height:40px;margin-bottom: 6px;border-bottom: 1px dotted #f99292;border-top: 1px dotted #f99292;padding: 0;color: #f99292;font-size: 11px;}
.fcstdb{float: left;width:15%;height:40px;border-right:1px dotted #f99292;line-height: 40px;text-align: center;font-size:11px;font-weight:bolder;}
.fcstdata{width:84%;float: right;height: 40px;padding: 3px;}
.fcstdata .fcst{clear:both;}
.txtcont{line-height:24px;}
.dayinfo{display:none;position: absolute;width: 250px;height: 150px;top: 25px;right: 15px;border: 1px solid #d4d4d4;background: #ffffff;z-index: 9999;padding: 10px;border-radius: 10px;}
.txt-bold{display:inline-block;width:10%;font-weight:bolder;}
.txt-fcst{display:inline-block;width:30%;}

.availcnt {position: absolute;color:blue;font-weight:bolder;}
.availcnt.off {display:none;}
.availtxt {position: absolute;color:blue;font-weight:bolder;}
.availtxt.off {display:none;}

.scend {color:red;}
.guide-wrap{height: 550px;border: 1px solid #d9d9d9;text-align: center;padding: 30% 0;}

#book_theme{font-weight:bolder;display:inline-block;height:34px;padding-top: 8px;}
#book_members{display:inline-block;height:34px;padding-top: 8px;}

#overbookinNoti{display:none;color:red;}
#overbookinNoti.show{display:inline-block;}

@media (max-width: 991px) {
	.swiper-container {height: 320px;}
	.book-title{display:none;}
	.book-input{width:100%;font-size:11px;}
	.book-title span {font-size: 12px;padding-left: 5px;}
	.lsh-td1 .input-group p{margin-bottom: 6px;font-size:11px;}
	.ship-desc{font-size:11px;}
	.txtcont{font-size:12px; line-height:20px;}
	.fc-calendar .fc-row > div > div span.lunartide {font-size: 9px;}
	.fc-calendar .fc-row > div > div a, .fc-calendar .fc-row > div > div span {font-size: 10px;}

	.ship-kind{max-width:180px;}
}
@media (max-width: 850px) {
	.swiper-container {height: 320px;}
}
@media (max-width: 767px) {
	.swiper-container {height: 480px;}
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:12px;}
	.book-title{display:block;}
	.book-input{width:75%;}
	.book-input{font-size:11px;}
	.ship-desc{font-size:11px;}
	.guide-wrap{height: 400px;padding: 15% 0;}
	.fc-calendar .fc-row > div > div a, .fc-calendar .fc-row > div > div span {font-size: 11px;}

	.ship-kind{max-width:250px;}
}
@media (max-width: 560px) {
	.swiper-container {height: 380px;}
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:12px;}
	.book-title{display:block;}
	.book-input{width:75%;}
	.book-input{font-size:11px;}
	.ship-desc{font-size:11px;}
	.fc-calendar .fc-row > div > div a, .fc-calendar .fc-row > div > div span {font-size: 10px;}

	.ship-kind{max-width:180px;}
}
@media (max-width: 479px) {
	.swiper-container {height: 320px;}
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:11px;}
	.book-title{display:none;}
	.book-input{width:100%;}
	.fc-calendar .fc-row > div > div span.lunartide {top: 0px;right: 2px;}
	
	.ship-kind{width:80px;}
	.btn-u {width: 260px;}
	.txtcont{font-size:11px; line-height:18px;}
}
@media (max-width: 340px) {	
	.fc-calendar .fc-row > div{padding:2px;padding-top:8px;}
}

</style>

<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v5">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">예약하기</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<div class="lsh-toggle-fluid cal-container container" style="min-height:800px;padding-bottom:50px;">
	<div class="row">

		<div id="booknotice" class="col-sm-6">

			<div class="row">
				<div class="col-xxs-12">
					<div class="row">
						<div class="col-xxs-12">
							<div class="headline-center-v2 headline-center-v2-dark">
								<h2 style="margin:0;font-size:23px; font-weight:900;">예약필독사항</h2>
								<span class="bordered-icon"><i class="fa fa-th-large"></i></span>
							</div>
						</div>
					</div>
					<div id="scrollbar" class="panel-body no-padding mCustomScrollbar" data-mcs-theme="minimal-dark">
						<div class="table-title"><span class="item-fa"><i class="fa fa-anchor"></span></i><h3 class="item-title">입출항 시간</h3></div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 출항</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['out_time'],1); ?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 입항</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['in_time'],1); ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

						<div class="table-title"><span class="item-fa"><i class="fa fa-pencil-square-o"></span></i><h3 class="item-title">단체 및 독선 예약</h3></div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 단체예약</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['book_group'],1); ?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 단체이용료</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['book_group_fee'],1); ?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 독선예약</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['book_solo'],1); ?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 독선이용료</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['book_solo_fee'],1); ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

						<div class="table-title"><span class="item-fa"><i class="fa fa-tags"></span></i><h3 class="item-title">예약 및 환불안내</h3></div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 예약처리절차</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['book_process'],1); ?>
										</div>
									</td>
								</tr>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 환불</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['refund_process'],1); ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>

						<div class="table-title"><span class="item-fa"><i class="fa fa-info-circle"></span></i><h3 class="item-title">기타 유의사항</h3></div>
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="lsh-td1">
										<div class="note"><span class="notespan"><i class="fa fa-check"></i> 기타 유의사항</span></div>
										<div class="input-group lsh-form-nopadding txtcont">
											<?php echo get_text($comfig['etc_notice'],1); ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Calendar -->
		<div id="bookform" class="col-sm-6">
			<?php if($comfig[usebooking] == "0") {?>
			<form name="fbook" id="fbook"  class="sky-form" onsubmit="return fbook_submit(this);" method="post" autocomplete="off" >
			<input type="hidden" name="w" value="">
			<input type="hidden" id="s_idx" name="s_idx" value="<?php echo $first_s_idx; ?>">
			<input type="hidden" id="sc_ymd" name="sc_ymd" value="">
			<input type="hidden" id="sc_price" name="sc_price" value="">
			<input type="hidden" id="bm" value="<?php echo $bm;?>">
			<input type="hidden" id="by" value="<?php echo $by;?>">
			<div class="row">
				<div class="col-xxs-12">
					<div class="headline-center-v2 headline-center-v2-dark">
						<h2 style="margin:0;font-size:23px; font-weight:900;">출조 예약</h2>
						<span class="bordered-icon"><i class="fa fa-th-large"></i></span>
					</div>
				</div>
			</div>

			<div class="custom-calendar-wrap custom-calendar-full">
				<div class="custom-header clearfix">
					<h3 class="custom-month-year">
						<span id="custom-prev" class="prev-month cal-arrow" style="padding-right:10px;"><img src="<?php echo G5_IMG_URL;?>/back2.png"></span>
						<span id="custom-year" class="custom-year"></span>년
						<span id="custom-month" class="custom-month"></span>
						<span id="custom-next" class="next-month cal-arrow" style="padding-left:10px;"><img src="<?php echo G5_IMG_URL;?>/next2.png"></span>
						<span id="custom-current" class="custom-current" title="Go to current date"></span>
					</h3>
					<select id="ship_selectbox" class="ship-kind">
						<?php echo $shipSelect;?>
					</select>
				</div>
				<div id="calendar" class="fc-calendar-container"></div>
			</div>
			
			<hr style="margin:20px 0;">
			<div id="shipSelect" class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>어선선택</span>
				</div>
				<div class="col-xxs-9 book-input" style="position:relative;">
					<ul id="rtn_ships" style="margin:0;padding:0;">
						<?php echo $ships;?>
					</ul>
					<span class="ship-detail">자세히</span>
				</div>
			</div>          

			<div id="ship_detail" class="row">
				<!-- Swiper -->
				<div class="col-xxs-12">
					<div id="shipImgsWrap" class="col-xxs-12" style="padding:10px;border:1px solid #dadada;">
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

						<div id="shipsvc" class="ship-desc">
							<?php echo $svcdivstr; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>예약현황</span>
				</div>
				<div class="col-xxs-9 book-input">
				<span id="book_members">
					<span style="color:red;font-weight:bolder;">
						※ 예약일자를 선택해 주세요.
					</span>
					<!--
					<div id="sc_members">
						<ul class="list-unstyled lists-v1">
							<li><i class="fa fa-angle-right"></i>예약접수(입금대기) : 30명</li>
							<li><i class="fa fa-angle-right"></i>예약완료(입금완료) : 연안부두</li>
						</ul>
					</div>
					-->
				</span>			
				</div>
			</div>

			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>예약일자</span>
				</div>
				<div class="col-xxs-9 book-input">
					<span id="book_theme">
						<span style="color:red;">
							※ 예약일자를 선택해 주세요.
						</span>
					</span>
					<div id="sc_cont">
					</div>
				</div>
			</div>          
			

			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>출조인원</span>
				</div>
				<div class="col-xxs-9 book-input">
					<select id="rtn_selbox" name="bk_member_cnt" class="input-lsh required" required="required" onchange="showResult(this.value);" >
						<option value="">인원선택</option>
					</select>
				</div>
			</div>          
			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>입금자명</span>
				</div>
				<div class="col-xxs-9 book-input">
					<input type="text" name="bk_banker" id="bk_banker" maxlength="20" class="frm_input required input-lsh" placeholder="입금자명" required />
				</div>
			</div>          

			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>연락처</span>
				</div>
				<div class="col-xxs-9 book-input">
					<input type="text" name="bk_tel" id="bk_tel" maxlength="20" class="frm_input required input-lsh" placeholder="연락처" required />
				</div>
			</div>          

			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>기타사항</span>
				</div>
				<div id="txteditor" class="col-xxs-9 book-input">
					<textarea rows="3" name="bk_memo" id="bk_memo"  maxlength="65536" placeholder="기타 특이사항"  class="txtarea-lsh" style="resize:none;"></textarea>
				</div>
			</div>          
			<div class="row book-title-row">
				<div class="col-xxs-3 book-title">
					<i class="fa fa-angle-right"></i>
					<span>예약내용</span>
				</div>
				<div id="txteditor" class="col-xxs-9 book-input">
					<ul id="book_result" class="book-result">
						<li class="ready">
							※ 예약일자, 어선, 출조인원을 선택하십시오.
						</li>
					</ul>
				</div>
			</div>     
			
			<div class="lsh-write-btn-right" style="text-align:center;float:none;margin-top:20px;">
				<button type="submit" id="btn_fbook" accesskey="s" class="btn_fbook btn-u">예약하기</button>
			</div>
			</form>
			<?php } else if($comfig[usebooking] == "1") {?>

			<div class="row">
				<div class="col-xxs-12">
					<div class="headline-center-v2 headline-center-v2-dark">
						<h2 style="margin:0;font-size:23px; font-weight:900;">출조 예약</h2>
						<span class="bordered-icon"><i class="fa fa-th-large"></i></span>
					</div>
				</div>
			</div>

			<div class="row guide-wrap">
				<div class="col-xxs-12 book-guide">
					<img alt="" src="/assets/img/icons/flat/01.png" class="image-md margin-bottom-20">

					<h2 style="margin:0;font-size:23px; font-weight:900;"><p class="guide-title">현재 전화예약만 가능합니다.</p>
					<p class="guide-cont">
						<span class="guide-tel">예약문의 : <?php echo get_text($comfig['com_tel']);?></span>
					</p></h2>
				</div>
			</div>

			<?php } ?>
		</div>
	</div>
</div>
<!-- End Calendar -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>

<?php if($comfig[usebooking] == "0") {?>
<!--페이지 스크립트 영역-->
<?php include_once(G5_SHIP_PATH.'/jsdata2.php');?>
<script src="<?php echo G5_URL;?>/assets/plugins/swiper/js/swiper.js"></script>
<script type="text/javascript" src="<?php echo G5_URL;?>/assets/plugins/calendar/js/jquery.calendario2.js"></script>
<script>
// 달력초기화 - 현재날짜와 어선키값을 통해 해당어선의 해당년월 예약가능인원 불러옴.
var cal = $('#calendar').calendario({
	onDayClick : function( $el, $contentEl, dateProperties ) {
		if($el.hasClass("fc-past")) 
		{ 
			//alert("예약은 현재일 이후 날짜로 가능합니다. "); 
			return false; 
		}
		var notavailcnt = $el.find(".notavail").length;
		if(notavailcnt > 0) 
		{ 
			//alert("예약은 현재일 이후 날짜로 가능합니다. "); 
			return false; 
		}

		$(".fc-calendar .fc-row > div").removeClass("on");
		$el.addClass("on");

		// 날짜를 숫자형태로 변환
		var numericMonth = dateProperties["month"];
		var numericDay = dateProperties["day"];
		var numericYear = dateProperties["year"];
		// 날짜가공('0'붙임)
		if(dateProperties["month"] < 10) dateProperties["month"] ="0"+dateProperties["month"];
		if(dateProperties["day"] < 10) dateProperties["day"] ="0"+dateProperties["day"];
		// 이동할 년월일
		var gotodate = "";
		gotodate += dateProperties["year"];
		gotodate += dateProperties["month"];
		gotodate += dateProperties["day"];
		// 이동할 년월을 저장
		$("#bm").val(dateProperties["month"]);
		$("#by").val(dateProperties["year"]);
		// 이동할 년월일을 저장
		var scymd = String(dateProperties["year"])+String(dateProperties["month"])+String(dateProperties["day"]);
		$("#sc_ymd").val(scymd);
		// 어선키값 추출
		var sidx = $("#s_idx").val();
		// 해당 어선의 해당 년월 정보를 가져옴.
		ajax_get_schedule(sidx, scymd);
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
	//var sidx = "<?php echo $first_s_idx;?>";
	var sidx = $("#s_idx").val();
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_jsdata2.php",
		data: "lapse=after&cy="+yearGet+"&cm="+monthGet+"&s_idx="+sidx, 
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
				cal.gotoNextMonth( updateMonthYear );
				cal.setData(msgarray.data_arr);
				$("#s_idx").val(sidx);
				$("#by").val(yearGet);
				$("#bm").val(monthGet);
			}
		},
		complete: function(){
			initBooking(monthGet,yearGet); // 예약데이터 초기화
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

	//var sidx = "<?php echo $first_s_idx;?>";
	var sidx = $("#s_idx").val();
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_jsdata2.php",
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
			initBooking(monthGet,yearGet);
			loadend();
		}
	});
});

// 현재달로 이동 - 이동날짜와 어선키값을 통해 해당어선의 해당년월 예약가능인원 불러옴.
$( '#custom-current' ).on( 'click', function() {
	var yearGet = cal.getYear();
	var monthGet = cal.getMonth();
	if(monthGet<10) monthGet="0"+monthGet;

	//var sidx = "<?php echo $first_s_idx;?>";
	var sidx = $("#s_idx").val();
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_jsdata2.php",
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
			initBooking(monthGet,yearGet);
			loadend();
		}
	});
});

// 달력재가공 업데이트
function updateMonthYear() {				
	$month.html( cal.getMonthName() );
	$year.html( cal.getYear() );
}

// 해당년월일 어선별 예약정보 추출
function ajax_get_schedule(sidx, dateval) {
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_get_schedule.php",
		data: "s_idx="+sidx+"&sc_ymd="+dateval, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
				else {loadend(); return false;}
			}
			else
			{
				if(msgarray.spec == "1")
				{
					var rtn_s_idx = msgarray.s_idx;
					var rtn_sc_ymd = msgarray.sc_ymd;
					var rtn_sc_status = msgarray.sc_status;
					var rtn_sc_bk_members = msgarray.sc_bk_members;
					var rtn_theme_total = msgarray.sc_theme_total;
					var rtn_sc_theme = msgarray.sc_theme;
					var rtn_sc_cont = msgarray.sc_cont;
					var rtn_sc_price = msgarray.sc_price;
					var rtn_selbox = msgarray.selbox;
					var rtn_shipselbox = msgarray.shipselbox;
					var rtn_ship_arr = msgarray.ship_arr;
					var rtn_ship_imgs = msgarray.shipImgs;
					var rtn_svcdivstr = msgarray.svcdivstr;
					$("#book_theme").html(rtn_theme_total);
					$("#book_members").html(rtn_sc_bk_members);
					$("#sc_cont").html(rtn_sc_cont);
					$("#rtn_ships").html(rtn_ship_arr);
					$("#rtn_selbox").html(rtn_selbox);
					$("#ship_selectbox").html(rtn_shipselbox);
					$("#sc_price").val(rtn_sc_price);
					$("#shipImgs").html(rtn_ship_imgs);
					$("#shipsvc").html(rtn_svcdivstr);
					$("#s_idx").val(rtn_s_idx);
					var bookResultReady = "<li class='ready'>※ 예약일자, 어선, 출조인원을 선택하십시오.</li>";
					$("#book_result").html(bookResultReady);
				}
				else
				{
					var rtn_s_idx = msgarray.s_idx;
					var rtn_ship_arr = msgarray.ship_arr;
					var rtn_shipselbox = msgarray.shipselbox;
					var rtn_ship_imgs = msgarray.shipImgs;
					var rtn_svcdivstr = msgarray.svcdivstr;
					$("#s_idx").val(rtn_s_idx);
					$("#rtn_ships").html(rtn_ship_arr);
					$("#ship_selectbox").html(rtn_shipselbox);
					$("#shipImgs").html(rtn_ship_imgs);
					$("#shipsvc").html(rtn_svcdivstr);
					var bookResultReady = "<li class='ready'>※ 예약일자, 어선, 출조인원을 선택하십시오.</li>";
					$("#book_result").html(bookResultReady);
				}
			}
		},
		complete: function(){
			loadend();
			initSwiper();
		}
	});
}

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

// 년월 이동시 예약데이터 초기화
function initBooking(m,y) {
	var bookTheme = "<span style='color:red;'>※ 예약일자를 선택해 주세요.</span>";
	$("#book_theme").html(bookTheme);
	var ships = "<?php echo $ships;?>";
	$("#rtn_ships").html(ships);
	var selbox = "<option value=''>인원선택</option>";
	$("#rtn_selbox").html(selbox);
	//var sidx = "<?php echo $first_s_idx;?>";
	//$("#s_idx").val(sidx);
	var sidx = $("#s_idx").val();
	var bookResultReady = "<li class='ready'>※ 예약일자, 어선, 출조인원을 선택하십시오.</li>";
	$("#book_result").html(bookResultReady);
	$("#bm").val(m);
	$("#by").val(y);
	$("#sc_ymd").val("");
	$("#sc_price").val("");
	$("#sc_cont").html("");

	$(".ship-name").removeClass("on");
	$("#shipLi_"+sidx).addClass("on");
}

// 날짜,어선,인원 모두 선택시 예약결과 하단에 표시
function checkMem() {
	return true;
}

// 인원선택시 요금계산후 하단에 표시
function showResult(bookcnt) {

    if(!bookcnt || bookcnt < 1) {
        var bookResultReady = "<li class='ready'>※ 예약일자, 어선, 출조인원을 선택하십시오.</li>";
		$("#book_result").html(bookResultReady);
        $("#overbookinNoti").removeClass("show");
    } else {
        var sidx = $.trim($("#s_idx").val());
        var scymd = $.trim($("#sc_ymd").val());
        $.ajax({ 
            type: "GET",
            url: g5_url+"/ship/ajax_booking_preview.php",
            data: "s_idx="+sidx+"&sc_ymd="+scymd+"&bk_member_cnt="+bookcnt, 
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
                    $("#book_result").html(msgarray.cont);
                    if(msgarray.overbooking == 1) {
                        $("#overbookinNoti").addClass("show");
                    } else {
                        $("#overbookinNoti").removeClass("show");
                    }
                }
            },
            complete: function(){
                loadend();
            }
        });
    }

}

function blinker() {
	if($('.availcnt').hasClass("off")) {
		$('.availcnt').removeClass("off");
		$('.availtxt').addClass("off");
	} else  {
		$('.availtxt').removeClass("off");
		$('.availcnt').addClass("off");
	}
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
			url: g5_url+"/ship/ajax_jsdata2.php",
			data: "s_idx="+sidx+"&cy="+yearGet+"&cm="+monthGet, 
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
					cal.gotoMonth( monthGet,yearGet,updateMonthYear );
					cal.setData(msgarray.data_arr); // ajax로받아온 데이터배열을 caldata : codropsEvents 에 집어넣고 그 값으로 달력을 렌더링함. 따라서 include한 jsdata2.php는 최초에 빈값으로 세팅
					$("#s_idx").val(sidx);
					$("#by").val(yearGet);
					$("#bm").val(monthGet);
				}

				// 예약인원 blink 효과
				setInterval(blinker, 1000);
				/*
				(function blink() { 
					//$('.availtxt').fadeIn(300).fadeOut(300); 
					$('.availcnt').fadeOut(300).fadeIn(300, blink); 
				})();
				*/
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
	$(document).off("click",".ship-name").on("click",".ship-name",function(e){
		var sidx = $.trim($(this).data("sidx"));
		var scy = $("#by").val();
		var scm = $("#bm").val();
		var scymd = $.trim($("#sc_ymd").val());

		if(!sidx || sidx == "") {alert("어선키값 오류입니다."); return false;}

		if(!scymd || scymd =="") 
		{ 
			scymd = scy+scm;
			var ajaxData = "s_idx="+sidx+"&cy="+scy+"&cm="+scm; 
		}
		else
		{ 
			var ajaxData = "s_idx="+sidx+"&sc_ymd="+scymd; 
		}

		ajax_get_schedule(sidx, scymd);

		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata2.php",
			data: ajaxData, 
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
					cal.gotoMonth(scm,scy,updateMonthYear);
					cal.setData(msgarray.data_arr);
					$("#"+scymd).addClass("on");
					$("#s_idx").val(sidx);
					$("#by").val(scy);
					$("#bm").val(scm);
				}
			},
			complete: function(){
				loadend();
			}
		});

	});

	// 셀렉트박스 어선선택시 데이터 가져옴
	$(document).off("change",".ship-kind").on("change",".ship-kind",function(e){
		var sidx = $.trim($(this).val());
		var scy = $("#by").val();
		var scm = $("#bm").val();
		var scymd = $.trim($("#sc_ymd").val());

		if(!sidx || sidx == "") {alert("어선키값 오류입니다."); return false;}

		if(!scymd || scymd =="") 
		{ 
			scymd = scy+scm;
			var ajaxData = "s_idx="+sidx+"&cy="+scy+"&cm="+scm; 
		}
		else
		{ 
			var ajaxData = "s_idx="+sidx+"&sc_ymd="+scymd; 
		}

		ajax_get_schedule(sidx, scymd);

		$.ajax({ 
			type: "GET",
			url: g5_url+"/ship/ajax_jsdata2.php",
			data: ajaxData, 
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
					cal.gotoMonth(scm,scy,updateMonthYear);
					cal.setData(msgarray.data_arr);
					$("#"+scymd).addClass("on");
					$("#s_idx").val(sidx);
					$("#by").val(scy);
					$("#bm").val(scm);
				}
			},
			complete: function(){
				loadend();
			}
		});

	});

	// 어선자세히 보기
	$(document).off("click",".ship-detail").on("click",".ship-detail",function(e){
		$("#ship_detail").slideDown("fast",function(){
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
						$("#shipImgs").html(msgarray.cont);
						$("#shipsvc").html(msgarray.svcdivstr);
					}
				},
				complete: function(){
					initSwiper();
					loadend();
				}
			});

		});
		$(this).removeClass("ship-detail").addClass("ship-hide").html("창닫기");
		var sidx =$("#s_idx").val();
	});

	// 어선자세히 보기 닫기
	$(document).off("click",".ship-hide").on("click",".ship-hide",function(e){
		$("#ship_detail").slideUp("fast");
		$(this).removeClass("ship-hide").addClass("ship-detail").html("자세히");
	});


});

</script>

<script>
// 예약하기
function fbook_submit(f)
{
    if(!(confirm("예약을 진행하시겠습니까?"))) {
        return false;
    } else {
        ajax_fbook_submit();
        return false;
    }
}

// 예약 ajax처리
function ajax_fbook_submit()
{
	$(".btn_fbook").attr("disabled","disabled");
	
	// 데이터 검증
	var s_idx = $("#s_idx").val();
	var sc_ymd = $.trim($("#sc_ymd").val());
	var bk_price = parseInt($("#sc_price").val());
	var bk_banker = $.trim($("#bk_banker").val());
	var bk_tel = $.trim($("#bk_tel").val());
	var bk_member_cnt = parseInt($("#rtn_selbox").val());

	if(!s_idx || s_idx=="") {alert("어선키값 오류입니다."); $(".btn_fbook").removeAttr("disabled"); return false;}
	if(!sc_ymd || sc_ymd=="") {alert("예약일자를 선택해 주세요."); $(".btn_fbook").removeAttr("disabled"); return false;}
	if(sc_ymd.length != 8) {alert("예약일자를 선택해 주세요."); $(".btn_fbook").removeAttr("disabled"); return false;}
	if(!bk_price || bk_price < 1) {alert("출조비용 오류입니다."); $(".btn_fbook").removeAttr("disabled"); return false;}
	if(!bk_banker || bk_banker=="") {alert("예약자명을 입력하세요."); $(".btn_fbook").removeAttr("disabled"); return false;}
	if(!bk_tel || bk_tel=="") {alert("연락처를 입력하세요."); $(".btn_fbook").removeAttr("disabled"); return false;}
	if(!bk_member_cnt || bk_member_cnt < 1) {alert("예약인원을 선택하세요."); $(".btn_fbook").removeAttr("disabled"); return false;}
	
	var formData = $("#fbook").serialize();
	$.ajax({ 
		type: "POST",
		url: "./ajax_booking_save.php",
		data: formData, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl) 
				{
					if(msgarray.errurl == "reload") document.location.reload();
					else document.location.replace(msgarray.errurl);
				}
				else
				{	
					loadend(); 
					$(".btn_fbook").removeAttr("disabled");
					return false;
				}
			}
			else
			{
				alert("예약접수가 완료되었습니다.");
				document.location.replace("./booking_result.php?bk_idx="+msgarray.bkidx);
			}
		},
		complete: function(){
			loadend();
		}
	});
}
</script>
<script>
$(document).load($(window).bind("load resize", moveDiv));

function moveDiv(e) {

	var tpn = "<?php echo $_tpn;?>";
	var wrapper_width = "";
	if(tpn == "3")  wrapper_width = $(window).outerWidth();
	else wrapper_width = $("#divwrap").outerWidth();

	if(wrapper_width < sm_width)
	{
		$("#booknotice").insertAfter($("#bookform"));  
	}
	else
	{
		$("#bookform").insertAfter($("#booknotice"));
	}
}
</script>
<?php } ?>
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->