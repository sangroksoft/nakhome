<?php
$sub_menu = "420000";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'w');

$pgubun = "book_config";

/*===============날짜정보================*/
// 파라미터로 넘어온 년월일
$ym = trim($_REQUEST[ym]);
$ym = (int)preg_replace('/[^0-9]/', '', $ym);
if(!$ym || $ym < 200001 || $ym > 205101) $ym = "";

//날짜자리수체크
if (strlen($ym) != 6) $ym = "";

// 현재일자
$now_ym = date(Ym);
$now_ymd = date(Ymd);

// 넘어온 일자에 문제가 있다면 현재일자로 치환
if($ym=="") $ym=$now_ym;
// 개별날짜 추출
$cy = substr($ym,0,4);
$cm = substr($ym,4,2);
$ym = $cy.$cm;

$_tmp_ymd = $ym."01";
// 선택년월의 최종일
$lastday = date('t', strtotime($_tmp_ymd));
/*===============날짜정보================*/

/*===============어선정보================*/
$s_idx = (int)preg_replace('/[^0-9]/', '', $_REQUEST['s_idx']);
if(!$s_idx || $s_idx < 1) alert("어선키값 오류입니다.");

$shipsql = " select * from m_ship where s_idx = '{$s_idx}' ";
$ship = sql_fetch($shipsql);

if(!$ship['s_idx']) alert("존재하지 않는 어선입니다.");
$s_name = get_text($ship[s_name]);

$g5['title'] = $s_name." - 예약설정";

$sql = " select * from m_schedule where s_idx='{$s_idx}' and sc_y = '{$cy}' and sc_m = '{$cm}' order by sc_d asc ";
$result = sql_query($sql);
$totcnt = sql_num_rows($result);

include_once(G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_ADMINSHIP_PATH.'/ml_layer.php');
?>
<link rel="stylesheet" href="<?php echo G5_URL;?>/assets/plugins/datepicker/bootstrap-datepicker.css">
<script type="text/javascript" src="<?php echo G5_URL;?>/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo G5_URL;?>/assets/plugins/datepicker/bootstrap-datepicker.kr.min.js"></script>


