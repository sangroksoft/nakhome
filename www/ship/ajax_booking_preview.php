<?php
include_once('./_common.php');

$returnVal = "";

/*
if(!$is_member)
{
	$errorstr = "로그인 후 이용하실 수 있습니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
*/
//===================== 어선정보가져옴 ========================
$s_idx = clean_xss_tags(trim($_GET[s_idx]));
if(!$s_idx || $s_idx < 1) 
{
	$errorstr = "키값오류입니다.";
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
if($ship[s_expose] != "y") 
{
	$errorstr = "현재 해당 어선은 선택하실 수 없습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
$ship_name = get_text($ship[s_name]);
//===================== 어선정보가져옴 ========================

//===================== 달력정보가져옴 ========================
$sc_ymd = trim($_GET[sc_ymd]);
$sc_ymd = (int)preg_replace('/[^0-9]/', '', $sc_ymd);
if(!$sc_ymd || $sc_ymd < 20000101 || $sc_ymd > 20501231)
{
	$errorstr = "예약일자를 선택해 주세요.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

//날짜자리수체크
if (strlen($sc_ymd) != 8)
{
	$errorstr = "예약일자를 선택해 주세요.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 개별날짜 추출
$sc_y = substr($sc_ymd,0,4);
$sc_m = substr($sc_ymd,4,2);
$sc_d = substr($sc_ymd,6,2);

$sc = sql_fetch(" select * from m_schedule where s_idx='{$s_idx}' and sc_ymd='{$sc_ymd}' ");

// 출조상태체크
$sc_status = $sc[sc_status];
if($sc_status != "0")
{
	$errorstr = "해당일 예약이 마감되었습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 출조테마
$sc_theme = get_text($sc[sc_theme]);

// 1인당 출조금액
$sc_price = $sc[sc_price];

// 출조인원
$bk_member_cnt = clean_xss_tags(trim($_GET[bk_member_cnt]));
$bk_member_cnt = preg_replace('/[^0-9]/', '', $bk_member_cnt);
if(!$bk_member_cnt || $bk_member_cnt < 1)
{
	$errorstr = "출조인원을 정확히 선택하십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 총출조비용
$bk_price_total = $sc_price * $bk_member_cnt;

// 예약비용
$bk_price_total_tmp = $bk_price_total*($comfig['book_fee'] / 100);

// 해당일 상세출조스케쥴
$bookResult = '';
$bookResult .= '<li class="bk_result_ymd">';
$bookResult .= '<span class="bk-result-ymd">'.$sc_y.'년 '.$sc_m.'월 '.$sc_d.'일</span> - <span class="bk-result-ship">'.$ship_name .' ('.$sc_theme.')</span>';
$bookResult .= '</li>';
$bookResult .= '<li class="bk_result_price">';
$bookResult .= '<span class="bk-unit-price">1인 출조비 '.number_format($sc_price).'원 * '.$bk_member_cnt.'명</span> = ';
$bookResult .= '<span  class="bk-total-price">'.number_format($bk_price_total).'원</span>';
$bookResult .= '</li>';
$bookResult .= '<li class="bk_result_desc">';
$bookResult .= '※ 총 예약금액 중에 <span class="bk-contract-price">계약금('.number_format($bk_price_total_tmp).'원) 이상 입금</span> 시 예약완료 됩니다.';
$bookResult .= '</li>';
//===================== 달력정보가져옴 ========================

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"cont"=>$bookResult
	)
);

echo $returnVal;
?>
