<?php
$sub_menu = "100500";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

check_demo();
auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') alert('최고관리자만 접근 가능합니다.');
check_admin_token();

$sql_tpn = "";
if($_POST['tpn'] && ($_POST['tpn'] > 0 && $_POST['tpn'] < 4)) $sql_tpn = " , tpn = '{$_POST[tpn]}' ";

$sdom = trim($_POST['sdom']);

$sql = " update m_config
            set sdom = '{$_POST['sdom']}',
                semail = '{$_POST['semail']}',
                smap = '{$_POST['smap']}',
                tide = '{$_POST['tide']}',
                sea = '{$_POST['sea']}',
                com_name = '{$_POST['com_name']}',
                com_cont = '{$_POST['com_cont']}',
                com_saupja = '{$_POST['com_saupja']}',
                com_tongsin = '{$_POST['com_tongsin']}',
                com_tel = '{$_POST['com_tel']}',
                com_hp = '{$_POST['com_hp']}',
                com_addr = '{$_POST['com_addr']}',
                com_fax = '{$_POST['com_fax']}',
                com_email = '{$_POST['com_email']}',
                com_account = '{$_POST['com_account']}',
                com_account_owner = '{$_POST['com_account_owner']}',
                com_bank = '{$_POST['com_bank']}',
                book_fee = '{$_POST['book_fee']}',
                in_time = '{$_POST['in_time']}',
                out_time = '{$_POST['out_time']}',
                book_group = '{$_POST['book_group']}',
                book_group_fee = '{$_POST['book_group_fee']}',
                book_solo = '{$_POST['book_solo']}',
                book_solo_fee = '{$_POST['book_solo_fee']}',
                book_process = '{$_POST['book_process']}',
                refund_process = '{$_POST['refund_process']}',
                usebooking = '{$_POST['usebooking']}',
                bkmode = '{$_POST['bkmode']}',
                main_bkmode = '{$_POST['main_bkmode']}',
                etc_notice = '{$_POST['etc_notice']}'
				$sql_tpn ";
sql_query($sql);

$com_uidx = md5($_SERVER['DOCUMENT_ROOT']);
sql_query(" update m_config set com_uidx = '{$com_uidx}' ");

$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_pd = 20485760;
$thumb_w = 800; //썸네일 가로사이즈
$thumb_h = 600; //썸네일 세로사이즈

$thumb_w2 = 320; //썸네일 가로사이즈
$thumb_h2 = 240; //썸네일 세로사이즈

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/m_map', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/m_map', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/m_map/thumb', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/m_map/thumb', G5_DIR_PERMISSION);
@mkdir(G5_DATA_PATH.'/file/m_map/thumb2', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/m_map/thumb2', G5_DIR_PERMISSION);

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

        $row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'm_map'  and bf_no = '{$i}' ");
        @unlink(G5_DATA_PATH.'/file/m_map/'.$row['bf_file']);
        @unlink(G5_DATA_PATH.'/file/m_map/thumb/'.$row['bf_file']);
        @unlink(G5_DATA_PATH.'/file/m_map/thumb2/'.$row['bf_file']);
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
		$row = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'm_map'  and bf_no = '{$i}' ");
		@unlink(G5_DATA_PATH.'/file/m_map/'.$row['bf_file']);
        @unlink(G5_DATA_PATH.'/file/m_map/thumb/'.$row['bf_file']);
        @unlink(G5_DATA_PATH.'/file/m_map/thumb2/'.$row['bf_file']);

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

		$dest_file_path = G5_DATA_PATH.'/file/m_map';
		$dest_file = G5_DATA_PATH.'/file/m_map/'.$upload[$i]['file'];
		$dest_thumb_file_path = G5_DATA_PATH.'/file/m_map/thumb';
		$dest_thumb_file = G5_DATA_PATH.'/file/m_map/thumb/'.$upload[$i]['file'];
		$dest_thumb_file_path2 = G5_DATA_PATH.'/file/m_map/thumb2';
		$dest_thumb_file2 = G5_DATA_PATH.'/file/m_map/thumb2/'.$upload[$i]['file'];

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

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = 'm_map'  and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = 'm_map'
                                
                                and bf_no = '{$i}' ";
            sql_query($sql);
        }
        else
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content[$i]}'
                        where bo_table = 'm_map'
                                  
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = 'm_map',
                         wr_id = '{$s_idx}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
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
$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = 'm_map'  ");
for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
{
    $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = 'm_map'  and bf_no = '{$i}' ");

    // 정보가 있다면 빠집니다.
    if ($row2['bf_file']) break;

    // 그렇지 않다면 정보를 삭제합니다.
    sql_query(" delete from {$g5['board_file_table']} where bo_table = 'm_map'  and bf_no = '{$i}' ");
}

//===== API 실행 ======
/*
$arr = array();
$arr[com_uidx] = $com_uidx;
$arr[data]	     = $_POST;

$curlData = http_build_query($arr);
$curlUrl = "https://monak.kr/api/_com_save.php";
//$curlUrl = "https://www.monak.co.kr/api/_com_save.php";
curl_api($curlUrl, $curlData);
*/
//===== API 종료 ======

goto_url('./config_form.php', false);
?>