<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/latest.lib.php');

$sql = " select bo_table, bo_subject from g5_board where (1) and bo_use_search = '1' order by bo_order asc ";
$result = sql_query($sql);
?>
<div class="row lsh-row-gap-10">
<?php for($i=0; $row=sql_fetch_array($result);$i++) {?>
	<?php if($bo_table == $row[bo_table]) continue; else { ?>  
	<?php
		$col_xs_num = ""; 
		switch($row[bo_table])
		{
			case("fishing") : $callcnt = 12; $subj_length = 80; $col_xs_num = "col-xs-12"; break;
			default : $callcnt = 5; $subj_length = 80; $col_xs_num = "col-xs-6";  break;
		}

	?>
	<div class="<?php echo $col_xs_num;?> col-sm-4 col-md-12 lsh-col-gap-5 toggle-bd">
		<div class="latest-post">
			<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $row[bo_table];?>"><h2><?php echo $row[bo_subject]; ?></h2></a></div>
			<!-- Latest Links -->
			<?php echo latest($row[bo_table], $row[bo_table], $callcnt, $subj_length); ?>
			<!-- End Latest Links -->
		</div>
	</div>
	<?php } ?>
<?php } ?>
</div>

