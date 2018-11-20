<?php
$sub_menu = "410000";
include_once("./_common.php");

auth_check($auth[$sub_menu], 'w');

$pgubun = "book_list_calendar";

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

$g5['title'] = $s_name." - 예약현황";

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
.selectbox80{width:80px;height:28px;}
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

.tbl_head01 thead th.inner-th{height:14px;background:#f3f3f3;padding: 5px 0;}
.tbl_head01 tbody td.inner-td{height:14px;padding: 5px;}
.bookMem{display:inline;padding-right: 10px;}
.btn-list-modi{background:#f3f3f3;border:1px solid #ccc; padding:5px;outline:none !important;}
</style>


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

		<!--<span id="datepicker"><input type="text" value="2019-01-02"></span>-->
		<span class="next-month cal-arrow"><img src="<?php echo G5_IMG_URL;?>/next.png"></span>
	</div>
	<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<thead>
			<tr>
				<th scope="col">날짜</th>
				<th scope="col">예약상세</th>
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
			// 출조비용
			$sc_price = number_format($row[sc_price]);
			// 예약정원
			$sc_max = number_format($row[sc_max]);
			// 현재예약접수인원
			$scwaitFetch = sql_fetch(" select ifnull(sum(bk_member_cnt), 0) as sc_wait from m_bookdata where bk_ymd = '{$row[sc_ymd]}'  and s_idx = '{$row[s_idx]}' and bk_status = '0' ");
			$sc_wait = number_format($scwaitFetch[sc_wait]);
			// 현재예약취소인원
			$sccancelFetch = sql_fetch(" select ifnull(sum(bk_member_cnt), 0) as sc_cancel from m_bookdata where bk_ymd = '{$row[sc_ymd]}'  and s_idx = '{$row[s_idx]}' and bk_status = '-1' ");
			$sc_cancel = number_format($sccancelFetch[sc_cancel]);
			// 현재예약확정인원
			$sc_booked = number_format($row[sc_booked]);
			// 현재예약가능인원
			$sc_available = $row[sc_max] - $row[sc_booked];
			$sc_available = number_format($sc_available);
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
			switch($row[sc_status])
			{
				case(0) : $sc_status = "<span style='color:blue;'>예약가능</span>"; break;
				case(1) : $sc_status = "<span style='color:red;'>예약마감</span>"; break;
			}	

			// 과거날짜면 readonly로
			$readOnly = $reQuired = "";
			if($thisDay < G5_TIME_YMD ) {$readOnly = " readonly='readonly' "; $reQuired = ""; $sc_status = "<span style='color:red;'>예약마감</span>";}

			// 날짜별 어선별 예약데이터 추출
			$bksql =  " select * from m_bookdata where bk_ymd = '{$row[sc_ymd]}'  and s_idx = '{$row[s_idx]}' order by bk_datetime desc ";
			$bkresult = sql_query($bksql);
			$bkcnt = sql_num_rows($bkresult);
			?>
			<tr>
				<td class="td140">
					<?php echo $sc_ymd;?> (<?php echo $weekday; ?>) 
					<?php if($thisDay >= G5_TIME_YMD ) {?>
					<span  class="showmodal" id="btn_modal" data-tgt="daily" data-valarr="<?php echo $row[sc_ymd];?>|<?php echo $s_idx;?>"><i class="fa fa-cog"></i></span>
					<?php } ?>
					<p><?php echo $sc_status;?></p>
				</td>
				<td class="" style="padding:10px; text-align:left;">
					<?php if($bkcnt > 0) { ?>
					<?php if ($is_mobile == "1"){ ?>
						<div class="m_book_date">
							<?php echo $sc_ymd;?> (<?php echo $weekday; ?>) 
							<?php if($thisDay >= G5_TIME_YMD ) {?>
							<span  class="showmodal xs-hidden" id="btn_modal" data-tgt="daily" data-valarr="<?php echo $row[sc_ymd];?>|<?php echo $s_idx;?>"><i class="fa fa-cog"></i></span>
							<?php } ?>
						</div>
						<div style="padding-bottom:10px; float:left;">
							<span style="color:#111;font-weight:bolder;">※ <?php echo $s_name; ?> (정원 <?php echo $sc_max; ?>명)  - <?php echo $sc_theme; ?></span>
							(
							<span class="bookMem" style="color:#333;">예약접수 <?php echo $sc_wait; ?>명,</span>
							<span class="bookMem" style="color:red;">예약취소 <?php echo $sc_cancel; ?>명,</span>
							<span class="bookMem" style="color:blue;">예약확정 <?php echo $sc_booked; ?>명,</span>
							<span class="bookMem" style="color:green;">예약가능 <?php echo $sc_available; ?>명</span>
							)
						</div>
						<form id="fbooklist_<?php echo $row[sc_ymd];?>" onsubmit="return fbooklist_submit(this,'<?php echo $row[sc_ymd];?>');" method="post">
							<input type="hidden" name="token" value="">
							<input type="hidden" name="s_idx" value="<?php echo $s_idx ?>">
							<input type="hidden" name="sc_idx" value="<?php echo $row[sc_idx] ?>">
							<input type="hidden" name="sc_ymd" value="<?php echo $row[sc_ymd] ?>">
							<div style="padding-bottom:10px; float:right;">		
								<button type="submit" id="btn_<?php echo $row[sc_ymd];?>" data-ymd="<?php echo $row[sc_ymd];?>" class="btn-list-modi">설정적용</button>
							</div>
							<?php for($k=0;$bkrow=sql_fetch_array($bkresult);$k++) { ?>
								<?php
									$z = $row[sc_ymd]."_".$k;
									// 회원ID
									$bk_mb_id = $bkrow[bk_mb_id];
									// 회원명
									$bk_mb_name = get_text($bkrow[bk_mb_name]);
									// 예약자(입금자)명
									$bk_banker = get_text($bkrow[bk_banker]);
									// 예약자연락처
									$bk_tel = get_text($bkrow[bk_tel]);
									// 어선명
									$s_name = $s_name;
									// 출조테마
									$bk_theme = get_text($bkrow[bk_theme]);
									// 출조일
									$bk_ymd = $bkrow[bk_y]."-".$bkrow[bk_m]."-".$bkrow[bk_d];
									// 출조인원
									$bk_member_cnt = number_format($bkrow[bk_member_cnt]);
									// 예약메모
									$bk_memo = get_text($bkrow[bk_memo]);
									// 예약접수일
									$bk_datetime = $bkrow[bk_datetime];
									// 총출조비용
									$bk_price_total = number_format($bkrow[bk_price_total]);
									// 수금액
									$pay_amount = number_format($bkrow[pay_amount]);
									if($bkrow[pay_amount] >= 0) $misu_total = $bkrow[pay_amount] - $bkrow[bk_price_total];
									else if($bkrow[pay_amount] < 0) $misu_total = $bkrow[pay_amount] + $bkrow[bk_price_total];
			
									// 미수잔액
									//$misu_total = $bkrow[bk_price_total] - $bkrow[pay_amount];
									$misu_total = number_format($misu_total);
									// 예약상태
									switch($bkrow[bk_status])
									{
										case("-2") : $bk_status = "<span style='color:red;'>예약취소요청</span>"; break;
										case("-1") : $bk_status = "<span style='color:red;'>예약취소</span>";$addHideClass="canceled"; break;
										case("0") : $bk_status = "<span style='color:#333;'>예약접수</span>"; break;
										case("1") : $bk_status = "<span style='color:blue;'>예약완료</span>"; break;
									}	
								?>
							<table class="m_detail_table <?php echo $addHideClass; ?>">
								<tr>
									<td class="m_td_title">예약상태</td>
									<td class="m_td_title">입금자명</td>
								</tr>
								<tr>
									<td>
										<?php echo $bk_status;?>
										<input type="hidden" name="chk[]" value="<?php echo $z ?>" id="chk_<?php echo $z ?>">
										<input type="hidden" name="bk_idx[<?php echo $z ?>]" value="<?php echo $bkrow['bk_idx'] ?>" id="bk_idx_<?php echo $z ?>">
									</td>
									<td>
										<span style="color:#999;"><?php echo $bk_banker; ?></span>
									</td>
								</tr>
								<tr>
									<td class="hideAndShowBtn" colspan="2">
										<a onclick="openDetail('<?php echo $z ?>')" class="open_detail <?php echo $z ?>">자세히 보기</a>
										<a onclick="closeDetail('<?php echo $z ?>')" class="close_detail <?php echo $z ?>">닫기</a>
									</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td class="m_td_title">예약자명</td>
									<td class="m_td_title">연락처</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td>
										<?php echo $bk_mb_name;?>
									</td>
									<td>
										<?php echo $bk_tel; ?>
									</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td class="m_td_title">예약인원</td>
									<td class="m_td_title">예약접수일</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td>
										<?php echo $bk_member_cnt; ?>
										<input type="hidden" name="bk_member_cnt[<?php echo $z ?>]" class="td60 ta-right" maxlength="7" value="<?php echo $bkrow['bk_member_cnt'] ?>">
									</td>
									<td>
										<?php echo $bk_datetime; ?>
									</td>
								</tr>

								<tr class="c_book_detail <?php echo $z ?>">
									<td class="m_td_title">출조비용</td>
									<td class="m_td_title">미수잔액</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td>
										<?php echo $bk_price_total; ?>
									</td>
									<td>
										<span style="color:red;"><?php echo $misu_total; ?></span>
									</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td class="m_td_title" colspan="2">입금액</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td colspan="2">
										<input type="text" name="pay_amount[<?php echo $z ?>]" class="td60 ta-right" maxlength="7" value="<?php echo $pay_amount; ?>">
									</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td class="m_td_title" colspan="2">메모</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td colspan="2">
										<?php echo $bk_memo; ?>
									</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td class="m_td_title" colspan="2">예약설정</td>
								</tr>
								<tr class="c_book_detail <?php echo $z ?>">
									<td colspan="2">
										<?php if($bkrow[bk_status] == "-2") {?>
										<select name="bk_status[<?php echo $z ?>]" class="selectbox100">
											<option value="-2" selected='selected' >예약취소요청</option>
											<option value="-1">예약취소</option>
											<option value="1">예약완료</option>
										</select>
										<?php } else if($bkrow[bk_status] == "-1") { ?>
										<span style="color:red;">예약취소</span>
										<input type="hidden" name="bk_status[<?php echo $z ?>]" value="-1">
										<?php } else if($bkrow[bk_status] == "1") { ?>
										<select name="bk_status[<?php echo $z ?>]" class="selectbox100">
											<option value="-1">예약취소</option>
											<option value="1" selected='selected'>예약완료</option>
										</select>
										<?php } else { ?>
										<select name="bk_status[<?php echo $z ?>]" class="selectbox100">
											<option value="-1">예약취소</option>
											<option value="0" selected='selected'>예약접수</option>
											<option value="1">예약완료</option>
										</select>
										<?php } ?>
									</td>
								</tr>
							</table>
							<?php } ?>
						</form>
					<?php } else { ?>
					<form id="fbooklist_<?php echo $row[sc_ymd];?>" onsubmit="return fbooklist_submit(this,'<?php echo $row[sc_ymd];?>');" method="post">
					<input type="hidden" name="token" value="">
					<input type="hidden" name="s_idx" value="<?php echo $s_idx ?>">
					<input type="hidden" name="sc_idx" value="<?php echo $row[sc_idx] ?>">
					<input type="hidden" name="sc_ymd" value="<?php echo $row[sc_ymd] ?>">

					<div style="padding-bottom:10px; float:left;">		
						<span style="color:#111;font-weight:bolder;">※ <?php echo $s_name; ?> (정원 <?php echo $sc_max; ?>명)  - <?php echo $sc_theme; ?></span>
						(
						<span class="bookMem" style="color:#333;">예약접수 <?php echo $sc_wait; ?>명,</span>
						<span class="bookMem" style="color:red;">예약취소 <?php echo $sc_cancel; ?>명,</span>
						<span class="bookMem" style="color:blue;">예약확정 <?php echo $sc_booked; ?>명,</span>
						<span class="bookMem" style="color:green;">예약가능 <?php echo $sc_available; ?>명</span>
						)
					</div>
					<div style="padding-bottom:10px; float:right;">		
						<button type="submit" id="btn_<?php echo $row[sc_ymd];?>" data-ymd="<?php echo $row[sc_ymd];?>" class="btn-list-modi">설정적용</button>
					</div>
					<?php for($k=0;$bkrow=sql_fetch_array($bkresult);$k++) { ?>
						<?php
							$z = $row[sc_ymd]."_".$k;
							// 회원ID
							$bk_mb_id = $bkrow[bk_mb_id];
							// 회원명
							$bk_mb_name = get_text($bkrow[bk_mb_name]);
							// 예약자(입금자)명
							$bk_banker = get_text($bkrow[bk_banker]);
							// 예약자연락처
							$bk_tel = get_text($bkrow[bk_tel]);
							// 어선명
							$s_name = $s_name;
							// 출조테마
							$bk_theme = get_text($bkrow[bk_theme]);
							// 출조일
							$bk_ymd = $bkrow[bk_y]."-".$bkrow[bk_m]."-".$bkrow[bk_d];
							// 출조인원
							$bk_member_cnt = number_format($bkrow[bk_member_cnt]);
							// 예약메모
							$bk_memo = get_text($bkrow[bk_memo]);
							// 예약접수일
							$bk_datetime = $bkrow[bk_datetime];
							// 총출조비용
							$bk_price_total = number_format($bkrow[bk_price_total]);
							// 수금액
							$pay_amount = number_format($bkrow[pay_amount]);
							if($bkrow[pay_amount] >= 0) $misu_total = $bkrow[pay_amount] - $bkrow[bk_price_total];
							else if($bkrow[pay_amount] < 0) $misu_total = $bkrow[pay_amount] + $bkrow[bk_price_total];
	
							// 미수잔액
							//$misu_total = $bkrow[bk_price_total] - $bkrow[pay_amount];
							$misu_total = number_format($misu_total);
							// 예약상태
							switch($bkrow[bk_status])
							{
								case("-2") : $bk_status = "<span style='color:red;'>예약취소요청</span>"; break;
								case("-1") : $bk_status = "<span style='color:red;'>예약취소</span>"; break;
								case("0") : $bk_status = "<span style='color:#333;'>예약접수</span>"; break;
								case("1") : $bk_status = "<span style='color:blue;'>예약완료</span>"; break;
							}	
						?>
					
					<table>
						<caption><?php echo $g5['title']; ?> 목록</caption>
						<thead>
							<tr>
								<th class="inner-th" scope="col">예약상태</th>
								<th class="inner-th" scope="col">예약자명</th>
								<th class="inner-th" scope="col">입금자명</th>
								<th class="inner-th" scope="col">연락처</th>
								<th class="inner-th" scope="col">예약인원</th>
								<th class="inner-th" scope="col">예약접수일</th>
								<th class="inner-th" scope="col">메모</th>
								<th class="inner-th" scope="col">출조비용</th>
								<th class="inner-th" scope="col">입금액</th>
								<th class="inner-th" scope="col">미수잔액</th>
								<th class="inner-th" scope="col">예약설정</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="inner-td td80">
									<?php echo $bk_status;?>
									<input type="hidden" name="chk[]" value="<?php echo $z ?>" id="chk_<?php echo $z ?>">
									<input type="hidden" name="bk_idx[<?php echo $z ?>]" value="<?php echo $bkrow['bk_idx'] ?>" id="bk_idx_<?php echo $z ?>">
								</td>
								<td class="inner-td td60">
									<?php echo $bk_mb_name;?>
								</td>
								<td class="inner-td td60"><span style="color:#999;"><?php echo $bk_banker; ?></span></td>
								<td class="inner-td td80"><?php echo $bk_tel; ?></td>
								<td class="inner-td td50">
									<?php echo $bk_member_cnt; ?>
									<input type="hidden" name="bk_member_cnt[<?php echo $z ?>]" class="td60 ta-right" maxlength="7" value="<?php echo $bkrow['bk_member_cnt'] ?>">
								</td>
								<td class="inner-td td130"><?php echo $bk_datetime; ?></td>
								<td class="inner-td ta-left"><?php echo $bk_memo; ?></td>
								<td class="inner-td td70"><?php echo $bk_price_total; ?></td>
								<td class="inner-td td70">
									<input type="text" name="pay_amount[<?php echo $z ?>]" class="td60 ta-right" maxlength="7" value="<?php echo $pay_amount; ?>">
								</td>
								<td class="inner-td td70"><span style="color:red;"><?php echo $misu_total; ?></span></td>
								<td class="inner-td td100">
									<?php if($bkrow[bk_status] == "-2") {?>
									<select name="bk_status[<?php echo $z ?>]" class="selectbox100">
										<option value="-2" selected='selected' >예약취소요청</option>
										<option value="-1">예약취소</option>
										<option value="1">예약완료</option>
									</select>
									<?php } else if($bkrow[bk_status] == "-1") { ?>
									<span style="color:red;">예약취소</span>
									<input type="hidden" name="bk_status[<?php echo $z ?>]" value="-1">
									<?php } else if($bkrow[bk_status] == "1") { ?>
									<select name="bk_status[<?php echo $z ?>]" class="selectbox100">
										<option value="-1">예약취소</option>
										<option value="1" selected='selected'>예약완료</option>
									</select>
									<?php } else { ?>
									<select name="bk_status[<?php echo $z ?>]" class="selectbox100">
										<option value="-1">예약취소</option>
										<option value="0" selected='selected'>예약접수</option>
										<option value="1">예약완료</option>
									</select>
									<?php } ?>
								</td>
							</tr>
							<?php } ?>
							
						</tbody>
					</table>
					</form>
					<?php } 
					} else { ?>
					<div class="nobook">		
						<span style="color:#111;font-weight:bolder;">※ <?php echo $s_name; ?> (정원 <?php echo $sc_max; ?>명) - <?php echo $sc_theme; ?></span>
						( 예약현황이 없습니다. )
					</div>
					<?php } ?>

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

			// 과거날짜면 readonly로
			$readOnly = $reQuired = "";
			if($sc_ym < $now_ym) {$readOnly = " readonly='readonly' "; $reQuired = ""; }
			?>
			<tr>
				<td class="td140">
					<?php echo $sc_ymd;?> (<?php echo $weekday; ?>)
					<input type="hidden" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
					<input type="hidden" name="s_idx[<?php echo $i ?>]" value="<?php echo $row['s_idx'] ?>" id="s_idx_<?php echo $i ?>">
					<input type="hidden" name="sc_ymd[<?php echo $i ?>]" value="<?php echo $row['sc_ymd'] ?>" id="sc_ymd_<?php echo $i ?>">
				</td>
				<td class="" style="padding:10px; text-align:left;">
					<div>		
						<span style="color:#111;font-weight:bolder;">※ <?php echo $s_name; ?> - <span style="color:red;">예약설정된 내용이 없습니다.</span></span>
					</div>
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
	document.location.href = "./book_list_calendar.php?s_idx="+sidx+"&ym="+ym;
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
	document.location.href = "./book_list_calendar.php?s_idx="+sidx+"&ym="+ym;
});

