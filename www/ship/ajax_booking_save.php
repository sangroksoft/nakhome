<?php
include_once('./_common.php');
$returnVal = "";

if (!($w == '' || $w == 'u'))
{
	$errorstr = "작성구분값 오류입니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

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

//===================== 어선정보가져옴 ========================
$s_idx = clean_xss_tags(trim($_POST[s_idx]));
if(!$s_idx || $s_idx < 1) 
{
	$errorstr = "어선키값 오류입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
$ship = sql_fetch(" select * from m_ship where s_idx = '{$s_idx}' ");
if(!$ship[s_idx]) 
{
	$errorstr = "존재하지 않는 어선입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($ship[s_expose] != "y") 
{
	$errorstr = "현재 해당 어선은 선택하실 수 없습니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
$s_name = get_text($ship[s_name]);
//===================== 어선정보가져옴 ========================

$bk_member_cnt = clean_xss_tags(trim($_POST[bk_member_cnt]));
$bk_member_cnt = preg_replace('/[^0-9]/', '', $bk_member_cnt);
if(!$bk_member_cnt || $bk_member_cnt < 1)
{
	$errorstr = "출조인원을 정확히 선택하십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$ship_available = $ship[s_max];
/*
if($bk_member_cnt > $ship_available)
{
	$errorstr = "예약가능한 인원을 초과했습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
*/
//===================== 달력정보가져옴 ========================
$bk_ymd = trim($_POST[sc_ymd]);
//날짜자리수체크
if (strlen($bk_ymd) != 8)
{
	$errorstr = "예약일자선택 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$bk_ymd = (int)preg_replace('/[^0-9]/', '', $bk_ymd);
$now_date = date("Ymd");
$limit_date =  date("Ymd", strtotime("+2 month"));
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
if(!$sc['sc_idx'])
{
	$errorstr = "선택하신 예약일자에 예약할 수 없습니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($sc['sc_status'] != "0")
{
	$errorstr = "선택하신 예약일자에 예약할 수 없습니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$sc_idx = $sc['sc_idx'];
$sc_available = $sc['sc_max'] - $sc['sc_booked'];

/* 예약가능인원체크 - 출조가능인원을 초과하면 에러. */
if($bk_member_cnt > $sc['sc_max'])
{
    $errorstr = "예약가능한 인원을 초과했습니다.";
    $errorurl = "";
    $returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
/* 예약가능인원체크 - 초과예약인원을 받는 여부. */
if($bk_member_cnt > $sc_available)
{
    if($comfig['overbooking'] == "1") {
        ;
    } else {
        $errorstr = "예약가능한 인원을 초과했습니다.";
        $errorurl = "";
        $returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
    }
}

// 출조제목
$bk_theme = addslashes(trim($sc['sc_theme']));

// 1인당 출조비용
$bk_price = $sc['sc_price'];
$bk_price = (int)preg_replace('/[^0-9]/', '', $bk_price);
if(!$bk_price || $bk_price < 1)
{
	$errorstr = "출조비용오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 전체 출조비용
$bk_price_total = $bk_price * $bk_member_cnt;
//===================== 달력정보가져옴 ========================

// 회원정보
if (!$is_member)
{
	$bk_mb_id = "temp_member";
	$bk_mb_name = $bk_banker;
}
else{
	$bk_mb_id = $member['mb_id'];
	$bk_mb_name = $member['mb_name'];
}

// 예약자(입금자)명
$bk_banker = clean_xss_tags(trim($_POST['bk_banker']));
if(!$bk_banker || $bk_banker == "")
{
	$errorstr = "예약자명을 입력하세요.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 예약자 핸드폰번호
$bk_tel = clean_xss_tags(trim($_POST['bk_tel']));
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
$bk_memo = '';
if (isset($_POST['bk_memo'])) 
{
	$bk_memo = substr(trim($_POST['bk_memo']),0,65536);
	$bk_memo = preg_replace("#[\\\]+$#", "", $bk_memo);
}

// 정보 업데이트
$sql = " insert into m_bookdata 
				set  sc_idx = '{$sc_idx}', 
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

// 문자 발송
$smstext = "[홈페이지 예약]\n".$s_name."\n".$bk_m."월 ".$bk_d."일\n".$bk_banker."님(".($bk_member_cnt*1).")명\n".$bk_tel;
$receiver = $config['cf_admin_tel'];
$postField = "sUserid=plannew&authKey=dXPHlYB2vKCmdfFaxh3vy7pDb4KkYb9m&sendMsg=".$smstext."&destNum=".$receiver."&callNum=01047055637&sMode=Real&sType=SMS";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,    "http://www.sms9.co.kr/authSendApi/authSendApi_UTF8.php");
//curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
curl_setopt($ch, CURLOPT_POST,    true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postField);
$response = curl_exec($ch);
curl_close($ch);

//===== API 실행 ======
// 모낚에서 예약한 건만 취급하기 때문에 낚홈에서 예약한 건은 모낚으로 전송안함.
/*
$_data = array();
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
//$curlUrl = "https://monak.co.kr/api/_bk_save.php";
curl_api($curlUrl, $curlData);
*/
//===== API 종료 ======

$returnVal = json_encode(
	array(
		"rslt"=>"ok",
		"bkidx"=>$bk_idx
	)
);

echo $returnVal;
?>
