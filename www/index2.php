<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "index";


// 슬라이더이미지
$msimgcnt = 0;
for($i=0;$i<5;$i++) {
	$msimgsql = "";
	$msimgsql = sql_fetch(" select * from g5_board_file where bo_table = 'mainslider' and wr_id = '1' and bf_no = '{$i}' ");
	if($msimgsql[bf_file] != "") $msimgcnt++;
	$msimgsrc_alias = "msimg".$i;
	$$msimgsrc_alias = G5_DATA_URL."/file/mainslider/".$msimgsql[bf_file];
	$msimgcont_alias = "msimgcont".$i;
	$$msimgcont_alias = get_text($msimgsql[bf_content]);
}

// 박스타이틀, 내용
$txt1_title = get_text(trim($comfig[txt1_title]));
$txt1_cont = get_text(trim($comfig[txt1_cont]));
$txt1_cont = str_replace("|","<br class='br-merit'>",$txt1_cont);

$txt2_title = get_text(trim($comfig[txt2_title]));
$txt2_cont = get_text(trim($comfig[txt2_cont]));
$txt2_cont = str_replace("|","<br class='br-merit'>",$txt2_cont);

$txt3_title = get_text(trim($comfig[txt3_title]));
$txt3_cont = get_text(trim($comfig[txt3_cont]));
$txt3_cont = str_replace("|","<br class='br-merit'>",$txt3_cont);

include_once(G5_PATH.'/head.php');
?>

<!--템플릿 include-->
<?php include_once(G5_PATH.'/_index22.php'); ?>
<!--템플릿 include-->

<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->