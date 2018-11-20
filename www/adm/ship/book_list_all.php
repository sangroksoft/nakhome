<?php
$sub_menu = "410100";
include_once("./_common.php");

if($is_mobile == "1"){
	echo "<script>location.href='book_list_calendar_all.php'</script>";
}

auth_check($auth[$sub_menu], 'w');

$pgubun = "book_list_all";

$sql_common = " from m_bookdata  " ;
$sql_search = " where (1) " ;
$sop = 'and';

$params = array();

if($sch)
{
	$qstr .= "&sch=".$sch;

	if ($s_idx)	{ 
        $sql_search .= " and s_idx = '{$s_idx}'  "; $qstr .= "&s_idx=".$s_idx; 
    }
	if ($bs)	{ 
        $sql_search .= " and bk_status='{$bs}'  "; $qstr .= "&bs=".$bs; 
    }
	if ($sdate != "" || $edate != "") 	
	{ 
		$qstr .= "&dg=".$dg; 
		if ($dg == "o") 	
		{ 
			if ($sdate != "") { 
                $bk_sdate = str_replace("-","",$sdate); $sql_search .= " and bk_ymd >= '{$bk_sdate}'  "; $qstr .= "&sdate=".$sdate; 
            }
			if ($edate != "") { 
                $bk_edate = str_replace("-","",$edate); $sql_search .= " and bk_ymd <= '{$bk_edate}'  "; $qstr .= "&edate=".$edate; 
            }
		}
		else if ($dg == "b") 	
		{ 
			if ($sdate != "") { 
                $bk_sdate = $sdate." 00:00:00"; $sql_search .= " and bk_datetime >= '{$bk_sdate}'  "; $qstr .= "&sdate=".$sdate; 
            }
			if ($edate != "") { 
                $bk_edate = $edate." 23:59:59"; $sql_search .= " and bk_datetime <= '{$bk_edate}'  "; $qstr .= "&edate=".$edate; 
            }
		}
	}

	$stx = trim($stx);
	if($stx) {
        $sql_search .= get_sql_search_lsh("bk_tel||bk_banker||bk_memo", $stx, $sop);
    }
}

$params["s_idx"] = $s_idx;
$params["bk_status"] = $bs;
$params["dg"] = $dg;
$params["bk_sdate"] = $bk_sdate;
$params["bk_edate"] = $bk_edate;
$params["stx"] = $stx;
//print_r2($params);

if (!$sst) { $sst = "bk_datetime"; $sod = "desc"; } 
$sql_order = " order by $sst $sod ";

//=========== 페이징을 위한 Query 시작=================
$sqlcnt = " select bk_idx $sql_common $sql_search $sql_order ";
$rowcnt = sql_query($sqlcnt);
$total_count = sql_num_rows($rowcnt); 

//$page_rows = $config[cf_page_rows];
$page_rows = 20;
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)

// 검색시 검색리스트로 돌아오기 위한 로직추가
if($pgchk)
{
  if($pgchk > $total_page) $page = $total_page;
	if($total_page == 0) $page = 1;
}

$from_record = ($page - 1) * $page_rows; // 시작 열을 구함
$nListorder = $total_count - (($page-1) * $page_rows) + 1; //게시물 일련번호추출

$pagelist = get_paging(10, $page, $total_page, "?$qstr&page=");
//=========== 페이징을 위한 Query 끝===================

//=========== 리스트를 뽑아오는 Query 시작=============
$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $page_rows ";
$result = sql_query($sql);
//echo $sql;
//=========== 리스트를 뽑아오는 Query 끝===============

$bkInfo = get_bk_statistics($params);
//print_r2($bkInfo);

$ssql = " select * from m_ship where (1) ";
$srslt = sql_query($ssql);

$g5['title'] = "예약현황";

include_once(G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_ADMINSHIP_PATH.'/ml_layer.php');
?>



<style>
.selectbox80{width:80px;height:28px;}
.selectbox100{width:100px;height:28px;}
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

