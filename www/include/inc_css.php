<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($pgubun == "nakhome")
{
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/pages/blog.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/pages/blog_magazine.css">'.PHP_EOL;
}
if($pgubun == "index")
{
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/plugins/revolution-slider/rs-plugin/css/settings.css">'.PHP_EOL;
	if($_tpn == "1" || $_tpn == "2")
	{
		echo '<link rel="stylesheet" href="'.G5_URL.'/assets/plugins/slick/slick.css">'.PHP_EOL;
	}
}
if($pgubun == "introduce")
{
	;
}
if($pgubun == "blog")
{
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/pages/blog.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/pages/blog_magazine.css">'.PHP_EOL;
}
if($pgubun == "booking")
{
	;
}
if($pgubun == "pagegallery")
{
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/plugins/cube-gallery/css/cubeportfolio.min.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/plugins/cube-gallery/css/custom-cubeportfolio.css">'.PHP_EOL;
}
if($pgubun == "masonry")
{
	echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/pages/blog_masonry_3col.css">'.PHP_EOL;
}
if($pgubun == "gallery2")
{
	;
}

if($bo_table)
{
	$pgubun = $bo_table;

	if($bo_mode == "list")
	{
		if($pgubun == "gallery")
		{
			echo '<link rel="stylesheet" href="'.G5_URL.'/assets/plugins/cube-gallery/css/cubeportfolio.min.css">'.PHP_EOL;
			echo '<link rel="stylesheet" href="'.G5_URL.'/assets/plugins/cube-gallery/css/custom-cubeportfolio.css">'.PHP_EOL;
		}
		echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/app.css">'.PHP_EOL;
		echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/blocks.css">'.PHP_EOL;
	}
	else if($bo_mode == "view")
	{
		echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/app.css">'.PHP_EOL;
		echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/blocks.css">'.PHP_EOL;
	}
	if($bo_mode == "write")
	{
		;
	}
}
//공통CSS 
echo '<link rel="stylesheet" href="'.G5_URL.'/assets/css/lsh-custom.css">'.PHP_EOL;

?>