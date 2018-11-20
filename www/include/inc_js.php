<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($pgubun == "nakhome")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}

if($pgubun == "member")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}

if($pgubun == "index")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>'.PHP_EOL;
	
	if($_tpn == "1" || $_tpn == "2")
	{
		echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/slick/slick.min.js"></script>'.PHP_EOL;
	}
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/plugins/revolution-slider.js"></script>'.PHP_EOL;
	if($_tpn == "1" || $_tpn == "2")
	{
		echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/plugins/slick/slick-v2.js"></script>'.PHP_EOL;
	}
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo 'App.initScrollBar();'.PHP_EOL;
	if($_tpn == "1" || $_tpn == "3")	echo 'RevolutionSlider.initRSfullWidth();'.PHP_EOL;
	else if($_tpn == "2") echo 'RevolutionSlider.initRSfullScreen();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "introduce")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "booking")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo 'App.initScrollBar();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "bk_process")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo 'App.initScrollBar();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "pagegallery")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/cube-gallery/js/jquery.cubeportfolio.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/cube-gallery/js/cube-portfolio-lsh1.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "masonry")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/masonry/jquery.masonry.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/pages/blog-masonry.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "guide")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "map")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}

if($pgubun == "gallery2")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "bookresult")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo 'App.initScrollBar();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}
if($pgubun == "regiresult")
{
	echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
	echo '<script type="text/javascript">'.PHP_EOL;
	echo 'jQuery(document).ready(function() {'.PHP_EOL;
	echo 'App.init();'.PHP_EOL;
	echo '});'.PHP_EOL;
	echo '</script>'.PHP_EOL;
}

if($bo_table)
{
	$pgubun = $bo_table;

	if($bo_mode == "list")
	{
		echo '<script src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
		if($pgubun == "gallery")
		{
			echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/cube-gallery/js/jquery.cubeportfolio.min.js"></script>'.PHP_EOL;
			echo '<script type="text/javascript" src="'.G5_URL.'/assets/plugins/cube-gallery/js/cube-portfolio-lsh2.js"></script>'.PHP_EOL;
		}
		echo '<script>'.PHP_EOL;
		echo 'jQuery(document).ready(function() {'.PHP_EOL;
		echo 'App.init();'.PHP_EOL;
		echo '});'.PHP_EOL;
		echo '</script>'.PHP_EOL;
	}
	else if($bo_mode == "view")
	{
		echo '<script src="'.$board_skin_url.'/js/lsh_board_view.js"></script>'.PHP_EOL;
		echo '<script src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
		echo '<script>'.PHP_EOL;
		echo 'jQuery(document).ready(function() {'.PHP_EOL;
		echo 'App.init();'.PHP_EOL;
		echo '});'.PHP_EOL;
		echo '</script>'.PHP_EOL;
	}
	if($bo_mode == "write")
	{
		echo '<script src="'.G5_URL.'/assets/js/app.js"></script>'.PHP_EOL;
		echo '<script>'.PHP_EOL;
		echo 'jQuery(document).ready(function() {'.PHP_EOL;
		echo 'App.init();'.PHP_EOL;
		echo '});'.PHP_EOL;
		echo '</script>'.PHP_EOL;
		if($board['bo_use_dhtml_editor'] && ($member['mb_level'] >= $board['bo_html_level']))
		{
			echo '<script src="'.$board_skin_url.'/js/lsh_board_write_editor.js"></script>'.PHP_EOL;
		}
		echo '<script src="'.$board_skin_url.'/js/lsh_board_write.js"></script>'.PHP_EOL;
	}
}

// 공통 JS
echo '<script type="text/javascript" src="'.G5_URL.'/assets/js/lsh-custom.js"></script>'.PHP_EOL;
?>