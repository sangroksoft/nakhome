<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "guide";

include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<style>
.interactive-slider-v2 {height: 470px;}
.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}
.notespan{font-size: 1.3em;display: inline-block;border-bottom: 1px dotted #333;padding: 3px 6px;margin-bottom: 10px;}
.lsh-td1 .input-group p{margin-bottom: 6px;}

.txtcont{line-height:24px;}
@media (max-width: 991px) {
	.txtcont{font-size:12px; line-height:20px;}
}
@media (max-width: 767px) {
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:12px;}
}
@media (max-width: 480px) {
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:11px;}
	.txtcont{font-size:11px; line-height:18px;}
}
</style>
<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">출조안내</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<!--=== Content Part ===-->
<div class="container content">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-40">
				<h2 class="pg-title">출조안내</h2>
			</div>
			<div class="table-title"><span class="item-fa"><i class="fa fa-anchor"></span></i><h3 class="item-title">입출항 시간</h3></div>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="ca_name" class="lsh-label">출항</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 출항</span></div>
							<div class="input-group lsh-form-nopadding txtcont">
								<?php echo get_text($comfig['out_time'],1); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="ca_name" class="lsh-label">입항</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 입항</span></div>
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

			<div class="table-title"><span class="item-fa"><i class="fa fa-tags"></span></i><h3 class="item-title">예약 및 환불안내</h3></div>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="ca_name" class="lsh-label">예약처리절차</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 예약처리절차</span></div>
							<div class="input-group lsh-form-nopadding txtcont">
								<?php echo get_text($comfig['book_process'],1); ?>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="ca_name" class="lsh-label">환불</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 환불</span></div>
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
						<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
							<label for="ca_name" class="lsh-label">기타 유의사항</label>
						</th>
						<td class="lsh-td1">
							<div class="note visible-sm visible-xs visible-xxs"><span class="notespan"><i class="fa fa-check"></i> 기타 유의사항</span></div>
							<div class="input-group lsh-form-nopadding txtcont">
								<?php echo get_text($comfig['etc_notice'],1); ?>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
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
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->