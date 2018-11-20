<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div class="vdiv"></div>

<div id="mini_calendar" class="cal-po-rel">
	<div class="container cal-cont">
		<div class="mini-calendar">
			<div class="ym-wrap-div">
				<h3 class="ym-wrap-h3">
					<span id="custom-prev" class="prev-month <?php echo $calArrowPrev;?>" data-ymd="<?php echo $prevMonth;?>" data-fymd="<?php echo $prevMonthFymd;?>"  style="padding-right:10px;">
						<img src="<?php echo G5_IMG_URL;?>/back2.png">
					</span>
					<span id="custom-year" class="custom-year"><?php echo $cy;?></span>년
					<span id="custom-month" class="custom-month"><?php echo $cm;?>월</span>
					<span id="custom-next" class="next-month <?php echo $calArrowNext;?>" data-ymd="<?php echo $nextMonth;?>" data-fymd="<?php echo $nextMonthFymd;?>" style="padding-left:10px;">
						<img src="<?php echo G5_IMG_URL;?>/next2.png">
					</span>
					<span id="custom-current" class="custom-current" title="Go to current date"></span>
				</h3>
			</div>

			<div class="swiper-container">
				<div class="swiper-wrapper">
					
					<?php for($i=0;$i<$lastday;$i++) {?>
					<?php 
						$active="";
						$j=$i+1;
						if($j==$d) $active="";

						$_day = $i+1;
						if($_day < 10) $_day = "0".$_day;

						// 물때추출
						$lunarArr = getLunarDate($cy, $cm, $_day);
						$_sc_ymd = $cy.$cm.$_day;

						$tidenum = $lunarArr[3];
						if($comfig[tide] == "7")
							$tideName = $tideArr_w[$tidenum];
						else if($comfig[tide] == "8")
							$tideName = $tideArr_es[$tidenum];

						$datahash="";
						if($_day >=$cd) {
							$datahash="#tr_".$_sc_ymd;
							$dataymd=$_sc_ymd;
							$datafymd=$_sc_ymd;
						}

						// 요일추출
						$wd = date('w', strtotime($_sc_ymd));
						switch($wd)
						{
							case(0) : $weekday = "일"; $spancss = "span-sunday"; break;
							case(1) : $weekday = "월"; $spancss = ""; break;
							case(2) : $weekday = "화"; $spancss = ""; break;
							case(3) : $weekday = "수"; $spancss = ""; break;
							case(4) : $weekday = "목"; $spancss = ""; break;
							case(5) : $weekday = "금"; $spancss = ""; break;
							case(6) : $weekday = "토"; $spancss = "span-saturday"; break;
						}	

						// 해당일 기상정보
						$wicon = "";
						$fcam = sql_fetch(" select * from m_fcst where ymd='{$_sc_ymd}' and dayb='오전' ");
						if($fcam[ymd])
						{
							$wicon = "<img src='".$fcam[wicon]."' style='height:15px;'>";
							$wsky =$fcam[sky];
						}
						$fcpm = sql_fetch(" select * from m_fcst where ymd='{$_sc_ymd}' and dayb='오후' ");
						if($fcpm[ymd])
						{
							$wicon = "<img src='".$fcpm[wicon]."' style='height:15px;'>";
							$wsky = $fcpm[sky];
						}
						if(!$fcpm[ymd] && !$fcam[ymd])
						{
							$fcall = sql_fetch(" select * from m_fcst where ymd='{$_sc_ymd}' and dayb='종일' ");
							if($fcall[ymd])
							{
								$wicon = "<img src='".$fcall[wicon]."' style='height:15px;'>";
								$wsky = $fcall[sky];
							}
						}

					?>
					<div id="slide_<?php echo $i;?>" class="swiper-slide <?php echo $active;?>" data-hash="<?php echo $datahash;?>" data-ymd="<?php echo $dataymd;?>" data-fymd="<?php echo $datafymd;?>">
						<div class="day-wt-wrap">
							<span class="day-name <?php echo $spancss;?>"><?php echo $j;?>(<?php echo $weekday;?>)</span>
							<span class="wt-name <?php echo $spancss;?> "><?php echo $tideName;?><?php echo $wicon;?></span>
						</div>
					</div>
					<?php } ?>
				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>
</div>


