<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($comfig[com_uidx] == "") 
{
	if($is_admin == "super") goto_url(G5_ADMIN_URL);	
	else 
	{
		if($pgubun == "member") { ; }
		else
		{
			if(!$is_member) alert("선사환경설정이 완료되지 않았습니다.", G5_BBS_URL."/login.php");
			else alert("선사환경설정이 완료되지 않았습니다.");
		}
	}
}

$menu1 = $menu2 = $menu3 = $menu4 = $menu5 = $menu6 = "";
switch($pgubun)
{
	case("introduce") : $menu1 = "active"; break;
	case("pagegallery") : $menu2 = "active"; break;
	case("guide") : $menu3 = "active"; break;
	case("booking") : $menu4 = "active"; break;
	case("notice") : $menu5 = "active"; break;
	case("free") : $menu5 = "active"; break;
	case("qna") : $menu5 = "active"; break;
	case("fishing") : $menu5 = "active"; break;
	case("map") : $menu6 = "active"; break;
}
include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
?>
<style>
.header-v6 .navbar-nav > .active > a {color:#1ceae3}
.header-v6 .navbar-nav > .active > a:hover {color:#1ceae3}
</style>
<!-- Preload  로딩이 많고 부하가 걸리는 페이지의 경우 사용함. tail.php 에 js코드 연동-->
<div id="preloader">
	<div class="sk-spinner sk-spinner-wave">
		<div class="sk-rect1"></div>
		<div class="sk-rect2"></div>
		<div class="sk-rect3"></div>
		<div class="sk-rect4"></div>
		<div class="sk-rect5"></div>
	</div>
</div>
<style>
#lsh-topbar{position:absolute; top:0px;right:12px;width:100%;height:30px;z-index:9999;}
#lsh-topbar ul {list-style:none;margin:0;padding:0;padding-top:5px}
#lsh-topbar ul li{float:left;color:#fff;list-style:none;margin:0;padding:0 5px;}
#lsh-topbar ul li.topbar-devider{border-right:1px solid #fff;}
#lsh-topbar ul li a{color:#e0e0e0;font-size: 11px;}
@media (max-width: 991px) {
	#lsh-topbar{display:none;}
}
@media (min-width: 992px) {
	.header .navbar-collapse {bottom: 10px;}
	.header-fixed-shrink .navbar-collapse{bottom:0px;}
}

.header .navbar-nav > li > a {font-size: 16px;font-weight: bolder;}

</style>
<!-- End Preload -->
<div id="divwrap" class="wrapper">
		<!--=== Header v6 ===-->
		<div class="header-v6 header-white-transparent header-sticky">

			<!-- Navbar -->
			<div class="navbar mega-menu" role="navigation">
				<div class="container">
					<!-- Topbar -->
					<div id="lsh-topbar" class="topbar lsh-topbar" >
						<ul class="loginbar pull-right">
							<?php if ($is_guest) { ?>
							<li><a href="<?php echo G5_BBS_URL;?>/register.php">회원가입</a></li>  
							<li> | </li>   
							<?php } ?>
							<?php if($is_member) { ?>
							<li><a href="<?php echo G5_BBS_URL;?>/logout.php">로그아웃</a></li>   
							<li> | </li>   
							<li><a href="<?php echo G5_SHIP_URL;?>/mypage.php">마이페이지</a></li>   
							<?php } else { ?>
							<li><a href="<?php echo G5_BBS_URL;?>/login.php">로그인</a></li>   
							<?php } ?>
							<?php if ($is_admin == 'super') {  ?>
							<li><a href="<?php echo G5_ADMIN_URL ?>"><i class="fa fa-cog"></i></a></li>  
							<?php } ?>
						</ul>
					</div>
					<!-- End Topbar -->
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="menu-container">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<!-- Navbar Brand -->
						<div class="navbar-brand">
							<a href="<?php echo G5_URL;?>">
								<img class="default-logo" src="<?php echo G5_URL;?>/assets/img/logo/logo_light.png" alt="Logo">
								<img class="shrink-logo" src="<?php echo G5_URL;?>/assets/img/logo/logo_dark.png" alt="Logo">
							</a>
						</div>
						<!-- ENd Navbar Brand -->
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-responsive-collapse">
						<div class="menu-container">
							<ul class="nav navbar-nav">
								<!-- 선박소개 -->
								<li class="dropdown <?php echo $menu1;?>">
									<a href="<?php echo G5_SHIP_URL;?>/introduce.php">
										선박소개
									</a>
								</li>
								<!-- End 선박소개 -->

								<!-- 조황정보 -->
								<li class="dropdown <?php echo $menu2;?>">
									<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=gallery">
										조황정보
									</a>
								</li>
								<!-- End 조황정보 -->

								<!-- 출조안내 -->
								<li class="dropdown <?php echo $menu3;?>">
									<a href="<?php echo G5_SHIP_URL;?>/guide.php">
										출조안내
									</a>
								</li>
								<!-- End 출조안내 -->

								<!-- 예약하기 -->
								<li class="dropdown <?php echo $menu4;?>">
									<!--
									<a href="<?php echo G5_SHIP_URL;?>/booking.php">
										예약하기
									</a>
									-->
									<a href="javascript:;" onclick="gotoBooking();">
										예약하기
									</a>
								</li>
								<!-- End 예약하기 -->

								<!-- 커뮤니티 -->
								<li class="dropdown <?php echo $menu5;?>">
									<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=notice">
										커뮤니티
									</a>
								</li>
								<!-- End 커뮤니티 -->

								<!-- 오시는길 -->
								<li class="dropdown <?php echo $menu6;?>">
									<a href="<?php echo G5_SHIP_URL;?>/map.php" style="padding-right:0px;">
										오시는길
									</a>
								</li>
								<!-- End 오시는길 -->

								<?php if ($is_guest) { ?>
								<li class="dropdown hidden-md hidden-lg"><a href="<?php echo G5_BBS_URL;?>/register.php">회원가입</a></li>  
								<li class="dropdown hidden-md hidden-lg"><a href="<?php echo G5_BBS_URL;?>/login.php">로그인</a></li>   
								<?php } else if($is_member) { ?>
								<li class="dropdown hidden-md hidden-lg"><a href="<?php echo G5_BBS_URL;?>/logout.php">로그아웃</a></li>   
								<?php if ($is_admin == 'super') {  ?>
								<li class="dropdown hidden-sm hidden-lg"><a href="<?php echo G5_ADMIN_URL ?>"><i class="fa fa-cog"></i></a></li>  
								<?php } else { ?>
								<li class="dropdown hidden-md hidden-lg"><a href="<?php echo G5_SHIP_URL;?>/mypage.php">마이페이지</a></li>   
								<?php } ?>
								<?php } ?>
							</ul>
						</div>
					</div><!--/navbar-collapse-->
				</div>
			</div>
			<!-- End Navbar -->
		</div>
		<!--=== End Header v6 ===-->
