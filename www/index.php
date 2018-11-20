<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun = "index";
//===================== 달력정보가져옴 ========================
$ymd=date(Ymd);
// 개별날짜 추출
$by = substr($ymd,0,4);
$bm = substr($ymd,4,2);
$bd = substr($ymd,6,2);
//===================== 달력정보가져옴 ========================

//===================== 어선정보가져옴 ========================
$sql_ship = " select * from m_ship where s_expose = 'y' ";
$result_ship = sql_query($sql_ship);


$ships = "";
$shipSelect = "";
$shipBigImgs = "";
$shipSmallImgs = "";

for($i=0;$srow=sql_fetch_array($result_ship);$i++) {

	// 첫번째 어선이미지
	if($i==0)
	{
		for($j=0;$j<5;$j++) {
			$_imgsql = "";
			$_imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table = 'm_ship' and wr_id = '1' and bf_no = '{$j}' ");

			$_imgsrc_alias = "img".$j;
			$$_imgsrc_alias = G5_DATA_URL."/file/m_ship/thumb2/".$_imgsql[bf_file];
			$_imgsrc2_alias = "bigimg".$j;
			$$_imgsrc2_alias = G5_DATA_URL."/file/m_ship/thumb/".$_imgsql[bf_file];

			$shipBigImgs .= "<div class='swiper-slide' style='background-image:url(".$$_imgsrc2_alias."'></div>";
			$shipSmallImgs .= "<div class='swiper-slide' style='background-image:url(".$$_imgsrc_alias."'></div>";
		}

		$svcdivstr = '';
		$k=0; 
		while($k < count($_menu_arr)) { 
			$m_subj = $_menu_arr[$k][0];
			$m_key = $_menu_arr[$k][1];
			
			$chkstr = "";
			if(in_array($m_key, array_map("trim", explode('|', $srow[s_service])))) $chkstr = "checked='checked' ";
			$k++; 
			
			$svcdivstr .= '<div class="col-xxs-6 col-xs-4 col-sm-4">';
			$svcdivstr .= '<input type="checkbox" id="svc_'.$m_key.'" '.$chkstr.' onclick="return false;" />';
			$svcdivstr .= '<label for="svc_'.$m_key.'" style="padding-left:4px;">'.$m_subj.'</label>';
			$svcdivstr .= '</div>';
		}

		$first_s_idx = $srow[s_idx];
		$is_selected = " on";
	}
	else
	{
		$is_selected = "";
	}

	// 등록어선명
	$ships .= "<li class='ship-li'><span class='ship-name".$is_selected."' data-sidx='".$srow[s_idx]."'>".get_text($srow[s_name])."</span></li>";

	// 셀렉트박스
	$shipSelect .= "<option value='".$srow[s_idx]."'>".get_text($srow[s_name])."</option>";
}

//===================== 어선정보가져옴 ========================

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
<?php include_once(G5_PATH.'/_index'.$_tpn.'.php'); ?>
<!--템플릿 include-->

<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->