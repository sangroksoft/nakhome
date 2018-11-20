<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// 상수모음 시작
//------------------------------------------------------------------------------
define('G5_SHIP_DIR', 'ship');
define('G5_SHIP_PATH', G5_PATH.'/'.G5_SHIP_DIR);
define('G5_SHIP_URL', G5_URL.'/'.G5_SHIP_DIR);

define('G5_ADMINSHIP_DIR', 'ship');
define('G5_ADMINSHIP_PATH', G5_ADMIN_PATH.'/'.G5_ADMINSHIP_DIR);
define('G5_ADMINSHIP_URL', G5_ADMIN_URL.'/'.G5_ADMINSHIP_DIR);

//------------------------------------------------------------------------------
// 전역변수 설정
//------------------------------------------------------------------------------
// 어선 서비스항목 설정
$_menu_arr = array(
	array("미끼제공", "1"), 
	array("수세식화장실", "2"), 
	array("조식제공", "3"), 
	array("중식제공", "4"), 
	array("석식제공", "5"), 
	array("회 떠드림", "6"), 
	array("커피/음료 제공", "7"), 
	array("무료숙박 제공", "8"), 
	array("낚시대 무료제공", "9"), 
	array("낚시대 유료대여", "10"), 
	array("어장물고기 제공", "11"), 
	array("먼바다 낚시", "12"), 
	array("침선 낚시", "13"), 
	array("어초 낚시", "14"), 
	array("어군탐지기", "15"), 
	array("플로터(프루터)", "16"), 
	array("무전기", "17"), 
	array("안내방송장비", "18"), 
	array("레이더", "19"), 
	array("소나", "20"), 
	array("전동릴 전기공급", "21"), 
	array("자동항법장치", "22"), 
	array("해수쿨러", "23"), 
	array("안전용 CCTV", "24"), 
	array("소화기", "25"), 
	array("구명밧줄", "26"), 
	array("구명조끼", "27"), 
	array("낚시객 보험", "28"), 
	array("TV", "29"), 
	array("냉장고", "30"), 
	array("에어컨", "31"), 
	array("정수기", "32"), 
	array("무선인터넷", "33"), 
	array("전기콘센트", "34"), 
	array("여름철 그늘막", "35"), 
	array("라면판매", "36")
);

// 물때 설정
$tideArr_es = array(
"01"=>"8물","02"=>"9물","03"=>"10물","04"=>"11물","05"=>"12물","06"=>"13물","07"=>"14물","08"=>"조금","09"=>"1물","10"=>"2물","11"=>"3물","12"=>"4물","13"=>"5물","14"=>"6물","15"=>"7물",
"16"=>"8물","17"=>"9물","18"=>"10물","19"=>"11물","20"=>"12물","21"=>"13물","22"=>"14물","23"=>"조금","24"=>"1물","25"=>"2물","26"=>"3물","27"=>"4물","28"=>"5물","29"=>"6물","30"=>"7물"
);
$tideArr_w = array(
"01"=>"7물","02"=>"8물","03"=>"9물","04"=>"10물","05"=>"11물","06"=>"한객기","07"=>"대객기","08"=>"조금","09"=>"무시","10"=>"1물","11"=>"2물","12"=>"3물","13"=>"4물","14"=>"5물","15"=>"6물",
"16"=>"7물","17"=>"8물","18"=>"9물","19"=>"10물","20"=>"11물","21"=>"한객기","22"=>"대객기","23"=>"조금","24"=>"무시","25"=>"1물","26"=>"2물","27"=>"3물","28"=>"4물","29"=>"5물","30"=>"6물"
);
/*
$tideArr_w = array(
"1"=>"7물","2"=>"8물","3"=>"9물","4"=>"10물","5"=>"11물","6"=>"12물","7"=>"13물","8"=>"조금","9"=>"무시","10"=>"1물","11"=>"2물","12"=>"3물","13"=>"4물","14"=>"5물","15"=>"6물",
"16"=>"7물","17"=>"8물","18"=>"9물","19"=>"10물","20"=>"11물","21"=>"12물","22"=>"13물","23"=>"조금","24"=>"무시","25"=>"1물","26"=>"2물","27"=>"3물","28"=>"4물","29"=>"5물","30"=>"6물"
);
*/
// 수역설정
$_sea_arr = array(
	array("경기북부앞바다",        "12A20000|12A20100|12A20101"), 
	array("인천경기남부앞바다",  "12A20000|12A20100|12A20102"), 
	array("충남북부앞바다",        "12A20000|12A20100|12A20103"), 
	array("충남남부앞바다",        "12A20000|12A20100|12A20104"), 
	array("전북북부앞바다",        "12A30000|12A30100|22A30101"), 
	array("전북남부앞바다",        "12A30000|12A30100|22A30102"), 
	array("전남북부서해앞바다",  "12A30000|12A30100|22A30103"), 
	array("전남중부서해앞바다",  "12A30000|12A30100|22A30104"), 
	array("전남남부서해앞바다",  "12A30000|12A30100|22A30105"), 
	array("전남서부남해앞바다",  "12B10000|12B10100|12B10101"), 
	array("전남동부남해앞바다",  "12B10000|12B10100|12B10102"), 
	array("강원북부앞바다",        "12C20000|12C20100|12C20103"), 
	array("강원중부앞바다",        "12C20000|12C20100|12C20102"), 
	array("강원남부앞바다",        "12C20000|12C20100|12C20101"), 
	array("경북북부앞바다",        "12C10000|12C10100|12C10103"), 
	array("경북남부앞바다",        "12C10000|12C10100|12C10102"), 
	array("울산앞바다",              "12C10000|12C10100|12C10101"), 
	array("부산앞바다",              "12B20000|12B20100|12B20103"), 
	array("경남중부남해앞바다",  "12B20000|12B20100|12B20102"), 
	array("경남서부남해/거제시동부앞바다",  "12B20000|12B20100|12B20101"), 
	array("제주도북부앞바다",     "12B30000|12B10300|12B10302"), 
	array("제주도동부앞바다",     "12B30000|12B10300|12B10301"), 
	array("제주도서부앞바다",     "12B30000|12B10300|12B10304"), 
	array("제주도남부앞바다",     "12B30000|12B10300|12B10303"), 
);

