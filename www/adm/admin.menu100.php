<?php
if($member[mb_id] == "nakadmin")
{
	$menu['menu100'] = array (
		array('100000', '환경설정', G5_ADMIN_URL.'/config_form.php',   'config'),
		array('', '기본환경설정', G5_ADMIN_URL.'/config_form.php',   'cf_basic'),
		array('100500', '선사환경설정',        G5_ADMINSHIP_URL.'/config_form.php', ''),
		array('100600', '이미지설정',        G5_ADMINSHIP_URL.'/config_img.php', ''),
		array('100700', '텍스트설정',        G5_ADMINSHIP_URL.'/config_txt.php', ''),
		//array('100900', '예약초기화',        G5_ADMINSHIP_URL.'/init_booking.php', ''),
	);
}
else
{
	$menu['menu100'] = array (
		array('100000', '환경설정', G5_ADMIN_URL.'/config_form.php',   'config'),
		array('', '기본환경설정', G5_ADMIN_URL.'/config_form.php',   'cf_basic'),
		array('100500', '선사환경설정',        G5_ADMINSHIP_URL.'/config_form.php', ''),
		array('100600', '이미지설정',        G5_ADMINSHIP_URL.'/config_img.php', ''),
		array('100700', '텍스트설정',        G5_ADMINSHIP_URL.'/config_txt.php', ''),
	);
}

?>