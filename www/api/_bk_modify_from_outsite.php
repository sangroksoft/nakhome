<?php
include_once('./_common.php');

$returnVal = "";
/* // api로넘어온 데이터
$_data = array();
$_data["s_uidx"] = $s_uidx;
$_data["bk_idx"] = $bk[bk_idx];
$_data["_bk_price"] = $_bk_price;
$_data["bk_banker"] = $bk_banker;
$_data["bk_tel"] = $bk_tel;
$_data["bk_member_cnt"] = $bk_member_cnt;
$arr = array();
$arr[com_uidx]   = $ship[com_uidx];
$arr[sdom]        = $ship[sdom];
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
$s_uidx = $data[s_uidx];
if(!$s_uidx || $s_uidx=="") {
	$errorstr = "예약 파라미터값 오류-003.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
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
$bk_reward_use = $data[bk_reward_use];
$bk_banker = $data[bk_banker];
if(!$bk_banker || $bk_banker=="") {
	$errorstr = "예약 파라미터값 오류-009.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_tel = $data[bk_tel];
if(!$bk_tel || $bk_tel=="") {
	$errorstr = "예약 파라미터값 오류-010.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_member_cnt = $data[bk_member_cnt];
if(!$bk_member_cnt || $bk_member_cnt=="") {
	$errorstr = "예약 파라미터값 오류-011.";
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
if($bk_status != "0")
{
	$errorstr = "예약완료 또는 취소된 예약은 수정할 수 없습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 예약인원
$bk_member_cnt = (int)preg_replace('/[^0-9-]/', '', $bk_member_cnt);
if($bk_member_cnt < 1)
{
	$errorstr = "예약인원을 정확히 선택하십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 입금자명
$bk_banker = clean_xss_tags(trim($bk_banker));
if(!$bk_banker || $bk_banker == "")
{
	$errorstr = "예약자명을 입력하세요.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 예약자 핸드폰번호
$bk_tel = clean_xss_tags(trim($bk_tel));
$bk_tel = preg_replace("/[^0-9]/", "", $bk_tel);
if(!$bk_tel)
{
	$errorstr = "휴대폰번호를 입력해 주십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
else 
{
	if(!preg_match("/^01[0-9]{8,9}$/", $bk_tel))
	{
		$errorstr = "휴대폰번호를 올바르게 입력해 주십시오.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
}

$sc = sql_fetch(" select sc_desc from m_schedule where s_idx='{$s_idx}' and sc_ymd='{$bk_ymd}' ");

// 1인당 출조비용
$bk_price = $bk[bk_price];
$bk_price = (int)preg_replace('/[^0-9]/', '', $bk_price);
if(!$bk_price || $bk_price < 1)
{
	$errorstr = "출조비용오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 전체 출조비용
$bk_price_total = $bk_price * $bk_member_cnt;

// 예약내용 업데이트
sql_query(" update m_bookdata 
				set bk_member_cnt = '{$bk_member_cnt}', 
					 bk_reward_use = '{$bk_reward_use}', 
					 bk_price = '{$bk_price}', 
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}'
				 where bk_idx='{$bk_idx}'  ");

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"bk_idx"=>$bk_idx,
		"bk_price"=>$bk_price,
		"bk_price_total"=>$bk_price_total,
		"sc_desc"=>$sc[sc_desc]
	)
);

echo $returnVal; 	exit;

?>