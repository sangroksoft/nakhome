<?php
include_once('./_common.php');
$returnVal = "";

$sccnt =  trim($_POST["sccnt"]);
$basetime =  trim($_POST["basetimestr"]);

$y = mb_substr(trim($basetime),0,4);
$m = mb_substr(trim($basetime),6,2);
$d = mb_substr(trim($basetime),10,2);

$firstday = $y.$m.$d;
$firstdayUnix = strtotime($firstday);

sql_query(" delete from m_fcst where (1) ");

for($i=0;$i<$sccnt;$i++)
{
	$vals = trim($_POST["fc".$i]);
	$valsArr = explode("|",$vals);

	if($sccnt == 18)
	{
		if($i==0) $ymd = $firstday;
		else if($i==1 || $i==2) { $ymd = date("Ymd", strtotime("+1 day",$firstdayUnix)); }
		else if($i==3 || $i==4) { $ymd = date("Ymd", strtotime("+2 day",$firstdayUnix)); }
		else if($i==5 || $i==6) { $ymd = date("Ymd", strtotime("+3 day",$firstdayUnix)); }
		else if($i==7 || $i==8) { $ymd = date("Ymd", strtotime("+4 day",$firstdayUnix)); }
		else if($i==9 || $i==10) { $ymd = date("Ymd", strtotime("+5 day",$firstdayUnix)); }
		else if($i==11 || $i==12) { $ymd = date("Ymd", strtotime("+6 day",$firstdayUnix)); }
		else if($i==13 || $i==14) { $ymd = date("Ymd", strtotime("+7 day",$firstdayUnix)); }
		else if($i==15) { $ymd = date("Ymd", strtotime("+8 day",$firstdayUnix)); }
		else if($i==16) { $ymd = date("Ymd", strtotime("+9 day",$firstdayUnix)); }
		else if($i==17) { $ymd = date("Ymd", strtotime("+10 day",$firstdayUnix)); }
	}
	else if($sccnt == 19)
	{
		if($i==0 || $i==1) $ymd = $firstday;
		else if($i==2 || $i==3) { $ymd = date("Ymd", strtotime("+1 day",$firstdayUnix)); }
		else if($i==4 || $i==5) { $ymd = date("Ymd", strtotime("+2 day",$firstdayUnix)); }
		else if($i==6 || $i==7) { $ymd = date("Ymd", strtotime("+3 day",$firstdayUnix)); }
		else if($i==8 || $i==9) { $ymd = date("Ymd", strtotime("+4 day",$firstdayUnix)); }
		else if($i==10 || $i==11) { $ymd = date("Ymd", strtotime("+5 day",$firstdayUnix)); }
		else if($i==12 || $i==13) { $ymd = date("Ymd", strtotime("+6 day",$firstdayUnix)); }
		else if($i==14 || $i==15) { $ymd = date("Ymd", strtotime("+7 day",$firstdayUnix)); }
		else if($i==16) { $ymd = date("Ymd", strtotime("+8 day",$firstdayUnix)); }
		else if($i==17) { $ymd = date("Ymd", strtotime("+9 day",$firstdayUnix)); }
		else if($i==18) { $ymd = date("Ymd", strtotime("+10 day",$firstdayUnix)); }
	}

	$dayb = $valsArr[1];
	$sky = $valsArr[2];
	$wv = $valsArr[3];
	$wd = $valsArr[4];
	$ws = $valsArr[5];
	$wicon = $valsArr[6];

	// 정보 업데이트
	$sql = " insert into m_fcst 
			 set ymd = '{$ymd}', 
				 basetime = '{$basetime}', 
				 dayb = '{$dayb}', 
				 sky = '{$sky}', 
				 wv = '{$wv}', 
				 wd = '{$wd}', 
				 ws = '{$ws}',
				 wicon = '{$wicon}',
				 lastupdate = '".G5_TIME_YMDHIS."' ";
	sql_query($sql);
}

$returnVal = json_encode(
	array(
		"rslt"=>"ok"
	)
);

echo $returnVal;
?>
