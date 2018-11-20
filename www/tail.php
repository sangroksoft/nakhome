<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!-- JS Global Compulsory -->
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
<script src="<?php echo G5_URL;?>/assets/plugins/modernizr.js"></script>
<script src="<?php echo G5_URL;?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo G5_URL;?>/assets/plugins/back-to-top.js"></script>
<script src="<?php echo G5_JS_URL;?>/js.cookie.js"></script>

<!-- JS Implementing Plugins -->
<?php include_once(G5_PATH.'/include/inc_js.php');?>

<!-- Preload  로딩이 많고 부하가 걸리는 페이지의 경우 사용함. head.php에 관련코드 연동-->
<script>
$(window).load(function() { // makes sure the whole site is loaded
	$('#status').fadeOut(); // will first fade out the loading animation
	//$('#preloader').hide();
	$('#preloader').delay(50).fadeOut('slow'); // will fade out the white DIV that covers the website.
	$('body').delay(50).css({'overflow':'visible'});
	$(window).scroll();
})
<?php if(!($pgubun == "booking" || $pgubun == "bk_process")) { ?>
	Cookies.remove('bkymd');
	Cookies.remove('fymd');
<?php } ?>
</script>

<!-- 멀티단어 검색-->
<script>
// 검색어 체크
function fsearch_submit(f)
{
	/*
	if (f.stx.value.length < 2)
	{
		alert("검색어는 두글자 이상 입력하십시오.");
		f.stx.select();
		f.stx.focus();
		return false;
	}
	*/

	// 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
	var cnt = 0;
	for (var i=0; i<f.stx.value.length; i++) {
		if (f.stx.value.charAt(i) == ' ')
			cnt++;
	}
	if (cnt > 2) {
		alert("빠른 검색을 위하여 검색어에 3개 단어만 입력할 수 있습니다.");
		f.stx.select();
		f.stx.focus();
		return false;
	}
}

function gotoBooking()
{
	Cookies.remove('bkymd');
	Cookies.remove('fymd');
	Cookies.set('isload', true);

	document.location.href=g5_url+"/ship/booking.php";
}

</script>

</div><!--/wrapper-->
<!-- toast and loading -->
<div class='lsh-toast'></div>
<div class="loadimgWrap"><img src="<?php echo G5_IMG_URL;?>/loading_now.gif" class="loadimg"></div>

