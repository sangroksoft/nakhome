<?php
include_once('./_common.php');

$returnVal = "";

if (!$_GET['ymd'] || $_GET['ymd'] < date("Ymd")) $ymd = date("Ymd");
else {
	$ymdTmp = $_GET['ymd'];
	$ymdTmp = substr($ymdTmp,0,6);
	$ymd = $ymdTmp."01";
}

$cy = substr($ymd,0,4);
$cm = substr($ymd,4,2);
$cd = substr($ymd,6,2);
$d = (int)$cd;

$cym = $cy.$cm;
$cymd = $cy.$cm.$cd;

if (!$cymd || strlen($cymd) != 8) {
	$cymd = date("Ymd");
	$fymd = date("Ymd");
} else {
	if ($cymd <= date("Ymd")) {
		$fymd = date("Ymd");
	} else {
		if (!$_GET['fymd']) $fymd = $cym."01";
		else $fymd = $_GET['fymd'];
	}
}
$fd = substr($fymd,6,2);
$fd = (int)$fd;
$fd = $fd-1;

$lastday = date('t', strtotime($cymd));


/*

$last_month_start = new DateTime("first day of -1 month");
$last_month_end = new DateTime("last day of -1 month");
$next_month_start = new DateTime("first day of +1 month");
$next_month_end = new DateTime("last day of +1 month");

*/

$month_firstday = strtotime(date($cymd, time()));
$prevMonth = date('Ymd', strtotime('-1 Month', $month_firstday));
$prevMonth = substr($prevMonth,0,6)."01";
$prevMonthFymd = substr($prevMonth,0,6)."01";

$nextMonth = date('Ymd', strtotime('+1 Month', $month_firstday));
$nextMonth = substr($nextMonth,0,6)."01";
$nextMonthFymd = substr($nextMonth,0,6)."01";

$curmonth_firstday = strtotime(date("Ymd", time()));
$moveLimit = date('Ymd', strtotime('+12 Month', $curmonth_firstday));
if($cymd > $moveLimit) {
	$errorstr = "12개월 이내 출조일정만 검색가능합니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$calArrowPrev = "cal-arrow";
if($prevMonth < $cymd) $calArrowPrev = "cal-arrow";
$calArrowNext = "cal-arrow";
if($nextMonth < $cymd) $calArrowNext = "cal-arrow";

ob_start();
include './ajax_get_bk_diary_skin.php'; 
$content = ob_get_contents();
ob_end_clean();

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"ymd" => $cymd,
		"fymd" => $fymd,
		"slideidx" => $fd,
		"cont" => $content
	)
);

echo $returnVal;
?>
