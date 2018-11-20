<?php
$sub_menu = "400000";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'w');

$pgubun = "ship_write";

if(!($w == '' || $w == 'u')) alert("작성구분값 오류입니다.");

if($w=="")
{
	if ($s_idx) alert("등록시에는 키값을 사용하지 않습니다.");
	$g5['title'] = "어선등록";
}
else if($w == 'u') 
{
	$s_idx = (int)preg_replace('/[^0-9]/', '', $_REQUEST['s_idx']);
	if(!$s_idx || $s_idx < 1) alert("어선키값 오류입니다.");

	$shipsql = " select * from m_ship where s_idx = '{$s_idx}' ";
	$ship = sql_fetch($shipsql);

	if(!$ship['s_idx']) alert("존재하지 않는 어선입니다.");
	$s_name = get_text($ship[s_name]);

	// 이미지
	for($i=0;$i<5;$i++) {
		$_imgsql = "";
		$_imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table = 'm_ship' and wr_id = '{$s_idx}' and bf_no = '{$i}' ");

		$_imgfile_alias = "imgfile".$i;
		$$_imgfile_alias = $_imgsql[bf_file];
		$_imgsrc_alias = "img".$i;
		$$_imgsrc_alias = G5_DATA_URL."/file/m_ship/thumb2/".$_imgsql[bf_file];
	}

	$shipsSql = " select * from m_ship where (1) ";
	$resultships = sql_query($shipsSql);
	$shipSelect = "<select>";

	for($i=0;$srow=sql_fetch_array($resultships);$i++) {

		// 셀렉트박스
		$shipSelect .= "<option value='".$srow[s_idx]."'>".get_text($srow[s_name])."</option>";
	}
	$shipSelect .= "</select>";

	set_session('ss_db_table', 'm_ship');
	set_session('ss_s_idx', $_REQUEST['s_idx']);

	$g5['title'] = $s_name." - 어선정보";
}

$mapx = trim($ship[mapx]);
if(!$mapx) $mapx = "126.9783767";
$mapy = trim($ship[mapy]);
if(!$mapy) $mapy = "37.5666091";

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>
<script type="text/javascript" src="//openapi.map.naver.com/openapi/v3/maps.js?clientId=CE2xFoctklexAiHc9CWl"></script>

