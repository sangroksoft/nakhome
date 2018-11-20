<?php
$sub_menu = "200100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from g5_member  " ;
$sql_search = " where (1) and mb_level < '10' " ;

$sop = 'and';

if ($stx) 
{ 
	$stx = strip_tags($stx);
	$stx = get_search_string($stx); // 특수문자 제거
	if(!$stx) alert("검색어를 입력하세요.");

	if ($sfl) 
	{
		switch($sfl)
		{
			case("mb_nick") : $sql_search .= " and (INSTR(mb_nick, '$stx')) "; break;
			case("mb_id") : $sql_search .= " and (INSTR(mb_id, '$stx')) "; break;
			default : $sql_search .= " and (INSTR(mb_nick, '$stx')) "; break;
		}
	}
	else
	{
		//$sql_search .= " and f_subj like '%$stx%' ";
		if (preg_match("/[a-zA-Z]/", $stx))
			$sql_search .= "and (INSTR(LOWER(mb_nick), LOWER('$stx')))";
		else
			$sql_search .= "and (INSTR(mb_nick, '$stx'))";
	}
}

if (!$sst) { $sst = "mb_datetime"; $sod = "desc"; } 
$sql_order = " order by $sst $sod ";

//=========== 페이징을 위한 Query 시작=================
$sql = " select count(*) as cnt $sql_common $sql_search $sql_order ";
$row = sql_fetch($sql);
$total_count = $row[cnt]; 

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
$totcnt = sql_num_rows($result);
//=========== 리스트를 뽑아오는 Query 끝===============

//echo $sql;

$g5['title'] = '회원관리';
include_once('./admin.head.php');
?>
<style>
.tbl_head01 thead th, .tbl_head01 tbody td {text-align:center;}

.list-top-wrap{padding:0 20px;}
.list-top-wrap .search-wrap{float:right;width:50%;text-align:right;}
.list-top-wrap .cate-wrap{margin: 0 0 10px;float:left;width:50%;}
.list-top-wrap .cate-wrap a{padding: 4px 8px;border: 1px solid #ccc;width:60px;height: 30px;text-align:center;display: inline-block;line-height: 30px;background-color: #f7f7f7;}
.list-top-wrap .cate-wrap a.selected{background-color: #999;color:#fff;}

.list-top-wrap .search-wrap .local_sch01 {margin: 0;padding: 0;border-bottom:none;}
.casebtn{padding: 2px 4px;border: 1px solid #ccc;width:50px;height: 24px;text-align:center;display: inline-block;line-height: 24px;background-color: #f7f7f7;}

.td_name{text-align:center;}
</style>

<div class="list-top-wrap">
	<div class="search-wrap">
		<form id="fsearch" name="fsearch" method="get">
		<label for="sfl" class="sound_only">검색대상</label>
		<select name="sfl" id="sfl" class="select-100">
			<option value="mb_id"<?php echo get_selected($sfl, 'mb_id'); ?>>회원 ID</option>
			<option value="mb_nick"<?php echo get_selected($sfl, 'mb_nick'); ?>>닉네임</option>
		</select>
		<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required class="frm_input required search-input" size="20" maxlength="20" placeholder="검색어 입력">
		<div class="clear lg-hidden"></div>
		<input type="submit" value="검색" class="btn_submit" style="padding:4px 6px 5px 6px;">
		<?php if($sfl || $stx) { ?>
		<span style="padding:5px 6px;background-color:#128700;vertical-align:middle;"><a href="./member_list.php" style="color:#ffffff;">검색초기화</a></span>
		<?php } ?>

		</form>
	</div>
</div>
<div style="clear:both;margin-bottom:10px;"></div>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
		<thead>
			<tr>
				<th scope="col" rowspan="2">번호</th>
				<th scope="col" rowspan="2">회원상태</th>
				<th scope="col" rowspan="2">회원 ID</th>
				<th scope="col" rowspan="2">닉네임</th>
				<th scope="col" rowspan="2" class="xs-hidden">가입일</th>
				<th scope="col" rowspan="2" class="xs-hidden">최종접속일</th>
				<th scope="col" colspan="4" class="xs-hidden">예약현황</th>
			</tr>
			<tr class="xs-hidden">
				<th scope="col" class="xs-hidden">총예약신청</th>
				<th scope="col" class="xs-hidden">예약대기</th>
				<th scope="col" class="xs-hidden">예약완료</th>
				<th scope="col" class="xs-hidden">예약취소</th>
			</tr>

		</thead>
		<tbody>
			<?php for ($i=0; $row=sql_fetch_array($result); $i++) {
				$bg = 'bg'.($i%2);
				$nListorder--; //게시물 일련번호


				$mb_status = "<span style='color:blue;font-weight:bolder;'>정상</span>";
				if($row[mb_intercept_date]) $mb_status = "<span style='color:gray;font-weight:bolder;'>차단</span>";
				if($row[mb_leave_date]) $mb_status = "<span style='color:gray;font-weight:bolder;'>탈퇴</span>";

				$mb_id = $row[mb_id];
				$mb_nick = get_text($row[mb_nick]);
				$mb_datetime = substr($row[mb_datetime],0,10);
				$mb_today_login = substr($row[mb_today_login],0,10);

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

			?>
			<tr class="<?php echo $bg; ?>">
				<td class="td50 tdmin50"><?php echo $nListorder ?></td>
				<td class="td70 tdmin70"><a href="./member_form.php?<?php echo $qstr;?>&mb_id=<?php echo $mb_id;?>"><?php echo $mb_status; ?></a></td>
				<td class="td150 tdmin150"><a href="./member_form.php?<?php echo $qstr;?>&mb_id=<?php echo $mb_id;?>"><?php echo $mb_id; ?></a></td>
				<td class="tdmin120">
					<a href="./member_form.php?<?php echo $qstr;?>&mb_id=<?php echo $mb_id;?>"><span style='color:#777;font-weight:bolder;'><?php echo $mb_nick ?></span></a>
				</td>
				<td class="td120 tdmin120 xs-hidden"><a href="./member_form.php?<?php echo $qstr;?>&mb_id=<?php echo $mb_id;?>"><?php echo $mb_datetime ?></a></td>
				<td class="td120  tdmin120 xs-hidden"><a href="./member_form.php?<?php echo $qstr;?>&mb_id=<?php echo $mb_id;?>"><?php echo $mb_today_login?></a></td>
				<td class="td60 tdmin60 xs-hidden"><span style=''><?php echo number_format($bktotal); ?> 건</span></td>
				<td class="td60 tdmin60 xs-hidden"><span style='color:gray;'><?php echo number_format($bkwait); ?> 건</span></td>
				<td class="td60 tdmin60 xs-hidden"><span style='color:green;'><?php echo number_format($bkend); ?> 건</span></td>
				<td class="td60 tdmin60 xs-hidden"><span style='color:red;'><?php echo number_format($bkcancel); ?> 건</span></td>
			</tr>
			<?php } ?>
			<?php if (!$i)  echo "<tr><td colspan='15' class=\"empty_table\">자료가 없습니다.</td></tr>"; ?>
		</tbody>
	</table>
</div>
<?php echo $pagelist;?>

<?php
include_once ('./admin.tail.php');
?>
