<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//if(!comcheck($_POST[com_uidx])) die;


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

$data = $_POST[data];

$bk_channel = trim($data[bk_channel]);
$bk_channel_mb_id = trim($data[bk_channel_mb_id]);
$bk_channel_mb_name = clean_xss_tags(trim($data[bk_channel_mb_name]));
$bk_reward_use = $data[bk_reward_use];


//===================== 어선정보가져옴 ========================
$s_idx = clean_xss_tags(trim($data[s_idx]));
$ship = sql_fetch(" select * from m_ship where s_idx = '{$s_idx}' ");
$s_name = get_text($ship[s_name]);
//===================== 어선정보가져옴 ========================

$bk_member_cnt = clean_xss_tags(trim($data[bk_member_cnt]));
$bk_member_cnt = preg_replace('/[^0-9]/', '', $bk_member_cnt);

$ship_available = $ship[s_max];

//===================== 달력정보가져옴 ========================
$bk_ymd = trim($data[sc_ymd]);
$bk_ymd = (int)preg_replace('/[^0-9]/', '', $bk_ymd);

$now_date = date("Ymd");
$limit_date =  date("Ymd", strtotime("+2 month"));

// 개별날짜 추출
$bk_y = substr($bk_ymd,0,4);
$bk_m = substr($bk_ymd,4,2);
$bk_d = substr($bk_ymd,6,2);

$sc = sql_fetch(" select * from m_schedule where s_idx='{$s_idx}' and sc_ymd='{$bk_ymd}' ");
/* 예약가능인원체크 - 여분의 예약인원을 받으려면 아래 주석처리함. 반대로 해당일 정원만큼만 예약인원을 받으려면 주석해제. */
$sc_available = $sc[sc_max] - $sc[sc_booked];

// 출조제목
$bk_theme = addslashes(trim($sc[sc_theme]));

// 1인당 출조비용
$bk_price = $sc[sc_price];
$bk_price = (int)preg_replace('/[^0-9]/', '', $bk_price);
// 전체 출조비용
$bk_price_total = $bk_price * $bk_member_cnt;
//===================== 달력정보가져옴 ========================
// 회원정보
// 예약자(입금자)명
$bk_banker = clean_xss_tags(trim($data['bk_banker']));

if (!$is_member){
	$bk_mb_id = "temp_member";
	$bk_mb_name = $bk_banker;
}else{
	$bk_mb_id = $member['mb_id'];
	$bk_mb_name = $member['mb_name'];
}

// 예약자 핸드폰번호
$bk_tel = clean_xss_tags(trim($data['bk_tel']));
$bk_tel = preg_replace("/[^0-9]/", "", $bk_tel);

// 예약메모
$bk_memo = '';
if (isset($data['bk_memo'])) 
{
	$bk_memo = substr(trim($data['bk_memo']),0,65536);
	$bk_memo = preg_replace("#[\\\]+$#", "", $bk_memo);
}

// 정보 업데이트
$sql = " insert into m_bookdata 
				set bk_channel = '{$bk_channel}', 
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

// 스케쥴테이블(m_schedule)에도 예약자수 업데이트(여기서 업데이트 하지 않고 관리자가 예약금입금 확인 후 예약처리시 업데이트)


//===== API 실행 ======
/*
$_data = array();
$_data["bk_channel"] = $_POST[data][bk_channel];
$_data["bk_channel_mb_id"] = $_POST[data][bk_channel_mb_id];
$_data["bk_channel_mb_name"] = $_POST[data][bk_channel_mb_name];
$_data["bk_reward_use"] = $_POST[data][bk_reward_use];
$_data["s_uidx"] = $ship[s_uidx];
$_data["bk_idx"] = $bk_idx;
$_data["bk_ymd"] = $bk_ymd;
$_data["bk_status"] = "0";
$_data["bk_mb_id"] = $bk_mb_id;
$_data["bk_mb_name"] = $bk_mb_name;
$_data["bk_banker"] = $bk_banker;
$_data["bk_tel"] = $bk_tel;
$_data["s_idx"] = $s_idx;
$_data["s_name"] = $s_name;
$_data["bk_theme"] = $bk_theme;
$_data["bk_price"] = $bk_price;
$_data["bk_price_total"] = $bk_price_total;
$_data["bk_y"] = $bk_y;
$_data["bk_m"] = $bk_m;
$_data["bk_d"] = $bk_d;
$_data["bk_member_cnt"] = $bk_member_cnt;
$_data["bk_memo"] = $bk_memo;
$_data["bk_ip"] = $_SERVER['REMOTE_ADDR'];

$arr = array();
$arr[com_uidx]   = $comfig[com_uidx];
$arr[com_name] = $comfig[com_name];
$arr[sdom]        = $comfig[sdom];
$arr[data]	       = $_data;

$curlData = http_build_query($arr);
$curlUrl = "https://monak.kr/api/_bk_save.php";
//$curlUrl = "https://www.monak.co.kr/api/_bk_save.php";
curl_api($curlUrl, $curlData);
*/
//===== API 종료 ======
?>
