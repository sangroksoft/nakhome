<?php
include_once('./_common.php');

$dataArrTmp = clean_xss_tags(trim($_GET[valarr]));
$dataArr = explode("|",$dataArrTmp);

$w = $dataArr[1];

if($w=="u") {
	$bk_idx = $dataArr[0];
	$bk_idx =  preg_replace('/[^0-9]/', '', $bk_idx);
	if(!$bk_idx || $bk_idx < 1) alert_closelayer("예약키값 오류입니다.","closelayer2");

	$bk = sql_fetch(" select * from m_bookdata where bk_idx = '{$bk_idx}' ");
	if(!$bk['bk_idx']) alert_closelayer("존재하지 않는 예약입니다.","closelayer2");

	$s_idx = $bk['s_idx'];
	$bk_ymd = $bk['bk_ymd'];
	$bk_status = $bk['bk_status'];

	if(!$is_member)
	{
		// 회원ID
		$bk_mb_id = "temp_member";
		// 회원명
		$bk_mb_name = "비회원 예약";
	}
	else{
		// 회원ID
		$bk_mb_id = $bk[bk_mb_id];
		// 회원명
		$bk_mb_name = get_text($bk[bk_mb_name]);
	}
	// 예약자(입금자)명
	$bk_banker = get_text($bk[bk_banker]);
	// 예약자연락처
	$bk_tel = get_text($bk[bk_tel]);
	// 어선아이디
	$s_idx = $bk[s_idx];
	// 어선명
	$s_name = get_text($bk[s_name]);
	// 출조테마
	$bk_theme = get_text($bk[bk_theme]);
	// 출조일
	$bk_ymd = $bk[bk_y]."-".$bk[bk_m]."-".$bk[bk_d];
	$bk_ymd_wd = $bk[bk_y].$bk[bk_m].$bk[bk_d];
	// 요일추출
	$wd = date('w', strtotime($bk_ymd));
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
	// 출조인원
	$bk_member_cnt = number_format($bk[bk_member_cnt]);
	// 예약메모
	$bk_memo = get_text($bk[bk_memo],0);
	// 예약접수일
	$bk_datetime = $bk[bk_datetime];
	// 총출조비용
	$bk_price_total = $bk[bk_price_total];
	// 예약비용
	$book_price = $bk[bk_price_total] * ($comfig['book_fee'] / 100);
	$book_price = number_format($book_price);
	// 입금액
	$pay_amount = $bk[pay_amount];

	// 예약가능인원
	$sc = sql_fetch(" select * from m_schedule where s_idx='{$bk[s_idx]}' and sc_ymd='{$bk[bk_ymd]}' ");

	if($bk_status == "0") { // 원래상태가 예약접수시
		$sc_available = $sc[sc_max] - $sc[sc_booked];
		$sc_available_str ="<span style='color:red;'>※ 예약가능인원 : ".$sc_available."명";
	} else if($bk_status == "1") { // 원래상태가 예약완료시
		$sc_available =$sc[sc_max] - ($sc[sc_booked] - $bk[bk_member_cnt]);
		$sc_available_str ="<span style='color:red;'>※ 예약가능인원 : ".$sc_available."명";
	} else if($bk_status == "-1") { // 원래상태가 예약취소시
		$sc_available_str ="";
	} else if($bk_status == "-2") { // 원래상태가 예약취소요청시
		$sc_available_str ="";
	}
} else if($w=="") {

	$sc_ymd=date('Y-m-d');
	$scymd=date('Ymd');
	// 개별날짜 추출
	$sy = substr($ymd,0,4);
	$sm = substr($ymd,5,2);
	$sd = substr($ymd,8,2);
	//echo $sy;echo $sm;echo $sd;

	$sql = " select * from m_ship where (1) ";
	$result = sql_query($sql);
	$ships = "";
	for($i=0;$row=sql_fetch_array($result);$i++) {
		// 셀렉트박스
		$ship_selected="";
		if($i==0) $ship_selected=" selected='selected' ";
		$ships .= "<option value='".$row[s_idx]."' ".$ship_selected.">".get_text($row[s_name])."</option>";
	}
}


if($w=="") $g5['title'] = "예약등록";
else if($w=="u") $g5['title'] = "예약수정";
$colspan = 18;

