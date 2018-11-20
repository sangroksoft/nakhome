<?php
include_once('./_common.php');

$returnVal = "";
/* // api로넘어온 데이터
$_data = array();
$_data["s_uidx"] = $s_uidx;
$_data["bk_channel_mb_id"] = $member[mb_id];
$_data["bk_idx"] = $bk[bk_idx];
$arr = array();
$arr[com_uidx]   = $bk[com_uidx];
$arr[sdom]        = $bk[sdom];
$arr[data]	       = $_data;
*/

$outsiteurl = "https://monak.co.kr";
$com_uidx = $_POST[com_uidx];
if(!$com_uidx || $com_uidx=="") {
	$errorstr = "예약 파라미터값 오류-001.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 

$data = $_POST[data];

$bk_idx = $data[bk_idx];
if(!$bk_idx || $bk_idx=="") {
	$errorstr = "예약 파라미터값 오류-004.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_channel_mb_id = $data[bk_channel_mb_id];
if(!$bk_channel_mb_id || $bk_channel_mb_id=="") {
	$errorstr = "예약 파라미터값 오류-007.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 

if($com_uidx != $comfig[com_uidx]) {
	$errorstr = "선사코드불일치 오류.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 

// ********에러검증 시작 ************//
$bk_idx =  preg_replace('/[^0-9]/', '', $bk_idx);
if(!$bk_idx || $bk_idx < 1)
{
	$errorstr = "예약키값 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
if(!$bk['bk_idx'])
{
	$errorstr = "존재하지 않는 예약입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($bk['bk_channel_mb_id'] != $bk_channel_mb_id)
{
	$errorstr = "비정상적인 접근입니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$s_idx = $bk['s_idx'];
$bk_ymd = $bk['bk_ymd'];
$bk_status = $bk['bk_status'];

// 예약상태체크
if($bk_status == "-1" || $bk_status == "-2")
{
	$errorstr = "이미 취소된 예약입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

if($bk_status == "0") { $cancelSql = " bk_status = '-1', cancel_datetime='".G5_TIME_YMDHIS."' "; $api_bk_status = "-1";  }
if($bk_status == "1") { $cancelSql = " bk_status = '-2', cancel_datetime='".G5_TIME_YMDHIS."' "; $api_bk_status = "-2";  }

// 예약취소
sql_query(" update m_bookdata set $cancelSql where bk_idx='{$bk_idx}'  ");

$returnVal = json_encode(
	array(
		"rslt"=>"ok"
	)
);
echo $returnVal; exit; 


?>