.schdate{width:70px;text-align:right;padding:0 5px;}
button.btn-time{border:1px solid #ccc; background:#efefef;padding:5px}
#fsearch td{height:24px;padding:2px 4px;}
#fsearch input[type="submit"] {height: 24px;padding: 2px 20px;}
#fsearch td .frm_input{height:24px;}

.sumdiv td{height:28px;padding:2px 4px;}
.sumdiv td .frm_input{height:28px;}

.tbl_head01 th.sch-th {background:#e5ecef;width:134px;}
.local_ov01{margin: 10px 0 20px;}

.floatL{float:left;width:49%;}
.floatR{float:right;width:49%;}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo G5_CSS_URL;?>/jquery-ui/base/jquery-ui.css">


<div class="tbl_head01 tbl_wrap">

	<div class="floatL">
        <form id="fsearch" name="fsearch" method="get">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="sch" value="1">
        <input type="hidden" name="s_idx" value="<?php echo $s_idx ?>">
        <table>
            <tbody>
                <tr>
                    <th scope="row" class="sch-th">기간검색</th>
                    <td colspan="3" style="text-align:left;">
                        <select id="dg" name="dg" class="selectbox80">
                            <option value="o" <?php if($dg == "o") echo "selected='selected'"; ?>>출조일</option>
                            <option value="b" <?php if($dg == "b") echo "selected='selected'"; ?>>예약접수일</option>
                        </select>
                        <div class="clear lg-hidden tb-margin"></div>
                        <input type="text" id="sdate" name="sdate" value="<?php echo stripslashes($sdate) ?>" class="frm_input schdate" maxlength="10" minlength="10" placeholder=""> ~ 
                        <input type="text" id="edate" name="edate" value="<?php echo stripslashes($edate) ?>" class="frm_input schdate" maxlength="10" minlength="10" placeholder="">
                        <div class="clear lg-hidden tb-margin"></div>
                        <button type="button" class="btn-time" data-sch="today">오늘</button>
                        <button type="button" class="btn-time" data-sch="yesterday">어제</button>
                        <button type="button" class="btn-time" data-sch="thismonth">이번달</button>
                        <button type="button" class="btn-time" data-sch="prevmonth">지난달</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="sch-th">예약상태</th>
                    <td colspan="3" style="text-align:left;">
                        <select id="bs" name="bs" class="selectbox80">
                            <option value="">전체</option>
                            <option value="-2" <?php if($bs == "-2") echo "selected='selected'"; ?>>예약취소요청</option>
                            <option value="-1" <?php if($bs == "-1") echo "selected='selected'"; ?>>예약취소</option>
                            <option value="0" <?php if($bs == "0") echo "selected='selected'"; ?>>예약접수</option>
                            <option value="1" <?php if($bs == "1") echo "selected='selected'"; ?>>예약완료</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="sch-th">선박선택</th>
                    <td colspan="3" style="text-align:left;">
                        <select id="s_idx" name="s_idx" class="selectbox80">
                            <option value="">전체</option>
                            <?php for($i=0;$srows=sql_fetch_array($srslt);$i++) { ?>
                            <option value='<?php echo $srows[s_idx];?>' <?php if($s_idx == $srows[s_idx]) echo "selected='selected' ";?>><?php echo get_text($srows[s_name]);?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="sch-th">검색어</th>
                    <td colspan="3" style="text-align:left;">
                        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" class="frm_input" style="width:200px;" maxlength="20" placeholder="입금자, 연락처, 회원아이디로 검색">
                        <input type="submit" value="검색" class="btn_submit" style="background-color:#ccc;padding:0 10px;">
                        <?php if($sch) { ?>
                        <span style="padding:6px 6px;background-color:#128700;vertical-align:middle;">
                            <a href="./book_list_all.php" style="color:#ffffff;">검색초기화</a>
                        </span>
                        <?php } ?>
                    </td>
                </tr>

            </tbody>
        </table>
        </form>
	</div>

	<div class="floatR sumdiv">
		<table>
			<tbody>
				<tr>
					<th scope="row" class="sch-th">예약완료</th>
					<td colspan="3" style="text-align:left;">
                        <?php echo number_format($bkInfo['bk_okcnt']);?>건(<?php echo number_format($bkInfo['bk_oksum']);?>명) - <?php echo number_format($bkInfo['bk_okprice']);?>원
                    </td>
				</tr>
				<tr>
					<th scope="row" class="sch-th">예약접수</th>
					<td colspan="3" style="text-align:left;">
                        <?php echo number_format($bkInfo['bk_waitcnt']);?>건(<?php echo number_format($bkInfo['bk_waitsum']);?>명) - <?php echo number_format($bkInfo['bk_waitprice']);?>원
                    </td>
				</tr>
				<tr>
					<th scope="row" class="sch-th">예약취소</th>
					<td colspan="3" style="text-align:left;">
                        <?php echo number_format($bkInfo['bk_cancelcnt']);?>건(<?php echo number_format($bkInfo['bk_cancelsum']);?>명) - <?php echo number_format($bkInfo['bk_cancelprice']);?>원
                    </td>
				</tr>
				<tr>
					<th scope="row" class="sch-th">예약취소신청</th>
					<td colspan="3" style="text-align:left;">
                        <?php echo number_format($bkInfo['bk_cancel_reqcnt']);?>건(<?php echo number_format($bkInfo['bk_cancel_reqsum']);?>명) - <?php echo number_format($bkInfo['bk_cancel_reqprice']);?>원
                    </td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="clear:both;"></div>

    

	<form name="fbooklist" id="fbooklist" onsubmit="return fbooklist_submit(this);" method="post">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="">
	<input type="hidden" name="s_idx" value="<?php echo $s_idx ?>">
	<div class="" style="padding: 18px 0;">
		<div class="btn_add01 btn_add" style="margin: 0 0 10px">
			<a href="./book_list_calendar_all.php" id="bo_add">다이어리형 보기</a>
		</div>

		<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<thead>
				<tr>
					<th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" id="chkall" title="현재 페이지 목록 전체선택" onclick="check_all(this.form)"></th>
					<th scope="col" rowspan="2">번호</th>
					<th scope="col" rowspan="2">예약자</th>
					<th scope="col" rowspan="2">연락처</th>
					<th scope="col" rowspan="2">예약어선</th>
					<th scope="col" rowspan="2">출조테마</th>
					<th scope="col" rowspan="2">출조일</th>
					<th scope="col" rowspan="2">출조인원</th>
					<th scope="col" rowspan="2">예약메모</th>
					<th scope="col" rowspan="2">예약접수일</th>
					<th scope="col" rowspan="2">입금자</th>
					<th scope="col" colspan="3">입금현황</th>
					<th scope="col" rowspan="2">예약상태</th>
				</tr>
				<tr>
					<th scope="col">총출조비용</th>
					<th scope="col">입금액</th>
					<th scope="col">미수잔액</th>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
				<?php
					$list = $i%2;
					$nListorder--; //게시물 일련번호
					$bg = 'bg'.($i%2);

					// 회원ID
					$bk_mb_id = $row[bk_mb_id];
					if($row[bk_channel] != "") $bk_mb_id="<span style='color:red;'>".$row[bk_channel]."</span>";
					// 회원명
					$bk_mb_name = get_text($row[bk_mb_name]);
					// 예약자(입금자)명
					$bk_banker = get_text($row[bk_banker]);
					// 예약자연락처
					$bk_tel = get_text($row[bk_tel]);
					// 어선명
					$s_name = get_text($row[s_name]);
					// 출조테마
					$bk_theme = get_text($row[bk_theme]);
					// 출조일
					$bk_ymd = $row[bk_y]."-".$row[bk_m]."-".$row[bk_d];
					// 출조인원
					$bk_member_cnt = number_format($row[bk_member_cnt]);
					// 예약메모
					$bk_memo = get_text($row[bk_memo]);
					// 예약접수일
					$bk_datetime = $row[bk_datetime];
					// 총출조비용
					$bk_price_total = number_format($row[bk_price_total]);
					// 수금액
					$pay_amount = number_format($row[pay_amount]);
					if($row[pay_amount] >= 0) $misu_total = $row[pay_amount] - $row[bk_price_total];
					else if($row[pay_amount] < 0) $misu_total = $row[pay_amount] + $row[bk_price_total];

					// 미수잔액
					//$misu_total = $row[bk_price_total] - $row[pay_amount];
					$misu_total = number_format($misu_total);
				?>
				<tr class="tr-hover">
					<td class="td40 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u" onclick="event.cancelBubble = true;">
						<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						<input type="hidden" name="bk_idx[<?php echo $i ?>]" value="<?php echo $row['bk_idx'] ?>" id="bk_idx_<?php echo $i ?>">
						<input type="hidden" name="bk_member_cnt[<?php echo $i ?>]" value="<?php echo $row['bk_member_cnt'] ?>">
					</td>
					<td class="td50 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $nListorder; ?></td>
					<td class="td100 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_mb_name; ?><br>(<?php echo $bk_mb_id; ?>)</td>
					<td class="td90 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_tel; ?></td>
					<td class="td100 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $s_name;?></td>
					<td class="td200 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_theme;?></td>
					<td class="td80 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_ymd; ?></td>
					<td class="td60 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_member_cnt; ?></td>
					<td class="tdmin150 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u" style="padding-left:10px;text-align:left;"><?php echo $bk_memo; ?></td>
					<td class="td140 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_datetime; ?></td>
					<td class="td100 showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_banker; ?></td>
					<td class="td70 ta-right showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><?php echo $bk_price_total; ?></td>
					<td class="td70 ta-right"><input type="text" name="pay_amount[<?php echo $i ?>]" class="td70 ta-right" maxlength="7" value="<?php echo $pay_amount; ?>"></td>
					<td class="td70 ta-right showmodal" data-tgt="booking" data-valarr="<?php echo $row['bk_idx'] ?>|u"><span style="color:red;"><?php echo $misu_total; ?></span></td>
					<td class="td100">
						<?php if($row[bk_status] == "-2") {?>
						<select name="bk_status[<?php echo $i ?>]" class="selectbox100">
							<option value="-2" selected='selected' >예약취소요청</option>
							<option value="-1">예약취소</option>
							<option value="1">예약완료</option>
						</select>
						<?php } else if($row[bk_status] == "-1") { ?>
						<span style="color:red;">예약취소</span>
						<input type="hidden" name="bk_status[<?php echo $i ?>]" value="-1">
						<?php } else if($row[bk_status] == "1") { ?>
						<select name="bk_status[<?php echo $i ?>]" class="selectbox100">
							<option value="-1">예약취소</option>
							<option value="1" selected='selected'>예약완료</option>
						</select>
						<?php } else { ?>
						<select name="bk_status[<?php echo $i ?>]" class="selectbox100">
							<option value="-1">예약취소</option>
							<option value="0" selected='selected'>예약접수</option>
							<option value="1">예약완료</option>
						</select>
						<?php } ?>
					</td>
				</tr>
				<?php } ?>

				<?php if (!$i) echo "<tr><td colspan='15' class=\"empty_table\">예약내용이 없습니다.</td></tr>"; ?>
			</tbody>
		</table>
	</div>

	<div class="btn_list01 btn_list" style="float:left;margin:0;">
		<button type="submit" id="btn_list_modify" class="btn_list_modify" style="vertical-align:bottom;">선택적용</button>
	</div>
	<div class="btn_list01 btn_list" style="float:right;margin:0;">
		<button type="button" id="btn_book_write" class="showmodal" style="vertical-align:bottom;" data-tgt="booking" data-valarr="|">예약등록</button>
	</div>
	</form>
</div>

<?php
	if ($pagelist) {
		echo "<div style='width:100%;padding:20px 0;text-align:center;'>$pagelist</div>";
	}
?>

<script>
$( function() {
	$( "#sdate" ).datepicker({
		dateFormat: 'yy-mm-dd',
		monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNamesMin:['일','월','화','수','목','금','토'],
		changeMonth:true, // 월변경가능
		changeYear:true,  // 년변경가능
		showMonthAfterYear:true // 년 뒤에 월표시
	});
	$( "#edate" ).datepicker({
		dateFormat: 'yy-mm-dd',
		monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNamesMin:['일','월','화','수','목','금','토'],
		changeMonth:true, // 월변경가능
		changeYear:true,  // 년변경가능
		showMonthAfterYear:true // 년 뒤에 월표시
	});
});

// 기간 검색
$(document).off("click",".btn-time").on("click",".btn-time",function(e){

	var sch = $(this).data("sch");
	var now = new Date();
	var fd, ld;

	if(sch == "today")
	{
		// 현재 5월10일 기준
		var fd = new Date(); // 오늘(5월10일)
		var ld = new Date(); // 오늘(5월10일)
	}
	else if(sch == "yesterday")
	{
		var fd = new Date(new Date().setDate(new Date().getDate()-1)); // 하루전(4월30일)
		var ld = new Date(new Date().setDate(new Date().getDate()-1)); // 하루전(4월30일)
	}
	else if(sch == "thismonth")
	{
		var fd = new Date(new Date().setMonth(new Date().getMonth(), 1)); // 이번달 첫날(5월1일)
		var ld = new Date(new Date().setMonth(new Date().getMonth()+1, 0)); // 이번달 마지막날(5월31일)
	}
	else if(sch == "prevmonth")
	{
		var fd = new Date(new Date().setMonth(new Date().getMonth()-1, 1)); // 한달전 첫날(4월1일)
		var ld = new Date(new Date().setMonth(new Date().getMonth(), 0)); // 한달전 마지막날(4월30일)
	}
	// 화면에 표시
	$("#sdate").val(dateToYYYYMMDD(fd));
	$("#edate").val(dateToYYYYMMDD(ld));
});

//모달창 띄우기
$(document).off("click",".showmodal").on("click",".showmodal",function(e){
	e.preventDefault();
	var tgt = $(this).data("tgt");
	var valarr = $(this).data("valarr");
	show_modal('layerpopup2',tgt,valarr);
});

</script>

<script>
// 리스트 적용
function fbooklist_submit(f)
{
	ajax_fbooklist_submit();
	return false;
}

// 리스트 적용 AJAX 처리
function ajax_fbooklist_submit()
{
    if (!is_checked("chk[]")) {
        alert("적용하실 예약항목을 선택하십시오.");
        return false;
    }

	var formData = $("#fbooklist").serialize();

	$.ajax({ 
		type: "POST",
		url: "./ajax_book_list_all_modify.php",
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
				alert("적용되었습니다.");
				document.location.reload();
			}
		},
		complete: function(){
			loadend();
		}
	});
}
</script>
<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