<style>
.selectbox100{width:100px;height:24px;}
.tbl_head01 thead th, .tbl_head01 tbody td {text-align:center;}
.tbl_head01 tbody td {padding:2px 4px;}
.tbl_head01 td input {border: 1px solid #ddd;padding: 1px 5px;}
.tbl_head01 tbody td.td-img {position:relative;}
#fpdsearch input[type="submit"] {height: 26px;padding: 2px 20px;}
.tbl_head01 th.sch-th {background:#e5ecef;width:150px;}
.divfloat{float:left;padding-right:4px;width:170px;}
.tbl_head01 tbody td.ta-left {text-align:left;}
.btn_list01 {margin-bottom: 20px;}
.local_desc01 {clear:both;margin: 10px 0px;padding: 10px 20px 0;min-width: 920px;border: 1px solid #f2f2f2;background: #f9f9f9;}

.showmodal{cursor:pointer;}
.cal-select{height: 28px;margin:0 auto; text-align:center;padding-bottom: 20px;}
.cal-arrow{width: 28px;height: 28px;display: inline-block;cursor:pointer;}
.current-month{width: 160px;height: 24px;display: inline-block;line-height: 16px;font-size: 16px;font-weight: bolder;color: #909090;padding-top: 4px;}
.datepicker{position:absolute;width:250px;background:#fff;padding:0px;}

.btn-list-modi{background:#f3f3f3;border:1px solid #ccc; padding:5px;outline:none !important;}
</style>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
<link href="<?php echo G5_PLUGIN_URL;?>/colorpicker/css/evol-colorpicker.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="<?php echo G5_PLUGIN_URL;?>/colorpicker/js/evol-colorpicker.min.js" type="text/javascript"></script>
<style>
.evo-colorind, .evo-colorind-ie, .evo-colorind-ff {margin-top: 4px;border-radius: 50%;}
.tbl_head01 tbody td .evo-palette2 tbody td {padding: 6px 7px;}
.tbl_head01 table .evo-palette2, .evo-palette2-ie{width:auto;}
.tbl_head01 tbody td .evo-palette tbody td{padding:7px;}
</style>

<form name="fsclist" id="fsclist" onsubmit="return fsclist_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="s_idx" value="<?php echo $s_idx;?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<div class="tbl_head01 tbl_wrap" style="padding: 18px 20px;">
	<div class="cal-select">
		<span class="prev-month cal-arrow"><img src="<?php echo G5_IMG_URL;?>/back.png"></span>
		<span class="current-month">
			<select id="go_y" class="selectbox">
				<?php for($i=2000;$i<2051;$i++) { ?>
				<option value="<?php echo $i;?>" <?php if($cy == $i) echo "selected='selected'";?>><?php echo $i;?></option>
				<?php } ?>
			</select>
			<select id="go_m" class="selectbox" onchange="chgym();">
				<option value="01" <?php if($cm == "01") echo "selected='selected'";?>>01</option>
				<option value="02" <?php if($cm == "02") echo "selected='selected'";?>>02</option>
				<option value="03" <?php if($cm == "03") echo "selected='selected'";?>>03</option>
				<option value="04" <?php if($cm == "04") echo "selected='selected'";?>>04</option>
				<option value="05" <?php if($cm == "05") echo "selected='selected'";?>>05</option>
				<option value="06" <?php if($cm == "06") echo "selected='selected'";?>>06</option>
				<option value="07" <?php if($cm == "07") echo "selected='selected'";?>>07</option>
				<option value="08" <?php if($cm == "08") echo "selected='selected'";?>>08</option>
				<option value="09" <?php if($cm == "09") echo "selected='selected'";?>>09</option>
				<option value="10" <?php if($cm == "10") echo "selected='selected'";?>>10</option>
				<option value="11" <?php if($cm == "11") echo "selected='selected'";?>>11</option>
				<option value="12" <?php if($cm == "12") echo "selected='selected'";?>>12</option>
			</select>
		</span>
		<!--
		<span id="datepicker"><input type="text" value="2019-01-02"></span>
		-->
		<span class="next-month cal-arrow"><img src="<?php echo G5_IMG_URL;?>/next.png"></span>
	</div>
	<div class="lg-hidden" style="text-align: center;margin-bottom: 5px">
		<span>* 출조 제목, 출조 지점, 공지사항은 스마트폰을 가로로 돌려 수정하실 수 있습니다.</span>
	</div>
	<?php if($ym >= $now_ym) { ?>
	<div class="btn_list01" id="book_modal">
		<button type="button" style="vertical-align:bottom;" class="showmodal" id="btn_modal" data-tgt="monthly" data-valarr="<?php echo $ym;?>|<?php echo $s_idx;?>"><?php echo $cm;?>월 일괄설정</button>
	</div>
	<?php } ?>
	<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<thead>
			<tr>
				<th scope="col">날짜</th>
				<th scope="col" class="m-width-75">예약상태</th>
				<th scope="col" class="xs-hidden">출조제목</th>
				<th scope="col" class="xs-hidden">출조지점</th>
				<th scope="col" class="m-width-70">출조비용</th>
				<th scope="col" class="m-width-70">예약가능인원</th>
				<th scope="col" class="xs-hidden">공지사항</th>
				<th scope="col">개별설정</th>
			</tr>
		</thead>
		<tbody>
		<?php if($totcnt > 0) { ?>
			<?php for($i=0;$row=sql_fetch_array($result);$i++) { ?>
			<?php
			$list = $i%2;
			$bg = 'bg'.($i%2);
			// 날짜
			$sc_ym = $row[sc_y].$row[sc_m];
			$sc_ymd = $row[sc_y]."-".$row[sc_m]."-".$row[sc_d];
			// 출조제목
			$sc_theme = get_text($row[sc_theme]);
			// 출조테마폰트컬러
			$sc_theme_color = "#333333";
			if($row[sc_theme_color]) $sc_theme_color = $row[sc_theme_color];
			// 출조지점
			$sc_point = get_text($row[sc_point]);
			// 출조비용
			$sc_price = $row[sc_price];
			// 예약가능인원
			$sc_max = get_text($row[sc_max]);
			// 공지사항
			$sc_desc = get_text($row[sc_desc]);
			// 요일추출
			$thisDay = $row[sc_y]."-".$row[sc_m]."-".$row[sc_d];
			$wd = date('w', strtotime($thisDay));
			switch($wd)
			{
				case(0) : $weekday = "<span style='color:red;'>일</span>"; break;
				case(1) : $weekday = "<span style='color:#777;'>월</span>"; break;
				case(2) : $weekday = "<span style='color:#777;'>화</span>"; break;
				case(3) : $weekday = "<span style='color:#777;'>수</span>"; break;
				case(4) : $weekday = "<span style='color:#777;'>목</span>"; break;
				case(5) : $weekday = "<span style='color:#777;'>금</span>"; break;
				case(6) : $weekday = "<span style='color:blue;'>토</span>"; break;
			}	
			// 음력추출
			$lunarArr = getLunarDate($row[sc_y], $row[sc_m], $row[sc_d]);
			$lunarYmd = $lunarArr[1]."-".$lunarArr[2]."-".$lunarArr[3];
			// 물때 추출
			$tidenum = $lunarArr[3];
			if($comfig[tide] == "7")
				$tideName = $tideArr_w[$tidenum];
			else if($comfig[tide] == "8")
				$tideName = $tideArr_es[$tidenum];

			// 과거날짜면 readonly로
			$readOnly = $reQuired = "";
			if($sc_ym < $now_ym) {$readOnly = " readonly='readonly' "; $reQuired = ""; }
			?>
			<tr>
				<td class="td150">
					<?php echo $sc_ymd;?> (<?php echo $weekday;?>) - <?php echo $tideName; ?>
					<input type="hidden" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
					<input type="hidden" name="s_idx[<?php echo $i ?>]" value="<?php echo $row['s_idx'] ?>" id="s_idx_<?php echo $i ?>">
					<input type="hidden" name="sc_ymd[<?php echo $i ?>]" value="<?php echo $row['sc_ymd'] ?>" id="sc_ymd_<?php echo $i ?>">
				</td>
				<td class="td100">
					<select id="sc_status_<?php echo $row[sc_ymd];?>" name="sc_status[<?php echo $i ?>]" class="scstatus selectbox w100" <?php echo $readOnly;?>>
						<option value="0" <?php if($row[sc_status] == "0") echo "selected='selected'";?>>예약가능</option>
						<option value="1" <?php if($row[sc_status] == "1") echo "selected='selected'";?>>예약마감</option>
					</select>
				</td>
				<td class="td250 xs-hidden">
					<div style="float:left;">
						<input type="text" id="sc_theme_<?php echo $row[sc_ymd];?>" name="sc_theme[<?php echo $i ?>]" value="<?php echo $sc_theme;?>" class="w95 <?php echo $reQuired;?>" required="required" maxlength="255" <?php echo $readOnly;?>></div>
					<div style="float:left;"><input type="hidden" class="noIndColor" id="sc_theme_color_<?php echo $row[sc_ymd];?>" name="sc_theme_color[<?php echo $i ?>]" value="<?php echo $sc_theme_color;?>" /></div>
				</td>
				<td class="td150 xs-hidden">
					<input type="text" id="sc_point_<?php echo $row[sc_ymd];?>" name="sc_point[<?php echo $i ?>]" value="<?php echo $sc_point;?>" class="w95 <?php echo $reQuired;?>" required="required" maxlength="255" <?php echo $readOnly;?>>
				</td>
				<td class="td90">
					<input type="number" id="sc_price_<?php echo $row[sc_ymd];?>" name="sc_price[<?php echo $i ?>]" value="<?php echo $sc_price;?>" class="w85 <?php echo $reQuired;?>" required="required" <?php echo $readOnly;?>>
				</td>
				<td class="td70">
					<input type="number" id="sc_max_<?php echo $row[sc_ymd];?>" name="sc_max[<?php echo $i ?>]" value="<?php echo $sc_max;?>" class="w80 <?php echo $reQuired;?>" required="required" <?php echo $readOnly;?>>
				</td>
				<td class="tdmin200 xs-hidden">
					<input type="text" id="sc_desc_<?php echo $row[sc_ymd];?>" name="sc_desc[<?php echo $i ?>]" value="<?php echo $sc_desc;?>" class="w98" maxlength="255" <?php echo $readOnly;?>>
				</td>
				<td class="td90">
					<button type="button" class="btn-list-modi" data-scymd="<?php echo $row[sc_ymd];?>"  style="vertical-align:bottom;">설정적용</button>
				</td>
			</tr>
			<?php } ?>
		<?php }	else { ?>
			<?php for($i=0;$i<$lastday;$i++) { ?>
			<?php
			// 날짜
			$_day = $i+1;
			if($_day < 10) $_day = "0".$_day;
			$sc_ym = $cy.$cm;
			$sc_ymd = $cy."-".$cm."-".$_day;
			// 출조제목
			$sc_theme = "";
			// 출조지점
			$sc_point = "";
			// 출조비용
			$sc_price = "";
			// 예약가능인원
			$sc_max = "";
			// 현재예약인원
			$sc_bookcnt = "";
			// 공지사항
			$sc_desc = "";
			// 요일추출
			$thisDay = $sc_ymd;
			$wd = date('w', strtotime($thisDay));
			switch($wd)
			{
				case(0) : $weekday = "<span style='color:red;'>일</span>"; break;
				case(1) : $weekday = "<span style='color:#777;'>월</span>"; break;
				case(2) : $weekday = "<span style='color:#777;'>화</span>"; break;
				case(3) : $weekday = "<span style='color:#777;'>수</span>"; break;
				case(4) : $weekday = "<span style='color:#777;'>목</span>"; break;
				case(5) : $weekday = "<span style='color:#777;'>금</span>"; break;
				case(6) : $weekday = "<span style='color:blue;'>토</span>"; break;
			}	
			// 음력추출
			$lunarArr = getLunarDate($cy, $cm, $_day);
			$lunarYmd = $lunarArr[1]."-".$lunarArr[2]."-".$lunarArr[3];
			// 물때 추출
			$tidenum = $lunarArr[3];
			$tideName = $tideArr_w[$tidenum];

			// 과거날짜면 readonly로
			$readOnly = $reQuired = "";
			if($sc_ym < $now_ym) {$readOnly = " readonly='readonly' "; $reQuired = ""; }
			?>
			<tr>
				<td class="td150">
					<?php echo $sc_ymd;?> (<?php echo $weekday;?>) - <?php echo $tideName; ?>
					<input type="hidden" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
					<input type="hidden" name="s_idx[<?php echo $i ?>]" value="<?php echo $row['s_idx'] ?>" id="s_idx_<?php echo $i ?>">
					<input type="hidden" name="sc_ymd[<?php echo $i ?>]" value="<?php echo $row['sc_ymd'] ?>" id="sc_ymd_<?php echo $i ?>">
				</td>
				<td class="td100">
					<select name="sc_status[<?php echo $i ?>]" class="scstatus selectbox w100" <?php echo $readOnly;?>>
						<option value="0" <?php if($row[sc_status] == "0") echo "selected='selected'";?>>예약가능</option>
						<option value="1" <?php if($row[sc_status] == "1") echo "selected='selected'";?>>예약마감</option>
					</select>
				</td>
				<td class="td250 xs-hidden">
					<input type="text" name="sc_theme[<?php echo $i ?>]" value="<?php echo $sc_theme;?>" class="w95 <?php echo $reQuired;?>" required="required" maxlength="255" <?php echo $readOnly;?>>
					<input type="hidden" name="sc_theme_color[<?php echo $i ?>]" value="#333333" />
				</td>
				<td class="td250 xs-hidden"><input type="text" name="sc_point[<?php echo $i ?>]" value="<?php echo $sc_point;?>" class="w95 <?php echo $reQuired;?>" required="required" maxlength="255" <?php echo $readOnly;?>></td>
				<td class="td90"><input type="number" name="sc_price[<?php echo $i ?>]" value="<?php echo $sc_price;?>" class="w85 <?php echo $reQuired;?>" required="required" <?php echo $readOnly;?>></td>
				<td class="td70"><input type="number" name="sc_max[<?php echo $i ?>]" value="<?php echo $sc_max;?>" class="w80 <?php echo $reQuired;?>" required="required"></td>
				<td class="tdmin200 xs-hidden"><input type="text" name="sc_desc[<?php echo $i ?>]" value="<?php echo $sc_desc;?>" class="w98" maxlength="255" <?php echo $readOnly;?>></td>
				<td class="td90">
					<button type="button" class="btn-list-modi" data-scymd="<?php echo $sc_ymd;?>"  style="vertical-align:bottom;">설정적용</button>
				</td>
			</tr>
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>

	<div class="cal-select" style="padding-top:30px;">
		<span class="prev-month cal-arrow"><img src="<?php echo G5_IMG_URL;?>/back.png"></span>
		<span class="current-month"><?php echo $cy;?>-<?php echo $cm;?></span>
		<span class="next-month cal-arrow"><img src="<?php echo G5_IMG_URL;?>/next.png"></span>
	</div>
</div>
</form>

<form name="fsclistmodify" id="fsclistmodify" method="post" autocomplete="off">
<input type="hidden" name="s_idx" value="<?php echo $s_idx;?>">
<input type="hidden" id="sc_ymd" name="sc_ymd" value="">
<input type="hidden" id="sc_status" name="sc_status" value="">
<input type="hidden" id="sc_theme" name="sc_theme" value="">
<input type="hidden" id="sc_theme_color" name="sc_theme_color" value="">
<input type="hidden" id="sc_point" name="sc_point" value="">
<input type="hidden" id="sc_price" name="sc_price" value="">
<input type="hidden" id="sc_max" name="sc_max" value="">
<input type="hidden" id="sc_desc" name="sc_desc" value="">
</form>

<script>
$( '.next-month' ).on( 'click', function() {
	var y = "<?php echo $cy;?>";
	var m = "<?php echo $cm;?>";
	var m_oMonth= new Date(y, m, 0)
	m_oMonth.setDate(1);
	m_oMonth.setMonth(m_oMonth.getMonth() + 1);

	var yearGet = m_oMonth.getFullYear(); //년을 구한다
	var monthGet = m_oMonth.getMonth()+1; //월을 구한다.
	if(monthGet<10) monthGet="0"+monthGet;
	var ym = String(yearGet)+String(monthGet);

	var sidx = "<?php echo $s_idx;?>";
	document.location.href = "./book_config.php?s_idx="+sidx+"&ym="+ym;
});

$( '.prev-month' ).on( 'click', function() {
	var y = "<?php echo $cy;?>";
	var m = "<?php echo $cm;?>";
	var m_oMonth= new Date(y, m, 0)
	m_oMonth.setDate(1);
	m_oMonth.setMonth(m_oMonth.getMonth() - 1);

	var yearGet = m_oMonth.getFullYear(); //년을 구한다
	var monthGet = m_oMonth.getMonth()+1; //월을 구한다.
	if(monthGet<10) monthGet="0"+monthGet;
	var ym = String(yearGet)+String(monthGet);

	var sidx = "<?php echo $s_idx;?>";
	document.location.href = "./book_config.php?s_idx="+sidx+"&ym="+ym;
});

//모달창 띄우기
$(document).off("click",".showmodal").on("click",".showmodal",function(e){
	e.preventDefault();
	var tgt = $(this).data("tgt");
	var valarr = $(this).data("valarr");
	show_modal('layerpopup2',tgt,valarr);
});

//개별설정
$(document).off("click",".btn-list-modi").on("click",".btn-list-modi",function(e){
	e.preventDefault();

	var sc_ymd = $(this).data("scymd");
	var sc_status = $("#sc_status_"+sc_ymd).val();
	var sc_theme = $("#sc_theme_"+sc_ymd).val();
	var sc_theme_color = $("#sc_theme_color_"+sc_ymd).val();
	var sc_point = $("#sc_point_"+sc_ymd).val();
	var sc_price = $("#sc_price_"+sc_ymd).val();
	var sc_max = $("#sc_max_"+sc_ymd).val();
	var sc_desc = $("#sc_desc_"+sc_ymd).val();

	$("#sc_ymd").val(sc_ymd);
	$("#sc_status").val(sc_status);
	$("#sc_theme").val(sc_theme);
	$("#sc_theme_color").val(sc_theme_color);
	$("#sc_point").val(sc_point);
	$("#sc_price").val(sc_price);
	$("#sc_max").val(sc_max);
	$("#sc_desc").val(sc_desc);


	var formData = $("#fsclistmodify").serialize();
	$.ajax({ 
		type: "POST",
		url: "./ajax_daily_update.php",
		data: formData, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
				else {	loadend(); return false;}
			}
			else
			{
				//console.log(msgarray.sql);
				alert("적용되었습니다.");
				document.location.reload();
			}
		},
		complete: function(){
			loadend();
		}
	});
});

function chgym() {

	var go_y = String($("#go_y").val());
	var go_m = String($("#go_m").val());
	var go_ym = go_y+go_m;

	var sidx = "<?php echo $s_idx;?>";
	document.location.href = "./book_config.php?s_idx="+sidx+"&ym="+go_ym;
}
</script>
<script>
	$('#datepicker input').datepicker({
		language: "kr",
		format: "yyyy-mm-dd",
		clearBtn: true,
		autoclose: true,
		todayHighlight: true,
		minViewMode: 1,
		startDate: -Infinity,
		endDate: Infinity
	});
</script>

<script>
$(document).ready(function(){
	$('.noIndColor').colorpicker({
		displayIndicator: false,
		//color: null,
		//customTheme: null, 
		showOn: 'both', 
		hideButton: false,
		transparentColor: false,
		history: false,
		defaultPalette: 'theme', 

		// Used to translate the widget.
		//strings: 'Theme Colors,Standard Colors,Web Colors,Theme Colors,Back to Palette,History,No history yet.'


	});
});
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
