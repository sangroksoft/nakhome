<?php
$sub_menu = "100100";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

$sql = " update {$g5['config_table']}
            set cf_title = '{$_POST['cf_title']}',
                cf_admin_email = '{$_POST['cf_admin_email']}',
                cf_admin_email_name = '{$_POST['cf_admin_email_name']}',
                cf_admin_tel = '{$_POST['cf_admin_tel']}',
                cf_possible_ip = '".trim($_POST['cf_possible_ip'])."',
                cf_intercept_ip = '".trim($_POST['cf_intercept_ip'])."',
                cf_analytics = '{$_POST['cf_analytics']}',
                cf_add_meta = '{$_POST['cf_add_meta']}',
                cf_delay_sec = '{$_POST['cf_delay_sec']}',
                cf_filter = '{$_POST['cf_filter']}',
                cf_prohibit_id = '{$_POST['cf_prohibit_id']}',
                cf_prohibit_email = '{$_POST['cf_prohibit_email']}',
                cf_register_point = '{$_POST['cf_register_point']}',
                cf_stipulation = '{$_POST['cf_stipulation']}',
                cf_privacy = '{$_POST['cf_privacy']}' ";
sql_query($sql);

$mb_password    = trim($_POST['mb_password']);
if ($mb_password && $mb_password != "")
{
	$sqlmem = " update {$g5['member_table']} set mb_password = '".get_encrypt_string($mb_password)."' where mb_id = '{$member[mb_id]}' ";
	sql_query($sqlmem);
}

//sql_query(" OPTIMIZE TABLE `$g5[config_table]` ");

goto_url('./config_form.php', false);
?>