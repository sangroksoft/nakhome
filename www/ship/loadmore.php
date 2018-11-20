<?php
include_once('./_common.php');

$ca_sql = "";
if($ca_name) $ca_sql = " and ca_name = '$ca_name' ";

$content = "";

$blocknum1 = $clickcnt;
$start_num1 = $pgcnt*$blocknum1;	
$end_num2 = $pgcnt;	

$sql1 = " select * from g5_write_gallery where wr_is_comment = '0' $ca_sql order by wr_datetime desc limit {$start_num1}, {$end_num2} ";
$result1 = sql_query($sql1);

$blocknum2 = $clickcnt+1;
$start_num2 = $pgcnt*$blocknum2;	
$end_num2 = $pgcnt;	

$sql2 = " select * from g5_write_gallery where wr_is_comment = '0' $ca_sql order by wr_datetime desc limit {$start_num2}, {$end_num2} ";
$result2 = sql_query($sql2);
$block2_cnt = sql_num_rows($result2);

ob_start();
include './loadmore_skin.php';
$content = ob_get_contents();
ob_end_clean();

$returnVal = $content;

echo $returnVal;
?>
