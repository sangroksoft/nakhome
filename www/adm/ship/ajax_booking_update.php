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

if($w=="u") {
	$bk_idx = clean_xss_tags(trim($_POST[bk_idx]));
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
	
	// 예약상태
	$ori_bk_status = $bk['bk_status'];
	$new_bk_status = $_POST['bk_status'];

	// 예약인원
	$ori_bk_member_cnt = $bk[bk_member_cnt];
	$new_bk_member_cnt = clean_xss_tags(trim($_POST[bk_member_cnt]));
	$new_bk_member_cnt = preg_replace('/[^0-9]/', '', $new_bk_member_cnt);
	if(!$new_bk_member_cnt || $new_bk_member_cnt < 1)
	{
		$errorstr = "예약인원을 숫자로 입력하십시오.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}

	/* 예약가능인원체크 - 여분의 예약인원을 받으려면 아래 주석처리함. 반대로 해당일 정원만큼만 예약인원을 받으려면 주석해제. */
	$sc = sql_fetch(" select * from m_schedule where s_idx='{$bk[s_idx]}' and sc_ymd='{$bk[bk_ymd]}' ");

    // 아래는 예약가능인원만 체크하기 때문에 새로변경되는 예약상태가 의미 없음. 즉 예약완료만을 가정함.
    // '예약취소요청'도 아직 상태변경전이라면 '예약완료'와 동일함.
    // 20181018 이석호 추가
	if($ori_bk_status == "0") { // 원래상태가 예약접수시(예약접수,예약완료,예약취소 가능)
		$sc_available = $sc[sc_max] - $sc[sc_booked];
	} else if($ori_bk_status == "1") { // 원래상태가 예약완료시(예약완료, 예약취소 가능)
		$sc_available =$sc[sc_max] - ($sc[sc_booked] - $ori_bk_member_cnt);
	} else if($ori_bk_status == "-1") { // 원래상태가 예약취소시(변경할 상태 없음)
		;
	} else if($ori_bk_status == "-2") { // 원래상태가 예약취소요청시(예약취소요청,예약완료,예약취소 가능)
		$sc_available =$sc[sc_max] - ($sc[sc_booked] - $ori_bk_member_cnt);
	}

	if($new_bk_member_cnt > $sc_available)
	{
		$errorstr = "예약가능한 인원을 초과했습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}

	// 총출조비용
	$bk_price_total = clean_xss_tags(trim($_POST['bk_price_total']));
	$bk_price_total = (int)preg_replace('/[^0-9]/', '', $bk_price_total);
	if(!$bk_price_total || $bk_price_total < 1)
	{
		$errorstr = "출조비용오류입니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	// 입금액
	$pay_amount = (int)preg_replace('/[^0-9-]/', '', $_POST['pay_amount']); // 마이너스금액 또는 0원도 있을수 있으므로 검증안함.

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
		$errorstr = "예약자 연락처를 입력해 주십시오.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	else 
	{
		if(!preg_match("/^01[0-9]{8,9}$/", $bk_tel))
		{
			$errorstr = "연락처를 올바르게 입력해 주십시오.";
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

	$bkSql = "";
	$scSql = "";
	$bk_member_cnt_gap = $new_bk_member_cnt - $ori_bk_member_cnt;

	if($new_bk_status != $ori_bk_status) // 예약상태가 변경되는 경우
	{
		if($ori_bk_status == "-2") // 기존예약상태가 예약취소요청
		{
			if($new_bk_status == "-1") // 예약취소로 변경하는 경우
			{
				$bkSql = "
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}', 
					 pay_amount = '{$pay_amount}', 
					 bk_memo = '{$bk_memo}',
					 bk_status='{$new_bk_status}' , 
					 cancel_datetime = '".G5_TIME_YMDHIS."' ";
				$scSql = " sc_booked = sc_booked - $ori_bk_member_cnt ";
			}
			else if($new_bk_status == "1") // 예약완료로 변경하는 경우
			{
				$bkSql = "
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}', 
					 bk_member_cnt = '{$new_bk_member_cnt}',
					 pay_amount = '{$pay_amount}', 
					 bk_memo = '{$bk_memo}',
					 bk_status='{$new_bk_status}' , 
					 cancel_datetime = '' ";
				$scSql = " sc_booked = sc_booked + $bk_member_cnt_gap ";
			}
		}
		else if($ori_bk_status == "0") // 기존예약상태가 예약접수
		{
			if($new_bk_status == "-1") // 예약취소로 변경하는 경우(기존예약접수상태는 예약인원이 확정되지 않은 상태이므로 sc_booked 는 변화 없음.
			{
				$bkSql = "
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}', 
					 pay_amount = '{$pay_amount}', 
					 bk_memo = '{$bk_memo}',
					 bk_status='{$new_bk_status}' , 
					 cancel_datetime = '".G5_TIME_YMDHIS."' ";
			}
			else if($new_bk_status == "1") // 예약완료로 변경하는 경우
			{
				$bkSql = "
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}', 
					 bk_member_cnt = '{$new_bk_member_cnt}',
					 pay_amount = '{$pay_amount}', 
					 bk_memo = '{$bk_memo}',
					 bk_status='{$new_bk_status}' , 
					 cancel_datetime = '' ";
				$scSql = " sc_booked = sc_booked + $new_bk_member_cnt ";
			}
		}
		else if($ori_bk_status == "1") // 기존예약상태가 예약완료
		{
			if($new_bk_status == "-1") // 예약취소로 변경하는 경우
			{
				$bkSql = "
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}', 
					 pay_amount = '{$pay_amount}', 
					 bk_memo = '{$bk_memo}',
					 bk_status='{$new_bk_status}' , 
					 cancel_datetime = '".G5_TIME_YMDHIS."' ";
				$scSql = " sc_booked = sc_booked - $ori_bk_member_cnt ";
			}
		}

		sql_query(" update m_bookdata 	set  $bkSql  where	bk_idx='{$bk_idx}' ");
		sql_query(" update m_schedule set  $scSql  where s_idx='{$bk[s_idx]}' and sc_ymd = '{$bk[bk_ymd]}'  ");

	}
	else // 예약상태 변경이 없는 경우 - 예약접수, 예약완료, 예약취소요청 상태에서 가능
	{
		$sql = "	 update m_bookdata 
						set	 bk_banker = '{$bk_banker}', 
							 bk_tel = '{$bk_tel}', 
							 bk_price_total = '{$bk_price_total}', 
							 bk_member_cnt = '{$new_bk_member_cnt}',
							 pay_amount = '{$pay_amount}', 
							 bk_memo = '{$bk_memo}' 
						where bk_idx='{$bk_idx}'	 ";
		sql_query($sql);
        
        // 인원 변경이 있다면
		if($bk_member_cnt_gap != "0"){
			sql_query(" update m_schedule set  sc_booked = sc_booked + $bk_member_cnt_gap where s_idx='{$bk[s_idx]}' and sc_ymd = '{$bk[bk_ymd]}'  ");
		}
	}

} else if($w=="") {

	$bk_status = clean_xss_tags(trim($_POST[bk_status]));
	if(!($bk_status =="0" || $bk_status =="1")) 
	{
		$errorstr = "예약상태 오류입니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}

	//===================== 어선정보가져옴 ========================
	$s_idx = clean_xss_tags(trim($_POST[s_idx]));
	if(!$s_idx || $s_idx < 1) 
	{
		$errorstr = "어선키값 오류입니다.";
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

	/*
	$ship_available = $ship[s_max];
	if($bk_member_cnt > $ship_available)
	{
		$errorstr = "예약가능한 인원을 초과했습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	*/
	//===================== 달력정보가져옴 ========================
	$bk_ymd = trim($_POST[sc_ymd]);
	$bk_ymd = (int)preg_replace('/[^0-9]/', '', $bk_ymd);
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
	if(!$sc[sc_idx])
	{
		$errorstr = "선택하신 예약일자에 예약할 수 없습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	if($sc[sc_status] != "0")
	{
		$errorstr = "선택하신 예약일자에 예약할 수 없습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	/* 예약가능인원체크 - 여분의 예약인원을 받으려면 아래 주석처리함. 반대로 해당일 정원만큼만 예약인원을 받으려면 주석해제. */
	$sc_available = $sc[sc_max] - $sc[sc_booked];
	if($bk_member_cnt > $sc_available)
	{
		$errorstr = "예약가능한 인원을 초과했습니다.".$sc_available."-- ".$bk_member_cnt;
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
		$errorstr = "출조비용오류입니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}

	// 전체 출조비용
	//$bk_price_total = $bk_price * $bk_member_cnt;
	$bk_price_total = trim($_POST[bk_price_total]);
	$bk_price_total = (int)preg_replace('/[^0-9]/', '', $bk_price_total);

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
					set bk_ymd = '{$bk_ymd}', 
						 bk_status = '{$bk_status}', 
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

	if($bk_status == "1"){ // 예약완료로 바로 처리하는 경우에 스케쥴테이블에도 업데이트
		sql_query(" update m_schedule set  sc_booked = sc_booked + $bk_member_cnt  where s_idx='{$s_idx}' and sc_ymd = '{$bk_ymd}'  ");
	}
	/*
	// 문자 발송
	$smstext = "[홈페이지 예약 접수]\n".$s_name."/".$bk_m."월 ".$bk_d."일\n".$bk_banker."님 외 ".($bk_member_cnt*1-1)."명";
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
	*/

}

$returnVal = json_encode(
	array(
		"rslt"=>"ok",
		"bkidx"=>$bk_idx
	)
);

echo $returnVal;
?>
