<?php
include_once('./_common.php');

$snoopy = new Snoopy;
 
$snoopy->maxframes = 5;

//네이버 파싱하니까 네이버 주소
if($snoopy->fetch("http://www.kma.go.kr/mini/marine/inner_marine_forecast.jsp?topArea=12A30000&x=26&y=12&midArea=12A20100&btmArea=12A20102"))
{
	//  echo "<PRE>".htmlspecialchars($snoopy->results[0])."</PRE>\n";
	//  echo "<PRE>".htmlspecialchars($snoopy->results[1])."</PRE>\n";
	//  echo "<PRE>".htmlspecialchars($snoopy->results[2])."</PRE>\n";

	//$aaa = iconv("euckr", "utf8", trim(str_replace('<br>','<div>',$snoopy->results)));
	//preg_match_all('/<tr(.*?)>(.*?)<\/tr>/is', $aaa, $text);
	//$bbb = print_r2(htmlspecialchars(str_replace('&nbsp;','',$text[0][1])));
	preg_match('/<div id="marine-panel"(.*?)>(.*?)<\/div>/is', iconv("euckr", "utf8", $snoopy->results), $html);
	echo print_r($html[0]);

	$isSuccess = "1";
}
else
{
	$isSuccess = "";
}

?>
<form name="fsclistmodify" id="fsclistmodify" method="post" autocomplete="off">
<input type="hidden" id="isSuccess" name="isSuccess" value="<?php echo $isSuccess;?>">
<input type="hidden" id="bastime" name="bastime" value="">
<input type="hidden" id="fc0" name="fc0" value="">
<input type="hidden" id="fc1" name="fc1" value="">
<input type="hidden" id="fc2" name="fc2" value="">
<input type="hidden" id="fc3" name="fc3" value="">
<input type="hidden" id="fc4" name="fc4" value="">
<input type="hidden" id="fc5" name="fc5" value="">
<input type="hidden" id="fc6" name="fc6" value="">
<input type="hidden" id="fc7" name="fc7" value="">
<input type="hidden" id="fc8" name="fc8" value="">
<input type="hidden" id="fc9" name="fc9" value="">
<input type="hidden" id="fc10" name="fc10" value="">
<input type="hidden" id="fc11" name="fc11" value="">
<input type="hidden" id="fc12" name="fc12" value="">
<input type="hidden" id="fc13" name="fc13" value="">
<input type="hidden" id="fc14" name="fc14" value="">
<input type="hidden" id="fc15" name="fc15" value="">
<input type="hidden" id="fc16" name="fc16" value="">
<input type="hidden" id="fc17" name="fc17" value="">
<input type="hidden" id="fc18" name="fc18" value="">
</form>

<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script>
$(document).ready(function(){
	//tr 갯수가 19개면 오늘 오전,오후 다있는 상황이고 18개면 오전은 누락되어 있음.
	var baseTime = $.trim($("#marine-panel").find("span").html());
	baseTimeY = baseTime.substr(0,4);
	baseTimeM = baseTime.substr(6,2);
	baseTimeD = baseTime.substr(10,2);
	baseTimeYMD = baseTimeY+baseTimeM+baseTimeD;
	$("#bastime").val(baseTimeYMD);
	/*
	console.log(baseTimeY);
	console.log(baseTimeM);
	console.log(baseTimeD);
	console.log(baseTimeYMD);
	*/

	var tr = $("tbody.marine tr");
	$("head").remove();
	tr.each(function(index){ 

		var dayNameTh = $(this).find("th");
		var dayNameThLength = dayNameTh.length;
		if(dayNameThLength > 0)
		{
			var dayName = dayNameTh.html();
		}
		else
		{
			var dayName = $(this).prev("tr").find("th").html();
		}

		var dB = $(this).find("td:eq(0)");
		var dBhtml = $.trim(dB.html());
		var dW = $(this).find("td:eq(1)").find("dd.desc");
		var dWhtml = $.trim(dW.html());
		var dT = $(this).find("td:eq(2)");
		var dThtml = $.trim(dT.html());
		var dV = $(this).find("td:eq(3)");
		var dVhtml = $.trim(dV.html());
		var dWs = $(this).find("td:eq(4)");
		var dWshtml = $.trim(dWs.html());

		var totstr = dayName+"|"+dBhtml+"|"+dWhtml+"|"+dThtml+"|"+dVhtml+"|"+dWshtml;
		$("#fc"+index).val(totstr);
		/*
		console.log(dayName);
		console.log(dBhtml);
		console.log(dWhtml);
		console.log(dThtml);
		console.log(dVhtml);
		console.log(dWshtml);
		*/
	});
});

</script>