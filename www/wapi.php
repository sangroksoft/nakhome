<?php
include_once('./_common.php');

$seaArr = explode("|",$comfig[sea]);
$topArea = $seaArr[0];
$midArea = $seaArr[1];
$btmArea = $seaArr[2];

$apiFetch = sql_fetch(" select lastupdate from m_fcst limit 1");

$last_unix = strtotime($apiFetch[lastupdate]);
$up_time = date("Y-m-d H:i:s", strtotime("+2 hours",$last_unix));
$now_time = date("Y-m-d H:i:s");

if($now_time < $up_time) return;

$snoopy = new Snoopy;
$snoopy->maxframes = 5;

if($snoopy->fetch("http://www.kma.go.kr/mini/marine/inner_marine_forecast.jsp?topArea=$topArea&midArea=$midArea&btmArea=$btmArea"))
{
	preg_match('/<div id="marine-panel"(.*?)>(.*?)<\/div>/is', iconv("euckr", "utf8", $snoopy->results), $html);
	echo print_r($html[0]);

	$isSuccess = "1";
}
else
{
	$isSuccess = "";
}

?>
<form name="fapi" id="fapi" method="post" autocomplete="off">
<input type="hidden" id="isSuccess" name="isSuccess" value="<?php echo $isSuccess;?>">
<input type="hidden" id="sccnt" name="sccnt" value="">
<input type="hidden" id="basey" name="basey" value="">
<input type="hidden" id="basem" name="basem" value="">
<input type="hidden" id="based" name="based" value="">
<input type="hidden" id="basetimestr" name="basetimestr" value="">
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
var g5_url       = "<?php echo G5_URL ?>";
$(document).ready(function(){
	//tr 갯수가 19개면 오늘 오전,오후 다있는 상황이고 18개면 오전은 누락되어 있음.
	var baseTime = $.trim($("#marine-panel").find("span").html());
	baseTimeY = baseTime.substr(0,4);
	baseTimeM = baseTime.substr(6,2);
	baseTimeD = baseTime.substr(10,2);
	//baseTimeYMD = baseTimeY+baseTimeM+baseTimeD;
	$("#basey").val(baseTimeY);
	$("#basem").val(baseTimeM);
	$("#based").val(baseTimeD);
	$("#basetimestr").val(baseTime);

	var tr = $("tbody.marine tr");
	var successcnt = 0;

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

		var dimg = $(this).find("td:eq(1)").find("img").attr("src");
		//dimg = dimg.substr(dimg.length - 8, 8); // 이미지이름과 확장자만 추출
		dimg = "http://www.weather.go.kr"+dimg; // 기상청url 추가 (http://www.weather.go.kr)

		var totstr = dayName+"|"+dBhtml+"|"+dWhtml+"|"+dThtml+"|"+dVhtml+"|"+dWshtml+"|"+dimg;
		$("#fc"+index).val(totstr);

		successcnt++;
	});

	$("#sccnt").val(successcnt);

	if(successcnt > 17)
	{
		var formData = $("#fapi").serialize();
		$.ajax({ 
			type: "POST",
			url: g5_url+"/ship/ajax_fcst_save.php",
			data: formData, 
			beforeSend: function(){
				//loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);
				if(msgarray.rslt == "error")
				{
					return false;
				}
				else
				{
					return true;
				}
			},
			complete: function(){
				//loadend();
			}
		});
		
	}
});
</script>