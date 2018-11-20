<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo $member_skin_url;?>/style.css">
<style>
input.frm_input{width: 100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}
</style>
<!--페이지 CSS Include 영역-->
<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p style="font-size:36px;font-weight:bolder;color:#fff;opacity:1;">회원가입</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->


<!-- 회원가입약관 동의 시작 { -->
<div class="container content lsh-toggle-fluid">		

<div class="mbskin">
    <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
	<input type="hidden" name="sp" value="<?php echo $sp;?>">
    <p>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>

    <section id="fregister_term">
        <h2><i class="fa fa-tags"></i>회원가입약관</h2>
        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <fieldset class="fregister_agree">
            <label for="agree11">회원가입약관의 내용에 동의합니다.</label>
            <input type="checkbox" name="agree" value="1" id="agree11">
        </fieldset>
    </section>

    <section id="fregister_private">
        <h2><i class="fa fa-tags"></i>개인정보처리방침</h2>
        <textarea readonly><?php echo get_text($config['cf_privacy']) ?></textarea>
        <fieldset class="fregister_agree">
            <label for="agree21">개인정보처리방침안내의 내용에 동의합니다.</label>
            <input type="checkbox" name="agree2" value="1" id="agree21">
        </fieldset>
    </section>

    <div class="container">
        <p style="font-size:20px;font-weight:bolder;color:#000000;opacity:1;"><input type="submit" class="btn_submit" value="회원가입"></p>
    </div>

    </form>

</div>
</div>
<!-- } 회원가입 약관 동의 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer'.$sp.'.php');?>
<?php include_once(G5_PATH.'/jquery_load'.$sp.'.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail'.$sp.'.php');?>
<!--페이지 스크립트 영역-->
<script>
function fregister_submit(f)
{
	if (!f.agree.checked) {
		alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}

	if (!f.agree2.checked) {
		alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree2.focus();
		return false;
	}

	return true;
}
</script>
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail'.$sp.'.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->