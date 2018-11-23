<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun="member";

if (!$is_member) alert('로그인 후 이용하여 주십시오.', G5_URL);

$thisYmd = date("Ymd");


$sql_common = " from m_bookdata ";
$sql_search = " where bk_mb_id = '{$member[mb_id]}'  ";

$sop = strtolower($sop);
if ($sop != 'and' && $sop != 'or') $sop = 'and';

$stx = trim($stx);

// 분류 선택 또는 검색어가 있다면
if ($stx) $sql_search .= get_sql_search_lsh($sfl, $stx, $sop, $join_field="");
if ($sca) $sql_search .= " and cate='{$sca}' ";
if (!$sst) { $sst = "bk_datetime"; $sod = "desc"; } 
$sql_order = " order by $sst $sod ";

//=========== 페이징을 위한 Query 시작=================
$sqlcnt = " select bk_idx $sql_common $sql_search $sql_order ";
$resultcnt = sql_query($sqlcnt);
$total_count = sql_num_rows($resultcnt); 

$page_rows = 10;
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

//$pagelist = get_paging_nak($config[cf_write_pages], $page, $total_page, "?$qstr&g=$g&cate2=$cate2&page=");
$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");
//=========== 페이징을 위한 Query 끝===================

//=========== 리스트를 뽑아오는 Query 시작=============
$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $page_rows ";
$result = sql_query($sql);
//=========== 리스트를 뽑아오는 Query 끝===============

//=========== 정렬에 사용하는 QUERY_STRING=============
$qstr2 = "sop=$sop";
//=========== 정렬에 사용하는 QUERY_STRING=============

$todaytime = date("Y-m-d");

