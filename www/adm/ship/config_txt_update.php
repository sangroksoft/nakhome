<?php
$sub_menu = "100700";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'w');

/********************************************************************에러체크*********************************************************************/
$upload_max_filesize = ini_get('upload_max_filesize');
if (empty($_POST)) alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.");
/********************************************************************에러체크*********************************************************************/

$txt1_title = '';
if (isset($_POST['txt1_title'])) 
{
    $txt1_title = substr(trim($_POST['txt1_title']),0,255);
    $txt1_title = preg_replace("#[\\\]+$#", "", $txt1_title);
}
$txt1_cont = '';
if (isset($_POST['txt1_cont'])) 
{
    $txt1_cont = substr(trim($_POST['txt1_cont']),0,255);
    $txt1_cont = preg_replace("#[\\\]+$#", "", $txt1_cont);
}

$txt2_title = '';
if (isset($_POST['txt2_title'])) 
{
    $txt2_title = substr(trim($_POST['txt2_title']),0,255);
    $txt2_title = preg_replace("#[\\\]+$#", "", $txt2_title);
}
$txt2_cont = '';
if (isset($_POST['txt2_cont'])) 
{
    $txt2_cont = substr(trim($_POST['txt2_cont']),0,255);
    $txt2_cont = preg_replace("#[\\\]+$#", "", $txt2_cont);
}

$txt3_title = '';
if (isset($_POST['txt3_title'])) 
{
    $txt3_title = substr(trim($_POST['txt3_title']),0,255);
    $txt3_title = preg_replace("#[\\\]+$#", "", $txt3_title);
}
$txt3_cont = '';
if (isset($_POST['txt3_cont'])) 
{
    $txt3_cont = substr(trim($_POST['txt3_cont']),0,255);
    $txt3_cont = preg_replace("#[\\\]+$#", "", $txt3_cont);
}

$sql = " update m_config
			set txt1_title = '{$txt1_title}', 
				 txt1_cont = '{$txt1_cont}',
				 txt2_title = '{$txt2_title}',
				 txt2_cont = '{$txt2_cont}',
				 txt3_title = '{$txt3_title}',
				 txt3_cont = '{$txt3_cont}' ";
sql_query($sql);

goto_url(G5_ADMINSHIP_URL."/config_txt.php");
?>