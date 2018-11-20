<?php
include_once('./_common.php');

$returnVal = "";

$s_idx = clean_xss_tags(trim($_GET[s_idx]));
if(!$s_idx || $s_idx < 1) 
{
	$errorstr = "키값오류입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$ship = sql_fetch(" select * from m_ship where s_idx = '{$s_idx}' ");
if(!$ship[s_idx]) 
{
	$errorstr = "존재하지 않는 어선입니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}

$shipName = get_text($ship[s_name]);
$shipDesc = get_text($ship[s_cont],1);

$svcdivstr = '';
$k=0; 
while($k < count($_menu_arr)) { 
	$m_subj = $_menu_arr[$k][0];
	$m_key = $_menu_arr[$k][1];
	
	$chkstr = "";
	if(in_array($m_key, array_map("trim", explode('|', $ship[s_service])))) $chkstr = "checked='checked' ";
	$k++; 
	
	$svcdivstr .= '<div class="col-xxs-6 col-xs-4 col-sm-4">';
	$svcdivstr .= '<input type="checkbox" id="svc_'.$m_key.'" '.$chkstr.'  onclick="return false;" />';
	$svcdivstr .= '<label for="svc_'.$m_key.'" style="padding-left:4px;">'.$m_subj.'</label>';
	$svcdivstr .= '</div>';
}

ob_start();
include './ajax_get_shipinfo_skin.php'; 
$content = ob_get_contents();
ob_end_clean();

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"cont"=>$content,
		"shipName"=>$shipName,
		"shipsvc"=>$svcdivstr,
		"shipdesc"=>$shipDesc
	)
);

echo $returnVal;
?>