$g5['title'] = '예약현황';
include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo $member_skin_url;?>/style.css">
<style>
input.frm_input{width:100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}
.table > tbody > tr > td{vertical-align:middle;}
.interactive-slider-v2 {height: 470px;}
.item-fa{font-size:2em;}
h3.item-title{display:inline-block;padding-left:20px;}
.notespan{font-size: 1.3em;display: inline-block;border-bottom: 1px dotted #333;padding: 3px 6px;margin-bottom: 10px;}
.lsh-td1 .input-group p{margin-bottom: 6px;}

.lsh-subnav-ul>.active-sub-li {background-color:#e39799;}
.lsh-subnav-ul>.active-sub-li a {display:inline-block;width:100%;color:#ffffff; font-weight:bolder;}
.lsh-subnav-ul {display: inline-block;width: 100%;margin: 0;padding: 0 16px;margin-top: 10px;}
.lsh-subnav-ul>.lsh-subnav-li {background-color: #ffffff;float: left;font-size: 16px;line-height: 45px;margin: 0;padding: 0;text-align: center;list-style: none;outline: 1px solid #ccc;border: none;}

.lsh-nav-li .on, .lsh-sub-left-menu a.on{color:red;font-weight:700;}
.lsh-subnav-ul li a{display:inline-block;width:100%;text-decoration:none;}
.lsh-subnav-ul li a:hover{color:#333;text-decoration:none;}
.lsh-subnav-ul li a.on{background-color:#5a5a5a;color:white;font-weight:700;}

.btn-detail{padding:4px 10px;background:#fff;border:1px solid #ccc;}
.tr-cont{display:none;}
.btn-book-modi {padding:4px 10px;background:#006d31;border:1px solid #ccc;color:#fff;}
.btn-book-cancel {padding:4px 10px;background:#006d31;border:1px solid #ccc;color:#fff;}

.psg-span{padding:0 1px;padding-top:2px;float:left;}
.psg-num{display:block;}

.psg-name{width:15%;}
.psg-sex{width:8%;}
.psg-sex select{width:100%;height:34px;border:1px solid #ccc;}
.psg-birth{width:15%;}
.psg-tel{width:24%;}
.psg-addr{width:38%;}
@media screen and (max-width: 991px) {
	.table > thead > tr > th{font-size:12px;}
	.table > tbody > tr > td{font-size:12px;}
	.lsh-subnav-ul>.lsh-subnav-li {font-size: 12px;line-height:35px;}
}
@media (max-width: 767px) {
	.table > thead > tr > th{font-size:11px;}
	.table > tbody > tr > td{font-size:11px;}
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:12px;}
	.lsh-td-subj a{font-size:11px;}
}
@media (max-width: 640px) {
    input.frm_input {padding:3px;}
    .psg-name{width:24%;}
    .psg-sex{width:15%;}
    .psg-birth{width:25%;}
    .psg-tel{width:36%;}
    .psg-addr{width:100%;}
}
@media (max-width: 480px) {
	.lsh-td1 .input-group p{margin-bottom: 4px;font-size:11px;}
}
</style>
<!--페이지 CSS Include 영역-->

<!-- Interactive Slider v2 -->
<div class="interactive-slider-v2 img-v3">
	<div class="container">
		<p>Clean and fully responsive Template.</p>
	</div>
</div>
<!-- End Interactive Slider v2 -->


<!--=== Content Part ===-->
<div class="container content">
	<div class="row blog-page">
		<!-- Left Sidebar -->
		<div class="col-md-9">
			<div class="margin-bottom-40">
				<h2 class="pg-title">마이페이지</h2>
				<div class="row">	
					<ul class="lsh-subnav-ul">
						<li class="col-xxs-4 col-xs-4 lsh-subnav-li"><a href="<?php echo G5_SHIP_URL;?>/mypage.php" class="sub2nav">정보수정</a></li>
						<li class="col-xxs-4 col-xs-4 lsh-subnav-li"><a href="<?php echo G5_SHIP_URL;?>/mybooking.php" class="sub2nav on">예약현황</a></li>
						<li class="col-xxs-4 col-xs-4 lsh-subnav-li"><a href="<?php echo G5_SHIP_URL;?>/myboard.php" class="sub2nav">게시글현황</a></li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default margin-bottom-20">
				<table class="table table-striped invoice-table">
					<thead>
						<tr>
							<th class="lsh-td-num hidden-xxs hidden-xs ta-center">번호</th>
							<th class="lsh-td-name ta-center">예약상태</th>
							<th class="lsh-td-subj ta-center">예약내용</th>
							<th class="lsh-td-date hidden-xxs hidden-xs ta-center">출조일</th>
							<th class="lsh-td-name hidden-xxs hidden-xs ta-right">총출조비용</th>
							<th class="lsh-td-date hidden-xxs hidden-xs ta-center">예약접수일</th>
							<th class="lsh-td-name ta-center">상세보기</th>
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
							// 회원명
							$bk_mb_name = get_text($row[bk_mb_name]);
							// 예약자(입금자)명
							$bk_banker = get_text($row[bk_banker]);
							// 예약자연락처
							$bk_tel = get_text($row[bk_tel]);
							// 어선아이디
							$s_idx = $row[s_idx];
							// 어선명
							$s_name = get_text($row[s_name]);
							// 출조테마
							$bk_theme = get_text($row[bk_theme]);
							// 출조일
							$bk_ymd = $row[bk_y]."-".$row[bk_m]."-".$row[bk_d];
							// 출조인원
							$bk_member_cnt = number_format($row[bk_member_cnt]);
							// 예약메모
							$bk_memo = get_text($row[bk_memo],0);
							// 예약접수일
							$bk_datetime = $row[bk_datetime];
							// 총출조비용
							$bk_price_total = number_format($row[bk_price_total]);
							// 예약상태
							switch($row[bk_status])
							{
								case("-2") : $bk_status = "<span style='color:red;'>예약취소접수</span>"; break;
								case("-1") : $bk_status = "<span style='color:red;'>예약취소</span>"; break;
								case("0") : $bk_status = "<span style='color:#333;'>예약접수</span>"; break;
								case("1") : $bk_status = "<span style='color:blue;'>예약완료</span>"; break;
								default :  $bk_status = "<span style='color:#333;'>예약접수</span>"; break;
							}

							$bk_cancel_date = "";
							if($row[bk_status] == "-1") $bk_cancel_date = "<br><span style='color:red;font-size:10px;'>취소 : (".$row[cancel_datetime].")</span>";
						?>	
						<tr class="tr-hover">
							<td class="td50 hidden-xxs hidden-xs ta-center"><?php echo $nListorder; ?></td>
							<td class="td80 ta-center"><?php echo $bk_status; ?></td>
							<td class="ta-center"><span class="ellipsis ta-center"><?php echo $bk_theme;?></span></td>
							<td class="td110 hidden-xxs hidden-xs ta-center"><?php echo $bk_ymd; ?></td>
							<td class="td80 hidden-xxs hidden-xs ta-center"><?php echo $bk_price_total; ?></td>
							<td class="td150 hidden-xxs hidden-xs ta-center"><?php echo $bk_datetime; ?><?php echo $bk_cancel_date; ?></td>
							<td class="td80 ta-center"><button type="button" class="btn-detail">상세</button></td>
						</tr>
						<tr class="tr-cont">
							<td colspan="10">

								<?php if($row[bk_status] >= "0") { ?>
								<form id="fbookmodify_<?php echo $row[bk_idx];?>" onsubmit="return fbookmodify_submit(this,'<?php echo $row[bk_idx];?>');" method="post">
								<input type="hidden" name="token" value="">
								<input type="hidden" name="bk_idx" value="<?php echo $row[bk_idx] ?>">
								<input type="hidden" name="bk_status" value="<?php echo $row[bk_status] ?>">
								<?php } ?>

								<table class="table table-bordered">
									<tbody>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="" class="lsh-label">예약상태</label>
											</th>
											<td class="lsh-td1">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 예약상태</div>
												<div class="col-xxs-12 input-group lsh-form-nopadding">
													<?php echo $bk_status; ?><?php echo $bk_cancel_date; ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="" class="lsh-label">출조일</label>
											</th>
											<td class="lsh-td1">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 출조일</div>
												<div class="col-xxs-12 input-group lsh-form-nopadding">
													<?php echo $bk_ymd; ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="" class="lsh-label">출조테마</label>
											</th>
											<td class="lsh-td1">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 출조테마</div>
												<div class="col-xxs-12 input-group lsh-form-nopadding">
													<?php echo $s_name;?> - <?php echo $bk_theme;?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="" class="lsh-label">입금자명<strong class="sound_only">필수</strong></label>
											</th>
											<td class="lsh-td1">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 입금자명</div>
												<div class="col-xxs-12 input-group lsh-form-nopadding">
													<?php if($row[bk_status] == "0") { ?>
														<input type="text" name="bk_banker" class="frm_input required" maxlength="20" required="required" value="<?php echo $bk_banker;?>">
													<?php } else if($row[bk_status] == "1") {?>
														<?php echo $bk_banker; ?>
														<input type="hidden" name="bk_banker" value="<?php echo $bk_banker;?>">
													<?php } else if($row[bk_status] == "-1" || $row[bk_status] == "-2") {?>
														<?php echo $bk_banker; ?>
													<?php } ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="" class="lsh-label">연락처<strong class="sound_only">필수</strong></label>
											</th>
											<td class="lsh-td1">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 연락처</div>
												<div class="col-xxs-12 input-group lsh-form-nopadding">
													<?php if($row[bk_status] == "0") { ?>
														<input type="text" name="bk_tel" class="frm_input required" maxlength="20" required="required" value="<?php echo $bk_tel;?>">
													<?php } else if($row[bk_status] == "1") { ?>
														<input type="hidden" name="bk_tel" value="<?php echo $bk_tel;?>">
														<?php echo $bk_tel; ?>
													<?php } else if($row[bk_status] == "-1" || $row[bk_status] == "-2") {?>
														<?php echo $bk_tel; ?>
													<?php } ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="" class="lsh-label">예약인원<strong class="sound_only">필수</strong></label>
											</th>
											<td class="lsh-td1">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 예약인원</div>
												<div class="col-xxs-12 input-group lsh-form-nopadding">
													<?php if($row[bk_status] == "0") { ?>
													<?php
														$_ship_scsql = sql_fetch(" select * from m_schedule where s_idx = '{$s_idx}' and sc_ymd = '{$row[bk_ymd]}' ");
														$_available = $_ship_scsql[sc_max] - $_ship_scsql[sc_booked];
													?>

													<select id="rtn_selbox" name="bk_member_cnt" class="required" style="height:28px;" required="required">
													<?php for ($i=0; $i<$_ship_scsql[sc_max]; $i++) { ?>	
													<?php 
														$selected = "";
														$disabled = "";
                                                        $addOptStr = "";

                                                        $j=$i+1;

                                                        if($comfig['overbooking'] == "1") {
                                                            if($i>=$_available) {
                                                                $addOptStr = "(대기접수)";
                                                            }
                                                        } else {
                                                            if($j > $_available) $disabled = "disabled='disabled' ";
                                                        }    

                                                        if($j == $row[bk_member_cnt]) $selected = " selected='selected' ";
													?>
													<option value="<?php echo $j?>" <?php echo $disabled?>  <?php echo $selected?>><?php echo $j?> 명<?php echo $addOptStr?></option>
													<?php } ?>
													</select>
													<?php } else if($row[bk_status] == "1") {?>
													<input type="hidden" name="bk_member_cnt" value="<?php echo $row[bk_member_cnt];?>">
													<?php echo $bk_member_cnt; ?>명	
													<?php } else if($row[bk_status] == "-1" || $row[bk_status] == "-2") {?>
													<?php echo $bk_member_cnt; ?>명
													<?php } ?>
												</div>
											</td>
										</tr>
								        <?php if($row[bk_status] == "1") { // 예약완료인 경우에만 보임?>
                                        <?php
                                            $pssql = " select * from m_passenger where bk_idx = '{$row['bk_idx']}' order by ps_no asc ";
                                            $psrslt = sql_query($pssql);
                                            $pscnt = sql_num_rows($psrslt);

                                            if($bk_ymd >= $todaytime) { // 예약완료이고 예약일 이전이라면
                                                $readOnlyStr = "";
                                                $requiredStr = "";
                                            }
                                        ?>
										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="wr_content" class="lsh-label">승선명부</label>
											</th>
											<td class="lsh-td1 wr_content">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 승선명부</div>
												<div class="note color-red">※ 생년월일, 연락처는 기호없이 숫자로만 작성</div>
                                                <?php for($i=0;$psrow=sql_fetch_array($psrslt);$i++) { ?>
                                                <?php
                                                    $j=$i+1;
                                                    $ps_name = get_text($psrow['ps_name']);
                                                    $ps_sex = get_text($psrow['ps_sex']);
                                                    $ps_tel = get_text($psrow['ps_tel']);
                                                    $ps_birth = get_text($psrow['ps_birth']);
                                                    $ps_addr = get_text($psrow['ps_addr']);
                                                   
                                                ?>
                                                <div class="col-xxs-12 input-group lsh-form-nopadding g-mt-1 g-mb-1" style="padding:5px 0;">
                                                    <span class="psg-num"><i class="fa fa-user"></i> 예약자 <?php echo $j; ?></span>
                                                    <span class="psg-span psg-name">
                                                        <input type="text" name="psg[<?php echo $i; ?>][ps_name]" class="frm_input required" maxlength="255" required="required" value="<?php echo $ps_name;?>" placeholder="성명">
                                                    </span>

                                                    <span class="psg-span psg-sex">
                                                        <select name="psg[<?php echo $i; ?>][ps_sex]" class="input-lsh required" required="required">
                                                            <option value="m" <?php if($psrow['ps_sex'] == "m") echo "selected='selected'"; ?>>남</option>
                                                            <option value="f" <?php if($psrow['ps_sex'] == "f") echo "selected='selected'"; ?>>여</option>
                                                        </select>
                                                    </span>

                                                    <span class="psg-span psg-birth">
                                                        <input type="text" name="psg[<?php echo $i; ?>][ps_birth]" class="frm_input required" maxlength="255" required="required" value="<?php echo $ps_birth;?>" placeholder="생년월일">
                                                    </span>
                                                    <span class="psg-span psg-tel">
                                                        <input type="text" name="psg[<?php echo $i; ?>][ps_tel]" class="frm_input required" maxlength="255" required="required" value="<?php echo $ps_tel;?>" placeholder="연락처">
                                                    </span>
                                                    <span class="psg-span psg-addr">
                                                        <input type="text" name="psg[<?php echo $i; ?>][ps_addr]" class="frm_input required" maxlength="255" required="required" value="<?php echo $ps_addr;?>" placeholder="주소">
                                                    </span>
                                                </div>    
                                                <?php } ?>
                                            </td>
										</tr>
							        	<?php } ?>

										<tr>
											<th scope="row" class="hidden-xxs hidden-xs hidden-sm lsh-th1">
												<label for="wr_content" class="lsh-label">예약메모</label>
											</th>
											<td class="lsh-td1 wr_content">
												<div class="note visible-sm visible-xs visible-xxs"><strong>Note:</strong> 예약메모</div>
												<div id="txteditor" class="col-xxs-12 input-group" style="padding-bottom:0;">
													<?php if($row[bk_status] == "0") { ?>
													<textarea rows="5" name="bk_memo" id="bk_memo"  maxlength="65536" class="frm_textarea" style="width:100%;resize:none;" placeholder="예약메모"><?php echo $bk_memo; ?></textarea>
													<?php } else {?>
													<textarea rows="5" name="bk_memo" id="bk_memo" class="frm_textarea" style="width:100%;resize:none;" readonly="readonly"><?php echo $bk_memo; ?></textarea>
													<?php } ?>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<?php if((!($row[bk_status] == "-1" || $row[bk_status] == "-2")) && ($bk_ymd >= $todaytime)) { ?>
								<div style="padding:10px 0 40px 0;">
									<div class="lsh-write-btn-right">
										<?php if($row[bk_status] == "0") { ?>
										<input type="submit" class="btn-book-modi"  id="btn-book-modi" value="예약수정">
										<button type="button" class="btn-book-cancel" data-bkidx="<?php echo $row[bk_idx];?>">예약취소</button>
										<?php } else if($row[bk_status] == "1") { ?>
										<button type="button" class="btn-book-cancel" data-bkidx="<?php echo $row[bk_idx];?>">예약취소신청</button>
										<?php } ?>
									</div>
								</div>
								<?php } ?>
								<?php if($row[bk_status] >= "0") { ?>
								</form>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>

						<?php if (!$i) echo "<tr><td colspan='15' class=\"empty_table\">예약내용이 없습니다.</td></tr>"; ?>
					</tbody>
				</table>
			</div>

			<?php echo $pagelist;  ?>
		</div>
		<!-- Left Sidebar -->
		<!-- Right Sidebar -->
		<div class="col-md-3 magazine-page">
			<?php include_once(G5_BBS_PATH."/sidebar_page.php"); ?>
		</div>
		<!-- End Right Sidebar -->
	</div>          
</div>

<!-- } 회원정보 입력/수정 끝 -->

<!--//=========== 페이지하단 공통파일 Include =============-->
<?php include_once(G5_PATH.'/footer.php');?>
<?php include_once(G5_PATH.'/jquery_load.php'); // jquery 관련 코드가 반드시 페이지 상단에 노출되어야 하는 경우는 페이지 상단에 위치시킴.?>
<?php include_once(G5_PATH.'/tail.php');?>
<!--페이지 스크립트 영역-->
<script>
// 리스트 클릭시 상세리스트 보기
$(document).off("click",".tr-hover").on("click",".tr-hover",function(e){
	var trcont = $(this).next("tr");
	if(trcont.hasClass("on")) { $(".tr-cont").removeClass("on").hide(); trcont.removeClass("on").hide(); }
	else {$(".tr-cont").removeClass("on").hide();	trcont.addClass("on").show()}
});
$(document).off("click",".btn-book-cancel").on("click",".btn-book-cancel",function(e){
	var bkidx = $(this).data("bkidx");
	if(!confirm("예약을 취소(신청) 하시겠습니까?")) { return false; }
	else
	{
		$.ajax({ 
			type: "POST",
			url: "./ajax_mybooking_cancel.php",
			data: "bk_idx="+bkidx, 
			beforeSend: function(){
				loadstart();
			},
			success: function(msg){ 
				var msgarray = $.parseJSON(msg);
				if(msgarray.rslt == "error")
				{
					alert(msgarray.errcode); 
					if(msgarray.errurl) 
					{
						if(msgarray.errurl == "reload") document.location.reload();
						else document.location.replace(msgarray.errurl);
					}
					else {	loadend(); return false;}
				}
				else
				{
					alert("처리되었습니다.");
					document.location.reload();
				}
			},
			complete: function(){
				loadend();
			}
		});
	}
});

</script>
<script>
// 리스트 적용
function fbookmodify_submit(f,bkidx)
{
    if(!(confirm("예약내용을 수정하시겠습니까?"))) {
        return false;
    } else {
	    ajax_fbookmodify_submit(bkidx);
        return false;
    }
}

// 리스트 적용 AJAX 처리
function ajax_fbookmodify_submit(bkidx)
{
	var formData = $("#fbookmodify_"+bkidx).serialize();

	$.ajax({ 
		type: "POST",
		url: "./ajax_mybooking_modify.php",
		data: formData, 
		beforeSend: function(){
			loadstart();
		},
		success: function(msg){ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl) 
				{
					if(msgarray.errurl == "reload") document.location.reload();
					else document.location.replace(msgarray.errurl);
				}
				else {	loadend(); return false;}
			}
			else
			{
				alert("처리되었습니다.");
				document.location.reload();
			}
		},
		complete: function(){
			loadend();
		}
	});
}
</script>

<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->