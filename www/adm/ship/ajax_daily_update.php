<?php
include_once('./_common.php');

$returnVal = "";

//===================== 어선정보가져옴 ========================
$s_idx = preg_replace('/[^0-9]/', '', $_POST['s_idx']);
if(!$s_idx || $s_idx < 1)
{
	$errorstr = "어선 키값이 유효하지 않습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$shipsql = " select * from m_ship where s_idx = '{$s_idx}' ";
$ship = sql_fetch($shipsql);

if(!$ship['s_idx'])
{
	$errorstr = "어선이 존재하지 않습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
//===================== 어선정보가져옴 ========================

//===================== 달력정보가져옴 ========================
$now_y = date("Y");
$now_m = date("m");
$now_d = date("d");
$now_ymd = $now_y.$now_m.$now_d;

$sc_ymd = trim($_POST[sc_ymd]);
$sc_ymd = (int)preg_replace('/[^0-9]/', '', $sc_ymd);
// 날짜자리수체크
if (strlen($sc_ymd) != 8)
{
	$errorstr = "날짜에 오류가 있습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
// 년월이 넘어오지 않았거나, 현재년월보다 이전이거나, 2050년 이상이면 오류
if(!$sc_ymd)
{
	$errorstr = "예약일자 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($sc_ymd < $now_ymd)
{
	$errorstr = "예약일자는 현재일부터 설정가능합니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($sc_ymd > 20501231)
{
	$errorstr = "예약일자는 2050년까지 설정가능합니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 개별날짜 추출
$sc_y = substr($sc_ymd,0,4);
$sc_m = substr($sc_ymd,4,2);
$sc_d = substr($sc_ymd,6,2);

//===================== 달력정보가져옴 ========================
// 출조상태
$sc_status =  clean_xss_tags(trim($_POST['sc_status']));
// 출조제목
$sc_theme =  clean_xss_tags(trim($_POST['sc_theme']));
// 출조제목폰트컬러
$sc_theme_color =  clean_xss_tags(trim($_POST['sc_theme_color']));
// 출조지점
$sc_point =  clean_xss_tags(trim($_POST['sc_point']));
// 출조비용
$sc_price = (int)preg_replace('/[^0-9]/', '', $_POST['sc_price']);
if(!$sc_price || $sc_price < 0 )
{
	$errorstr = "출조가격에 오류가 있습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
// 예약가능인원
$sc_max = (int)preg_replace('/[^0-9]/', '', $_POST['sc_max']);
if(!$sc_max || $sc_max < 1 )
{
	$errorstr = "예약가능인원에 오류가 있습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
// 공지사항
$sc_desc = '';
if (isset($_POST['sc_desc'])) 
{
    $sc_desc = substr(trim($_POST['sc_desc']),0,65536);
    $sc_desc = preg_replace("#[\\\]+$#", "", $sc_desc);
}

$scFetch = sql_fetch(" select *, count(*) as sccnt from m_schedule where s_idx = '{$s_idx}' and sc_y = '{$sc_y}' and sc_m = '{$sc_m}' and sc_d = '{$sc_d}' ");
if($scFetch[sccnt] > 0) $w="u"; else $w="";

// 일정등록
if($w=="")
{
	$sql = " insert into m_schedule
				set s_idx = '{$s_idx}',
					 sc_status = '{$sc_status}',
					 sc_ymd = '{$sc_ymd}',
					 sc_y = '{$sc_y}',
					 sc_m = '{$sc_m}',
					 sc_d = '{$sc_d}',
					 sc_theme = '{$sc_theme}',
					 sc_theme_color = '{$sc_theme_color}',
					 sc_point = '{$sc_point}',
					 sc_price = '{$sc_price}',
					 sc_desc = '{$sc_desc}',
					 sc_max = '{$sc_max}' ";
	sql_query($sql);
}
else if($w=="u")
{
    // 20181018 추가 이석호
    // 업데이트시 해당일의 기존 예약완료인원수 체크해서 완료인원보다 적은 수로 설정하면 오류
    $sc_booked = $scFetch['sc_booked'];
    if($sc_max < $sc_booked) {
        $errorstr = "예약가능인원은 해당일의 기존 예약완료인원수보다 큰 수로 입력하십시오.";
        $errorurl = "";
        $returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
    }

    $sql = " update m_schedule
				set sc_status = '{$sc_status}',
					 sc_theme = '{$sc_theme}',
					 sc_theme_color = '{$sc_theme_color}',
					 sc_point = '{$sc_point}',
					 sc_price = '{$sc_price}',
					 sc_desc = '{$sc_desc}',
					 sc_max = '{$sc_max}' 
				where s_idx = '{$s_idx}' and sc_ymd='{$sc_ymd}' ";
	sql_query($sql);
}

$returnVal = json_encode(
	array(
		"rslt"=>"ok",
		"sql"=>$sql
	)
);
echo $returnVal; exit; 

?>