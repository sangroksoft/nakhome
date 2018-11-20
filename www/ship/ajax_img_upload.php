<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/instagraph.php');

$returnVal = "";

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_pd = 20485760;

if (empty($_POST)) 
{
	$errorstr = $_errArray[40][2]; 
	//$errorstr = "파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if (!$is_member) 
{
	$errorstr = $_errArray[0][2]; 
	//$errorstr = "가입회원만 이용하실 수 있습니다.";
	$errorurl = G5_URL;
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
if ($_POST[selectednum] == "" || $_POST[selectednum] < 0 ) 
{
	$errorstr = $_errArray[62][2]; 
	//$errorstr = "이미지저장 처리중 오류가 발생하였습니다.";
	$errorurl = "";
	$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
}
$selectednum = $_POST[selectednum];

@mkdir(G5_DATA_PATH.'/file/tmpimg', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/tmpimg', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/tmpimg/thumb', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/tmpimg/thumb', G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
$upload['file']     = '';
$upload['source']   = '';
$upload['filesize'] = 0;
$upload['image']    = array();
$upload['image'][0] = '';
$upload['image'][1] = '';
$upload['image'][2] = '';

$upload['del_check'] = false;

$tmp_file  = $_FILES['bf_file_'.$selectednum]['tmp_name'];
$filesize  = $_FILES['bf_file_'.$selectednum]['size'];
$filename  = $_FILES['bf_file_'.$selectednum]['name'];
$filename  = get_safe_filename($filename);

// 서버에 설정된 값보다 큰파일을 업로드 한다면
if ($filename) 
{
	if ($_FILES['bf_file_'.$selectednum]['error'] == 1) 
	{
		$errorstr = $_errArray[63][2]; 
		//$errorstr = "파일의 용량이 서버에 설정된 값보다 크므로 파일을 업로드 할 수 없습니다";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	else if ($_FILES['bf_file_'.$selectednum]['error'] != 0) 
	{
		$errorstr = $_errArray[64][2]; 
		//$errorstr = "파일이 정상적으로 업로드 되지 않았습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
}

if (is_uploaded_file($tmp_file)) 
{
	// 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
	if (!$is_admin && $filesize > $upload_max_pd) 
	{
		$errorstr = $_errArray[65][2]; 
		//$errorstr = "파일의 용량이 허용된 값보다 크므로 업로드 하지 않습니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}
	$timg = @getimagesize($tmp_file);

    $is_img = ""; // 업로드된 파일이 이미지인지 검사 - 썸네일생성시 체크
	if ( preg_match("/\.({$config['cf_image_extension']})$/i", strtolower($filename)) || preg_match("/\.({$config['cf_flash_extension']})$/i", strtolower($filename)) )
	{ 
		if ($timg[2] < 1 || $timg[2] > 16) 
		{
			$errorstr = $_errArray[66][2]; 
			//$errorstr = "이미지 파일이 아닙니다.";
			$errorurl = "";
			$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
		}
	}
	else
	{
		$errorstr = $_errArray[66][2]; 
		//$errorstr = "이미지 파일이 아닙니다.";
		$errorurl = "";
		$returnVal = returnErrorArr($errorstr,$errorurl); echo $returnVal; exit; 
	}

	$upload['image'] = $timg;

	// 프로그램 원래 파일명
	$upload['source'] = $filename;
	$upload['filesize'] = $filesize;

	// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
	$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

	shuffle($chars_array);
	$shuffle = implode('', $chars_array);

	// 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
	$upload['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));
	$upload['file'] = str_replace('.PNG', '.png', $upload['file']);
	$upload['file'] = str_replace('.JPG', '.jpg', $upload['file']);
	$upload['file'] = str_replace('.jpeg', '.jpg', $upload['file']);
	$upload['file'] = str_replace('.JPEG', '.jpg', $upload['file']);

	$dest_file = G5_DATA_PATH.'/file/tmpimg/'.$upload['file'];
	$dest_thumb_file = G5_DATA_PATH.'/file/tmpimg/thumb/'.$upload['file'];

	// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
	$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file_'.$selectednum]['error']);

	// png 파일의 경우 jpg로 변환(imagemagick 에서 png를 제대로 처리 못하는 문제)
	if ($upload['image']['2'] == "3")
	{
		$image = imagecreatefrompng($dest_file);
		$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
		imagedestroy($image);
		$quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
		imagejpeg($bg, $dest_file.".jpg", $quality);
		imagedestroy($bg);

		$upload['file'] = $upload['file'].".jpg";

		$dest_file = $dest_file.".jpg";
		$dest_thumb_file = $dest_thumb_file.".jpg";
	}

	$imgWidth = $upload['image']['0'];
	$imgHeight = $upload['image']['1'];
	
	//업로드된 파일이 큰 이미지라면 잘라냄
	if($imgWidth > 640)
	{
		try	{ $instagraph = Instagraph::factory($dest_file, $dest_file);} 
		catch (Exception $e) {echo $e->getMessage();	die;}
		$instagraph->rImage("640"); 

		$new_timg = @getimagesize($dest_file);
		$imgWidth = $new_timg[0];
		$imgHeight = $new_timg[1];
	}
	
	// 이미지 비율 계산(4:3 기준)
	$imgRatio = ($imgHeight/$imgWidth)*100;

	if($imgRatio > 75) $imgOrient = "v";
	else if($imgRatio < 75) $imgOrient = "h";
	else if($imgRatio == 75) $imgOrient = "s";

	/*
	//쎈터이미지 생성
	try	{ $instagraph = Instagraph::factory($dest_file, $dest_center_file);}
	catch (Exception $e) {echo $e->getMessage();	die;}
	$instagraph->rImageCenterCube($imgOrient); // 760x760 으로 crop
	*/

	//썸네일 생성
	try	{$instagraph = Instagraph::factory($dest_file, $dest_thumb_file);} 
	catch (Exception $e) {echo $e->getMessage();die;	}
	$instagraph->rThumbCenterCube($imgOrient); // 240x160으로 crop
	
	chmod($dest_file, G5_FILE_PERMISSION);
	chmod($dest_thumb_file, G5_FILE_PERMISSION);

	//$_exif = @exif_read_data($dest_file);
}

if (!get_magic_quotes_gpc()) {$upload['source'] = addslashes($upload['source']);}

$sql = " insert into tmpimg
			set mb_id = '{$member[mb_id]}',
				 bf_file = '{$upload['file']}',
				 bf_source = '{$upload['source']}',
				 bf_filesize = '{$upload['filesize']}',
				 bf_width = '{$imgWidth}',
				 bf_height = '{$imgHeight}',
				 bf_type = '{$upload['image']['2']}',
				 bf_datetime = '".G5_TIME_YMDHIS."' ";
sql_query($sql);
$tmpimg_idx = sql_insert_id();

$returnVal = json_encode(
	array(
		"rslt"=>"ok", 
		"r_imgSrc"=>$upload['file'],
		"r_imgWidth"=>$imgWidth,
		"r_imgHeight"=>$imgHeight,
		"r_tmpidx"=>$tmpimg_idx,
		"r_selectednum"=>$_POST[selectednum]
	)
);

echo $returnVal;
?>