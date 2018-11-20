<?php
include_once('./_common.php');
/*
$returnVal = "";


	$arr = array();
	$arr[com_uidx]   = $comfig[com_uidx];
	$arr[data]	       = $_dataArr;

	$curlData = http_build_query($arr);
	$curlUrl = "https://monak.kr/api/_bk_adm_modify_all.php";
	$ch = curl_init ();
	curl_setopt ($ch, CURLOPT_URL, $curlUrl);
	curl_setopt ($ch, CURLOPT_HEADER, 0);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt ($ch, CURLOPT_REFERER, "");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $curlData);
	$buffer = curl_exec ($ch);
	$cinfo = curl_getinfo($ch);
	curl_close($ch);
	//$curl_result = json_decode($buffer);
	//print_r2($curl_result);
	//echo $curl_result->name;
	//===== API 실행 ======

	//===== API 결과처리 ======
	if ($cinfo['http_code'] != 200) {
		$errorstr = "사이트 접속오류.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	} else {
		$curl_result = json_decode($buffer);
	}

	print_r($curl_result);
	//===== API 결과처리 ======
*/
?>