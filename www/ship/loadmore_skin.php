<?php
include_once('./_common.php');
?>
<div class="cbp-loadMore-block<?php echo $blocknum1; ?>">
	<? for ($i=0; $row1=sql_fetch_array($result1); $i++) { ?>
	<?php 
	// 이미지 추출
	$imgsrc1 = "";
	if($row1[wr_device] == "p")
	{
		if($row1[wr_thumb]) $imgsrc1 = $row1[wr_thumb];
	}
	else if($row1[wr_device] == "m")
	{
		$imgsql1 = sql_fetch(" select bf_file from g5_board_file where bo_table='gallery' and wr_id='{$row1['wr_id']}' order by bf_no asc limit 1 ");
		if($imgsql1[bf_file]) $imgsrc1 = G5_DATA_URL."/file/gallery/thumb/".$imgsql1[bf_file];
	}

	$subj1 = utf8_strcut(get_text($row1['wr_subject']),30,"...");// 제목
	$cont1 = utf8_strcut(strip_tags($row1['wr_content']), 150, "...");// 내용
	?>
	<div class="cbp-item <?php echo $row1[ca_name]; ?>">
		<div class="cbp-caption">
			<div class="cbp-caption-defaultWrap">
				<img src="<?php echo $imgsrc1; ?>" alt="">
			</div>
			<div class="cbp-caption-activeWrap">
				<div class="cbp-l-caption-alignCenter">
					<div class="cbp-l-caption-body">
						<ul class="link-captions">
							<li>
								<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=gallery&wr_id=<?php echo $row1[wr_id];?>"><i class="rounded-x fa fa-search"></i></a>
							</li>
						</ul>
						<div class="cbp-l-grid-agency-title"><?php echo $subj1;?></div>
						<div class="cbp-l-grid-agency-desc"><?php echo $row1[ca_name];?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<?php if($block2_cnt > 0) { ?>
<div class="cbp-loadMore-block<?php echo $blocknum2; ?>">
	<? for ($j=0; $row2=sql_fetch_array($result2); $j++) { ?>
	<?php 
	// 이미지 추출
	$imgsrc2 = "";
	if($row2[wr_device] == "p")
	{
		if($row2[wr_thumb]) $imgsrc2 = $row2[wr_thumb];
	}
	else if($row2[wr_device] == "m")
	{
		$imgsql2 = sql_fetch(" select bf_file from g5_board_file where bo_table='gallery' and wr_id='{$row2['wr_id']}' order by bf_no asc limit 1 ");
		if($imgsql2[bf_file]) $imgsrc2 = G5_DATA_URL."/file/gallery/thumb/".$imgsql2[bf_file];
	}

	$subj2 = utf8_strcut(get_text($row2['wr_subject']),30,"...");// 제목
	$cont2 = utf8_strcut(strip_tags($row2['wr_content']), 150, "...");// 내용
	?>
	<div class="cbp-item <?php echo $row2[ca_name]; ?>">
		<div class="cbp-caption">
			<div class="cbp-caption-defaultWrap">
				<img src="<?php echo $imgsrc2; ?>" alt="">
			</div>
			<div class="cbp-caption-activeWrap">
				<div class="cbp-l-caption-alignCenter">
					<div class="cbp-l-caption-body">
						<ul class="link-captions">
							<li>
								<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=gallery&wr_id=<?php echo $row2[wr_id];?>"><i class="rounded-x fa fa-search"></i></a>
							</li>
						</ul>
						<div class="cbp-l-grid-agency-title"><?php echo $row2[wr_subject];?></div>
						<div class="cbp-l-grid-agency-desc"><?php echo $row2[ca_name];?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
