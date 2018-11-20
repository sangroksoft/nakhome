<?php
include_once('./_common.php');

$today = date('Ymd');
$day1 = date('Ymd',strtotime("1 day"));
$day2 = date('Ymd',strtotime("2 day"));
$day3 = date('Ymd',strtotime("3 day"));
$day4 = date('Ymd',strtotime("4 day"));
$day5 = date('Ymd',strtotime("5 day"));
$day6 = date('Ymd',strtotime("6 day"));
$day7 = date('Ymd',strtotime("7 day"));
$day8 = date('Ymd',strtotime("8 day"));
$day9 = date('Ymd',strtotime("9 day"));
$day10 = date('Ymd',strtotime("10 day"));

$weather_arr = array();
$day0_arr = $day1_arr = $day2_arr = $day3_arr = $day4_arr = $day5_arr = $day6_arr = $day7_arr = $day8_arr = $day9_arr = $day10_arr = array();

$ch = curl_init();
$url = 'http://newsky2.kma.go.kr/service/SecndSrtpdFrcstInfoService2/ForecastSpaceData'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . '=xhmSUu8fvPZ44%2Fexc5AdXRaB6SJ1TgjBYT2zadG%2FXbQcS%2FaEthNHuWdGUlOrTZgDcTtl5hS3mWfRpG9A82rlvg%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('ServiceKey') . '=' . urlencode('xhmSUu8fvPZ44%2Fexc5AdXRaB6SJ1TgjBYT2zadG%2FXbQcS%2FaEthNHuWdGUlOrTZgDcTtl5hS3mWfRpG9A82rlvg%3D%3D'); /*서비스 인증*/
$queryParams .= '&' . urlencode('base_date') . '=' . urlencode($today); /*예보기준일-현재일*/
$queryParams .= '&' . urlencode('base_time') . '=' . urlencode('1400'); /*예보기준시간, 새벽 5시 기준으로 뽑아옴. 실제 api 제공시간은 5시 10분이므로 크론탭은 5시 30분정도에 호출하면됨.*/
$queryParams .= '&' . urlencode('nx') . '=46'; /*지역 x 좌표*/
$queryParams .= '&' . urlencode('ny') . '=119'; /*지역 y 좌표*/
$queryParams .= '&' . urlencode('numOfRows') . '=300'; /*추출갯수*/
$queryParams .= '&' . urlencode('_type') . '=json'; 

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

$return = json_decode($response);
$sky_arr = $return->response->body->items->item;
print_r2($sky_arr); echo "<br>";

