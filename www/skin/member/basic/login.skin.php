<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<!--페이지 CSS Include 영역-->
<style>
input.frm_input{width: 100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}
</style>
<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">회원로그인</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->

<!-- 로그인 시작 { -->
<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
<input type="hidden" name="url" value='<?php echo $login_url ?>'>
<!--=== Content Part ===-->
<div class="container content">		
	<div class="row">
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 lsh-login-box1">
				<div class="reg-header">            
					<h2>회원로그인</h2>
				</div>
				
				<div class="note lsh-login-note"><strong>Note:</strong> ID를 입력하세요.</div>
				<div class="input-group margin-bottom-10">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<label for="login_id" class="login_id sound_only">회원아이디 필수</label>
					<input type="text" name="mb_id" id="login_id" required style="ime-mode:disabled;" placeholder="아이디입력" maxLength="20" class="required frm_input">
				</div>    
				<div class="note lsh-login-note"><strong>Note:</strong> 비밀번호를 입력하세요.</div>
				<div class="input-group margin-bottom-20">
					<span class="input-group-addon lsh-fa-padding-13"><i class="fa fa-lock"></i></span>
					<label for="login_pw" class="login_pw sound_only">비밀번호 필수</label>
					<input type="password" name="mb_password" id="login_pw" required placeholder="비밀번호입력" maxLength="20" class="required frm_input">
				</div>                    

				<div class="row">
					<div class="col-md-6 col-xs-6 col-xxs-6 checkbox">
						<label><input type="checkbox" name="auto_login" id="login_auto_login"> 자동로그인</label>                        
					</div>
					<div class="col-md-6 col-xs-6 col-xxs-6">
						<button class="btn-u pull-right btn_submit" type="submit">로그인</button>
					</div>
				</div>
		</div>
		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 lsh-login-box2">
			<h3><i class="fa fa-info-circle"></i>회원로그인 안내</h3>
			<p>
				회원아이디 및 비밀번호가 기억 안나실 때는 ID/비밀번호 찾기를 이용하십시오.<br>
				아직 회원이 아니시라면 회원으로 가입 후 이용해 주십시오.
			</p>
			<div class="lsh-login-box2-btn">
				<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="btn02">ID/비밀번호 찾기</a>
				<a href="./register.php" class="btn01">회원가입</a>
			</div>
		</div>
	</div><!--/row-->
</div><!--/container-->		
</form>

<div class="btn_confirm" style="text-align:center;">
	<a href="<?php echo G5_URL ?>"  class="lsh-btn-gomain" />메인으로 돌아가기</a>
</div>
<!-- } 로그인 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer'.$sp.'.php');?>
<?php include_once(G5_PATH.'/jquery_load'.$sp.'.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail'.$sp.'.php');?>
<!--페이지 스크립트 영역-->
<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail'.$sp.'.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->