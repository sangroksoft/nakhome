<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php for ($i=0; $i<count($list); $i++) {  ?>
<?php 
	// 이미지 추출
	$imgsrc = "";
	if($list[$i][wr_device] == "p")
	{
		if($list[$i][wr_thumb]) $imgsrc = $list[$i][wr_thumb2];
	}
	else if($list[$i][wr_device] == "m")
	{
		$imgsql = sql_fetch(" select bf_file from g5_board_file where bo_table='{$bo_table}' and wr_id='{$list[$i]['wr_id']}' order by bf_no asc limit 1 ");
		if($imgsql[bf_file]) $imgsrc = G5_DATA_URL."/file/".$bo_table."/thumb2/".$imgsql[bf_file];
	}

	$subj = utf8_strcut(get_text($list[$i]['wr_subject']),20,"...");// 제목
	$cont = utf8_strcut(strip_tags($list[$i]['wr_content']), 60, "...");// 내용
?>
<div class="col-md-3 col-sm-6 col-xs-6 col-xs-12 lsh-col-gap-5">
	<div class="thumbnails thumbnail-style thumbnail-kenburn">
		<div class="thumbnail-img">
			<div class="overflow-hidden">
				<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=gallery&wr_id=<?php echo $list[$i][wr_id];?>">
					<img class="img-responsive" src="<?php echo $imgsrc;?>" alt="" />
				</a>
			</div>
			<a class="btn-more hover-effect" href="<?php echo G5_BBS_URL;?>/board.php?bo_table=gallery&wr_id=<?php echo $list[$i][wr_id];?>">read more +</a>
		</div>
		<div class="caption">
			<h3><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=gallery&wr_id=<?php echo $list[$i][wr_id];?>" class="hover-effect ellipsis"><?php echo $subj;?></a></h3>
			<p class="thumb-p"><?php echo $cont;?></p>
		</div>
	</div>
</div>
<?php }  ?>
<?php if (count($list) == 0) { //게시물이 없을 때  ?>
<div class="col-xs-12" style="text-align:center;height:100px;border:none;outline:none;">게시물이 없습니다.</div>
<?php }  ?>