//------------------------------------------------------------------------------
// 함수정의
//------------------------------------------------------------------------------
function alert_goto_url($msg='',$url)
{
	global $g5;
    $url = str_replace("&amp;", "&", $url);

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'> alert('$msg'); document.location.href='$url';</script>";
	exit;
}

function alert_goto_url_back($msg='')
{
	global $g5;

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'> alert('$msg'); history.back(-1); </script>";
	exit;
}

function alert_replace_url($msg='',$url)
{
	global $g5;
    $url = str_replace("&amp;", "&", $url);

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'> alert('$url'); document.location.replace('$url');</script>";
	exit;
}

function replace_url($url)
{
	global $g5;
    $url = str_replace("&amp;", "&", $url);

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'>parent.document.location.replace('$url');</script>";
	exit;
}

// 메시지 출력후 부모창 리프레시 후 URL 이동
function alert_goto_url_closelayer($msg,$url)
{
	global $g5;
    $url = str_replace("&amp;", "&", $url);

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'> alert('$msg'); parent.document.location.href='$url';</script>";
	exit;
}
// 메시지 출력후 레이어 창을 닫음
function alert_closelayer($msg,$layernum)
{
	global $g5;

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'> alert('$msg'); parent.closelayer2();</script>";
	exit;
}

// 아이프레임 메시지 출력 후 부모창 이동
function alert_gotourl_iframe($msg, $url)
{
	global $g5;
    $url = str_replace("&amp;", "&", $url);

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'>alert('$msg'); parent.document.location.href='$url';</script>";
	exit;
}

// 아이프레임 메시지 출력 후 부모창 페이지 replace
function alert_replace_iframe($msg, $url)
{
	global $g5;
    $url = str_replace("&amp;", "&", $url);

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'>alert('$msg'); parent.document.location.replace('$url');</script>";
	exit;
}

// 아이프레임 메시지 출력 후 부모창 페이지 reload
function alert_reload_iframe($msg)
{
	global $g5;

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'>alert('$msg'); parent.document.location.reload();</script>";
	exit;
}

//메시지 출력후 모달창 닫음
function close_modal()
{
	global $g5;

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'>parent.document.location.reload();</script>";
	exit;
}

//메시지 출력후 모달창 닫음
function alert_close_modal($msg='',$layernum)
{
	global $g5;

	$closelayer = "parent.closelayer".$layernum."();";

	echo '<meta charset="utf-8">';
	echo "<script type='text/javascript'> alert('$msg'); ".$closelayer."</script>";
	exit;
}

//에러리턴
function returnError($errorstr,$errorurl)
{
    global $g5, $config, $member;
    global $is_admin;

	$returnVal = array (
			"errcode"=>$errorstr,
			"errurl"=>$errorurl
	);
	return $returnVal;
}

// 에러리턴
function returnErrorArr($errorstr,$errorurl)
{
    global $g5, $config, $member;
    global $is_admin;

	$returnVal = json_encode(
		array(
			"rslt"=>"error", 
			"errcode"=>$errorstr,
			"errurl"=>$errorurl
		)
	);
	return $returnVal;
}

// 마이크로 스탬프값 추출
function get_microstamp($saltvalue="")
{
	$tm = explode(" ", microtime());
	$tm1 = substr($tm[0], 2);
	$tm2 = substr($tm1, 0,6);
	$tm3=$tm[1].$saltvalue.$tm2;

	return $tm3;
}

