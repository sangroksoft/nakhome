<?php
include_once('./_common.php');

$g5['title'] = "월 예약 일괄설정";
$colspan = 18;

$dataArrTmp = clean_xss_tags(trim($_GET[valarr]));
$dataArr = explode("|",$dataArrTmp);
$sc_ym = $dataArr[0];
$s_idx = $dataArr[1];

//===================== 어선정보가져옴 ========================
if(!$s_idx || $s_idx < 1) alert_closelayer("어선키값 오류입니다.","closelayer2");
$ship = sql_fetch(" select * from m_ship where s_idx = '{$s_idx}' ");
if(!$ship[s_idx]) alert_closelayer("존재하지 않는 어선입니다.","closelayer2");

$s_name = get_text($ship[s_name]);
//===================== 어선정보가져옴 ========================

//===================== 달력정보가져옴 ========================
$now_ym = date("Ym");
$sc_ym = (int)preg_replace('/[^0-9]/', '', $sc_ym);
if(!$sc_ym) alert_closelayer("예약일자 오류입니다.","closelayer2");
if($sc_ym < $now_ym) alert_closelayer("예약일자는 현재월부터 설정가능합니다.","closelayer2");
if($sc_ym > 205012) alert_closelayer("예약일자는 2050년까지 설정가능합니다.","closelayer2");
if (strlen($sc_ym) != 6) alert_closelayer("예약일자를 선택해 주세요.","closelayer2");

// 개별날짜 추출
$sy = substr($sc_ym,0,4);
$sm = substr($sc_ym,4,2);
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
	<form name="fmonthly" id="fmonthly" onsubmit="return fmonthly_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w;?>">
	<input type="hidden" name="s_idx" value="<?php echo $s_idx;?>">
	<input type="hidden" name="sc_ym" value="<?php echo $sc_ym;?>">
	<div class="tbl_head01 tbl_wrap">
		<h1><?php echo $s_name;?> - <?php echo $sy;?> 년 <?php echo $sm;?> 월 예약일괄설정</h1>
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
						<input type="text" name="sc_theme" value="" id="sc_theme" class="frm_input w97" maxlength="255" placeholder="출조제목을 입력하세요 (입력예 : 광어다운샷 출조)">
					</td>
				</tr>
				<tr>
					<th scope="row">출조지점</th>
					<td colspan="3">
						<input type="text" name="sc_point" value="" id="sc_point" class="frm_input w97" maxlength="255" placeholder="출조지점을 입력하세요 (입력예 : 팔미도, 승봉도, 덕적도)">
					</td>
				</tr>
				<tr>
					<th scope="row">출조비용</th>
					<td colspan="3">
						<input type="number" name="sc_price" value="" id="sc_price" class="frm_input td100" placeholder=""> 원 
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">예약가능인원</th>
					<td colspan="3">
						<input type="number" name="sc_max" value="" id="sc_max" class="frm_input td50" placeholder=""> 명
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">공지사항</th>
					<td colspan="3">
						<textarea name="sc_desc" id="sc_desc" class="txtarea" maxlength="3000" rows="5" placeholder="공지사항"></textarea>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="btn-wrap">
			<p style="text-align:left;">
			※ 주의사항 : 위 항목 중 입력하신 항목만 반영되어 저장됩니다.<br>
			※ 주의사항 : 출조비용과 예약가능인원을 입력시 숫자로만 입력하십시오.
			</p>
		</div>

		<div class="btn-wrap">
			<input type="submit" class="btn-regi" id="btn_regi" value="일괄등록">
		</div>
	</div>
	</form>

</div>

<script>

// 발주취소 전송
function fmonthly_submit(f)
{
	ajax_fmonthly_submit();
	return false;
}

// 발주취소폼 AJAX 처리
function ajax_fmonthly_submit()
{
	$("#btn-regi").attr("disabled","disabled");
	var formData = $("#fmonthly").serialize();
	$.ajax({ 
		type: "POST",
		url: "./ajax_monthly_update.php",
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
