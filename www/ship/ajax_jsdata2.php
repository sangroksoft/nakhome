<?php
include_once('./_common.php');
$returnVal = "";

if($_GET[sc_ymd]) // 어선선택으로 들어온경우
{
	$sc_ymd = trim($_GET[sc_ymd]);
	$sc_ymd = (int)preg_replace('/[^0-9]/', '', $sc_ymd);
	if(!$sc_ymd || $sc_ymd < 20000101 || $sc_ymd > 20501231) $sc_ymd = date("Ymd");
	//날짜자리수체크
	if (strlen($sc_ymd) != 8) $sc_ymd = date("Ymd");

	// 개별날짜 추출
	$cy = substr($sc_ymd,0,4);
	$cm = substr($sc_ymd,4,2);
	$cd = "01";
	$cymd = $cy.$cm.$cd;
}
else if($_GET[cy] && $_GET[cm]) // 날짜선택으로 들어온 경우
{
	$cy = $_GET[cy];
	$cm = $_GET[cm];
	$cd = "01";
	$cymd = $cy.$cm.$cd;
	if (!$cymd || strlen($cymd) != 8) $cymd = date("Ymd");
}
else
{
	$cy = date("Y");
	$cm = date("m");
	$cd = "01";
	$cymd = date("Ymd");
}

//===================== 달력정보가져옴 ========================
$s_idx = (int)preg_replace('/[^0-9]/', '', $_GET[s_idx]);
if(!$s_idx || $s_idx < 1 )
{
	$errorstr = "어선 키값 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
$ship = sql_fetch(" select * from m_ship where s_idx = '{$s_idx}' ");
if(!$ship[s_idx]) 
{
	$errorstr = "존재하지 않는 어선입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$sql = " select * from m_schedule where s_idx='{$s_idx}' and  sc_y='{$cy}' and sc_m='{$cm}' ";
$result = sql_query($sql);
$sccnt = sql_num_rows($result);

$lastday = date('t', strtotime($cymd));
$data_arr=array();

if($sccnt > 0)
{
	for($i=0;$row=sql_fetch_array($result);$i++) {
		$_day = $row[sc_d];
		$aKey = $cm."-".$_day."-".$cy;
		$rowYmd = $cy."-".$cm."-".$_day;

		$lunarArr = getLunarDate($cy, $cm, $_day);
		$tidenum = $lunarArr[3];
		if($comfig[tide] == "7")
			$tideName = $tideArr_w[$tidenum];
		else if($comfig[tide] == "8")
			$tideName = $tideArr_es[$tidenum];

		$available = $row[sc_max] - $row[sc_booked]."명";
		$availableTxt = "예약가능";

		$notavail = "";
		if($row[sc_status] != "0") 
		{
			$notavail = " scend";
			$available = "마감";
			$availableTxt = "마감";
		}
		if($row[sc_max] - $row[sc_booked] == "0") 
		{
			$notavail = " scend";
			$available = "마감";
			$availableTxt = "마감";
		}
		if($rowYmd < G5_TIME_YMD) 
		{
			$notavail = "";
			$available = "";
			$availableTxt = "";
		}

		$aVal = "<span class='lunartide'>";
		$aVal .= $tideName;
		$aVal .= "</span>";
		$aVal .= "<span>";
		$aVal .= "<span class='availcnt ".$notavail."'>";
		$aVal .= $available;
		$aVal .= "</span>";
		$aVal .= "<span class='availtxt off".$notavail."'>";
		$aVal .= $availableTxt;
		$aVal .= "</span>";
		$aVal .= "</span>";

		$newArr = array($aKey => $aVal);
		$data_arr = array_merge($data_arr,$newArr);
	}
}
else
{
	for($i=0;$i<$lastday;$i++) {
		$_day = $i+1;
		if($_day < 10) $_day = "0".$_day;

		$aKey = $cm."-".$_day."-".$cy;
		$rowYmd = $cy."-".$cm."-".$_day;

		$lunarArr = getLunarDate($cy, $cm, $_day);
		$tidenum = $lunarArr[3];
		if($comfig[tide] == "7")
			$tideName = $tideArr_w[$tidenum];
		else if($comfig[tide] == "8")
			$tideName = $tideArr_es[$tidenum];

		$available = "";
		$availableTxt = "";
		$notavail = " notavail";
		if($rowYmd < G5_TIME_YMD) 
		{
			$notavail = "";
		}

		$aVal = "<span class='lunartide'>";
		$aVal .= $tideName;
		$aVal .= "</span>";
		$aVal .= "<span>";
		$aVal .= "<span class='availcnt ".$notavail."'>";
		$aVal .= $available;
		$aVal .= "</span>";
		$aVal .= "<span class='availtxt off".$notavail."'>";
		$aVal .= $availableTxt;
		$aVal .= "</span>";
		$aVal .= "</span>";

		$newArr = array($aKey => $aVal);
		$data_arr = array_merge($data_arr,$newArr);
	}
}
//$data_arr = "";

$returnVal = json_encode(
	array(
		"data_arr" => $data_arr
	)
);

echo $returnVal;
?>

