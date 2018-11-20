<?php
include_once('./_common.php');

$returnVal = "";

$w = $_GET['w'];
if(!($w == '' || $w == 'u'))
{
	$errorstr = "작성구분값 오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$newId = $_GET['newId'];
$newId = (int)preg_replace('/[^0-9]/', '', $_GET['newId']);

ob_start();
include './ajax_add_theme_skin.php';
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