// CURL로 외부 api 가져오기
function curl($url) {
    $ch = curl_init ();
    
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
    $g = curl_exec ( $ch );
    curl_close ( $ch );
    return $g;
}

// CURL로 외부 URL 에 파일이 존재하는지 체크
function remoteFileExist($filepath) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$filepath);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if(curl_exec($ch)!==false) {
        return true;
    } else {
        return false;
    }
}

// 날짜,시간 표현방식
function time_gap_ago($datetime) {

	$date1 = strtotime($datetime);
	$date2 = time();
	$subTime = $date2 - $date1;

	$y = floor($subTime/(60*60*24*365));
	$d = floor($subTime/(60*60*24))%365;
	$h = floor($subTime/(60*60))%24;
	$m = floor($subTime/60)%60;

	if($y>0)
	{
		if($y > 1) $postfix_y = "년"; else $postfix_y = "년";
		if($d > 0)
		{
			if($d > 1) $postfix_d = "일"; else $postfix_d = "일";
			$timegap =  $y.$postfix_y." ".$d.$postfix_d."전";
		}
		else
		{
			$timegap =  $y.$postfix_y."전";
		}
	}
	else if($d > 0)
	{
		if($d > 1) $postfix_d = "일"; else $postfix_d = "일";
		$timegap =  $d.$postfix_d."전";
	}
	else if($h > 0)
	{
		if($h > 1) $postfix_h = "시간"; else $postfix_h = "시간";
		$timegap =  $h.$postfix_h."전";
	}
	else if($m > 0)
	{
		if($m > 1) $postfix_m = "분"; else $postfix_m = "분";
		$timegap =  $m.$postfix_m."전";
	}
	else
	{
		$timegap =  "방금전";
	}

	return $timegap;
}

// 특수문자 제거
function clean_spchars($name)
{
    $pattern = '/[\^|||`\\\]/';
    $name = preg_replace($pattern, '', $name);

    return $name;
}

// 회원의 현재까지 포인트 합계
function get_mbpointsum($mb_id)
{
	global $g5,$member,$config,$is_admin;

	$minfo = sql_fetch(" select * from g5_member where mb_id = '{$mb_id}' ");
	if(!$minfo[mb_id]) { alert("존재하지 않는 회원입니다."); exit; }

	// 회원의 현재까지 포인트 합계
	$mbpoint_sql = sql_fetch(" select ifnull(sum(po_point), 0) as mbpoint_sum from lc_point where mb_id = '{$mb_id}' ");
	$mbpoint_sum = $mbpoint_sql[mbpoint_sum];

	return $mbpoint_sum;
}

// 회원의 현재까지 포인트 합계 업데이트
function update_mbpointsum($mb_id,$po_idx)
{
	global $g5,$member,$config,$is_admin;

	$minfo = sql_fetch(" select * from g5_member where mb_id = '{$mb_id}' ");
	if(!$minfo[mb_id]) { alert("존재하지 않는 회원입니다."); exit; }

	// 회원의 현재까지 포인트 합계 업데이트
	$po_point_sum = get_mbpointsum($mb_id);
	$sqlposum = " update lc_point  set po_point_sum = '{$po_point_sum}' where po_idx = '{$po_idx}'   ";
	sql_query($sqlposum);
}

// 포인트충전
function plusPoint($mb_id, $pp_point, $po_rel_act, $po_content, $pay_idx)
{
	global $g5,$member,$config,$is_admin;

	if($po_rel_act == "") $po_rel_act = "charge";
	$po_point = (int)preg_replace('/[^0-9]/', '', $pp_point);
	if(!$po_point || $po_point < 1) { alert("포인트는 0 이상 숫자로 입력하세요."); exit; }

	if($po_content == "") $po_content = "포인트충전";
	$po_gubun = "p";

	$minfo = sql_fetch(" select * from g5_member where mb_id = '{$mb_id}' ");
	if(!$minfo[mb_id]) { alert("존재하지 않는 회원입니다."); exit; }

	$sqlpo = " insert into lc_point
					set mb_id            = '{$minfo['mb_id']}',
						mb_name        = '{$minfo['mb_name']}',
						po_rel_id         = '{$minfo['mb_id']}',
						po_rel_act        = '{$po_rel_act}',
						po_point         = '{$po_point}',
						pay_idx           = '{$pay_idx}',
						b_idx            = '',
						po_gubun       = '{$po_gubun}',
						po_content      = '{$po_content}',
						po_ip              = '{$_SERVER['REMOTE_ADDR']}',
						po_datetime    = '".G5_TIME_YMDHIS."'   ";
	sql_query($sqlpo);
	$po_idx = sql_insert_id();

	// 누적포인트 업데이트
	update_mbpointsum($mb_id, $po_idx);
}

