<?php
include_once('./_common.php');

$returnVal = "";

if(!$wr_id)
{
	$errorstr = "키값 오류!";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

ob_start();
include './ajax_get_images_skin.php';
$content = ob_get_contents();
ob_end_clean();

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"cont"=>$content
	)
);

echo $returnVal;
?>