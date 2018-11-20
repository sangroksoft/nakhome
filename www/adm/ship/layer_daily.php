<?php
include_once('./_common.php');

$g5['title'] = "월 예약 일괄설정";
$colspan = 18;

$dataArrTmp = clean_xss_tags(trim($_GET[valarr]));
$dataArr = explode("|",$dataArrTmp);
$sc_ymd = $dataArr[0];
$s_idx = $dataArr[1];

//===================== 어선정보가져옴 ========================
if(!$s_idx || $s_idx < 1) alert_closelayer("어선키값 오류입니다.","closelayer2");
$ship = sql_fetch(" select * from m_ship where s_idx = '{$s_idx}' ");
if(!$ship[s_idx]) alert_closelayer("존재하지 않는 어선입니다.","closelayer2");

$s_name = get_text($ship[s_name]);
//===================== 어선정보가져옴 ========================

//===================== 달력정보가져옴 ========================
$now_ymd = date("Ymd");
$sc_ymd = (int)preg_replace('/[^0-9]/', '', $sc_ymd);
if(!$sc_ymd) alert_closelayer("예약일자 오류입니다.","closelayer2");
if($sc_ymd < $now_ymd) alert_closelayer("예약일자는 현재일부터 설정가능합니다.","closelayer2");
if($sc_ymd > 20501231) alert_closelayer("예약일자는 2050년까지 설정가능합니다.","closelayer2");
if (strlen($sc_ymd) != 8) alert_closelayer("예약일자를 선택해 주세요.","closelayer2");

// 개별날짜 추출
$sy = substr($sc_ymd,0,4);
$sm = substr($sc_ymd,4,2);
$sd = substr($sc_ymd,6,2);

$sc = sql_fetch(" select * from m_schedule where sc_ymd = '{$sc_ymd}' and s_idx='{$s_idx}' ");
$sc_theme = get_text($sc[sc_theme]);
$sc_price = $sc[sc_price];
$sc_max = $sc[sc_max];
$sc_desc = get_text($sc[sc_desc],0);
//===================== 달력정보가져옴 ========================

include_once(G5_PATH.'/head.adm.sub.php');
?>
<style>
.tbl_head01 tbody th {width:110px;border:1px solid #d9d9d9;color:#555;padding:10px 0;font-size: 0.95em; background:#f1f1f1;padding:5px;}
.tbl_head01 tbody td {border:1px solid #d9d9d9;padding:5px;}
.tbl_head01 td input{border: 1px solid #ddd;padding: 1px 5px; height:24px;}
.btn-wrap{padding-top:10px;text-align:center;}
.btn-wrap .btn-regi{border:1px solid #ccc; padding:0px 20px; background:#efefef;line-height: 36px;}

.divfloat{float:left;padding-right:4px;width:170px;}
.showmodal{cursor:pointer;}
h3.h3-tbltitle{padding:10px 0;}

.ta-right{text-align:right;}
.ta-center{text-align:center;}
.tbl_head01 textarea {width:99%;height: 50px;}
h1 {min-width:1px;}

.input-div{padding:0 20px;}
</style>
<div style="width:100%; height:100%; background: #ffffff;margin-top:20px;">
	<form name="fdailly" id="fdailly" onsubmit="return fdailly_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w;?>">
	<input type="hidden" name="s_idx" value="<?php echo $s_idx;?>">
	<input type="hidden" name="sc_ymd" value="<?php echo $sc_ymd;?>">
	<div class="tbl_head01 tbl_wrap">
		<h1><?php echo $s_name;?> - <?php echo $sy;?> 년 <?php echo $sm;?> 월 <?php echo $sd;?> 일 예약설정</h1>
		<table>
			<tbody>
				<tr>
					<th scope="row">예약상태</th>
					<td colspan="3">
						<select name="sc_status" class="selectbox w30">
							<option value="0" <?php if($row[sc_status] == "0") echo "selected='selected'";?>>예약가능</option>
							<option value="1" <?php if($row[sc_status] == "1") echo "selected='selected'";?>>예약마감</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">출조제목</th>
					<td colspan="3">
						<input type="text" name="sc_theme" id="sc_theme" class="frm_input required w97" maxlength="255" value="<?php echo $sc_theme;?>" placeholder="출조제목을 입력하세요 (입력예 : 광어다운샷 출조)" required="required">
					</td>
				</tr>
				<tr>
					<th scope="row">출조비용</th>
					<td colspan="3">
						<input type="number" name="sc_price" id="sc_price" class="frm_input required td100" value="<?php echo $sc_price;?>" placeholder="" required="required"> 원 
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">예약가능인원</th>
					<td colspan="3">
						<input type="number" name="sc_max" id="sc_max" class="frm_input required td50" value="<?php echo $sc_max;?>" placeholder="" required="required"> 명
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">공지사항</th>
					<td colspan="3">
						<textarea name="sc_desc" id="sc_desc" class="txtarea" maxlength="3000" rows="5" placeholder="공지사항"><?php echo $sc_desc;?></textarea>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="btn-wrap">
			※ 주의사항 : 
		</div>

		<div class="btn-wrap">
			<input type="submit" class="btn-regi" id="btn_regi" value="등록">
		</div>
	</div>
	</form>

</div>

<script>

// 전송
function fdailly_submit(f)
{
	ajax_fdailly_submit();
	return false;
}

// AJAX 처리
function ajax_fdailly_submit()
{
	$("#btn-regi").attr("disabled","disabled");
	var formData = $("#fdailly").serialize();
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
				$("#btn-regi").removeAttr("disabled");
				alert(msgarray.errcode); 
				if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
				else {	loadend(); return false;}
			}
			else
			{
				alert("저장되었습니다.");
				parent.document.location.reload();
			}
		},
		complete: function(){
			loadend();
		}
	});
}

</script>
<?php
include_once(G5_PATH.'/tail.adm.sub.php');
?>
