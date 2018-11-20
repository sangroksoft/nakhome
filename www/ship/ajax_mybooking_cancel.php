<?php
include_once('./_common.php');

$returnVal = "";

if(!$is_member)
{
	$errorstr = "로그인 후 이용하실 수 있습니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// ********에러검증 시작 ************//
$bk_idx = $_POST['bk_idx'];
$bk_idx =  preg_replace('/[^0-9]/', '', $bk_idx);
if(!$bk_idx || $bk_idx < 1)
{
	$errorstr = "예약키값 오류입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
if(!$bk['bk_idx'])
{
	$errorstr = "존재하지 않는 예약입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($bk['bk_mb_id'] != $member[mb_id])
{
	$errorstr = "비정상적인 접근입니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$s_idx = $bk['s_idx'];
$bk_ymd = $bk['bk_ymd'];
$bk_status = $bk['bk_status'];

// 예약상태체크
if($bk_status == "-1")
{
	$errorstr = "이미 취소된 예약입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($bk_status == "-2")
{
	$errorstr = "이미 취소신청된 예약입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

if($bk_status == "0") { // 예약접수상태인경우 바로 예약취소처리(-1)
    $cancelSql = " bk_status = '-1', cancel_datetime='".G5_TIME_YMDHIS."' "; $api_bk_status = "-1";  
}
if($bk_status == "1") {  // 예약완료상태인경우 예약취소신청 처리(-2)
    $cancelSql = " bk_status = '-2', cancel_datetime='".G5_TIME_YMDHIS."' "; $api_bk_status = "-2";  
}

// 예약취소(신청)
sql_query(" update m_bookdata set $cancelSql where bk_idx='{$bk_idx}'  ");

//===== API 실행 ======
// 모낚에서 예약한 건만 취급하기 때문에 낚홈에서 예약한 건은 모낚으로 전송안함.
/*
$_data = array();
$_data["bk_idx"] = $bk_idx;
$_data["bk_status"] = $api_bk_status;

$arr = array();
$arr[com_uidx]   = $comfig[com_uidx];
$arr[data]	       = $_data;

$curlData = http_build_query($arr);
$curlUrl = "http://monak.kr/api/_bk_user_cancel.php";
curl_api($curlUrl, $curlData);
*/
//===== API 종료 ======

$returnVal = json_encode(
	array(
		"rslt"=>"ok"
	)
);
echo $returnVal; exit; 

?>