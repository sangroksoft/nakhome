<?php
include_once('./_common.php');

$returnVal = "";
/* // api로넘어온 데이터
$dataTmp = array();
$dataTmp[s_uidx] = $s_uidx;
$dataTmp[_bk_idx] = $_bk_idx;
$dataTmp[bk_idx] = $bk_idx;
$dataTmp[bk_channel_mb_id] = $bk_channel_mb_id;
$dataTmp[bk_status] = $new_bk_status;
$dataTmp[pay_amount] = $pay_amount;
$_dataArr[] = $dataTmp;
$arr = array();
$arr[com_uidx]   = $comfig[com_uidx];
$arr[data]	       = $_dataArr;
*/

$com_uidx = $_POST[com_uidx];
if(!$com_uidx || $com_uidx=="") {
	$errorstr = "예약 파라미터값 오류-001.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 

$data = $_POST[data];
$_bk_idx = $data[0][_bk_idx];

if(!$_bk_idx || $_bk_idx=="") {
	$errorstr = "예약 파라미터값 오류-002.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$s_uidx = $data[0][s_uidx];
if(!$s_uidx || $s_uidx=="") {
	$errorstr = "예약 파라미터값 오류-003.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_idx = $data[0][bk_idx];
if(!$bk_idx || $bk_idx=="") {
	$errorstr = "예약 파라미터값 오류-004.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 

$bk_channel_mb_id = $data[0][bk_channel_mb_id];
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
	$errorstr = "존재하지 않는 예약입니다1.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
/*
if($bk['_bk_idx'] != $_bk_idx)
{
	$errorstr = "존재하지 않는 예약입니다2.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
*/
if($bk['bk_channel_mb_id'] != $bk_channel_mb_id)
{
	$errorstr = "비정상적인 접근입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$s_idx = $bk['s_idx'];
$bk_ymd = $bk['bk_ymd'];
$ori_bk_status = $bk['bk_status'];
$new_bk_status = $data[0]['bk_status'];

if(!($new_bk_status == "-1" || $new_bk_status == "0" || $new_bk_status == "1"))
{
	$errorstr = "예약상태 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}


$bkcntFetch = sql_fetch(" select ifnull(sum(bk_member_cnt), 0) as bkmemcnt from m_bookdata where s_idx = '{$s_idx}' and bk_ymd='{$bk_ymd}' and (bk_status = '-2' or bk_status = '1') ");
$bkmemcnt = $bkcntFetch['bkmemcnt'];
$bkmemcnt_tot = $bk[bk_member_cnt]+$bkcntFetch['bkmemcnt'];
$ori_bk_member_cnt = $bk[bk_member_cnt];

$sc = sql_fetch(" select sc_max from m_schedule where s_idx = '{$s_idx}' and sc_ymd='{$bk_ymd}' ");

if($new_bk_status != $ori_bk_status)
{
	if($ori_bk_status == "0")
	{
		if($new_bk_status == "1")
		{
			if($bkmemcnt_tot > $sc[sc_max]) 
			{
				$errorstr = " 예약인원이 초과되어 예약완료를 할수 없습니다.";
				$errorurl = "";
				$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
			}
		}
	}
}

$bkSql = "";
$scSql = "";

$pay_amount = (int)preg_replace('/[^0-9-]/', '', $data[0][pay_amount]); // 마이너스금액 또는 0원도 있을수 있으므로 검증안함.

if($new_bk_status != $ori_bk_status)
{
	if($ori_bk_status == "-2") // 기존예약상태가 예약취소요청
	{
		if($new_bk_status == "-1") // 예약취소로 변경하는 경우
		{
			$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '".G5_TIME_YMDHIS."' ";
			$scSql = " sc_booked = sc_booked - $ori_bk_member_cnt ";
		}
		else if($new_bk_status == "1") // 예약완료로 변경하는 경우
		{
			$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '' ";
		}
	}
	else if($ori_bk_status == "0") // 기존예약상태가 예약접수
	{
		if($new_bk_status == "-1") // 예약취소로 변경하는 경우
		{
			$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '".G5_TIME_YMDHIS."' ";
		}
		else if($new_bk_status == "1") // 예약완료로 변경하는 경우
		{
			$bkSql = " , bk_status='{$new_bk_status}' ";
			$scSql = " sc_booked = sc_booked + $ori_bk_member_cnt ";
		}
	}
	else if($ori_bk_status == "1") // 기존예약상태가 예약완료
	{
		if($new_bk_status == "-1") // 예약취소로 변경하는 경우
		{
			$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '".G5_TIME_YMDHIS."' ";
			$scSql = " sc_booked = sc_booked - $ori_bk_member_cnt ";
		}
	}
}

sql_query(" update m_bookdata set pay_amount = '{$pay_amount}' $bkSql where bk_idx = '{$bk_idx}'  ");
if($scSql != "") sql_query(" update m_schedule set $scSql where s_idx='{$s_idx}' and sc_ymd = '{$bk_ymd}'  ");

$returnVal = json_encode(
	array(
		"rslt"=>"ok"
	)
);

echo $returnVal; 	exit;

?>