<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$returnVal = "";
//$returnVal = json_encode($_POST);

/* // api로넘어온 데이터
$_data = array();
$_data["s_uidx"] = $ship[s_uidx];
$_data["bk_ymd"] = $bk_ymd;
$_data["bk_status"] = "0";
$_data["p_idx"] = $p_idx;
$_data["bk_channel"] = "monak";
$_data["bk_channel_mb_id"] = $mb_id;
$_data["bk_channel_mb_name"] = $mb_name;
$_data["bk_reward_use"] = $bk_reward_use;
$_data["bk_mb_id"] = "temp_member";
$_data["bk_mb_name"] = $bk_banker;
$_data["bk_banker"] = $bk_banker;
$_data["bk_tel"] = $bk_tel;
$_data["bk_member_cnt"] = $bk_member_cnt;
$arr = array();
$arr[com_uidx]   = $ship[com_uidx];
$arr[sdom]        = $ship[sdom];
$arr[data]	       = $_data;
*/

// 어선 체크
// 어선 예약가능여부 체크(현재 예약가능인원수 초과여부)
// 예약일 체크
// 예약일 예약가능여부 체크
// 예약인원체크
// 출조비용체크
// 출조제목체크
// 예약자명 체크
// 예약자 연락처 체크
// 기타사항체크

