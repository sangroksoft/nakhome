<?php
$sub_menu = "200100";
$sub_menu_arr = "";

include_once('./_common.php');

$w="u";

$mb_id = trim($_REQUEST['mb_id']);
if(!$mb_id) alert('회원아이디가 넘어오지 않았습니다.');

$mbinfo = sql_fetch(" select * from g5_member where mb_id = '{$mb_id}' ");
if (!$mbinfo['mb_id']) alert("존재하지 않는 회원입니다.");

$mb_no = $mbinfo[mb_no];
$mb_nick = get_text($mbinfo[mb_nick]);
$mb_last_date = $mbinfo[mb_today_login];

$mbstatus_normal_chked = $mbstatus_block_chked = $block_date = "";
if($mbinfo[mb_intercept_date] != "")
{
	$mbstatus_block_chked = " selected = 'selected' ";
	$block_date = $mbinfo[mb_intercept_date]. " 접근 차단됨.";
}
else
{
	$mbstatus_normal_chked = " selected = 'selected' ";
}

// 예약현황 추출
// 총예약접수
$bksql = sql_fetch(" select count(*) as bktotal from m_bookdata where bk_mb_id = '{$mb_id}' ");
$bktotal = $bksql[bktotal];
// 접수현황
$bksql2 = sql_fetch(" select count(*) as bkwait from m_bookdata where bk_mb_id = '{$mb_id}' and bk_status = '0' ");
$bkwait = $bksql2[bkwait];
// 예약완료현황
$bksql3 = sql_fetch(" select count(*) as bkend from m_bookdata where bk_mb_id = '{$mb_id}' and bk_status = '1' ");
$bkend = $bksql3[bkend];
// 취소현황
$bksql4 = sql_fetch(" select count(*) as bkcancel from m_bookdata where bk_mb_id = '{$mb_id}' and bk_status = '-1' ");
$bkcancel = $bksql4[bkcancel];

$mailling_checked = "";
if($mbinfo[mb_mailling] == "1") $mailling_checked = " checked='checked' ";

$title_link = "회원관리 - ";
$g5['title'] = $title_link.$mb_id." (".$mb_nick.")";
include_once('./admin.head.php');
?>