// 포인트차감
function minusPoint($mb_id, $pp_point, $po_rel_act, $po_content, $b_idx, $pay_idx)
{
	global $g5,$member,$config,$is_admin;

	if($po_rel_act == "") $po_rel_act = "minus";
	$po_point = (int)preg_replace('/[^0-9]/', '', $pp_point);
	if(!$po_point || $po_point < 1) { alert("포인트는 0 이상 숫자로 입력하세요."); exit; }
	$po_point = $po_point*(-1);

	if($po_content == "") $po_content = "포인트차감";
	$po_gubun = "n";

	$minfo = sql_fetch(" select * from g5_member where mb_id = '{$mb_id}' ");
	if(!$minfo[mb_id]) { alert("존재하지 않는 회원입니다."); exit; }

	$sqlpo = " insert into lc_point
					set mb_id            = '{$minfo[mb_id]}',
						mb_name        = '{$minfo['mb_name']}',
						po_rel_id         = '{$minfo[mb_id]}',
						po_rel_act        = '{$po_rel_act}',
						po_point         = '{$po_point}',
						pay_idx           = '{$pay_idx}',
						b_idx            = '{$b_idx}',
						po_gubun       = '{$po_gubun}',
						po_content      = '{$po_content}',
						po_ip              = '{$_SERVER['REMOTE_ADDR']}',
						po_datetime    = '".G5_TIME_YMDHIS."'   ";
	sql_query($sqlpo);
	$po_idx = sql_insert_id();

	// 누적포인트 업데이트
	update_mbpointsum($mb_id, $po_idx);
}

// 검색 구문을 얻는다.
function get_sql_search_lsh($search_field, $search_text, $search_operator='and', $join_field="")
{
    global $g5;

    $return_str = "";

    $search_text = strip_tags(($search_text));
    $search_text = trim(stripslashes($search_text));

    $return_str .= " and ";

    // 쿼리의 속도를 높이기 위하여 ( ) 는 최소화 한다.
    $op1 = "";

    // 검색어를 구분자로 나눈다. 여기서는 공백
    $s = array();
    $s = explode(" ", $search_text);

    // 검색필드를 구분자로 나눈다.
    $field = explode("||", $search_field);

    $return_str .= "(";
    for ($i=0; $i<count($s); $i++) 
	{
        // 검색어
        $search_str = trim($s[$i]);
        if ($search_str == "") continue;

        $return_str .= $op1;
        $return_str .= "(";

		$join_field = preg_match("/^[\w\,\|]+$/", $join_field) ? $join_field : "";

        $op2 = "";
        for ($k=0; $k<count($field); $k++) // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)
		{ 
            // SQL Injection 방지
            // 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
            $field[$k] = preg_match("/^[\w\,\|]+$/", $field[$k]) ? $field[$k] : "wr_subject";
			$_searchField_field = "";

			if($join_field != "")  $_searchField_field =  $join_field.".".$field[$k];
			else $_searchField_field = $field[$k];

            $return_str .= $op2;
            switch ($_searchField_field) 
			{
                case "mb_id" :
                case "mb_nick" :
                    $return_str .= " $_searchField_field = '$s[$i]' "; break;
                case "hitcnt" :
                case "recomcnt" :
                case "sharecnt" :
                    $return_str .= " $_searchField_field >= '$s[$i]' "; break;
                default :
                    if (preg_match("/[a-zA-Z]/", $search_str)) $return_str .= "INSTR(LOWER($_searchField_field), LOWER('$search_str'))";
                    else $return_str .= "INSTR($_searchField_field, '$search_str')";
                    break;
            }
            $op2 = " or ";
        }
        $return_str .= ")";

        $op1 = " $search_operator ";
    }
    $return_str .= " ) ";

    return $return_str;
}

//유투브 아이디 추출
function youtube_id_from_url($url) {
	$yurl = urldecode(rawurldecode($url));
	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $yurl, $matches);
	return $matches[1];
}

// ssl 적용여부
function is_ssl()
{
	$isSecure = false;
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
		$isSecure = true;
	}

	$https_port = $_SERVER['SERVER_PORT'];

	if(!($isSecure == true && $https_port == "48644")) return false;
	else return true;
}

