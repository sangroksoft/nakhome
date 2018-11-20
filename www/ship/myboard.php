<?php
include_once('./_common.php');
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$pgubun="member";

if (!$is_member) alert('로그인 후 이용하여 주십시오.', G5_URL);

$sql_common = " from m_board ";
$sql_search = " where mb_id = '{$member[mb_id]}'  ";

$sop = strtolower($sop);
if ($sop != 'and' && $sop != 'or') $sop = 'and';

$stx = trim($stx);

// 분류 선택 또는 검색어가 있다면
if ($stx) $sql_search .= get_sql_search_lsh($sfl, $stx, $sop, $join_field="");
if ($sca) $sql_search .= " and cate='{$sca}' ";
if (!$sst) { $sst = "wr_datetime"; $sod = "desc"; } 
$sql_order = " order by $sst $sod ";

//=========== 페이징을 위한 Query 시작=================
$sqlcnt = " select idx $sql_common $sql_search $sql_order ";
$resultcnt = sql_query($sqlcnt);
$total_count = sql_num_rows($resultcnt); 

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


$g5['title'] = '게시글현황';
include_once(G5_PATH.'/head.php');
?>
<!--페이지 CSS Include 영역-->
<link rel="stylesheet" href="<?php echo $member_skin_url;?>/style.css">
<style>
input.frm_input{width: 100%;height: 34px;border: 1px solid #ccc;padding: 10px;outline:none !important;}

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

.tr-cont{display:none;}
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
						<li class="col-xxs-4 col-xs-4 lsh-subnav-li"><a href="<?php echo G5_SHIP_URL;?>/mybooking.php" class="sub2nav">예약현황</a></li>
						<li class="col-xxs-4 col-xs-4 lsh-subnav-li"><a href="<?php echo G5_SHIP_URL;?>/myboard.php" class="sub2nav on">게시글현황</a></li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default margin-bottom-20">
				<table class="table table-striped invoice-table">
					<thead>
						<tr>
							<th class="lsh-td-num hidden-xxs hidden-xs ta-center">번호</th>
							<th class="lsh-td-subj hidden-xxs hidden-xs ta-center">구분</th>
							<th class="lsh-td-name ta-center">게시판</th>
							<th class="lsh-td-subj ta-center">제목</th>
							<th class="lsh-td-name hidden-xxs hidden-xs ta-center">작성일</th>
						</tr>
					</thead>
					<tbody>
						<?php for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
						<?php
							$list = $i%2;
							$nListorder--; //게시물 일련번호
							$bg = 'bg'.($i%2);

							// 구분
							switch($row[wr_gubun])
							{
								case("w") : $wr_gubun = "<span style='color:red;'>원글</span>"; break;
								case("r") : $wr_gubun = "<span style='color:#333;'>답글</span>"; break;
								case("c") : $wr_gubun = "<span style='color:blue;'>댓글</span>"; break;
								default :  $wr_gubun = "<span style='color:#333;'>작성구분</span>"; break;
							}	
							// 게시판
							$bo_table = get_text($row[bo_table]);
							$bo_subject = get_text($row[bo_subject]);
							$wr_id = get_text($row[wr_id]);
							// 글제목
							$wr_subject = get_text($row[wr_subject]);
							// 댓글내용
							$wr_comment = "";
							if($row[wr_gubun] == "c") $wr_comment = get_text($row[wr_comment]);
							// 작성일
							$wr_datetime = substr($row[wr_datetime],0,10);
						?>	
						<tr class="tr-hover">
							<td class="td50 hidden-xxs hidden-xs ta-center"><?php echo $nListorder; ?></td>
							<td class="td80 hidden-xxs hidden-xs ta-center">
								<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_table;?>&wr_id=<?php echo $wr_id;?>" target="blank"><?php echo $wr_gubun;?></a>
							</td>
							<td class="td80 tdmin80 ta-center">
								<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_table;?>">[<?php echo $bo_subject; ?>]</a>
							</td>
							<td class="ta-left">
								<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_table;?>&wr_id=<?php echo $wr_id;?>" target="blank"><?php echo $wr_subject; ?></a>
								<?php if($wr_comment) { ?>
								<p style="margin:5px 0 0 0;">
									<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $bo_table;?>&wr_id=<?php echo $wr_id;?>" target="blank"><?php echo $wr_comment; ?></a>
								</p>
								<?php } ?>
							</td>
							<td class="td120 hidden-xxs hidden-xs ta-center"><?php echo $wr_datetime; ?></td>
						</tr>
						<?php } ?>

						<?php if (!$i) echo "<tr><td colspan='15' class=\"empty_table\">게시글 현황이 없습니다.</td></tr>"; ?>
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
<!--페이지 스크립트 영역-->
<?php include_once(G5_PATH.'/tail.sub.php'); ?>
<!--//=========== 페이지하단 공통파일 Include =============-->