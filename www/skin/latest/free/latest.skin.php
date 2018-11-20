<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<ul class="list-unstyled blog-trending margin-bottom-20">
	<?php for ($i=0; $i<count($list); $i++) {  ?>
	<li>
		<h3><a href="<?php echo $list[$i]['href'];?>"><?php echo $list[$i]['subject'];?></a></h3>
		<small style="text-align:right;">작성일 : <?php echo $list[$i]['datetime'];?> / 조회 : <?php echo $list[$i]['wr_hit'];?></small>
	</li>
	<?php }  ?>
	<?php if (count($list) == 0) { //게시물이 없을 때  ?>
	<li>게시물이 없습니다.</li>
	<?php }  ?>
</ul>