for($i=0; $i<count($sky_arr); $i++)
{
	//날짜 시간
	$fcstdate = $sky_arr[$i]->fcstDate; //예보날짜
	$fcsttime = $sky_arr[$i]->fcstTime; //예보시간
	$category = $sky_arr[$i]->category;//'카테고리

	if($fcstdate == $today)
	{
		if($fcsttime == "0900")
		{
			if($category == "POP") $bn_pop = $sky_arr[$i]->fcstValue; //강수확율 %
			if($category == "PTY") $bn_pty = $sky_arr[$i]->fcstValue; //강수형태 (없음(0), 비(1), 비/눈(2), 눈(3))
			if($category == "SKY") $bn_sky = $sky_arr[$i]->fcstValue; //하늘상태 맑음(1), 구름조금(2), 구름많음(3), 흐림(4)
			if($category == "VEC") $bn_vec = $sky_arr[$i]->fcstValue; //풍향
			if($category == "WSD") $bn_wsd = $sky_arr[$i]->fcstValue; //풍속
			if($category == "WAV") $bn_wav = $sky_arr[$i]->fcstValue; //파고
		}
		if($fcsttime == "1200")
		{
			if($category == "POP") $an_pop = $sky_arr[$i]->fcstValue; //강수확율 %
			if($category == "PTY") $an_pty = $sky_arr[$i]->fcstValue; //강수형태 (없음(0), 비(1), 비/눈(2), 눈(3))
			if($category == "SKY") $an_sky = $sky_arr[$i]->fcstValue;
			if($category == "VEC") $an_vec = $sky_arr[$i]->fcstValue;
			if($category == "WSD") $an_wsd = $sky_arr[$i]->fcstValue;
			if($category == "WAV") $an_wav = $sky_arr[$i]->fcstValue;
		}
	}
	else if($fcstdate == $day1)
	{
		if($fcsttime == "0000")
		{
			if($category == "POP") $bn_pop1 = $sky_arr[$i]->fcstValue; //강수확율 %
			if($category == "PTY") $bn_pty1 = $sky_arr[$i]->fcstValue; //강수형태 (없음(0), 비(1), 비/눈(2), 눈(3))
			if($category == "SKY") $bn_sky1 = $sky_arr[$i]->fcstValue;
			if($category == "VEC") $bn_vec1 = $sky_arr[$i]->fcstValue;
			if($category == "WSD") $bn_wsd1 = $sky_arr[$i]->fcstValue;
			if($category == "WAV") $bn_wav1 = $sky_arr[$i]->fcstValue;
		}
		if($fcsttime == "1200")
		{
			if($category == "POP") $an_pop1 = $sky_arr[$i]->fcstValue; //강수확율 %
			if($category == "PTY") $an_pty1 = $sky_arr[$i]->fcstValue; //강수형태 (없음(0), 비(1), 비/눈(2), 눈(3))
			if($category == "SKY") $an_sky1 = $sky_arr[$i]->fcstValue;
			if($category == "VEC") $an_vec1 = $sky_arr[$i]->fcstValue;
			if($category == "WSD") $an_wsd1 = $sky_arr[$i]->fcstValue;
			if($category == "WAV") $an_wav1 = $sky_arr[$i]->fcstValue;
		}
	}
	else if($fcstdate == $day2)
	{
		if($fcsttime == "0000")
		{
			if($category == "POP") $bn_pop2 = $sky_arr[$i]->fcstValue; //강수확율 %
			if($category == "PTY") $bn_pty2 = $sky_arr[$i]->fcstValue; //강수형태 (없음(0), 비(1), 비/눈(2), 눈(3))
			if($category == "SKY") $bn_sky2 = $sky_arr[$i]->fcstValue;
			if($category == "VEC") $bn_vec2 = $sky_arr[$i]->fcstValue;
			if($category == "WSD") $bn_wsd2 = $sky_arr[$i]->fcstValue;
			if($category == "WAV") $bn_wav2 = $sky_arr[$i]->fcstValue;
		}
		if($fcsttime == "1200")
		{
			if($category == "POP") $an_pop2 = $sky_arr[$i]->fcstValue; //강수확율 %
			if($category == "PTY") $an_pty2 = $sky_arr[$i]->fcstValue; //강수형태 (없음(0), 비(1), 비/눈(2), 눈(3))
			if($category == "SKY") $an_sky2 = $sky_arr[$i]->fcstValue;
			if($category == "VEC") $an_vec2 = $sky_arr[$i]->fcstValue;
			if($category == "WSD") $an_wsd2 = $sky_arr[$i]->fcstValue;
			if($category == "WAV") $an_wav2 = $sky_arr[$i]->fcstValue;
		}
	}
}
//하늘상태 맑음(1), 구름조금(2), 구름많음(3), 흐림(4)
switch($bn_sky)
{
	case("1") : $bn_sky = "맑음" ; break;
	case("2") : $bn_sky = "구름조금" ; break;
	case("3") : $bn_sky = "구름많음" ; break;
	case("4") : $bn_sky = "흐림" ; break;
}
switch($an_sky)
{
	case("1") : $an_sky = "맑음" ; break;
	case("2") : $an_sky = "구름조금" ; break;
	case("3") : $an_sky = "구름많음" ; break;
	case("4") : $an_sky = "흐림" ; break;
}
switch($bn_sky1)
{
	case("1") : $bn_sky1 = "맑음" ; break;
	case("2") : $bn_sky1 = "구름조금" ; break;
	case("3") : $bn_sky1 = "구름많음" ; break;
	case("4") : $bn_sky1 = "흐림" ; break;
}
switch($an_sky1)
{
	case("1") : $an_sky1 = "맑음" ; break;
	case("2") : $an_sky1 = "구름조금" ; break;
	case("3") : $an_sky1 = "구름많음" ; break;
	case("4") : $an_sky1 = "흐림" ; break;
}
switch($bn_sky2)
{
	case("1") : $bn_sky2 = "맑음" ; break;
	case("2") : $bn_sky2 = "구름조금" ; break;
	case("3") : $bn_sky2 = "구름많음" ; break;
	case("4") : $bn_sky2 = "흐림" ; break;
}
switch($an_sky2)
{
	case("1") : $an_sky2 = "맑음" ; break;
	case("2") : $an_sky2 = "구름조금" ; break;
	case("3") : $an_sky2 = "구름많음" ; break;
	case("4") : $an_sky2 = "흐림" ; break;
}

$today_w = "오전 ".$bn_sky.", 오후 ".$an_sky;
$today_ws = "오전 ".$bn_wsd."m/s, 오후 ".$an_wsd."m/s";
$today_t = "오전 ".$bn_wav."m, 오후 ".$an_wav."m";