// 푸시
function alarmPush($dataArray)
{
	global $g5,$member,$config,$is_admin;

	//알람DB저장 및 푸시보내기(판매자 자신은 해당없음)
	$pu_subj = trim($dataArray['pu_subj']);
	$pu_cont = trim($dataArray['pu_cont']);
	$pu_sender = $dataArray['pu_sender'];
	$pu_sender_name = $dataArray['pu_sender_name'];
	$pu_receiver = $dataArray['pu_receiver'];
	$pu_receiver_name = $dataArray['pu_receiver_name'];
	$pu_url = $dataArray['pu_url'];
	$pu_keyidx = $dataArray['pu_keyidx'];
	$pu_mode = $dataArray['pu_mode'];
	$pu_param = $dataArray['pu_param'];

	//푸시보내기
	$pushArray = array(
		'pu_subj'=>$pu_subj, 
		'pu_sender'=>$pu_sender, 
		'pu_receiver'=>$pu_receiver, 
		'pu_url'=> $pu_url, 
		'pu_keyidx'=>$pu_keyidx, 
		'pu_mode'=>$pu_mode, 
		'pu_param'=> $pu_param
	);
	sendPushMsg($pushArray);
}

// 회원 삭제
function member_delete_lsh($mb_id)
{
    global $config;
    global $g5;

    $sql = " select * from {$g5['member_table']} where mb_id= '".$mb_id."' ";
    $mb = sql_fetch($sql);

    // 이미 삭제된 회원은 제외
    if(preg_match('#^[0-9]{8}.*삭제함#', $mb['mb_memo']))  return;

    // 회원자료는 정보만 없앤 후 아이디는 보관하여 다른 사람이 사용하지 못하도록 함 : 061025
    $sql = " update {$g5['member_table']} 
				set mb_password = '', 
					mb_level = 1, 
					mb_homepage = '', 
					mb_phone_os = '', 
					mb_phone_key = '', 
					mb_push_ok = '', 
					mb_memo = '".date('Ymd', G5_SERVER_TIME)." 삭제함\n{$mb['mb_memo']}' 
				where mb_id = '{$mb_id}' ";
    sql_query($sql);

    // 포인트 테이블에서 삭제
    sql_query(" delete from gg_point where mb_id = '$mb_id' ");
}


// 양력 -> 음력 변환 함수입니다.
// 10년 단위로 기준 일을 구합니다.
// 각 10년 1월 1일부터 몇 일이 지났는지 계산합니다.
// PHP 내장된 날짜계산 함수를 이용했습니다.
function getBaseDay($year, $month, $day)
{
    global $g5, $config, $member;
	$base_year = (int)($year / 10) * 10;

	$s = sprintf("%d%02d%02d", $base_year, 1, 1);
	$base_date = date("Ymd", strtotime($s));

	$s = sprintf("%d%02d%02d", $year, $month, $day);
	$cur_date = date("Ymd", strtotime($s));

	$base_day = (int)( ( strtotime($cur_date) - strtotime($base_date) ) / 86400);

	return $base_day;
}

// 양력 -> 음력 변환 함수입니다.
// 배열 값을 반환하니 다음을 참고하십시오.
// return[0] : 성공시 0, 실패시 0이 아닌 값
// return[1] : 음력 연도
// return[2] : 음력 월
// return[3] : 음력 일
// return[4] : 평달이면 0, 윤달이면 1
function getLunarDate($year, $month, $day)
{
    global $g5, $config, $member;
	$out_value = array(-1, 0, 0, 0, 0);
	$base_year = (int)($year / 10) * 10;
	$base_jump = 6;
	$base_day = getBaseDay($year, $month, $day);

	$str_path = sprintf(G5_EXTEND_PATH."/lunar_%d.txt", $base_year);

	// 파일을 엽니다.
	$f = fopen($str_path, "rb");
	if(FALSE == $f) return $out_value;

	// 해당 날짜 위치로 이동합니다.
	if(0 == fseek($f, ($base_day * $base_jump), SEEK_SET))
	{
		$buffer = fread($f, $base_jump);
		if(strlen($buffer) >= $base_jump - 1)
		{
			$year_flag = substr($buffer, 0, 1);
			$lunar_year = $year;
			$lunar_leap = 0;

			// 첫 글자에 담긴 정보를 반영한다.
			// - : 특이사항 없음
			// a : -1년
			// b : 윤달
			// c : -1년, 윤달
			if($year_flag == "a") $lunar_year--;
			if($year_flag == "b") $lunar_leap = 1;
			if($year_flag == "c") { $lunar_year--; $lunar_leap = 1; }

			$lunar_month	= intval(substr($buffer, 1, 2));
			$lunar_day		= intval(substr($buffer, 3, 2));
	
			$out_value[0] = 0;
			$out_value[1] = $lunar_year;
			$out_value[2] = $lunar_month;
			if($out_value[2] < 10) $out_value[2] = "0".$out_value[2];
			$out_value[3] = $lunar_day;
			if($out_value[3] < 10) $out_value[3] = "0".$out_value[3];
			$out_value[4] = $lunar_leap;
		}
	}
	fclose($f);

	return $out_value;
}