//모달창 띄우기
$(document).off("click",".showmodal").on("click",".showmodal",function(e){
	e.preventDefault();
	var tgt = $(this).data("tgt");
	var valarr = $(this).data("valarr");
	show_modal('layerpopup2',tgt,valarr);
});

function chgym() {

	var go_y = String($("#go_y").val());
	var go_m = String($("#go_m").val());
	var go_ym = go_y+go_m;

	var sidx = "<?php echo $s_idx;?>";
	document.location.href = "./book_list_calendar.php?s_idx="+sidx+"&ym="+go_ym;
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
// 리스트 적용
function fbooklist_submit(f,scymd)
{
	ajax_fbooklist_submit(scymd);
	return false;
}

// 리스트 적용 AJAX 처리
function ajax_fbooklist_submit(scymd)
{
	var formData = $("#fbooklist_"+scymd).serialize();

	$.ajax({ 
		type: "POST",
		url: "./ajax_book_list_calendar_modify.php",
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

<script>
	$(document).ready(function(){
		$(".nobook").closest("tr").hide();
	});
	
	function openDetail(fornum){
		$(".c_book_detail."+fornum).show();
		$(".open_detail."+fornum).hide();
		$(".close_detail."+fornum).show();
	}
	function closeDetail(fornum){
		$(".c_book_detail."+fornum).hide();
		$(".open_detail."+fornum).show();
		$(".close_detail."+fornum).hide();
	}
	
	function hideCanceled(){
		$(".canceled").hide();
		$("#cancelREsult").text("감추기 완료");
		$("#cancelREsult").show();
		setTimeout(function(){ $("#cancelREsult").fadeOut(); }, 1000);
	}
	
	function showCanceled(){
		$(".canceled").show();
		$("#cancelREsult").text("보이기 완료");
		$("#cancelREsult").show();
		setTimeout(function(){ $("#cancelREsult").fadeOut(); }, 1000);
	}
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>