$outsiteurl = "https://monak.co.kr";
$com_uidx = $_POST[com_uidx];
if(!$com_uidx || $com_uidx=="") {
	$errorstr = "예약 파라미터값 오류-001.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
/*
$sdom = $data[sdom];
if(!$sdom || $sdom=="") {
	$errorstr = "예약 파라미터값 오류-002.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
*/
$data = $_POST[data];
$s_uidx = $data[s_uidx];
if(!$s_uidx || $s_uidx=="") {
	$errorstr = "예약 파라미터값 오류-003.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_ymd = $data[bk_ymd];
if(!$bk_ymd || $bk_ymd=="") {
	$errorstr = "예약 파라미터값 오류-004.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_channel = $data[bk_channel];
if(!$bk_channel || $bk_channel=="") {
	$errorstr = "예약 파라미터값 오류-006.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_channel_mb_id = $data[bk_channel_mb_id];
if(!$bk_channel_mb_id || $bk_channel_mb_id=="") {
	$errorstr = "예약 파라미터값 오류-007.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 
$bk_channel_mb_name = $data[bk_channel_mb_name];
if(!$bk_channel_mb_name || $bk_channel_mb_name=="") {
	$errorstr = "예약 파라미터값 오류-008.";
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
$bk_mb_id = "temp_member";
$bk_mb_name = $bk_banker;
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
$_bk_price = $data[_bk_price];
if(!$_bk_price || $_bk_price=="" || $_bk_price < 0) {
	$errorstr = "예약 파라미터값 오류-012.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 


if($com_uidx != $comfig[com_uidx]) {
	$errorstr = "선사코드불일치 오류.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} 

//===================== 어선정보가져옴 ========================
$ship = sql_fetch(" select * from m_ship where s_uidx = '{$s_uidx}' ");
if(!$ship[s_idx]) 
{
	$errorstr = "존재하지 않는 어선입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($ship[s_expose] != "y") 
{
	$errorstr = "현재 해당 어선은 예약하실 수 없습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$s_idx = $ship[s_idx];
$s_name = get_text($ship[s_name]);
//===================== 어선정보가져옴 ========================

$bk_member_cnt = clean_xss_tags(trim($bk_member_cnt));
$bk_member_cnt = preg_replace('/[^0-9]/', '', $bk_member_cnt);
if(!$bk_member_cnt || $bk_member_cnt < 1)
{
	$errorstr = "출조인원을 정확히 선택하십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$ship_available = $ship[s_max];
if($bk_member_cnt > $ship_available)
{
	$errorstr = "예약가능한 인원을 초과했습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
//===================== 달력정보가져옴 ========================
//날짜자리수체크
if (strlen($bk_ymd) != 8)
{
	$errorstr = "예약일자선택 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$bk_ymd = (int)preg_replace('/[^0-9]/', '', $bk_ymd);
$now_date = date("Ymd");
//$limit_date =  date("Ymd", strtotime("+2 month"));
if(!$bk_ymd || $bk_ymd < $now_date)
{
	$errorstr = "예약일자선택 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 개별날짜 추출
$bk_y = substr($bk_ymd,0,4);
$bk_m = substr($bk_ymd,4,2);
$bk_d = substr($bk_ymd,6,2);

$sc = sql_fetch(" select * from m_schedule where s_idx='{$s_idx}' and sc_ymd='{$bk_ymd}' ");
if(!$sc[sc_idx])
{
	$errorstr = "선택하신 예약일자에 예약할 수 없습니다.-001";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($sc[sc_status] != "0")
{
	$errorstr = "선택하신 예약일자에 예약할 수 없습니다.-002";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
/* 예약가능인원체크 - 여분의 예약인원을 받으려면 아래 주석처리함. 반대로 해당일 정원만큼만 예약인원을 받으려면 주석해제. */
$sc_available = $sc[sc_max] - $sc[sc_booked];
if($bk_member_cnt > $sc_available)
{
	$errorstr = "예약가능한 인원을 초과했습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 출조제목
$bk_theme = addslashes(trim($sc[sc_theme]));

// 1인당 출조비용
$bk_price = $sc[sc_price];
$bk_price = (int)preg_replace('/[^0-9]/', '', $bk_price);
if(!$bk_price || $bk_price < 1)
{
	$errorstr = "출조비용에 오류가 있습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($bk_price != $_bk_price)
{
	$errorstr = "출조비용에 변동이 있습니다. 예약절차를 다시 진행해 주세요";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}


// 전체 출조비용
$bk_price_total = $bk_price * $bk_member_cnt;
//===================== 달력정보가져옴 ========================

// 예약자(입금자)명
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

// 예약메모
$bk_memo = $bk_channel.' 에서 접수된 예약입니다.';

// 정보 업데이트
$sql = " insert into m_bookdata 
				set  bk_channel = '{$bk_channel}',
					 bk_channel_mb_id = '{$bk_channel_mb_id}',
					 bk_channel_mb_name = '{$bk_channel_mb_name}',
					 bk_reward_use = '{$bk_reward_use}',
				     bk_ymd = '{$bk_ymd}', 
					 bk_status = '0', 
					 bk_gubun = '', 
					 bk_mb_id = '{$bk_mb_id}', 
					 bk_mb_name = '{$bk_mb_name}', 
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 s_idx = '{$s_idx}', 
					 s_name = '{$s_name}', 
					 bk_theme = '{$bk_theme}', 
					 bk_price = '{$bk_price}', 
					 bk_price_total = '{$bk_price_total}', 
					 bk_y = '{$bk_y}',
					 bk_m = '{$bk_m}',
					 bk_d = '{$bk_d}',
					 bk_member_cnt = '{$bk_member_cnt}',
					 bk_member_arr = '',
					 bk_memo = '{$bk_memo}',
					 bk_ip = '{$_SERVER['REMOTE_ADDR']}',
                     bk_datetime = '".G5_TIME_YMDHIS."'  ";
sql_query($sql);
$bk_idx = sql_insert_id();

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"bk_idx"=>$bk_idx,
		"s_idx"=>$s_idx,
		"s_name"=>$s_name,
		"bk_theme"=>$bk_theme,
		"bk_price"=>$bk_price,
		"bk_price_total"=>$bk_price_total,
		"bk_y"=>$bk_y,
		"bk_m"=>$bk_m,
		"bk_d"=>$bk_d,
		"sc_desc"=>$sc[sc_desc]
	)
);

echo $returnVal; 	exit;

?>
