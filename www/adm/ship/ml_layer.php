<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!--아이프레임 레이어팝업을 위한 style 설정 //#layermask는 head.sub.php의 body 바로 아래 저장-->
<style> 
#layermask {position:absolute;z-index:9000;background-color:#000;display:none;left:0;top:0;} 
#layerpopup2 {display:none; outline:2px solid #666;position:absolute;right:10%;top:10%;z-index:10000;width:580px;height:580px; background:#ffffff}
#topdiv_wrap2 {width:580px; height:30px; background:url('<?php echo G5_IMG_URL;?>/modal_title_bg.gif'); background-repeat: repeat-x; }
#iframe_wrap2 {background-color:#ffffff;}
#iframe_tag2 {background-color: #ffffff;}
.topdiv_left2 {float:left; padding-left:10px;  color:#525252; font-weight:bolder;}
.topdiv_left2 span {line-height:30px}
.topdiv_right2 {float:right; padding-right:10px; padding-top:5px;}

#layerpopup3 {display:none; outline:2px solid #666;position:absolute;right:10%;top:10%;z-index:10000;width:670px;height:500px; background:#ffffff}
#topdiv_wrap3 {width:670px; height:30px; background:url('<?php echo G5_IMG_URL;?>/modal_title_bg.gif'); background-repeat: repeat-x; }
#iframe_wrap3 {background-color:#ffffff;}
#iframe_tag3 {background-color: #ffffff;}
.topdiv_left3 {float:left; padding-left:10px;  color:#525252; font-weight:bolder;}
.topdiv_left3 span {line-height:30px}
.topdiv_right3 {float:right; padding-right:10px; padding-top:5px;}

</style>

<form id="f_contform" name="f_contform" enctype="multipart/form-data" autocomplete="off" target="target_iframe2">
	<input type='hidden' name='target' id="target"  value=''>
	<input type='hidden' name='valarr' id="valarr"  value=''>
</form>

<div id="layerpopup2">
	<div id="topdiv_wrap2">
		<div class="topdiv_left2">
			<span>예약설정</span>
		</div>
		<div class="topdiv_right2">
			<span style=" float:right;"><a href="javascript:;" onclick="closelayer2();"><img src='<?php echo G5_IMG_URL; ?>/btn_close2.gif' border="0" alt=""></a></span>
		</div> 
	</div>
	<div id="iframe_wrap2"></div>  
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
function wrapWindowByMask(val)
{
	$(document).ready(function(){
		//화면의 높이와 너비를 구한다.
		//$("body").css("min-width","1280px");
		var maskHeight = '100%';  
		var maskWidth = '100%';  
	
		//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
		$('#layermask').css({'width':maskWidth,'height':maskHeight});  
	
		//애니메이션 효과 - 일단 1초동안 까맣게 됐다가 20% 불투명도로 간다.
		$('#layermask').fadeTo("fast",0.5);    
	
		//레이어윈도우 띄움.
		$('#'+ val).show();
		var $layerPopupObj = $('#'+ val);
		var left = ( $(window).scrollLeft() + ($(window).width() - $layerPopupObj.outerWidth()) / 2 );
		var top = ( $(window).scrollTop() + ($(window).height() - $layerPopupObj.outerHeight()) / 2 );
		$layerPopupObj.css({'left':left+'px','top':top+'px', 'position':'absolute'});
		$('body').css('position','relative').append($layerPopupObj);
	});
}

function centerModal()
{
	var maskHeight = '100%';  
	var maskWidth = '100%';  

	//레이어윈도우 띄움.
	var $layerPopupObj = $('#layerpopup2');
	var left = ( $(window).scrollLeft() + ($(window).width() - $layerPopupObj.outerWidth()) / 2 );
	var top = ( $(window).scrollTop() + ($(window).height() - $layerPopupObj.outerHeight()) / 2 );
	$layerPopupObj.css({'left':left+'px','top':top+'px', 'position':'absolute'});
}

$(window).on('resize', function(){
	centerModal();
});

function show_modal(layername,tgt,varr)
{
	(function($){
    
		var iframe_str = "<iframe id='iframe_tag2' width='580px' height='548px' frameborder='no' marginheight='0' marginwidth='0' scrolling='no' allowTransparency='true' name='target_iframe2'></iframe>";
		$("#iframe_wrap2").html(iframe_str);
		
		wrapWindowByMask(layername);
		$("#layerpopup2").draggable({
			//handle : '#top_div2', //드래그를 적용시킬 엘리먼트
			cancel : '#iframe_wrap2', //드래그를 제외시킬 엘리먼트
			scroll: false, // 스크롤 막음
			//containment:'#wrapper', // 스크롤 제한영역
			revert:true // 드래그 후 되돌아오기
		});
	
		var fc = document.f_contform;
	
		if(tgt == "monthly")
		{
			fc.target.value = tgt;
			fc.valarr.value = varr;
			fc.method = "get";
			fc.action = "./layer_monthly.php";
		}
		if(tgt == "daily")
		{
			fc.target.value = tgt;
			fc.valarr.value = varr;
			fc.method = "get";
			fc.action = "./layer_daily.php";
		}
		if(tgt == "booking")
		{
			fc.target.value = tgt;
			fc.valarr.value = varr;
			fc.method = "get";
			fc.action = "./layer_booking.php";
		}

		fc.submit();
	})(jQuery);
}

function closelayer2() 
{
	(function($){
	 	$("#layermask").fadeOut("fast");
		$("#iframe_wrap2").html("").empty();  
		$("#layerpopup2").hide();  
		$("body").css("min-width","");
	})(jQuery);
}

//모달창 닫기
$(document).on("click","#layermask",function(){
	$("#layermask").fadeOut("fast");
	$("#iframe_wrap2").html("").empty();  
	$("#layerpopup2").hide();  
	$("body").css("min-width","");
});

</script>