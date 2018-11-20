<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$result_ship = sql_query($sql_ship);
if($comfig['main_bkmode'] == "month") {
	include "./_index2_month.php";
} else if($comfig['main_bkmode'] == "week") {
	include "./_index2_week.php";
} else {
	include "./_index2_week.php";
}
?>