<div class="table-responsive table-bk">
	<table class="table table-bordered u-table--v2">
		<thead class="text-uppercase g-letter-spacing-1">
		<tr>
			<th class="g-font-weight-300 g-color-black">날짜</th>
			<th class="g-font-weight-300 g-color-black g-min-width-200">선박</th>
			<th class="g-font-weight-300 g-color-black g-min-width-200">예약현황</th>
		</tr>
		</thead>
		<tbody>
		<?php // 월날짜추출
		for($i=$d-1;$i<$lastday;$i++) {
			$_day = $i+1;
			if($_day < 10) $_day = "0".$_day;

			// 물때추출
			$lunarArr = getLunarDate($cy, $cm, $_day);
			$_sc_ymd = $cy.$cm.$_day;

			$tidenum = $lunarArr[3];
			if($comfig[tide] == "7")
				$tideName = $tideArr_w[$tidenum];
			else if($comfig[tide] == "8")
				$tideName = $tideArr_es[$tidenum];

			// 요일추출
			$wd = date('w', strtotime($_sc_ymd));
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

			$sql2 = " select * from m_ship where s_expose='y' ";
			$result2 = sql_query($sql2);
			$totcnt2 = sql_num_rows($result2);
		
			$trid="";
			$trid="id='tr_".$_sc_ymd."'";

			$tdoffcss = "";
			$is_past = false;
			if($_sc_ymd < date("Ymd")) {
				$is_past = true;
				$tdoffcss = "td-off";
			}

			for($j=0;$row2=sql_fetch_array($result2);$j++) { // 어선추출

				$available = "";
				$available_str =  '<span style="color:red;">예약불가</span>';

				$sc = sql_fetch(" select * from m_schedule where s_idx = '{$row2[s_idx]}' and sc_ymd='{$_sc_ymd}' ");
				// 선박명
				$s_name = get_text($row2['s_name']);
				// 출조제목
				$sc_theme = get_text($sc['sc_theme']);
				// 출조제목색깔
				$sc_theme_color = "#333";
				if($sc['sc_theme_color']) $sc_theme_color = $sc['sc_theme_color'];
				// 출조비용
				$sc_price = number_format($sc['sc_price']);
				// 출조공지
				$sc_desc = "출조일정이 없습니다.";

				// 예약인원현황
				$bkMebers = get_bk_members($sc[s_idx], $sc[sc_ymd]);
				$has_schedule = false;

				if($is_past == false) {
					if($sc[sc_idx]) {
						// 출조공지
						$sc_desc = get_text($sc[sc_desc],1);
						$has_schedule = true;

						// 예약가능인원
						$available = $sc[sc_max] - $sc[sc_booked];
						$available_str = '<span style="color:blue;">'.$available.'명</span>';
						$availcnt_css = "availcnt";
						$tdoffcss2 = "";

						if(!$sc[sc_idx]) {
							$available = 0;
							$available_str = '<span style="color:red;">예약불가</span>';
							$availcnt_css = "";
						} else {
							if($sc[sc_status] != "0") {
								$available = 0;
								$available_str = '<span style="color:red;">예약마감</span>';
								$availcnt_css = "";
							}
							if($available == "0") 
							{
								$available = 0;
								$available_str = '<span style="color:red;">예약마감</span>';
								$availcnt_css = "";
							}
						}
					} else {
						$has_schedule = false;

						$available = 0;
						$available_str = '<span style="color:red;">예약불가</span>';
						$availcnt_css = "";
						$tdoffcss2 = "td-off";
					}
				} else {
					if($sc[sc_idx]) {
						$has_schedule = true;
						// 출조공지
						$sc_desc = get_text($sc[sc_desc],1);
					} else {
						$has_schedule = true;
						$sc_desc = "출조일정이 없습니다.";
					}

					$available = 0;
					$available_str = '<span style="color:red;">예약불가</span>';
					$availcnt_css = "";
					$tdoffcss2 = "td-off";
				}

				$bdbtmcss = "";
				$lastnum = $j+1;
				if($totcnt2 == $lastnum) $bdbtmcss = "bd-btm";

				//print_r2($sc);
			?>
			<tr <?php if($j=="0") echo $trid;?> class="<?php echo $bdbtmcss;?>">
				<?php if($j=="0") {?>
				<td class="align-middle text-nowrap td-day <?php echo $tdoffcss;?> bd-btm" rowspan="<?php echo $totcnt2;?>">
					<span class="daywd"><?php echo $_day;?>일(<?php echo $weekday;?>)</span>
				</td>
				<?php } ?>
				<td class="align-middle td-ship <?php echo $tdoffcss;?> <?php echo $tdoffcss2;?>">
					<div class="div-ship-bk">
						<div class="d-flex"><span class="ship-name"><?php echo $s_name;?></span></div>
						<div class="bk_btn">
							<?php if($available > 0) {?>
							<button type="button" data-sidx="<?php echo $sc[s_idx];?>" data-ymd="<?php echo $_sc_ymd;?>" data-fymd="<?php echo $_sc_ymd;?>" class="btn-bk-link">예약하기</a>
							<?php } ?>
						</div>
					</div>
				</td>
				<?php if($has_schedule) {?>
				<td class="align-middle td-bkcont <?php echo $tdoffcss;?> <?php echo $tdoffcss2;?>">
					<div style="padding-bottom:10px;"><span class="daily-ship-title"><?php echo $cy;?>-<?php echo $cm;?>-<?php echo $_day;?>(<?php echo $weekday;?>)-<?php echo $tideName;?>: <?php echo $s_name;?></span></div>
					<div style="padding-bottom:2px;"><span class="daily-ship-theme" style="color:<?php echo $sc_theme_color;?>">※ <?php echo $sc_theme;?> (1인 <?php echo $sc_price;?>원)</span></div>
					<div style="padding-bottom:10px;"><span class="daily-ship-notice">※ <?php echo $sc_desc;?></span></div>
					<div>
						<div class="bkok-div">
							<span>※ 예약완료 - <?php echo $bkMebers['bkokMemberCnt'];?>명</span>
						</div>
						<div class="daily-ship-bkok"><?php echo $bkMebers['bkok'];?></div>
					</div>
					<div>
						<div class="bkwait-div">
							<span>※ 예약대기 - <?php echo $bkMebers['bkwaitMemberCnt'];?>명</span>
						</div>
						<span class="daily-ship-bkwait"><?php echo $bkMebers['bkwait'];?></span>
					</div>
					<?php if($is_past==false) {?>
					<div>
						<div class="bkwait-div">
							<span style="color:red;">※ 남은자리 - <span class="<?php echo $availcnt_css;?>"><?php echo $available_str;?></span></span>
						</div>
						
					</div>
					<?php } ?>
				</td>
				<?php } else { ?>
				<td class="align-middle td-bkcont <?php echo $tdoffcss;?> <?php echo $tdoffcss2;?>">
					<div><span class="daily-ship-title"><?php echo $cy;?>-<?php echo $cm;?>-<?php echo $_day;?>(<?php echo $weekday;?>)-<?php echo $tideName;?>: <?php echo $s_name;?></span></div>
					<div><span class="daily-ship-notice">출조일정이 없습니다.</div>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		<?php } ?>
		</tbody>
	</table>
</div>
