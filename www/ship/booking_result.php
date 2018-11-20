<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "bookresult";

$bk_idx = $_REQUEST['bk_idx'];
$bk_idx =  preg_replace('/[^0-9]/', '', $bk_idx);
if(!$bk_idx || $bk_idx < 1)
{
	$errorstr = "예약키값 오류입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
if(!$bk['bk_idx'])
{
	$errorstr = "존재하지 않는 예약입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$s_idx = $bk['s_idx'];
$bk_ymd = $bk['bk_ymd'];
$bk_status = $bk['bk_status'];

if(!$is_member)
{
	// 회원ID
	$bk_mb_id = "temp_member";
	// 회원명
	$bk_mb_name = "비회원 예약";
}
else{
	// 회원ID
	$bk_mb_id = $bk[bk_mb_id];
	// 회원명
	$bk_mb_name = get_text($bk[bk_mb_name]);
}
// 예약자(입금자)명
$bk_banker = get_text($bk[bk_banker]);
// 예약자연락처
$bk_tel = get_text($bk[bk_tel]);
// 어선아이디
$s_idx = $bk[s_idx];
// 어선명
$s_name = get_text($bk[s_name]);
// 출조테마
$bk_theme = get_text($bk[bk_theme]);
// 출조일
$bk_ymd = $bk[bk_y]."-".$bk[bk_m]."-".$bk[bk_d];
$bk_ymd_wd = $bk[bk_y].$bk[bk_m].$bk[bk_d];
// 요일추출
$wd = date('w', strtotime($bk_ymd));
switch($wd)
{
	case(0) : $weekday = "<span style='color:red;'>일</span>"; break;
	case(1) : $weekday = "<span style='color:#777;'>월</span>"; break;
	case(2) : $weekday = "<span style='color:#777;'>화</span>"; break;
	case(3) : $weekday = "<span style='color:#777;'>수</span>"; break;
	case(4) : $weekday = "<span style='color:#777;'>목</span>"; break;
	case(5) : $weekday = "<span style='color:#777;'>금</span>"; break;
	case(6) : $weekday = "<span style='color:blue;'>토</span>"; break;
}	
// 출조인원
$bk_member_cnt = number_format($bk[bk_member_cnt]);
// 예약메모
$bk_memo = get_text($bk[bk_memo],0);
// 예약접수일
$bk_datetime = $bk[bk_datetime];
// 총출조비용
$bk_price_total = number_format($bk[bk_price_total]);
// 예약비용
$book_price = $bk[bk_price_total] * ($comfig['book_fee'] / 100);
$book_price = number_format($book_price);

include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css">
<style>
input.frm_input{width: 100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}
/*Scrollbar*/
.mCustomScrollBox{height:500px;padding:0 15px;border: 1px solid #dadada;}
.mCS-autoHide > .mCustomScrollBox > .mCSB_scrollTools, .mCS-autoHide > .mCustomScrollBox ~ .mCSB_scrollTools {opacity: 0.2;}
.mCSB_container{padding: 15px 0;}
.btn-u{width: 320px;border-radius: 20px;height: 40px;font-size: 16px;background:#f99292;}

.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}
.notespan{font-size: 1.3em;display: inline-block;border-bottom: 1px dotted #333;padding: 3px 6px;margin-bottom: 10px;}

.txtcont{line-height:24px;}

@media (max-width: 991px) {
	.txtcont{font-size:12px; line-height:20px;}
}
@media (max-width: 767px) {
	.txtcont{font-size:11px; line-height:18px;}
}

</style>
<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">예약이 완료되었습니다</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<div class="container content">		
	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 lsh-login-box1">
			<div class="reg-header"><h2 style="text-align:center;font-weight:bolder;">예약접수 완료</h2></div>
		</div>
		<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 lsh-login-box2">
			<div class="row">
				<div class="col-xxs-12">
					<h3><i class="fa fa-info-circle"></i>예약접수 내용</h3>
					<p style="margin-bottom:30px;">
						<i class="fa fa-check-square-o"></i> 예약일자 : <?php echo $bk_ymd;?> (<?php echo $wd;?>)<br>
						<i class="fa fa-check-square-o"></i> 출조테마 : <?php echo $s_name;?> - <?php echo $bk_theme;?><br>
						<i class="fa fa-check-square-o"></i> 예약인원 : <?php echo $bk_banker;?>님 포함 <?php echo $bk_member_cnt;?>명<br>
						<i class="fa fa-check-square-o"></i> 출조비용 : <?php echo $bk_price_total;?>원<br>
						<i class="fa fa-check-square-o"></i> 예약금액 : <?php echo $book_price;?>원 (예약금액은 출조비용의 <?php echo $comfig['book_fee'];?>% 입니다.)
					</p>

					<h3><i class="fa fa-info-circle"></i>입금 및 입금계좌 안내</h3>
					<p>
						아래 계좌로 총 출조비용 <?php echo $bk_price_total;?>원의 <?php echo $comfig['book_fee'];?>%(<?php echo $book_price;?>원) 이상 입금시 예약이 완료됩니다.<br>
					</p>
					<p>
						<i class="fa fa-check-square-o"></i>
						<span style="font-weight:bolder;">
							입금계좌 : <?php echo $comfig['com_bank'];?> <?php echo $comfig['com_account'];?> (예금주 : <?php echo $comfig['com_account_owner'];?>)
						</span>
					</p>
				</div>
			</div>

			<div class="row" style="padding-top:50px;">
				<div class="col-xxs-12">
					<div class="headline-center-v2 headline-center-v2-dark">
						<h2 style="margin:0;font-size:20px; font-weight:200;">예약필독사항</h2>
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
	</div><!--/row-->
</div><!--/container-->		
</form>

<div class="btn_confirm" style="text-align:center;">
	<?php if($is_member) { ?>
	<a href="<?php echo G5_SHIP_URL ?>/mybooking.php"  class="lsh-btn-gomain" />예약확인</a>
	<?php } ?>
	<a href="<?php echo G5_URL ?>"  class="lsh-btn-gomain" />메인으로</a>
</div>
<!-- } 로그인 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->