<style>
.tbl_frm01 th {width:180px;padding:10px 0;}
td ul{margin:0;padding:0;list-style:none;}
td li{margin:0;padding:0;list-style:none;}
td dd{margin:0;padding:0;list-style:none;}
.tbl_frm01 textarea {height: 250px;width:99.5%;}
.tbl_frm01 td input, .tbl_frm01 td input {border: 1px solid #ddd;padding: 1px 5px;}
.divfloat{float:left;padding-right:4px;width:170px;}
.img-responsive{width:100%;max-width:100%;}
.showmodal{cursor:pointer;}
.input-help{color:#ea600c;}
h3.h3-tbltitle{padding:10px 0;}
div.addedtheme{margin-top:5px;}
.addtheme {padding:4px;display:inline-block;margin-top:10px;background:#276945;color:#fff;cursor:pointer;}
.deltheme {padding:4px;background:#e23600;color:#fff;cursor:pointer;}
.svcdiv {float:left;width:33.333333333%;text-align:left;}
</style>

<div class="list-top-wrap xs-hidden">
	<div class="cate-wrap">
		<a href="./ship_write.php?w=u&s_idx=<?php echo $s_idx;?>" class="selected">어선정보</a>
		<a href="./book_config.php?s_idx=<?php echo $s_idx;?>"  class="">예약설정</a>
		<!--<a href="./book_list.php?s_idx=<?php echo $s_idx;?>"  class="">예약현황</a>-->
		<a href="./book_list_calendar.php?s_idx=<?php echo $s_idx;?>"  class="">예약현황</a>
	</div>
</div>
<div style="clear:both;margin-bottom:10px;"></div>

<form name="fshipwrite" id="fshipwrite" onsubmit="return fshipwrite_submit(this);" method="post" action="./ship_write_update.php" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w;?>">
<input type="hidden" name="s_idx" value="<?php echo $s_idx;?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" id="mapx" name="mapx" value="<?php echo $mapx;?>">
<input type="hidden" id="mapy" name="mapy" value="<?php echo $mapy;?>">

<div class="tbl_frm01 tbl_wrap">
	<h3 class="h3-tbltitle">어선 필수정보</h3>
	<table class="mobile_table" id="width100">
		<tbody>
			<?php if($w=="u") { ?> 
			<tr>
				<th scope="row">노출설정</th>
				<td colspan="3">
					<div id="expo_wrap" class="divfloat">
						<select name="s_expose" class="selectbox td100">
							<option value="n" <?php if($ship[s_expose] == "n") echo " selected='selected' ";?>>미노출</option>
							<option value="y" <?php if($ship[s_expose] == "y") echo " selected='selected' ";?>>노출</option>
						</select>
					</div>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<th scope="row">선주(선장)명</th>
				<td colspan="3">
					<input type="text" name="s_owner" id="s_owner" class="td200 required" value="<?php echo get_text($ship[s_owner]);?>" maxlength="255" required="required" placeholder="선주(선장)명을 입력하세요."/>
				</td>
			</tr>
			<tr>
				<th scope="row">어선명</th>
				<td colspan="3">
					<input type="text" name="s_name" id="s_name" class="w40 required" value="<?php echo get_text($ship[s_name]);?>" maxlength="255" required="required" placeholder="어선명을 입력하세요."/>
				</td>
			</tr>
			<tr>
				<th scope="row">최대승선인원</th>
				<td colspan="3">
					<input type="number" name="s_max" id="s_max" value="<?php echo $ship[s_max];?>" class="required td100" required="required" placeholder="최대승선인원" /> 
				</td>
			</tr>
			<tr>
				<th scope="row">최소출항인원</th>
				<td colspan="3">
					<input type="number" name="s_min" id="s_min" value="<?php echo $ship[s_min];?>" class="required td100" required="required" placeholder="최소출항인원" /> 
				</td>
			</tr>
			<tr>
				<th scope="row">기본출조제목</th>
				<td colspan="3">
					<input type="text" name="s_theme" class="required w40" value="<?php echo $ship[s_theme];?>" maxlength="255" required="required" placeholder="기본출조제목을 입력하세요 (입력예 : 광어다운샷 출조)" />
				</td>
			</tr>
			<tr>
				<th scope="row">기본출조비용</th>
				<td colspan="3">
					<input type="text" name="s_price" class="required td100" value="<?php echo number_format($ship[s_price]);?>" maxlength="7" required="required" placeholder="출조비용 (입력예 : 100000)" />
				</td>
			</tr>
			<tr>
				<th scope="row">배타는 곳</th>
				<td colspan="3">
					<input type="text" name="s_addr" class="required w40" value="<?php echo get_text($ship[s_addr]);?>" maxlength="255" required="required" placeholder="배타는 곳 주소 입력" />
				</td>
			</tr>
		</tbody>
	</table>

	<h3 class="h3-tbltitle">어선 부가정보</h3>
	<table class="mobile_table" id="width100">
		<tbody>
			<tr>
				<th scope="row">출항시간정보</th>
				<td>
					<textarea name="s_schedule" id="s_schedule" class="txtarea" maxlength="3000" rows="5" placeholder="출항시간"><?php echo get_text($ship[s_schedule]); ?></textarea>
				</td>
				<th scope="row">어선소개</th>
				<td>
					<textarea name="s_cont" id="s_cont" class="txtarea" maxlength="3000" rows="5" placeholder="어선소개"><?php echo get_text($ship[s_cont]); ?></textarea>
				</td>
			</tr>
			<tr>
				<th scope="row">제공서비스</th>
				<td style='max-width:1px;'>
					<?php $i=0; while($i < count($_menu_arr)) { ?>
					<?php
						$m_subj = $_menu_arr[$i][0];
						$m_key = $_menu_arr[$i][1];
						
						$chkstr = "";
						if(in_array($m_key, array_map("trim", explode('|', $ship[s_service])))) $chkstr = "checked='checked' ";
						$i++; 
					?>
					<div class="svcdiv">
						<input type="checkbox" id="svc_<?php echo $m_key;?>" name="s_service[]" value="<?php echo $m_key;?>" <?php echo $chkstr;?> class="agmenu">
						<label for="svc_<?php echo $m_key;?>"><?php echo $m_subj;?></label>
					</div>
					<?php } ?>
				</td>
				<th scope="row">어선위치</th>
				<td>
					<div id="map" class="map" style="width:100%; height:300px;"></div>
				</td>
			</tr>
		</tbody>
	</table>

	<h3 class="h3-tbltitle">어선이미지</h3>
	<table>
		<tbody>
			<?php for($i=0;$i<5;$i++) { ?>
			<?php
				$j=$i+1;
				$imgfile_alias = "imgfile".$i;
				$imgfile = $$imgfile_alias;
				$imgsrc_alias = "img".$i;
				$imgsrc = $$imgsrc_alias;
			?>
			<tr>
				<th scope="row">이미지_<?php echo $j;?></th>
				<td colspan="3">
					<input type="file" name="bf_file[]" title="선박이미지<?php echo $j;?>" class="frm_file frm_input">
					<?php if($imgfile) { ?>
					<input type="checkbox" id="bf_file_del<?php echo $i;?>" name="bf_file_del[<?php echo $i;?>]" value="1"> 
					<img src="<?php echo $imgsrc;?>" height="40px;"> ※체크시 파일삭제
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm" style="margin-top:20px;">
	<?php if($w=="") { ?>
	<input type="submit" class="btn_submit" id="btn_submit" style="background:#5f5f5f;" value="어선등록">
	<?php } else if($w=="u") { ?> 
	<input type="submit" class="btn_submit" id="btn_submit" style="background:#5f5f5f;" value="수정완료">
	<?php } ?>
	<a href="./ship_list.php" style="background:#5f5f5f;">목록</a>
</div>

</form>

<script>
// 출조테마 추가
$(document).off("click",".addtheme").on("click",".addtheme",function(e){
	
	var themecnt = $("#td_addtheme div").length;
	if(themecnt > 4)
	{
		alert("출조항목은 5개 까지만 추가하실 수 있습니다."); return false;
	}
	else
	{
		var lastGroupId = parseInt($("#td_addtheme div").last().attr("id"));
		var newGroupId = lastGroupId+1;
		var wmode = "<?php echo $w;?>";

		$.ajax({ 
			type: "GET",
			url: "./ajax_add_theme.php",
			data: "w="+wmode+"&newId="+newGroupId , 
			beforeSend: function(){
				loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);
				if(msgarray.rslt == "error")
				{
					alert(msgarray.errcode); 
					if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
					else {	return false;}
				}
				else
				{
					$("#td_addtheme div").last().after(msgarray.cont);
				}
			},
			complete: function(){
				loadend();
			}
		});
	}
});

// 출조테마 삭제
$(document).off("click",".deltheme").on("click",".deltheme",function(e){
	$(this).closest("div").remove();
});
</script>

<script type="text/javascript">
$(document).ready(function(){

	var mapx = "<?php echo $mapx;?>";
	var mapy = "<?php echo $mapy;?>";

	var position = new naver.maps.LatLng(mapy, mapx);

	var map = new naver.maps.Map('map', {
		center: position,
		zoom: 5
	});

	var marker = new naver.maps.Marker({
		position: position,
		map: map
	});

	naver.maps.Event.addListener(map, 'click', function(e) {
		marker.setPosition(e.coord);
		var mapX = e.coord.x;
		var mapY = e.coord.y;
		$("#mapx").val(mapX);
		$("#mapy").val(mapY);
	});
});
</script>

<script>
function fshipwrite(f)
{
	document.getElementById("btn_submit").disabled = "disabled";
	return true;
}
</script>
<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
