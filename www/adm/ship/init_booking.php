<?php
/*
$sub_menu = "100700";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'w');

if (!($is_admin == "super" && $member[mb_id] == 'nakadmin'))  alert('최고관리자만 접근 가능합니다.');

sql_query(" truncate TABLE m_bookdata ");
sql_query(" update m_schedule set sc_booked = '0' where (1) ");

$ship = sql_fetch(" select * from m_ship where (1) order by s_idx asc limit 1 ");

for($i=0;$i<5;$i++)
{
	$bk_ymd = "20170930";
	$bk_mb_id = "test1";
	$bk_mb_name = "테스트일";
	$bk_banker = "테스트일";
	$bk_tel = "0101111111";
	$s_uidx = $ship[s_uidx];
	$s_idx = $ship[s_idx];
	$s_name = $ship[s_name];
	$bk_theme = "왕갈치출조";
	$bk_y = "2017";
	$bk_m = "09";
	$bk_d = "30";
	$bk_member_cnt = $i+1;
	$bk_price = 50000;
	$bk_price_total = $bk_price * $bk_member_cnt;
	$bk_memo = $bk_member_cnt."명 예약합니다";

	$sql = " insert into m_bookdata 
				set bk_ymd = '{$bk_ymd}', 
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

	//===== API 데이터추출 ======
	$dataTmp = array();

	$dataTmp[bk_idx] = $bk_idx;
	$dataTmp[bk_ymd] = $bk_ymd;
	$dataTmp[bk_status] = $bk_status;
	$dataTmp[bk_mb_id] = $bk_mb_id;
	$dataTmp[bk_mb_name] = $bk_mb_name;
	$dataTmp[bk_banker] = $bk_banker;
	$dataTmp[bk_tel] = $bk_tel;
	$dataTmp[s_idx] = $s_idx;
	$dataTmp[s_uidx] = $s_uidx;
	$dataTmp[s_name] = $s_name;
	$dataTmp[bk_theme] = $bk_theme;
	$dataTmp[bk_price] = $bk_price;
	$dataTmp[bk_price_total] = $bk_price_total;
	$dataTmp[bk_y] = $bk_y;
	$dataTmp[bk_m] = $bk_m;
	$dataTmp[bk_d] = $bk_d;
	$dataTmp[bk_member_cnt] = $bk_member_cnt;
	$dataTmp[bk_memo] = $bk_memo;
	$dataTmp[bk_ip] = $_SERVER['REMOTE_ADDR'];

	$_dataArr[] = $dataTmp;
	//===== API 데이터추출 ======
}
//===== API 실행 ======
$arr = array();
$arr[com_uidx]   = $comfig[com_uidx];
$arr[com_name]   = $comfig[com_name];
$arr[sdom]   = $comfig[sdom];
$arr[data]	       = $_dataArr;

$curlData = http_build_query($arr);
$curlUrl = "https://monak.kr/api/_bk_init.php";
curl_api($curlUrl, $curlData);
//===== API 종료 ======

goto_url(G5_ADMINSHIP_URL."/book_list_all.php");
*/
?>
