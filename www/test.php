<?php
include_once('./_common.php');
/*
$aaa = "2017년 11월 24일 (화)요일 17:00발표";

$bbb = mb_substr($aaa,0,19);
echo $bbb; echo "<br>";
$ccc = mb_substr(trim($aaa),0,4);
echo $ccc; echo "<br>";
$ddd = mb_substr(trim($aaa),6,2);
echo $ddd; echo "<br>";

$eee = mb_substr(trim($aaa),10,2);
echo $eee; echo "<br>";


$poll_edate = strtotime("20170919");
$edate = date("Ymd", strtotime("+11 day",$poll_edate));
echo $edate; echo "<br>";


$seaArr = explode("|",$config[cf_sea_area]);
$topArea = $seaArr[0];
$midArea = $seaArr[1];
$btmArea = $seaArr[2];
echo $_SERVER[HTTP_HOST];
*/

/*
	$firstday = date(Ymd);
	$firstdayUnix = strtotime($firstday);
	$_plusday = "+2 day"; 
	$targetday = date("Ymd", strtotime($_plusday,$firstdayUnix)); 

//$targetday = "20180708";
			$wday_Y = substr($targetday,0,4); 
			$wday_M = substr($targetday,4,2); 
			$wday_D = substr($targetday,6,2); 
echo $targetday."<br>";
echo $wday_Y."<br>";
echo $wday_M."<br>";
echo $wday_D."<br>";
*/

/*
$subject = "coding everybody http://naver.com misgradu@naver.com 010-0000-0000 라자다/이베이 중급강의";
preg_match('~(http:\/\/\w+\.\w+)\s(\w+@\w+\.\w+)~',$subject,$match);
print_r2($match);

echo "homepage : ".$match[1];
echo "<br>";
echo "email : ".$match[2];
echo "<br><br>";

$subject = "wdasdfasdfasdf who is wdo";
preg_match_all('@^wd+@i',$subject,$match);
print_r2($match);
*/

/*
$last_month_start = new DateTime("first day of -2 month");
$last_month_end = new DateTime("last day of -2 month");
$next_month_start = new DateTime("first day of +3 month");
$next_month_end = new DateTime("last day of +3 month");

echo $last_month_start->format('Y-m-d'); // 2012-02-01
echo "<br>"; // 2012-02-01
echo $last_month_end->format('Y-m-d'); // 2012-02-29
echo "<br>"; // 2012-02-01
echo $next_month_start->format('Y-m-d'); // 2012-02-01
echo "<br>"; // 2012-02-01
echo $next_month_end->format('Y-m-d'); // 2012-02-29
echo "<br>2222"; // 2012-02-01
*/

$sql = " select * from m_bookdata where (1) ";
$result = sql_query($sql);
for($i=0;$row=sql_fetch_array($result);$i++) {

    $sql2 = " select * from m_schedule where s_idx='{$row['s_idx']}' and sc_ymd = '{$row['bk_ymd']}' ";
    $result2 = sql_query($sql2);

    for($j=0;$row2=sql_fetch_array($result2);$j++) {

        sql_query(" update m_bookdata set sc_idx='{$row2['sc_idx']}' where bk_idx='{$row['bk_idx']}' ");

    }
}

// 깃헙자동배포 테스트
// 깃헙자동배포 테스트 두개 사이트 확인

?>