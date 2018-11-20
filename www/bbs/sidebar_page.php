<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/latest.lib.php');

$sql = " select bo_table, bo_subject from g5_board where bo_table='notice' ";
$result = sql_query($sql);
?>
<?php for($i=0; $row=sql_fetch_array($result);$i++) {?>
	<?php
		switch($row[bo_table])
		{
			case("fishing") : $callcnt = 12; $subj_length = 80; break;
			default : $callcnt = 5; $subj_length = 80; break;
		}
	?>
	<div class="posts">
		<div class="headline headline-md"><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=<?php echo $row[bo_table];?>"><h2><?php echo $row[bo_subject]; ?></h2></a></div>
		<!-- Latest Links -->
		<?php echo latest($row[bo_table], $row[bo_table], $callcnt, $subj_length); ?>
		<!-- End Latest Links -->
	</div>
<?php } ?>
	<div class="bannerWrap g-mt-20 col-lg-12 col-md-12 col-sm-6">
		<h6>예약문의 및 입금계좌</h6>
		<ul style="padding-left: 15px;list-style-position: inside;">
			<li>문의 : <?php echo get_text($comfig['com_tel']);?></li>
			<li>휴대폰 : <?php echo get_text($comfig['com_hp']);?></li>
			<li><?php echo get_text($comfig['com_bank']);?> <?php echo get_text($comfig['com_account']);?></li>
			<li>예금주 : <?php echo get_text($comfig['com_account_owner']);?></li>
		</ul>
	</div>
	<a href="https://monak.kr" target="_blank">
	<div class="bannerWrap banimg g-mt-20 col-lg-12 col-md-12 col-sm-6">
			<img src="<?php echo G5_URL;?>/assets/img/banners/ban01.jpg" alt="모두의낚시" class="img-responsive">
	</div>
	</a>