// 게시판 첨부파일 썸네일 삭제
function delete_board_thumbnail_lsh($bo_table, $file)
{
    if(!$bo_table || !$file)
        return;

    $fn = preg_replace("/\.[^\.]+$/i", "", basename($file));
    $files = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb/'.$fn.'*');
    if (is_array($files)) {
        foreach ($files as $filename)
            unlink($filename);
    }

    $files2 = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb2/'.$fn.'*');
    if (is_array($files2)) {
        foreach ($files2 as $filename2)
            unlink($filename2);
    }
}

// 에디터 원본이미지, 썸네일이미지 삭제
function delete_editor_img_lsh($contents)
{
    if(!$contents) return;

    // $contents 중 img 태그 추출
    $matchs = get_editor_image($contents, false); //false가 반드시 들어가야 소스,파일명 제대로 추출함.
	if(!$matchs) return;

	for($i=0; $i<count($matchs[1]); $i++)
	{
		// 이미지 path 구함
		$p = parse_url($matchs[1][$i]);

		if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0) $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
		else $data_path = $p['path'];

		$srcfile = "";
		$srcpath = "";
		$srcname = "";

		$srcfile = G5_PATH.$data_path;
		$srcpath = dirname($srcfile);
		$srcname = basename($srcfile);

		// 썸네일1 삭제
		$delFiles1 = glob($srcpath.'/thumb-'.$srcname.'*');
		if (is_array($delFiles1)) {
			foreach($delFiles1 as $srcname1) unlink($srcname1);
		}
		// 썸네일2 삭제
		$delFiles2 = glob($srcpath.'/thumb2-'.$srcname.'*');
		if (is_array($delFiles2)) {
			foreach($delFiles2 as $srcname2) unlink($srcname2);
		}
		// 원본이미지 삭제
		$delFiles = glob($srcpath.'/'.$srcname.'*');
		if (is_array($delFiles)) {
			foreach($delFiles as $srcname) unlink($srcname);
		}
	}
}

// CURL로 외부 api 값 전달
function curl_api($url,$carr) {
  
	$ch = curl_init ();

	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $carr);
    curl_exec($ch);
	curl_close ($ch);
}

// 메인화면 1주일 스케쥴
function get_week_day()
{
    global $g5, $config, $member, $comfig, $tideArr_w, $tideArr_es;

	$firstday = date(Ymd);
	$firstdayUnix = strtotime($firstday);

	$td_str="";
	$td_str .="<thead>";
	$td_str .="<tr>";

	for($i=0;$i<8;$i++)
	{
		if($i==0) {
			$wday = "선박";
		} else if($i==1) {
			$wday = "오늘";$targetday = date("Ymd"); 
		} else { 
			$j=$i-1;
			$_plusday = "+".$j." day"; 
			$targetday = date("Ymd", strtotime($_plusday,$firstdayUnix)); 
			$wday_yoil = get_yoil(date("Ymd", strtotime($_plusday,$firstdayUnix))); 
			$wday_m = date("n", strtotime($_plusday,$firstdayUnix)); 
			$wday_d = date("j", strtotime($_plusday,$firstdayUnix)); 
			$wday = $wday_m."월 ".$wday_d."일 (".$wday_yoil.")";
		}

		// 해당일 기상정보
		$fcam = sql_fetch(" select * from m_fcst where ymd='{$targetday}' and dayb='오전' ");
		if($fcam[ymd])
		{
			$wicon = "<img src='".$fcam[wicon]."' style='height:25px;'>";
			$wsky =$fcam[sky];
		}
		$fcpm = sql_fetch(" select * from m_fcst where ymd='{$targetday}' and dayb='오후' ");
		if($fcpm[ymd])
		{
			$wicon = "<img src='".$fcpm[wicon]."' style='height:25px;'>";
			$wsky = $fcpm[sky];
		}
		if(!$fcpm[ymd] && !$fcam[ymd])
		{
			$fcall = sql_fetch(" select * from m_fcst where ymd='{$targetday}' and dayb='종일' ");
			if($fcall[ymd])
			{
				$wicon = "<img src='".$fcall[wicon]."' style='height:25px;'>";
				$wsky = $fcall[sky];
			}
		}

		// 해당일 물때
		$wday_Y = substr($targetday,0,4); 
		$wday_M = substr($targetday,4,2); 
		$wday_D = substr($targetday,6,2); 

		$lunarArr = getLunarDate($wday_Y, $wday_M, $wday_D);
		$tidenum = $lunarArr[3];
		if($comfig[tide] == "7") {
			$tideName = $tideArr_w[$tidenum];
		} else if($comfig[tide] == "8") {
			$tideName = $tideArr_es[$tidenum];
		}

		$td_str .="<th>";
		$td_str .="<div>".$wday." ".$wicon."</div>";
		$td_str .="<div>".$tideName."</div>";
		$td_str .="</th>";
	}
	$td_str .="</tr>";
	$td_str .="</thead>";

	return $td_str;

}
// 메인화면 1주일 스케쥴
function get_week_schedule($s_idx)
{
    global $g5, $config, $member;

	$firstday = date(Ymd);
	$firstdayUnix = strtotime($firstday);

	for($i=0;$i<7;$i++)
	{
		if($i==0) {$sc_ymd = $firstday;}
		else { $plusday = "+".$i." day"; $sc_ymd = date("Ymd", strtotime($plusday,$firstdayUnix)); }

		// 가져올 정보 - 선박명, 출조제목, 예약가능, 예약완료, 입금대기, 
		$sc = sql_fetch(" select * from m_schedule where s_idx='{$s_idx}' and sc_ymd='{$sc_ymd}' ");
		// 해당일 설정상태
		$sc_status = $sc[sc_status];
		// 출조제목
		$sc_theme = get_text($sc[sc_theme]);
		$sc_theme_color = get_text($sc[sc_theme_color]);
		if(!$sc_theme || $sc_theme=="") {
			$sc_theme = "출조일정이 없습니다.";
			$sc_theme_color = "red";
		}
		// 출조지점
		$sc_point = get_text($sc[sc_point]);
		// 출조가격
		$sc_price = $sc[sc_price];
		// 출조공지
		$sc_desc = get_text($sc[sc_desc],1);

		// 예약인원현황
		$bkMebers = get_bk_members($s_idx, $sc_ymd);

		// 예약가능인원
		$available = $sc[sc_max] - $sc[sc_booked];
		$available_str = '<span style="color:blue;">'.$available."명</span>";
		if(!$sc[sc_idx]) 
		{
			$available = 0;
			$available_str = '<span style="color:red;">예약불가</span>';
		}
		else
		{
			if($sc[sc_status] != "0") 
			{
				$available = 0;
				$available_str = '<span style="color:red;">예약마감</span>';
			}
		}

		$td_str .="<td>";
		$td_str .="<ul>";
		$td_str .="<li><span class='sc-theme'  style='color:".$sc_theme_color.";'>※ ".$sc_theme."</span></li>";
		$td_str .="<li> - 남은자리 : ".$available_str."</li>";
		$td_str .="<li> - 예약완료 : ".$bkMebers['bkok']."</li>";
		$td_str .="<li> - 입금대기 : ".$bkMebers['bkwait']."</li>";
		$td_str .="</ul>";
		$td_str .="</td>";

	} // end for

	return $td_str;
}

