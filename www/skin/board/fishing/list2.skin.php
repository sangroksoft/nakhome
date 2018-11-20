<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style>
@media (max-width: 767px) {
	.lsh-td-subj a{font-size:11px;}
}
</style>

<div class="blog-page" style="padding-top:50px;">
	<!-- Left Sidebar -->
		<div class="panel panel-default margin-bottom-20">
			<table class="table table-striped invoice-table">
				<thead>
					<tr>
						<th class="lsh-td-num">번호</th>
						<th class="lsh-td-subj">제목</th>
						<th class="lsh-td-name hidden-xxs hidden-xs">작성자</th>
						<th class="lsh-td-date hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>작성일</a></th>
						<th class="lsh-td-hit hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></th>
						<?php if ($is_good) { ?>
						<th class="lsh-td-good hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천</a></th>
						<?php } ?>
						<?php if ($is_nogood) { ?>
						<th class="lsh-td-nogood hidden-xxs hidden-xs"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천</a></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
				<?php for ($i=0; $i<count($list); $i++) { ?>
						<tr>
							<td class="lsh-td-num" style="width:60px;">
								<?php
								if ($list[$i]['is_notice']) // 공지사항
									echo '<strong>공지</strong>';
								else if ($wr_id == $list[$i]['wr_id'])
									echo "<span class=\"bo_current\">열람중</span>";
								else
									echo $list[$i]['num'];
								 ?>
							</td>
							<td class="lsh-td-subj">
								<span class="ellipsis">
								<?php
								echo $list[$i]['icon_reply'];
								if ($is_category && $list[$i]['ca_name']) { ?>
								<a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link hidden-xxs hidden-xs"><?php echo $list[$i]['ca_name'] ?></a>
								<?php } ?>

								<a href="<?php echo $list[$i]['href'] ?>">
									<?php echo $list[$i]['subject'] ?>
									<?php if ($list[$i]['comment_cnt']) { ?><span style="color:red;">(<?php echo $list[$i]['comment_cnt']; ?>)</span><?php } ?>
								</a>
				
								<?php
								if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
								if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
								if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
								if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
								if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
								?>
								</span>
							</td>
							<td class="lsh-td-name hidden-xxs hidden-xs" style="width:100px;"><?php echo $list[$i]['name'];?></td>
							<td class="lsh-td-date hidden-xxs hidden-xs" style="width:120px;"><?php echo $list[$i]['datetime'];?></td>
							<td class="lsh-td-hit hidden-xxs hidden-xs" style="width:60px;"><?php echo $list[$i]['wr_hit'];?></td>
							<?php if ($is_good) { ?>
							<td class="lsh-td-good hidden-xxs hidden-xs"><?php echo $list[$i]['wr_good'] ?></td>
							<?php } ?>
							<?php if ($is_nogood) { ?>
							<td class="lsh-td-nogood hidden-xxs hidden-xs"><?php echo $list[$i]['wr_nogood'] ?></td>
							<?php } ?>
						</tr>
				<?php } ?>
				<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
				</tbody>
			</table>
		</div>

		<?php echo $write_pages;  ?>
	<!-- Left Sidebar -->
</div>

<!-- } 게시판 목록 끝 -->

