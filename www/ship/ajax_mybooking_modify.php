<?php
include_once('./_common.php');

$returnVal = "";

if(!$is_member){
	$errorstr = "로그인 후 이용하실 수 있습니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// ********에러검증 시작 ************//
$bk_idx = $_POST['bk_idx'];
$bk_idx =  preg_replace('/[^0-9]/', '', $bk_idx);
if(!$bk_idx || $bk_idx < 1){
	$errorstr = "예약키값 오류입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
if(!$bk['bk_idx']){
	$errorstr = "존재하지 않는 예약입니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if($bk['bk_mb_id'] != $member[mb_id]){
	$errorstr = "비정상적인 접근입니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$s_idx = $bk['s_idx'];
$sc_idx = $bk['sc_idx'];
$bk_ymd = $bk['bk_ymd'];
$bk_status = $bk['bk_status'];

// 예약상태체크
if($bk_status != 0){
	$errorstr = "예약을 수정할 수 없습니다.";
	$errorurl = "reload";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 예약인원
$bk_member_cnt = (int)preg_replace('/[^0-9-]/', '', $_POST['bk_member_cnt']);
if($bk_member_cnt < 1){
	$errorstr = "예약인원을 정확히 선택하십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$sc=sql_fetch(" select * from m_schedule where sc_idx='{$sc_idx}'");
if(!$sc['sc_idx']) {
    $errorstr = "예약설정일자 오류입니다.";
    $errorurl = "";
    $returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$sc_available = $sc['sc_max'] - $sc['sc_booked'];

/* 예약가능인원체크 - 출조가능인원을 초과하면 에러. */
if($bk_member_cnt > $sc[sc_max]){
    $errorstr = "예약가능한 인원을 초과했습니다.";
    $errorurl = "";
    $returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
/* 예약가능인원체크 - 초과예약인원을 받는 여부. */
if($bk_member_cnt > $sc_available){
    if($comfig['overbooking'] == "1") {
        ;
    } else {
        $errorstr = "예약가능한 인원을 초과했습니다.";
        $errorurl = "";
        $returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
    }
}

// 입금자명
$bk_banker = clean_xss_tags(trim($_POST['bk_banker']));
if(!$bk_banker || $bk_banker == ""){
	$errorstr = "예약자명을 입력하세요.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 예약자 핸드폰번호
$bk_tel = clean_xss_tags(trim($_POST['bk_tel']));
$bk_tel = preg_replace("/[^0-9]/", "", $bk_tel);
if(!$bk_tel){
	$errorstr = "휴대폰번호를 입력해 주십시오.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
} else {
	if(!preg_match("/^01[0-9]{8,9}$/", $bk_tel)){
		$errorstr = "휴대폰번호를 올바르게 입력해 주십시오.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
}

//$sc = sql_fetch(" select * from m_schedule where s_idx='{$s_idx}' and sc_ymd='{$bk_ymd}' ");

// 1인당 출조비용
$bk_price = $bk[bk_price];
$bk_price = (int)preg_replace('/[^0-9]/', '', $bk_price);
if(!$bk_price || $bk_price < 1){
	$errorstr = "출조비용오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

// 전체 출조비용
$bk_price_total = $bk_price * $bk_member_cnt;

// 예약메모
$bk_memo = '';
if (isset($_POST['bk_memo'])) {
	$bk_memo = substr(trim($_POST['bk_memo']),0,65536);
	$bk_memo = preg_replace("#[\\\]+$#", "", $bk_memo);
}

// 승선명부
$psgcnt = count($_POST['psg']);
if($psgcnt > 0) {
    for($i=0;$i<$psgcnt;$i++) {
        // 예약내용 업데이트
        $ps_name = clean_xss_tags(trim($_POST['psg'][$i]['ps_name']));
        $ps_sex = clean_xss_tags(trim($_POST['psg'][$i]['ps_sex']));
        $ps_birth = clean_xss_tags(trim($_POST['psg'][$i]['ps_birth']));
        $ps_tel = clean_xss_tags(trim($_POST['psg'][$i]['ps_tel']));
        $ps_addr = clean_xss_tags(trim($_POST['psg'][$i]['ps_addr']));

        sql_query(" insert into m_passenger 
                        set bk_idx = '{$bk_idx}', 
                             s_idx = '{$s_idx}', 
                             bk_ymd = '{$bk_ymd}', 
                             ps_name = '{$ps_name}', 
                             ps_sex = '{$ps_sex}', 
                             ps_tel = '{$ps_tel}', 
                             ps_birth = '{$ps_birth}', 
                             ps_addr = '{$ps_addr}',
                             regip = '{$_SERVER['REMOTE_ADDR']}',
                             regdate = '".G5_TIME_YMDHIS."' ");
    }
}

// 예약내용 업데이트
sql_query(" update m_bookdata 
				set bk_member_cnt = '{$bk_member_cnt}', 
					 bk_price = '{$bk_price}', 
					 bk_banker = '{$bk_banker}', 
					 bk_tel = '{$bk_tel}', 
					 bk_price_total = '{$bk_price_total}', 
					 bk_memo = '{$bk_memo}' 
				 where bk_idx='{$bk_idx}'  ");

//===== API 실행 ======
// 모낚에서 예약한 건만 취급하기 때문에 낚홈에서 예약한 건은 모낚으로 전송안함.
/*
$_data = array();
$_data["bk_idx"] = $bk_idx;
$_data["bk_member_cnt"] = $bk_member_cnt;
$_data["bk_banker"] = $bk_banker;
$_data["bk_tel"] = $bk_tel;
$_data["bk_price"] = $bk_price;
$_data["bk_price_total"] = $bk_price_total;
$_data["bk_memo"] = $bk_memo;

$arr = array();
$arr[com_uidx]   = $comfig[com_uidx];
$arr[data]	       = $_data;

$curlData = http_build_query($arr);
$curlUrl = "http://monak.kr/api/_bk_user_modify.php";
curl_api($curlUrl, $curlData);
*/
//===== API 종료 ======

$returnVal = json_encode(
	array(
		"rslt"=>"ok"
	)
);
echo $returnVal; exit; 

?>