<style>
.tbl_frm01 th {width:14%;}
.tbl_frm01 td {width:36%;}
.pcntinput{text-align:center;width:50px;height:24px;border:1px solid #ccc;color:red;}
.selectbox100{width:100px;height:24px;}
.tbl_head01 thead th, .tbl_head01 tbody td {text-align:center;}
a.btn-detail{border:1px solid #ccc;padding:4px 6px;background:#efefef;}
</style>
<!--
<div class="list-top-wrap">
	<div class="cate-wrap">
		<a href="./member_form.php?mb_id=<?php echo $mb_id;?>" class="selected">회원 정보</a>
		<a href="./mem_plist.php?mb_no=<?php echo $mb_no;?><?php echo $qstr;?>"  class="">회원 포스팅현황</a>
		<a href="./mem_reward_list.php?mb_no=<?php echo $mb_no;?>"  class="">회원 리워드현황</a>
	</div>
</div>
<div style="clear:both;margin-bottom:10px;"></div>
-->
<form name="fmbwrite" id="fmbwrite" onsubmit="return fmbwrite_submit(this);" method="post" action="./member_form_update.php" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" id="w" name="w" value="<?php echo $w ?>">
<input type="hidden" id="mb_id" name="mb_id" value="<?php echo $mb_id;?>">
<?php if($mb_id == "admin") { ?>
<input type="hidden" id="mb_status" name="mb_status" value="0">
<?php } ?>

<div class="tbl_frm01 tbl_wrap company-wrap">
	<table id="company_table" class="mobile_table">
		<colgroup>
			<col>
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th scope="row">회원ID</th>
				<td><?php echo $mb_id;?></td>
				<th scope="row">비밀번호</th>
				<td>
					<?php if($mbinfo[mb_leave_date] != "") { ?>
					<span style="display:inline-block;color:red;">※ 탈퇴한 회원입니다.</span>
					<?php } else { ?>
					<input type="password" id="mb_password" name="mb_password" class="frm_input" value="" maxlength="20" style="width:25%;">
					<span style="display:inline-block;color:red;">※ 기존 비밀번호를 변경하실 때에만 입력하십시오.</span>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row">회원닉네임</th>
				<td>
					<?php if($mbinfo[mb_leave_date] != "") { ?>
					<span style="display:inline-block;color:red;"><?php echo $mb_nick; ?> ※ 탈퇴한 회원입니다.</span>
					<?php } else { ?>
					<input type="text" id="mb_nick" name="mb_nick" class="frm_input" value="<?php echo $mb_nick; ?>" placeholder="닉네임">
					<button type="button" id="chknick" style="border:1px solid #ccc;padding:3px 8px;">중복체크</button>
					<span id="chk_result"></>
					<?php } ?>
				</td>
				<th scope="row">가입경로</th>
				<td><?php echo $mb_joinroot;?></td>
			</tr>
			<tr>
				<th scope="row">가입일</th>
				<td>
					<?php echo $mbinfo[mb_datetime]; ?>
				</td>
				<th scope="row">최종접속일</th>
				<td><?php echo $mb_last_date ;?></td>
			</tr>
			<tr>
				<th scope="row">예약현황</th>
				<td>
					총예약신청 : <?php echo number_format($bktotal);?>건, 
					예약대기 : <?php echo number_format($bkwait);?>건, 
					예약완료 : <?php echo number_format($bkend);?>건, 
					예약취소 : <?php echo number_format($bkcancel);?>건
				</td>
				<th scope="row">메일수신여부</th>
				<td>
					<?php if($mbinfo[mb_leave_date] != "") { ?>
					<span style="display:inline-block;color:red;">※ 탈퇴한 회원입니다.</span>
					<?php } else { ?>
					<input type="checkbox" name="mb_mailling" value="1" <?php echo $mailling_checked;?>> ※ 메일링 수신여부 체크
					<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row">회원레벨</th>
				<td>
					<?php if($mbinfo[mb_leave_date] != "") { ?>
					<span style="display:inline-block;color:red;">※ 탈퇴한 회원입니다.</span>
					<?php } else { ?>
					<?php echo get_member_level_select('mb_level', 1, $member['mb_level'], $mbinfo['mb_level']) ?>
					<?php } ?>
				</td>
				<th scope="row">회원상태변경</th>
				<td>
				<?php if($w=="") { ?>
					※ 회원 가입 후 상태변경이 가능합니다.
				<?php } else if($w=="u") { ?>
					<?php if($mb_id == "admin") { ?>
						정상
					<?php } else { ?>
						<?php if($mbinfo[mb_leave_date] != "") { ?>
						회원탈퇴 (탈퇴일 : <?php echo $mbinfo[mb_leave_date];?>)
						<?php } else { ?>
						<select name="mb_status" class="selectbox100"> 
							<option value="0" <?php echo $mbstatus_normal_chked;?>>정상</option>
							<option value="-1" <?php echo $mbstatus_block_chked;?>>차단</option>
							<option value="-2">탈퇴</option>
						</select> <?php echo $block_date;?>
						<?php } ?>
					<?php } ?>

				<?php } ?>
				</td>
			</tr>
			<tr>
				<th scope="row">회원메모</th>
				<td colspan="3">
					<textarea id="mb_profile" name="mb_profile" class="frm_input w99pct" maxlength="65536"><?php echo get_text($mbinfo[mb_profile],0);?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm" style="margin-top:20px;">
	<?php if($mbinfo[mb_leave_date] == "") { ?>
	<input type="submit" class="btn_submit" id="btn_submit" style="background: #5f5f5f;" value="저장">
	<?php } ?>
	<a href="./member_list.php?<?php echo $qstr;?>" class="btn_back" style="background: #5f5f5f;" >목록</button>
</div>
</form>

<script>
// 신청폼 전송
function fmbwrite_submit(f)
{
	return true;
}


$(document).off("click", "#chknick").on("click", "#chknick", function(e) {
	
	//e.preventDefault();

	var mbid = $("#mb_id").val();
	var mbnick = $("#mb_nick").val();

	//모달창 내용 ajax 호출.
	$.ajax({ 
		type: "GET",
		url: "./ajax_chknick.php",
		data: "mbnick="+mbnick+"&mbid="+mbid,  
		beforeSend: function(){
			loadstart();
		},
		success: function(msg)
		{ 
			var msgarray = $.parseJSON(msg);
			if(msgarray.rslt == "error")
			{
				alert(msgarray.errcode); 
				if(msgarray.errurl)  
				{
					if(msgarray.errurl == "back") history.go(-1);
					else return false;
				}
			}
			else
			{
				$("#chk_result").html(msgarray.chkresult);
			}
		},
		complete: function(){
			loadend();
		}

	}); 
})

</script>

<?php
include_once ('./admin.tail.php');
?>
