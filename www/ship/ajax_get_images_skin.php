<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$wr = sql_fetch(" select * from g5_write_gallery where wr_id = '{$wr_id}' ");

$imgsrc = "";
if($wr[wr_device] == "p")
{
	$matches = get_editor_image($wr['wr_content'], false);
	for($i=0; $i<count($matches[1]); $i++)
	{
		// 이미지 path 구함
		$p = parse_url($matches[1][$i]);
		if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
			$data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
		else
			$data_path = $p['path'];

		$srcfile = G5_PATH.$data_path;

		if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile) && is_file($srcfile)) {
			$size = @getimagesize($srcfile);
			if(empty($size)) continue;
			$imgsrc = $data_path;

			echo '<a href="'.$imgsrc.'" class="cbp-lightbox" data-title="'.$row[bf_content].'"></a>'.PHP_EOL;
		}
	}
}
else if($wr[wr_device] == "m")
{
	$sql = " select * from g5_board_file where bo_table = 'gallery' and wr_id = '{$wr_id}' order by bf_no asc ";
	$result = sql_query($sql);

	for ($i=0; $row=sql_fetch_array($result); $i++) { 
	
		echo '<a href="'.G5_DATA_URL.'/file/gallery/'.$row[bf_file].'" class="cbp-lightbox" data-title="'.$row[bf_content].'"></a>'.PHP_EOL;

	}
}

?>