// 어선별 특정일 예약완료, 예약(입금)대기 인원수 구하기
function get_bk_members($s_idx, $sc_ymd) {
    global $g5, $config, $member;

	// 예약접수인원
	$b0sql = " select bk_mb_name, bk_banker, bk_member_cnt from m_bookdata where bk_ymd='{$sc_ymd}' and bk_status='0' and s_idx='{$s_idx}' ";
	$b0result=sql_query($b0sql);
	$b0cnt = sql_num_rows($b0result);
    $b0MemberCnt = 0;
	if($b0cnt > 0) {
		$b0_array="";
		for($j=0;$row0=sql_fetch_array($b0result);$j++) {
			if($b0_array=="") {
                $b0_array="<span class='mb-bkwait'>".$row0[bk_banker]."(".$row0[bk_member_cnt].")</span>";
            } else {
                $b0_array .= "<span class='mb-bkwait'>".$row0[bk_banker]."(".$row0[bk_member_cnt].")</span>";
            }

            $b0MemberCnt += $row0[bk_member_cnt];
		}
	} else {
		$b0_array="";
	}

	// 예약완료인원
	$b1sql = " select bk_mb_name, bk_banker, bk_member_cnt from m_bookdata where bk_ymd='{$sc_ymd}' and bk_status='1' and s_idx='{$s_idx}' ";
	$b1result=sql_query($b1sql);
	$b1cnt = sql_num_rows($b1result);
    $b1MemberCnt = 0;
	if($b1cnt > 0) {
		$b1_array="";
		for($k=0;$row1=sql_fetch_array($b1result);$k++) {
			if($b1_array=="") {
                $b1_array= "<span class='mb-bkok'>".$row1[bk_banker]."(".$row1[bk_member_cnt].")</span>";
            } else {
                $b1_array .= "<span class='mb-bkok'>".$row1[bk_banker]."(".$row1[bk_member_cnt].")</span>";
            }

            $b1MemberCnt += $row1[bk_member_cnt];
		}
	} else {
		$b1_array="";
	}
	
	$bkArr = array (
		"bkwait" => $b0_array,
		"bkwaitcnt" => $b0cnt,
		"bkwaitMemberCnt" => $b0MemberCnt,
		"bkok" => $b1_array,
		"bkokcnt" => $b1cnt,
		"bkokMemberCnt" => $b1MemberCnt,
	);

	return $bkArr;

}
// 날짜값 검증
function chk_date($date) {

    if(!$date) return false;

    $date = (int)preg_replace('/[^0-9]/', '', $date);
    if (strlen($date) != 8) return false;

    $dateymd = substr($date,0,8);

    // 개별날짜 추출
    $chk_y = substr($dateymd,0,4);
    $chk_m = substr($dateymd,4,2);
    $chk_d = substr($dateymd,6,2);

    $bool = checkdate($chk_m, $chk_d, $chk_y);

    return $bool;
}

