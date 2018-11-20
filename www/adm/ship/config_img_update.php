<?php
$sub_menu = "100600";
include_once("./_common.php");
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

auth_check($auth[$sub_menu], 'w');

/********************************************************************에러체크*********************************************************************/
$upload_max_filesize = ini_get('upload_max_filesize');
if (empty($_POST)) alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.");
/********************************************************************에러체크*********************************************************************/

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_pd = 20485760;
$thumb_w = 800; //썸네일 가로사이즈
$thumb_h = 600; //썸네일 세로사이즈

$thumb_w2 = 320; //썸네일 가로사이즈
$thumb_h2 = 240; //썸네일 세로사이즈

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/mainslider', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/mainslider', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/mainslider/thumb', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/mainslider/thumb', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/mainslider/thumb2', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/mainslider/thumb2', G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
    $upload[$i]['file']     = '';
    $upload[$i]['source']   = '';
    $upload[$i]['filesize'] = 0;
    $upload[$i]['image']    = array();
    $upload[$i]['image'][0] = '';
    $upload[$i]['image'][1] = '';
    $upload[$i]['image'][2] = '';

    // 삭제에 체크가 되어있다면 파일을 삭제합니다.
    if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
        $upload[$i]['del_check'] = true;

        $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'mainslider' and wr_id = '1' and bf_no = '{$i}' ");
        @unlink(G5_DATA_PATH.'/file/mainslider/'.$row['bf_file']);
    }
    else
        $upload[$i]['del_check'] = false;

    $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
	set_image_rotate($tmp_file);
    $filesize  = $_FILES['bf_file']['size'][$i];
    $filename  = $_FILES['bf_file']['name'][$i];
    $filename  = get_safe_filename($filename);

    // 서버에 설정된 값보다 큰파일을 업로드 한다면
    if ($filename) {
        if ($_FILES['bf_file']['error'][$i] == 1) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량이 서버에 설정('.$upload_max_filesize.')된 값보다 크므로 업로드 할 수 없습니다.\\n';
            continue;
        }
        else if ($_FILES['bf_file']['error'][$i] != 0) {
            $file_upload_msg .= '\"'.$filename.'\" 파일이 정상적으로 업로드 되지 않았습니다.\\n';
            continue;
        }
    }

    if (is_uploaded_file($tmp_file)) {
        // 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
        if (!$is_admin && $filesize > $board['bo_upload_size']) {
            $file_upload_msg .= '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이 게시판에 설정('.number_format($board['bo_upload_size']).' 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n';
            continue;
        }
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                continue;
        }
        $upload[$i]['image'] = $timg;

		// 존재하는 파일이 있다면 삭제합니다.
		$row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'mainslider' and wr_id = '1' and bf_no = '{$i}' ");
		@unlink(G5_DATA_PATH.'/file/mainslider/'.$row['bf_file']);

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

		$dest_file_path = G5_DATA_PATH.'/file/mainslider';
		$dest_file = G5_DATA_PATH.'/file/mainslider/'.$upload[$i]['file'];
		$dest_thumb_file_path = G5_DATA_PATH.'/file/mainslider/thumb';
		$dest_thumb_file = G5_DATA_PATH.'/file/mainslider/thumb/'.$upload[$i]['file'];
		$dest_thumb_file_path2 = G5_DATA_PATH.'/file/mainslider/thumb2';
		$dest_thumb_file2 = G5_DATA_PATH.'/file/mainslider/thumb2/'.$upload[$i]['file'];

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

		$imgWidth = $upload[$i]['image']['0'];
		$imgHeight = $upload[$i]['image']['1'];
		
		//업로드된 파일이 큰 이미지라면 잘라냄
		if($imgWidth > 1200)
		{
			imgrescale($upload[$i]['file'], $dest_file_path, $dest_file_path, 1200, "", $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
			$newtimg = @getimagesize($dest_file);
			$imgWidth = $newtimg['0'];
			$imgHeight = $newtimg['1'];
		}
		
		//썸네일 생성
		//center_crop
		center_crop($dest_file,$dest_thumb_file,$thumb_w,$thumb_h,$quality=80);
		center_crop($dest_file,$dest_thumb_file2,$thumb_w2,$thumb_h2,$quality=80);
		
		chmod($dest_file, G5_FILE_PERMISSION);
		chmod($dest_thumb_file, G5_FILE_PERMISSION);
		chmod($dest_thumb_file2, G5_FILE_PERMISSION);
    }
}

// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
for ($i=0; $i<count($upload); $i++)
{
    if (!get_magic_quotes_gpc()) {
        $upload[$i]['source'] = addslashes($upload[$i]['source']);
    }

	$bf_content = '';
	if (isset($_POST['bf_content'][$i])) {
		$bf_content = substr(trim($_POST['bf_content'][$i]),0,255);
		$bf_content = preg_replace("#[\\\]+$#", "", $bf_content);
	}

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = 'mainslider' and wr_id = '1' and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = 'mainslider'
                                and wr_id = '1'
                                and bf_no = '{$i}' ";
            sql_query($sql);
        }
        else
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content}'
                        where bo_table = 'mainslider'
                                  and wr_id = '1'
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = 'mainslider',
                         wr_id = '1',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content}',
                         bf_download = 0,
                         bf_filesize = '{$upload[$i]['filesize']}',
                         bf_width = '{$upload[$i]['image']['0']}',
                         bf_height = '{$upload[$i]['image']['1']}',
                         bf_type = '{$upload[$i]['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
        sql_query($sql);
    }
}

// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = 'mainslider' and wr_id = '1' ");
for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
{
    $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'mainslider' and wr_id = '1' and bf_no = '{$i}' ");

    // 정보가 있다면 빠집니다.
    if ($row2['bf_file']) break;

    // 그렇지 않다면 정보를 삭제합니다.
    sql_query(" delete from {$g5['board_file_table']} where bo_table = 'mainslider' and wr_id = '1' and bf_no = '{$i}' ");
}

goto_url(G5_ADMINSHIP_URL."/config_img.php");
?>