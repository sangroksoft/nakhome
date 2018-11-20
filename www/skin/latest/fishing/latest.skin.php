<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<ul class="list-inline blog-photostream">
	<?php for ($i=0; $i<count($list); $i++) {  ?>
	<?php 
		// 이미지 추출
		$imgsrc = "";
		if($list[$i][wr_device] == "p")
		{
			if($list[$i][wr_thumb]) $imgsrc = $list[$i][wr_thumb];
		}
		else if($list[$i][wr_device] == "m")
		{
			$imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table='{$bo_table}' and wr_id='{$list[$i]['wr_id']}' order by bf_no asc limit 1 ");
			if($imgsql[bf_file]) $imgsrc = G5_DATA_URL."/file/".$bo_table."/thumb/".$imgsql[bf_file];
		}
	?>
	<li class="col-xxs-4 col-xs-2 col-sm-4">
		<a href="<?php echo $list[$i]['href'];?>" rel="gallery" class="img-hover-v2" title="Images">
			<span><img class="img-responsive" alt="" src="<?php echo $imgsrc;?>">
		</a>
	</li>
	<?php }  ?>
	<?php if (count($list) == 0) { //게시물이 없을 때  ?>
	<li>게시물이 없습니다.</li>
	<?php }  ?>
</ul>
