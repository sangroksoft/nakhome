<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "regiresult";

?>
<!--페이지 CSS Include 영역-->
<style>
.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}
.notespan{font-size: 1.3em;display: inline-block;border-bottom: 1px dotted #333;padding: 3px 6px;margin-bottom: 10px;}
.lsh-login-box2 {height:400px;}
</style>
<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p>회원가입을 축하합니다.!</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<div class="container content">		
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 lsh-login-box1">
			<div class="reg-header"><h2 style="text-align:center;font-weight:bolder;">회원가입 완료</h2></div>
		</div>
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 lsh-login-box2">
			<div class="row">
				<div class="col-xxs-12" style="text-align:center;">
					<p>
						<strong><?php echo get_text($mb['mb_name']); ?></strong>님의 회원가입을 진심으로 축하합니다.<br>
					</p>
					<p>
						<i class="fa fa-check-square-o"></i> 회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br>
						아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.
					</p>

					<p>
						<i class="fa fa-check-square-o"></i> 회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.<br>
						감사합니다.
					</p>
				</div>
			</div>
		</div>
	</div><!--/row-->
</div><!--/container-->		
</form>

<div class="btn_confirm" style="text-align:center;">
	<a href="<?php echo G5_URL ?>"  class="lsh-btn-gomain" />메인으로</a>
</div>
<!-- } 로그인 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer'.$sp.'.php');?>
<?php include_once(G5_PATH.'/jquery_load'.$sp.'.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail'.$sp.'.php');?>
<!--페이지 스크립트 영역-->
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail'.$sp.'.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->