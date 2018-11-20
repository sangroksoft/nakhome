<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!--=== Footer v1 ===-->
<div id="footer-v1" class="footer-v1">
	<div class="footer">
		<div class="container">
			<div class="row">
				<!-- About -->
				<div class="col-md-3 md-margin-bottom-40" style="padding-top:6px;">
					<a href="<?php echo G5_URL;?>"><img class="logo-footer" class="footer-logo" src="<?php echo G5_URL;?>/assets/img/logo/logo_light.png" alt="Logo"></a>
					<p style="padding-top:5px;"><?php echo get_text($comfig['com_cont'],1);?></p>
				</div>
				<!-- End About -->

				<!-- Latest -->
				<div class="col-md-3 md-margin-bottom-40">
					<div class="">
						<div class="headline"><h2>최근 게시글</h2></div>
						<ul class="list-unstyled latest-list">
							<?php 
							$ftsql = " select * from m_board where wr_gubun='w' order by wr_datetime desc limit 3 ";
							$ftresult = sql_query($ftsql);
							 for($i=0;$ftrow=sql_fetch_array($ftresult);$i++) { 
								$ftsubj = conv_subject($ftrow['wr_subject'], 25, '…');
								$ftregdate = substr($ftrow['wr_datetime'],0,10);

								$fthref = G5_BBS_URL."/board.php?bo_table=".$ftrow[bo_table]."&wr_id=".$ftrow[wr_id];
							?>
							<li>
								<a href="<?php echo $fthref;?>"><?php echo $ftsubj;?></a>
								<small><?php echo $ftregdate;?></small>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<!-- End Latest -->

				<!-- Link List -->
				<div class="col-md-3 md-margin-bottom-40">
					<div class="headline"><h2>메뉴링크</h2></div>
					<ul class="list-unstyled link-list">
						<li><a href="<?php echo G5_SHIP_URL;?>/introduce.php">선박소개</a><i class="fa fa-angle-right"></i></li>
						<li><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=gallery">조황정보</a><i class="fa fa-angle-right"></i></li>
						<li><a href="<?php echo G5_SHIP_URL;?>/guide.php">출조안내</a><i class="fa fa-angle-right"></i></li>
						<li><a href="<?php echo G5_SHIP_URL;?>/booking.php">예약하기</a><i class="fa fa-angle-right"></i></li>
						<li><a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=notice">커뮤니티</a><i class="fa fa-angle-right"></i></li>
					</ul>
				</div>
				<!-- End Link List -->

				<!-- Address -->
				<div class="col-md-3 map-img md-margin-bottom-40">
					<div class="headline"><h2>Contact Us</h2></div>
					<address class="md-margin-bottom-40">
						상호 : <?php echo get_text($comfig['com_name']);?> <br />
						대표자 : <?php echo get_text($comfig['com_account_owner']);?> <br />
						주소 : <?php echo get_text($comfig['com_addr']);?> <br />
						Tel: <?php echo get_text($comfig['com_tel']);?> <br />
						Fax: <?php echo get_text($comfig['com_fax']);?> <br />
						사업자번호 : <?php echo get_text($comfig['com_saupja']);?> <br />
						Email: <a href="mailto:<?php echo get_text($comfig['com_email']);?>" style="color:#aaa;"><?php echo get_text($comfig['com_email']);?></a>
					</address>
				</div>
				<!-- End Address -->
			</div>
		</div>
	</div><!--/footer-->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<p>
						2018 &copy; All Rights Reserved.
					</p>
				</div>

				<!-- Social Links
				<div class="col-md-6">
					<ul class="footer-socials list-inline">
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook">
								<i class="fa fa-facebook"></i>
							</a>
						</li>
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Skype">
								<i class="fa fa-skype"></i>
							</a>
						</li>
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</li>
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Linkedin">
								<i class="fa fa-linkedin"></i>
							</a>
						</li>
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Pinterest">
								<i class="fa fa-pinterest"></i>
							</a>
						</li>
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter">
								<i class="fa fa-twitter"></i>
							</a>
						</li>
						<li>
							<a href="#" class="tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Dribbble">
								<i class="fa fa-dribbble"></i>
							</a>
						</li>
					</ul>
				</div>
				End Social Links -->
			</div>
		</div>
	</div><!--/copyright-->
</div>
<!--=== End Footer v1 ===-->