include_once(G5_PATH.'/head.adm.sub.php');
?>
<style>
.tbl_head01 tbody th {width:110px;border:1px solid #d9d9d9;color:#555;padding:10px 0;font-size: 0.95em; background:#f1f1f1;padding:5px;}
.tbl_head01 tbody td {border:1px solid #d9d9d9;padding:5px;height:24px;}
.tbl_head01 td input{border: 1px solid #ddd;padding: 1px 5px; height:20px;}
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

.schdate{width:100px;text-align:right;}
.frm_input { font-size: 1em;}
</style>

<?php if($w=="") {?>
<link rel="stylesheet" href="<?php echo G5_CSS_URL;?>/jquery-ui/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php } ?>

<div style="width:100%; height:100%; background: #ffffff;margin-top:20px;">
	<form name="fbooking" id="fbooking" onsubmit="return fbooking_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w;?>">
	<?php if($w=="u") {?>
	<input type="hidden" name="bk_idx" value="<?php echo $bk_idx;?>">
	<input type="hidden" name="s_idx" value="<?php echo $s_idx;?>">
	<input type="hidden" name="bk_ymd" value="<?php echo $bk_ymd;?>">
	<?php } ?>
	<div class="tbl_head01 tbl_wrap">
		<h1><?php echo $g5['title'];?></h1>
		<table>
			<tbody>
				<?php if($w=="") {?>
				<tr>
					<th scope="row">어선선택</th>
					<td colspan="3">
						<select id="s_idx" name="s_idx" class="selectbox" required="required" onchange="chg_ship(this.value);">
							<?php echo $ships;?>
						</select>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th scope="row">출조일</th>
					<td colspan="3">
						<?php if($w=="u") {?>
							<?php echo $bk_ymd ?>
							<span style="color:red;"><?php echo $sc_available_str;?></span>
						<?php } else if($w=="") {?>
							<input type="text" name="sc_ymd" id="sc_ymd" required="required" value="<?php echo $sc_ymd ?>" >
							<span style="color:red;">※ 예약가능인원 : <span  id="sc_available"></span></span>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">출조제목</th>
					<td colspan="3">
						<?php if($w=="u") {?>
							<?php echo $s_name;?> <?php echo $bk_theme;?>
						<?php } else if($w=="") {?>
							<span  id="sc_theme"></span>
						<?php } ?>
					</td>
				</tr>

				<?php if($w=="u") {?>
				<tr>
					<th scope="row">예약자</th>
					<td colspan="3">
						<?php echo $bk_mb_name;?> (<?php echo $bk_mb_id;?>)
					</td>
				</tr>
				<tr>
					<th scope="row">예약접수일</th>
					<td colspan="3">
						<?php echo $bk_datetime;?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th scope="row">예약인원</th>
					<td colspan="3">
						<input type="text" name="bk_member_cnt" value="<?php echo $bk_member_cnt;?>" id="bk_member_cnt" class="frm_input td40 ta-right" required="required" maxlength="2"> 명
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">출조비용</th>
					<td colspan="3">
						<input type="text" name="bk_price_total" value="<?php echo $bk_price_total;?>" id="bk_price_total" class="frm_input td60 ta-right" required="required" maxlength="10" placeholder=""> 원 
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">입금액</th>
					<td colspan="3">
						<input type="text" name="pay_amount" value="<?php echo $pay_amount;?>" id="pay_amount" class="frm_input td60 ta-right" maxlength="10" placeholder=""> 원 
						<span style="color:red;">(※ 숫자로만 입력하세요.)</span>
					</td>
				</tr>
				<tr>
					<th scope="row">입금자</th>
					<td colspan="3">
						<input type="text" name="bk_banker" value="<?php echo $bk_banker;?>" id="bk_banker" class="frm_input td100" required="required" maxlength="30" placeholder="입금자"> 
					</td>
				</tr>
				<tr>
					<th scope="row">연락처</th>
					<td colspan="3">
						<input type="text" name="bk_tel" value="<?php echo $bk_tel;?>" id="bk_tel" class="frm_input td100" required="required" maxlength="20" placeholder="연락처"> 
					</td>
				</tr>
				<tr>
					<th scope="row">예약메모</th>
					<td colspan="3">
						<textarea name="bk_memo" id="bk_memo" class="txtarea" maxlength="3000" rows="5" placeholder="예약메모"><?php echo $bk_memo;?></textarea>
					</td>
				</tr>
				<?php if($w=="u") {?>
				<tr>
					<th scope="row">예약상태</th>
					<td colspan="3">
						<?php if($bk[bk_status] == "-2") {?>
						<select name="bk_status" class="selectbox w30">
							<option value="-2" selected='selected' >예약취소요청</option>
							<option value="-1">예약취소</option>
							<option value="1">예약완료</option>
						</select>
						<?php } else if($bk[bk_status] == "-1") { ?>
						<span style="color:red;">예약취소</span>
						<input type="hidden" name="bk_status" value="-1">
						<?php } else if($bk[bk_status] == "1") { ?>
						<select name="bk_status" class="selectbox w30">
							<option value="-1">예약취소</option>
							<option value="1" selected='selected'>예약완료</option>
						</select>
						<?php } else { ?>
						<select name="bk_status" class="selectbox w30">
							<option value="-1">예약취소</option>
							<option value="0" selected='selected'>예약접수</option>
							<option value="1">예약완료</option>
						</select>
						<?php } ?>
					</td>
				</tr>
				<?php } else if($w=="") { ?>
				<tr>
					<th scope="row">예약상태</th>
					<td colspan="3">
						<select name="bk_status" class="selectbox w30">
							<option value="1" selected='selected'>예약완료</option>
							<option value="0">예약접수</option>
						</select>
					</td>
				</tr>
                <?php } ?>
			</tbody>
		</table>

		<?php if($w== "u") {?>
		<?php if($bk[bk_stauts] != "-1") {?>
		<div class="btn-wrap">
			<input type="submit" class="btn-regi" id="btn_regi" value="확인">
		</div>
		<?php } ?>
		<?php } else if($w=="") {?>
		<div class="btn-wrap">
			<!--<input type="submit" class="btn-regi"  value="예약접수" onclick="document.pressed=this.value">
			<input type="submit" class="btn-regi"  value="예약완료" onclick="document.pressed=this.value">
            -->
			<input type="submit" class="btn-regi" id="btn_regi" value="확인">
		</div>
		<?php } ?>
	</div>
	</form>

</div>

<?php if($w=="") {?>
<script>
$(document).ready(function(){
	// 달력초기화
	var sidx = $("#s_idx").val();
	var scymd = "<?php echo $scymd;?>";

	ajax_get_schedule(sidx,scymd);
});

function chg_ship(sidx) {
	var scymd = $("#sc_ymd").val();
	ajax_get_schedule(sidx,scymd);
}

// 해당년월일 어선별 예약정보 추출
function ajax_get_schedule(sidx, scymd) {
	$.ajax({ 
		type: "GET",
		url: g5_url+"/ship/ajax_get_schedule.php",
		data: "s_idx="+sidx+"&sc_ymd="+scymd, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl) {document.location.replace(msgarray.errurl);}
				else {loadend(); return false;}
			}
			else
			{
				var rtn_s_idx = msgarray.s_idx;
				var rtn_sc_ymd = msgarray.sc_ymd;
				var rtn_sc_status = msgarray.sc_status;
				var rtn_sc_bk_members = msgarray.sc_bk_members;
				var rtn_theme_total = msgarray.sc_theme_total;
				var rtn_sc_theme = msgarray.sc_theme;
				var rtn_sc_cont = msgarray.sc_cont;
				var rtn_sc_price = msgarray.sc_price;
				var rtn_selbox = msgarray.selbox;
				var rtn_shipselbox = msgarray.shipselbox;
				var rtn_ship_arr = msgarray.ship_arr;
				var rtn_ship_imgs = msgarray.shipImgs;
				var rtn_svcdivstr = msgarray.svcdivstr;
				var rtn_available_str = msgarray.available_str;

				$("#sc_available").html(rtn_available_str);
				$("#sc_theme").html(rtn_theme_total);
			}
		},
		complete: function(){
			loadend();
		}
	});
}
</script>
<script>
$( function() {
	$( "#sc_ymd" ).datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: 0, // 오늘이후부터만 선택가능
		monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNamesMin:['일','월','화','수','목','금','토'],
		changeMonth:true, // 월변경가능
		changeYear:true,  // 년변경가능
		showMonthAfterYear:true, // 년 뒤에 월표시
		onSelect : function() {
			//alert(this.value);
			var sidx = $("#s_idx").val();
			var scymd=this.value;
			ajax_get_schedule(sidx, scymd);
		}
	});
});
</script>
<?php } ?>
<script>

// 폼 전송
function fbooking_submit(f)
{
    /*
	var w = "<?php echo $w;?>";
	if(w=="") {
		if(document.pressed == "예약접수") {
			$("#bk_status").val("0");
		} else if(document.pressed == "예약완료") {
			$("#bk_status").val("1");
		}
	}
    */
	
	ajax_fbooking_submit();
	return false;
}

// 폼 AJAX 처리
function ajax_fbooking_submit()
{
	$("#btn_regi").attr("disabled","disabled");
	var formData = $("#fbooking").serialize();
	$.ajax({ 
		type: "POST",
		url: "./ajax_booking_update.php",
		data: formData, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				$("#btn_regi").removeAttr("disabled");
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
