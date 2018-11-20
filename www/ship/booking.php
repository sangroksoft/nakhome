<?php
include_once('./_common.php');
$pgubun = "booking";

if($comfig['bkmode']) {
	if($comfig['bkmode'] == "ver1") {
		include './booking_ver1.php';
	} else if($comfig['bkmode'] == "ver2") {
		include './booking_ver2.php';
	} else {
		include './booking_ver1.php';
	}
} else {
	include './booking_ver1.php';
}
?>