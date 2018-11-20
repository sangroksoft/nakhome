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
$now_ym = $now_y.$now_m;

$sc_ym = trim($_POST[sc_ym]);
$sc_ym = (int)preg_replace('/[^0-9]/', '', $sc_ym);
// 날짜자리수체크
if (strlen($sc_ym) != 6)
{
	$errorstr = "날짜에 오류가 있습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
// 년월이 넘어오지 않았거나, 현재년월보다 이전이거나, 2050년 이상이면 오류
if(!$sc_ym)
{
	$errorstr = "예약일자 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($sc_ym < $now_ym)
{
	$errorstr = "예약일자는 현재월부터 설정가능합니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($sc_ym > 205012)
{
	$errorstr = "예약일자는 2050년까지 설정가능합니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 개별날짜 추출
$sc_y = substr($sc_ym,0,4);
$sc_m = substr($sc_ym,4,2);

if($now_ym == $sc_ym)
{
	$_startday = date("d");
	//$startday = date("j");
	$startday = 1;
}
else
{
	$_startday = "01";
	$startday = 1;
}

$start_ymd = $sc_y.$sc_m.$_startday;
$lastday = date('t', strtotime($start_ymd));
//===================== 달력정보가져옴 ========================

// 출조상태
$sc_status =  clean_xss_tags(trim($_POST['sc_status']));
// 출조제목
$sc_theme =  clean_xss_tags(trim($_POST['sc_theme']));
$sc_theme_sql = "";
if($sc_theme && $sc_theme != "") $sc_theme_sql = " ,sc_theme = '{$sc_theme}' ";
// 출조지점
$sc_point =  clean_xss_tags(trim($_POST['sc_point']));
$sc_point_sql = "";
if($sc_point && $sc_point != "") $sc_point_sql = " ,sc_point = '{$sc_point}' ";
// 출조비용
$sc_price = (int)preg_replace('/[^0-9]/', '', $_POST['sc_price']);
$sc_price_sql = "";
if($sc_price)
{
	if($sc_price < 1 )
	{
		$errorstr = "출조가격에 오류가 있습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	else
	{
		$sc_price_sql = " ,sc_price = '{$sc_price}' ";
	}
}

// 예약가능인원
$sc_max = (int)preg_replace('/[^0-9]/', '', $_POST['sc_max']);
$sc_max_sql = "";
if($sc_max)
{
	if($sc_max < 1 )
	{
		$errorstr = "예약가능인원에 오류가 있습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	else
	{
		$sc_max_sql = " ,sc_max = '{$sc_max}' ";
	}
}

// 공지사항
$sc_desc = '';
$sc_desc_sql = "";
if (isset($_POST['sc_desc'])) 
{
    $sc_desc = substr(trim($_POST['sc_desc']),0,65536);
    $sc_desc = preg_replace("#[\\\]+$#", "", $sc_desc);
	if($sc_desc != "") $sc_desc_sql = " ,sc_desc = '{$sc_desc}' ";
}

$scFetch = sql_fetch(" select count(*) as sccnt from m_schedule where s_idx = '{$s_idx}' and sc_y = '{$sc_y}' and sc_m = '{$sc_m}' ");
if($scFetch[sccnt] > 0) $w="u"; else $w="";

// 일정등록
if($w=="")
{
	for($t=$startday;$t<$lastday+1;$t++) {

		$_insertYear = $sc_y;
		$_insertMonth = $sc_m;
		$_insertDay = $t;
		if($_insertDay < 10) $_insertDay = "0".$_insertDay;
		$_insertYmd = $_insertYear.$_insertMonth.$_insertDay;

		$sql = " insert into m_schedule
					set s_idx = '{$s_idx}',
						 sc_status = '{$sc_status}',
						 sc_ymd = '{$_insertYmd}',
						 sc_y = '{$_insertYear}',
						 sc_m = '{$_insertMonth}',
						 sc_d = '{$_insertDay}'
						 $sc_theme_sql
						 $sc_point_sql
						 $sc_price_sql
						 $sc_desc_sql
						 $sc_max_sql ";
		sql_query($sql);
	}
}
else if($w=="u")
{

    // 20181018 추가 이석호
    // 업데이트시 해당일의 기존 예약완료인원수 체크해서 완료인원보다 적은 수로 설정하면 넘어감
    // 개별일자설정과 달리 월별설정에서는 오류밷지않고 넘김
    $chksql = " select * from m_schedule where s_idx = '{$s_idx}' and sc_y = '{$sc_y}' and sc_m = '{$sc_m}' " ; 
    $resultsql = sql_query($chksql);
    for($i=0;$rowchk=sql_fetch_array($resultsql);$i++) {

        if($sc_max < $rowchk['sc_booked']) {
            $sc_max_sql = "";
        } 

        $sql = " update m_schedule
                    set sc_status = '{$sc_status}'
                         $sc_theme_sql
                         $sc_point_sql
                         $sc_price_sql
                         $sc_desc_sql
                         $sc_max_sql
                    where sc_idx = '{$rowchk['sc_idx']}' ";
        sql_query($sql);
    }
}

$returnVal = json_encode(
	array(
		"rslt"=>"ok"
	)
);
echo $returnVal; exit; 

?>