$day1_w = "오전 ".$bn_sky1.", 오후 ".$an_sky1;
$day1_ws = "오전 ".$bn_wsd1."m/s, 오후 ".$an_wsd1."m/s";
$day1_t = "오전 ".$bn_wav1."m, 오후 ".$an_wav1."m";

$day2_w = "오전 ".$bn_sky2.", 오후 ".$an_sky2;
$day2_ws = "오전 ".$bn_wsd2."m/s, 오후 ".$an_wsd2."m/s";
$day2_t = "오전 ".$bn_wav2."m, 오후 ".$an_wav2."m";

$day0_arr = array("ymd"=>$today, "w"=>$today_w,	"ws"=>$today_ws,"t"=>$today_t);
$day1_arr = array("ymd"=>$day1, "w"=>$day1_w,	"ws"=>$day1_ws,"t"=>$day1_t);
$day2_arr = array("ymd"=>$day2, "w"=>$day2_w,	"ws"=>$day2_ws,"t"=>$day2_t);


// 기준시간
$baseTime = "0600";
if(date('H') > 18) $baseTime = "1800";
$baseYmdTimd = date('Ymd').$baseTime;

$ch = curl_init();
$url = 'http://newsky2.kma.go.kr/service/MiddleFrcstInfoService/getMiddleSeaWeather'; /*URL*/
$queryParams = '?' . urlencode('ServiceKey') . '=xhmSUu8fvPZ44%2Fexc5AdXRaB6SJ1TgjBYT2zadG%2FXbQcS%2FaEthNHuWdGUlOrTZgDcTtl5hS3mWfRpG9A82rlvg%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('ServiceKey') . '=' . urlencode('xhmSUu8fvPZ44%2Fexc5AdXRaB6SJ1TgjBYT2zadG%2FXbQcS%2FaEthNHuWdGUlOrTZgDcTtl5hS3mWfRpG9A82rlvg%3D%3D'); /*서비스 인증 번호*/
$queryParams .= '&' . urlencode('regId') . '=' . urlencode('12A20000'); /*지역코드 - 하단 참고자료 참조*/
$queryParams .= '&' . urlencode('tmFc') . '=' . urlencode($baseYmdTimd); /*-일 2회((06:00,18:00)회 생성 되며 발표시각을 입력 -최근 24시간 자료만 제공 */
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('100'); /*한 페이지 결과 수*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /*페이지 번호*/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);
curl_close($ch);

$object = simplexml_load_string($response);
$channel = $object->channel;

foreach($channel->item as $value) {
	$title = $value->title;
	$description = $value->description;
	$link = $value->link;
}

$midtermFcst = $object->body->items->item;
for($i=3; $i<11; $i++)
{
	$dayname = $i." day";
	$day = date('Ymd',strtotime($dayname));

	if($i < 8)
	{
		$wAmIndex = "wf".$i."Am";
		$wPmIndex = "wf".$i."Pm";
		$tAmIndex = "wh".$i."AAm";
		$tPmIndex = "wh".$i."APm";
	}
	else
	{
		$wAmIndex = "wf".$i;
		$wPmIndex = "wf".$i;
		$tAmIndex = "wh".$i."AAm";
		$tPmIndex = "wh".$i."APm";
	}

	$wAm = $midtermFcst->$wAmIndex;
	$wPm = $midtermFcst->$wPmIndex;
	$tAm = $midtermFcst->$tAmIndex;
	$tPm = $midtermFcst->$tPmIndex;

	if($i < 8)
	{
		$day_w = "오전 ".$wAm.", 오후 ".$wPm;
		$day_ws = " - ";
		$day_t = " - ";
	}
	else
	{
		$day_w = $wAm;
		$day_ws = " - ";
		$day_t = " - ";
	}

	$dayarrAlias = "day".$i."_arr";
	$$dayarrAlias = array("ymd"=>$day, "w"=>$day_w,	"ws"=>$day_ws, "t"=>$day_t);
}

$day0=$today;
$weather_arr = array(
	array(
		$day0=>$day0_arr, 
		$day1=>$day1_arr, 
		$day2=>$day2_arr, 
		$day3=>$day3_arr, 
		$day4=>$day4_arr, 
		$day5=>$day5_arr, 
		$day6=>$day6_arr, 
		$day7=>$day7_arr, 
		$day8=>$day8_arr, 
		$day9=>$day9_arr, 
		$day10=>$day10_arr 
	)
);
print_r2($weather_arr[0]);
for($i=0; $i<12;$i++)
{
	$_ymd == "";
	$dayName = "day".$i;
	$_ymd = $weather_arr[0][$$dayName]["ymd"];
	$_wav = $weather_arr[0][$$dayName]["t"];
	echo $_ymd; 
	echo $_wav; 

}

?>