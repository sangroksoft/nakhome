<?php
include_once('./_common.php');
$returnVal = "";

// ********에러검증 시작 ************//
if(count($_POST['chk']) < 1)
{
	$errorstr = "선택된 예약항목이 없습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$errcnt = 0;
for ($i=0; $i<count($_POST['chk']); $i++)
{
	// 실제 번호를 넘김
	$k = $_POST['chk'][$i];
	$bk_idx = $_POST['bk_idx'][$k];
	$bk_idx =  (int)preg_replace('/[^0-9]/', '', $bk_idx);
	if(!$bk_idx || $bk_idx < 1) {$errorstr = "예약항목 키값 오류입니다.";$errcnt++; break;}

	$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
	if(!$bk[bk_idx]) {$errorstr = " 존재하지 않는 예약항목이 있습니다.";$errcnt++; break;}

	$s_idx = $bk[s_idx];
	$bk_ymd = $bk[bk_ymd];
	$ori_bk_status = $bk[bk_status];

	$pay_amount = (int)preg_replace('/[^0-9-]/', '', $_POST['pay_amount'][$k]); // 마이너스금액 또는 0원도 있을수 있으므로 검증안함.
	$new_bk_status = $_POST['bk_status'][$k];
    // 이석호 추가 20181018
	if(!($new_bk_status == "-2" || $new_bk_status == "-1" || $new_bk_status == "0" || $new_bk_status == "1")) {$errorstr = "예약상태 오류항목이 있습니다.";$errcnt++; break;}

	$bkcntFetch = sql_fetch(" select ifnull(sum(bk_member_cnt), 0) as bkmemcnt from m_bookdata where s_idx = '{$s_idx}' and bk_ymd='{$bk_ymd}' and (bk_status = '-2' or bk_status = '1') ");
	$bkmemcnt = $bkcntFetch['bkmemcnt'];
	$bkmemcnt_tot = $bk[bk_member_cnt]+$bkcntFetch['bkmemcnt'];

	$sc = sql_fetch(" select sc_max from m_schedule where s_idx = '{$s_idx}' and sc_ymd='{$bk_ymd}' ");

    // 20181018 이석호 추가
    // 예약상태를 변경하는 순간 실시간 예약인원체크
    // 기존 예약상태가 예약완료,예약취소요청인 경우에는 이미 예약확정인원으로 잡혀있기 때문에 굳이 체크필요없음.
    // 리스트 수정항목에 인원수정항목이 없으므로 상태변화에 따른 인원변화가 있는 예약접수->예약완료만 체크하면 됨.
    // 따라서 예약접수상태에서 예약완료로 변경하는 경우에만 체크함.
	if($new_bk_status != $ori_bk_status)
	{
		if($ori_bk_status == "0")
		{
			if($new_bk_status == "1")
			{
				if($bkmemcnt_tot > $sc[sc_max]) {$errorstr = " 예약인원초과 항목이 있습니다."; $errcnt++; break;}
			}
		}
	}
}
if($errcnt > 0)
{
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

for ($i=0; $i<count($_POST['chk']); $i++)
{
	// 실제 번호를 넘김
	$k = $_POST['chk'][$i];
	$bk_idx = $_POST['bk_idx'][$k];
	$bk_idx =  (int)preg_replace('/[^0-9]/', '', $bk_idx);

	$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
	$s_idx = $bk[s_idx];
	$bk_ymd = $bk[bk_ymd];
	$ori_bk_status = $bk[bk_status];

	$pay_amount = (int)preg_replace('/[^0-9-]/', '', $_POST['pay_amount'][$k]); // 마이너스금액 또는 0원도 있을수 있으므로 검증안함.
	$new_bk_status = $_POST['bk_status'][$k];

	$bkcntFetch = sql_fetch(" select  ifnull(sum(bk_member_cnt), 0) as bkmemcnt from m_bookdata where s_idx = '{$s_idx}' and bk_ymd='{$bk_ymd}' and (bk_status = '-2' or bk_status = '1') ");
	$bkmemcnt = $bkcntFetch['bkmemcnt'];
	$bkmemcnt_tot = $bk[bk_member_cnt]+$bkcntFetch['bkmemcnt'];
	$ori_bk_member_cnt = $bk[bk_member_cnt];

	$sc = sql_fetch(" select sc_max from m_schedule where s_idx = '{$s_idx}' and sc_ymd='{$bk_ymd}' ");

	$bkSql = "";
	$scSql = "";
	$api_bk_status = "";
	$api_cancel_datetime = "";

	if($new_bk_status != $ori_bk_status)
	{
		if($ori_bk_status == "-2") // 기존예약상태가 예약취소요청
		{
			if($new_bk_status == "-1") // 신규상태를 예약취소로 변경하는 경우
			{
				$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '".G5_TIME_YMDHIS."' ";
				$scSql = " sc_booked = sc_booked - $ori_bk_member_cnt ";
				$api_bk_status = $new_bk_status;
				$api_cancel_datetime = G5_TIME_YMDHIS;
			}
			else if($new_bk_status == "1") // 신규상태를 예약완료로 변경하는 경우
			{
				$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '' ";
				$api_bk_status = $new_bk_status;
				$api_cancel_datetime = "0";
			}
		}
		else if($ori_bk_status == "0") // 기존예약상태가 예약접수
		{
			if($new_bk_status == "-1") // 신규상태를 예약취소로 변경하는 경우
			{
				$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '".G5_TIME_YMDHIS."' ";
				$api_bk_status = $new_bk_status;
				$api_cancel_datetime = G5_TIME_YMDHIS;
			}
			else if($new_bk_status == "1") // 신규상태를 예약완료로 변경하는 경우
			{
				$bkSql = " , bk_status='{$new_bk_status}' ";
				$scSql = " sc_booked = sc_booked + $ori_bk_member_cnt ";
				$api_bk_status = $new_bk_status;
			}
		}
		else if($ori_bk_status == "1") // 기존예약상태가 예약완료
		{
			if($new_bk_status == "-1") // 신규상태를 예약취소로 변경하는 경우
			{
				$bkSql = " , bk_status='{$new_bk_status}' , cancel_datetime = '".G5_TIME_YMDHIS."' ";
				$scSql = " sc_booked = sc_booked - $ori_bk_member_cnt ";
				$api_bk_status = $new_bk_status;
				$api_cancel_datetime = G5_TIME_YMDHIS;
			}
		}
	}

	sql_query(" update m_bookdata set pay_amount = '{$pay_amount}' $bkSql where bk_idx = '{$bk_idx}'  ");
	if($scSql != "") sql_query(" update m_schedule set $scSql where s_idx='{$s_idx}' and sc_ymd = '{$bk_ymd}'  ");

	//===== API 데이터추출 ======

	if($bk[bk_channel] != "") {
		$dataTmp = array();
		$dataTmp[bk_status] = $api_bk_status;
		$dataTmp[cancel_datetime] = $api_cancel_datetime;
		$dataTmp[pay_amount] = $pay_amount;
		$dataTmp[bk_idx] = $bk_idx;
		$_dataArr[] = $dataTmp;
	}
	//===== API 데이터추출 ======
}

//===== API 실행 ======
/*
if(count($_dataArr) > 0) {
	$arr = array();
	$arr[com_uidx]   = $comfig[com_uidx];
	$arr[data]	       = $_dataArr;

	$curlData = http_build_query($arr);
	$curlUrl = "https://monak.kr/api/_bk_adm_modify_all.php";
	curl_api($curlUrl, $curlData);
}
*/
//===== API 종료 ======

$returnVal = json_encode(
	array(
		"rslt"=>"ok",
		"datas"=>$arr
	)
);
echo $returnVal; exit; 

?>