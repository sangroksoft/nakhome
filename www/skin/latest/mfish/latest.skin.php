<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<div id="scrollbar" class="mCustomScrollbar" data-mcs-theme="minimal-dark">
	<?php for ($i=0; $i<count($list); $i++) {  ?>
	<?php 
		$left_class="col-xs-4 col-sm-4 lsh-col-gap-4";
		$right_class="col-xs-8 col-sm-8 lsh-col-gap-4";

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
		if(!$imgsrc)
		{
			$left_class="";
			$right_class="col-sm-12";
		}

		$subj = utf8_strcut(get_text($list[$i]['wr_subject']),50,"...");// 제목
		$cont = utf8_strcut(strip_tags($list[$i]['wr_content']), 50, "...");// 내용

	
	?>
	<div class="row lsh-row-gap-11">
		<a href="<?php echo $list[$i]['href'] ?>">			
		<?php if($imgsrc) { ?>
		<div class="<?php echo $left_class;?>" style="text-align:center;">
			<img class="img-responsive" style="display:inline-block;" src="<?php echo $imgsrc;?>" alt="">
		</div>
		<?php } ?>
		<div class="<?php echo $right_class;?> news-v3">
			<div class="news-v3-in-sm no-padding">
				<span class="latest-title ellipsis"><?php echo $subj ?></span>
				<p style="line-height:15px;margin-top:4px;"><?php echo $cont;?></p>
			</div>
		</div>
		</a>
	</div>
	<div class="clearfix"><hr style="margin:5px 0;"></div>
	<?php }  ?>
	<?php if (count($list) == 0) { //게시물이 없을 때  ?>
	<li>게시물이 없습니다.</li>
	<?php }  ?>
</div>