// 예약현황
function get_bk_statistics($params) {
    global $g5, $config, $member;

    /* //$params 값들
    [s_idx] => 
    [bk_status] => 1
    [dg] => o
    [bk_sdate] => 20180701
    [bk_edate] => 20180731
    [stx] => 테스트
    */
    $sql_search = "";
 
    $s_idx =  (int)preg_replace('/[^0-9]/', '', $params['s_idx']);
    if($s_idx) $sql_search .= " and s_idx='{$s_idx}' ";

    //$bk_status = $params['bk_status'];
    //if($bk_status) $sql_search .= " and bk_status='{$bk_status}' ";

    $sdate = $params['bk_sdate'];
    $edate = $params['bk_edate'];
    $dg = $params['dg'];
	if ($sdate != "" || $edate != "") 	
	{ 
		if ($dg == "o") 	
		{ 
			if ($sdate != "") { 
                $bk_sdate = str_replace("-","",$sdate); $sql_search .= " and bk_ymd >= '{$bk_sdate}'  "; 
            }
			if ($edate != "") { 
                $bk_edate = str_replace("-","",$edate); $sql_search .= " and bk_ymd <= '{$bk_edate}'  ";
            }
		}
		else if ($dg == "b") 	
		{ 
			if ($sdate != "") { 
                $bk_sdate = $sdate." 00:00:00"; $sql_search .= " and bk_datetime >= '{$bk_sdate}'  ";
            }
			if ($edate != "") { 
                $bk_edate = $edate." 23:59:59"; $sql_search .= " and bk_datetime <= '{$bk_edate}'  ";
            }
		}
	}

	$stx = trim($params['stx']);
	if($stx) {
        $sql_search .= get_sql_search_lsh("bk_tel||bk_banker||bk_memo", $stx, "and");
    }

    // 예약완료
    $r1 = sql_fetch(" select count(*) as r1cnt, ifnull(sum(bk_member_cnt),0) as r1sum, ifnull(sum(bk_price_total),0) as r1price from m_bookdata where (1) $sql_search and bk_status='1' ");
    $bk_okcnt = $r1['r1cnt'];
    $bk_oksum = $r1['r1sum'];
    $bk_okprice = $r1['r1price'];
    // 예약접수
    $r2 = sql_fetch(" select count(*) as r2cnt, ifnull(sum(bk_member_cnt),0) as r2sum, ifnull(sum(bk_price_total),0) as r2price from m_bookdata where (1) $sql_search and bk_status='0' ");
    $bk_waitcnt = $r2['r2cnt'];
    $bk_waitsum = $r2['r2sum'];
    $bk_waitprice = $r2['r2price'];
    // 예약취소
    $r3 = sql_fetch(" select count(*) as r3cnt, ifnull(sum(bk_member_cnt),0) as r3sum, ifnull(sum(cancel_amount),0) as r3price from m_bookdata where (1) $sql_search and bk_status='-1' ");
    $bk_cancelcnt = $r3['r3cnt'];
    $bk_cancelsum = $r3['r3sum'];
    $bk_cancelprice = $r3['r3price'];
   // 예약취소신청
    $r4 = sql_fetch(" select count(*) as r4cnt, ifnull(sum(bk_member_cnt),0) as r4sum, ifnull(sum(bk_price_total),0) as r4price from m_bookdata where (1) $sql_search and bk_status='-2' ");
    $bk_cancel_reqcnt = $r4['r4cnt'];
    $bk_cancel_reqsum = $r4['r4sum'];
    $bk_cancel_reqprice = $r4['r4price'];

    $rArray = array(
        "bk_okcnt" => $bk_okcnt,
        "bk_oksum" => $bk_oksum,
        "bk_okprice" => $bk_okprice,
        "bk_waitcnt" => $bk_waitcnt,
        "bk_waitsum" => $bk_waitsum,
        "bk_waitprice" => $bk_waitprice,
        "bk_cancelcnt" => $bk_cancelcnt,
        "bk_cancelsum" => $bk_cancelsum,
        "bk_cancelprice" => $bk_cancelprice,
        "bk_cancel_reqcnt" => $bk_cancel_reqcnt,
        "bk_cancel_reqsum" => $bk_cancel_reqsum,
        "bk_cancel_reqprice" => $bk_cancel_reqprice,
    );
    return $rArray;
}

?>